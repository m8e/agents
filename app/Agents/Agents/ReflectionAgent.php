<?php

namespace App\Agents\Agents;

use Illuminate\Support\Facades\Log;
use OpenAI\Laravel\Facades\OpenAI;

class ReflectionAgent
{
    protected $model;

    public function __construct($model = 'gpt-4o')
    {
        $this->model = $model;
    }

    public function generate(array $generationHistory, int $verbose = 0): string
    {
        try {
            $response = OpenAI::chat()->create([
                'model' => $this->model,
                'messages' => $generationHistory,
            ]);

            $output = $response->choices[0]->message->content;

            if ($verbose > 0) {
                echo "\n\nGENERATION\n\n" . $output;
            }

            return $output;
        } catch (\Exception $e) {
            Log::error('Error during generation: ' . $e->getMessage());

            return 'Error during generation.';
        }
    }

    public function reflect(array $reflectionHistory, int $verbose = 0): string
    {
        try {
            $response = OpenAI::chat()->create([
                'model' => $this->model,
                'messages' => $reflectionHistory,
            ]);

            $output = $response->choices[0]->message->content;

            if ($verbose > 0) {
                echo "\n\nREFLECTION\n\n" . $output;
            }

            return $output;
        } catch (\Exception $e) {
            Log::error('Error during reflection: ' . $e->getMessage());

            return 'Error during reflection.';
        }
    }

    public function run(
        string $generationSystemPrompt,
        string $reflectionSystemPrompt,
        string $userPrompt,
        int $nSteps = 3,
        int $verbose = 0
    ): string {
        $generationHistory = [
            $this->buildPromptStructure($generationSystemPrompt, 'system'),
            $this->buildPromptStructure($userPrompt, 'user'),
        ];

        $reflectionHistory = [
            $this->buildPromptStructure($reflectionSystemPrompt, 'system'),
        ];

        for ($step = 0; $step < $nSteps; $step++) {
            $this->fancyStepTracker($step, $nSteps);

            // Generate response
            $generation = $this->generate($generationHistory, $verbose);

            // Update histories
            $generationHistory[] = $this->buildPromptStructure($generation, 'assistant');
            $reflectionHistory[] = $this->buildPromptStructure($generation, 'user');

            // Reflect on the generation
            $critique = $this->reflect($reflectionHistory, $verbose);

            // Update histories
            $reflectionHistory[] = $this->buildPromptStructure($critique, 'assistant');
            $generationHistory[] = $this->buildPromptStructure($critique, 'user');
        }

        return $generation;
    }

    private function buildPromptStructure(string $prompt, string $role): array
    {
        return [
            'role' => $role,
            'content' => $prompt,
        ];
    }

    private function fancyStepTracker(int $step, int $totalSteps): void
    {
        echo "\n==============================================\n";
        echo 'STEP ' . ($step + 1) . '/' . $totalSteps . "\n";
        echo "==============================================\n";
        usleep(500000); // Sleep for 0.5 seconds
    }
}
