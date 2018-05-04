<?php

namespace App\Http\Controllers;

use App\Comment;
use App\Reaction;
use App\Snowflake;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class CommentController extends Controller {
	public function get( $post_id ) {
		$comments = Comment::join( 'users as authors', 'authors.user_id', '=', 'comments.author_id' )
			->leftJoin( 'posts AS images', 'authors.photo_id', '=', 'images.post_id' )
		->where( 'comments.post_id', '=', $post_id )
		->orderBy( 'comment_id', 'ASC' )
		->get();

		foreach( $comments as $comment ) {
			$req = Reaction::leftJoin( 'posts AS images', 'authors.photo_id', '=', 'images.post_id' )
				->where( 'reactions.comment_id', '=', $comment->comment_id );
			foreach( Reaction::select as $select ) {
				$req->addSelect( 'reactions.' . $select . ' AS ' . $select );
			}
			foreach( Reaction::select_more as $select ) {
				$req->addSelect( 'reactions.' . $select . ' AS ' . $select );
			}
			foreach( User::select as $select ) {
				$req->addSelect( 'authors.' . $select . ' AS ' . $select );
			}
			$comment->reactions = $req->addSelect( 'images.image_url AS photo_url' )
								->get();
		}

		return response()->json( $comments );
	}

	public function post( Request $request, $post_id ) {
		$params = $request->all();

		$params[ 'comment_id' ] = Snowflake::create( with( new Comment )->getTable() );
		$params[ 'author_id' ] = Auth::user()->user_id;
		$params[ 'post_id' ] = $post_id;

		$validator = Validator::make( $params, Comment::validation );

		if( $validator->fails() ) {
			return response()->json( [ 'errors' => $validator->errors() ], 420 );
		}

		$comment = Comment::create( $params );
		return response()->json( $comment );
	}
}