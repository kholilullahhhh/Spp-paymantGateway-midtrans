<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Student;
use App\Models\Classes;
use App\Models\Kelas;
use App\Models\Guru;

class SiswaController extends Controller
{
    private $menu = 'siswa';

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $datas = Student::with(['kelas', 'payment', 'user'])->get();
        $menu = $this->menu;
        return view('pages.admin.siswa.index', compact('menu', 'datas'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $menu = $this->menu;
        $kelas = Classes::all();
        return view('pages.admin.siswa.create', compact('menu', 'kelas'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        
        $r = $request->all();
        // dd($r);

        // Menyimpan data guru
        Student::create($r);

        return redirect()->route('siswa.index')->with('message', 'Data guru berhasil ditambahkan.');
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $data = Student::findOrFail($id); 
        $kelas = Classes::all();
        $menu = $this->menu;

        return view('pages.admin.siswa.edit', compact('data', 'kelas', 'menu'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request )
    {
        $r = $request->all();
        $data = Student::find($r['id']);

        // dd($r);
        $data->update($r);

        return redirect()->route('siswa.index')->with('message', 'Data guru berhasil diperbarui.');
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $data = Student::findOrFail($id);
        $data->delete();

        return response()->json(['message' => 'Data siswa berhasil dihapus.']);
    }
}
