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

    <title>{{ config('app.name') }}</title>

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    @yield( 'styles' )
</head>
<body>
    <div id="app">
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
                        <ul id="notificationPanel" class="menu vertical">
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

        @yield('content')
    </div>

    <!-- Scripts -->
    @yield( 'scripts' )
    <script>
        $( '#notificationPanel li .read-action' ).click(function() {
            let notificationLine = $( this ).parent().parent();
            let notification_id = notificationLine.attr( 'data-notification-id' );
            window.axios.post( '{{ url('api/notification') }}/' + notification_id + '/read' ).then(function( response ) {
                notificationLine.remove();
                console.log( response );
            }).catch( function( error ) {
                notificationLine.remove();
                console.log( error );
            });
        });
    </script>
</body>
</html>