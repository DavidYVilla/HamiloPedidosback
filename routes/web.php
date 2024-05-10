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

Route::get('/', function () {
    //return view('welcome');
    return redirect('/login');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::post('/verificar', [App\Http\Controllers\HomeController::class, 'verificar'])->name('verificarOTP');
Route::get('/reenviar', [App\Http\Controllers\HomeController::class, 'reenviar'])->name('reenviar');

//rutas para negocios
Route::get('/negocios', [App\Http\Controllers\NegociosController::class, 'index']);
Route::get('/negocios/registrar', [App\Http\Controllers\NegociosController::class, 'create']);
Route::post('/negocios/registrar', [App\Http\Controllers\NegociosController::class, 'store']);
Route::get('/negocios/actualizar/{id}', [App\Http\Controllers\NegociosController::class, 'edit']);
Route::put('/negocios/actualizar/{id}', [App\Http\Controllers\NegociosController::class, 'update']);
Route::get('/negocios/estado/{id}', [App\Http\Controllers\NegociosController::class, 'estado']);
Route::get('/negocios/ver/{id}', [App\Http\Controllers\NegociosController::class, 'show']);
