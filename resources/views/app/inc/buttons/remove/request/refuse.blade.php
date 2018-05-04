{!! Form::open(['route' => [ 'user.friend.ask.refuse', $username ]]) !!}
{{ method_field('DELETE') }}
<button type="submit" class="secondary button">Refuse request</button>
{!! Form::close() !!}
