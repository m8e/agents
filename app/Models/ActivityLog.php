<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ActivityLog extends Model
{
    use HasFactory;

    protected $fillable = [
        'team_id',
        'user_id',
        'agent_id',
        'activity_type',
        'related_object_type',
        'related_object_id',
        'details',
    ];

    /**
     * Get the team associated with the activity log.
     */
    public function team()
    {
        return $this->belongsTo(Team::class);
    }

    /**
     * Get the user who performed the activity.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the agent who performed the activity.
     */
    public function agent()
    {
        return $this->belongsTo(Agent::class);
    }

    /**
     * Get the related object (objective, milestone, or agent) for this activity log.
     */
    public function relatedObject()
    {
        return $this->morphTo();
    }
}
