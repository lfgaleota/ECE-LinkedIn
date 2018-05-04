{!! Form::open(['route' => [ 'user.network.remove', $username ]]) !!}
{{ method_field('DELETE') }}
<button type="submit" class="alert button small"><i class="fas fa-times"></i> Supprimer du réseau</button>
{!! Form::close() !!}
