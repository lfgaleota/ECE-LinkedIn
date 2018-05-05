@php($title = 'Créer une entreprises/école')
@extends('layouts.app', ['profile_sidebar' => true])

@section('content')
	<div class="callout card">
		<div class="card-divider">
			Créer une entreprises/école
		</div>
		<div class="card-section">
			@include( 'app.inc.forms.entity' )
		</div>
	</div>
@endsection