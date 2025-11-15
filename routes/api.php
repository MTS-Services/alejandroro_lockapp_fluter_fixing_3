<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
Route::post('signup', 'ApiController@signup');
Route::post('signin', 'ApiController@verifyLogin');
Route::post('socialsignin', 'ApiController@socialsignin');
Route::post('profile_complete', 'ApiController@profile_complete');
Route::post('forgot', 'ApiController@Forgot');
Route::post('update_profile', 'ApiController@UpdateProfile');
Route::post('update_password', 'ApiController@UpdatePassword');
Route::post('add_media', 'ApiController@AddMedia');
Route::post('get_media', 'ApiController@GetMedia');
Route::post('delete_media', 'ApiController@DeleteMedia');
Route::post('delete_account', 'ApiController@DeleteAccount');

Route::post('discover_users','ApiController@DiscoverUsers');
Route::post('discover_filter','ApiController@DiscoverFilter');
Route::post('get_users_details','ApiController@GetUserDetails');

Route::post('add_tofavorite','ApiController@AddtoFavorite');
Route::post('get_user_favorite','ApiController@GetUserFavorite');
Route::post('remove_tofavorite','ApiController@RemovetoFavorite');

Route::post('userliked','ApiController@UserLiked');
Route::post('get_userliked','ApiController@GetUserLiked');
Route::post('userunliked','ApiController@UserUnliked');

Route::post('create_story','ApiController@CreateStory');
Route::post('get_your_story','ApiController@GetYourStory');
Route::post('delete_story','ApiController@DeleteStory');
Route::post('get_storyseen_userlist','ApiController@GetStoryseenUserlist');

Route::post('get_friend_story','ApiController@GetFriendStory');
Route::post('seen_story','ApiController@UserViewStory');

Route::post('update_device_token', 'ApiController@UpdateDeviceToken');
Route::post('mark_token_invalid', 'ApiController@MarkTokenInvalid');

Route::post('create_chat', 'ApiController@CreateChat');
Route::post('get_chats','ApiController@GetChats');
Route::post('get_chat_conversion','ApiController@GetChatConversion');

Route::post('abuse_report','ApiController@AbuseReport');
Route::post('get_packages','ApiController@GetPackages');
Route::post('buy_package','ApiController@BuyPackage');
Route::post('get_transaction','ApiController@GetTransaction');
Route::post('get_blockuser','ApiController@GetUserBlock');
Route::post('user_block','ApiController@UserBlock');
Route::post('user_unblock','ApiController@UserUnBlock');
Route::post('swipes','ApiController@Swipes');
