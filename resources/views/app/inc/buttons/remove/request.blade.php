{!! Form::open(['route' => [ 'user.friend.refuse', $username ]]) !!}
{{ method_field('PUT') }}
<button type="submit" class="button">Remove request</button>
{!! Form::close() !!}