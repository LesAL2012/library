<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Znck\Eloquent\Traits\BelongsToThrough;

class Genre extends Model
{
    use HasFactory;
    use SoftDeletes;
    use BelongsToThrough;

    protected $table = 'genres';
    protected $guarded = false;

    public function type_genres()
    {
        //return $this->hasMany(Books::class, 'writer_id', 'id');
        return $this->hasMany(TypeGenre::class);
    }

    public function books()
    {
        //return $this->hasMany(Book::class);

        return $this->hasManyThrough(Book::class, TypeGenre::class)->select('books.id','books.name');
    }

    /* public function genre(){
        //return $this->belongsTo(Writer::class, 'writer_id', 'id');
        //return $this->belongsTo(TypeGenre::class)->(Genre::class)->genre();
        return $this->belongsToThrough(Genre::class, TypeGenre::class)->select('genres.id','genres.name');
    } */
}
