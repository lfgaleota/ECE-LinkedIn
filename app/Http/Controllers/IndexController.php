<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;

class IndexController extends Controller {
    public function get() {
        if( Auth::check() ) {
            $timeline = Auth::user()->selectorTimeline()->paginate( 20 );
            return view( 'index', [
                'timeline' => $timeline
            ]);
        }
        return view( 'index' );
    }
}