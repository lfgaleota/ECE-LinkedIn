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
Route::middleware(['auth'])->group( function() {
	Route::get('user/', 'UserController@list')->name( 'user.list' );
});

Route::middleware(['auth', 'api'])->group( function() {
	Route::get('api/{username}/images/{last_id?}', 'UserController@imagesUser')->name( 'api.user.images' );
	Route::get('api/{username}/videos/{last_id?}', 'UserController@videosUser')->name( 'api.user.videos' );
	Route::get('api/{username}/events/{last_id?}', 'UserController@eventsUser')->name( 'api.user.events' );

	Route::post('api/{username}/education', 'UserController@education');
	Route::post('api/{username}/experience', 'UserController@experience');
	Route::post('api/{username}/skill', 'UserController@skill');

	Route::get('api/images/{last_id?}', 'UserController@images');
	Route::get('api/videos/{last_id?}', 'UserController@videos');
	Route::get('api/events/{last_id?}', 'UserController@events');
});

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
});

/*
 * POSTS
 */
Route::middleware(['auth'])->group( function() {
	Route::get('post/{post_id}', 'PostController@show')->name( 'post.get' );
});

Route::middleware(['auth', 'api'])->group( function() {
	Route::get('api/post/{post_id}', 'PostController@get')->name( 'api.post.get' );
	Route::get('api/post/{post_id}/access', 'PostController@access')->name( 'api.post.access' );
	Route::post( 'api/post/subs', 'PostController@subposts' )->name( 'api.post.subs' );
	Route::post( 'api/post/gets', 'PostController@gets' )->name( 'api.post.gets' );

	Route::put('api/post', 'PostController@create')->name( 'api.post.create' );
	Route::put('api/image', 'PostController@createImage')->name( 'api.image.create' );
	Route::put('api/video', 'PostController@createVideo')->name( 'api.video.create' );

	Route::put('api/{username}/image', 'PostController@createImageUser')->name( 'api.user.image.create' );
	Route::put('api/{username}/video', 'PostController@createVideoUser')->name( 'api.user.video.create' );

	Route::get('api/post/{post_id}/comments', 'CommentController@get');
	Route::put('api/post/{post_id}/comments', 'CommentController@post');
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
 * NOTIFICATIONS
 */
Route::middleware(['auth', 'api'])->group( function() {
	Route::post('api/notification/{notification_id}/read', 'NotificationController@read')->name( 'api.notification.read.mark' );
});

/*
 * JOBS
 */
Route::middleware( 'auth' )->group( function() {
	Route::get('job', 'JobController@list')->name( 'job.list' );
	Route::get('job/own', 'JobController@listOwn')->name( 'job.list.own' );
	Route::get('job/create', 'JobController@create')->name( 'job.create' );
	Route::get('job/{id}/edit', 'JobController@edit')->name( 'job.edit' );
	Route::get('job/{id}/delete', 'JobController@deleteAsk')->name( 'job.delete.ask' );

	Route::get('job/{id}', 'JobController@show')->name( 'job.show' );

	Route::post('job/{id}/apply', 'JobController@apply')->name( 'job.apply' );
	Route::post('job/{id}', 'JobController@update')->name( 'job.update' );

	Route::put('job', 'JobController@store')->name( 'job.store' );

	Route::delete('job/{id}', 'JobController@delete')->name( 'job.delete' );
});

/*
 * ENTITIES
 */
Route::middleware( 'auth' )->group( function() {
	Route::get('entity', 'EntityController@list')->name( 'entity.list' );
	Route::get('entity/own', 'EntityController@listOwn')->name( 'entity.list.own' );
	Route::get('entity/create', 'EntityController@create')->name( 'entity.create' );
	Route::get('entity/{id}/edit', 'EntityController@edit')->name( 'entity.edit' );
	Route::get('entity/{id}/delete', 'EntityController@deleteAsk')->name( 'entity.delete.ask' );

	Route::get('entity/{id}', 'EntityController@show')->name( 'entity.show' );

	Route::post('entity/{id}', 'EntityController@update')->name( 'entity.update' );


	Route::put('entity', 'EntityController@store')->name( 'entity.store' );

	Route::delete('entity/{id}', 'EntityController@delete')->name( 'entity.delete' );
});

Route::middleware(['auth', 'api'])->group( function() {
	Route::get('api/entity', 'EntityController@getAll')->name( 'api.entity' );
});

/*
 * SEARCH
 */
Route::middleware('auth')->group( function() {
	Route::get('search/users', 'SearchController@users')->name( 'search.user' );
	Route::get('search/jobs', 'SearchController@jobs')->name( 'search.job' );
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

Route::middleware(['auth'])->group( function() {
	Route::post('user/{id}', 'UserController@update')->name( 'user.update' );
	Route::delete('{username}', 'UserController@delete')->name( 'user.delete' );
});