<?php

namespace App\Contracts;

interface MessageContract
{
    // Basic Message Information
    public function getId(): int;
    public function getAgentId(): int;
    public function getGoalId(): ?int;
    public function getTaskId(): ?int;
    public function getSender(): AgentContract; // 'user', 'llm'
    public function getContent(): string;

    // Metadata
    public function getMetadata(): ?array;
    public function setMetadata(array $metadata): void;

    // Associations
    public function setAgent(AgentContract $agent): void;
    public function setGoal(GoalContract $goal): void;
    public function setTask(TaskContract $task): void;

    // Actions
    public function send(): void;
}
