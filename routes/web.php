<?php

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

/*Route::get('/', function () {
    return view('welcome');
});*/
Route::get('/chat',function(){
    return view('chat');
});
Route::get('/', 'LoginController@Login');
Route::get('login', [ 'as' => 'login', 'uses' => 'LoginController@Login']);
Route::post('dologin', ['as'=>'post:dologin','uses'=>'LoginController@DoLogin']);
Route::get('logout', [ 'as' => 'get:logout', 'uses' => 'LoginController@logout']);
Route::get('reset-password/{token}', [ 'as' => 'get:reset_password', 'uses' => 'LoginController@ResetPassword']);
Route::post('reset_password', [ 'as' => 'post:reset_password', 'uses' => 'LoginController@postResetPassword']);
Route::get('success_message',function(){
    return view('success_message');
});

Route::group(['middleware' => 'App\Http\Middleware\AdminMiddleware'], function() {
    Route::get('dashboard', ['as'=>'get:dashboard','uses'=>'DashboardController@Dashboard']);
    Route::get('profile', ['as'=>'get:profile','uses'=>'AdminController@Profile']);
    Route::post('updateprofile', ['as'=>'post:updateprofile','uses'=>'AdminController@UpdateProfile']);
    Route::get('password', ['as'=>'get:password','uses'=>'AdminController@Password']);
    Route::post('updatepassword', ['as'=>'post:updatepassword','uses'=>'AdminController@UpdatePassword']);

    Route::get('users', ['as'=>'get:users','uses'=>'UsersController@Users']);
    Route::get('viewuser/{id}', ['as'=>'get:viewuser','uses'=>'UsersController@ViewUser']);
    Route::get('userstatus/{id}/{status}', ['as'=>'get:userstatus','uses'=>'UsersController@UserStatus']);
    Route::get('deleteuser/{id}', ['as'=>'get:deleteuser','uses'=>'UsersController@UserDelete']);

    Route::get('packages', ['as'=>'get:packages','uses'=>'PackagesController@Index']);
    Route::get('addpackages', ['as'=>'get:addpackages','uses'=>'PackagesController@AddPackages']);
    Route::post('addpackages', ['as'=>'post:addpackages','uses'=>'PackagesController@PostAddPackages']);
    Route::get('editpackages/{id}', ['as'=>'get:editpackages','uses'=>'PackagesController@EditPackages']);
    Route::post('editpackages', ['as'=>'post:editpackages','uses'=>'PackagesController@UpdatePackages']);
    Route::get('deletepackages/{id}', ['as'=>'get:deletepackages','uses'=>'PackagesController@DeletePackages']);

    Route::get('abuse_report', ['as'=>'get:abuse_report','uses'=>'AbuseReportController@Index']);
    Route::get('editabuse_report/{id}', ['as'=>'get:editabuse_report','uses'=>'AbuseReportController@EditAbuseReport']);
    Route::post('update_abuse', ['as'=>'post:update_abuse','uses'=>'AbuseReportController@UpdateAbuse']);

    Route::get('membership', ['as'=>'get:membership','uses'=>'MembershipController@Index']);

    Route::get('notification', ['as'=>'get:notification','uses'=>'NotificationController@Index']);
    Route::post('sendnotification', ['as'=>'post:sendnotification','uses'=>'NotificationController@SendNotification']);
    
});