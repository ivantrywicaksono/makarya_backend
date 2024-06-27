<?php

namespace App\Http\Controllers;

use App\Models\Artist;
use Illuminate\Http\Request;

class ArtistController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(int $user_id)
    {
        $artist = Artist::where('user_id', $user_id)->first();
        return json_encode($artist);
    }
    public function get(int $id)
    {
        $artist = Artist::find($id);
        return json_encode($artist);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, int $user_id)
    {
        $updatedData = [
            'name' => $request->name,
            'description' => $request->description,
            'phone_number' => $request->phone_number,
        ];

        if ($request->hasFile('image') || !empty($request->image)) {
            $imagePath = $request->image;
            // $request->file('image')->store('profile', 'public');
            $updatedData['image'] = $imagePath;
        }

        $artist = Artist::where('user_id', $user_id)->first();
        if(!$artist) {
            return response()->json([
                    'message' => 'Seniman tidak ditemukan'
                ], 404
            );
        }

        $artist->update($updatedData);

        return $artist;
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Artist $artist)
    {
        //
    }
}
