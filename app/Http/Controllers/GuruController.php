<?php

namespace App\Http\Controllers;

use App\Models\guru;
use App\Models\kelas;
use Illuminate\Http\Request;

class GuruController extends Controller
{
    
    private $menu = 'guru';

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $datas = Guru::get();
        $menu = $this->menu;
        return view('pages.admin.guru.index', compact('menu', 'datas'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $menu = $this->menu;
        return view('pages.admin.guru.create', compact('menu'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $r = $request->all();

        $file = $request->file('pas_foto');

        // dd($file->getSize() / 1024);
        // if ($file->getSize() / 1024 >= 512) {
        //     return redirect()->route('guru.create')->with('message', 'size gambar');
        // }

        $foto = $request->file('pas_foto');
        $ext = $foto->getClientOriginalExtension();
        // $r['pas_foto'] = $request->file('pas_foto');

        $nameFoto = date('Y-m-d_H-i-s_') . "." . $ext;
        $destinationPath = public_path('upload/pas_foto');

        $foto->move($destinationPath, $nameFoto);

        $fileUrl = asset('upload/pas_foto/' . $nameFoto);
        // dd($destinationPath);
        $r['pas_foto'] = $nameFoto;
        // dd($r);
        Guru::create($r);


        return redirect()->route('guru.index')->with('message', 'store');
    }

    /**
     * Display the specified resource.
     */
    public function show(Guru $guru)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $data = Guru::find($id);
        $kelas = Kelas::all();
        $menu = $this->menu;

        return view('pages.admin.guru.edit', compact('data', 'menu','kelas'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        $r = $request->all();
        $data = Guru::find($r['id']);

        $foto = $request->file('pas_foto');



        if ($request->hasFile('pas_foto')) {
            if ($foto->getSize() / 1024 >= 512) {
                return redirect()->route('guru.edit', $r['id'])->with('message', 'size gambar');
            }
            $ext = $foto->getClientOriginalExtension();
            $nameFoto = date('Y-m-d_H-i-s_') . "." . $ext;
            $destinationPath = public_path('upload/pas_foto');

            $foto->move($destinationPath, $nameFoto);

            $fileUrl = asset('upload/pas_foto/' . $nameFoto);
            $r['pas_foto'] = $nameFoto;
        } else {
            $r['pas_foto'] = $request->thumbnail_old;
        }

        // dd($r);
        $data->update($r);

        return redirect()->route('guru.index')->with('message', 'update');


    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $data = Guru::find($id);
        $data->delete();
        return response()->json($data);
    }
}
