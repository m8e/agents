<?php

// app/Agents/BaseAgent.php

namespace App\Agents;

use Cognesy\Instructor\Instructor;

abstract class BaseAgent
{
    protected Instructor $instructor;
    protected array $conversationHistory = [];

    public function __construct()
    {
        $this->instructor = new Instructor();
    }

    public function receiveMessage(string $message): string
    {
        // Update conversation history
        $this->conversationHistory[] = ['role' => 'user', 'content' => $message];

        // Process the message
        $response = $this->processMessage($message);

        // Update conversation history with the agent's response
        $this->conversationHistory[] = ['role' => 'assistant', 'content' => $response];

        return $response;
    }

    abstract protected function processMessage(string $message): string;
}
