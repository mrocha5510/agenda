<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\api\contactoController;

Route::get('/contactos',[contactoController::class, 'index']);

Route::get('/contacto/{id}',[contactoController::class, 'get_contacto']);

Route::post('/contacto',[contactoController::class, 'addContacto']);

Route::put('/contacto/{id}',[contactoController::class, 'edit_contacto']);

Route::delete('/contacto/{id}',[contactoController::class, 'delete_contacto']);