<?php

// app/Agents/BaseAgent.php

namespace App\Agents\Messages;

use App\Contracts\AgentContract;
use App\Contracts\MessageContract;
use Cognesy\Instructor\Instructor;
use Illuminate\Support\Carbon;

abstract class BaseMessage implements MessageContract
{
    protected string $content;
    protected AgentContract $sender;
    protected AgentContract $recipient;
    protected Carbon $timestamp;

    public function __construct(string $content, AgentContract $sender, AgentContract $recipient)
    {
        $this->content = $content;
        $this->sender = $sender;
        $this->recipient = $recipient;
        $this->timestamp = now();
    }

    public function getContent(): string
    {
        return $this->content;
    }

    public function getSender(): AgentContract
    {
        return $this->sender;
    }

    public function getRecipient(): AgentContract
    {
        return $this->recipient;
    }

    public function getTimestamp(): string
    {
        return $this->timestamp;
    }

    public function send(): void
    {
        $instructor = new Instructor();
        $instructor->send($this->recipient, $this->content);
    }
}
