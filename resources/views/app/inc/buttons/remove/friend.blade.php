{!! Form::open(['route' => [ 'user.friend.remove', $username ]]) !!}
{{ method_field('DELETE') }}
<button type="submit" class="alert button">Remove friend</button>
{!! Form::close() !!}
