@extends('layouts.app')

@section('content')
    @foreach( $users as $user )
        <li><a href="{{ route( 'user.profile', [ 'username' => $user->username ] ) }}">{{ $user->getName() }}</a></li>
    @endforeach

    {{ $users->links() }}
@endsection