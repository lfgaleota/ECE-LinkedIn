<?php

namespace App\Http\Controllers;


use App\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Notifications\Notification;
use App\Notifications\FriendRequest;

class FriendController extends Controller
{
    public function get() {
        return response()->json( Auth::user()->getFriends() );
    }

    /**
     * @param $username
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function add( $username ) {
        $user = User::whereUsername( $username )->firstOrFail();

        Auth::user()->addFriend( $user );
        $user->notify( new FriendRequest( $user, Auth::user(), true ) );

        return back();
    }

        public function ask($username ) {
        $user = User::whereUsername( $username )->firstOrFail();

        Auth::user()->sendFriendRequest( $user );
        $user->notify( new FriendRequest( Auth::user(), $user, false ) );

        return back();
    }

        public function refuse($username ) {
        $user = User::whereUsername( $username )->firstOrFail();

        Auth::user()->delFriendRequest( $user );

        return back();
    }

    /**
     * @param $username
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function remove( $username ) {
        $user = User::whereUsername( $username )->firstOrFail();

        Auth::user()->removeFriend( $user );

        return back();
    }
}