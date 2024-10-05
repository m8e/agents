<?php

// app/Agents/BaseAgent.php

namespace App\Agents\Agents;

use App\Contracts\AgentContract;
use App\Contracts\PromptContract;
use Cognesy\Instructor\Extras\Structure\Structure;
use OpenAI\Client as OpenAIClient;
use Psr\Log\LoggerInterface;

use function App\Agents\gettype;

abstract class BaseAgent implements AgentContract
{
    protected bool $keepMessageHistory;
    protected OpenAIClient $client;

    // this should be array of MessageContract
    protected array $messages = [];
    protected LoggerInterface $logger;

    public function __construct(
        protected AgentContract $agent,
        protected PromptContract $systemPrompt,
        protected Structure $inputFormat,
        protected Structure $outputFormat,
        array $tools = [],
        array $executableFunctionsList = [],
        bool $keepMessageHistory = true,
    ) {
    }

    protected function initializeMessages(): void
    {
        $this->messages = [['role' => 'system', 'content' => $this->systemPrompt]];
    }

    protected function initializeTools(array $tools): void
    {
        foreach ($tools as [$func, $funcDesc]) {
            $this->toolsList[] = $this->getFunctionSchema($func, $funcDesc);
            $this->executableFunctionsList[$func->getName()] = $func;
        }
    }

    protected function getFunctionSchema(callable $func, string $description): array
    {
        $reflection = new \ReflectionFunction($func);
        $parameters = $reflection->getParameters();
        $paramsSchema = [];

        foreach ($parameters as $param) {
            $paramType = $param->getType();
            $paramsSchema[$param->getName()] = [
                'type' => $paramType ? $paramType->getName() : 'mixed',
                'description' => '', // Add parameter descriptions if available
            ];
        }

        return [
            'name' => $reflection->getName(),
            'description' => $description,
            'parameters' => $paramsSchema,
        ];
    }

    public function run(
        mixed $inputData,
        ?string $screenshot = null,
        ?string $sessionId = null,
        string $model = 'gpt-4'
    ) {
        // Validate input data type
        if (!is_a($inputData, $this->inputFormat)) {
            throw new \InvalidArgumentException(
                'Input data must be of type ' . $this->inputFormat
            );
        }

        // Handle message history
        if (!$this->keepMessageHistory) {
            $this->initializeMessages();
        }

        // Append user message
        $this->appendUserMessage($inputData, $screenshot);

        // Main loop
        while (true) {
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

                // Validate output format
                if (!is_a($responseMessage['content'], $this->outputFormat)) {
                    throw new \TypeError(
                        'Expected response_message content to be of type ' . $this->outputFormat .
                        ', but got ' . gettype($responseMessage['content'])
                    );
                }

                return $responseMessage['content'];
            } catch (\Exception $e) {
                $this->logger->error('Error in run method: ' . $e->getMessage());
                throw $e;
            }
        }
    }

    protected function appendUserMessage($inputData, ?string $screenshot): void
    {
        $content = json_encode($inputData, JSON_UNESCAPED_SLASHES);

        if ($screenshot) {
            $this->messages[] = [
                'role' => 'user',
                'content' => [
                    ['type' => 'text', 'text' => $content],
                    ['type' => 'image_url', 'image_url' => ['url' => $screenshot]],
                ],
            ];
        } else {
            $this->messages[] = [
                'role' => 'user',
                'content' => $content,
            ];
        }

        // Handle current_page_dom and current_page_url if present
        if (property_exists($inputData, 'current_page_dom') && property_exists($inputData, 'current_page_url')) {
            $this->messages[] = [
                'role' => 'user',
                'content' => 'Current page URL:' . PHP_EOL . $inputData->current_page_url .
                    PHP_EOL . 'Current page DOM:' . PHP_EOL . $inputData->current_page_dom,
            ];
        }
    }

    protected function getClientResponse(string $model)
    {
        $options = [
            'model' => $model,
            'messages' => $this->messages,
        ];

        if (!empty($this->toolsList)) {
            $options['functions'] = $this->toolsList;
            $options['function_call'] = 'auto';
        }

        return $this->client->chat()->create($options);
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

        $functionToCall = $this->executableFunctionsList[$functionName];

        try {
            $functionResponse = call_user_func_array($functionToCall, $functionArgs);
            $this->messages[] = [
                'role' => 'function',
                'name' => $functionName,
                'content' => json_encode($functionResponse),
            ];
        } catch (\Exception $e) {
            $this->logger->error("Error calling tool $functionName: " . $e->getMessage());
            $this->messages[] = [
                'role' => 'function',
                'name' => $functionName,
                'content' => json_encode([
                    'error' => 'The tool responded with an error. Please try again with a different tool or modify the parameters.',
                ]),
            ];
        }
    }

    abstract protected function processMessage(string $message): string;
}
