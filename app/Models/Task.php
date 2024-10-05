<?php

namespace App\Models;

use App\Enums\Priority;
use App\Enums\TaskProgress;
use App\Enums\TaskStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;

class Task extends Model
{
    use SoftDeletes;
    use HasFactory;

    protected $casts = [
        'progress' => TaskProgress::class,
        'status' => TaskStatus::class,
        'priority' => Priority::class,
        'metadata' => 'array', // Cast metadata to array
    ];

    protected $fillable = [
        'goal_id',
        'parent_task_id',
        'assigned_to',
        'title',
        'progress',
        'task_status',
        'task_priority',
    ];

    protected static function boot(): void
    {
        parent::boot();

        static::created(function ($task): void {
            // Insert the direct relationship (task to itself)
            DB::table('task_closure')->insert([
                'ancestor' => $task->id,
                'descendant' => $task->id,
                'depth' => 0,
            ]);

            if ($task->parent_task_id) {
                // Insert paths from ancestors to the new task
                $ancestorPaths = DB::table('task_closure')
                    ->where('descendant', $task->parent_task_id)
                    ->get();

                foreach ($ancestorPaths as $path) {
                    DB::table('task_closure')->insert([
                        'ancestor' => $path->ancestor,
                        'descendant' => $task->id,
                        'depth' => $path->depth + 1,
                    ]);
                }
            }
        });

        static::deleting(function ($task): void {
            // Delete paths where the descendant is the task being deleted
            DB::table('task_closure')
                ->where('descendant', $task->id)
                ->delete();
        });

        static::updated(function ($task): void {
            if ($task->isDirty('parent_task_id')) {
                // Remove old paths
                DB::table('task_closure')
                    ->where('descendant', $task->id)
                    ->where('ancestor', '!=', $task->id)
                    ->delete();

                if ($task->parent_task_id) {
                    // Insert new paths from ancestors to the task
                    $ancestorPaths = DB::table('task_closure')
                        ->where('descendant', $task->parent_task_id)
                        ->get();

                    foreach ($ancestorPaths as $path) {
                        DB::table('task_closure')->insert([
                            'ancestor' => $path->ancestor,
                            'descendant' => $task->id,
                            'depth' => $path->depth + 1,
                        ]);
                    }
                }
            }
        });
    }

    // Relationships to get ancestors and descendants
    public function ancestors()
    {
        return $this->belongsToMany(
            Task::class,
            'task_closure',
            'descendant',
            'ancestor'
        )->withPivot('depth');
    }

    public function descendants()
    {
        return $this->belongsToMany(
            Task::class,
            'task_closure',
            'ancestor',
            'descendant'
        )->withPivot('depth');
    }

    public function parent()
    {
        return $this->belongsTo(Task::class, 'parent_task_id');
    }

    public function children()
    {
        return $this->hasMany(Task::class, 'parent_task_id');
    }

    // Metadata
    public function getMetadataItem(string $key, $default = null)
    {
        return $this->metadata[$key] ?? $default;
    }

    public function setMetadataItem(string $key, $value): void
    {
        $metadata = $this->metadata;
        $metadata[$key] = $value;
        $this->metadata = $metadata;
        $this->save();
    }

    public function removeMetadataItem(string $key): void
    {
        $metadata = $this->metadata;
        unset($metadata[$key]);
        $this->metadata = $metadata;
        $this->save();
    }


    // Set custom collection class
    public function newCollection(array $models = [])
    {
        return new TaskCollection($models);
    }

    // Relationships
    public function goal()
    {
        return $this->belongsTo(Goal::class);
    }

    public function agents()
    {
        return $this->belongsToMany(Agent::class, 'agent_task');
    }

    /**
     * Get the comments associated with this task.
     */
    public function comments()
    {
        return $this->morphMany(Comment::class, 'related_object');
    }

    /**
     * Get the activity logs associated with this task.
     */
    public function activityLogs()
    {
        return $this->morphMany(ActivityLog::class, 'related_object');
    }
}
