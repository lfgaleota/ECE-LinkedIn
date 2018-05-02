<?php

namespace App\Http\Controllers;


use App\User;
use Illuminate\Support\Facades\Auth;

class FriendController extends Controller
{
    /**
     * @param $username
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function add($username ) {
        $user = User::whereUsername( $username )->firstOrFail();

        Auth::user()->addFriend( $user );

        return back();
    }

        public function ask($username ) {
        $user = User::whereUsername( $username )->firstOrFail();

        Auth::user()->sendFriendRequest( $user );

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
    public function remove($username ) {
        $user = User::whereUsername( $username )->firstOrFail();

        Auth::user()->removeFriend( $user );

        return back();
    }
}