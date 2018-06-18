<post-form>
	<form ref="form" class="form-container" onsubmit={ submit }>
		<div>
			<textarea ref="text_content" name="description" class="text-content" required></textarea>
			<div class="toolbar">
				<button ref="photo_button" class="button" type="button" name="photo_button" onclick={ openImageSelector
				        }><i class="fa fa-image"></i></button>
				<button ref="video_button" class="button" type="button" name="video_button" onclick={ openVideoSelector }>
					<i class="fa fa-video"></i>
				</button>
				<button ref="visibility_button" class="button" type="button" data-toggle="post-visiblity-selector"><i
						class="fa fa-globe" ref="visibility_icon"></i>
				</button>
				<button class="button float-right" type="submit"><i class="fas fa-paper-plane"></i></button>
				<div ref="visibility_dropdown" class="dropdown-pane visibility-dropdown" id="post-visiblity-selector"
				     data-dropdown
				     data-auto-focus="true">
					<label>
						<input ref="visibility_checbox_PUBLIC" type="radio" class="visilibity-selector" name="visibility" value="PUBLIC" checked
						       onchange={ visibilityClicked }/>
						<span class="visibility-label">
                            <i class="fa fa-globe"></i> Public
                        </span>
					</label>
					<label>
						<input ref="visibility_checbox_NETWORKMEMBERS" type="radio" class="visilibity-selector" name="visibility" value="NETWORKMEMBERS"
						       onchange={ visibilityClicked }/>
						<span class="visibility-label">
                            <i class="fa fa-suitcase"></i> Membres du réseau
                        </span>
					</label>
					<label>
						<input ref="visibility_checbox_FRIENDS" type="radio" class="visilibity-selector" name="visibility" value="FRIENDS" onchange={
						       visibilityClicked }/>
						<span class="visibility-label">
                            <i class="fa fa-users"></i> Amis
                        </span>
					</label>
					<label onclick={ restrictedClicked }>
						<input ref="visibility_checbox_RESTRICTED" type="radio" class="visilibity-selector" name="visibility" value="RESTRICTED" onchange={
						       visibilityClicked }/>
						<span class="visibility-label">
                            <i class="fa fa-user"></i> Restreint
                        </span>
					</label>
				</div>
			</div>
		</div>
		<div class="progress" ref="progressBar"></div>
	</form>

	<style>
		:scope {
			display: block;
		}

		.text-content {
			border: 0;
			border-bottom: 1px solid hsla(0, 0%, 4%, .25);
			margin: 0;
			min-height: 100px;
		}

		.toolbar {
			font-size: 0;
		}

		.toolbar > *,
		.toolbar .button {
			display: inline-block;
			margin: 0;
		}

		.visibility-dropdown {
			padding: 0;
			width: auto;
		}

		.visilibity-selector {
			display: none;
		}

		.visibility-label {
			display: block;
			width: 100%;
			padding: 1em;
			background: white;
			cursor: pointer;
		}

		.visilibity-selector:checked + .visibility-label {
			background: #23a3ba;
			color: white;
		}

		.progress {
			display: none;
			height: 4px;
			width: 0;
			padding: 0;
			margin: 0;
			background: #23a3ba;
			transition: width 0.25s ease-in;
		}
	</style>

	<script>
		this.form = {
			"photo_ids": [],
			"video_ids": [],
			"post_visibility_user_ids": [],
		};
		this.isRestricted = false;
		this.post_id = null;
		this.error = false;

		this.icons = {
			"PUBLIC": "fa fa-globe",
			"NETWORKMEMBERS": "fa fa-suitcase",
			"FRIENDS": "fa fa-users",
			"RESTRICTED": "fa fa-user"
		};

		let that = this;

		function mount() {
			$( that.refs.visibility_button ).foundation();
			$( that.refs.visibility_dropdown ).foundation();
		}

		clearForm() {
			that.form = {
				"photo_ids": [],
				"video_ids": [],
				"post_visibility_user_ids": []
			};
			that.post_id = null;
			that.isRestricted = false;
			that.error = false;
			that.setProgress( 0 );
			that.update();
		}

		loadPost( post ) {
			that.post_id = post.post_id;
			that.refs.text_content.value = post.description;
			that.setVisibility( that.refs[ 'visibility_checbox_' + post.visibility ] );
			for( let i = 0; i < post.subposts.length; i++ ) {
				if( post.subposts[ i ].type == 'IMAGE' ) {
					that.form.photo_ids.push( post.subposts[ i ].post_id );
				}
				if( post.subposts[ i ].type == 'VIDEO' ) {
					that.form.video_ids.push( post.subposts[ i ].post_id );
				}
			}
			for( let i = 0; i < post.visibilities.length; i++ ) {
				that.form.post_visibility_user_ids.push( post.visibilities[ i ].user_id );
			}
			that.update();
		}

		loadExisting( post_id ) {
			that.setProgress( 0 );
			that.disable();
			that.update();

			window.axios.get( baseapipath + '/post/' + post_id, )
				.then( function( response ) {
					that.setProgress( 0 );
					that.enable();
					that.error = true;
					that.loadPost( post );
				}).catch( function( error ) {
					that.setProgress( 0 );
					that.error = true;
					that.update();
			});
		}

		visibilityClicked( e ) {
			that.setVisibility( e.target );
			if( e.target.value === "RESTRICTED" ) {
				that.openFriendSelector();
			} else {
				that.form.post_visibility_user_ids = [];
			}
		}

		clearVisibility() {
			that.setVisibility( that.refs.form.querySelector( 'input[name="visibility"]' ) );
		}

		setVisibility( checkbox ) {
			let jCheckbox = $( checkbox );
			jCheckbox.prop( 'checked', true );
			that.refs.visibility_icon.className = that.icons[ checkbox.value ];
			$( that.refs.visibility_dropdown ).foundation( 'close' );
			that.isRestricted = checkbox.value == 'RESTRICTED';
		}

		restrictedClicked( e ) {
			if( that.isRestricted ) {
				e.preventDefault();
				e.stopImmediatePropagation();
				that.openFriendSelector();
			}
		}

		function onFriendSelected( friends ) {
			that.form.post_visibility_user_ids = [];
			for( let i = 0; i < friends.length; i++ ) {
				that.form.post_visibility_user_ids.push( friends[ i ].user_id );
			}
		}

		function onFriendNotSelected() {
			that.clearVisibility();
		}

		function friendGet( tag ) {
			tag.isLoading();
			window.axios.get( opts.baseApiPath + '/network' )
				.then( function( response ) {
					let constructItems = response.data;
					if( opts.postId && that.post_visibility_user_ids.length === 0 ) {
						window.axios.get( opts.baseApiPath + '/post/' + opts.postId + '/access' )
							.then( function( response ) {
								tag.notLoading();
								console.log( reponse );
							} ).catch( function( error ) {
							tag.notLoading();
							console.log( error );
						} );
					} else {
						tag.notLoading();
						for( let i = 0; i < constructItems.length; i++ ) {
							if( that.form.post_visibility_user_ids.indexOf( constructItems[ i ].user_id ) > -1 ) {
								constructItems[ i ].selected = true;
							}
						}
					}
					tag.setItems( constructItems );
				} ).catch( function( error ) {
				tag.notLoading();
				console.log( error );
			} );
		}

		function onFriendSelected( friends ) {
			that.form.post_visibility_user_ids = [];
			for( let i = 0; i < friends.length; i++ ) {
				that.form.post_visibility_user_ids.push( friends[ i ].user_id );
			}
		}

		function onFriendNotSelected() {
			that.clearVisibility();
		}

		openFriendSelector() {
			$( 'body' ).append( $( '<tag-selector></tag-selector>' ) );
			window.riot.mount( 'tag-selector', {
				onSelected: onFriendSelected,
				onCancelled: onFriendNotSelected,
				component: 'friend-renderer',
				itemGetInitier: friendGet,
				fullWidth: true
			} );
		}

		function imagesGet( tag ) {
			tag.isLoading();
			window.axios.get( opts.baseApiPath + '/images' )
				.then( function( response ) {
					tag.notLoading();
					let items = response.data;
					for( let i = 0; i < items.length; i++ ) {
						if( that.form.photo_ids.indexOf( items[ i ].post_id ) > -1 ) {
							items[ i ].selected = true;
						}
					}
					tag.setItems( items );
				} ).catch( function( error ) {
				tag.notLoading();
				console.log( error );
			} );
		}

		function onImageSelected( images ) {
			that.refs.photo_button.disabled = false;
			that.form.photo_ids = [];
			for( let i = 0; i < images.length; i++ ) {
				that.form.photo_ids.push( images[ i ].post_id );
			}
		}

		function onImageCancelled() {
			that.refs.photo_button.disabled = false;
		}

		function openImage( selectorTag ) {
			function onImageSubmit( image, tag ) {
				tag.disable();
				image.append( '_method', 'PUT' );
				window.axios.post(
					opts.baseApiPath + '/image',
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

		openImageSelector() {
			that.refs.photo_button.disabled = true;
			$( 'body' ).append( $( '<tag-selector></tag-selector>' ) );
			window.riot.mount( 'tag-selector', {
				onSelected: onImageSelected,
				onCancelled: onImageCancelled,
				component: 'image-renderer',
				itemGetInitier: imagesGet,
				hasAdd: true,
				add: openImage
			} );
		}

		function videosGet( tag ) {
			tag.isLoading();
			window.axios.get( opts.baseApiPath + '/videos' )
				.then( function( response ) {
					tag.notLoading();
					let items = response.data;
					for( let i = 0; i < items.length; i++ ) {
						if( that.form.video_ids.indexOf( items[ i ].post_id ) > -1 ) {
							items[ i ].selected = true;
						}
					}
					tag.setItems( items );
				} ).catch( function( error ) {
				tag.notLoading();
				console.log( error );
			} );
		}

		function onVideoSelected( videos ) {
			that.refs.video_button.disabled = false;
			that.form.video_ids = [];
			for( let i = 0; i < videos.length; i++ ) {
				that.form.video_ids.push( videos[ i ].post_id );
			}
		}

		function onVideoCancelled() {
			that.refs.video_button.disabled = false;
		}

		function openVideo( selectorTag ) {
			function onVideoSubmit( video, tag ) {
				tag.disable();
				video.append( '_method', 'PUT' );
				window.axios.post(
					opts.baseApiPath + '/video',
					video,
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

			$( 'body' ).append( $( '<video-form></video-form>' ) );
			window.riot.mount( 'video-form', { onSelected: onVideoSubmit } );
		}

		openVideoSelector() {
			that.refs.video_button.disabled = true;
			$( 'body' ).append( $( '<tag-selector></tag-selector>' ) );
			window.riot.mount( 'tag-selector', {
				onSelected: onVideoSelected,
				onCancelled: onVideoCancelled,
				component: 'video-renderer',
				itemGetInitier: videosGet,
				hasAdd: true,
				add: openVideo
			} );
		}

		this.on( 'mount', function() {
			mount();
		} );

		function getForm() {
			that.form[ "post_id" ] = that.post_id;
			that.form[ "description" ] = that.refs.text_content.value;
			let visibilityRadios = that.refs.form.querySelectorAll( 'input[name="visibility"]' );
			for( let i = 0; i < visibilityRadios.length; i++ ) {
				if( visibilityRadios[ i ].checked ) {
					that.form[ "visibility" ] = visibilityRadios[ i ].value;
				}
			}
			return that.form;
		}

		setProgress( progress ) {
			that.refs.progressBar.style.width = progress + '%';
			if( progress > 0 ) {
				$( that.refs.progressBar ).show();
			} else {
				$( that.refs.progressBar ).hide();
			}
		}

		clear() {
			that.clearForm();
			that.clearVisibility();
			that.refs.text_content.value = "";
		}

		disable() {
			let elems = that.refs.form.querySelectorAll( 'button' );
			for( let i = 0; i < elems.length; i++ ) {
				elems[ i ].disabled = true;
			}
			that.refs.text_content.disabled = true;
		}

		enable() {
			let elems = that.refs.form.querySelectorAll( 'button' );
			for( let i = 0; i < elems.length; i++ ) {
				elems[ i ].disabled = false;
			}
			that.refs.text_content.disabled = false;
		}

		submit( e ) {
			e.preventDefault();
			e.stopImmediatePropagation();
			that.disable();
			opts.onSubmitted( getForm(), that );
		}
	</script>
</post-form>