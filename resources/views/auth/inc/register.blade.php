<div class="registration-form">
    @if (env('REGISTRATION_ALLOWED'))
        {!! Form::open(['route' => 'register']) !!}
            <input type="hidden" name="registration" value="true" />

            <div>
                {{ Form::label('name', 'Prénom', ['class' => ($errors->has('name') ? 'is-invalid-label' : '')]) }}
                {{ Form::text('name', '', ['required' => true, 'class' => ($errors->has('name') ? 'is-invalid-input' : '')]) }}
                @if ($errors->has('name'))
                    <span class="form-error is-visible">
                        {{ $errors->first('name') }}
                    </span>
                @endif
            </div>

            <div>
                {{ Form::label('surname', 'Nom de famille', ['class' => ($errors->has('surname') ? 'is-invalid-label' : '')]) }}
                {{ Form::text('surname', '', ['required' => true, 'class' => ($errors->has('surname') ? 'is-invalid-input' : '')]) }}
                @if ($errors->has('surname'))
                    <span class="form-error is-visible">
                        {{ $errors->first('surname') }}
                    </span>
                @endif
            </div>

            <div>
                {{ Form::label('birth_date', 'Date de naissance', ['class' => ($errors->has('surname') ? 'is-invalid-label' : '')]) }}
                {{ Form::date('birth_date', '', ['required' => true, 'class' => ($errors->has('birth_date') ? 'is-invalid-input' : '')]) }}
                @if ($errors->has('birth_date'))
                    <span class="form-error is-visible">
                        {{ $errors->first('birth_date') }}
                    </span>
                @endif
            </div>

            <div>
                {{ Form::label('username', 'Nom d\'utilisateur', ['class' => ($errors->has('username') ? 'is-invalid-label' : ''), 'id' => 'username_register']) }}
                {{ Form::text('username', '', ['required' => true, 'class' => ($errors->has('username') ? 'is-invalid-input' : ''), 'id' => 'username_register']) }}
                @if ($errors->has('username'))
                    <span class="form-error is-visible">
                        {{ $errors->first('username') }}
                    </span>
                @endif
            </div>

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

            <div class='_g-recaptcha' id='_g-recaptcha_register'></div>
            <div>
                @if ($errors->has('g-recaptcha-response'))
                    <span class="form-error is-visible">
                        {{ $errors->first('g-recaptcha-response') }}
                    </span>
                @endif
            </div>

            <div>
                {{ Form::submit('S\'inscrire', ['class' => 'button expanded']) }}
            </div>
        {!! Form::close() !!}
    @else
        <p>L'enregistrement n'est pas possible pour le moment.</p>
    @endif
</div>
