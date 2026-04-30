<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    protected $fillable = [
        'book_request_id',
        'reviewer_id',
        'reviewed_user_id',
        'rating',
        'comment'
    ];

    public function reviewer()
    {
        return $this->belongsTo(User::class, 'reviewer_id');
    }

    public function reviewedUser()
    {
        return $this->belongsTo(User::class, 'reviewed_user_id');
    }

    public function request()
    {
        return $this->belongsTo(BookRequest::class, 'book_request_id');
    }
}