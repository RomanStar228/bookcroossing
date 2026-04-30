<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    protected $fillable = [
        'username',
        'full_name',
        'email',
        'password',
        'avatar_url',
        'description',
        'city_id',
        'role',
        'is_banned',
        'rating',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'is_banned' => 'boolean',
        'rating' => 'decimal:2',
    ];

    public function city()
    {
        return $this->belongsTo(City::class);
    }

    public function books()
    {
        return $this->hasMany(Book::class, 'owner_id');
    }

    public function bookRequests()
{
    return $this->hasMany(BookRequest::class, 'requester_id');
}

public function reviewsReceived()
{
    return $this->hasMany(Review::class, 'reviewed_user_id');
}

public function reviewsGiven()
{
    return $this->hasMany(Review::class, 'reviewer_id');
}
}