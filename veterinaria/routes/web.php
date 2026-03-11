<?php

use Illuminate\Support\Facades\Route;
use App\Livewire\Dashboard;
use App\Livewire\Clientes;
use App\Livewire\Mascotas;
use App\Livewire\Vacunas;
use App\Livewire\Consultas;

Route::get('/', Dashboard::class)->name('dashboard');
Route::get('/dashboard', Dashboard::class)->name('dashboard');
Route::get('/clientes', Clientes::class)->name('clientes');
Route::get('/mascotas', Mascotas::class)->name('mascotas');
Route::get('/vacunas', Vacunas::class)->name('vacunas');
Route::get('/consultas', Consultas::class)->name('consultas');
