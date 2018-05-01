{!! Form::open(['route' => [ 'user.friend.remove', $username ]]) !!}
{{ method_field('DELETE') }}
<button type="submit" class="button">Remove friend</button>
{!! Form::close() !!}