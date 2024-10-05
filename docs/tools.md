
Step 1: Create the Tool

```php
use App\Agents\Tools\ToolService;

// Assume $agentId is the ID of the agent we're associating the tool with
$agentId = 1;

$toolService = new ToolService();

// Define the function you want to expose as a tool
$addNumbersFunction = function (int $a, int $b) {
    return $a + $b;
};

// Create and store the tool
$tool = $toolService->createTool($agentId, $addNumbersFunction);
```

Step 2: Execute the Tool
```php
<?php

use App\Models\Tool;

// Retrieve the tool
$tool = Tool::where('name', 'addNumbers')->first();

if ($tool) {
    try {
        // Arguments to pass to the tool
        $arguments = ['a' => 5, 'b' => 7];

        // Execute the tool
        $result = $tool->run($arguments);

        echo "Result: $result"; // Output: Result: 12
    } catch (\Exception $e) {
        echo "Error: " . $e->getMessage();
    }
} else {
    echo "Tool not found.";
}
```
