<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\FilterCheckController;

Route::get('/filter-check', [FilterCheckController::class, 'check']);
