<?php

namespace App\Agents\Tools;

use App\Contracts\Too;

class AddNumbersTool implements Too
{
    /**
     * Description of the tool.
     *
     * @var string
     */
    public static $description = 'Adds two numbers together.';

    /**
     * Function signature.
     *
     * @var array
     */
    public static $functionSignature = [
        'name' => 'addNumbers',
        'description' => 'Adds two numbers together.',
        'parameters' => [
            'properties' => [
                'a' => ['type' => 'int'],
                'b' => ['type' => 'int'],
            ],
        ],
    ];

    /**
     * Execute the tool.
     *
     * @param array $args
     * @return int
     */
    public static function run(array $args)
    {
        return $args['a'] + $args['b'];
    }
}
