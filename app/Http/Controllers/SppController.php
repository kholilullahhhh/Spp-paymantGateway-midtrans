<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SppPlan;
use App\Models\user;
use App\Models\payment;

class SppController extends Controller
{
    private $menu = 'spp';

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $datas = SppPlan::get();
        $menu = $this->menu;
        return view('pages.admin.spp.index', compact('menu', 'datas'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $menu = $this->menu;
        return view('pages.admin.spp.create', compact('menu'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $r = $request->all();

        // Menyimpan data SPP
        $sppPlan = SppPlan::create($r);

        // Dapatkan semua siswa
        $students = User::where('role', 'siswa')->get();

        // Buat pembayaran untuk setiap siswa
        foreach ($students as $student) {
            Payment::create([
                'siswa_id' => $student->id,
                'spp_id' => $sppPlan->id,
                'paid_year' => $sppPlan->year,
                'amount' => $sppPlan->nominal,
                'status' => 'unpaid', // Status awal unpaid
                'paid_month' => $sppPlan->bulan,
            ]);
        }

        return redirect()->route('spp.index')->with('message', 'Data Spp berhasil ditambahkan dan pembayaran telah dibuat untuk semua siswa.');
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $data = SppPlan::findOrFail($id);
        $menu = $this->menu;

        return view('pages.admin.spp.edit', compact('data', 'menu'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        $r = $request->all();
        $data = SppPlan::find($r['id']);

        // dd($r);
        $data->update($r);

        return redirect()->route('spp.index')->with('message', 'Data Spp berhasil diperbarui.');
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $data = SppPlan::find($id);
        $data->delete();

        return redirect()->route('spp.index')->with('message', 'Data Spp berhasil dihapus.');
    }

}
