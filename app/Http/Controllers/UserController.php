<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Support\Facades\Auth;

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
    		$posts->where( 'post_id', '>', $after );
	    }
	    $posts = $posts->get();

    	return response()->json( $posts );
    }

	public function images( $after = null ) {
		$posts = Auth::user()->selectorImages()->limit( 20 );
		if( $after != null ) {
			$posts->where( 'post_id', '>', $after );
		}
		$posts = $posts->get();

		return response()->json( $posts );
	}

	public function videos( $after = null ) {
		$posts = Auth::user()->selectorVideos()->limit( 20 );
		if( $after != null ) {
			$posts->where( 'post_id', '>', $after );
		}
		$posts = $posts->get();

		return response()->json( $posts );
	}

	public function events( $after = null ) {
		$posts = Auth::user()->selectorEvents()->limit( 20 );
		if( $after != null ) {
			$posts->where( 'event_id', '>', $after );
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

        return view( 'app.networks.list', [
            'networkmembers' => $networkmembers
        ]);
    }
}