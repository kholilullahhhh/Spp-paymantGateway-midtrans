<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Payment;
use App\Models\User;
use App\Models\SppPlan;

class PaymentController extends Controller
{
    private $menu = 'payment';
    public function index()
    {
        $datas = Payment::with(['siswa', 'spp'])->get();
        $menu = $this->menu;

        return view('pages.admin.payment.index', compact('menu', 'datas'));
    }

}
