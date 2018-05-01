@extends('layouts.app')

@section('content')
    <h1>{{ $user->getName() }}</h1>
    <h2>{{ $user->title or 'No title' }}</h2>
    @guest
        <a href="{{ route( 'index' ) }}">Connect to interact</a>
    @else
        @if( Auth::user()->isSame( $user ) )
            You are viewing your own profile
        @else
            @if( Auth::user()->isInNetwork( $user ) )
                @include( 'app.inc.buttons.remove.network', [ 'username' => $user->username ] )
            @else
                @include( 'app.inc.buttons.add.network', [ 'username' => $user->username ] )
            @endif
            @if( Auth::user()->isFriend( $user ) )
                @include( 'app.inc.buttons.remove.friend', [ 'username' => $user->username ] )
            @else
                @include( 'app.inc.buttons.add.friend', [ 'username' => $user->username ] )
            @endif
        @endif
    @endif
@endsection