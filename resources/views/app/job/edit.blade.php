@extends('layouts.app', ['profile_sidebar' => true])

@section('content')
	<div class="callout card">
		<div class="card-divider">
			Modifier une offre d'emploi
		</div>
		<div class="card-section">
			@include( 'app.inc.forms.job', [ 'job' => $job ] )
		</div>
	</div>
@endsection