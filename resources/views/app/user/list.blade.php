@extends('layouts.app')

@section('content')
    <ul>
        @foreach( $users as $user )
            <li><a href="{{ route( 'user.profile', [ 'username' => $user->username ] ) }}">{{ $user->getName() }}</a></li>
        @endforeach
    </ul>

    {{ $users->links() }}
@endsection