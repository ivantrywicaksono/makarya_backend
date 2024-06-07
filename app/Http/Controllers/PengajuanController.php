<?php

namespace App\Http\Controllers;

use App\Models\Pengajuan;
use Illuminate\Http\Request;

class PengajuanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Pengajuan::all();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $pengajuan = Pengajuan::create([
            'name' => $request->name,
        ]);

        return $pengajuan;
    }

    /**
     * Display the specified resource.
     */
    public function show(int $id)
    {
        $pengajuan = Pengajuan::find($id);

        if(!$pengajuan) {
            return response()->json([
                    'message' => 'Pengajuan tidak ditemukan'
                ], 404
            );
        }

        return $pengajuan;
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, int $id)
    {
        $pengajuan = Pengajuan::find($id);

        if(!$pengajuan) {
            return response()->json([
                    'message' => 'Pengajuan tidak ditemukan'
                ], 404
            );
        }

        $pengajuan->update([
            'name' => $request->name,
        ]);

        return $pengajuan;
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(int $id)
    {
        $pengajuan = Pengajuan::find($id);

        if(!$pengajuan) {
            return response()->json([
                    'message' => 'Pengajuan tidak ditemukan'
                ], 404
            );
        }

        $pengajuan->delete();

        return $pengajuan;
    }
}
