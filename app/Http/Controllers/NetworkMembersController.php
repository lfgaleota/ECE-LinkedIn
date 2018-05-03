<?php

namespace App\Http\Controllers;


use App\User;
use Illuminate\Support\Facades\Auth;

class NetworkMembersController extends Controller
{
    public function get() {
        return response()->json( Auth::user()->getNetworkMembers() );
    }

    /**
     * @param $username
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function add( $username ) {
        $user = User::whereUsername( $username )->firstOrFail();

        Auth::user()->addToNetwork( $user );

        return back();
    }

    /**
     * @param $username
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function remove( $username ) {
        $user = User::whereUsername( $username )->firstOrFail();

        Auth::user()->removeFromNetwork( $user );

        return back();
    }
}