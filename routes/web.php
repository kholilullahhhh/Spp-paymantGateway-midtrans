<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/
//  User
Route::group(
    ['prefix' => '', 'namespace' => 'App\Http\Controllers\User'],
    function () {
        Route::redirect('/', '/');
        // Dashboard
    
        //         Route::get(
        //             '/',
        //             function () {
        //                 return view('pages.landing.index');
        //             }
        //         )->name('user.index');
    
        // Route::get(
        //     '/',
        //     function () {
        //         return view('pages.landing.index');
        //     }
        // )->name('user.index');
    
        Route::get('/', 'UserController@index')->name('user.index');
        Route::get('/kontak', 'UserController@kontak')->name('user.kontak');
        Route::get('/eksternal', 'UserController@guru')->name('user.guru');

        Route::get('/detail/{jenis}/{id}', 'UserController@detail')->name('user.detail.post');


        Route::get('/pegawai', 'UserController@pegawai')->name('user.pegawai');
        Route::get('/pegawai/form', 'UserController@form_pegawai')->name('user.form_pegawai');
        Route::post('/pegawai/daftar', 'UserController@daftar_pegawai')->name('user.daftar_pegawai');
        Route::get('/pegawai/all', 'UserController@getPenugasanAll')->name('user.pegawai.all');
        Route::get('/pegawai/detail', 'UserController@getPenugasanDetail')->name('user.pegawai.detail');
        Route::get('/pegawai/detailLoka', 'UserController@getPenugasanDetailLoka')->name('user.pegawai.detail.loka');
        Route::get('/pegawai/detailEksternal', 'UserController@getPenugasanDetailEksternal')->name('user.pegawai.detail.eksternal');

        Route::get('/statistik', 'UserController@statistik')->name('user.statistik');
        Route::get('/api/statistics/month/{month}', 'UserController@getMonthStatistics')->name('user.statistik.month');
        Route::get('/api/statistics/activities/{month}', 'UserController@getActivitiesByMonth')->name('user.statistik.month');
        Route::get('/api/statistics/activity/{activityId}/{participantType}', 'UserController@getActivityStatistics')->name('user.statistik.activity');

        Route::get('/eksternal', 'UserController@guru')->name('user.guru');
        Route::get('/eksternal/form/{jenis}', 'UserController@form_guru')->name('user.form_guru');
        Route::post('/eksternal/daftar', 'UserController@daftar_guru')->name('user.daftar_guru');

        Route::get('/kegiatan', 'KegiatanController@index')->name('user.kegiatan');
        Route::get('/kegiatan/cari', 'KegiatanController@cari')->name('user.cari');

        Route::get('/kegiatan/registrasi', 'KegiatanController@regist')->name('user.kegiatan_regist');
        Route::post('/kegiatan/store', 'KegiatanController@store')->name('user.kegiatan_store');

        // response json
        Route::get('/kegiatan/getStatus', 'KegiatanController@getStatus')->name('user.kegiatan.getStatus');
        Route::get('/kegiatan/cariPeserta', 'KegiatanController@cariPeserta')->name('user.kegiatan.cariPeserta');
        Route::get('/kegiatan/peserta', 'KegiatanController@getPesertaByKegiatan')->name('user.kegiatan.peserta');
        Route::get('/peserta/detail', 'KegiatanController@getPesertaDetail')->name('user.peserta.detail');

        // trace pesrta dari kegiatan sebelum nya
        Route::get('/peserta/cekData', 'KegiatanController@cekDataPeserta')->name('user.peserta.cekData');

        Route::get('/print/absensi-peserta', 'KegiatanController@printAbsensiPeserta')->name('print.absensi.peserta');
        Route::get('/print/registrasi-peserta', 'KegiatanController@fprintRegistrasiPeserta')->name('print.registrasi.peserta');
        Route::get('/print/absensi-panitia', 'KegiatanController@printAbsensiPanitia')->name('print.absensi.panitia');
        Route::get('/print/absensi-narasumber', 'KegiatanController@printAbsensiNarasumber')->name('print.absensi.narasumber');

        Route::get('/print/absensi-tp', 'KegiatanController@printAbsensiTp')->name('print.absensi.tp');
        Route::get('/print/absensi-tkp', 'KegiatanController@printAbsensiTkp')->name('print.absensi.tkp');
        Route::get('/print/absensi-stk', 'KegiatanController@printAbsensiStk')->name('print.absensi.stk');
        Route::get('/print/absensi-pgw', 'KegiatanController@printAbsensiPgw')->name('print.absensi.pgw');
    }
);

// Route::get('/', function () {
//     return view('welcome');
// });

Route::group(
    ['prefix' => '', 'namespace' => 'App\Http\Controllers', 'middleware' => 'ValidasiUser'],
    function () {
        Route::redirect('/admin', 'dashboard/');
        // Dashboard
        Route::prefix('dashboard')->group(function () {

            // Root
            Route::get('/', 'AdminController@index')->name('dashboard');
            Route::get('/jadwalKegiatan', 'AdminController@jadwal')->name('dashboard.jadwal');
            Route::get('/jadwalKegiatan/{nik}', 'AdminController@getJadwalByPegawai')->name('dashboard.jadwal.getByPegawai');

            Route::get('/getByKegiatan', 'AdminController@getByKegiatan')->name('dashboard.jadwal.getByKegiatan')->withoutMiddleware(['ValidasiUser']);
            Route::get('/getByKegiatanUser', 'AdminController@getByKegiatanUser')->name('dashboard.jadwal.getByKegiatanUser')->withoutMiddleware(['ValidasiUser']);

            // Profile User yang Login
            Route::get('/profile/{id}', 'AdminController@profile')->name('profile.index');
            Route::put('/profile/update', 'AdminController@profile_update')->name('profile.update');

            Route::get('/fetch-sekolah', ['GuruController@index', 'fetchSekolah'])->name('fetchSekolah');

            // Guru
            // Route::prefix('guru')->group(function () {
            //     Route::get('/', 'guruController@index')->name('guru.index');
            //     Route::get('/create', 'guruController@create')->name('guru.create');
            //     Route::post('/store', 'guruController@store')->name('guru.store');
            //     Route::get('/show', 'guruController@showguru')->name('admin.guru.detail');
            //     Route::get('/edit/{id}', 'guruController@edit')->name('guru.edit');
            //     Route::put('/update', 'guruController@update')->name('guru.update');
            //     Route::post('/hapus/{id}', 'guruController@destroy')->name('guru.hapus');

            // });

            // Siswa
            Route::prefix('siswa')->group(function () {
                Route::get('/', 'SiswaController@index')->name('siswa.index');
                Route::get('/create', 'SiswaController@create')->name('siswa.create');
                Route::post('/store', 'SiswaController@store')->name('siswa.store');
                Route::get('/edit/{id}', 'SiswaController@edit')->name('siswa.edit');
                Route::put('/update', 'SiswaController@update')->name('siswa.update');
                // Route::post('/hapus/{id}', 'SiswaController@destroy')->name('siswa.hapus');
                Route::delete('/hapus/{id}', 'SiswaController@destroy')->name('siswa.hapus');
            });

            // spp
            Route::prefix('spp')->group(function () {
                Route::get('/', 'SppController@index')->name('spp.index');
                Route::get('/create', 'SppController@create')->name('spp.create');
                Route::post('/store', 'SppController@store')->name('spp.store');
                Route::get('/edit/{id}', 'SppController@edit')->name('spp.edit');
                Route::put('/update', 'SppController@update')->name('spp.update');
                Route::delete('/hapus/{id}', 'SppController@destroy')->name('spp.hapus');
            });

            // Kelas
            Route::prefix('kelas')->group(function () {
                Route::get('/', 'KelasController@index')->name('kelas.index');
                Route::get('/create', 'KelasController@create')->name('kelas.create');
                Route::post('/store', 'KelasController@store')->name('kelas.store');
                Route::get('/edit/{id}', 'KelasController@edit')->name('kelas.edit');
                Route::put('/update', 'KelasController@update')->name('kelas.update');
                Route::delete('/hapus/{id}', 'KelasController@destroy')->name('kelas.hapus');
            });


            // Akun
            Route::prefix('akun')->group(function () {
                Route::get('/', 'AkunController@index')->name('akun.index');
                Route::get('/create', 'AkunController@create')->name('akun.create');
                Route::post('/store', 'AkunController@store')->name('akun.store');
                Route::post('/regis', 'AkunController@regis')->name('akun.regis');
                Route::get('/edit/{id}', 'AkunController@edit')->name('akun.edit');
                Route::put('/update', 'AkunController@update')->name('akun.update');
                Route::post('/hapus/{id}', 'AkunController@destroy')->name('akun.hapus');
            });


            // // jadwal
            // Route::prefix('jadwal')->group(function () {
            //     Route::get('/', 'JadwalController@index')->name('jadwal.index');
            //     Route::get('/create', 'JadwalController@create')->name('jadwal.create');
            //     Route::post('/store', 'JadwalController@store')->name('jadwal.store');
            //     Route::get('/edit/{id}', 'JadwalController@edit')->name('jadwal.edit');
            //     Route::put('/update', 'JadwalController@update')->name('jadwal.update');
            //     Route::post('/hapus/{id}', 'JadwalController@destroy')->name('jadwal.hapus');
            // });

            // Kegiatan
            Route::prefix('kegiatan')->group(function () {
                Route::get('/', 'kegiatanController@index')->name('kegiatan.index');
                Route::get('/create', 'kegiatanController@create')->name('kegiatan.create');
                Route::post('/store', 'kegiatanController@store')->name('kegiatan.store');
                Route::get('/edit/{id}', 'kegiatanController@edit')->name('kegiatan.edit');
                Route::put('/update', 'kegiatanController@update')->name('kegiatan.update');
                Route::post('/hapus/{id}', 'kegiatanController@destroy')->name('kegiatan.hapus');
            });

            // Peserta Kegiatan
            Route::prefix('peserta')->group(function () {
                Route::get('/', 'PesertaKegiatanController@index')->name('peserta.index');
                Route::get('/create', 'PesertaKegiatanController@create')->name('peserta.create');
                Route::post('/store', 'PesertaKegiatanController@store')->name('peserta.store');
                Route::get('/edit/{id}', 'PesertaKegiatanController@edit')->name('peserta.edit');
                Route::put('/update', 'PesertaKegiatanController@update')->name('peserta.update');
                Route::post('/hapus/{id}', 'PesertaKegiatanController@destroy')->name('peserta.hapus');
                Route::get('/cetak/{id}', 'PesertaKegiatanController@cetak')->name('peserta.cetak');
                Route::get('/cetakByUser/{id}', 'PesertaKegiatanController@cetakByUser')->name('peserta.cetakByUser')->withoutMiddleware(['ValidasiUser']);
                Route::get('/export/{id_kegiatan}', 'PesertaKegiatanController@export')->name('peserta.export');

            });


            // Master Jabatan Pegawai 
            Route::prefix('kependudukan')->group(function () {
                Route::get('/', 'KependudukanController@index')->name('kependudukan.index');
                Route::get('/create', 'KependudukanController@create')->name('kependudukan.create');
                Route::post('/store', 'KependudukanController@store')->name('kependudukan.store');
                Route::get('/edit/{id}', 'KependudukanController@edit')->name('kependudukan.edit');
                Route::put('/update', 'KependudukanController@update')->name('kependudukan.update');
                Route::post('/hapus/{id}', 'KependudukanController@hapus')->name('kependudukan.hapus');
                Route::get('/cetak/{id}', 'KependudukanController@cetak')->name('kependudukan.cetak');
            });


            // Agenda
            Route::prefix('agenda')->group(function () {
                Route::get('/', 'AgendaController@index')->name('agenda.index');
                Route::get('/create', 'AgendaController@create')->name('agenda.create');
                Route::post('/store', 'AgendaController@store')->name('agenda.store');
                Route::get('/edit/{id}', 'AgendaController@edit')->name('agenda.edit');
                Route::put('/update', 'AgendaController@update')->name('agenda.update');
                Route::post('/hapus/{id}', 'AgendaController@destroy')->name('agenda.hapus');
            });

            // Tema
            Route::prefix('tema')->group(function () {
                Route::get('/', 'TemaController@index')->name('tema.index');
                Route::get('/create', 'TemaController@create')->name('tema.create');
                Route::post('/store', 'TemaController@store')->name('tema.store');
                Route::get('/edit/{id}', 'TemaController@edit')->name('tema.edit');
                Route::put('/update', 'TemaController@update')->name('tema.update');
                Route::post('/hapus/{id}', 'TemaController@destroy')->name('tema.hapus');
            });

            // Modul
            Route::prefix('modul')->group(function () {
                Route::get('/', 'ModulController@index')->name('modul.index');
                Route::get('/create', 'ModulController@create')->name('modul.create');
                Route::post('/store', 'ModulController@store')->name('modul.store');
                Route::get('/edit/{id}', 'ModulController@edit')->name('modul.edit');
                Route::put('/update', 'ModulController@update')->name('modul.update');
                Route::post('/hapus/{id}', 'ModulController@destroy')->name('modul.hapus');
            });

        });
    }
);

// Auth
Route::group(['prefix' => 'auth', 'namespace' => 'App\Http\Controllers'], function () {
    Route::get('/', 'AuthController@login')->name('login');
    // Route::get('/reset', 'AuthController@reset')->name('reset');
    // Route::get('/reset_password', 'AuthController@reset_password')->name('reset.password');
    Route::post('/login', 'AuthController@login_action')->name('login_action');
    Route::get('/logout', function () {
        Session::flush();
        return redirect()->route(
            'user.index'
        )->with('message', 'sukses logout');
    })->name('logout');
});

