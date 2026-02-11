<?php

use App\Http\Controllers\Api\PaperWebhookController;
use Illuminate\Support\Facades\Route;

//Route::get('/', function () {
//    return view('welcome');
//});
use App\Http\Controllers\ClientController;


Route::get('/', [ClientController::class, 'index'])->name('client.login');
Route::post('/check', [ClientController::class, 'check'])->name('client.check');
Route::get('/dashboard/{customer}', [ClientController::class, 'dashboard'])->name('client.dashboard');

Route::post('/paper-webhook', [PaperWebhookController::class, 'handle']);
Route::get('/invoice/{id}/bayar', [ClientController::class, 'halamanBayar'])->name('client.bayar');