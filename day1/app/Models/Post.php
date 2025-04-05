<?php

namespace App\Models;

use Database\Factories\PostFactory;
use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Carbon;

/**
 *
 *
 * @property int $id
 * @property string $title
 * @property string $description
 * @property int $userId
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read User $user
 * @method static PostFactory factory($count = null, $state = [])
 * @method static Builder<static>|Post newModelQuery()
 * @method static Builder<static>|Post newQuery()
 * @method static Builder<static>|Post query()
 * @method static Builder<static>|Post whereCreatedAt($value)
 * @method static Builder<static>|Post whereDescription($value)
 * @method static Builder<static>|Post whereId($value)
 * @method static Builder<static>|Post whereTitle($value)
 * @method static Builder<static>|Post whereUpdatedAt($value)
 * @method static Builder<static>|Post whereUserId($value)
 * @mixin Eloquent
 */
class Post extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function user(): BelongsTo {
        return $this->belongsTo(User::class, 'userId', 'id');
    }
}
