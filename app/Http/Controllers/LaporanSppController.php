<?php

namespace App\Http\Controllers;

use App\Exports\LaporanSppExport;
use App\Models\Classes;
use App\Models\Payment;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class LaporanSppController extends Controller
{
    /**
     * Hanya Admin dan Tata Usaha (TU) yang boleh mengakses modul laporan.
     */
    private function authorizeAccess(): void
    {
        if (! in_array(session('role'), ['admin', 'tu'])) {
            abort(403, 'Anda tidak memiliki akses ke halaman ini.');
        }
    }

    private function validateFilters(Request $request): array
    {
        $validated = $request->validate([
            'month' => 'nullable|integer|min:1|max:12',
            'year' => 'nullable|integer|min:2000|max:2100',
            'status' => 'nullable|in:all,lunas,menunggak',
            'class_id' => 'nullable|exists:classes,id',
        ]);

        return [
            'month' => $validated['month'] ?? null,
            'year' => $validated['year'] ?? null,
            'status' => $validated['status'] ?? 'all',
            'class_id' => $validated['class_id'] ?? null,
        ];
    }

    /**
     * Satu sumber query untuk halaman web, Excel, dan PDF.
     */
    private function buildQuery(array $filters): Builder
    {
        return Payment::query()
            ->with(['siswa.class', 'spp'])
            ->when($filters['month'], fn (Builder $q, $month) => $q->where('paid_month', $month))
            ->when($filters['year'], fn (Builder $q, $year) => $q->where('paid_year', $year))
            ->when($filters['class_id'], fn (Builder $q, $classId) => $q->whereHas('siswa', fn (Builder $q2) => $q2->where('class_id', $classId)))
            ->when($filters['status'] === 'lunas', fn (Builder $q) => $q->where('status', Payment::STATUS_LUNAS))
            ->when($filters['status'] === 'menunggak', fn (Builder $q) => $q->where('status', '!=', Payment::STATUS_LUNAS));
    }

    private function buildReport(Request $request): array
    {
        $filters = $this->validateFilters($request);
        $query = $this->buildQuery($filters);

        $totalPemasukan = (float) (clone $query)->where('status', Payment::STATUS_LUNAS)->sum('amount');

        $totalKewajiban = (float) (clone $query)
            ->leftJoin('spp_plans', 'spp_plans.id', '=', 'payments.spp_id')
            ->sum('spp_plans.nominal');

        $totalTunggakan = max($totalKewajiban - $totalPemasukan, 0.0);

        $jumlahLunas = (clone $query)->where('status', Payment::STATUS_LUNAS)->distinct()->count('siswa_id');
        $totalSiswa = (clone $query)->distinct()->count('siswa_id');
        $jumlahBelumLunas = $totalSiswa - $jumlahLunas;
        $jumlahTransaksi = (clone $query)->where('status', Payment::STATUS_LUNAS)->count();

        $payments = (clone $query)
            ->orderByDesc('paid_year')
            ->orderByDesc('paid_month')
            ->orderBy('siswa_id')
            ->get();

        return compact(
            'filters',
            'payments',
            'totalPemasukan',
            'totalKewajiban',
            'totalTunggakan',
            'jumlahLunas',
            'jumlahBelumLunas',
            'jumlahTransaksi'
        );
    }

    public function index(Request $request)
    {
        $this->authorizeAccess();

        $report = $this->buildReport($request);

        return view('laporan.spp', array_merge($report, [
            'menu' => 'laporan',
            'kelasList' => Classes::orderBy('name')->get(['id', 'name', 'jurusan']),
            'tahunList' => Payment::query()->selectRaw('DISTINCT paid_year')->orderByDesc('paid_year')->pluck('paid_year'),
        ]));
    }

    public function exportExcel(Request $request)
    {
        $this->authorizeAccess();

        $filters = $this->validateFilters($request);
        $query = $this->buildQuery($filters);

        return Excel::download(new LaporanSppExport($query), $this->fileName($filters, 'xlsx'));
    }

    public function exportPdf(Request $request)
    {
        $this->authorizeAccess();

        $report = $this->buildReport($request);
        $report['petugas'] = session('name');

        $pdf = Pdf::loadView('laporan.spp-pdf', $report)
            ->setPaper('a4', 'portrait');

        return $pdf->stream($this->fileName($report['filters'], 'pdf'));
    }

    private function fileName(array $filters, string $ext): string
    {
        $year = $filters['year'] ?? 'semua-tahun';
        $month = $filters['month'] ? str_pad((string) $filters['month'], 2, '0', STR_PAD_LEFT) : 'semua-bulan';

        return "laporan-spp-{$year}-{$month}.{$ext}";
    }
}
