<?php

use App\Jobs\SendEmailJob;
use App\Mail\ContactanosMail;
use Illuminate\Log\Logger;
use Illuminate\Support\Facades\Mail;
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


Route::get('prueba', function () {
    return "Has accedido correctamente a esta ruta";
})->middleware(['auth:sanctum', 'role:user,admin']);

Route::get('soyadmin', function () {
    return "Usted es admin";
})->middleware(['auth:sanctum', 'role:admin']);;

Route::get('contactanos', function(){
    SendEmailJob::dispatchAfterResponse();
    SendEmailJob::dispatch();
    
    return response("Mensaje enviado") ;
})->name('contactanos');