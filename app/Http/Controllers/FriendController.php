<?php

namespace App\Http\Controllers;


use App\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Notifications\Notification;

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

        return back();
    }

        public function ask($username ) {
        $user = User::whereUsername( $username )->firstOrFail();

        Auth::user()->sendFriendRequest( $user );

        return back();
    }

        public function removeRequest($username ) {
        $user = User::whereUsername( $username )->firstOrFail();

        Auth::user()->delSentFriendRequest( $user );

        return back();
    }

        public function refuse($username ) {
        $user = User::whereUsername( $username )->firstOrFail();

        Auth::user()->delReceivedFriendRequest( $user );

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