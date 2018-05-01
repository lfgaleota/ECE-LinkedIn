{!! Form::open(['route' => [ 'user.network.add', $username ]]) !!}
{{ method_field('PUT') }}
<button type="submit" class="button">Add to network</button>
{!! Form::close() !!}