{!! Form::open(['route' => [ 'user.friend.ask', $username ]]) !!}
{{ method_field('PUT') }}
<button type="submit" class="button small"><i class="fas fa-user-plus"></i></button>
{!! Form::close() !!}