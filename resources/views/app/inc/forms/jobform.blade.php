<div class="job-form">
	{!!  Form::model($user, ['route' => ['user.update', $user->username], 'files' => true]) !!}

	<div>
		{{ Form::label('position', 'Poste', ['class' => ($errors->has('position') ? 'is-invalid-label' : '')]) }}
		{{ Form::text('position', null, ['required' => true, 'class' => ($errors->has('position') ? 'is-invalid-input' : '')]) }}
		@if ($errors->has('name'))
			<span class="form-error is-visible">
				{{ $errors->first('position') }}
			</span>
		@endif
	</div>

	<div>
		{{ Form::label('company', 'Entreprise', ['class' => ($errors->has('company') ? 'is-invalid-label' : '')])  }}
		{{ Form::text('company', null, ['required' => true, 'class' => ($errors->has('company') ? 'is-invalid-input' : '')]) }}
		@if ($errors->has('company'))
			<span class="form-error is-visible">
				{{ $errors->first('company') }}
			</span>
		@endif
	</div>

	<div>
		{{ Form::label('description', 'Descritpion', ['class' => ($errors->has('description') ? 'is-invalid-label' : '')]) }}
		{{ Form::text('description', null, ['required' => true, 'class' => ($errors->has('description') ? 'is-invalid-input' : '')]) }}
		@if ($errors->has('description'))
			<span class="form-error is-visible">
				{{ $errors->first('description') }}
			</span>
		@endif
	</div>


	<div>
		{{ Form::submit('Créer emploi', ['class' => 'button expanded']) }}
	</div>
	{!! Form::close() !!}
</div>
