<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Znck\Eloquent\Traits\BelongsToThrough;

class Book extends Model
{
    use HasFactory;
    use SoftDeletes;
    use BelongsToThrough;

    protected $table = 'books';
    protected $guarded = false;

    /* protected $withCount = ['likedUsers'];
    protected $with = ['category']; */

    public function writer(){
        //return $this->belongsTo(Writer::class, 'writer_id', 'id');
        return $this->belongsTo(Writer::class)->select('id','name');
    }

    public function category(){
        return $this->belongsTo(Category::class)->select('id','name');
    }

    public function type_genre(){
        //return $this->belongsTo(Writer::class, 'writer_id', 'id');
        return $this->belongsTo(TypeGenre::class)->select('id','name');
    }

    public function genre(){
        //return $this->belongsTo(Writer::class, 'writer_id', 'id');
        //return $this->belongsTo(TypeGenre::class)->(Genre::class)->genre();
        return $this->belongsToThrough(Genre::class, TypeGenre::class)->select('genres.id','genres.name');
    }

    public function tags(){
        return $this->belongsToMany(Tag::class, 'book_tags', 'book_id', 'tag_id')->select('tags.id','tags.name');
    }

    public function likedUsers(){
        return $this->belongsToMany(User::class, 'book_user_likes', 'book_id', 'user_id')->select('book_id','user_id');
    }
}

