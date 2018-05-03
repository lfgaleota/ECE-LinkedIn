@extends('layouts.app')

@section('content')

  <div class="grid-container">

  <div class="grid-x grid-padding-x">

  <div class="large-8 medium-8 cell">
    <div class="callout">
      <h1>Profile</h1>
      <h1>{{ $user->getName() }}</h1>
      <h2>{{ $user->title or 'No title' }}</h2>
      <h3>pouet cover pouet pp </h3>
    </div>
  </div>

  <div class="large-4 medium-4 cell">
    <div class="callout">
      <h5>Your network</h5>
      <p>Network</p>
      @include( 'app.inc.users.list', ['users' => $user->getNetworkMembers()])
    </div>
  </div>

  <div class="large-8 medium-8 cell">
    <div class="callout">
      <h5>Experience:</h5>
      <!-- Grid -->
      <div class="grid-x grid-padding-x">
        <div class="large-12 cell">
          <div class="primary callout">
            <p><strong>ECE Paris</strong> Diplome coloriage.</p>
          </div>
        </div>
      </div>
      <div class="grid-x grid-padding-x">
        <div class="large-6 medium-6 cell">
          <div class="primary callout">
            <p>kebabiste</p>
          </div>
        </div>
        <div class="large-6 medium-6 cell">
          <div class="primary callout">
            <p>6 ans</p>
          </div>
        </div>
      </div>
      <div class="grid-x grid-padding-x">
        <div class="large-4 medium-4 small-4 cell">
          <div class="primary callout">
            <p>oui</p>
          </div>
        </div>
        <div class="large-4 medium-4 small-4 cell">
          <div class="primary callout">
            <p>des fois</p>
          </div>
        </div>
        <div class="large-4 medium-4 small-4 cell">
          <div class="primary callout">
            <p>non</p>
          </div>
        </div>
      </div>
    </div>
          <hr/>
  </div>

  <div class="large-8 medium-8 cell">
    <div class="callout">
      <h5>Education:</h5>
      <!-- Grid -->
      <div class="grid-x grid-padding-x">
        <div class="large-12 cell">
          <div class="primary callout">
            <p><strong>ECE Paris</strong> Diplome coloriage.</p>
          </div>
        </div>
      </div>
      <div class="grid-x grid-padding-x">
        <div class="large-6 medium-6 cell">
          <div class="primary callout">
            <p>kebabiste</p>
          </div>
        </div>
        <div class="large-6 medium-6 cell">
          <div class="primary callout">
            <p>6 ans</p>
          </div>
        </div>
      </div>
      </div>
    </div>
          <hr />
  </div>

    <div class="large-4 medium-4 cell">

    <h5>Des boutons a utiliser maybe lol:</h5><br/>
    <p><a href="#" class="button">prout</a><br/>
    <a href="#" class="success button">pouet</a><br/>
    <a href="#" class="alert button">heh</a><br/>
    <a href="#" class="secondary button">oui</a></p>
  </div>

</div>
</div>

    @guest
        <a href="{{ route( 'index' ) }}">Connect to interact</a>
    @else
        @if( Auth::user()->isSame( $user ) )
            You are viewing your own profile
            <p>{{ $user->cover_id or '' }}</p>
            <p>{{ $user->photo_id or '' }}</p>

            <p>Network</p> <!-- if auth::user blabla or -->
            @include( 'app.inc.users.list', ['users' => $user->getNetworkMembers()])
          <p>Informations</p>
         <p><button class="button" data-toggle="profileEditModal">Edit le profil</button></p>

        <div class="reveal" id="profileEditModal" data-reveal data-close-on-click="true" data-animation-in="spin-in" data-animation-out="spin-out">
         @include( 'app.inc.forms.edit', [ 'user' => $user ])

          <button class="close-button" data-close aria-label="Close reveal" type="button">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>


        @else

            @if( Auth::user()->isInNetwork( $user ) )
                @include( 'app.inc.buttons.remove.network', [ 'username' => $user->username ] )

            @else
                @include( 'app.inc.buttons.add.network', [ 'username' => $user->username ] )
            @endif

            @if( Auth::user()->isFriend( $user ) )
                @include( 'app.inc.buttons.remove.friend', [ 'username' => $user->username ] )

            @elseif (Auth::user()->askedFriend( $user ) )
               Your request was sent
               @include( 'app.inc.buttons.remove.request', [ 'username' => $user->username ] )

            @elseif (Auth::user()->wasAskedFriend( $user ) )
                @include( 'app.inc.buttons.add.request', [ 'username' => $user->username ] )
                @include( 'app.inc.buttons.remove.request', [ 'username' => $user->username ] )

            @else
                @include( 'app.inc.buttons.add.friend', [ 'username' => $user->username ] )
            @endif

        @endif
    @endif
@endsection

@section('scripts')
    @parent

    @if($errors->any())
        <script>
            $( '#profileEditModal' ).foundation( 'open' );
        </script>
    @endif
@endsection
