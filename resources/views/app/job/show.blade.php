@extends('layouts.app', ['profile_sidebar' => true])

@section('content')
	@if( Session::has( 'success' ) )
		<div class="callout card success">
			{{ Session::get( 'success' ) }}
		</div>
	@endif
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
						@if( !$job->author->isSame( Auth::user() ) )
							<a class="button" data-open="applicationForm">Postuler</a>
						@endif
					</div>
				</div>
				@if( $job->author->isSame( Auth::user() ) || Auth::user()->hasFullEditRight() )
					<a class="button secondary tiny edit" href="{{ route( 'job.edit', [ 'job' => $job->job_id ] ) }}"><i class="fas fa-edit"></i></a>
					<a class="button alert tiny remove" href="{{ route( 'job.delete.ask', [ 'job' => $job->job_id ] ) }}"><i class="fas fa-times"></i></a>
				@endif
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
	@if( !$job->author->isSame( Auth::user() ) )
		<div class="reveal" id="applicationForm" data-reveal>
			{!! Form::open(['route' => [ 'job.apply', $job->job_id ] ]) !!}
			<div class="content">
				<input type="hidden" name="apply" value="true" />
				<div>
					{{ Form::label('coverLetter', 'Lettre de motivation', ['class' => ($errors->has('coverLetter') ? 'is-invalid-label' : '')]) }}
					{{ Form::textarea('coverLetter', null, ['required' => true, 'class' => ($errors->has('coverLetter') ? 'is-invalid-input' : '')]) }}
					@if ($errors->has('coverLetter'))
						<span class="form-error is-visible">
						{{ $errors->first('coverLetter') }}
					</span>
					@endif
				</div>
			</div>
			<div class="toolbar">
				<button class="button success" type="submit"><i class="fas fa-paper-plane"></i></button>
				<button class="button alert" type="button" data-close><i class="fas fa-times"></i></button>
			</div>
			{!! Form::close() !!}
		</div>
	@endif
@endsection

@section('styles')
	@parent
	{{ Html::style( 'css/job-offer.css' ) }}
@endsection

@section('scripts')
	@parent
	{{ Html::script( 'js/job-offer.js' ) }}
	@if($errors->any())
		<script>
			$( '#applicationForm' ).foundation( 'open' );
		</script>
	@endif
@endsection