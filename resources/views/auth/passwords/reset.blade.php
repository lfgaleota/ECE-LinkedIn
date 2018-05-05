@extends('layouts.app')

@section( 'styles' )
	@parent
	<link href="{{ asset('css/welcome.css') }}" rel="stylesheet">
@endsection

@section( 'scripts' )
	@parent
	<script src="{{ asset('js/welcome.js') }}"></script>
@endsection

@section('content')
	<div class="grid-container">
		<div class="grid-x grid-padding-x reset-password">
			<div class="cell medium-8">
				<div class="callout card">
					<div class="card-divider">Réinitialiser le mot de passe</div>
					<div class="card-section">
						@if (session('status'))
							<div class="callout success">
								{{ session('status') }}
							</div>
						@endif

						{!! Form::open(['route' => 'password.request']) !!}
							<input type="hidden" name="token" value="{{ $token }}">

							<div>
								{{ Form::label('email', 'Email', ['class' => ($errors->has('email') ? 'is-invalid-label' : '')]) }}
								{{ Form::email('email', '', ['required' => true, 'class' => ($errors->has('email') ? 'is-invalid-input' : '')]) }}
								@if ($errors->has('email'))
									<span class="form-error is-visible">
										{{ $errors->first('email') }}
									</span>
								@endif
							</div>

							<div>
								{{ Form::label('password', 'Mot de passe', ['class' => ($errors->has('password') ? 'is-invalid-label' : ''), 'id' => 'password_register']) }}
								{{ Form::password('password', ['required' => true, 'class' => ($errors->has('password') ? 'is-invalid-input' : ''), 'id' => 'password_register']) }}
								@if ($errors->has('password'))
									<span class="form-error is-visible">
										{{ $errors->first('password') }}
									</span>
								@endif
							</div>

							<div>
								{{ Form::label('password_confirmation', 'Confirmer le mot de passe', ['class' => ($errors->has('password_confirmation') ? 'is-invalid-label' : '')]) }}
								{{ Form::password('password_confirmation', ['required' => true]) }}
								@if ($errors->has('password_confirmation'))
									<span class="form-error is-visible">
										{{ $errors->first('password_confirmation') }}
									</span>
								@endif
							</div>

						<div>
							{{ Form::submit('Réinitialiser le mot de passe', ['class' => 'button expanded']) }}
						</div>
						{!! Form::close() !!}
					</div>
				</div>
			</div>
		</div>
	</div>
@endsection
