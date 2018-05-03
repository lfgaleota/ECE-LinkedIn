<div class="edit-form">
    {!!  Form::model($user, ['route' => ['user.update', $user->username], 'files' => true]) !!}

            <div>
                {{ Form::label('name', 'Name', ['class' => ($errors->has('name') ? 'is-invalid-label' : '')]) }}
                {{ Form::text('name', null, ['required' => true, 'class' => ($errors->has('name') ? 'is-invalid-input' : '')]) }}
                @if ($errors->has('name'))
                    <span class="form-error is-visible">
                        {{ $errors->first('name') }}
                    </span>
                @endif
            </div>

            <div>
                {{ Form::label('surname', 'Surname', ['class' => ($errors->has('surname') ? 'is-invalid-label' : '')]) }}
                {{ Form::text('surname', null, ['required' => true, 'class' => ($errors->has('surname') ? 'is-invalid-input' : '')]) }}
                @if ($errors->has('surname'))
                    <span class="form-error is-visible">
                        {{ $errors->first('surname') }}
                    </span>
                @endif
            </div>

            <div>
                {{ Form::label('username', 'Username', ['class' => ($errors->has('username') ? 'is-invalid-label' : ''), 'id' => 'username_register']) }}
                {{ Form::text('username', null, ['required' => true, 'class' => ($errors->has('username') ? 'is-invalid-input' : ''), 'id' => 'username_register']) }}
                @if ($errors->has('username'))
                    <span class="form-error is-visible">
                        {{ $errors->first('username') }}
                    </span>
                @endif
            </div>

            <div>
                {{ Form::label('birth_date', 'Birth Date', ['class' => ($errors->has('surname') ? 'is-invalid-label' : '')]) }}
                {{ Form::date('birth_date', null, ['required' => true, 'class' => ($errors->has('birth_date') ? 'is-invalid-input' : '')]) }}
                @if ($errors->has('birth_date'))
                    <span class="form-error is-visible">
                        {{ $errors->first('birth_date') }}
                    </span>
                @endif
            </div>



            <div>
                {{ Form::label('email', 'Email', ['class' => ($errors->has('email') ? 'is-invalid-label' : '')]) }}
                {{ Form::email('email', null, ['required' => true, 'class' => ($errors->has('email') ? 'is-invalid-input' : '')]) }}
                @if ($errors->has('email'))
                    <span class="form-error is-visible">
                        {{ $errors->first('email') }}
                    </span>
                @endif
            </div>

                        <div>
                {{ Form::label('title', 'Title', ['class' => ($errors->has('title') ? 'is-invalid-label' : '')]) }}
                {{ Form::text('title', null, [ 'class' => ($errors->has('title') ? 'is-invalid-input' : '')]) }}
                @if ($errors->has('title'))
                    <span class="form-error is-visible">
                        {{ $errors->first('title') }}
                    </span>
                @endif
            </div>

                        <div>
                {{ Form::label('cv', 'CV', ['class' => ($errors->has('cv') ? 'is-invalid-label' : '')]) }}
                {{ Form::file('cv', ['class' => ($errors->has('cv') ? 'is-invalid-input' : '' ), 'accept' => '.pdf']) }}
                @if ($user->cv_url !=null)
                Le profil possède un CV
                @endif
            </div>

            <div>
                {{ Form::submit('Change values', ['class' => 'button expanded']) }}
            </div>
        {!! Form::close() !!}
</div>
