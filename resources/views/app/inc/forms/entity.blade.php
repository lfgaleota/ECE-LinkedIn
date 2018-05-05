<div class="job-form">
	@if( isset($entity) && $entity != null )
		{!! Form::model($entity, ['route' => ['entity.update', $entity->entity_id], 'files' => true]) !!}
	@else
		{!! Form::open(['route' => 'entity.store', 'files' => true]) !!}
		{{ method_field('PUT') }}
	@endif

	<div>
		{{ Form::label('name', 'Nom', ['class' => ($errors->has('name') ? 'is-invalid-label' : '')]) }}
		{{ Form::text('name', null, ['required' => true, 'class' => ($errors->has('name') ? 'is-invalid-input' : '')]) }}
		@if ($errors->has('name'))
			<span class="form-error is-visible">
				{{ $errors->first('name') }}
			</span>
		@endif
	</div>

	<div>
		{{ Form::label('location', 'Localisation', ['class' => ($errors->has('location') ? 'is-invalid-label' : '')]) }}
		{{ Form::text('location', null, ['required' => true, 'class' => ($errors->has('location') ? 'is-invalid-input' : '')]) }}
		@if ($errors->has('location'))
			<span class="form-error is-visible">
			{{ $errors->first('location') }}
		</span>
		@endif
	</div>

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
		{{ Form::label('photo', 'Photo', ['class' => ($errors->has('photo') ? 'is-invalid-label' : '')]) }}
		{{ Form::file('photo', ['class' => ($errors->has('photo') ? 'is-invalid-input' : '' ), 'accept' => 'image/jpeg,image/png']) }}
		@if (isset($entity) && $entity != null && $entity->photo_url !=null)
			L'entité possède une photo
		@endif
		@if ($errors->has('photo'))
			<span class="form-error is-visible">
			{{ $errors->first('photo') }}
		</span>
		@endif
	</div>

	<div>
		@if( isset($entity) && $entity != null )
			{{ Form::submit('Modifier', ['class' => 'button expanded']) }}
		@else
			{{ Form::submit('Créer', ['class' => 'button expanded']) }}
		@endif
	</div>
	{!! Form::close() !!}
</div>
