<?php

use App\Http\Controllers\AiUsageSyncController;
use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/ai-usage/latest', [AiUsageSyncController::class, 'latest'])
    ->middleware('throttle:120,1')
    ->name('api.ai_usage.latest');

Route::post('/internal/ai-usage/sync', [AiUsageSyncController::class, 'store'])
    ->middleware('throttle:20,1')
    ->name('api.ai_usage.sync');
