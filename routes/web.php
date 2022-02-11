<?php

use Illuminate\Support\Facades\Route;

Route::post('/news', [\App\Http\Controllers\NewsController::class, 'getNews'])->middleware(['json.force','json.check']);
