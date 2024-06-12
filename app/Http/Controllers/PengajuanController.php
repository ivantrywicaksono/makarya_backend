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
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'template_doc' => 'nullable|file|mimes:pdf,doc,docx',
            'pengajuan_doc' => 'required|file|mimes:pdf,doc,docx',
            'status' => 'nullable|string',
            'artist_id' => 'required|integer',
        ]);

        $templateDocPath = $request->file('template_doc') ? $request->file('template_doc')->store('template', 'public') : null;
        $pengajuanDocPath = $request->file('pengajuan_doc')->store('pengajuan', 'public');

        try {
            $pengajuan = Pengajuan::create([
                'name' => $request->name,
                'description' => $request->description,
                'template_doc' => $templateDocPath,
                'pengajuan_doc' => $pengajuanDocPath,
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
    public function show($id)
    {
        $pengajuan = Pengajuan::find($id);

        if (!$pengajuan) {
            return response()->json([
                'message' => 'Pengajuan tidak ditemukan'
            ], 404);
        }

        return response()->json($pengajuan, 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $pengajuan = Pengajuan::find($id);

        if (!$pengajuan)
        
        
        {
            return response()->json([
                'message' => 'Pengajuan tidak ditemukan'
            ], 404);
        }

        // $request->validate([
        //     'name' => 'required|string|max:255',
        //     'description' => 'nullable|string',
        //     'template_doc' => 'nullable|file|mimes:pdf,doc,docx',
        //     'pengajuan_doc' => 'required|file|mimes:pdf,doc,docx',
        // ]);

        $templateDocPath = $pengajuan->template_doc;
        if ($request->hasFile('template_doc')) {
            // Delete the old file if exists
            if ($templateDocPath) {
                Storage::disk('public')->delete($templateDocPath);
            }
            $templateDocPath = $request->file('template_doc')->store('template', 'public');
        }

        $pengajuanDocPath = $pengajuan->pengajuan_doc;
        if ($request->hasFile('pengajuan_doc')) {
            // Delete the old file if exists
            if ($pengajuanDocPath) {
                Storage::disk('public')->delete($pengajuanDocPath);
            }
            $pengajuanDocPath = $request->file('pengajuan_doc')->store('pengajuan', 'public');
        }

        $pengajuan->update([
            'name' => $request->name,
            'description' => $request->description,
            'template_doc' => $templateDocPath,
            'pengajuan_doc' => $pengajuanDocPath
        ]);

        return response()->json([
            'status'=>200,
            'student'=>'student updated successfully'
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $pengajuan = Pengajuan::find($id);

        if (!$pengajuan) {
            return response()->json([
                'message' => 'Pengajuan tidak ditemukan'
            ], 404);
        }

        if ($pengajuan->template_doc) {
            Storage::disk('public')->delete($pengajuan->template_doc);
        }
        if ($pengajuan->pengajuan_doc) {
            Storage::disk('public')->delete($pengajuan->pengajuan_doc);
        }

        $pengajuan->delete();

        return response()->json(['message' => 'Pengajuan deleted successfully'], 200);
    }
}
