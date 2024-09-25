<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;

class TaskCollection extends Collection
{
    public function topLevel()
    {
        return $this->filter(function ($task) {
            return is_null($task->parent_task_id);
        });
    }
}
