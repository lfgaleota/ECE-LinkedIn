{!! Form::open(['route' => [ 'user.friend.remove', $username ]]) !!}
{{ method_field('DELETE') }}
<button type="submit" class="alert button small"><i class="fas fa-user-times"></i></button>
{!! Form::close() !!}
