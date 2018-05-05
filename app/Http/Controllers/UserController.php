<?php

namespace App\Http\Controllers;

use App\Post;
use App\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
	public function list() {
		$users = User::paginate( 20 );

		return view( 'app.user.list', [
			'users' => $users
		]);
	}

	public function timeline( $after = null ) {
		$posts = Auth::user()->selectorTimeline()->limit( 20 );
		if( $after != null ) {
			$posts->where( 'posts.post_id', '<', $after );
		}
		$posts = $posts->get();

		return response()->json( $posts );
	}

	public function images( $after = null ) {
		return $this->imagesUser( Auth::user()->username, $after );
	}

	public function imagesUser( $username, $after = null ) {
		$user = User::whereUsername( $username )->firstOrFail();

		$posts = $user->selectorImages()->limit( 20 );
		if( $after != null ) {
			$posts->where( 'post_id', '<', $after );
		}
		$posts = $posts->get();

		return response()->json( $posts );
	}

	public function videos( $after = null ) {
		return $this->videosUser( Auth::user()->username, $after );
	}

	public function videosUser( $username, $after = null ) {
		$user = User::whereUsername( $username )->firstOrFail();

		$posts = $user->selectorVideos()->limit( 20 );
		if( $after != null ) {
			$posts->where( 'post_id', '<', $after );
		}
		$posts = $posts->get();

		return response()->json( $posts );
	}

	public function events( $after = null ) {
		return $this->eventsUser( Auth::user()->username, $after );
	}

	public function eventsUser( $username, $after = null ) {
		$user = User::whereUsername( $username )->firstOrFail();

		$posts = $user->selectorEvents()->limit( 20 );
		if( $after != null ) {
			$posts->where( 'event_id', '<', $after );
		}
		$posts = $posts->get();

		return response()->json( $posts );
	}

	public function profile( $username ) {
		$user = User::whereUsername( $username )->firstOrFail();

		return view( 'app.user.profile', [
			'user' => $user
		]);
	}

	public function network() {
		$networkmembers = Auth::user()->selectorNetworkMembers( Auth::user() )->paginate( 20 );
		$inviters = User::join( 'friend_requests', 'friend_requests.requester_id', '=', 'users.user_id' )
			->where( 'invited_id', '=', Auth::user()->user_id )
			->get();

		return view( 'app.networks.list', [
			'inviters' => $inviters,
			'networkmembers' => $networkmembers
		]);
	}

	public function update(Request $request, $username){
		$user = User::whereUsername( $username )->firstOrFail();

		$params = $request->all();
		if( isset( $params[ 'email' ] ) && $params[ 'email' ] === $user->email ) {
			unset( $params[ 'email' ] );
		}

	    $validator = Validator::make($params, User::validation_update);

	    if($validator->fails()) {
		    return redirect()->back()->withErrors($validator)->withInput();
	    }

		if( $request->has('name')) {
			$user->name = $request->input('name');
		}
		if( $request->has('surname')) {
			$user->surname = $request->input('surname');
		}
		if( $request->has('username')) {
			$user->username = $request->input('username') ;
		}
		if( $request->has('email')) {
			$user->email = $request->input('email') ;
		}
		if( $request->has('birth_date')) {
			$user->birth_date = $request->input('birth_date') ;
		}
		if( $request->has('title')) {
			$user->title = $request->input('title') ;
		}
		if( $request->has('password') && Auth::user()->type == 'ADMIN' ) {
			$user->setPassword( $request->input('password') );
		}

		if( $request->hasFile('cv') ) {
			$user->setCV( $request->file('cv') );
		}
		if( $request->has('photo_id') && $request->input('photo_id') != null ) {
			$photo = Post::find( $request->input('photo_id') );
			if( $photo == null ) {
				throw new \Exception( 'Invalid Photo ID.' );
			}
			if( $photo->author_id != $user->user_id ) {
				throw new \Exception( 'Cannot set picture from another user.' );
			}
			$user->photo_id = $request->input('photo_id');
		}

		if( $request->has('cover_id') && $request->input('cover_id') != null ) {
			$cover = Post::find( $request->input('cover_id') );
			if( $cover == null ) {
				throw new \Exception( 'Invalid Cover ID.' );
			}
			if( $cover->author_id != $user->user_id ) {
				throw new \Exception( 'Cannot set picture from another user.' );
			}
			$user->cover_id = $request->input('cover_id');
		}

		$user->save();

		return redirect()->route( 'user.profile', [ 'username' => $user->username ] );
	}

	public function education( Request $request, $username ) {
		$user = User::whereUsername( $username )->firstOrFail();

		if( !Auth::user()->role == 'ADMIN' && !Auth::user()->isSame( $user ) ) {
			return response()->json( [ 'errors' => 'Unauthorized' ], 401 );
		}

		$validator = Validator::make( $request->all(), [
			'data' => 'required|array'
		]);

		if( $validator->fails() ) {
			return response()->json( [ 'errors' => $validator->errors() ], 420 );
		}

		if( $user->infos == null ) {
			$user->infos = '{}';
		}
		$infos = json_decode( $user->infos, true );
		$infos[ 'education' ] = $request->get( 'data' );
		$user->infos = json_encode( $infos );
		$user->save();

		return response()->json();
	}

	public function experience( Request $request, $username ) {
		$user = User::whereUsername( $username )->firstOrFail();

		if( !Auth::user()->role == 'ADMIN' && !Auth::user()->isSame( $user ) ) {
			return response()->json( [ 'errors' => 'Unauthorized' ], 401 );
		}

		$validator = Validator::make( $request->all(), [
			'data' => 'required|array'
		]);

		if( $validator->fails() ) {
			return response()->json( [ 'errors' => $validator->errors() ], 420 );
		}

		if( $user->infos == null ) {
			$user->infos = '{}';
		}
		$infos = json_decode( $user->infos, true );
		$infos[ 'experience' ] = $request->get( 'data' );
		$user->infos = json_encode( $infos );
		$user->save();

		return response()->json();
	}

	public function skill( Request $request, $username ) {
		$user = User::whereUsername( $username )->firstOrFail();

		if( !Auth::user()->role == 'ADMIN' && !Auth::user()->isSame( $user ) ) {
			return response()->json( [ 'errors' => 'Unauthorized' ], 401 );
		}

		$validator = Validator::make( $request->all(), [
			'data' => 'required|array'
		]);

		if( $validator->fails() ) {
			return response()->json( [ 'errors' => $validator->errors() ], 420 );
		}

		if( $user->infos == null ) {
			$user->infos = '{}';
		}
		$infos = json_decode( $user->infos, true );
		$infos[ 'skill' ] = $request->get( 'data' );
		$user->infos = json_encode( $infos );
		$user->save();

		return response()->json();
	}
}