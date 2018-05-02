@extends('layouts.app')

@section('content')
    @include( 'app.inc.users.list', [ 'users' => $users ] )
@endsection