<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\Http\Request;

class EventController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Event::all();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $event = Event::create([
            'name' => $request->name,
            'image' => $request->image,
            'location' => $request->location,
            'date' => $request->date,
            'time' => $request->time,
            'price' => $request->price,
        ]);

        return $event;
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
            'image' => $request->image,
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
