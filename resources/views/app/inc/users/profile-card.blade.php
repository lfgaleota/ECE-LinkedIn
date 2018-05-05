@if( !isset( $frame ) || $frame )
	<div class="callout profile-header-card" {!! isset( $sticky ) ? 'data-sticky data-anchor="' . $sticky[ 'element' ] . '" data-margin-top="' . $sticky[ 'top' ] . '"' : '' !!}>
		@endif
		<div class="header" @if($user->cover_url) style="background-image: url({{ $user->cover_url }});" @endif>
			<img src="{{ $user->photo_url or \App\User::default_photo_url }}"/>
		</div>
		<div class="summary">
			<h5>{{ $user->getName() }}</h5>
			<h6>{{ $user->title or 'Libre' }}</h6>
		</div>
		@if( !isset( $frame ) || $frame )
	</div>
@endif