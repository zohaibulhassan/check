<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ExcelController;

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

// Route::get('/', function () {
//     return view('home');
// });

Auth::routes();

Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/guest', [App\Http\Controllers\HomeController::class, 'guest'])->name('guest');
Route::get('/users',[App\Http\Controllers\HomeController::class, 'userlist'])->name('userlist');
Route::get('/registerModel',[App\Http\Controllers\HomeController::class, 'registerModel'])->name('registerModel');
Route::get('/mapping', [App\Http\Controllers\HomeController::class, 'mapping'])->name('mapping');



Route::get('/demomapping', [App\Http\Controllers\HomeController::class, 'demomapping'])->name('demomapping');




Route::get('/map_company/{companyid}', [App\Http\Controllers\HomeController::class, 'map_company'])->name('map_company');
Route::get('/demomap_company/{companyid}', [App\Http\Controllers\HomeController::class, 'demomap_company'])->name('demomap_company');
Route::post('/map-company-details', [App\Http\Controllers\HomeController::class, 'mapCompanyDetails'])->name('map-company-details');
Route::post('/download', [App\Http\Controllers\HomeController::class, 'download'])->name('download');


Route::post('/demodownload', [App\Http\Controllers\HomeController::class, 'demodownload'])->name('demodownload');



Route::get('/get-stock-years', [App\Http\Controllers\HomeController::class, 'getStockYears'])->name('getStockYears');


Route::get('/demoget-stock-years', [App\Http\Controllers\HomeController::class, 'demogetStockYears'])->name('demogetStockYears');



// Route::get('/get-pie-chart-data', [App\Http\Controllers\HomeController::class,'getPieChartData'])->name('getPieChartData');
// Route::get('/getCompanyShareData', [App\Http\Controllers\HomeController::class,'getCompanyShareData'])->name('getCompanyShareData');
Route::post('/fetchdata', [App\Http\Controllers\HomeController::class, 'fetchdata'])->name('fetchdata');
Route::post('/demofetchdata', [App\Http\Controllers\HomeController::class, 'demofetchdata'])->name('demofetchdata');

Route::get('/uploaddata',[App\Http\Controllers\HomeController::class, 'uploaddata'])->name('uploaddata');
Route::get('/demouploaddata',[App\Http\Controllers\HomeController::class, 'demouploaddata'])->name('demouploaddata');

Route::post('/uploadDatafile',[App\Http\Controllers\HomeController::class, 'uploadDatafile'])->name('uploadDatafile');
Route::post('/demouploadDatafile',[App\Http\Controllers\HomeController::class, 'demouploadDatafile'])->name('demouploadDatafile');
Route::post('registermodal', [App\Http\Controllers\HomeController::class, 'registermodal'])->name('registermodal');
Route::post('savecompany', [App\Http\Controllers\HomeController::class, 'savecompany'])->name('savecompany');


Route::post('demosavecompany', [App\Http\Controllers\HomeController::class, 'demosavecompany'])->name('demosavecompany');






Route::get('/home', [App\Http\Controllers\HomeController::class, 'search'])->name('search');


Route::get('/demohome', [App\Http\Controllers\HomeController::class, 'demosearch'])->name('demosearch');



Route::get('editcompany/{id}', [App\Http\Controllers\HomeController::class, 'editcompany'])->name('editcompany');
Route::post('updatecompany', [App\Http\Controllers\HomeController::class, 'updatecompany'])->name('updatecompany');
Route::get('updatelogo', [App\Http\Controllers\HomeController::class, 'updatelogo'])->name('updatelogo');
Route::post('savelogo', [App\Http\Controllers\HomeController::class, 'savelogo'])->name('savelogo');
Route::post('/approve_user/{user}', [App\Http\Controllers\HomeController::class, 'approve'])->name('approve_user');
Route::delete('/reject_user/{user}', [App\Http\Controllers\HomeController::class, 'reject'])->name('reject_user');