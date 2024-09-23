<?php

namespace App\Contracts;

interface GoalContract
{
    // Basic Goal Information
    public function getId(): int;
    public function getTeamId(): int;
    public function getUserId(): int;
    public function getAgentId(): ?int;
    public function getTitle(): string;
    public function getDescription(): ?string;

    // Timing and Progress
    public function getStartDate(): \DateTimeInterface;
    public function getDeadlineDate(): ?\DateTimeInterface;
    public function getProgress(): int;
    public function updateProgress(int $progress): void;

    // Status and Priority
    public function getStatus(): string; // 'not_started', 'in_progress', 'completed'
    public function setStatus(string $status): void;
    public function getPriority(): string; // 'critical', 'high', 'normal', 'low', 'backlog'
    public function setPriority(string $priority): void;
    public function getRiskLevel(): string; // 'low', 'medium', 'high'
    public function setRiskLevel(string $riskLevel): void;

    // Metrics and Outcome
    public function getEstimatedTokens(): ?int;
    public function setEstimatedTokens(int $tokens): void;
    public function getActualTokens(): ?int;
    public function setActualTokens(int $tokens): void;
    public function getOutcome(): ?string;
    public function setOutcome(string $outcome): void;

    // Tags and Criteria
    public function getTags(): ?array;
    public function setTags(array $tags): void;
    public function getCompletionCriteria(): ?string;
    public function setCompletionCriteria(string $criteria): void;

    // Associations
    public function getTasks(): array; // Returns an array of ITask
    public function addTask(TaskContract $task): void;
    public function removeTask(TaskContract $task): void;
}
