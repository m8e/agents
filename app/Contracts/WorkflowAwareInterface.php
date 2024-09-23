<?php

namespace App\Contracts;

interface WorkflowAwareInterface
{
    public function getCurrentState(): string;
    public function canTransitionTo(string $state): bool;
    public function applyTransition(string $transition): void;
}
