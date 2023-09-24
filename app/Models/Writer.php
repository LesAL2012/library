<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Writer extends Model{

    use HasFactory;
    use SoftDeletes;

    protected $table = 'writers';
    protected $guarded = false;

    public function books()
    {
        //return $this->hasMany(Books::class, 'writer_id', 'id');
        return $this->hasMany(Book::class);
    }
}
