@php($title = 'Page non trouvée')
@php($same_background = true)
@php($vertically_centered = true)
@extends('layouts.app')

@section('content')
	<div class="grid-container">
		<div class="grid-x grid-padding-x">
			<div class="cell  medium-5 large-4">
				<div class="text-center show-for-small-only">
					<img src="{{asset('images/logo-dead.png')}}" alt="Logo">
				</div>
				<div class="text-right hide-for-small-only">
					<img src="{{asset('images/logo-dead.png')}}" alt="Logo">
				</div>
			</div>

			<div class="cell small-12 medium-7 large-8">
				<h1>Page non trouvée</h1>
				@auth
					<p>Vous pouvez essayer de <a href="{{ route( 'search.user' ) }}">rechercher</a> ce que vous souhaitez voir.</p>
				@else
					<p><a href="{{ route( 'index' ) }}">Vous connecter</a> vous permettrai peut-être d'accéder à cette ressource.</p>
				@endauth
			</div>
		</div>
	</div>
@endsection
