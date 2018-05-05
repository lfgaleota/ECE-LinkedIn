<?php

namespace App\Http\Controllers;

use App\Job;
use App\JobOffer;
use App\Snowflake;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class JobController extends Controller {
	public function store( Request $request ) {
		$validator = Validator::make( $request->all(), JobOffer::validation_create );

		if( $validator->fails() ) {
			return redirect()->back()->withErrors( $validator )->withInput();
		}

		$params = $request->all();
		$params[ 'job_id' ] = Snowflake::create( ( new JobOffer ) ->getTable() );
		$params[ 'author_id' ] = Auth::user()->user_id;

		JobOffer::create( $params );

		return redirect()->route( 'job.list' );
	}

	public function update( Request $request, $id ) {
		$validator = Validator::make( $request->all(), JobOffer::validation_update );

		if( $validator->fails() ) {
			return redirect()->back()->withErrors( $validator )->withInput();
		}

		$job = JobOffer::findOrFail( $id );

		if( !Auth::user()->hasFullEditRight() && !$job->author->isSame( Auth::user() ) ) {
			return response( 'Unauthorized.', 401 );
		}

		if( $request->has( 'position' ) ) {
			$job->position = $request->get( 'position' );
		}
		if( $request->has( 'description' ) ) {
			$job->description = $request->get( 'description' );
		}

		$job->save();

		return redirect()->route( 'job.list' );
	}

	public function create() {
		return view( 'app.job.create' );
	}

	public function edit( $id ) {
		$job = JobOffer::findOrFail( $id );

		if( !Auth::user()->hasFullEditRight() && !$job->author->isSame( Auth::user() ) ) {
			return response( 'Unauthorized.', 401 );
		}

		return view( 'app.job.edit', [ 'job' => $job ] );
	}

	public function list() {
		$jobs = JobOffer::with( 'entity' )->paginate( 20 );

		return view( 'app.job.list', [ 'jobs' => $jobs ] );
	}
}    

