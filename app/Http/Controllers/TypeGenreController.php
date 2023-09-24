<?php

namespace App\Http\Controllers;

use App\Models\TypeGenre;
use App\Models\Genre;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;

class TypeGenreController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $paginate = 4;

        if (isset($_COOKIE['paginate'])) {
            $paginate = $_COOKIE['paginate'];
        }

        if ($request->paginate) {
            $paginate = $request->paginate;
        }

        //dd( $paramArr['writers']);

        if (isset($_COOKIE['paginate'])) {
            $paginate = $_COOKIE['paginate'];
        }

        if ($request->paginate) {
            $paginate = $request->paginate;
        }

        $typeGenre=TypeGenre::select(
            'id',
            'name',
            'genre_id',
        )
        ->withCount('books')
        ->with('genre')
        ->orderBy('updated_at', 'DESC')
        ->paginate($paginate);

        //dd($writers);

        $count_page = count( $typeGenre->items());
        if ($count_page == 0 ||  $_GET['page'] = "0") {
            $_GET['page'] = "1";
            return redirect('/type_genres');
        }



        return Inertia::render('Settings/TypeGenres', [
            'title' => 'All types of genres',
            'type_genres' =>  $typeGenre,
            'genres' => Genre::select('id', 'name')->orderBy('name')->get(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, TypeGenre $typeGenre)
    {
        $request->validate([
            'name' => 'required|unique:writers|string|max:255',
            'genre_id' => 'required|integer|exists:genres,id',
        ]);

        $data = ['name' => $request->name, 'genre_id'=> $request->genre_id];

        //dd($data);

        try {
            DB::beginTransaction();

            TypeGenre::firstOrCreate($data);

            DB::commit();
        } catch (\Exception $exception) {
            DB::rollBack();
            abort(500);
        }

        $typeGenre = TypeGenre::orderBy('created_at', 'desc')->take(1)->get();

        $typeGenre = $typeGenre->toArray()[0];

        //dd($writer);

        setcookie("messageSettings", '#' . $typeGenre['id'] .  ' : ' . $typeGenre['name'] . ' - type of genre was successfully created', time() + 10);

        return redirect()->route('type_genres.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(TypeGenre $typeGenre)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(TypeGenre $typeGenre)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, TypeGenre $typeGenre)
    {
        $request->validate([
            'name' => 'required|unique:writers|string|max:255',
            'genre_id' => 'required|integer|exists:genres,id',
        ]);

        $data = ['name' => $request->name, 'genre_id'=> $request->genre_id];

        //dd($data);

        $typeGenre->update($data);

        setcookie("messageSettings", '#' . $typeGenre['id'] .  ' : ' . $typeGenre['name'] . ' - type of genre was successfully updated', time() + 10);

        return redirect()->route('type_genres.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(TypeGenre $typeGenre)
    {
        $typeGenre->delete();

        setcookie("messageSettings", '#' . $typeGenre['id'] .  ' : ' . $typeGenre['name'] . ' - type of genre was successfully deleted', time() + 10);

        return redirect()->back();
    }
}
