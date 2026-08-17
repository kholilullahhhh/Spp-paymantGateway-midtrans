<?php

namespace Database\Seeders;

use App\Models\SppPlan;
use Illuminate\Database\Seeder;

class SppPlanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * Membuat 12 plan SPP untuk tahun 2026.
     * Bulan 1-6 = semester genap, bulan 7-12 = semester ganjil.
     */
    public function run(): void
    {
        $year = '2026';

        for ($bulan = 1; $bulan <= 12; $bulan++) {
            $semester = $bulan <= 6 ? 'genap' : 'ganjil';

            SppPlan::updateOrCreate(
                ['year' => $year, 'bulan' => $bulan],
                [
                    'year' => $year,
                    'bulan' => $bulan,
                    'semester' => $semester,
                    'nominal' => 300000,
                ]
            );
        }
    }
}
