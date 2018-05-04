{!! Form::open(['route' => [ 'user.friend.ask.delete', $username ]]) !!}
{{ method_field('DELETE') }}
<button type="submit" class="secondary button small"><i class="fas fa-user-times"></i> Enlever la demande d'ami</button>
{!! Form::close() !!}
