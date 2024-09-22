<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Objective extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'title',
        'description',
        'icon',
        'deadline_date',
    ];

    protected function casts(): array
    {
        return [
            'deadline_date' => 'datetime',
        ];
    }

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

}
