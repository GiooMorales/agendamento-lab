<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PlaceController;
use App\Http\Controllers\SchedulingController;
use App\Http\Controllers\UserController;




//Login
Route::get('/register', [UserController::class, 'signUp']);
Route::post('/register', [UserController::class, 'register']);
Route::get('/login', [UserController::class, 'signIn'])->name('login');
Route::post('/login', [UserController::class, 'login']);

Route::middleware('auth')->group(function() {

    //Rota inicial
    Route::get('/', function () {
        return view('home');
    });

   //Logout
    Route::get('logout', [UserController::class, 'logout']);

    //Rotas de espaço (Places)
    Route::get('/places', [PlaceController::class, 'index']);
    Route::get('/places/new', [PlaceController::class, 'create']);
    Route::post('/places/new', [PlaceController::class, 'store']);
    Route::delete('/places/{id}', [PlaceController::class, 'destroy']);
    Route::get('/places/{id}/edit', [PlaceController::class, 'edit']);
    Route::put('/places/{id}/edit', [PlaceController::class, 'update']);

    //Rotas de agendamento (Scheduling)
    Route::get('/scheduling', [SchedulingController::class, 'index']);
    Route::post('/scheduling/new', [SchedulingController::class, 'store']); 
});