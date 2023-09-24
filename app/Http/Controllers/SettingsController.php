<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\BookUserLike;
use App\Models\Category;
use App\Models\Genre;
use App\Models\Tag;
use App\Models\TypeGenre;
use App\Models\Writer;
use Illuminate\Http\Request;
use Inertia\Inertia;

class SettingsController extends Controller
{
    public function __invoke()
    {
        $take = 10;

        $writers = Writer::withCount('books')->orderBy('books_count', 'desc')->take($take)->get();
        $writersCount = Writer::count();

        $categories = Category::withCount('books')->orderBy('books_count', 'desc')->take($take)->get();
        $categoriesCount = Category::count();

        $genres = Genre::withCount('books')->orderBy('books_count', 'desc')->take($take)->get();
        $genresCount = Genre::count();

        $typeGenres = TypeGenre::withCount('books')->take($take)->get();
        $typeGenresCount = TypeGenre::count();

        $tags = Tag::withCount('books')->take($take)->get();
        $tagsCount = Tag::count();

        $likes = Book::select('name')->withCount('likedUsers')->orderBy('liked_users_count', 'desc')->take($take)->get();
        $likesCount = BookUserLike::count();
        $booksCount = Book::count();

        return Inertia::render('Settings/Settings', [
            'title' => 'Settings',
            'take' => $take,
            'data' => [
                'writers' => ['writersData' => $writers, 'writersCount' => $writersCount],
                'categories' => ['categoriesData' => $categories, 'categoriesCount' => $categoriesCount],
                'genres' => ['genresData' => $genres, 'genresCount' => $genresCount],
                'typeGenres' => ['typeGenresData' => $typeGenres, 'typeGenresCount' => $typeGenresCount],
                'tags' => ['tagsData' => $tags, 'tagsCount' => $tagsCount],
                'likes' => ['likesData' => $likes, 'likesCount' => $likesCount, 'booksCount' => $booksCount],
            ],
        ]);
    }
}
