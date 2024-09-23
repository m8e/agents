<?php

namespace App\Contracts;

interface AgentContract
{
    // Basic Agent Information
    public function getId(): int;
    public function getTeamId(): int;
    public function getName(): string;
    public function getDescription(): ?string;
    public function getType(): string; // 'ai', 'human', 'bot'
    public function getStatus(): string; // 'active', 'inactive', 'suspended'

    // Configuration and Capabilities
    public function getConfig(): ?array;
    public function setConfig(array $config): void;
    public function getCapabilities(): ?array;
    public function setCapabilities(array $capabilities): void;

    // Activity Tracking
    public function getLastActiveAt(): ?\DateTimeInterface;
    public function updateLastActiveAt(): void;

    // State Management
    public function activate(): void;
    public function deactivate(): void;
    public function suspend(): void;

    // Interactions
    public function sendMessage(MessageContract $message): void;
    public function receiveMessage(MessageContract $message): void;

    // Associations
    public function assignGoal(GoalContract $goal): void;
    public function getAssignedGoals(): array; // Returns an array of IGoal
    public function assignTask(TaskContract $task): void;
    public function getAssignedTasks(): array; // Returns an array of ITask
}
