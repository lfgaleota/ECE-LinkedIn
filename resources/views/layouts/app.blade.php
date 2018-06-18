@section( 'scripts' )
	<script src="{{ asset('js/app.js') }}"></script>
	<script src="https://cdn.jsdelivr.net/npm/riot@3.9/riot+compiler.min.js"></script>
@endsection

<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">

	<!-- CSRF Token -->
	<meta name="csrf-token" content="{{ csrf_token() }}">

	<title>{{ isset( $title ) ? $title . ' | ' . config('app.name') : config('app.name') }}</title>

	<!-- Styles -->
	<link href="{{ asset('css/app.css') }}" rel="stylesheet">
	@yield( 'styles' )
</head>
<body>
<div id="app">
	<nav id="menubar" class="top-bar">
		<div class="top-bar-left">
			<ul class="menu">
				<li class="hide-for-small-only">
					<img src="{{asset('images/logo-menu.png')}}" alt="Logo">
				</li>
				<li>
					<a href="{{ url('/') }}"><i class="fas fa-home"></i></a>
				</li>
				@auth
					<li class="hide-for-small-only">
						{!! Form::open(['route' => 'search.user', 'method' => 'GET']) !!}
							<input type="search" placeholder="Rechercher..." class="animated-search-form" name="q">
						{!! Form::close() !!}
					</li>
					<li class="show-for-small-only">
						<a href="{{ route( 'search.user' ) }}"><i class="fas fa-search"></i></a>
					</li>
				@endauth
			</ul>
		</div>

		<div class="top-bar-right">
			<ul class="dropdown menu" data-dropdown-menu data-disable-hover="true" data-click-open="true">
				@auth
					@if( Auth::user()->hasFullEditRight() )
						<li class="hide-for-small-only"><a href="{{ route( 'user.list' ) }}" title="Utilisateurs">Utilisateurs</a></li>
						<li class="hide-for-small-only"><a href="{{ route( 'entity.list' ) }}" title="Entreprises/Ecoles"><i class="fas fa-building"></i></a></li>
					@else
						<li class="hide-for-small-only"><a href="{{ route( 'entity.list.own' ) }}" title="Mes entreprises/écoles"><i class="fas fa-building"></i></a></li>
					@endif
					<li><a href="{{ route( 'job.list' ) }}" title="Offres d'emploi"><i class="fas fa-suitcase"></i></a></li>
					<li><a href="{{ route( 'user.network.list' ) }}" title="Mon réseau"><i class="fas fa-users"></i></a></li>
					<li>
						<a href="#">
							<i class="fas fa-bell"></i><span
									class="badge notification-badge">{{count(auth()->user()->unreadNotifications)}}</span>
						</a>
						<ul id="notificationPanel" class="menu vertical popover-panel">
							@foreach(auth()->user()->unreadNotifications as $notification)
								@php
									$filename = preg_split( "/\\\\/", $notification->type );
									$filename = strtolower( $filename[ count( $filename ) - 1 ] );
								@endphp
								<li data-notification-id="{{ $notification->id }}">
									<div class="grid-x">
										<div class="cell auto">
											@include( 'app.inc.notifications.' . $filename , [ 'notification' => $notification ])
										</div>
										<div class="cell shrink read-action">
											<span class="badge align-right"></span>
										</div>
									</div>
								</li>
							@endforeach
						</ul>
					</li>

					<li>
						<a href="{{ route( 'user.profile', [ 'username' => Auth::user()->username ] ) }}"><i
									class="fas fa-user-circle"></i></a>
						<ul class="menu vertical popover-panel">

							<li>
								<a href="{{ route( 'user.profile', [ 'username' => Auth::user()->username ] ) }}">
									Mon profil
								</a>

							</li>
							@if( Auth::user()->hasFullEditRight() )
								<li class="show-for-small-only"><a href="{{ route( 'user.list' ) }}" title="Utilisateurs">Utilisateurs</a></li>
								<li class="show-for-small-only"><a href="{{ route( 'entity.list' ) }}" title="Entreprises/Ecoles">Entreprises/Ecoles</a></li>
							@else
								<li class="show-for-small-only"><a href="{{ route( 'entity.list.own' ) }}" title="Mes entreprises/écoles">Mes entreprises/écoles</a></li>
							@endif
							<li>
								<a href="{{ route('logout') }}"
								   onclick="event.preventDefault();
                                    document.getElementById('logout-form').submit();">
									Déconnexion
								</a>

								<form id="logout-form" action="{{ route('logout') }}" method="POST"
								      style="display: none;">
									{{ csrf_field() }}
								</form>
							</li>
						</ul>
					</li>
				@else
					@if(!isset($is_index) || !$is_index)
						<li class="hide-for-small-only"><a href="{{ url( '/' ) }}">Connexion</a></li>
						<li class="hide-for-small-only"><a href="{{ url( '/#register' ) }}">Inscription</a></li>
						<li class="show-for-small-only"><a href="{{ url( '/' ) }}"><i class="fas fa-sign-in-alt"></i></a></li>
					@endif
				@endauth
			</ul>
		</div>
	</nav>

	@if( isset( $profile_sidebar ) && $profile_sidebar )
		<div id="home" class="grid-container">
			<div class="grid-x grid-margin-x">
				<div class="cell medium-4 large-3 hide-for-small-only" data-sticky-container>
					@php
					if( isset( $profile_sticky ) && !$profile_sticky ) {
						$carddata = [ 'user' => Auth::user() ];
					} else {
						$carddata = [ 'user' => Auth::user(), 'sticky' => [ 'element' => 'userList', 'top' => '4' ] ];
					}
					@endphp
					@include( 'app.inc.users.profile-card', $carddata )
					@yield('sidebar')
				</div>
				<div class="cell small-12 medium-8 large-9" id="userList">
					@yield('content')
				</div>
			</div>
		</div>
	@else
		@yield('content')
	@endif
</div>

<!-- Scripts -->
@yield( 'scripts' )
<script>
	$( '#notificationPanel li .read-action' ).click( function() {
		let notificationLine = $( this ).parent().parent();
		let notification_id = notificationLine.attr( 'data-notification-id' );
		window.axios.post( '{{ url('api/notification') }}/' + notification_id + '/read' ).then( function( response ) {
			notificationLine.remove();
			console.log( response );
		} ).catch( function( error ) {
			notificationLine.remove();
			console.log( error );
		} );
	} );
</script>
</body>
</html>