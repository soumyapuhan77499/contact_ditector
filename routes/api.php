<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ContactApiController;

Route::post('/save-contact', [ContactApiController::class, 'saveContact']);

