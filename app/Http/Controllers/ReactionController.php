<?php

namespace App\Http\Controllers;

use App\Comment;
use App\Notifications\ReactComment;
use App\Post;
use App\Reaction;
use App\Snowflake;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Notifications\ReactPost;

class ReactionController extends Controller {
	public function forPost( $post_id ) {
		return response()->json( Reaction::where( 'post_id', '=', $post_id )->get() );
	}

	public function forComment( $comment_id ) {
		return response()->json( Reaction::whereCommentId( $comment_id )->get() );
	}

	public function forPosts( Request $request ) {
		$final = [];
		$reactions = Reaction::whereIn( 'post_id', $request->input( 'ids' ) )->orderBy( 'reaction_id', 'DESC' )->get();
		foreach( $reactions as $reaction ) {
			if( !array_key_exists( $reaction->post_id, $final ) ) {
				$final[ $reaction->post_id ] = [];
			}
			array_push( $final[ $reaction->post_id ], $reaction );
		}
		return response()->json( $final );
	}

	public function forComments( Request $request ) {
		$final = [];
		$reactions = Reaction::whereIn( 'comment_id', $request->input( 'ids' ) )->orderBy( 'reaction_id', 'DESC' )->get();
		foreach( $reactions as $reaction ) {
			if( !array_key_exists( $reaction->post_id, $final ) ) {
				$final[ $reaction->post_id ] = [];
			}
			array_push( $final[ $reaction->post_id ], $reaction );
		}
		return response()->json( $final );
	}

	public function addForPost( Request $request, $post_id ) {
		$params = $request->all();

		Post::findOrFail( $post_id );

		$params[ 'post_id' ] = $post_id;
		$params[ 'reaction_id' ] = Snowflake::create( 'reaction' );
		$params[ 'author_id' ] = Auth::user()->user_id;

		$validator = Validator::make( $params, Reaction::validation );

		if( $validator->fails() ) {
			return response()->json( [ 'errors' => $validator->errors() ], 420 );
		}

		$old = Reaction::wherePostId( $post_id )->where( 'reactions.author_id', '=', Auth::user()->user_id )->first();
		if( $old != null ) {
			$old->delete();
		}

		$reaction = Reaction::create( $params );

		$reaction->post->getAuthor()->notify( new ReactPost( Auth::user(), $reaction->post ) );

		return response()->json( $reaction );
	}

	public function addForComment( Request $request, $comment_id ) {
		$params = $request->all();

		Comment::findOrFail( $comment_id );

		$params[ 'comment_id' ] = $comment_id;
		$params[ 'reaction_id' ] = Snowflake::create( 'reaction' );
		$params[ 'author_id' ] = Auth::user()->user_id;

		$validator = Validator::make( $params, Reaction::validation );

		if( $validator->fails() ) {
			return response()->json( [ 'errors' => $validator->errors() ], 420 );
		}

		$old = Reaction::whereCommentId( $comment_id )->where( 'reactions.author_id', '=', Auth::user()->user_id )->first();
		if( $old != null ) {
			$old->delete();
		}

		$reaction = Reaction::create( $params );

		$reaction->comment->author->notify( new ReactComment( Auth::user(), $reaction->comment ) );

		return response()->json( $reaction );
	}

	public function removeForPost( $post_id ) {
		return response()->json( Reaction::wherePostId( $post_id )->where( 'reactions.author_id', '=', Auth::user()->user_id )->firstOrFail()->delete() );
	}

	public function removeForComment( $comment_id ) {
		return response()->json( Reaction::whereCommentId( $comment_id )->where( 'reactions.author_id', '=', Auth::user()->user_id )->firstOrFail()->delete() );
	}
}