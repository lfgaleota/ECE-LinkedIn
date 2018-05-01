<?php

namespace App\Http\Controllers;


use App\User;
use Illuminate\Support\Facades\Auth;

class FriendController extends Controller
{
    public function list() {
        $users = Auth::user()->selectorFriends()->paginate( 20 );

        return view( 'app.friends.list', [
            'users' => $users
        ]);
    }

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