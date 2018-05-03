@extends('layouts.app')

@section('content')

    <div class="grid-container">
    <div class="grid-x grid-padding-x">

    <div class="large-12 cell">
      <div class="callout">
        <h3>Network</h3>

      @include( 'app.inc.users.list', [ 'users' => $networkmembers ] )

    </div>
  </div>
  </div>
</div>

@endsection
