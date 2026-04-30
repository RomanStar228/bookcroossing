<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BookRequest extends Model
{
    protected $fillable = [
        'book_id',
        'requester_id',
        'status'
    ];

    public function book()
    {
        return $this->belongsTo(Book::class);
    }

    public function requester()
    {
        return $this->belongsTo(User::class, 'requester_id');
    }

// app/Models/BookRequest.php

public function canLeaveReview(User $user)
{
    return $this->status === 'completed' &&
           ($user->id === $this->requester_id || $user->id === $this->book->owner_id) &&
           !$this->reviews()->where('reviewer_id', $user->id)->exists();
}
public function reviews()
{
    return $this->hasMany(Review::class);
}
}