<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    use HasFactory;

    protected $fillable = [
        'owner_id',
        'title',
        'author',
        'isbn',
        'genre_id',
        'description',
        'cover_image_url',
        'status',
        'city_id',
        'condition',
        'is_public',
    ];

    // Связи согласно ТЗ
    public function owner()
    {
        return $this->belongsTo(User::class, 'owner_id');
    }

    public function city()
    {
        return $this->belongsTo(City::class);
    }

    public function genre()
    {
        return $this->belongsTo(Genre::class); // позже создадим
    }

    public function exchangeRequests()
    {
        return $this->hasMany(ExchangeRequest::class);
    }
}