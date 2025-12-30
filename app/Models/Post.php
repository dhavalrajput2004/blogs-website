<?php

namespace App\Models;

use App\Events\PostCreated;
use App\Models\Scopes\OldScope;
use App\Observers\PostObserver;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Attributes\Scope;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Attributes\ScopedBy;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;

//#[ScopedBy([OldScope::class])]
//#[ObservedBy([PostObserver::class])]
class Post extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'body',
        'image',
        'user_id',
        'category_id'
    ];

    public function likes(): MorphMany
    {
        return $this->morphMany(Like::class, 'likeable');
    }

    public function userLiked($userId) {
        return $this->likes()->where('user_id', $userId)->first();
    }

    public function tags(): BelongsToMany
    {
        return $this->belongsToMany(Tag::class)->withPivot('tag_id','post_id','created_at', 'updated_at');
    }

    public function comments(): HasMany
    {
        return $this->hasMany(Comment::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    protected function scopeSearch(Builder $query, $search = ''): void
    {
        $query->where('title', 'like', '%' . $search . '%');
    }

    // protected $dispatchesEvents = [
    //     'created' => PostCreated::class,
    // ];
}
