<?php

use App\Http\Controllers\AdministracijaController;
use App\Http\Controllers\AnalitikaController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\KonferencijaController;
use App\Http\Controllers\LokacijaController;
use App\Http\Controllers\PrijavaController;
use App\Http\Controllers\RadController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect() -> route('konferencija.index');
});

Route::get('login', function(){
    return redirect() -> route('auth.create');
}) -> name('login');

Route::get('signup', function(){
    return redirect() -> route('user.create');
}) -> name('signup');

Route::delete('auth', [AuthController::class, 'destroy']) -> name('logout');

Route::get('/rad/{konferencija}', [RadController::class, 'download']) -> name('rad.download');
Route::get('/rad/{konferencija}/ocjena', [RadController::class, 'ocjena']) -> name('rad.ocjena');
Route::put('/rad/{konferencija}', [RadController::class, 'status'])-> middleware('can:updateStatus,konferencija') -> name('rad.status');



Route::resource('auth', AuthController::class) -> only(['create', 'store']);
Route::resource('konferencija', KonferencijaController::class);
Route::resource('user', UserController::class) -> except(['index', 'show']);
Route::resource('administracija', AdministracijaController::class) -> only('create', 'store', 'edit', 'destroy');
Route::resource('lokacija', LokacijaController::class) -> only('index', 'create', 'store', 'destroy');
Route::resource('konferencija.prijava', PrijavaController::class) -> only('store', 'destroy');
Route::resource('analitika', AnalitikaController::class) -> only('index');