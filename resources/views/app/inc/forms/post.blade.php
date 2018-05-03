<div class="post-form">
    {!! Form::open(['route' => 'post.add']) !!}
        <div>
            {{ Form::label('name', 'Name', ['class' => ($errors->has('name') ? 'is-invalid-label' : '')]) }}
            {{ Form::text('name', '', ['required' => true, 'class' => ($errors->has('name') ? 'is-invalid-input' : '')]) }}
            @if ($errors->has('name'))
                <span class="form-error is-visible">
                        {{ $errors->first('name') }}
                    </span>
            @endif
        </div>

        <div>
            {{ Form::label('surname', 'Surname', ['class' => ($errors->has('surname') ? 'is-invalid-label' : '')]) }}
            {{ Form::text('surname', '', ['required' => true, 'class' => ($errors->has('surname') ? 'is-invalid-input' : '')]) }}
            @if ($errors->has('surname'))
                <span class="form-error is-visible">
                        {{ $errors->first('surname') }}
                    </span>
            @endif
        </div>

        <div>
            {{ Form::label('birth_date', 'Birth Date', ['class' => ($errors->has('surname') ? 'is-invalid-label' : '')]) }}
            {{ Form::date('birth_date', '', ['required' => true, 'class' => ($errors->has('birth_date') ? 'is-invalid-input' : '')]) }}
            @if ($errors->has('birth_date'))
                <span class="form-error is-visible">
                        {{ $errors->first('birth_date') }}
                    </span>
            @endif
        </div>

        <div>
            {{ Form::label('username', 'Username', ['class' => ($errors->has('username') ? 'is-invalid-label' : ''), 'id' => 'username_register']) }}
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
            {{ Form::label('password', 'Password', ['class' => ($errors->has('password') ? 'is-invalid-label' : ''), 'id' => 'password_register']) }}
            {{ Form::password('password', ['required' => true, 'class' => ($errors->has('password') ? 'is-invalid-input' : ''), 'id' => 'password_register']) }}
            @if ($errors->has('password'))
                <span class="form-error is-visible">
                        {{ $errors->first('password') }}
                    </span>
            @endif
        </div>

        <div>
            {{ Form::label('password_confirmation', 'Confirm Password') }}
            {{ Form::password('password_confirmation', ['required' => true]) }}
        </div>

        <div>
            {{ Form::submit('Register', ['class' => 'button expanded']) }}
        </div>
    {!! Form::close() !!}
</div>
