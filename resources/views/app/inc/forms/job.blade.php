<div class="job-form">
	@if( isset($job) && $job != null )
		{!! Form::model($job, ['route' => ['job.update', $job->job_id]]) !!}
	@else
		{!! Form::open(['route' => 'job.store']) !!}
		{{ method_field('PUT') }}
	@endif

	<div>
		{{ Form::label('position', 'Poste', ['class' => ($errors->has('position') ? 'is-invalid-label' : '')]) }}
		{{ Form::text('position', null, ['required' => true, 'class' => ($errors->has('position') ? 'is-invalid-input' : '')]) }}
		@if ($errors->has('position'))
			<span class="form-error is-visible">
				{{ $errors->first('position') }}
			</span>
		@endif
	</div>

	@if( !isset($job) || $job == null )
		<div>
			{{ Form::label('entity_open', 'Entreprise/Ecole', ['class' => ($errors->has('entity_id') ? 'is-invalid-label' : '')]) }}
			<button id="post_entity_selector" class="button" type="button" name="entity_open">
				Sélectionner <span id="post_entity_isselected" style="display: none">
			<i class="fa fa-check"></i>
		</span>
			</button>
			<input type="hidden" name="entity_id" value="" />
			@if ($errors->has('entity_id'))
				<span class="form-error is-visible">
			{{ $errors->first('entity_id') }}
		</span>
			@endif
		</div>
	@endif

	<div>
		{{ Form::label('description', 'Description', ['class' => ($errors->has('description') ? 'is-invalid-label' : '')]) }}
		{{ Form::textarea('description', null, ['required' => true, 'class' => ($errors->has('description') ? 'is-invalid-input' : '')]) }}
		@if ($errors->has('description'))
			<span class="form-error is-visible">
				{{ $errors->first('description') }}
			</span>
		@endif
	</div>

	<div>
		@if( isset($job) && $job != null )
			{{ Form::submit('Modifier', ['class' => 'button expanded']) }}
		@else
			{{ Form::submit('Créer', ['class' => 'button expanded']) }}
		@endif
	</div>
	{!! Form::close() !!}
</div>