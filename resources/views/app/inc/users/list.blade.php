@foreach( $users as $user )
	@if($user->hasFriendOf())
	@if($user->isFriendOf)
	is your friend
	@else
	is not your friend
	@endif
	@endif
    <li><a href="{{ route( 'user.profile', [ 'username' => $user->username ] ) }}">{{ $user->getName() }}</a></li>
@endforeach

{{ method_exists( $users, 'links' ) ? $users->links() : '' }}