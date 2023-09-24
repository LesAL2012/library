<?php

namespace App\Http\Controllers;

use App\Models\Writer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;

class WriterController extends Controller
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

        $writers = Writer::select(
            'id',
            'name',
        )
            ->withCount('books')
            ->orderBy('updated_at', 'DESC')
            ->paginate($paginate);



        //dd($writers);

        $count_page = count($writers->items());
        if ($count_page == 0 ||  $_GET['page'] = "0") {
            $_GET['page'] = "1";
            return redirect('/writers');
        }



        return Inertia::render('Settings/Writers', [
            'title' => 'All writers',
            'writers' => $writers,
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
    public function store(Request $request, Writer $writer)
    {
        $request->validate([
            'name' => 'required|unique:writers|string|max:255',
        ]);

        $data = $request->name;

        //dd($data);

        try {
            DB::beginTransaction();

            Writer::firstOrCreate(['name' => $data]);

            DB::commit();
        } catch (\Exception $exception) {
            DB::rollBack();
            abort(500);
        }

        $writer = Writer::orderBy('created_at')->take(1)->get();

        $writer = $writer->toArray()[0];

        //dd($writer);

        setcookie("messageSettings", '#' . $writer['id'] .  ' : ' . $writer['name'] . ' - writer was successfully created', time() + 10);

        return redirect()->route('writers.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(Writer $writer)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Writer $writer)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Writer $writer)
    {

        $request->validate([
            'name' => 'required|unique:writers|string|max:255',
        ]);

        $data = $request->name;

        $dataUpdate = ['name' => $data];

        $writer->update($dataUpdate);

        setcookie("messageSettings", '#' . $writer['id'] .  ' : ' . $writer['name'] . ' - writer was successfully updated', time() + 10);

        return redirect()->route('writers.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Writer $writer)
    {
        $writer->delete();

        setcookie("messageSettings", '#' . $writer['id'] .  ' : ' . $writer['name'] . ' - writer was successfully deleted', time() + 10);

        return redirect()->back();
    }
}
