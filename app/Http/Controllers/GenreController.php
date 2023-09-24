<?php

namespace App\Http\Controllers;

use App\Models\Genre;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;

class GenreController extends Controller
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

        $genres=Genre::select(
            'id',
            'name',
        )
        ->withCount('type_genres')
        ->withCount('books')
        ->orderBy('updated_at', 'DESC')
        ->paginate($paginate);

        //dd($writers);

        $count_page = count($genres->items());
        if ($count_page == 0 ||  $_GET['page'] = "0") {
            $_GET['page'] = "1";
            return redirect('/genres');
        }



        return Inertia::render('Settings/Genres', [
            'title' => 'All genres',
            'genres' => $genres,
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
    public function store(Request $request, Genre $genre)
    {
        $request->validate([
            'name' => 'required|unique:writers|string|max:255',
        ]);

        $data = $request->name;

        //dd($data);

        try {
            DB::beginTransaction();

            Genre::firstOrCreate(['name'=>$data]);

            DB::commit();
        } catch (\Exception $exception) {
            DB::rollBack();
            abort(500);
        }

        $genre = Genre::orderBy('created_at', 'desc')->take(1)->get();

        $genre = $genre->toArray()[0];

        //dd($writer);

        setcookie("messageSettings", '#' . $genre['id'] .  ' : ' . $genre['name'] . ' - genre was successfully created', time() + 10);

        return redirect()->route('genres.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(Genre $genre)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Genre $genre)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Genre $genre)
    {
        $request->validate([
            'name' => 'required|unique:writers|string|max:255',
        ]);

        $data = $request->name;
        //dd($data);
        $dataUpdate = ['name' => $data];

        $genre->update($dataUpdate);

        setcookie("messageSettings", '#' . $genre['id'] .  ' : ' . $genre['name'] . ' - genre was successfully updated', time() + 10);

        return redirect()->route('genres.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Genre $genre)
    {
        $genre->delete();

        setcookie("messageSettings", '#' . $genre['id'] .  ' : ' . $genre['name'] . ' - genre was successfully deleted', time() + 10);

        return redirect()->back();
    }
}
