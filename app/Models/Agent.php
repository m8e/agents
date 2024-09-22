<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Agent extends Model
{
    use SoftDeletes;
    use HasFactory;

    protected $fillable = [
        'team_id',
        'name',
        'description',
        'type',
        'status',
        'config',
        'capabilities',
        'last_active_at',
    ];

    protected $casts = [
        'config' => 'array',
        'capabilities' => 'array',
        'last_active_at' => 'datetime',
    ];

    public function team()
    {
        return $this->belongsTo(Team::class);
    }

    public function goals()
    {
        return $this->hasMany(Goal::class, 'assigned_to');
    }

    public function tasks()
    {
        return $this->hasMany(Task::class, 'assigned_to');
    }
}
