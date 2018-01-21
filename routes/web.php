<?php

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

use Illuminate\Support\Facades\Mail;
use App\Mail\SendEmailable;
use App\Jobs\SendEmailJob;

Route::get('/', function () {
    return view('welcome');
});

Route::post('purchases','PurchasesController@store');

Route::get('importExport', 'MaatwebsiteDemoController@importExport');
Route::get('downloadExcel/{type}', 'MaatwebsiteDemoController@downloadExcel');
Route::post('importExcel', 'MaatwebsiteDemoController@importExcel');

Route::get('email',function (){
   // dispatch(new \App\Jobs\SendEmailJob());
    $job = (new SendEmailJob())->delay(\Carbon\Carbon::now()->addSeconds(5));
    dispatch($job);
    return "Email sent successfully";
});