<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\Http\Request;

class EventController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(int $community_id = 0)
    {
        if($community_id > 0) {
            return Event::where('community_id', $community_id)->get();
        }
        return Event::all();
    }

    public function getAllByCommunityId(int $community_id)
    {
        return Event::where('community_id', $community_id)->get();
    }

    public function getLatest()
    {
        return Event::orderBy('date', 'desc')->first();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        if ($request->hasFile('image') || !empty($request->image)) {
            $imagePath = $request->image;
            // $imagePath = $request->file('image')->store('event', 'public');
        }

        $event = Event::create([
            'name' => $request->name,
            // 'image' => $imagePath,
            'image' => $request->image,
            'location' => $request->location,
            'date' => $request->date,
            'time' => $request->time,
            'price' => $request->price,
            'community_id' => $request->community_id,
        ]);

        return json_encode($event);
    }

    /**
     * Display the specified resource.
     */
    public function show(int $id)
    {
        $event = Event::find($id);

        if(!$event) {
            return response()->json([
                    'message' => 'Acara tidak ditemukan'
                ], 404
            );
        }

        return $event;
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, int $id)
    {
        $event = Event::find($id);

        if(!$event) {
            return response()->json([
                    'message' => 'Acara tidak ditemukan'
                ], 404
            );
        }

        $event->update([
            'name' => $request->name,
            'location' => $request->location,
            'date' => $request->date,
            'time' => $request->time,
            'price' => $request->price,
        ]);

        return $event;
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(int $id)
    {
        $event = Event::find($id);

        if(!$event) {
            return response()->json([
                    'message' => 'Acara tidak ditemukan'
                ], 404
            );
        }

        $event->delete();

        return $event;
    }
}
