### Reflection Agent

```php
use App\Services\ReflectionAgentService;

$agent = app(ReflectionAgentService::class);

// Define the generation system prompt
$generationSystemPrompt =
  "You are a knowledgeable assistant that provides detailed and accurate answers.";

// Define the reflection system prompt
$reflectionSystemPrompt =
  "You are an assistant that critiques responses for correctness, clarity, and helpfulness. Provide feedback on how to improve the response.";

// Define the user's prompt
$userPrompt = "what kind of earth plasters are in use in the philippines.";

// Set the number of reflection steps (optional)
$nSteps = 3;

// Set verbosity level (optional, 0 for no verbose output)
$verbose = 1;

// Run the agent
$response = $agent->run(
  $generationSystemPrompt,
  $reflectionSystemPrompt,
  $userPrompt,
  $nSteps,
  $verbose
);

// Output the final response
echo $response;

```
