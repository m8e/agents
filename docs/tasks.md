## **Agents**

```php
// Assign Agents to a Task:
$task = Task::find($taskId);
$agentIds = [1, 2, 3]; // Array of agent IDs to assign

$task->agents()->sync($agentIds); // Assigns agents to the task

// Retrieve Agents Assigned to a Task:
$task = Task::find($taskId);
$agents = $task->agents; // Collection of Agent models

// Retrieve Tasks Assigned to an Agent:
$agent = Agent::find($agentId);
$tasks = $agent->tasks; // Collection of Task models
```
## **How to Use the Closure Table**

### **Creating Tasks**

When you create a new task, the closure table is automatically updated.

```php
$task = new Task([
    'title' => 'Subtask 1',
    'parent_task_id' => $parentTaskId,
    // other fields...
]);
$task->save();
```

### **Retrieving Descendants**

Get all descendants of a task:

```php
$task = Task::find($taskId);
$descendants = $task->descendants()->get();
```

### **Retrieving Ancestors**

Get all ancestors of a task:

```php
$task = Task::find($taskId);
$ancestors = $task->ancestors()->get();
```

### **Querying Tasks with Depth**

You can also filter by depth:

```php
// Get immediate children (depth = 1)
$children = $task->descendants()->wherePivot('depth', 1)->get();

// Get all descendants up to a certain depth
$descendants = $task->descendants()->wherePivot('depth', '<=', 3)->get();
```
