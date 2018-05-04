<nav id="menubar" class="top-bar">
	<div class="top-bar-left">
		<ul class="menu">
			<li>
				<img src="{{asset('img/logo-menu.png')}}" alt="Logo">
			</li>
			<li>
				<a href="{{ url('/') }}"><i class="fas fa-home"></i></a>
			</li>
			@auth
				<li>
					<form>
						<input type="search" placeholder="Recherche" class="animated-search-form">
					</form>
				</li>
			@endauth
		</ul>
	</div>

	<div class="top-bar-right">
		<ul class="dropdown menu" data-dropdown-menu>
			@auth
				<li><a href="{{ route( 'user.network.list' ) }}"><i class="fas fa-users"></i></a></li>
				<li><a href="#"><i class="fas fa-envelope"></i></a></li>
				<li>
					<a href="#">
						<i class="fas fa-bell"></i><span class="badge">{{count(auth()->user()->unreadNotifications)}}</span>
					</a>
					<ul class="menu vertical">
						<li>
							@foreach(auth()->user()->unreadNotifications as $notification)
								<a href="#"><?php var_dump( $notification ); ?></a>
							@endforeach
						</li>

					</ul>
				</li>

				<li>
					<a href="{{ route( 'user.profile', [ 'username' => Auth::user()->username ] ) }}"><i
								class="fas fa-user-circle"></i></a>
					<ul class="menu vertical">

						<li>
							<a href="{{ route( 'user.profile', [ 'username' => Auth::user()->username ] ) }}">
								Mon profil
							</a>

						</li>

						<li>
							<a href="{{ route('logout') }}"
							   onclick="event.preventDefault();
                                               document.getElementById('logout-form').submit();">
								Déconnexion
							</a>

							<form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
								{{ csrf_field() }}
							</form>
						</li>
					</ul>
				</li>
			@else
				<li><a href="{{ url( '/' ) }}">Connexion</a></li>
				<li><a href="{{ url( '/' ) }}">Inscription</a></li>
			@endauth
		</ul>
	</div>
</nav>
