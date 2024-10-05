<?php

namespace App\Models;

use App\Agents\Tools\AddNumbersTool;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Tool extends Model
{
    protected $fillable = [
        'agent_id',
        'name',
        'description',
        'function_signature',
    ];

    protected $casts = [
        'function_signature' => 'array',
    ];

    /**
     * Get the agent that owns the tool.
     */
    public function agent(): BelongsTo
    {
        return $this->belongsTo(Agent::class);
    }

    /**
     * Execute the tool's function with the given arguments.
     *
     * @param array $args
     * @return mixed
     * @throws \Exception
     */
    public function run(array $args)
    {
        // Validate arguments against function signature
        $validatedArgs = $this->validateArguments($args);

        // Securely execute the function
        return $this->executeFunction($validatedArgs);
    }

    /**
     * Validate the provided arguments against the function signature.
     *
     * @param array $args
     * @return array
     * @throws \Exception
     */
    protected function validateArguments(array $args): array
    {
        $properties = $this->function_signature['parameters']['properties'] ?? [];

        $validatedArgs = [];

        foreach ($properties as $paramName => $paramInfo) {
            $expectedType = $paramInfo['type'] ?? 'string';

            if (! array_key_exists($paramName, $args)) {
                throw new \Exception("Missing argument: $paramName");
            }

            $value = $args[$paramName];

            // Type casting and validation
            settype($value, $expectedType);

            $validatedArgs[$paramName] = $value;
        }

        return $validatedArgs;
    }

    /**
     * Securely execute the function associated with this tool.
     *
     * @param array $args
     * @return mixed
     * @throws \Exception
     */
    protected function executeFunction(array $args)
    {
        // For security, we'll use a predefined list of allowed functions
        $allowedFunctions = $this->getAllowedFunctions();

        if (! array_key_exists($this->name, $allowedFunctions)) {
            throw new \Exception("Function '{$this->name}' is not allowed.");
        }

        $function = $allowedFunctions[$this->name];

        return call_user_func_array($function, $args);
    }

    /**
     * Get the list of allowed functions that can be executed.
     *
     * @return array
     */
    protected function getAllowedFunctions(): array
    {
        // Map of function names to their callable implementations
        return [
            'addNumbers' => [AddNumbersTool::class, 'run'],
            // Add other allowed functions here
        ];
    }
}
