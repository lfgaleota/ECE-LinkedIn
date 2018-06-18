<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;

class IndexController extends Controller {
	public function get() {
		if( Auth::check() ) {
			return view( 'app.home' );
		}
		return view( 'guest.welcome' );
	}
}