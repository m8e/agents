<?php

namespace App\Contracts;

use App\Contracts\MessageContract;

interface AgentContract
{
    /**
     * Runs the agent with the provided input data.
     *
     * @param mixed $inputData The input data for the agent to process.
     * @param string|null $screenshot Optional screenshot URL or data.
     * @param string|null $sessionId Optional session ID.
     * @param string $model The model to use for processing.
     * @return mixed The agent's response.
     */
    public function run(
        mixed $inputData,
        ?string $screenshot = null,
        ?string $sessionId = null,
        string $model = 'gpt-4'
    );

    /**
     * Receives a message and processes it.
     *
     * @param MessageContract $message The message to process.
     * @return void
     */
    public function receiveMessage(MessageContract $message): void;
}
