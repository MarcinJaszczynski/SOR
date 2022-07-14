<?php

use Illuminate\Support\Facades\Route;

// Dodane dla Spatie Role and 

use Illuminate\Support\Facades\Auth;

use App\Http\Controllers\HomeController;
use App\Http\Controllers\HotelController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\PDFController;
use App\Http\Controllers\EventPaymentController;


// Koniec

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('layouts.app');
});


Auth::routes();

Route::group(['middleware' => ['auth']], function () {
    Route::resource('users', UserController::class);
    Route::resource('roles', RoleController::class);
    Route::resource('permissions', PermissionController::class);
    Route::resource('events', EventController::class);
});

Route::get('/dashboard', function () {
    return view('dashboard.index');
})->middleware('auth');


Route::post('filedelete', [EventController::class, 'fileDelete'])->name('filedelete');

Route::put('eventfileupdate', [EventController::class, 'eventFileUpdate'])->name('eventfileupdate');

Route::delete('/elementDelete/{id}', [EventController::class, 'elementDelete']);

Route::post('/events/fileStore', [EventController::class, 'fileStore'])->name('events.fileStore');

Route::post('eventhotel/store', [EventController::class, 'eventHotelStore']);

Route::put('eventhotel/update', [EventController::class, 'eventHotelUpdate']);

Route::post('/hotels/store', [HotelController::class, 'store'])->name('hotel.store');

Route::delete('/eventHotelDelete', [EventController::class, 'eventHotelDelete'])->name('eventHotelDelete');

Route::put('/eventElementUpdate', [EventController::class, 'eventElementUpdate']);

Route::post('/events/elementCreate', [EventController::class, 'eventElementStore']);

// Wydruki

Route::get('/reports/pilotpdf', [PDFController::class, 'generatePilotPDF'])->name('pilotpdf');

Route::get('/reports/hotelpdf', [PDFController::class, 'generateHotelpdf'])->name('hotelpdf');

Route::get('/reports/driverPdf', [PDFController::class, 'generateDriverpdf'])->name('driverpdf');

Route::get('/reports/briefcasePdf', [PDFController::class, 'generateBriefcasepdf'])->name('briefcasepdf');

Route::post('/reports/contractPdf', [PDFController::class, 'generateContractpdf'])->name('contractpdf');



// Płatności

Route::get('/eventPayments/index', [EventPaymentController::class, 'index'])->name('eventPaymentsIndex');

Route::post('eventPayments/store', [EventPaymentController::class, 'store'])->name('eventPaymentStore');

Route::put('eventPayments/update', [EventPaymentController::class, 'update']);

Route::delete('eventPayments/delete/{id}', [EventPaymentController::class, 'destroy']);
