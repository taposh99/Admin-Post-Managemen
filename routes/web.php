<?php

use App\Http\Controllers\PostController;
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

Route::get('/', function () {
    return view('welcome');
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
});
// routes/web.php

Route::resource('posts', PostController::class);

Route::get('posts/{post}/review', [PostController::class, 'review'])->middleware('superadmin')->name('posts.review');
Route::post('posts/{post}/approve', [PostController::class, 'approve'])->middleware('superadmin')->name('posts.approve');

// Add routes for post review and approval