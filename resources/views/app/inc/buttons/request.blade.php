{!! Form::open(['route' => [ 'user.friend.add', $username ]]) !!}
{{ method_field('PUT') }}
<button type="submit" class="button">Accept request</button>
{!! Form::close() !!}
{!! Form::open(['route' => [ 'user.friend.refuse', $username ]]) !!}
{{ method_field('PUT') }}
<button type="submit" class="button">Refuse request</button>
{!! Form::close() !!}