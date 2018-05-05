<comment-section>
	<div class="comments">
		<div class="comment" each={ comment in comments }>
			<a class="comment-author" href={ opts.addsopts.basepath + '/' + comment.username }>
				{ comment.name } { comment.surname }
			</a>
			<div class="comment-content">
				<p>{ comment.text }</p>
			</div>
			<like-button item={ comment } addsopts={ opts.addsopts } iscomment="true"></like-button>
		</div>
	</div>
	<form ref="form" onsubmit={ submit }>
		<div class="grid-x">
			<div class="cell auto">
				<textarea ref="text_content" name="text" class="text-content" required></textarea>
			</div>
			<div class="cell shrink">
				<button class="button" type="submit"><i class="fas fa-paper-plane"></i></button>
			</div>
		</div>
		<div class="progress" ref="progressBar"></div>
	</form>

	<style>
		:scope {
			display: block;
			padding: 0.5rem 1rem;
			background: #e6e6e6;
		}

		.text-content {
			border: 0;
			margin: 0;
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

		button {
			height: 100%;
			margin: 0 !important;
		}

		.comment {
			position: relative;
			margin-bottom: 1rem;
		}

		.comment .comment-author {
			display: block;
			padding: 0 0 0 0.5rem;
		}

		.comment .comment-content {
			display: inline-block;
			width: auto;
			padding: 0.25rem 0.5rem;
			background: white;
			border-radius: 10px;
		}

		.comment .comment-content p {
			margin: 0;
		}

		.comment like-button {
			display: block;
			position: absolute;
			left: 0.25rem;
			bottom: -1rem;
		}

		.comment like-button > button {
			border-radius: 30px;
			font-size: 10px;
			padding: 0.25rem;
		}

		.comment like-button > button > * {
			font-size: inherit;
		}

		.comment like-button .dropdown-pane.add, .comment [data-is="like-button"] .dropdown-pane.add {
			bottom: 22px;
		}

		form {
			margin-top: 1.5rem;
		}

		form .text-content {
			border-top-left-radius: 10px;
			border-bottom-left-radius: 10px;
		}

		form .button {
			border-top-right-radius: 10px;
			border-bottom-right-radius: 10px;
		}
	</style>

	<script>
		this.post_id = null;
		this.comments = [];

		let that = this;

		loadComments() {
			window.axios.get(
				opts.addsopts.baseapipath + '/post/' + opts.post_id + '/comments',
				null,
				{
					onUploadProgress: function( progressEvent ) {
						that.setProgress( Math.round( ( progressEvent.loaded * 100 ) / progressEvent.total ) );
					}
				}
			).then( function( response ) {
				that.enable();
				that.setProgress( 0 );
				that.setItems( response.data );
			}).catch( function( error ) {
				that.enable();
				that.setProgress( 0 );
				console.log( error );
			});
		}

		setItems( items ) {
			that.comments = items;
			that.update();
		}

		reload() {
			that.loadComments();
		}

		postComment() {
			that.disable();
			let data = getForm();
			data[ '_method' ] = 'PUT';
			window.axios.post(
				opts.addsopts.baseapipath + '/post/' + opts.post_id + '/comments',
				data,
				{
					onUploadProgress: function( progressEvent ) {
						that.setProgress( Math.round( ( progressEvent.loaded * 100 ) / progressEvent.total ) );
					}
				}
			).then( function( response ) {
				that.enable();
				that.setProgress( 0 );
				that.reload();
			}).catch( function( error ) {
				that.enable();
				that.setProgress( 0 );
				console.log( error );
			});
		}

		this.on( 'mount', function() {
			that.reload();
		});

		function getForm() {
			return {
				text: that.refs.text_content.value,
				post_id: opts.post_id
			};
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
			that.setProgress( 0 );
			that.refs.text_content.value = "";
			that.update();
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
			that.postComment();
		}
	</script>
</comment-section>