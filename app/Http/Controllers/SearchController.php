<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;

class SearchController extends Controller {
	public function users( Request $request ) {
		return view( 'app.search.user', [ 'query' => $request->get( 'q' ) ] );
	}
}