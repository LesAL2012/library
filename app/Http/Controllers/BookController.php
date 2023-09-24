<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\BookTag;
use App\Models\BookUserLike;
use App\Models\Category;
use App\Models\Genre;
use App\Models\Tag;
use App\Models\TypeGenre;
use App\Models\Writer;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;
use Intervention\Image\Facades\Image;

class BookController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    public function index(Request $request)
    {

        $paginate = 4;

        $paramArr = [
            'sortBy' => 'id',
            'sortDir' => 'ASC',
            'years' => [Book::min('year'), Book::max('year')],
            'writers' => Writer::select('id', 'name')->orderBy('name')->get(),
            'category' => Category::select('id', 'name')->orderBy('name')->get(),
            'tag' => Tag::select('id', 'name')->orderBy('name')->get(),
            'genre' => Genre::select('id', 'name')->orderBy('name')->get(),
            'type' => TypeGenre::select('id', 'name', 'genre_id')->orderBy('name')->get(),
        ];

        //dd( $paramArr['writers']);

        if (isset($_COOKIE['paginate'])) {
            $paginate = $_COOKIE['paginate'];
        }

        if ($request->paginate) {
            $paginate = $request->paginate;
        }



        $books = Book::select(
            'id',
            'name',
            'image',
            'description',
            'year',
            'amount',
            'writer_id',
            'type_genre_id',
            //'genre_id',
            'category_id',
            //'tags_id'
        );

        $books = $books->with('writer', 'type_genre', 'genre', 'category', 'tags', 'likedUsers');
        $books = $books->withCount('likedUsers');

        if (isset($_COOKIE['sortBy']) && $_COOKIE['sortBy'] == 'liked_users_count') {
            $paramArr['sortBy'] = 'liked_users_count';
        } elseif (isset($_COOKIE['sortBy']) && $_COOKIE['sortBy'] == 'year') {
            $paramArr['sortBy'] = 'year';
        } elseif (isset($_COOKIE['sortBy']) && $_COOKIE['sortBy'] == 'name') {
            $paramArr['sortBy'] = 'name';
        } elseif (isset($_COOKIE['sortBy']) && $_COOKIE['sortBy'] == 'writer') {
            $paramArr['sortBy'] = Writer::select('name')->whereColumn('books.writer_id', 'writers.id');
        } elseif (isset($_COOKIE['sortBy']) && $_COOKIE['sortBy'] == 'category') {
            $paramArr['sortBy'] = Category::select('name')->whereColumn('books.category_id', 'categories.id');
        } elseif (isset($_COOKIE['sortBy']) && $_COOKIE['sortBy'] == 'type') {
            $paramArr['sortBy'] = TypeGenre::select('name')->whereColumn('books.type_genre_id', 'type_genres.id');
        } elseif (isset($_COOKIE['sortBy']) && $_COOKIE['sortBy'] == 'genre') {
            $paramArr['sortBy'] =  TypeGenre::whereColumn('books.type_genre_id', 'type_genres.id')
                ->join('genres', 'type_genres.genre_id', '=', 'genres.id')->select('genres.name');
        }

        if (isset($_COOKIE['sortDir']) && $_COOKIE['sortDir'] == 1) {
            $paramArr['sortDir'] = 'ASC';
        } else {
            $paramArr['sortDir'] = 'DESC';
        }

        if (isset($_COOKIE['yearMini']) && $_COOKIE['yearMini'] != '' && isset($_COOKIE['yearMaxi']) && $_COOKIE['yearMaxi'] != '') {
            if ($_COOKIE['yearMini'] != $paramArr['years'][0] || $_COOKIE['yearMaxi'] != $paramArr['years'][1]) {
                $books->whereBetween('year', [$_COOKIE['yearMini'], $_COOKIE['yearMaxi']]);
            }
        }

        if (isset($_COOKIE['titleSearch']) && $_COOKIE['titleSearch'] != '') {

            $titleS = '%' . $_COOKIE['titleSearch'] . '%';

            $books->where('name', 'like', $titleS);

            if (count($books->paginate($paginate)->items()) == 0 && isset($_GET['page']) && $_GET['page'] != 1) {
                $_GET['page'] = "1";
                return redirect('/books');
            } else {
                if (isset($_COOKIE['messageSearchT'])) {
                    setcookie("messageSearchT", '', time() - 1);
                }
            }

            if (count($books->paginate($paginate)->items()) == 0) {
                $messageSearch = 'There are no books with this name "' . $_COOKIE['titleSearch'] . '"';
                setcookie("messageSearchT", $messageSearch, time() + 10);
                setcookie("titleSearch", '', time() - 1);
                return redirect()->back();
            }
        }

        if (isset($_COOKIE['writerSearch']) && $_COOKIE['writerSearch'] != '') {

            $books->whereHas('writer', function (Builder $query) {
                $query->whereIn('id', explode(",", $_COOKIE['writerSearch']));
            });

            if (count($books->paginate($paginate)->items()) == 0 && isset($_GET['page']) && $_GET['page'] != 1) {
                $_GET['page'] = "1";
                return redirect('/books');
            } else {
                if (isset($_COOKIE['messageSearchW'])) {
                    setcookie("messageSearchW", '', time() - 1);
                }
            }

            if (count($books->paginate($paginate)->items()) == 0) {
                $messageSearch = 'There are no books with these writers ...';
                setcookie("messageSearchW", $messageSearch, time() + 10);
                setcookie("writerSearch", '', time() - 1);
                return redirect()->back();
            }
        }

        if (isset($_COOKIE['categorySearch']) && $_COOKIE['categorySearch'] != '') {

            $books->whereHas('category', function (Builder $query) {
                $query->whereIn('id', explode(",", $_COOKIE['categorySearch']));
            });

            if (count($books->paginate($paginate)->items()) == 0 && isset($_GET['page']) && $_GET['page'] != 1) {
                $_GET['page'] = "1";
                return redirect('/books');
            } else {
                if (isset($_COOKIE['messageSearchC'])) {
                    setcookie("messageSearchC", '', time() - 1);
                }
            }

            if (count($books->paginate($paginate)->items()) == 0) {
                $messageSearch = 'There are no books with these categories ...';
                setcookie("messageSearchC", $messageSearch, time() + 10);
                setcookie("categorySearch", '', time() - 1);
                return redirect()->back();
            }
        }

        if (isset($_COOKIE['tagSearch']) && $_COOKIE['tagSearch'] != '') {

            $books->whereHas('tags', function (Builder $query) {
                $query->whereIn('tags.id', explode(",", $_COOKIE['tagSearch']));
            });

            if (count($books->paginate($paginate)->items()) == 0 && isset($_GET['page']) && $_GET['page'] != 1) {
                $_GET['page'] = "1";
                return redirect('/books');
            } else {
                if (isset($_COOKIE['messageSearchT'])) {
                    setcookie("messageSearchTag", '', time() - 1);
                }
            }

            if (count($books->paginate($paginate)->items()) == 0) {
                $messageSearch = 'There are no books with these tags ...';
                setcookie("messageSearchTag", $messageSearch, time() + 10);
                setcookie("tagSearch", '', time() - 1);
                return redirect()->back();
            }

        }

        if (isset($_COOKIE['genreSearch']) && $_COOKIE['genreSearch'] != '') {

            $books->whereHas('type_genre', function (Builder $query) {
                $query->whereHas('genre', function (Builder $query) {
                    $query->where('id', explode("-", $_COOKIE['genreSearch'])[2]);
                });
            });

            if (count($books->paginate($paginate)->items()) == 0 && isset($_GET['page']) && $_GET['page'] != 1) {
                $_GET['page'] = "1";
                return redirect('/books');
            } else {
                if (isset($_COOKIE['messageSearchG'])) {
                    setcookie("messageSearchG", '', time() - 1);
                }
            }

            if (count($books->paginate($paginate)->items()) == 0) {
                $messageSearch = 'There are no books with these genres ...';
                setcookie("messageSearchG", $messageSearch, time() + 10);
                setcookie("genreSearch", '', time() - 1);
                return redirect()->back();
            }

        }

        if (isset($_COOKIE['typeSearch']) && $_COOKIE['typeSearch'] != '') {



            if (isset($_COOKIE['genreSearch']) && $_COOKIE['genreSearch'] != '') {

                $arrCookieTypeId = explode(",", $_COOKIE['typeSearch']);
                $arrCookieGenreId = explode("-", $_COOKIE['genreSearch'])[2];
                $typesDb = $paramArr['type']->toArray();

                $arrTypesIdForSearch = array();

                foreach ($typesDb as $type) {
                    if ($type['genre_id'] == $arrCookieGenreId) {
                        if (in_array($type['id'], $arrCookieTypeId)) {
                            array_push($arrTypesIdForSearch, $type['id']);
                        }
                    }
                }

                //dd($arrTypesIdForSearch);

                if (count($arrTypesIdForSearch) > 0) {
                    $GLOBALS['arrTypesIdForSearch'] = $arrTypesIdForSearch;
                    //dd($arrCookieTypeId, $arrCookieGenreId , $arrTypesIdForSearch, $GLOBALS['arrTypesIdForSearch']);
                    $books->whereHas('type_genre', function (Builder $query) {
                        $query->whereIn('id', $GLOBALS['arrTypesIdForSearch']);
                    });

                    //dd(count($books->paginate($paginate)->items()));

                    if (count($books->paginate($paginate)->items()) == 0) {
                        $messageSearch = 'There are no books with these types ...';
                        setcookie("messageSearchType", $messageSearch, time() + 10);
                        setcookie("typeSearch", null);

                        unset ($_COOKIE['typeSearch']);

                        //dd($_COOKIE['typeSearch']);
                        return redirect()->back();
                    }

                } else {
                    $messageSearch = 'There are no books with these types ...';
                    setcookie("messageSearchType", $messageSearch, time() + 5);
                }
            } else {

                $books->whereHas('type_genre', function (Builder $query) {
                    $query->whereIn('id', explode(",", $_COOKIE['typeSearch']));
                });

                if (count($books->paginate($paginate)->items()) == 0) {
                    $messageSearch = 'There are no books with these types ...';
                    setcookie("messageSearchType", $messageSearch, time() + 10);
                    setcookie("typeSearch", '', time() - 1);
                    return redirect()->back();
                }
            }

            if (count($books->paginate($paginate)->items()) == 0 && isset($_GET['page']) && $_GET['page'] != 1) {
                $_GET['page'] = "1";
                return redirect('/books');
            } else {
                if (isset($_COOKIE['messageSearchType'])) {
                    setcookie("messageSearchType", '', time() - 1);
                }
            }
        }


        $likesAreNotNull = 0;
        if (isset($_COOKIE['likesAreNotNull']) && $_COOKIE['likesAreNotNull'] == 1) {
            $likesAreNotNull = 1;
        }

        if ($likesAreNotNull) {
            $books->has('likedUsers', '<>', 0);

            if (count($books->paginate($paginate)->items()) == 0) {
                setcookie("likesAreNotNull", '', time() - 1);
                return redirect()->back();
            }
        }


        //->has('likedUsers', '<', 70)


        $books = $books->orderBy($paramArr['sortBy'], $paramArr['sortDir']);

        $books = $books->paginate($paginate);
        //dd($books->toArray());



        $count_page = count($books->items());
        //dd($count_page);
        if ($count_page == 0 ||  $_GET['page'] = "0") {
            $_GET['page'] = "1";
            return redirect('/books');
        }

        /* $category = Category::all('id','name');

        dd($category->toArray()); */



        return Inertia::render('Books/Index', [
            'title' => 'All books',
            'books' => $books,
            'years' => $paramArr['years'],
            'writers' => $paramArr['writers'],
            'category' => $paramArr['category'],
            'tag' => $paramArr['tag'],
            'genre' => $paramArr['genre'],
            'type' => $paramArr['type'],

        ]);
        //->where('year','>', 2000)->orderBy('liked_users_count', 'DESC')
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $paramArr = [
            'writers' => Writer::select('id', 'name')->orderBy('name')->get(),
            'category' => Category::select('id', 'name')->orderBy('name')->get(),
            'tag' => Tag::select('id', 'name')->orderBy('name')->get(),
            'genre' => Genre::select('id', 'name')->orderBy('name')->get(),
            'type' => TypeGenre::select('id', 'name', 'genre_id')->orderBy('name')->get(),
        ];

        return Inertia::render('Books/Create', [
            'title' => 'Create book',
            'paramArr' => $paramArr,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        /* $request->validate([
            'name' => 'required|string|max:128',

            'description' => 'required|string|max:255',
            'description_more' => 'required|string|max:1024',

            'year' => 'required|digits:4|integer|min:1960|max:'.(date('Y')+1),
            'amount' => 'required|digits:3|integer|min:1|max:999',

            'type_genre_id' => 'required|integer|exists:type_genres,id',
            'writer_id' => 'required|integer|exists:writers,id',
            'category_id' => 'required|integer|exists:categories,id',

            'tags' => 'nullable|array',
            'tags.*' => 'nullable|integer|exists:tags,id',

            'image' => 'required|file|mimes:jpg,png,gif,bmp|max:7168|dimensions:max_width=2048,max_height=1024',

        ]); */



        $data = $request->form;

        //dd($data);

        try {
            DB::beginTransaction();

            $tagIds = $data['tags'];

            $dataUpdate = array();

            if (count($data['image']) > 0) {
                $file = $data['image'][0];
                $nameImg = '_' . md5(Carbon::now() . '_' . $file->getClientOriginalName()) . '.' . $file->getClientOriginalExtension();

                $link_save = str_replace('/app/public', 'storage', env('DIR_IMG_FACTORY'));
                $link_save_min = str_replace('/app/public', 'storage', env('DIR_IMG_FACTORY_MIN'));

                Image::make($file)->save($link_save . $nameImg);
                Image::make($file)->fit(165, 220)->save($link_save_min . $nameImg);

                $dataUpdate['image'] = $nameImg;
            }

            $dataUpdate['year'] = $data['year'];
            $dataUpdate['amount'] = $data['amount'];
            $dataUpdate['type_genre_id'] = $data['type_genre_id'];
            $dataUpdate['name'] = $data['name'];
            $dataUpdate['writer_id'] = $data['writer_id'];
            $dataUpdate['description'] = $data['description'];
            $dataUpdate['description_more'] = $data['description_more'];
            $dataUpdate['category_id'] = $data['category_id'];

            $book = Book::firstOrCreate($dataUpdate);
            $book->tags()->attach($tagIds);

            DB::commit();
        } catch (\Exception $exception) {
            DB::rollBack();
            abort(500);
        }

        //$extentions = ['JPG', 'PNG', 'GIF', 'BMP'];

        $book = Book::select(
            'id',
            'name',
            'image',
            'description',
            'description_more',
            'year',
            'amount',
            'writer_id',
            'type_genre_id',
            'category_id',
        )
            ->withCount('likedUsers')
            ->with('writer', 'type_genre', 'genre', 'category', 'tags')
            ->orderBy('created_at', 'desc')->take(1)->get();

        $bookData = $book->toArray()[0];
        //dd($bookData);


        return Inertia::render('Books/Show', [
            'bookFull' => $book,
        ])->with('message', '#' . $bookData['id'] .  ' : ' . $bookData['name'] . ' - data was successfully created');
    }

    /**
     * Display the specified resource.
     */
    public function show(Book $book)
    {


        $book = $book->where('id', $book->id)
            ->select(
                'id',
                'name',
                'image',
                'description',
                'description_more',
                'year',
                'amount',
                'writer_id',
                'type_genre_id',
                'category_id',
            )
            ->withCount('likedUsers')
            ->with('writer', 'type_genre', 'genre', 'category', 'tags')
            ->get();

        //dd($book->toArray());

        return Inertia::render('Books/Show', [
            'bookFull' => $book,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Book $book)
    {
        $book = $book->where('id', $book->id)
            ->select(
                'id',
                'name',
                'image',
                'description',
                'description_more',
                'year',
                'amount',
                'writer_id',
                'type_genre_id',
                'category_id',
            )
            ->withCount('likedUsers')
            ->with('writer', 'type_genre', 'genre', 'category', 'tags')
            ->get();

        $paramArr = [
            'writers' => Writer::select('id', 'name')->orderBy('name')->get(),
            'category' => Category::select('id', 'name')->orderBy('name')->get(),
            'tag' => Tag::select('id', 'name')->orderBy('name')->get(),
            'genre' => Genre::select('id', 'name')->orderBy('name')->get(),
            'type' => TypeGenre::select('id', 'name', 'genre_id')->orderBy('name')->get(),
        ];

        //dd($book->toArray());

        return Inertia::render('Books/Edit', [
            'bookFull' => $book,
            'paramArr' => $paramArr,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Book $book)
    {

        //dd(\request()->all());

        $data = $request->form;

        //dd($nameImg);

        try {
            DB::beginTransaction();

            $tagIds = [];
            if (isset($data['tags'])) {
                $tagIds = $data['tags'];
                unset($data['tags']);
            }

            $dataUpdate = array();

            if (count($data['image']) > 0) {
                $file = $data['image'][0];
                $nameImg = '_' . md5(Carbon::now() . '_' . $file->getClientOriginalName()) . '.' . $file->getClientOriginalExtension();

                $link_save = str_replace('/app/public', 'storage', env('DIR_IMG_FACTORY'));
                $link_save_min = str_replace('/app/public', 'storage', env('DIR_IMG_FACTORY_MIN'));

                Image::make($file)->save($link_save . $nameImg);
                Image::make($file)->fit(165, 220)->save($link_save_min . $nameImg);

                $dataUpdate['image'] = $nameImg;
            }

            $dataUpdate['year'] = $data['year'];
            $dataUpdate['amount'] = $data['amount'];
            $dataUpdate['type_genre_id'] = $data['type_genre_id'];
            $dataUpdate['name'] = $data['name'];
            $dataUpdate['writer_id'] = $data['writer_id'];
            $dataUpdate['description'] = $data['description'];
            $dataUpdate['description_more'] = $data['description_more'];
            $dataUpdate['category_id'] = $data['category_id'];
            //dd( $gataUpdate);

            $book->update($dataUpdate); //ключ і значення полів - як в базі "title"

            //dd($data->toArray());

            if (count($tagIds) > 0) $book->tags()->sync($tagIds); // прибирає усі теги, на які записаний пост і пише нові, що прийши

            DB::commit();
        } catch (\Exception $exception) {
            DB::rollBack();
            abort(500);
        }

        //$extentions = ['JPG', 'PNG', 'GIF', 'BMP'];

        $book = $book->where('id', $book->id)
            ->select(
                'id',
                'name',
                'image',
                'description',
                'description_more',
                'year',
                'amount',
                'writer_id',
                'type_genre_id',
                'category_id',
            )
            ->withCount('likedUsers')
            ->with('writer', 'type_genre', 'genre', 'category', 'tags')
            ->get();

        $bookData = $book->toArray()[0];
        //dd($bookData['id']);



        return Inertia::render('Books/Show', [
            'bookFull' => $book,
        ])->with('message', '#' . $bookData['id'] .  ' : ' . $bookData['name'] . ' - data was successfully updated');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Book $book)
    {

        $book->delete();
        BookTag::where('book_id', $book->id)->delete();
        BookUserLike::where('book_id', $book->id)->delete();

        setcookie("messageDeleteBook", '#' . $book['id'] .  ' : ' . $book['name'] . ' - book was successfully deleted', time() + 10);

        return redirect()->route('books.index');
    }
}
