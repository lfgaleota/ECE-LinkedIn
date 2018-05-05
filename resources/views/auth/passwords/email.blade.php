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
		<div class="grid-x grid-padding-x forgot-password">
			<div class="cell medium-8">
				<div class="callout card">
					<div class="card-divider">Réinitialisation du mot de passe</div>
					<div class="card-section">
						@if (session('status'))
							<div class="callout success">
								{{ session('status') }}
							</div>
						@endif

						{!! Form::open(['route' => 'password.email']) !!}
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
								{{ Form::submit('Envoyer le lien de réinitialisation du mot de passe', ['class' => 'button expanded']) }}
							</div>
						{!! Form::close() !!}
					</div>
				</div>
			</div>
			</div>
		</div>
	</div>
@endsection
