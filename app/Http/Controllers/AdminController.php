<?php

namespace App\Http\Controllers;

use App\Models\Agenda;
use App\Models\Guru;
use App\Models\Siswa;
use App\Models\Student;
use App\Models\InternalPpnpn;
use Illuminate\Http\Request;
use App\Models\Admin;
use Spatie\Activitylog\Models\Activity;
use App\Models\Internal;
use App\Models\Kegiatan;
use App\Models\PesertaKegiatan;
use App\Models\User;
use Carbon\Carbon;

class AdminController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Total Users
        $totalUsers = User::count();
        $siswa = User::count();
        $totalTeachers = User::where('role', 'guru')->count();
        $totalAdmin = User::where('role', 'admin')->count();

        // Monthly user registration data
        $monthlyUsers = [];
        for ($i = 1; $i <= 12; $i++) {
            $monthlyUsers[] = User::whereYear('created_at', now()->year)
                ->whereMonth('created_at', $i)
                ->count();
        }

        // Upcoming events count
        $upcomingEvents = Agenda::where('tgl_kegiatan', '>=', Carbon::today())
            ->where('tgl_kegiatan', '<=', Carbon::today()->addDays(30))
            ->count();

        // Upcoming events list
        $upcomingEventList = Agenda::where('tgl_kegiatan', '>=', Carbon::today())
            ->orderBy('tgl_kegiatan')
            ->take(5)
            ->get();

        // Recent activities (using Spatie Activitylog if available)
        $recentActivities = Agenda::where('tgl_selesai', '>=', Carbon::today())
            ->orderBy('tgl_selesai', 'asc')
            ->take(5)
            ->get();

        // Calendar events
        $events = Agenda::all()->map(function ($event) {
            return [
                'title' => $event->title,
                'start' => $event->tgl_kegiatan . ' ' . $event->jam_mulai,
                'end' => $event->tgl_selesai . ' ' . $event->jam_selesai,
                'description' => $event->description,
                'color' => '#6777ef',
                'textColor' => '#fff'
            ];
        });

        // Data Guru

        return view('pages.admin.dashboard.index', [
            'menu' => 'dashboard',
            'totalUsers' => $totalUsers,
            'totalTeachers' => $totalTeachers,
            'totalAdmin' => $totalAdmin,
            'upcomingEvents' => $upcomingEvents,
            'upcomingEventList' => $upcomingEventList,
            'recentActivities' => $recentActivities,
            'siswa' => $siswa,
            'events' => $events,
            'monthlyUsers' => $monthlyUsers,
        ]);
    }



    // public function getByKegiatan(Request $r)
    // {
    //     // dd($r->all());
    //     try {
    //         $peserta = PesertaKegiatan::where('id_kegiatan', $r->kegiatan_id)->where('no_ktp', $r->nik)->first();
    //         return response()->json([
    //             'status' => $peserta == null ? false : true,
    //             'data' => $peserta
    //         ]);
    //     } catch (\Exception $th) {
    //         return response()->json([
    //             'status' => false,
    //             'data' => $th
    //         ]);
    //     }
    // }

    // public function getByKegiatanUser(Request $r)
    // {
    //     // dd($r->all());
    //     try {
    //         $peserta = PesertaKegiatan::where('id_kegiatan', $r->kegiatan_id)->where('no_ktp', $r->nik)->first();
    //         return response()->json([
    //             'status' => $peserta == null ? false : true,
    //             'data' => $peserta
    //         ]);
    //     } catch (\Exception $th) {
    //         return response()->json([
    //             'status' => false,
    //             'data' => $th
    //         ]);
    //     }
    // }

    // public function jadwal()
    // {
    //     $jadwalInternal = Internal::select('kota', 'jenis', 'deskripsi', 'kegiatan', 'tgl_kegiatan', 'tgl_selesai_kegiatan', 'jam_mulai', 'jam_selesai', 'nama')
    //         ->whereIn('jenis', ['Pendamping Lokakarya', 'Penugasan Pegawai', 'Penugasan PPNPN'])
    //         ->get()
    //         ->groupBy('kegiatan');

    //     $jadwal = $jadwalInternal->map(function ($items, $key) {
    //         $groupedByJenis = $items->groupBy('jenis');
    //         $penugasanPegawai = $groupedByJenis->get('Penugasan Pegawai', collect());
    //         $penugasanPPNPN = $groupedByJenis->get('Penugasan PPNPN', collect());

    //         return [
    //             'kegiatan' => $key,
    //             'deskripsi' => $items->first()->deskripsi,
    //             'tgl_kegiatan' => $items->first()->tgl_kegiatan,
    //             'tgl_selesai_kegiatan' => $items->first()->tgl_selesai_kegiatan,
    //             'jam_mulai' => $items->first()->jam_mulai,
    //             'jam_selesai' => $items->first()->jam_selesai,
    //             'penugasan_pegawai' => $penugasanPegawai->pluck('nama')->unique()->toArray(),
    //             'penugasan_ppnpn' => $penugasanPPNPN->pluck('nama')->unique()->toArray(),
    //         ];
    //     })->values();
    //     // dd($jadwal[46]);
    //     return response()->json([
    //         'jadwal' => $jadwal
    //     ]);
    // }




    /**
     * Show the form for creating a new resource.
     */
    public function profile($id)
    {
        $data = Admin::find($id);
        return view('pages.admin.profile.index', ['menu' => 'profile', 'data' => $data]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function profile_update(Request $request)
    {
        $r = $request->all();
        // $update_nik = Pegawai::where('nama_lengkap', $r['name'])->first();
        // $update->nik();


        // dd( $r['id']);
        $admin = Admin::find($r['id']);
        $user = User::find($r['id']);
        if ($r['password'] != null) {
            $r['password'] = bcrypt($r['password']);
            // dump('ubah password');
        } else {
            unset($r['password']);
        }
        // dd(true);

        $admin->update($r);
        $user->update($r);

        return redirect()->route('dashboard')->with('message', 'update profile');
    }

    // public function getJadwalByPegawai($nik)
    // {
    //     // Ambil jadwal dari Internal hanya untuk pegawai dengan NIK tertentu
    //     // Ambil jadwal dari Internal dengan tiga jenis yang disebutkan
    //     $jadwalInternal = Internal::select('kota', 'jenis', 'deskripsi', 'kegiatan', 'tgl_kegiatan', 'tgl_selesai_kegiatan', 'jam_mulai', 'jam_selesai', 'nama')
    //         ->whereIn('jenis', ['Pendamping Lokakarya', 'Penugasan Pegawai', 'Penugasan PPNPN'])->where('nik', $nik)
    //         ->get();

    //     // Mengembalikan response dalam bentuk JSON
    //     return response()->json([
    //         'jadwal' => $jadwalInternal
    //     ]);
    // }
}
