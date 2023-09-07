<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DataSiswa;
use App\Http\Controllers\DataMahasiswa;
use App\Http\Controllers\UserControlController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned  to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    $berita =  App\Models\berita::paginate(1);
    return view('welcome',['berita' => $berita,]);
});
//berita
Route::get('/home/berita', [App\Http\Controllers\beritaController::class,'beritaGet'])->name('home.berita.index');
Route::get('/home/berita/create', [App\Http\Controllers\beritaController::class,'beritaCreate'])->name('home/berita/create');
Route::post('/home/berita-post', [App\Http\Controllers\beritaController::class,'beritaPost'])->name('home.berita.post');
Route::get('/home/berita/edit/{id}', [App\Http\Controllers\beritaController::class, 'beritaEdit'])->name('home.berita.edit');
Route::get('/home/berita/index/delete/{id}',[App\Http\Controllers\beritaController::class,'beritaDel']);

Route::middleware(['guest'])->group(function () {
    Route::view('/', 'halaman_depan/index');
    Route::get('/sesi', [AuthController::class, 'index'])->name('auth');
    Route::post('/sesi', [AuthController::class, 'login']);
    Route::get('/reg', [AuthController::class, 'create'])->name('registrasi');
    Route::post('/reg', [AuthController::class, 'register']);
    Route::get('/verify/{verify_key}', [AuthController::class, 'verify']);
});


Route::middleware(['auth'])->group(function () {
    Route::redirect('/home', '/user');
    Route::get('/admin', [AdminController::class, 'index'])->name('admin')->middleware('userAkses:admin');
    Route::view('admin', 'admin.index')->name('admin');
    Route::get('/user', [UserController::class, 'index'])->name('user')->middleware('userAkses:user');

    //////// SISWA //////
    Route::get('/data_siswa/index', [DataSiswa::class, 'index'])->name('data_siswa.index');
    Route::get('/dasistambah', [DataSiswa::class, 'tambah']);
    Route::get('/dasisedit/{id}', [DataSiswa::class, 'edit']);
    Route::post('/dasishapus/{id}', [DataSiswa::class, 'hapus']);

    //////// GALLERY //////////
    Route::get('/data_gallery', [DataGallery::class, 'index'])->name('data_gallery.index');
    Route::get('/dagaltambah', [DataGallery::class, 'tambah']);
    Route::get('/dagaledit/{id}', [DataGallery::class, 'edit']);
    Route::post('/dagalhapus/{id}', [DataGallery::class, 'hapus']);

    ///////// BERITA //////////
    ///////// BERITA //////////Route::get('/data_berita', [DataBerita::class, 'index'])->name('data_berita.index');
    ///////// BERITA //////////Route::get('/dabertambah', [DataBerita::class, 'tambah']);
    ///////// BERITA //////////Route::get('/daberedit/{id}', [DataBerita::class, 'edit']);
    ///////// BERITA //////////Route::post('/daberhapus/{id}', [DataBerita::class, 'hapus']);

    ///////// GURU /////////////
    Route::get('/data_guru', [DataGuru::class, 'index'])->name('data_guru.index');
    Route::get('/dagurtambah', [DataGuru::class, 'tambah']);
    Route::get('/daguredit/{id}', [DataGuru::class, 'edit']);
    Route::post('/dagurhapus/{id}', [DataGuru::class, 'hapus']);

    Route::get('/usercontrol', [UserControlController::class, 'index'])->name('usercontrol');

    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    // new siswa
    Route::post('/tambahdasis', [DataSiswa::class, 'create']);
    Route::post('/editdasis', [DataSiswa::class, 'change']);

    // new gallery
    Route::post('/tambahdagal', [DataGallery::class, 'create']);
    Route::post('/editdagal', [DataGallery::class, 'change']);

    // new berita
    Route::post('/tambahdaberr', [DataBerita::class, 'create']);
    Route::post('/editdaberr', [DataBerita::class, 'change']);

    // new guru
    Route::post('/tambahdagur', [DataGuru::class, 'create']);
    Route::post('/editdagur', [DataGuru::class, 'change']);

    Route::get('/tambahuc', [UserControlController::class, 'tambah']);
    Route::get('/edituc/{id}', [UserControlController::class, 'edit']);
    Route::post('/hapusuc/{id}', [UserControlController::class, 'hapus']);
    Route::post('/tambahuc', [UserControlController::class, 'create']);
    Route::post('/edituc', [UserControlController::class, 'change']);

    
});
