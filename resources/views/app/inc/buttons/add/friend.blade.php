{!! Form::open(['route' => [ 'user.friend.add', $username ]]) !!}
{{ method_field('PUT') }}
<button type="submit" class="button">Add as friend</button>
{!! Form::close() !!}