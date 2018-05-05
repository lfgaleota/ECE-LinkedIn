@php($title = "Supprimer une offre d'emploi")
@extends('layouts.app', ['profile_sidebar' => true])

@section('content')
	<div class="callout card">
		<div class="card-divider">
			Supprimer une offre d'emploi
		</div>
		<div class="card-section">
			<p>Voulez-vous vraiment <b>supprimer</b> l'offre pour <b>{{ $job->position }}</b> chez <b>{{ $job->entity->name }}</b> ?</p>
			<div class="text-center">
				{!! Form::open(['route' => [ 'job.delete', $job->job_id ] ]) !!}
					{{ method_field( 'DELETE' ) }}
					<a class="button secondary" href="{{ URL::previous() }}">Non</a>
					<button class="button alert" type="submit">Oui</button>
				{!! Form::close() !!}
			</div>
		</div>
	</div>
@endsection