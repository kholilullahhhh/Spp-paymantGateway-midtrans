<?php

namespace Database\Seeders;

use App\Models\Payment;
use App\Models\SppPlan;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class PaymentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * Membuat pembayaran per siswa per bulan (Januari-Desember 2026) dengan
     * variasi status untuk menguji laporan: lunas, menunggak, dan pending.
     *
     * Skema status per siswa (bulan):
     * - ahmad : 1-12 lunas
     * - budi  : 1-9 lunas, 10 pending, 11-12 belum
     * - citra : 1-4 lunas, 5 pending, 6-12 belum
     * - dedi  : 1-12 lunas
     * - eka   : semua belum
     * - fajar : 7-8 lunas, 9 pending, sisanya belum
     * - gita  : 1-12 lunas
     * - hari  : 1 lunas, 2-12 belum
     */
    public function run(): void
    {
        Payment::where('order_id', 'like', 'PYMT-SEED-%')->delete();

        $map = [
            'ahmad' => ['paid' => range(1, 12), 'pending' => []],
            'budi' => ['paid' => range(1, 9), 'pending' => [10]],
            'citra' => ['paid' => range(1, 4), 'pending' => [5]],
            'dedi' => ['paid' => range(1, 12), 'pending' => []],
            'eka' => ['paid' => [], 'pending' => []],
            'fajar' => ['paid' => [7, 8], 'pending' => [9]],
            'gita' => ['paid' => range(1, 12), 'pending' => []],
            'hari' => ['paid' => [1], 'pending' => []],
        ];

        $plans = SppPlan::where('year', '2026')->get()->keyBy('bulan');

        $students = User::where('role', 'siswa')->get()->keyBy('username');

        foreach ($map as $username => $config) {
            $student = $students->get($username);
            if (! $student) {
                continue;
            }

            for ($bulan = 1; $bulan <= 12; $bulan++) {
                $plan = $plans->get($bulan);
                if (! $plan) {
                    continue;
                }

                $status = in_array($bulan, $config['pending']) ? 'pending' : (in_array($bulan, $config['paid']) ? 'paid' : 'unpaid');

                Payment::create([
                    'siswa_id' => $student->id,
                    'spp_id' => $plan->id,
                    'order_id' => "PYMT-SEED-{$student->nis}-{$bulan}",
                    'paid_month' => $bulan,
                    'paid_year' => $plan->year,
                    'amount' => $plan->nominal,
                    'status' => $status,
                    'paid_at' => $status === 'paid' ? Carbon::create(2026, $bulan, 10, 8, 0, 0) : null,
                ]);
            }
        }
    }
}
