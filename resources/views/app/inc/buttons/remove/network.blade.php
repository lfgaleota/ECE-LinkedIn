{!! Form::open(['route' => [ 'user.network.remove', $username ]]) !!}
{{ method_field('DELETE') }}
<button type="submit" class="button">Remove from network</button>
{!! Form::close() !!}