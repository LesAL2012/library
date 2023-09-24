<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;


class CategoryController extends Controller
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

        $categories=Category::select(
            'id',
            'name',
        )
        ->withCount('books')
        ->orderBy('updated_at', 'DESC')
        ->paginate($paginate);

        //dd($writers);

        $count_page = count($categories->items());
        if ($count_page == 0 ||  $_GET['page'] = "0") {
            $_GET['page'] = "1";
            return redirect('/categories');
        }



        return Inertia::render('Settings/Categories', [
            'title' => 'All categories',
            'categories' => $categories,
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
    public function store(Request $request, Category $category)
    {
        $request->validate([
            'name' => 'required|unique:writers|string|max:255',
        ]);

        $data = $request->name;

        //dd($data);

        try {
            DB::beginTransaction();

            Category::firstOrCreate(['name'=>$data]);

            DB::commit();
        } catch (\Exception $exception) {
            DB::rollBack();
            abort(500);
        }

        $category = Category::orderBy('created_at', 'desc')->take(1)->get();

        $category = $category->toArray()[0];

        //dd($writer);

        setcookie("messageSettings", '#' .$category['id'] .  ' : ' . $category['name'] . ' - category was successfully created', time() + 10);

        return redirect()->route('categories.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(Category $category)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Category $category)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Category $category)
    {
        $request->validate([
            'name' => 'required|unique:writers|string|max:255',
        ]);

        $data = $request->name;
        //dd($data);
        $dataUpdate = ['name' => $data];

        $category->update($dataUpdate);

        setcookie("messageSettings", '#' . $category['id'] .  ' : ' . $category['name'] . ' - category was successfully updated', time() + 10);

        return redirect()->route('categories.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Category $category)
    {
        $category->delete();

        setcookie("messageSettings", '#' . $category['id'] .  ' : ' . $category['name'] . ' - category was successfully deleted', time() + 10);

        return redirect()->back();
    }
}
