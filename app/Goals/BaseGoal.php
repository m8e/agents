<?php

namespace App\Goals;

use Symfony\Component\Workflow\Registry;
use App\Services\AgentService;

abstract class AbstractGoal
{
    protected $fillable = ['description', 'status', 'is_workflow', 'workflow_id', 'is_one_shot'];
    protected $agentService;
    protected $workflowRegistry;

    public function __construct(
        AgentService $agentService,
        Registry $workflowRegistry,
        array $attributes = [],
    ) {
        parent::__construct($attributes);
        $this->agentService = $agentService;
        $this->workflowRegistry = $workflowRegistry;
    }

    /**
     * Determines if the goal follows a workflow or not.
     */
    public function isWorkflowBased(): bool
    {
        return $this->is_workflow;
    }

    /**
     * Determines if the goal is a one-shot goal.
     */
    public function isOneShot(): bool
    {
        return $this->is_one_shot;
    }

    /**
     * Handles the execution of the goal, delegating to either the workflow execution or the agent-driven execution.
     */
    public function execute()
    {
        if ($this->isWorkflowBased()) {
            return $this->executeWorkflowGoal();
        } else {
            return $this->executeAgentDrivenGoal();
        }
    }

    /**
     * Abstract function to be implemented by subclasses for workflow-based goal execution.
     * Should apply specific transitions in the Symfony workflow.
     */
    abstract protected function executeWorkflowGoal();

    /**
     * Abstract function to be implemented by subclasses for agent-driven goal execution.
     * This allows agents to dynamically decide how to handle the tasks.
     */
    abstract protected function executeAgentDrivenGoal();

    /**
     * This method can be overridden to add custom initialization logic.
     */
    public function initializeGoal()
    {
        // Custom initialization logic for specific goal types
    }
}
