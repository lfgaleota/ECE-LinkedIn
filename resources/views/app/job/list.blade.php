@extends('layouts.app', ['profile_sidebar' => true])

@section('content')
	<section class="callout card job">
		<div class="card-divider">
			Offres d'emploi
			@if( isset( $editable ) && $editable )
				<a href="{{ route( 'entity.create' ) }}" class="button tiny success force-right"><i class="fas fa-plus"></i></a>
			@endif
		</div>
		<div class="card-section">
			<div class="grid-x grid-margin-x">
				@foreach( $jobs as $job )
					<a class="cell thumbnail job-offer small-12 medium-6 large-4" href="{{ route( 'job.show', [ 'id' => $job->job_id ] ) }}">
						<p class="entity-photo"><img src="{{ $job->entity->photo_url or \App\Entity::default_photo_url }}" /></p>
						<p class="position">{{ $job->position }}</p>
						<p class="entity-name">{{ $job->entity->name }}</p>
						<p class="entity-location">{{ $job->entity->location }}</p>
						<div class="fill"></div>
						<p class="date">{{ $job->created_at }}</p>
					</a>
				@endforeach
			</div>

			{{ $jobs->links() }}
		</div>
	</section>
@endsection

@section('styles')
	@parent
	{{ Html::style( 'css/job-list.css' ) }}
@endsection

@section('scripts')
	@parent
	{{ Html::script( 'js/job-list.js' ) }}
@endsection