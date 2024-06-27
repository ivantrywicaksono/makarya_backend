<?php

namespace App\Http\Controllers;

use App\Models\Community;
use Illuminate\Http\Request;

class CommunityController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Community::all();
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
        $community = Community::where('user_id', $user_id)->first();
        return json_encode($community);
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
            'group_link' => $request->group_link,
        ];

        if ($request->hasFile('image') || !empty($request->image)) {
            // $imagePath = $request->file('image')->store('profile', 'public');
            $imagePath = $request->image;
            $updatedData['image'] = $imagePath;
        }

        $community = Community::where('user_id', $user_id)->first();
        if(!$community) {
            return response()->json([
                    'message' => 'Komunitas tidak ditemukan'
                ], 404
            );
        }

        $community->update($updatedData);

        return $community;
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Community $community)
    {
        //
    }
}
