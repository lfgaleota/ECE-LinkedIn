@extends('layouts.app')

@section('content')

	<div id="home" class="grid-container">
		<div class="grid-x grid-margin-x">
			<div class="cell medium-4 hide-for-small-only">
					@include( 'app.inc.users.profile-card', [ 'user' => Auth::user() ] )
		 </div>
			<div class="cell small-12 medium-8">
				<post-form></post-form>
				<tag-infinite-scroller></tag-infinite-scroller>
			</div>
		</div>
	</div>

@endsection

@section('content')
<div class="reveal" id="profileEditModal" data-reveal data-close-on-click="true"
		     data-animation-in="spin-in" data-animation-out="spin-out">
			@include('app.inc.forms.jobform')

			<button class="close-button" data-close aria-label="Close reveal" type="button">
				<span aria-hidden="true">&times;</span>
			</button>
		</div>


@endsection