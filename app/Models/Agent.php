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

    public function objectives()
    {
        return $this->hasMany(Objective::class, 'assigned_to');
    }

    public function milestones()
    {
        return $this->hasMany(Milestone::class, 'assigned_to');
    }

    public function roles()
    {
        return $this->morphToMany(Role::class, 'model', 'model_has_roles');
    }
}
