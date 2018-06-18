<div class="login-form">
	{!! Form::open(['route' => 'login']) !!}
	<div>
		{{ Form::label('username', 'Nom d\'utilisateur ou Email', ['class' => ($errors->has('username') ? 'is-invalid-label' : '')]) }}
		{{ Form::text('username', '', ['required' => true, 'class' => ($errors->has('username') ? 'is-invalid-input' : '')]) }}
		@if ($errors->has('username'))
			<span class="form-error is-visible">
	                        {{ $errors->first('username') }}
	                    </span>
		@endif
	</div>

	<div>
		{{ Form::label('password', 'Mot de passe', ['class' => ($errors->has('password') ? 'is-invalid-label' : '')]) }}
		{{ Form::password('password', ['required' => true, 'class' => ($errors->has('password') ? 'is-invalid-input' : '')]) }}
		@if ($errors->has('password'))
			<span class="form-error is-visible">
	                        {{ $errors->first('password') }}
	                    </span>
		@endif
	</div>

	<div class="grid-x grid-margin-x">
		<div class="cell shrink">
			{{ Form::label('remember', 'Se souvenir de moi', ['class' => 'text-right']) }}
		</div>
		<div class="cell auto">
			<div class="switch">
				<input type="checkbox" id="remember" name="remember"
				       class="switch-input" {{ old('remember') ? 'checked' : '' }}>
				<label class="switch-paddle" for="remember">
					<span class="show-for-sr">Se souvenir de moi</span>
				</label>
			</div>
		</div>
	</div>

	<div class='_g-recaptcha' id='_g-recaptcha_login'></div>
	<div>
		@if ($errors->has('g-recaptcha-response'))
			<span class="form-error is-visible">
				{{ $errors->first('g-recaptcha-response') }}
			</span>
		@endif
	</div>

	<div>
		{{ Form::submit('Connexion', ['class' => 'button expanded']) }}
	</div>

	<p class="text-center">
		<a href="{{ route('password.request') }}">Mot de passe oublié ?</a>
	</p>
	{!! Form::close() !!}
</div>