<?php
 
use App\Http\Controllers\Api\WhoisController;
use Illuminate\Support\Facades\Route;
 
Route::get('/whois', WhoisController::class)->name('whois');