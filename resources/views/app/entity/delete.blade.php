@extends('layouts.app', ['profile_sidebar' => true])

@section('content')
	<div class="callout card">
		<div class="card-divider">
			Supprimer une entreprise/école
		</div>
		<div class="card-section">
			<p>Voulez-vous vraiment <b>supprimer</b> l'entreprise/école <b>{{ $entity->name }}</b> ?</p>
			<p>Toutes les offres d'emploi associées seront supprimées.</p>
			<div class="text-center">
				{!! Form::open(['route' => [ 'entity.delete', $entity->entity_id ] ]) !!}
					{{ method_field( 'DELETE' ) }}
					<a class="button secondary" href="{{ URL::previous() }}">Non</a>
					<button class="button alert" type="submit">Oui</button>
				{!! Form::close() !!}
			</div>
		</div>
	</div>
@endsection