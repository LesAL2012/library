<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BookUserLike extends Model
{
    use HasFactory;

    protected $table = 'book_user_likes';
    protected $guarded = false;

    /* public function book(){
        //return $this->belongsTo(Writer::class, 'writer_id', 'id');
        return $this->belongsTo(Book::class)->select('books.name');
    } */
}
