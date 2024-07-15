<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DetailsController;
use App\Http\Controllers\MasterController;
use App\Http\Controllers\Controller;
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
Route::group(['middleware' => ['admin_auth','web' ]], function () {

//master api 
Route::post('master/', [MasterController::class, 'master']);
Route::post('cbbo-expert/', [MasterController::class, 'cbbo']);

//excel route
// Route::get('/expert', [DetailsController::class, 'expert']);
Route::get('fromInputBusiness/', [DetailsController::class, 'fromInputBusiness']);
Route::get('expertFormData/', [DetailsController::class, 'expertFormData']);
Route::get('kharifCrops/', [DetailsController::class, 'kharifCrops']);
// Route::get('selectedGstReturn/', [DetailsController::class, 'selectedGstReturn']);

///newapi route firt_form
Route::get('/newhasConnectivity', [DetailsController::class, 'newhasConnectivity']);
Route::get('/newselectedGstReturn', [DetailsController::class, 'newselectedGstReturn']);
Route::get('/newfromInputBusiness', [DetailsController::class, 'newfromInputBusiness']);
Route::get('/awarenessProgram', [DetailsController::class, 'awarenessProgram']);
Route::get('/newkharifCrops', [DetailsController::class, 'newkharifCrops']); 
   Route::get('/logout', function () {
        session()->forget('ADMIN_LOGIN');
        session()->forget('ADMIN_ID');
        session()->flash('error', 'Logout successfully');
        return redirect('admin'); // Redirect to the login page or another appropriate page
    });
});

