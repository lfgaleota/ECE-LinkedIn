@extends('layouts.app')

@section('content')
	<div id="home" class="grid-container">
		<div class="grid-x grid-margin-x">
			<div class="cell medium-4 large-3 hide-for-small-only" data-sticky-container>
				@include( 'app.inc.users.profile-card', [ 'user' => Auth::user(), 'sticky' => [ 'element' => 'timeline', 'top' => '4' ] ] )
			</div>
			<div class="cell small-12 medium-8 large-9" id="timeline">
				<post-form></post-form>
				<tag-infinite-scroller></tag-infinite-scroller>
			</div>
		</div>
	</div>
@endsection

@section('styles')
	@parent
	<link href="{{ asset( 'css/home.css' ) }}" rel="stylesheet"/>
@endsection

@section('scripts')
	@parent
	@include( 'app.inc.tags' )
	<script>
		function onPostSubmit( form, tag ) {
			tag.disable();

			function onProgress( progressEvent ) {
				tag.setProgress( Math.round( ( progressEvent.loaded * 100 ) / progressEvent.total ) );
			}

			window.axios.put( '{{ url( "api/post" ) }}', form, { onUploadProgress: onProgress } )
				.then( function( response ) {
					tag.clear();
					tag.setProgress( 0 );
					tag.enable();
					window.infiniteScroller.reload();
				} ).catch( function( error ) {
				tag.enable();
				tag.setProgress( 0 );
				console.log( error );
			} );
		}

		window.riot.mount( 'post-form', { onSubmitted: onPostSubmit, baseApiPath: '{{ url( 'api' ) }}' } );

		function getPostId( post ) {
			return post.post_id;
		}

		function loadPost( last_id, tag ) {
			window.axios.get( '{{ route( 'api.user.timeline' ) }}' + ( last_id !== null ? '/' + last_id : '' ) )
				.then( function( response ) {
					__post__loadAdditional( '{{ url( 'api' ) }}', response.data, tag.addItems, function( error ) {
						tag.error();
						console.log( error );
					} );
				}).catch( function( error ) {
					tag.error();
				console.log( error );
			} );
		}

		function setInfiniteScroller( tag ) {
			window.infiniteScroller = tag;
		}

		window.riot.mount( 'tag-infinite-scroller', {
			load: loadPost,
			getItemId: getPostId,
			component: 'post-renderer',
			scrollElement: document,
			addsopts: {
				basepath: '{{ url( '/' ) }}',
				baseapipath: '{{ url( 'api' ) }}',
				currentuserid: '{{ Auth::user()->user_id }}'
			},
			onMounted: setInfiniteScroller
		} );
	</script>
@endsection
