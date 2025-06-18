<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Payment;
use Illuminate\Support\Str;
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
    public function create()
    {
        $siswa = User::where('role', 'siswa')->get();
        $spp = SppPlan::all();
        $menu = $this->menu;

        return view('pages.admin.payment.create', compact('menu', 'siswa', 'spp'));
    }

    public function store(Request $request)
    {
        $orderId = 'PAY-' . strtoupper(Str::random(5));
        $data = $request->all();
        $data['order_id'] = $orderId;

        // Ensure that year is set based on the selected SPP plan
        if ($request->has('spp_id')) {
            $sppPlan = SppPlan::find($request->spp_id);
            $data['year'] = $sppPlan->year; // Set the year from the selected SPP plan
        }

        Payment::create($data);

        return redirect()->route('payment.index')->with('success', 'Payment created successfully');
    }


}
