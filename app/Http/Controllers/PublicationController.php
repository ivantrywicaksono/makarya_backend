<?php

namespace App\Http\Controllers;

use App\Models\Publication;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;

class PublicationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // $publications = Publication::all();
        $publications = Publication::withCount('likes', 'comments')->get();
        $publications = $publications->map(function ($p) {
            $p->artist;
            $p->comments;
            $p->comments_count;
            $p->likes_count;
            return $p;
        });

        return $publications;
    }

    public function getAllByArtistId(int $artist_id)
    {
        $publications = Publication::where('artist_id', $artist_id)->get();
        $publications = $publications->map(function ($p) {
            $p->artist;
            $p->comments;
            $p->comments_count;
            $p->likes_count;
            return $p;
        });

        return $publications;
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('publication', 'public');
        }

        $publication = Publication::create([
            'description' => $request->description,
            'image' => $imagePath,
            'created_at' => now()->toDate(),
            'artist_id' => $request->artist_id,
        ]);

        $publication->artist;

        return json_encode($publication);
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

        $publication->artist;
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

    public function popular() {
        $mostLikedAndCommentedPublications = Publication::withCount(['likes', 'comments'])
            ->orderBy(DB::raw('likes_count + comments_count'), 'desc')
            ->first();

        $mostLikedAndCommentedPublications->artist;
        $mostLikedAndCommentedPublications->comments;

        return response()->json($mostLikedAndCommentedPublications);
    }
}
