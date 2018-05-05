@extends('layouts.app')

@section('content')
	<div id="home" class="grid-container">
		<div class="grid-x grid-margin-x">
			<div class="cell medium-4 large-3 hide-for-small-only" data-sticky-container>
				@include( 'app.inc.users.profile-card', [ 'user' => Auth::user(), 'sticky' => [ 'element' => 'userList', 'top' => '4' ] ] )
			</div>
			<div class="cell small-12 medium-8 large-9" id="userList">
				@if(count($inviters) > 0)
					<div class="callout card">
						<div class="card-divider">
							Invitations
						</div>
						<div class="card-section">
							@include( 'app.inc.users.list', [ 'users' => $inviters, 'buttons' => true ] )
						</div>
					</div>
				@endif
				<div class="callout card">
					<div class="card-divider">
						Réseau
					</div>
					<div class="card-section">
						@include( 'app.inc.users.list', [ 'users' => $networkmembers ] )
					</div>
				</div>
			</div>
		</div>
	</div>
@endsection
