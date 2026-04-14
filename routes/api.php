<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PembayaranController;

Route::post('/notification', [PembayaranController::class, 'callback']);