<?php

namespace App\Agents\Agents;

use App\Models\Tool;
use OpenAI\Exceptions\ErrorException;
use Psr\Log\LoggerInterface;

class ToolAgent extends BaseAgent
{
    private string $model;
    private array $tools;
    private array $toolsDict;
    private int $agentId;

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

    public function __construct(
        int $agentId,
        LoggerInterface $logger,
        string $model = 'gpt-4',
    ) {
        $this->agentId = $agentId;
        $this->model = $model;
        $this->logger = $logger;

        // Retrieve tools associated with the agent from the database
        $this->tools = Tool::where('agent_id', $agentId)->get()->all();

        // Build a dictionary for quick access
        $this->toolsDict = [];
        foreach ($this->tools as $tool) {
            $this->toolsDict[$tool->name] = $tool;
        }

        // Prepare tools information for system prompt
        $toolsInfo = $this->addToolSignatures();

        // Prepare system prompt
        $systemPrompt = sprintf(self::TOOL_SYSTEM_PROMPT, $toolsInfo);

        // Prepare tools for BaseAgent
        $toolsArray = [];
        foreach ($this->tools as $tool) {
            $functionName = $tool->name;
            $functionDescription = $tool->description ?? '';
            $functionParameters = $tool->function_signature; // Assuming this is an associative array

            // Construct function schema as expected by OpenAI API
            $functionSchema = [
                'name' => $functionName,
                'description' => $functionDescription,
                'parameters' => [
                    'type' => 'object',
                    'properties' => $functionParameters,
                ],
            ];

            $toolsArray[] = [$functionSchema, $functionDescription];
            $this->executableFunctionsList[$functionName] = $tool; // Store the Tool model instance
        }
    }

    private function addToolSignatures(): string
    {
        $toolsInfo = '';
        foreach ($this->tools as $tool) {
            $toolsInfo .= json_encode($tool->function_signature, JSON_UNESCAPED_SLASHES) . "\n";
        }

        return $toolsInfo;
    }

    public function run(
        mixed $inputData,
        ?string $screenshot = null,
        ?string $sessionId = null,
        string $model = null
    ) {
        $model = $model ?? $this->model;

        // Validate input data type if inputFormat is specified
        if ($this->inputFormat && !is_a($inputData, $this->inputFormat)) {
            throw new \InvalidArgumentException(
                'Input data must be of type ' . $this->inputFormat
            );
        }

        // Extract user message from $inputData
        $userMsg = $this->extractUserMessage($inputData);

        // Handle message history
        if (!$this->keepMessageHistory) {
            $this->initializeMessages();
        }

        // Append user message
        $this->messages[] = [
            'role' => 'user',
            'content' => $userMsg,
        ];

        // Main loop
        $maxRetries = 5;
        $retryCount = 0;

        while ($retryCount < $maxRetries) {
            try {
                $response = $this->getClientResponse($model);

                // Process the response
                $responseMessage = $response['choices'][0]['message'] ?? null;

                if (!$responseMessage) {
                    throw new \Exception('No response message received from the client.');
                }

                // Handle function calls (tools)
                if (isset($responseMessage['function_call'])) {
                    $functionCall = $responseMessage['function_call'];
                    $this->appendToolResponse($functionCall);
                    continue;
                }

                // Return the assistant's final reply
                return $responseMessage['content'];
            } catch (ErrorException $e) {
                $statusCode = $e->getCode();

                if ($statusCode === 429) {
                    $retryAfter = $e->getResponse()?->getHeaderLine('Retry-After') ?? 1;
                    $this->logger->warning("Rate limit exceeded. Retrying after {$retryAfter} seconds.");

                    sleep((int)$retryAfter);
                } else {
                    $this->logger->error('OpenAI API error: ' . $e->getMessage());

                    return 'Error: ' . $e->getMessage();
                }
            } catch (\Exception $e) {
                $this->logger->error('Unexpected error: ' . $e->getMessage());

                return 'Error: An unexpected error occurred.';
            }

            $retryCount++;
        }

        return 'Error: Unable to process your request at this time. Please try again later.';
    }

    protected function appendToolResponse(array $functionCall): void
    {
        $functionName = $functionCall['name'];
        $functionArgs = json_decode($functionCall['arguments'], true);

        if (!isset($this->executableFunctionsList[$functionName])) {
            $this->logger->error("Tool function not found: $functionName");
            $this->messages[] = [
                'role' => 'assistant',
                'content' => "Error: Tool function not found: $functionName",
            ];
            return;
        }

        /** @var Tool $tool */
        $tool = $this->executableFunctionsList[$functionName];

        try {
            // Validate arguments
            $arguments = $tool->validateArguments($functionArgs);

            // Execute the tool
            $result = $tool->run($arguments);

            // Append the function response to messages
            $this->messages[] = [
                'role' => 'function',
                'name' => $functionName,
                'content' => json_encode($result, JSON_UNESCAPED_SLASHES),
            ];
        } catch (\Exception $e) {
            $this->logger->error("Error calling tool $functionName: " . $e->getMessage());
            $this->messages[] = [
                'role' => 'function',
                'name' => $functionName,
                'content' => json_encode([
                    'error' => 'The tool responded with an error. Please try again with a different tool or modify the parameters.',
                ], JSON_UNESCAPED_SLASHES),
            ];
        }
    }

    protected function processMessage(string $message): string
    {
        // Implement message processing logic if needed
        return $message;
    }

    /**
     * Extracts the user message from the input data.
     * Adjust this method based on how $inputData is structured.
     *
     * @param mixed $inputData
     * @return string
     */
    private function extractUserMessage($inputData): string
    {
        // If inputData is a string, return it directly
        if (is_string($inputData)) {
            return $inputData;
        }

        // If inputData is an object or array, extract the message
        // Adjust this logic based on your application's requirements
        if (is_array($inputData) && isset($inputData['message'])) {
            return $inputData['message'];
        } elseif (is_object($inputData) && property_exists($inputData, 'message')) {
            return $inputData->message;
        }

        // Default case: convert inputData to JSON string
        return json_encode($inputData, JSON_UNESCAPED_SLASHES);
    }
}
