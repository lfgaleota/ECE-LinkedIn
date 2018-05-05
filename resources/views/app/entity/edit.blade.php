@extends('layouts.app', ['profile_sidebar' => true])

@section('content')
	<div class="callout card">
		<div class="card-divider">
			Modifier une entreprises/école
		</div>
		<div class="card-section">
			@include( 'app.inc.forms.entity', [ 'entity' => $entity ] )
		</div>
	</div>
@endsection