<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Cviebrock\EloquentSluggable\Sluggable;

class Post extends Model
{
    use HasFactory;
    use Sluggable;
    protected $fillable = ['title', 'description', 'userId', 'image'];

    public function user(): BelongsTo {
        return $this->belongsTo(User::class, 'userId', 'id');
    }

    public function comments(): MorphMany {
        return $this->morphMany(Comment::class, 'commentable');
    }

    public function sluggable(): array {
        return [
            'slug' => [
                'source' => 'title',
                'onUpdate' => true,
            ]
        ];
    }
}
