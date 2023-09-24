<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\Http\Request;


class LikeStoreController extends Controller
{
    public function __invoke(Book $book_id) {

        auth()->user()->likedBooks()->toggle($book_id->id);

        return redirect()->back();
    }
}
