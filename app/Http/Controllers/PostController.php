<?php

namespace App\Http\Controllers;

use App\Post;
use App\Snowflake;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class PostController extends Controller {
	public function access( $post_id ) {
		return DB::table( 'post_visibilities' )->select( 'user_id' )->where( 'post_id', '=', $post_id )->get();
	}

    public function create(Request $request) {
    	$params = $request->all();
    	if( !isset( $params[ 'post_id' ] ) ) {
		    $params[ 'post_id' ] = Snowflake::create( with(new Post)->getTable() );
	    }

	    $params[ 'author_id' ] = Auth::user()->user_id;

	    $validator = Validator::make($params, Post::validation);

	    if (!$validator->fails()) {
		    return response()->json(['errors'=>$validator->errors()]);
	    }

	    $posts_ids = [];
	    if( isset( $params[ 'photo_ids' ] ) ) {
	    	$posts_ids = array_merge( $params[ 'photo_ids' ], $posts_ids );
	    }
	    if( isset( $params[ 'video_ids' ] ) ) {
		    $posts_ids = array_merge( $params[ 'video_ids' ], $posts_ids );
	    }

	    $post = Post::create( $params );
	    $post->setSubposts( $posts_ids );
	    if( isset( $params[ 'post_visibility_user_ids' ] ) && $params[ 'visibility' ] == 'RESTRICTED' ) {
		    $post->setPostVisibility( $params[ 'post_visibility_user_ids' ] );
	    }
	    return response()->json( $post );
    }
}