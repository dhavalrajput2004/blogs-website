<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Str;
use Laravel\Sanctum\HasApiTokens;

//#[ObservedBy([UserObserver::class])]
class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'is_admin',
        'last_activity',
        'phone_number'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
        'is_admin' => 'boolean',
        'last_activity' => 'datetime'
    ];

    public function following(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'user_follower','follower_id','followee_id');
    }

    public function followers(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'user_follower', 'followee_id', 'follower_id');
    }

    public function isFollowing($userId) {
        return $this->following()->where('followee_id', $userId)->first();
    }

    public function posts(): HasMany
    {
        return $this->hasMany(Post::class);
    }

    public function comments(): HasMany
    {
        return $this->hasMany(Comment::class);
    }

    protected function scopeAdmin(Builder $query) 
    {
        $query->where('is_admin', true);
    }

    protected function scopeNormalUser(Builder $query) 
    {
        $query->where('is_admin', false);
    }

   // protected $dispatchesEvents = [
      //  'saved' => UserSaved::class,
      //  'deleted' => UserDeleted::class,
    // ];

    protected function phoneNumber(): Attribute
    {
        return Attribute::make(
            get: fn (string $value) => decrypt($value),
            set: fn (string $value) => encrypt($value)
        );
    }

    public function getFullNameAttribute() {
        return $this->attributes['name'];
    }

  //  public function setFullNameAttrbute($value) {
   //     $this->atttrbutes['name'] = $value;
  //  }
}
