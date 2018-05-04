@extends('layouts.app')

@section('content')

@guest
    <a href="{{ route( 'index' ) }}">Connect to interact</a>
@else

  <div class="grid-container">

  <div class="grid-x grid-padding-x">
  <div class="large-8 medium-8 cell">
    <div class="callout">
      <h1>{{ $user->getName() }}</h1>
      <h2>{{ $user->title or 'No title' }}</h2>
      <p>{{ $user->cover_id or '' }}</p>
      <p>{{ $user->photo_id or '' }}</p>
      <h3>pouet cover pouet pp </h3>

      @if( ! Auth::user()->isSame( $user ) )
        @if( Auth::user()->isInNetwork( $user ) )
            @include( 'app.inc.buttons.remove.network', [ 'username' => $user->username ] )

        @else
            @include( 'app.inc.buttons.add.network', [ 'username' => $user->username ] )
        @endif

        @if( Auth::user()->isFriend( $user ) )
            @include( 'app.inc.buttons.remove.friend', [ 'username' => $user->username ] )

        @elseif (Auth::user()->askedFriend( $user ) )
           Your request was sent
           @include( 'app.inc.buttons.remove.request.remove', [ 'username' => $user->username ] )

        @elseif (Auth::user()->wasAskedFriend( $user ) )
            @include( 'app.inc.buttons.add.request', [ 'username' => $user->username ] )
            @include( 'app.inc.buttons.remove.request.refuse', [ 'username' => $user->username ] )

        @else
            @include( 'app.inc.buttons.add.friend', [ 'username' => $user->username ] )
        @endif

  @endif

    </div>
  </div>

  <div class="large-4 medium-4 cell">
    <div class="callout">
      <h5>Network</h5>
      @include( 'app.inc.users.list', ['users' => $user->getNetworkMembers()])
    </div>
  </div>

  <div class="large-8 medium-8 cell">
    <div class="callout card profile-content-card">
      <div class="card-divider">
          Experience
      </div>
      <div class="card-section">
          <!-- Grid -->
          <div class="grid-x grid-padding-x">
            <div class="large-12 cell">
                <p><strong>ECE Paris</strong> Diplome coloriage.</p>
            </div>
          </div>

            <hr>
            <div class="grid-x grid-padding-x">
              <div class="large-12 cell">
                  <p><strong>ECE Paris</strong> Diplome coloriage.</p>
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
        <hr />
    </div>
          <hr />

    <div class="large-8 medium-8 cell">
      <div class="callout">
        <h5>Skills</h5>
        <!-- Grid -->
        <div class="grid-x grid-padding-x">
          <div class="large-12 cell">
              <p><strong>ECE Paris</strong> Diplome coloriage.</p>
          </div>
        </div>

          <hr/>
          <div class="grid-x grid-padding-x">
            <div class="large-12 cell">
                <p><strong>ECE Paris</strong> Diplome coloriage.</p>
            </div>
          </div>
      </div>
            <hr/>
    </div>
  </div>

    <div class="large-4 medium-4 cell">

    <h5></h5><br/>

    @if( Auth::user()->isSame( $user ) )
      <div class="grid-x grid-padding-x">
        <div class="large-6 medium-6 cell">
            <p><button type="submit" class="button" data-toggle="profileEditModal">Edit the Profile</button>
        </div>
      </div>
  </div>

  <div class="reveal" id="profileEditModal" data-reveal data-close-on-click="true" data-animation-in="spin-in" data-animation-out="spin-out">
   @include( 'app.inc.forms.edit', [ 'user' => $user ])

    <button class="close-button" data-close aria-label="Close reveal" type="button">
      <span aria-hidden="true">&times;</span>
    </button>
  </div>

@endif

@section('scripts')
    @parent

    @if($errors->any())
        <script>
            $( '#profileEditModal' ).foundation( 'open' );
        </script>
    @endif
@endsection

@endif

</div>
</div>

@endsection
