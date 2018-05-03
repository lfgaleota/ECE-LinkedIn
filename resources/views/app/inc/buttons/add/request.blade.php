{!! Form::open(['route' => [ 'user.friend.add', $username ]]) !!}
{{ method_field('PUT') }}
<button type="submit" class="button">Accept request</button>
{!! Form::close() !!}
