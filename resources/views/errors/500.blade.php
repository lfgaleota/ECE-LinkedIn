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
				<h1>J'ai glissé, Chef</h1>
				<p>Une erreur inattendu est survenue.</p>
			</div>
		</div>
	</div>
@endsection
