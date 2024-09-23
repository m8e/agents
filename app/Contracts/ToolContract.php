<?php

namespace App\Contracts;

interface ToolContract
{
    // Basic Tool Information
    public function getId(): int;

    public function getName(): string;

    public function getDescription(): ?string;

    public function getType(): string; // e.g., 'api', 'script', 'service'

    // Configuration
    public function getConfig(): ?array;

    public function setConfig(array $config): void;

    // Capabilities
    public function getCapabilities(): array; // List of actions or functions the tool can perform

    // Execution
    public function execute(string $action, array $parameters = []): mixed;

    // Status and Availability
    public function isAvailable(): bool;

    public function getLastUsedAt(): ?\DateTimeInterface;

    public function updateLastUsedAt(): void;

    // Associations
    public function setAgent(AgentContract $agent): void;

    public function getAgent(): ?AgentContract;

    // Lifecycle Management
    public function activate(): void;

    public function deactivate(): void;
}
