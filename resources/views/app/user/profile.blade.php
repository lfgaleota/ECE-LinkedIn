@php($title = $user->getName())
@extends('layouts.app')

@section('content')

	<div class="grid-container">
		<div class="grid-x grid-padding-x">
			<div class="large-8 medium-8 cell">
				<div class="callout profile-header-card">
					@include( 'app.inc.users.profile-card', [ 'user' => $user, 'frame' => false ] )

					@guest
						<div class="interact">
							<a href="{{ url('/') }}">Connectez-vous pour intéragir</a>
						</div>
					@else
						@if( Auth::user()->role == 'ADMIN' || Auth::user()->isSame( $user ) )
							<button type="submit" class="edit button tiny secondary" data-toggle="profileEditModal"><i class="fas fa-edit"></i></button>
						@endif
						@if( !Auth::user()->isSame( $user ) )
							<div class="interact">
								@if( $user->isInNetwork( Auth::user() ) )
									@include( 'app.inc.buttons.remove.network', [ 'username' => $user->username ] )
								@else
									@include( 'app.inc.buttons.add.network', [ 'username' => $user->username ] )
								@endif

								@if( Auth::user()->isFriend( $user ) )
									@include( 'app.inc.buttons.remove.friend', [ 'username' => $user->username ] )

								@elseif (Auth::user()->askedFriend( $user ) )
									@include( 'app.inc.buttons.remove.request.remove', [ 'username' => $user->username ] )

								@elseif (Auth::user()->wasAskedFriend( $user ) )
									@include( 'app.inc.buttons.add.request', [ 'username' => $user->username ] )
									@include( 'app.inc.buttons.remove.request.refuse', [ 'username' => $user->username ] )

								@else
									@include( 'app.inc.buttons.add.friend', [ 'username' => $user->username ] )
								@endif
							</div>
						@endif
					@endguest
				</div>

				@auth
					<education-renderer></education-renderer>
					<experience-renderer></experience-renderer>
					<skill-renderer></skill-renderer>
				@endauth
			</div>

			@if( Auth::user()->role == 'ADMIN' || Auth::user()->isInNetwork( $user ) )
				<div class="large-4 medium-4 cell profile-network-card">
					<div class="callout card">
						<div class="card-divider">Réseau</div>
						<div class="card-section profile-network-content">
							@include( 'app.inc.users.list', ['users' => $user->getNetworkMembers()])
						</div>
					</div>
				</div>
			@endif
		</div>
	</div>

	@if( Auth::user()->role == 'ADMIN' || Auth::user()->isSame( $user ) )
		<div class="reveal" id="profileEditModal" data-reveal data-close-on-click="true"
		     data-animation-in="spin-in" data-animation-out="spin-out">
			@include( 'app.inc.forms.user-edit', [ 'user' => $user ])

			<button class="close-button" data-close aria-label="Close reveal" type="button">
				<span aria-hidden="true">&times;</span>
			</button>
		</div>
	@endif
@endsection

@section('scripts')
	@parent
	@include('app.inc.tags')

	@if($errors->any())
		<script>
			$( '#profileEditModal' ).foundation( 'open' );
		</script>
	@endif
	<script>
		let canEdit = {{ Auth::user()->role == 'ADMIN' || Auth::user()->isSame( $user ) ? 'true' : 'false' }};
		let username = '{!! str_replace( "'", "\'", $user->username ) !!}';
		let infos = '{!! str_replace( "'", "\'", $user->infos ) !!}';
		infos = ( infos.length > 0 ? JSON.parse( infos ) : {} );
		window.riot.mount( 'education-renderer', { baseapipath: '{{ url( 'api' ) }}', initialitems: infos[ 'education' ], username: username, canedit: canEdit } );
		window.riot.mount( 'experience-renderer', { baseapipath: '{{ url( 'api' ) }}', initialitems: infos[ 'experience' ], username: username, canedit: canEdit } );
		window.riot.mount( 'skill-renderer', { baseapipath: '{{ url( 'api' ) }}', initialitems: infos[ 'skill' ], username: username, canedit: canEdit } );
	</script>
@endsection