<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Payment;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Str;
use App\Models\User;
use App\Models\Classes;
use App\Models\SppPlan;

class PaymentController extends Controller
{
    private $menu = 'payment';

    public function index(Request $request)
    {
        $query = Payment::with(['siswa.class', 'spp'])->latest();

        if ($request->filled('month')) {
            $query->where('paid_month', intval($request->month));
        }

        $datas = $query->get();

        // Ambil kelas dan jurusan dari tabel classes
        $kelasList = Classes::select('name')->distinct()->pluck('name');
        $jurusanList = Classes::select('jurusan')->distinct()->pluck('jurusan');

        $menu = $this->menu;

        return view('pages.admin.payment.index', compact('menu', 'datas', 'kelasList', 'jurusanList'));
    }



    public function create()
    {
        $siswa = User::where('role', 'siswa')->get();
        $spp = SppPlan::all();
        $menu = $this->menu;

        return view('pages.admin.payment.create', compact('menu', 'siswa', 'spp'));
    }
    public function konfirmasi($id)
    {
        $data = Payment::find($id);
        $data->status = 'paid';
        $data->paid_at = now();
        $data->save();

        return redirect()->route('payment.index')->with('success', 'Payment confirmed successfully');
    }

    public function store(Request $request)
    {
        $request->validate([
            'siswa_id' => 'required|exists:users,id',
            'spp_id' => 'required|exists:spp_plans,id',
            'paid_month' => 'nullable|integer|min:1|max:12',
            'amount' => 'required|numeric|min:0',
            'status' => 'required|in:paid,unpaid',
        ]);

        $orderId = 'PYMT-' . time() . '-' . rand(1000, 9999);

        $sppPlan = SppPlan::findOrFail($request->spp_id);

        $data = [
            'siswa_id' => $request->siswa_id,
            'spp_id' => $request->spp_id,
            'paid_month' => $request->paid_month ?? null,
            'paid_year' => $sppPlan->year,
            'amount' => $request->amount,
            'status' => $request->status,
            'order_id' => $orderId,
            'paid_at' => $request->status === 'paid' ? now() : null,
        ];

        Payment::create($data);

        return redirect()
            ->route('payment.index')
            ->with('success', 'Payment created successfully');
    }


    public function destroy($id)
    {
        $data = Payment::find($id);
        $data->delete();

        return redirect()->route('payment.index')->with('message', 'Data guru berhasil dihapus.');
    }

    public function exportPdf(Request $request)
    {
        $kelas = $request->kelas;
        $jurusan = $request->jurusan;

        // Sudah membayar
        $sudahBayar = Payment::with(['siswa.class'])
            ->whereHas('siswa.class', function ($query) use ($kelas, $jurusan) {
                $query->where('name', $kelas)
                    ->where('jurusan', $jurusan);
            })
            ->where('status', 'paid')
            ->get();

        // Belum membayar
        $belumBayar = Payment::with(['siswa.class'])
            ->whereHas('siswa.class', function ($query) use ($kelas, $jurusan) {
                $query->where('name', $kelas)
                    ->where('jurusan', $jurusan);
            })
            ->where('status', 'unpaid')
            ->get();

        $pdf = Pdf::loadView('pages.admin.payment.export_pdf', compact('sudahBayar', 'belumBayar', 'kelas', 'jurusan'))
            ->setPaper('a4', 'portrait');

        return $pdf->stream("Transaksi_{$kelas}_{$jurusan}.pdf");
    }




}
