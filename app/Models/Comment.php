<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'parent_id',
        'related_object_type',
        'related_object_id',
        'comment_text',
    ];

    /**
     * Get the user who made the comment.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the parent comment (for threaded comments).
     */
    public function parent()
    {
        return $this->belongsTo(Comment::class, 'parent_id');
    }

    /**
     * Get the child comments (replies).
     */
    public function children()
    {
        return $this->hasMany(Comment::class, 'parent_id');
    }

    /**
     * Get the related object (objective or milestone) that this comment is associated with.
     */
    public function relatedObject()
    {
        return $this->morphTo();
    }
}
