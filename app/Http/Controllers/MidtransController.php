<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Payment;
use App\Models\User;

class MidtransController extends Controller
{
    public function index()
    {

        $datas = Payment::whereHas('siswa', function ($query) {
            $query->where('nisn', auth()->user()->nisn);
        })->with(['siswa', 'spp'])->latest()->get();

        return view('pages.siswa.payment.index', [
            'menu' => 'midtrans',
            'datas' => $datas
        ]);
    }

}
