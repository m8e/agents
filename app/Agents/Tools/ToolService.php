<?php

namespace App\Agents\Tools;

use App\Models\Tool;
use ReflectionFunction;
use ReflectionNamedType;

class ToolService
{
    /**
     * Generate a function signature for a given callable.
     *
     * @param callable $fn
     * @return array
     * @throws \ReflectionException
     */
    public function getFunctionSignature(callable $fn): array
    {
        $reflection = new ReflectionFunction($fn);
        $fnSignature = [
            'name' => $reflection->getName(),
            'description' => $reflection->getDocComment() ?: '',
            'parameters' => [
                'properties' => []
            ]
        ];

        $params = [];
        foreach ($reflection->getParameters() as $param) {
            $type = $param->getType();
            $typeName = $type instanceof ReflectionNamedType ? $type->getName() : 'mixed';
            $params[$param->getName()] = ['type' => $typeName];
        }
        $fnSignature['parameters']['properties'] = $params;

        return $fnSignature;
    }

    /**
     * Create and store a new tool.
     *
     * @param int $agentId
     * @param callable $fn
     * @return Tool
     * @throws \ReflectionException
     */
    public function createTool(int $agentId, callable $fn)
    {
        $fnSignature = $this->getFunctionSignature($fn);

        return Tool::create([
            'agent_id' => $agentId,
            'name' => $fnSignature['name'],
            'description' => $fnSignature['description'],
            'function_signature' => $fnSignature,
        ]);
    }
}
