{!! Form::open(['route' => [ 'user.friend.ask.delete', $username ]]) !!}
{{ method_field('DELETE') }}
<button type="submit" class="secondary button">Remove request</button>
{!! Form::close() !!}
