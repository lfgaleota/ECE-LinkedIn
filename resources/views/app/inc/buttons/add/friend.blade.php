{!! Form::open(['route' => [ 'user.friend.ask', $username ]]) !!}
{{ method_field('PUT') }}
<button type="submit" class="button">Send friend request</button>
{!! Form::close() !!}