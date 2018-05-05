@foreach( $users as $user )
	<a href="{{ route( 'user.profile', [ 'username' => $user->username ] ) }}" class="friend-line grid-x grid-padding-x">
		<div class="cell shrink">
			<img src="{{ $user->photo_url or \App\User::default_photo_url }}" />
		</div>
		<div class="cell auto">
			<p>{{ $user->getName()}}</p>
		</div>
	</a>
@endforeach

{{ method_exists( $users, 'links' ) ? $users->links() : '' }}