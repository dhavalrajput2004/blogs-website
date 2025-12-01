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

//#[ScopedBy([OldScope::class])]
//#[ObservedBy([PostObserver::class])]
class Post extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'body',
        'author',
        'image',
        'user_id'
    ];

    public function comments(): HasMany
    {
        return $this->hasMany(Comment::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    protected function scopeSearch(Builder $query, $search = ''): void
    {
        $query->where('title', 'like', '%' . $search . '%');
    }

    protected $dispatchesEvents = [
        'created' => PostCreated::class,
    ];
}
