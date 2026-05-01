<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Book extends Model
{
    use HasFactory, SoftDeletes;

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
        'location',
        'condition',
        'is_public',
        'year',
    ];

    // Связи
    public function owner()
    {
        return $this->belongsTo(User::class, 'owner_id');
    }

    public function genre()
    {
        return $this->belongsTo(Genre::class);
    }

    public function city()
    {
        return $this->belongsTo(City::class);
    }

    /**
     * Запросы на эту книгу
     */
    public function requests()
    {
        return $this->hasMany(BookRequest::class);
    }

    // app/Models/Book.php

public function reviews()
{
    return $this->hasManyThrough(
        Review::class,
        BookRequest::class,
        'book_id',          // внешний ключ в book_requests
        'book_request_id',  // внешний ключ в reviews
        'id',               // локальный ключ в books
        'id'                // локальный ключ в book_requests
    )->where('book_requests.status', 'completed'); // Только завершённые обмены
}


// Добавьте этот метод после связей
public function getAvgRatingAttribute()
{
    // Берём средний rating из отзывов, связанных с книгой
    return $this->reviews()->avg('rating') ?? 0;
}

public function canViewLocation(User $user)
{
    // Если книга найдена (успешный обмен)
    if ($this->status === 'Найдена') {
        // Проверяем, есть ли завершённый обмен с участием этого пользователя
        return $this->requests()
            ->where('status', 'completed')
            ->where(function ($query) use ($user) {
                $query->where('requester_id', $user->id)
                      ->orWhereHas('book', function ($q) use ($user) {
                          $q->where('owner_id', $user->id);
                      });
            })
            ->exists();
    }
    return false;
}
}