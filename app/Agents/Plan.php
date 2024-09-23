<?php

namespace App\Agents;

use Cognesy\Instructor\Extras\Structure\Field;
use Cognesy\Instructor\Extras\Structure\Structure;
use Cognesy\Instructor\Validation\Traits\ValidationMixin;
use Cognesy\Instructor\Validation\ValidationResult;

class Plan
{
    use ValidationMixin;

    public string $goal;
    public array $tasks; // Array of Task definitions

    public static function defineStructure()
    {
        return Structure::define('Plan', [
            Field::string('goal', 'The main goal to achieve'),
            Field::sequence('tasks', [
                Field::string('description', 'Description of the subtask'),
                Field::string('agent', 'Agent responsible for the subtask')->optional(),
                Field::string('tool', 'Tool required for the subtask')->optional(),
            ], 'List of tasks to achieve the goal'),
        ], 'A plan to achieve a goal');
    }

    public function validate(): ValidationResult
    {
        // Add custom validation logic if necessary
        if (empty($this->tasks)) {
            return ValidationResult::invalid([], 'The plan must contain at least one task.');
        }

        return ValidationResult::valid();
    }
}
