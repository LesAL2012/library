<?php

namespace App\Http\Controllers\Test;

use App\Models\Writer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;
use App\Http\Controllers\Controller;

class WriterControllerViews extends Controller
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
            ->orderBy('id')
            ->paginate($paginate);



        //dd($writers->toArray()['data']);

        return Inertia::render('Settings/Writers', [
            'title' => 'All writers',
            'writers' => $writers,
        ]);
    }
}
