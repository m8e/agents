<?php

namespace App\Services;

use App\Models\Tool;
use Illuminate\Support\Facades\Log;
use OpenAI\Exceptions\ErrorException;
use OpenAI\Laravel\Facades\OpenAI;

class ToolAgentService
{
    private $model;
    private $tools;
    private $toolsDict;

    public const TOOL_SYSTEM_PROMPT = <<<EOD
You are a function-calling AI model. You are provided with function signatures within <tools></tools> XML tags.
You may call one or more functions to assist with the user query. Don't make assumptions about what values to plug
into functions. Pay special attention to the properties 'types'. You should use those types as in a PHP array.
For each function call, return a JSON object with function name and arguments within <tool_call></tool_call>
XML tags as follows:

<tool_call>
{"name": <function-name>, "arguments": <args-array>}
</tool_call>

Here are the available tools:

<tools>
%s
</tools>
EOD;

    public function __construct($agentId, $model = 'gpt-4o-mini')
    {
        $this->model = $model;

        // Retrieve tools associated with the agent from the database
        $this->tools = Tool::where('agent_id', $agentId)->get();

        // Build a dictionary for quick access
        $this->toolsDict = [];
        foreach ($this->tools as $tool) {
            $this->toolsDict[$tool->name] = $tool;
        }
    }

    private function addToolSignatures()
    {
        $toolsInfo = '';
        foreach ($this->tools as $tool) {
            $toolsInfo .= json_encode($tool->function_signature) . "\n";
        }

        return $toolsInfo;
    }

    private function parseToolCallStr($toolCallStr)
    {
        $cleanTags = preg_replace('/<\/?tool_call>/', '', $toolCallStr);

        $toolCallJson = json_decode($cleanTags, true);
        if (json_last_error() === JSON_ERROR_NONE) {
            return $toolCallJson;
        } else {
            return null;
        }
    }

    public function run($userMsg)
    {
        $toolSystemPrompt = sprintf(self::TOOL_SYSTEM_PROMPT, $this->addToolSignatures());

        $messages = [
            ['role' => 'system', 'content' => $toolSystemPrompt],
            ['role' => 'user', 'content' => $userMsg],
        ];

        $maxRetries = 5;
        $retryCount = 0;
        $waitTime = 1; // Initial wait time in seconds

        do {
            try {
                $response = OpenAI::chat()->create([
                    'model' => $this->model,
                    'messages' => $messages,
                    'temperature' => 0.7,
                ]);

                if (isset($response->choices[0]->message->content)) {
                    $toolCallStr = $response->choices[0]->message->content;
                    $toolCall = $this->parseToolCallStr($toolCallStr);

                    if (is_array($toolCall)) {
                        $toolName = $toolCall['name'];
                        if (isset($this->toolsDict[$toolName])) {
                            $tool = $this->toolsDict[$toolName];

                            try {
                                // Validate arguments
                                $arguments = $tool->validateArguments($toolCall['arguments']);

                                // Execute the tool
                                $result = $tool->run($arguments);

                                // Prepare messages for the final AI response
                                $messages[] = ['role' => 'assistant', 'content' => $toolCallStr];
                                $messages[] = ['role' => 'user', 'content' => "Observation: $result"];

                                // Optionally, you can reset retry count here if you want to retry the final response as well
                                $finalResponse = $this->getFinalResponse($messages);

                                return $finalResponse;
                            } catch (\Exception $e) {
                                Log::error('Tool execution error: ' . $e->getMessage());

                                return 'Error: ' . $e->getMessage();
                            }
                        } else {
                            return "Error: Tool $toolName not found.";
                        }
                    } else {
                        return 'Error: Invalid tool call.';
                    }
                } else {
                    return 'Error: Could not get response from AI.';
                }
            } catch (ErrorException $e) {
                $statusCode = $e->getCode();

                if ($statusCode === 429) {
                    // Rate limit exceeded
                    $retryAfter = $e->getResponse()?->getHeaderLine('Retry-After') ?? $waitTime;
                    Log::warning("Rate limit exceeded. Retrying after {$retryAfter} seconds.");

                    sleep((int)$retryAfter);
                    $waitTime *= 2; // Exponential backoff
                } else {
                    Log::error('OpenAI API error: ' . $e->getMessage());

                    return 'Error: ' . $e->getMessage();
                }
            } catch (\Exception $e) {
                Log::error('Unexpected error: ' . $e->getMessage());

                return 'Error: An unexpected error occurred.';
            }

            $retryCount++;
        } while ($retryCount < $maxRetries);

        return 'Error: Unable to process your request at this time. Please try again later.';
    }

    private function getFinalResponse(array $messages)
    {
        $maxRetries = 5;
        $retryCount = 0;
        $waitTime = 1;

        do {
            try {
                $finalResponse = OpenAI::chat()->create([
                    'model' => $this->model,
                    'messages' => $messages,
                    'temperature' => 0.7,
                ]);

                if (isset($finalResponse->choices[0]->message->content)) {
                    return $finalResponse->choices[0]->message->content;
                } else {
                    return 'Error: Could not get final response.';
                }
            } catch (ErrorException $e) {
                $statusCode = $e->getCode();

                if ($statusCode === 429) {
                    $retryAfter = $e->getResponse()?->getHeaderLine('Retry-After') ?? $waitTime;
                    Log::warning("Rate limit exceeded on final response. Retrying after {$retryAfter} seconds.");

                    sleep((int)$retryAfter);
                    $waitTime *= 2;
                } else {
                    Log::error('OpenAI API error on final response: ' . $e->getMessage());

                    return 'Error: ' . $e->getMessage();
                }
            } catch (\Exception $e) {
                Log::error('Unexpected error on final response: ' . $e->getMessage());

                return 'Error: An unexpected error occurred.';
            }

            $retryCount++;
        } while ($retryCount < $maxRetries);

        return 'Error: Unable to process your request at this time. Please try again later.';
    }
}
