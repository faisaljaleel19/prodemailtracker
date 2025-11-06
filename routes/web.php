<?php

use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Route;
use Illuminate\Validation\Rules\Enum;
use Illuminate\Foundation\Auth\User;
use Laravel\Socialite\Facades\Socialite;

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

//Route::get('/', function () {
//    return view('welcome');
//});
//Route::group(['middleware' => 'guest'], function () {
//    Route::get('/', function () {
//        return view('auth/login');
//    });
//    Route::get('/register', function () {
//        return view('auth/register');
//    });
//});
Route::group(['middleware' => 'guest'], function () {
    Route::get('/', [\App\Http\Controllers\Auth\AuthController::class, 'redirectToMS'])->name('mslogin');

    Route::get('/home', [\App\Http\Controllers\Auth\AuthController::class, 'handleMSCallback']);
});
//Route::get('/', function () {
//    return view('auth/login');
//});
Route::get('forbidden', [App\Http\Controllers\Auth\AuthController::class, 'forbidden'])->name('forbidden');
Route::get('logout', [App\Http\Controllers\Auth\AuthController::class, 'logout'])->name('logout');
//Route::get('logout', [App\Http\Controllers\Auth\LoginController::class, 'logout'])->name('logout');

Auth::routes();
Route::group(['middleware' => ['permission:view-dashboard', 'auth']], function () {
    Route::get('/dashboard', [HomeController::class, 'index'])->name('dashboard');
    Route::get('/get_all_months', [HomeController::class, 'get_all_months'])->name('get_all_months');
});
Route::group(['middleware' => ['permission:upload-tracker', 'auth']], function () {
    Route::get('/upload_tracker', [App\Http\Controllers\UploadTrackerController::class, 'index'])->name('upload_tracker');

    Route::post('/upload_tracker', [App\Http\Controllers\UploadTrackerController::class, 'upload_track'])->name('upload_tracker');
});

Route::group(['middleware' => ['permission:view-tracker', 'auth']], function () {

    Route::get('/product_track_list_view', [App\Http\Controllers\ProductTrackList::class, 'index'])->name('product_track_list_view');
    Route::get('/list_product_track', [App\Http\Controllers\ProductTrackList::class, 'list_product_track'])->name('list_product_track');

    Route::post('/batch_delete', [App\Http\Controllers\UploadTrackerController::class, 'batch_delete'])->name('batch_delete');

    Route::get('/list_batch_trackers', [App\Http\Controllers\UploadTrackerController::class, 'list_batch_trackers'])->name('list_batch_trackers');

    Route::post('/search_tracker', [\App\Http\Controllers\ProductTrackList::class, 'filter'])->name('search_tracker');

    Route::post('/get_tracker', [\App\Http\Controllers\ProductTrackList::class, 'get_tracker'])->name('get_tracker');
    Route::post('/get_product_categories', [\App\Http\Controllers\ProductTrackList::class, 'get_product_categories'])->name('get_product_categories');
    Route::post('/update_tracker', [\App\Http\Controllers\ProductTrackList::class, 'update_tracker'])->name('update_tracker');
});

Route::group(['middleware' => ['permission:send-activation-mail', 'auth']], function () {
    Route::get('/send_track_email', [App\Http\Controllers\UploadTrackerController::class, 'send_track_email'])->name('send_track_email');

    Route::get('/list_trackers_in_send_email', [App\Http\Controllers\SendActivationEmail::class, 'list_trackers_in_send_email'])->name('list_trackers_in_send_email');

    Route::get('/send_activation_email', [App\Http\Controllers\SendActivationEmail::class, 'index'])->name('send_activation_email');

    Route::post('/mail_send_activation', [App\Http\Controllers\SendActivationEmail::class, 'mail_send_activation'])->name('mail_send_activation');

    Route::get('/view_email_template', [\App\Http\Controllers\SendActivationEmail::class, 'view_email_template'])->name('view_email_template');
});

Route::group(['middleware' => ['permission:create-tracker', 'auth']], function () {
    Route::get('/create_tracker', [App\Http\Controllers\CreateTracker::class, 'index'])->name('create_tracker');
    Route::post('/add_tracker', [App\Http\Controllers\CreateTracker::class, 'add_tracker'])->name('add_tracker');
});

Route::group(['middleware' => ['permission:create-users|edit-users|delete-users', 'auth']], function () {
    Route::get('/users', [App\Http\Controllers\Users::class, 'index'])->name('users');

    Route::post('/add_user', [App\Http\Controllers\Users::class, 'add_user'])->name('add_user');

    Route::get('/list_users', [App\Http\Controllers\Users::class, 'list_users'])->name('list_users');

    Route::post('/user_status_change', [App\Http\Controllers\Users::class, 'user_status_change'])->name('user_status_change');
});

Route::get('/testemail', function(){
    return new \App\Mail\K10StreamingAndK10PlusTablet('test', '3344555', 'Ramkumar', 'test@gmail.com', '434455');
    dd(new Enum(\App\Enums\ProductCategories::class));
});
