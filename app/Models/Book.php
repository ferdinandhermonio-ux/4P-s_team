<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    protected $fillable = ['title', 'author', 'category_id', 'isbn', 'quantity', 'available_quantity'];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function borrowings()
    {
        return $this->hasMany(Borrowing::class);
    }
}
