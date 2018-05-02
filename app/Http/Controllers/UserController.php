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