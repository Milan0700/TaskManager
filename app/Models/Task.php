<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property int $id
 * @property int $user_id
 * @property string $uuid
 * @property int|null $category_id
 * @property string $title
 * @property string|null $description
 * @property bool $is_recurring
 * @property \Illuminate\Support\Carbon|null $task_date
 * @property \Illuminate\Support\Carbon|null $completed_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Category|null $category
 * @property-read \App\Models\User $user
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Task newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Task newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Task query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Task whereCategoryId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Task whereCompletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Task whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Task whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Task whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Task whereIsRecurring($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Task whereTaskDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Task whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Task whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Task whereUserId($value)
 * @mixin \Eloquent
 */
class Task extends Model
{
    use HasUlids;
    protected $fillable = ['title', 'description', 'category_id', 'task_date', 'completed_at','is_recurring'];
    public function getRouteKeyName()
    {
        return 'uuid';
    }
    public function casts(): array
    {
        return [
            'is_recurring' => 'boolean',
            'completed_at' => "datetime",
            'task_date' => "datetime"
        ];
    }

    function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
    function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }
    public function uniqueIds()
    {
        return ['uuid'];
    }
}
