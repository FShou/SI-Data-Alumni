<?php

namespace App\Http\Controllers;

use App\Models\Alumni;
use Illuminate\Http\Request;
use App\Models\Perusahaan;
class AlumniController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        // Validasi Request
        $request->validate([
            'nim' => 'required',
            'nama' => 'required',
        ]);


        $perusahaan= Perusahaan::firstOrCreate(
            ['nama_perusahaan' => $request->nama_perusahaan]
        );

        $alumni = new Alumni() ;
        $alumni->nim = ucfirst($request->nim);
        $alumni->nama = $request->nama;
        $alumni->kode_prodi = substr($alumni->nim, 0, 3);
        if ($perusahaan) {
            $alumni->kode_perusahaan = $perusahaan->kode_perusahaan;
        } else {
            $alumni->kode_perusahaan = null;
        }
        $alumni->alamat = $request->alamat;
        $alumni->no_telp = $request->no_telp;
        $alumni->email = $request->email;

        $alumni->save();
        return response()->json($alumni, 200);
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
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        // Validasi Request
        $request->validate([
            'nim' => 'required',
        ]);

        $alumni = alumni::find($request->nim);
        if (!$alumni) {
            return response()->json(['message' => 'Alumni Tidak ditemukan'], 404);
        }

        $perusahaan = perusahaan::find($request->kode_perusahaan);
        if (!$perusahaan) {
            $perusahaan = perusahaan::where('nama_perusahaan', $request->nama_perusahaan)->first();
        }
        // Jika perusahaan tidak ditemukan, tambahkan perusahaan baru
        if (!$perusahaan) {
            $perusahaan = perusahaan::create([
                'nama_perusahaan' => $request->nama_perusahaan,
            ]);
        }
        $alumni->nim = ucfirst($request->nim);
        $alumni->nama = $request->nama;
        $alumni->kode_prodi = substr("$request->nim", 0, 2);
        if ($perusahaan) {
            $alumni->kode_perusahaan = $perusahaan->kode_perusahaan;
        } else {
            $alumni->kode_perusahaan = null;
        }
        $alumni->alamat = $request->alamat;
        $alumni->no_telp = $request->no_telp;
        $alumni->email = $request->email;

        $alumni->save();
        return response()->json($alumni, 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
