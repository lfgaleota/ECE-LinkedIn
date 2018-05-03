{!! Form::open(['route' => [ 'user.friend.ask.refuse', $username ]]) !!}
{{ method_field('DELETE') }}
<button type="submit" class="button">Remove request</button>
{!! Form::close() !!}