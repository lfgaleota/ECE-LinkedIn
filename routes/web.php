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

Route::post('user/{id}', 'UserController@update')->name( 'user.update' );

/*
 * NETWORK & FRIENDS
 */
Route::middleware(['auth'])->group( function() {
    Route::get('network', 'UserController@network')->name( 'user.network.list' );

    Route::put('network/{username}', 'NetworkMembersController@add')->name( 'user.network.add' );
    Route::put('friend/{username}', 'FriendController@add')->name( 'user.friend.add' );
    Route::put('friend/{username}/ask', 'FriendController@ask')->name( 'user.friend.ask' );

    Route::delete('network/{username}', 'NetworkMembersController@remove')->name( 'user.network.remove' );
    Route::delete('friend/{username}', 'FriendController@remove')->name( 'user.friend.remove' );
	Route::delete('friend/{username}/ask/refuse', 'FriendController@refuse')->name( 'user.friend.ask.refuse' );
	Route::delete('friend/{username}/ask', 'FriendController@removeRequest')->name( 'user.friend.ask.delete' );
});

Route::middleware(['auth', 'api'])->group( function() {
    Route::get('api/network', 'NetworkMembersController@get')->name( 'api.user.network.list' );
    Route::get('api/friend', 'FriendController@get')->name( 'api.user.friend.list' );
	Route::get('api/timeline/{last_id?}', 'UserController@timeline')->name( 'api.user.timeline' );
	Route::get('api/images/{last_id?}', 'UserController@images')->name( 'api.user.images' );
	Route::get('api/videos/{last_id?}', 'UserController@videos')->name( 'api.user.videos' );
	Route::get('api/events/{last_id?}', 'UserController@events')->name( 'api.user.events' );
});

/*
 * POSTS
 */
Route::middleware(['auth'])->group( function() {
	Route::get('post/{post_id}', 'PostController@view')->name( 'post.get' );
});

Route::middleware(['auth', 'api'])->group( function() {
	Route::get('api/post/{post_id}', 'PostController@get')->name( 'api.post.get' );
	Route::get('api/post/{post_id}/access', 'PostController@access')->name( 'api.post.access' );
	Route::post( 'api/post/subs', 'PostController@subposts' )->name( 'api.post.subs' );
	Route::post( 'api/post/gets', 'PostController@gets' )->name( 'api.post.gets' );

	Route::put('api/post', 'PostController@create')->name( 'api.post.create' );
	Route::put('api/image', 'PostController@createImage')->name( 'api.image.create' );
	Route::put('api/video', 'PostController@createVideo')->name( 'api.video.create' );
});

/*
 * REACTIONS
 */
Route::middleware(['auth', 'api'])->group( function() {
	Route::get('api/post/{post_id}/reaction', 'ReactionController@forPost')->name( 'api.post.reaction.get' );
	Route::get('api/comment/{comment_id}/reaction', 'ReactionController@forComment')->name( 'api.comment.reaction.get' );

	Route::post('api/post/gets/reaction', 'ReactionController@forPosts')->name( 'api.post.gets.reaction' );
	Route::post('api/comment/gets/reaction', 'ReactionController@forComments')->name( 'api.comment.gets.reaction' );

	Route::put('api/post/{post_id}/reaction', 'ReactionController@addForPost')->name( 'api.post.reaction.add' );
	Route::put('api/comment/{comment_id}/reaction', 'ReactionController@addForComment')->name( 'api.comment.reaction.add' );

	Route::delete('api/post/{post_id}/reaction', 'ReactionController@removeForPost')->name( 'api.post.reaction.remove' );
	Route::delete('api/comment/{comment_id}/reaction', 'ReactionController@removeForComment')->name( 'api.comment.reaction.remove' );
});

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
