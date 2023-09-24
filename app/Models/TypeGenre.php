<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TypeGenre extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'type_genres';
    protected $guarded = false;

    public function books()
    {
        return $this->hasMany(Book::class);
    }

    public function genre(){
        //return $this->belongsTo(Writer::class, 'writer_id', 'id');
        return $this->belongsTo(Genre::class)->select('name', 'id');
    }
}
