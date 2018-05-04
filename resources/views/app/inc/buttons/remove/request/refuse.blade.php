{!! Form::open(['route' => [ 'user.friend.ask.refuse', $username ]]) !!}
{{ method_field('DELETE') }}
<button type="submit" class="secondary button small">Refuser la demande d'ami</button>
{!! Form::close() !!}
