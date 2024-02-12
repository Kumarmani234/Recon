<?php

use App\Http\Controllers\AcquirersController;
use App\Http\Controllers\AllAcquirersController;
use App\Http\Controllers\AxisController;
use App\Http\Controllers\CardIciciController;
use App\Http\Controllers\CosmosController;
use App\Http\Controllers\CosmosImportController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ICICIController;
use App\Http\Controllers\InduslndController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\PaygXsilicaController;
use App\Http\Controllers\PayuController;
use App\Http\Controllers\UPIKotakController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::middleware(['auth'])->group(function () {
    Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
    Route::get('/', [CosmosController::class, 'index']);
    Route::get('/cosmos-showimport', [CosmosImportController::class, 'index'])->name('cosmos-showimport');
    Route::get('/acquirer-import', [CosmosImportController::class, 'dataimport'])->name('acquirer.import');
    Route::get('/payu-data', [PayuController::class, 'index']);
    Route::get('/axis-data', [AxisController::class, 'index']);
    Route::get('/icici-data', [ICICIController::class, 'index']);
    Route::get('/card-icici-data', [CardIciciController::class, 'index']);
    Route::get('/indusland-data', [InduslndController::class, 'index']);
    Route::get('/upi-kotak-data', [UPIKotakController::class, 'index']);
    Route::get('/paygxsilica-data', [PaygXsilicaController::class, 'index']);
    Route::get('/all-acquirers', [AllAcquirersController::class, 'index'])->name('all-acquirers');
    Route::post('/change-tab', [AllAcquirersController::class, 'changeTab'])->name('change-tab');
});

