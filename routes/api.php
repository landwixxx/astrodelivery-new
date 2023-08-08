<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\IntegrationController;

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

Route::middleware(['verify-token', 'account-expired-api', 'verify-shopkeeper-disabled-api'])->group(function () {

    /**
     * Rota para receber requisições para a API
     * Cunsultar documentação para ver as requisições 
     */
    Route::post('/integracao', [IntegrationController::class, 'run'])->name('integration.run');
    Route::get('/integracao', function () {
        echo 'The GET method is not supported for this route.';
        echo '<br>';
        echo 'Supported methods: POST.';
    });
    Route::put('/integracao', function () {
        echo 'The GET method is not supported for this route.';
        echo '<br>';
        echo 'Supported methods: POST.';
    });
    Route::delete('/integracao', function () {
        echo 'The GET method is not supported for this route.';
        echo '<br>';
        echo 'Supported methods: POST.';
    });
});

// http://127.0.0.1:8000/api/integracao?empresa=strikefoods
