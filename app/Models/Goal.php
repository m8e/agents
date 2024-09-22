<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Goal extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'title',
        'description',
        'icon',
        'deadline_date',
        'team_id',
        'user_id',
        'agent_id',
        'start_date',
        'progress',
        'status',
        'priority',
        'risk_level',
        'estimated_tokens',
        'actual_tokens',
        'outcome',
        'tags',
        'completion_criteria',
    ];

    protected $casts = [
        'deadline_date' => 'datetime',
        'start_date' => 'datetime',
    ];

    public function comments()
    {
        return $this->morphMany(Comment::class, 'related_object');
    }

    public function activityLogs()
    {
        return $this->morphMany(ActivityLog::class, 'related_object');
    }

    public function team()
    {
        return $this->belongsTo(Team::class);
    }

    public function tasks()
    {
        return $this->hasMany(Task::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function agent()
    {
        return $this->belongsTo(Agent::class);
    }
}
