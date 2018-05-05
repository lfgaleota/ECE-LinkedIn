@php($title = $entity->name )
@extends('layouts.app', ['profile_sidebar' => true])

@section('content')
	@include( 'app.inc.entities.small-card', [ 'entity' => $entity ] )
@endsection