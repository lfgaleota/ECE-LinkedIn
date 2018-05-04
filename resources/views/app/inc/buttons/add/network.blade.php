{!! Form::open(['route' => [ 'user.network.add', $username ]]) !!}
{{ method_field('PUT') }}
<button type="submit" class="button small"><i class="fas fa-plus"></i> Ajouter à votre réseau</button>
{!! Form::close() !!}