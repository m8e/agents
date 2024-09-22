<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Milestone extends Model
{
    use SoftDeletes;
    use HasFactory;

    protected $fillable = [
        'objective_id',
        'assigned_to',
        'title',
        'progress',
        'milestone_status',
        'milestone_priority',
    ];

    /**
     * Get the objective that this milestone belongs to.
     */
    public function objective()
    {
        return $this->belongsTo(Objective::class);
    }

    /**
     * Get the agent assigned to this milestone.
     */
    public function agent()
    {
        return $this->belongsTo(Agent::class, 'assigned_to');
    }

    /**
     * The milestones that this milestone depends on.
     */
    public function dependencies()
    {
        return $this->belongsToMany(
            Milestone::class,
            'milestones_dependencies',
            'milestone_id',
            'depends_on_milestone_id'
        );
    }

    /**
     * The milestones that depend on this milestone.
     */
    public function dependents()
    {
        return $this->belongsToMany(
            Milestone::class,
            'milestones_dependencies',
            'depends_on_milestone_id',
            'milestone_id'
        );
    }

    /**
     * Get the comments associated with this milestone.
     */
    public function comments()
    {
        return $this->morphMany(Comment::class, 'related_object');
    }

    /**
     * Get the activity logs associated with this milestone.
     */
    public function activityLogs()
    {
        return $this->morphMany(ActivityLog::class, 'related_object');
    }
}
