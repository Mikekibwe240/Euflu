<?php
use Illuminate\Support\Facades\Route;

Route::get('/admin/equipes/search', [\App\Http\Controllers\Admin\EquipeController::class, 'ajaxSearch'])->name('admin.equipes.ajaxSearch');
