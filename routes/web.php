<?php

use App\Models\Post;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Inventaris;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\NodinController;
use App\Http\Controllers\MagangController;
use App\Http\Controllers\NaskahController;
use App\Http\Controllers\ResumeController;
use League\CommonMark\Node\Block\Document;
use App\Http\Controllers\KinerjaController;
use App\Http\Controllers\LaporanController;
use App\Http\Controllers\NotulenController;
use App\Http\Controllers\PaparanController;
use App\Http\Controllers\DocumentController;
use App\Http\Controllers\KegiatanController;
use App\Http\Controllers\LapkonisController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PeraturanController;
use App\Http\Controllers\InventarisController;
use App\Http\Controllers\RegisAdminController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/dashboard', [DashboardController::class, 'index'])->middleware('auth');


Route::get('/welcome', function () {
    return view('welcome', [
        "title" => "welcome"
    ]);
});

Route::get('/dokumen/{id}', [PostController::class, 'dokumen']);
Route::get('/dokumen/{id}/edit', [PostController::class, 'ubah']);
Route::put('/dokumen/{id}/edit', [PostController::class, 'ubahData']);
// Route::get('/permintaan/{id}', function($id){
//     return view('dokumen', [
//         'title' => 'dokumen',
//         'post' => Post::find($id)
//     ]);
// });




// Route::get('/inventaris', function (){
//     return view('inventaris', [
//         "title" => "Inventaris Bangsis"
//     ]);
// });


// Route::get('/kegiatan', function (){
//     return view('kegiatan', [
//         "title" => "Laporan Kegiatan"
//     ]);
// });


// Route::get('/resume', function (){
//     return view('laporan.resume.resume', [
//         "title" => "Rapat Resume"
//     ]);
// });


// Route::get('/nodin', function (){
//     return view('nodin', [
//         "title" => "Rapat Nodin"
//     ]);
// });


// Route::get('/notulen', function (){
//     return view('notulen', [
//         "title" => "Rapat Notulen"
//     ]);
// });



// Route::get('/peraturan', function(){
//     return view('peraturan', [
//         "title" => "Digitalisasi Dokumen Peraturan"
//     ]);
// });


// Route::get('/naskah', function(){
//     return view('naskah', [
//         "title" => "Digitalisasi Dokumen Naskah"
//     ]);
// });


// Route::get('/paparan', function(){
    //     return view('paparan', [
        //         "title" => "Digitalisasi Dokumen Paparan"
        //     ]);
        // });
        
        
      
// Route::get('/sisfo', function(){
//     return view('sisfo', [
//         "title" => "Lapkonis Sisfo"
//     ]);
// });

// Route::get('/kinerja',[KinerjaController::class, 'index']);
// Route::get('/kinerja/tambah',[KinerjaController::class, 'create']);
// Route::post('/kinerja/tambah',[KinerjaController::class, 'store']);
// Route::get('/kinerja', function(){
//     return view('kinerja', [
//         "title" => "Laporan Kinerja"
//     ]);
// });


// Route::get('/magang', function(){
//     return view('magang', [
//         "title" => "Magang Mahasiswa"
//     ]);
// });

Route::get('/login', [LoginController::class, 'index'])->name('login')->middleware('guest');
Route::post('/login', [LoginController::class, 'authenticate']);
Route::get('/logout', [LoginController::class, 'logout']);

Route::get('/register', [RegisterController::class, 'index']);
Route::post('/register', [RegisterController::class, 'store']);

Route::group(['middleware' => 'user'], function () {
    Route::get('/permintaan', [PostController::class, 'index'])->middleware('auth');
    Route::delete('/permintaan/{id}', [PostController::class, 'destroy'])->middleware('auth');
    Route::get('/data', [PostController::class, 'data'])->middleware('auth');
    Route::post('/data', [PostController::class, 'store']);
});

Route::group(['middleware' => 'admin'], function () {
    // Rute atau kontroler yang hanya dapat diakses oleh admin
    // Route::livewire('/search-users', 'search-users')->name('search-users');
    Route::get('/', [DashboardController::class, 'index'])->middleware('auth');

    Route::get('/posts', [PostController::class, 'lihat']);
    Route::get('/posts/search', [PostController::class, 'search']);
    Route::get('/kelola', [PostController::class, 'edit']);
    Route::delete('/kelola/{id}', [PostController::class, 'destroy']);
    Route::put('/kelola/{id}/edit', [PostController::class, 'update']);

    Route::get('/inventaris', [InventarisController::class, 'index']);
    Route::get('/inventaris/{id}/edit', [InventarisController::class, 'edit']);
    Route::put('/inventaris/{id}/edit', [InventarisController::class, 'update']);
    Route::delete('/inventaris/{id}', [InventarisController::class, 'destroy']);
    Route::get('/inventaris/search', [InventarisController::class, 'search']);
    Route::get('/inventaris-input', [InventarisController::class, 'data']);
    Route::post('/inventaris-input', [InventarisController::class, 'store']);

    Route::get('/lapkonis',[LapkonisController::class, 'index']);
    Route::get('/lapkonis/lihat/{id}',[LapkonisController::class, 'show']);
    Route::get('/lapkonis/{id}/edit',[LapkonisController::class, 'edit']);
    Route::put('/lapkonis/{id}/edit',[LapkonisController::class, 'update']);
    Route::delete('/lapkonis/{id}',[LapkonisController::class, 'destroy']);
    Route::get('/lapkonis/search',[LapkonisController::class, 'search']);
    Route::get('/lapkonis/tambah',[LapkonisController::class, 'create']);
    Route::post('/lapkonis/tambah',[LapkonisController::class, 'store']);  

    Route::get('/magang',[MagangController::class, 'index']);
    Route::get('/magang/{id}/edit',[MagangController::class, 'edit']);
    Route::put('/magang/{id}/edit',[MagangController::class, 'update']);
    Route::delete('/magang/{id}',[MagangController::class, 'destroy']);
    Route::get('/magang/search',[MagangController::class, 'search']);
    Route::get('/magang/tambah',[MagangController::class, 'create']);
    Route::post('/magang/tambah',[MagangController::class, 'store']); 


    Route::get('/kegiatan',[KegiatanController::class, 'index']);
    Route::get('/kegiatan/{id}/edit',[KegiatanController::class, 'edit']);
    Route::put('/kegiatan/{id}/edit',[KegiatanController::class, 'update']);
    Route::delete('/kegiatan/{id}',[KegiatanController::class, 'destroy']);
    Route::get('/kegiatan/search',[KegiatanController::class, 'search']);
    Route::get('/kegiatan/tambah',[KegiatanController::class, 'create']);
    Route::post('/kegiatan/tambah',[KegiatanController::class, 'store']);
    Route::get('/kegiatan/lihat/{id}',[KegiatanController::class, 'show']);


    Route::get('/resume',[ResumeController::class, 'index']);
    Route::get('/resume/lihat/{id}',[ResumeController::class, 'show']);
    Route::get('/resume/{id}/edit',[ResumeController::class, 'edit']);
    Route::put('/resume/{id}/edit',[ResumeController::class, 'update']);
    Route::delete('/resume/{id}',[ResumeController::class, 'destroy']);
    Route::get('/resume/search',[ResumeController::class, 'search']);
    Route::get('/resume/tambah',[ResumeController::class, 'create']);
    Route::post('/resume/tambah',[ResumeController::class, 'store']);


    Route::get('/notulen',[NotulenController::class, 'index']);
    Route::get('/notulen/lihat/{id}',[NotulenController::class, 'show']);
    Route::delete('/notulen/{id}',[NotulenController::class, 'destroy']);
    Route::get('/notulen/{id}/edit',[NotulenController::class, 'edit']);
    Route::put('/notulen/{id}/edit',[NotulenController::class, 'update']);
    Route::get('/notulen/search',[NotulenController::class, 'search']);
    Route::get('/notulen/tambah',[NotulenController::class, 'create']);
    Route::post('/notulen/tambah',[NotulenController::class, 'store']);


    Route::get('/nodin',[NodinController::class, 'index']);
    Route::get('/nodin/lihat/{id}',[NodinController::class, 'show']);
    Route::delete('/nodin/{id}',[NodinController::class, 'destroy']);
    Route::get('/nodin/{id}/edit',[NodinController::class, 'edit']);
    Route::put('/nodin/{id}/edit',[NodinController::class, 'update']);
    Route::get('/nodin/search',[NodinController::class, 'search']);
    Route::get('/nodin/tambah',[NodinController::class, 'create']);
    Route::post('/nodin/tambah',[NodinController::class, 'store']);


    Route::get('/peraturan',[PeraturanController::class, 'index']);
    Route::delete('/peraturan/{id}',[PeraturanController::class, 'destroy']);
    Route::get('/peraturan/{id}/edit',[PeraturanController::class, 'edit']);
    Route::put('/peraturan/{id}/edit',[PeraturanController::class, 'update']);
    Route::get('/peraturan/search',[PeraturanController::class, 'search']);
    Route::get('/peraturan/tambah',[PeraturanController::class, 'create']);
    Route::post('/peraturan/tambah',[PeraturanController::class, 'store']);


    Route::get('/naskah',[NaskahController::class, 'index']);
    Route::delete('/naskah/{id}',[NaskahController::class, 'destroy']);
    Route::get('/naskah/{id}/edit',[NaskahController::class, 'edit']);
    Route::put('/naskah/{id}/edit',[NaskahController::class, 'update']);
    Route::get('/naskah/search',[NaskahController::class, 'search']);
    Route::get('/naskah/tambah',[NaskahController::class, 'create']);
    Route::post('/naskah/tambah',[NaskahController::class, 'store']);


    Route::get('/paparan',[PaparanController::class, 'index']);
    Route::delete('/paparan/{id}',[PaparanController::class, 'destroy']);
    Route::get('/paparan/{id}/edit',[PaparanController::class, 'edit']);
    Route::put('/paparan/{id}/edit',[PaparanController::class, 'update']);
    Route::get('/paparan/search',[PaparanController::class, 'search']);
    Route::get('/paparan/tambah',[PaparanController::class, 'create']);
    Route::post('/paparan/tambah',[PaparanController::class, 'store']);

    Route::get('/pengguna', function(Request $request){
        $users = User::where('role', 'admin')->
                        orWhere('role', 'user')->get();
        return view('dashboard.administrator.pengguna.index',[
            'title' => 'Pengguna',
            'cat' => 'user',
            'users' => $users
        ]);
    });
    Route::get('/pengguna/request', [RegisterController::class, 'edit']);
    Route::put('/pengguna/request/{id}/edit', [RegisterController::class, 'update']);
    Route::get('/pengguna/search', [RegisterController::class, 'search']);
    Route::get('/pengguna/tambah', [RegisterController::class, 'index']);
    Route::post('/pengguna/tambah', [RegisterController::class, 'store']);
    Route::get('pengguna/logout', [LoginController::class, 'logout']);
    // Route::get('/pengguna', [RegisAdminController::class, 'index']);
    // Route::delete('/pengguna/{id}', function(User $user){
    //     User::destroy($user->id);
    //     return redirect('/pengguna')->with('success', 'Akun Berhasil di hapus!..');
    // });
    Route::delete('/pengguna/{id}', [RegisterController::class, 'destroy']);
    
    Route::get('/request', function(Post $post){
        return view('dashboard.administrator.request.index',[
            'title' => 'request',
            'posts' => Post::all()
        ]);
    });
    Route::delete('/request/{id}', [PostController::class, 'destroy']);
});


Route::get('/menu', function (){
    return view('dashboard.menu');
});












Route::get('/about', function () {
    return view('home', [
        "nama" => "dzulfikar",
        "email" => "itang@gmail.com"
    ]);
});