<?php

namespace App\Contracts;

interface TaskContract
{
    // Basic Task Information
    public function getId(): int;
    public function getGoalId(): int;
    public function getTitle(): string;

    // Assignment
    public function getAssignedTo(): ?int; // Agent ID
    public function assignToAgent(AgentContract $agent): void;

    // Progress and Status
    public function getProgress(): int;
    public function updateProgress(int $progress): void;
    public function getStatus(): string; // 'not_started', 'in_progress', 'completed'
    public function setStatus(string $status): void;

    // Priority
    public function getPriority(): string; // 'critical', 'high', 'medium', 'low'
    public function setPriority(string $priority): void;

    // Messaging
    public function getMessages(): array; // Returns an array of IMessage
    public function addMessage(MessageContract $message): void;
}
