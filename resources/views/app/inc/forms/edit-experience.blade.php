<div class="edit-experience">
    {!!  Form::model($user, ['route' => ['user.update', $user->username], 'files' => true]) !!}

          <div>
              {{ Form::label('titre', 'Title', ['class' => ($errors->has('name') ? 'is-invalid-label' : '')]) }}
              {{ Form::text('titre', null, ['required' => true, 'class' => ($errors->has('name') ? 'is-invalid-input' : '')]) }}
              @if ($errors->has('titre'))
                  <span class="form-error is-visible">
                      {{ $errors->first('titre') }}
                  </span>
              @endif
          </div>

            <div>
                {{ Form::label('company', 'Company', ['class' => ($errors->has('name') ? 'is-invalid-label' : '')]) }}
                {{ Form::text('company', null, ['required' => true, 'class' => ($errors->has('name') ? 'is-invalid-input' : '')]) }}
                @if ($errors->has('company'))
                    <span class="form-error is-visible">
                        {{ $errors->first('experience') }}
                    </span>
                @endif
            </div>

            <div>
                {{ Form::label('description', 'Description', ['class' => ($errors->has('name') ? 'is-invalid-label' : '')]) }}
                {{ Form::text('description', null, ['required' => true, 'class' => ($errors->has('name') ? 'is-invalid-input' : '')]) }}
                @if ($errors->has('description'))
                    <span class="form-error is-visible">
                        {{ $errors->first('description') }}
                    </span>
                @endif
            </div>

            <div>
                {{ Form::label('start', 'From', ['class' => ($errors->has('surname') ? 'is-invalid-label' : '')]) }}
                {{ Form::date('start', null, ['required' => true, 'class' => ($errors->has('birth_date') ? 'is-invalid-input' : '')]) }}
                @if ($errors->has('birth_date'))
                    <span class="form-error is-visible">
                        {{ $errors->first('birth_date') }}
                    </span>
                @endif
            </div>

            <div>
                {{ Form::label('end', 'To', ['class' => ($errors->has('surname') ? 'is-invalid-label' : '')]) }}
                {{ Form::date('end', null, ['required' => true, 'class' => ($errors->has('birth_date') ? 'is-invalid-input' : '')]) }}
                @if ($errors->has('birth_date'))
                    <span class="form-error is-visible">
                        {{ $errors->first('birth_date') }}
                    </span>
                @endif
                <input id="currentWork" type="checkbox"><label for="checkbox1">I currently work here</label>
            </div>

            <div>
                {{ Form::submit('Save', ['class' => 'button expanded']) }}
            </div>
        {!! Form::close() !!}
</div>
