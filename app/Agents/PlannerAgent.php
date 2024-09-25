<?php

// app/Agents/PlannerAgent.php

namespace App\Agents;

use Cognesy\Instructor\Enums\Mode;
use Cognesy\Instructor\Instructor;

class PlannerAgent extends BaseAgent
{
    public function generatePlan(string $goal): Plan
    {
        // Update conversation history if needed
        $this->conversationHistory[] = ['role' => 'user', 'content' => $goal];

        // Use Instructor-PHP to interact with the LLM
        $instructor = new Instructor();

        $planStructure = Plan::defineStructure();

        // Generate the plan using the LLM
        $plan = $instructor->respond(
            messages: $this->conversationHistory,
            responseModel: $planStructure,
            options: [
                'prompt' => "Given the user's goal, generate a plan with subtasks, agents, and tools required to accomplish it.",
            ],

            mode: Mode::Json
        );

        return $plan;
    }

    protected function processMessage(string $message): string
    {
        // TODO: Implement processMessage() method.
    }

    public function executePlan(Plan $plan)
    {
        foreach ($plan->tasks as $task) {
            $agentName = $task['agent'] ?? 'DefaultAgent';
            $agent = $this->getAgentByName($agentName);

            $toolName = $task['tool'] ?? null;

            if ($toolName) {
                $this->enableToolForAgent($agent, $toolName);
            }

            // Create a Task object and assign it to the agent
            $subTask = new Task($agent, $task['description']);
            $subTask->run();
        }
    }

    protected function getAgentByName(string $name): BaseAgent
    {
        // Logic to retrieve or instantiate the agent by name
        // For example, using a factory pattern or a service container
    }

    protected function enableToolForAgent(BaseAgent $agent, string $toolName)
    {
        // Logic to enable a tool for the agent
        // This might involve setting up the agent's capabilities
    }
}
