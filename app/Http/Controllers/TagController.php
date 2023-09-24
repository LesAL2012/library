<?php

namespace App\Http\Controllers;

use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;

class TagController extends Controller
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

        $tags=Tag::select(
            'id',
            'name',
        )
        ->withCount('books')
        ->orderBy('updated_at', 'DESC')
        ->paginate($paginate);

        //dd($writers);

        $count_page = count($tags->items());
        if ($count_page == 0 ||  $_GET['page'] = "0") {
            $_GET['page'] = "1";
            return redirect('/tags');
        }



        return Inertia::render('Settings/Tags', [
            'title' => 'All tags',
            'tags' => $tags,
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
    public function store(Request $request, Tag $tag)
    {
        $request->validate([
            'name' => 'required|unique:writers|string|max:255',
        ]);

        $data = $request->name;

        //dd($data);

        try {
            DB::beginTransaction();

            Tag::firstOrCreate(['name'=>$data]);

            DB::commit();
        } catch (\Exception $exception) {
            DB::rollBack();
            abort(500);
        }

        $tag = Tag::orderBy('created_at', 'desc')->take(1)->get();

        $tag = $tag->toArray()[0];

        //dd($writer);

        setcookie("messageSettings", '#' . $tag['id'] .  ' : ' . $tag['name'] . ' - tag was successfully created', time() + 10);

        return redirect()->route('tags.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(Tag $tag)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Tag $tag)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Tag $tag)
    {
        $request->validate([
            'name' => 'required|unique:writers|string|max:255',
        ]);

        $data = $request->name;
        //dd($data);
        $dataUpdate = ['name' => $data];

        $tag->update($dataUpdate);

        setcookie("messageSettings", '#' . $tag['id'] .  ' : ' . $tag['name'] . ' - tag was successfully updated', time() + 10);

        return redirect()->route('tags.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Tag $tag)
    {
        $tag->delete();

        setcookie("messageSettings", '#' . $tag['id'] .  ' : ' . $tag['name'] . ' - tag was successfully deleted', time() + 10);

        return redirect()->back();
    }
}
