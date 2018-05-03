<?php

namespace App\Http\Controllers;

use App\Post;
use App\Snowflake;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class PostController extends Controller {
	public function access( $post_id ) {
		return DB::table( 'post_visibilities' )->select( 'user_id' )->where( 'post_id', '=', $post_id )->get();
	}

	public function subposts( Request $request ) {
		$finalAssocs = [];
		$assocs = DB::table( 'sub_posts' )->whereIn( 'parent_post_id', $request->get('ids') )->get();
		foreach( $assocs as $assoc ) {
			if( !array_key_exists( $assoc->parent_post_id, $finalAssocs ) ) {
				$finalAssocs[ $assoc->parent_post_id ] = [];
			}
			array_push( $finalAssocs[ $assoc->parent_post_id ], $assoc->child_post_id );
		}
		return response()->json( $finalAssocs );
	}

	public function view( $post_id ) {
		return view( 'post.view', [ 'post_id' => $post_id ] );
	}

	public function get( $post_id ) {
		return response()->json( Post::findOrFail( $post_id ) );
	}

	public function gets( Request $request ) {
		$posts = Post::whereIn( 'post_id', $request->input( 'ids' ) )->get();
		return response()->json( $posts );
	}

    public function create(Request $request) {
    	$params = $request->all();
    	if( !isset( $params[ 'post_id' ] ) ) {
		    $params[ 'post_id' ] = Snowflake::create( with(new Post)->getTable() );
	    }

	    $params[ 'author_id' ] = Auth::user()->user_id;

	    $validator = Validator::make($params, Post::validation);

	    if ($validator->fails()) {
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

	public function createImage(Request $request) {
		$params = $request->all();
		if( !isset( $params[ 'post_id' ] ) ) {
			$params[ 'post_id' ] = Snowflake::create( with(new Post)->getTable() );
		}

		$params[ 'author_id' ] = Auth::user()->user_id;
		$params[ 'type' ] = 'IMAGE';

		$validator = Validator::make($params, Post::validation);

		if (!$validator->fails()) {
			return response()->json(['errors'=>$validator->errors()]);
		}

		if( !$request->hasFile( 'image' ) ) {
			throw new \Exception( "Image not uploaded." );
		}
		$path = $request->file( 'image' )->store( 'images' );
		$params[ 'image_url' ] = Storage::url( $path );

		$post = Post::create( $params );
		if( isset( $params[ 'post_visibility_user_ids' ] ) && $params[ 'visibility' ] == 'RESTRICTED' ) {
			$post->setPostVisibility( $params[ 'post_visibility_user_ids' ] );
		}
		return response()->json( $post );
	}
}