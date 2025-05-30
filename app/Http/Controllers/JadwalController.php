<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Jadwal;
use App\Models\Modul;
use App\Models\Tema;
use App\Models\Kelas;
use App\Models\Guru;


class JadwalController extends Controller
{
    private $menu = 'jadwal';

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $datas = Jadwal::with(['kelas', 'guru', 'tema', 'modul'])->get();
        $menu = $this->menu;
        return view('pages.admin.jadwal.index', compact('menu', 'datas'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $menu = $this->menu;
        $kelas = Kelas::all();
        $guru = Guru::all();
        $tema = Tema::all();
        $modul = Modul::all();

        return view('pages.admin.jadwal.create', compact('menu', 'kelas', 'guru', 'tema', 'modul'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        
        $r = $request->all();
        // dd($r);

        // Menyimpan data guru
        Jadwal::create($r);

        return redirect()->route('jadwal.index')->with('message', 'Data Jadwal berhasil ditambahkan.');
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $data = Jadwal::findOrFail($id); 
        $kelas = Kelas::all();
        $guru = Guru::all();
        $tema = Tema::all();
        $modul = Modul::all();
        $menu = $this->menu;

        return view('pages.admin.jadwal.edit', compact('data', 'kelas', 'guru','tema','modul', 'menu'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request )
    {
        $r = $request->all();
        $data = Jadwal::find($r['id']);

        // dd($r);
        $data->update($r);

        return redirect()->route('jadwal.index')->with('message', 'Data Jadwal berhasil diperbarui.');
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $data = Jadwal::findOrFail($id);
        $data->delete();

        return response()->json(['message' => 'Data Jadwal berhasil dihapus.']);
    }
}
