<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Tag extends Model
{
    use HasFactory;

    protected $fillable = [
        'tag_name',
    ];


    public function posts(): BelongsToMany
    {
        return $this->belongsToMany(Post::class)->withPivot('created_at', 'updated_at');
    }

    protected function scopeSearch(Builder $query, $search = ''): void
    {
        $query->where('tag_name', 'like', '%' . $search . '%');
    }
}
