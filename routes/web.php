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

/*
 * GENERAL
 */
Route::get('/', 'IndexController@get')->name('index');

/*
 * USERS
 */
Route::get('user/', 'UserController@list')->name( 'user.list' );

/*
 * NETWORK & FRIENDS
 */
Route::get('network', 'UserController@network')->name( 'user.network.list' );

Route::put('network/{username}', 'NetworkMembersController@add')->name( 'user.network.add' );
Route::put('friend/{username}', 'FriendController@add')->name( 'user.friend.add' );

Route::delete('network/{username}', 'NetworkMembersController@remove')->name( 'user.network.remove' );
Route::delete('friend/{username}', 'FriendController@remove')->name( 'user.friend.remove' );

/*
 * AUTH
 */
Auth::routes();

/*
 * USER PROFILE
 *
 * (last one because it handles every other possible URLs)
 */
Route::get('{username}', 'UserController@profile')->name( 'user.profile' );