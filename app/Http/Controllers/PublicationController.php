<?php

namespace App\Http\Controllers;

use App\Models\Publication;
use Illuminate\Http\Request;

class PublicationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Publication::all();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $publication = Publication::create([
            'description' => $request->description,
            'image' => $request->image,
            'created_at' => now()->toDate(),
        ]);

        return $publication;
    }

    /**
     * Display the specified resource.
     */
    public function show(int $id)
    {
        $publication = Publication::find($id);

        if(!$publication) {
            return response()->json([
                    'message' => 'Publikasi tidak ditemukan'
                ], 404
            );
        }

        return $publication;
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, int $id)
    {
        $publication = Publication::find($id);

        if(!$publication) {
            return response()->json([
                    'message' => 'Publikasi tidak ditemukan'
                ], 404
            );
        }

        $publication->update([
            'description' => $request->description,
        ]);

        return $publication;
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(int $id)
    {
        $publication = Publication::find($id);

        if(!$publication) {
            return response()->json([
                    'message' => 'Publikasi tidak ditemukan'
                ], 404
            );
        }

        $publication->delete();

        return $publication;
    }
}
