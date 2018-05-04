<author-tag>
	<a href={ opts.addsopts.basepath + '/' + opts.item.username }><img if={ !opts.picture } src={ __getProfileUrl( opts.item.photo_url ) } /> { opts.item.name } { opts.item.surname }</a>
</author-tag>

<post-renderer>
	<div class="post form-container" if={ opts.item.type == 'POST' }>
		<div class="author">
			<author-tag item={ opts.item } addsopts={ opts.addsopts } ></author-tag> · <a class="time" href={ opts.addsopts.basepath + '/post/' + opts.item.post_id }>{ moment( opts.item.created_at ).fromNow() }</a>
		</div>
		<div class="content" if={ opts.item.description != null }>
			<p>{ opts.item.description }</p>
		</div>
		<loader if={ loading }></loader>
		<div class="subposts" if={ ( subposts != null ) && ( subposts.length > 0 ) }>
			<virtual each={ subpost in subposts } if={ !hasSubPostError }>
				<post-renderer item={ subpost } addsopts={ parent.opts.addsopts }></post-renderer>
			</virtual>
		</div>
		<div class="callout alert" if={ hasSubPostError }>
			<p><i class="fas fa-exclamation-triangle"></i> Erreur lors du chargements des éléments de la publication.</p>
		</div>
		<div class="toolbar">
			<like-button item={ opts.item } addsopts={ opts.addsopts } iscomment="false"></like-button>
			<button class="button float-right" onclick={ toggleComment }><i class="fas fa-comments"></i></button>
			<button class="button float-right"><i class="fas fa-share"></i></button>
		</div>
		<comment-section if={ commentOpened } post_id={ opts.item.post_id } addsopts={ opts.addsopts }></comment-section>
	</div>

	<div class="post form-container" if={ opts.item.type == 'SHARE' && subposts != null }>
		<div class="author">
			<author-tag item={ opts.item } addsopts={ opts.addsopts }></author-tag> a partagé le poste de <author-tag item={ subposts[ 0 ] } addsopts={ opts.addsopts } picture="false"></author-tag> · <a class="time" href={ opts.addsopts.basepath + '/post/' + opts.item.post_id }>{ moment( opts.item.created_at ).fromNow() }</a>
		</div>
		<div class="content" if={ opts.item.description != null }>
			<p>{ opts.item.description }</p>
		</div>
		<div class="subposts">
			<virtual each={ subpost in subposts } if={ !hasSubPostError }>
				<post-renderer item={ subpost } addsopts={ parent.opts.addsopts }></post-renderer>
			</virtual>
		</div>
		<div class="callout alert" if={ hasSubPostError }>
			<p><i class="fas fa-exclamation-triangle"></i> Erreur lors du chargements des éléments de la publication.</p>
		</div>
		<div class="toolbar">
			<like-button item={ opts.item } addsopts={ opts.addsopts } iscomment="false"></like-button>
			<button class="button float-right"><i class="fas fa-comments"></i></button>
			<button class="button float-right"><i class="fas fa-share"></i></button>
		</div>
	</div>

	<a class="thumbnail" if={ opts.item.type == 'IMAGE' } onclick={ imageOpen }>
		<img src={ opts.item.image_url } />
	</a>

	<a class="thumbnail" if={ opts.item.type == 'VIDEO' } onclick={ videoOpen }>
		<video src={ opts.item.video_url }>
			<div class="callout alert">
				<p><i class="fas fa-exclamation-triangle"></i> Vid"o non  prise en charge par le navigateur.</p>
			</div>
		</video>
	</a>

	<style>
		.loader,
		.post .content,
		.post .toolbar,
		.post .subposts {
			border-top: 1px solid hsla(0,0%,4%,.25);
		}

		.loader,
		.post .author,
		.post .subposts {
			padding: 0.5rem 1rem;
		}

		a.thumbnail {
			display: inline-block;
			margin: 0.5rem;
		}

		.thumbnail img,
		.thumbnail video {
			width: 128px;
			height: 128px;
		}

		.post .author img {
			width: 3rem;
			height: 3rem;
			border: 1px solid hsla(0,0%,4%,.25);
			border-radius: 50%;
			margin-right: 0.5rem;
		}

		.post .author a {
			color: inherit;
		}

		.post .author a:hover {
			color: #1468a0;
		}

		.post .author .time {
			color: #999;
		}

		.post .content {
			padding: 1rem;
		}

		.post .content p:last-of-type {
			margin-bottom: 0;
		}

		.post .subposts:empty {
			border-top: none;
			padding: 0;
		}

		.post .toolbar {
			position: relative;
		}

		.post .toolbar > * {
			margin-bottom: 0;
		}

		.post .toolbar .reaction-count {
			margin-left: 0.4em;
		}

		.post .callout.alert {
			border-left: none;
			border-right: none;
			border-bottom: none;
		}
	</style>

	<script>
		this.subposts = [];
		this.loading = false;
		this.hasSubPostError = false;
		this.commentOpened = false;
		let that = this;

		toggleComment( e ) {
			e.preventDefault();
			e.stopImmediatePropagation();
			that.commentOpened ^= 1;
			that.update();
		}

		imageOpen( e ) {
			$( 'body' ).append( $( '<image-popup></image-popup>' ) );
			window.riot.mount( 'image-popup', { item: e.item.subpost } );
		}

		videoOpen( e ) {
			$( 'body' ).append( $( '<video-popup></video-popup>' ) );
			window.riot.mount( 'video-popup', { item: e.item.subpost } );
		}

		setSubPosts( subposts ) {
			that.subposts = subposts;
			that.update();
		}

		subPostError() {
			that.hasSubPostError = true;
			that.update();
		}

		loadSubPosts() {
			if( opts.item.subposts !== undefined && opts.item.subposts.length > 0 ) {
				that.loading = true;
				that.update();
				window.axios.post( opts.addsopts.baseapipath + '/post/gets', { ids: opts.item.subposts }  )
				.then( function( response ) {
						__post__loadAdditional( opts.addsopts.baseapipath, response.data, function( items ) {
							that.loading = false;
							that.setSubPosts( items );
						}, function( error ) {
							that.loading = false;
							that.subPostError();
							console.log( error );
						});
					}).catch( function( error ) {
						that.loading = false;
						that.subPostError();
						console.log( error );
					});
			}
		}

		this.on( 'mount', function() {
			that.loadSubPosts();
		});
	</script>
</post-renderer>