<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;


class PackageController extends Controller
{
    public function __invoke()
    {
        return Inertia::render('Packages/Index', ['title' => 'Packages']);
    }
}
