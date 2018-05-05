<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;

class IndexController extends Controller {
    public function get() {
        if( Auth::check() ) {
            return view( 'index' );
        }
        return view( 'index' );
    }
}