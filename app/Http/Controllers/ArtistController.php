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

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, int $user_id)
    {
        $artist = Artist::where('user_id', $user_id)->first();
        $artist->update([

        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Artist $artist)
    {
        //
    }
}
