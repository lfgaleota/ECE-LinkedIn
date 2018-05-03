@foreach( $users as $user )
<?php $relation=' ';?>
	
	@if($user->hasFriendOf())
		@if($user->isFriendOf)
		<?php $relation=' (Friend)';?>

		@else
		<?php $relation=' ';?>

		@endif

	@endif

    <li><a href="{{ route( 'user.profile', [ 'username' => $user->username ] ) }}">{{ $user->getName()}} {{$relation}} </a></li>
@endforeach

{{ method_exists( $users, 'links' ) ? $users->links() : '' }}