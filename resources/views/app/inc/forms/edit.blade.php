<div class="edit-form">
	{!!  Form::model($user, ['route' => ['user.update', $user->username], 'files' => true]) !!}

	<div>
		{{ Form::label('name', 'Prénom', ['class' => ($errors->has('name') ? 'is-invalid-label' : '')]) }}
		{{ Form::text('name', null, ['required' => true, 'class' => ($errors->has('name') ? 'is-invalid-input' : '')]) }}
		@if ($errors->has('name'))
			<span class="form-error is-visible">
				{{ $errors->first('name') }}
			</span>
		@endif
	</div>

	<div>
		{{ Form::label('surname', 'Nom de famille', ['class' => ($errors->has('surname') ? 'is-invalid-label' : '')]) }}
		{{ Form::text('surname', null, ['required' => true, 'class' => ($errors->has('surname') ? 'is-invalid-input' : '')]) }}
		@if ($errors->has('surname'))
			<span class="form-error is-visible">
				{{ $errors->first('surname') }}
			</span>
		@endif
	</div>

	<div>
		{{ Form::label('username', 'Nom d\'utilisateur', ['class' => ($errors->has('username') ? 'is-invalid-label' : ''), 'id' => 'username_register']) }}
		{{ Form::text('username', null, ['required' => true, 'class' => ($errors->has('username') ? 'is-invalid-input' : ''), 'id' => 'username_register']) }}
		@if ($errors->has('username'))
			<span class="form-error is-visible">
				{{ $errors->first('username') }}
			</span>
		@endif
	</div>

	<div>
		{{ Form::label('birth_date', 'Date de naissance', ['class' => ($errors->has('surname') ? 'is-invalid-label' : '')]) }}
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
		{{ Form::label('title', 'Statut', ['class' => ($errors->has('title') ? 'is-invalid-label' : '')]) }}
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
		@if ($errors->has('cv'))
			<span class="form-error is-visible">
				{{ $errors->first('cv') }}
			</span>
		@endif
	</div>

	<div>
		{{ Form::label('photo', 'Photo', ['class' => ($errors->has('photo_id') ? 'is-invalid-label' : '')]) }}
		<button id="post_photo_selector" class="button" type="button">
			Sélectionner <span id="post_photo_isselected" style="{{ $user->photo_id == null ? 'display: none' :'' }}">
				<i class="fa fa-check"></i>
			</span>
		</button>
		<input type="hidden" name="photo_id" value="{{ $user->photo_id != null ? $user->photo_id : '' }}" />
		@if ($errors->has('photo_id'))
			<span class="form-error is-visible">
				{{ $errors->first('photo_id') }}
			</span>
		@endif
	</div>

	<div>
		{{ Form::label('cover', 'Photo de couverture', ['class' => ($errors->has('cover_id') ? 'is-invalid-label' : '')]) }}
		<button id="post_cover_selector" class="button" type="button">
			Sélectionner <span id="post_cover_isselected" style="{{ $user->cover_id == null ? 'display: none' :'' }}">
				<i class="fa fa-check"></i>
			</span>
		</button>
		<input type="hidden" name="cover_id" value="{{ $user->cover_id != null ? $user->cover_id : '' }}" />
		@if ($errors->has('cover_id'))
			<span class="form-error is-visible">
				{{ $errors->first('cover_id') }}
			</span>
		@endif
	</div>

	<div>
		{{ Form::submit('Mettre à jour', ['class' => 'button expanded']) }}
	</div>
	{!! Form::close() !!}
</div>

@section('scripts')
	@parent

	<script>
		var photo_id = $( 'input[name="photo_id"]' );
		var cover_id = $( 'input[name="cover_id"]' );
		var photo_is_selected = $( '#post_photo_isselected' );
		var cover_is_selected = $( '#post_cover_isselected' );

		function photosGet( tag ) {
			tag.loading();
			window.axios.get( '{{ url( 'api/images' ) }}' )
				.then( function( response ) {
					tag.notLoading();
					let items = response.data;
					for( let i = 0; i < items.length; i++ ) {
						if( items[ i ].post_id == photo_id.val() ) {
							items[ i ].selected = true;
						}
					}
					tag.setItems( items );
				}).catch( function( error ) {
					tag.notLoading();
					console.log( error );
				});
		}

		function coversGet( tag ) {
			tag.loading();
			window.axios.get( '{{ url( 'api/images' ) }}' )
				.then( function( response ) {
					tag.notLoading();
					let items = response.data;
					for( let i = 0; i < items.length; i++ ) {
						if( items[ i ].post_id == cover_id.val() ) {
							items[ i ].selected = true;
						}
					}
					tag.setItems( items );
				}).catch( function( error ) {
				tag.notLoading();
				console.log( error );
			});
		}

		function onPhotoSelected( images ) {
			if( images.length > 0 ) {
				photo_id.val( images[ 0 ].post_id );
				photo_is_selected.show();
			} else  {
				photo_id.val();
				photo_is_selected.hide();
			}
		}

		function onCoverSelected( images ) {
			if( images.length > 0 ) {
				cover_id.val( images[ 0 ].post_id );
				cover_is_selected.show();
			} else  {
				cover_id.val();
				cover_is_selected.hide();
			}
		}

		function onPhotoCancelled() {
			photo_id.val();
			photo_is_selected.hide();
		}

		function onCoverCancelled() {
			cover_id.val();
			cover_is_selected.hide();
		}

		function openImage( selectorTag ) {
			function onImageSubmit( image, tag ) {
				tag.disable();
				image.append( '_method', 'PUT' );
				window.axios.post(
					'{{ url( 'api/image' ) }}',
					image,
					{
						headers: { 'content-type': 'multipart/form-data' },
						onUploadProgress: function( progressEvent ) {
							tag.setProgress( Math.round( ( progressEvent.loaded * 100 ) / progressEvent.total ) );
						}
					}
				).then( function( response ) {
					selectorTag.onAdd();
					tag.unmount();
				} ).catch( function( error ) {
					tag.enable();
					tag.setProgress( 0 );
					console.log( error );
				} );
			}

			$( 'body' ).append( $( '<image-form></image-form>' ) );
			window.riot.mount( 'image-form', { onSelected: onImageSubmit } );
		}

		$( '#post_photo_selector' ).click( function( e ) {
			e.preventDefault();
			e.stopImmediatePropagation();
			$( 'body' ).append( $( '<tag-selector></tag-selector>' ) );
			window.riot.mount( 'tag-selector', {
				onSelected: onPhotoSelected,
				onCancelled: onPhotoCancelled,
				component: 'image-renderer',
				itemGetInitier: photosGet,
				hasAdd: true,
				add: openImage
			});
		});

		$( '#post_cover_selector' ).click( function( e ) {
			e.preventDefault();
			e.stopImmediatePropagation();
			$( 'body' ).append( $( '<tag-selector></tag-selector>' ) );
			window.riot.mount( 'tag-selector', {
				onSelected: onCoverSelected,
				onCancelled: onCoverCancelled,
				component: 'image-renderer',
				itemGetInitier: coversGet,
				hasAdd: true,
				add: openImage
			});
		});
	</script>
@endsection