<?php

namespace App\Http\Controllers\Swagger;

use App\Models\Writer;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\Swagger\WriterResource;


/**
 * @OA\Info(
 *     title="Doc API - Writers",
 *     version="1.0"
 * ),
 * @OA\PathItem(
 *     path="/api/swagger/writers"
 * ),
 * @OA\Post(
 *     path="/api/swagger/writers",
 *     summary="Create & Store the writer",
 *     tags={"Writer"},
 *
 *     @OA\RequestBody(
 *         @OA\JsonContent(
 *             allOf={
 *                 @OA\Schema(
 *                     @OA\Property(property="name", type="string", example="Barbozini Gusto Elaff"),
 *                 ),
 *             },
 *         ),
 *     ),
 *
 *     @OA\Response(
 *         response=200,
 *         description="Ok",
 *
 *         @OA\JsonContent(
 *             @OA\Property(property="data", type="object",
 *                 @OA\Property(property="id", type="integer", example=35),
 *                 @OA\Property(property="name", type="string", example="Barbozini Gusto Elaff"),
 *             ),
 *         ),
 *
 *     ),
 * ),
 * @OA\Get(
 *     path="/api/swagger/writers",
 *     summary="Index - list of writers",
 *     tags={"Writer"},
 *
 *     @OA\Response(
 *         response=200,
 *         description="Ok",
 *
 *         @OA\JsonContent(
 *             @OA\Property(property="data", type="array", @OA\Items(
 *                 @OA\Property(property="id", type="integer", example=35),
 *                 @OA\Property(property="name", type="string", example="Barbozini Gusto Elaff"),
 *             )),
 *         ),
 *
 *     ),
 * ),
 * @OA\Get(
 *     path="/api/swagger/writers/{writer}",
 *     summary="Show - one writer",
 *     tags={"Writer"},
 *
 *     @OA\Parameter(
 *         description="ID of the writer",
 *         in="path",
 *         name="writer",
 *         required=true,
 *         example=35
 *     ),
 *
 *     @OA\Response(
 *         response=200,
 *         description="Ok",
 *
 *         @OA\JsonContent(
 *             @OA\Property(property="data", type="object",
 *                 @OA\Property(property="id", type="integer", example=35),
 *                 @OA\Property(property="name", type="string", example="Barbozini Gusto Elaff"),
 *             ),
 *         ),
 *
 *     ),
 * ),
 * @OA\Patch(
 *     path="/api/swagger/writers/{writer}",
 *     summary="Update - the writer",
 *     tags={"Writer"},
 *
 *     @OA\Parameter(
 *         description="ID of the writer",
 *         in="path",
 *         name="writer",
 *         required=true,
 *         example=30
 *     ),
 *
 *     @OA\RequestBody(
 *         @OA\JsonContent(
 *             allOf={
 *                 @OA\Schema(
 *                     @OA\Property(property="name", type="string", example="Barbozini Elaff"),
 *                 ),
 *             },
 *         ),
 *     ),
 *
 *     @OA\Response(
 *         response=200,
 *         description="Ok",
 *
 *         @OA\JsonContent(
 *             @OA\Property(property="data", type="object",
 *                 @OA\Property(property="id", type="integer", example=30),
 *                 @OA\Property(property="name", type="string", example="Barbozini Elaff"),
 *             ),
 *         ),
 *
 *     ),
 * ),
 * @OA\Delete(
 *     path="/api/swagger/writers/{writer}",
 *     summary="Delete - the writer",
 *     tags={"Writer"},
 *
 *     @OA\Parameter(
 *         description="ID of the writer",
 *         in="path",
 *         name="writer",
 *         required=true,
 *         example=30
 *     ),
 *
 *     @OA\Response(
 *         response=200,
 *         description="Ok",
 *
 *         @OA\JsonContent(
 *             @OA\Property(property="message", type="string", example="done"),
 *         ),
 *
 *     ),
 * ),
 *
 */
class WriterController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        $writers = Writer::all();


        return WriterResource::collection($writers);

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
    //public function store(WriterStoreRequest $request)
    public function store(Request $request)
    {

        $data = $request->validate([
            'name' => 'required|unique:writers|string|max:255',
        ]);

        $writer = Writer::create($data);

        //return WriterResource::make($writer)->resolve();
        return WriterResource::make($writer);
    }

    /**
     * Display the specified resource.
     */
    public function show(Writer $writer)
    {
        return WriterResource::make($writer);
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

        $data = $request->validate([
            'name' => 'required|unique:writers|string|max:255',
        ]);
        $writer->update($data);
        //$writer = $writer->fresh();
        return WriterResource::make($writer);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Writer $writer)
    {
        $writer->delete();

        return response()->json([
            'message' => 'done'
        ]);
    }
}
