@extends('layouts.app', ['profile_sidebar' => true])

@section('content')
	<section class="job-offer">
		<div class="callout card header">
			<div class="card-section">
				<div class="grid-x grid-margin-x">
					<div class="cell shrink">
						<img src="{{ $job->entity->photo_url or \App\Entity::default_photo_url }}" />
					</div>
					<div class="cell auto">
						<p class="position">{{ $job->position }}</p>
						<p class="entity">{{ $job->entity->name }} · {{ $job->entity->location }}</p>
						<p class="date">Publié <span class="content">{{ $job->created_at }}</span></p>
						<a class="button">Postuler</a>
					</div>
				</div>
			</div>
		</div>
		<div class="callout card description">
			<div class="card-divider">
				Description du poste
			</div>
			<div class="card-section">{{ $job->description }}</div>
		</div>
		@include( 'app.inc.entities.small-card', [ 'entity' => $job->entity ] )
	</section>
@endsection

@section('styles')
	@parent
	{{ Html::style( 'css/job-offer.css' ) }}
@endsection

@section('scripts')
	@parent
	{{ Html::script( 'js/job-offer.js' ) }}
@endsection