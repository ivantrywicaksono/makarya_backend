<?php

namespace App\Http\Controllers;

use App\Models\Pengajuan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

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
        
        try {
            $templateDocPath = $request->file('template_doc')->store('documents');
            $pengajuanDocPath = $request->file('pengajuan_doc')->store('documents');
            $pengajuan = Pengajuan::create([ 
                'id' => $request->id,
                'name' => $request->name,
                'description' => $request->description,
                'template_doc' => $templateDocPath, //$request->template_doc,
                'pengajuan_doc' => $pengajuanDocPath, //$request->pengajuan_doc,
                'status' => $request->status,
                'artist_id' => $request->artist_id,
            ]);

            return response()->json($pengajuan, 201);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
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
