<?php

namespace App\Http\Controllers;
use App\Models\Payment;
use App\Models\Spp;
use Illuminate\Http\Request;
use Midtrans\Config;
use Midtrans\Snap;

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

    public function create($id)
    {
        $payment = Payment::with(['siswa', 'spp'])->findOrFail($id);

        // Verifikasi status pembayaran
        if ($payment->status == 'paid') {
            return redirect()->back()
                ->with('error', 'Pembayaran ini sudah lunas');
        }

        // Verifikasi order_id
        if (empty($payment->order_id)) {
            $payment->order_id = 'PYMT-' . now()->format('YmdHis') . '-' . $payment->id;
            $payment->save();
        }

        // Konfigurasi Midtrans
        Config::$serverKey = config('midtrans.server_key');
        Config::$isProduction = config('midtrans.is_production');
        Config::$isSanitized = config('midtrans.is_sanitized');
        Config::$is3ds = config('midtrans.is_3ds');

        $params = [
            'transaction_details' => [
                'order_id' => $payment->order_id,
                'gross_amount' => $payment->amount,
            ],
            'customer_details' => [
                'first_name' => $payment->siswa->name,
                'email' => auth()->user()->email,
                'phone' => $payment->siswa->n0_hp ?? '081234567890',
            ],
            // 'enabled_payments' => ['gopay', 'bank_transfer', 'credit_card'],
            'expiry' => [
                'start_time' => now()->format('Y-m-d H:i:s O'),
                'unit' => 'hours',
                'duration' => 24, // Kadaluarsa dalam 24 jam
            ],
            'callbacks' => [
                'finish' => route('midtrans.callback')
            ]
        ];

        // Generate Snap Token
        $snapToken = Snap::getSnapToken($params);

        // Update payment data
        $payment->update([
            'snap_token' => $snapToken,
            'status' => 'paid' // Set status ke pending
        ]);

        return view('pages.siswa.payment.checkout', [
            'menu' => 'midtrans',
            'snapToken' => $snapToken,
            'payment' => $payment
        ]);
    }


    // public function store(Request $request, $id)
    // {
    //     $payment = Payment::findOrFail($id);

    //     // Konfigurasi Midtrans
    //     Config::$serverKey = config('midtrans.server_key');
    //     Config::$isProduction = config('midtrans.is_production');
    //     Config::$isSanitized = config('midtrans.is_sanitized');
    //     Config::$is3ds = config('midtrans.is_3ds');

    //     $params = [
    //         'transaction_details' => [
    //             'order_id' => $payment->order_id,
    //             'gross_amount' => $payment->amount,
    //         ],
    //         'customer_details' => [
    //             'first_name' => $payment->siswa->name,
    //             'email' => auth()->user()->email,
    //             'phone' => $payment->siswa->phone ?? '081234567890',
    //         ],
    //         'enabled_payments' => ['gopay', 'bank_transfer', 'credit_card'],
    //         'callbacks' => [
    //             'finish' => route('midtrans.callback')
    //         ]
    //     ];

    //     try {
    //         $snapToken = Snap::getSnapToken($params);
    //         $payment->snap_token = $snapToken;
    //         $payment->save();

    //         return view('pages.siswa.payment.checkout', [
    //             'snapToken' => $snapToken,
    //             'payment' => $payment
    //         ]);

    //     } catch (\Exception $e) {
    //         return redirect()->back()->with('error', 'Pembayaran gagal: ' . $e->getMessage());
    //     }
    // }

    public function callback(Request $request)
    {
        $serverKey = config('midtrans.server_key');
        $hashed = hash("sha512", $request->order_id . $request->status_code . $request->gross_amount . $serverKey);

        if ($hashed == $request->signature_key) {
            if ($request->transaction_status == 'capture' || $request->transaction_status == 'settlement') {
                $payment = Payment::where('order_id', $request->order_id)->first();
                if ($payment) {
                    $payment->status = 'paid';
                    $payment->paid_at = now();
                    $payment->save();

                    // Kirim notifikasi ke siswa/petugas
                    return redirect()->route('midtrans.index')->with('success', 'Pembayaran berhasil');
                }
            }
        }
        // dd($hashed);

        return redirect()->route('midtrans.index')->with('error', 'Pembayaran gagal');
    }

    public function notificationHandler(Request $request)
    {
        // Untuk handle notifikasi server-to-server dari Midtrans
        $notif = new \Midtrans\Notification();

        $transaction = $notif->transaction_status;
        $type = $notif->payment_type;
        $orderId = $notif->order_id;
        $fraud = $notif->fraud_status;

        $payment = Payment::where('order_id', $orderId)->first();

        if (!$payment) {
            return response()->json(['status' => 'error', 'message' => 'Payment not found'], 404);
        }

        if ($transaction == 'capture') {
            if ($type == 'credit_card') {
                if ($fraud == 'challenge') {
                    $payment->status = 'challenge';
                } else {
                    $payment->status = 'paid';
                }
            }
        } elseif ($transaction == 'settlement') {
            $payment->status = 'paid';
            $payment->paid_at = now();
        } elseif ($transaction == 'pending') {
            $payment->status = 'pending';
        } elseif ($transaction == 'deny') {
            $payment->status = 'denied';
        } elseif ($transaction == 'expire') {
            $payment->status = 'expired';
        } elseif ($transaction == 'cancel') {
            $payment->status = 'canceled';
        }

        $payment->save();
        return response()->json(['status' => 'success']);
    }
}