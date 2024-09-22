<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MilestoneDependency extends Model
{
    use HasFactory;

    protected $table = 'milestones_dependencies';

    protected $fillable = [
        'milestone_id',
        'depends_on_milestone_id',
    ];

    /**
     * Get the milestone that has the dependency.
     */
    public function milestone()
    {
        return $this->belongsTo(Milestone::class, 'milestone_id');
    }

    /**
     * Get the milestone that this milestone depends on.
     */
    public function dependsOn()
    {
        return $this->belongsTo(Milestone::class, 'depends_on_milestone_id');
    }
}
