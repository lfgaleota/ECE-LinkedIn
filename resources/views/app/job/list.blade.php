@extends('layouts.app', ['profile_sidebar' => true])

@section('content')
	@foreach( $jobs as $job )

			<div class="cell auto">
				<h1>{{ $job->position }}</h1>
				<h2>{{ $job->entity->name }}</h2>
				<p>{{ $job->description }}</p>
			</div>

	@endforeach

	{{ $jobs->links() }}
@endsection