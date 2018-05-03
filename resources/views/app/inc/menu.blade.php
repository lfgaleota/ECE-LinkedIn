<nav class="navbar navbar-default navbar-static-top">

  <nav class="top-bar">
      <div class="top-bar-left">
          <ul class="menu">
              <li class="menu-text"><img src="{{asset('img/home.png')}}" alt="network" width="30" height="75"></li>
              <li><input type="search" placeholder="Recherche" class="animated-search-form"></li>
              <li><button type="button" class="button">Search</button></li>
          </ul>
      </div>

      <div class="top-bar-right">
          <ul class="dropdown menu" data-dropdown-menu>
            <li><img src="{{asset('img/network.png')}}" alt="network" width="30" height="75"></li>
              <li><img src="{{asset('img/messaging.png')}}" alt="messaging" width="30" height="75"></li>
              <li><img src="{{asset('img/notification.png')}}" alt="notification" width="30" height="75"></li>
              <li><li>
                  <img src="{{asset('img/user.png')}}" alt="user" width="30" height="75">
                  <ul class="menu vertical">
                      <li><a href="#">Mon profile</a></li>
                      <li><a href="#">Mon reseau</a></li>
                      <li><a href="#">Parametres</a></li>
                  </ul>
              </li></li>
          </ul>
      </div>

    </nav>
    <div class="container">
        <div class="navbar-header">

            <!-- Collapsed Hamburger -->
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#app-navbar-collapse" aria-expanded="false">
                <span class="sr-only">Toggle Navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>

            <!-- Branding Image -->
            <a class="navbar-brand" href="{{ url('/') }}">
                {{ config('app.name', 'Laravel') }}
            </a>
        </div>

        <div class="collapse navbar-collapse" id="app-navbar-collapse">
            <!-- Left Side Of Navbar -->
            <ul class="nav navbar-nav">
                @auth
                    <li><a href="{{ route( 'user.list' ) }}">Users</a></li>
                    <li><a href="{{ route( 'user.network.list' ) }}">Network</a></li>
                @endif
            </ul>

            <!-- Right Side Of Navbar -->
            <ul class="nav navbar-nav navbar-right">
                @auth
                    <li class="dropdown">
                        <a href="{{ route( 'user.profile', [ 'username' => Auth::user()->username ] ) }}" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false" aria-haspopup="true">
                            {{ Auth::user()->name }} <span class="caret"></span>
                        </a>

                        <ul class="dropdown-menu">
                            <li>
                                <a href="{{ route('logout') }}"
                                   onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                    Logout
                                </a>

                                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                    {{ csrf_field() }}
                                </form>
                            </li>
                        </ul>
                    </li>
                @endguest
            </ul>
        </div>
    </div>
</nav>
