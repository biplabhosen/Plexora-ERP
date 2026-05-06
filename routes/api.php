<?php

use App\Http\Controllers\Api\SupportBotController;
use Illuminate\Support\Facades\Route;

Route::post('/support/chat', SupportBotController::class)->name('api.support.chat');
