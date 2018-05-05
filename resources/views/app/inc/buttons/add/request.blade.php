{!! Form::open(['route' => [ 'user.friend.add', $username ]]) !!}
{{ method_field('PUT') }}
<button type="submit" class="success button small"> Accepter la demande d'ami</button>
{!! Form::close() !!}
