<?php
declare(strict_types=1);

use Illuminate\Support\Facades\Route;
use Modules\Lender\Http\Controllers\LenderController;

Route::group([], function () {
    /**
     * Lender Resource controller
     */
    Route::resource('lenders', LenderController::class);

    Route::post('/upload-file', [\Modules\Lender\Http\Controllers\UploadController::class, 'upload']);
});
