@extends('layouts.app')

@section('content')
	<post-form></post-form>
	<h1>Votre fil</h1>
	<tag-infinite-scroller></tag-infinite-scroller>
@endsection

@section( 'scripts' )
	@parent
	<script data-src="{{ asset( 'tags/post-form.tag' ) }}" type="riot/tag"></script>
	<script data-src="{{ asset( 'tags/image-form.tag' ) }}" type="riot/tag"></script>
	<script data-src="{{ asset( 'tags/tag-selector.tag' ) }}" type="riot/tag"></script>
	<script data-src="{{ asset( 'tags/tag-infinite-scroller.tag' ) }}" type="riot/tag"></script>
	<script data-src="{{ asset( 'tags/friend-renderer.tag' ) }}" type="riot/tag"></script>
	<script data-src="{{ asset( 'tags/image-renderer.tag' ) }}" type="riot/tag"></script>
	<script data-src="{{ asset( 'tags/post-renderer.tag' ) }}" type="riot/tag"></script>
	<script data-src="{{ asset( 'tags/spinner.tag' ) }}" type="riot/tag"></script>
	<script>
		function onPostSubmit( form, tag ) {
			tag.disable();

			function onProgress( progressEvent ) {
				tag.setProgress( Math.round( ( progressEvent.loaded * 100 ) / progressEvent.total ) );
			}

			window.axios.put( '{{ url( "api/post" ) }}', form, { onUploadProgress: onProgress } )
				.then( function( response ) {
					tag.clear();
					tag.enable();
					document.location.reload();
				} ).catch( function( error ) {
				tag.enable();
				tag.setProgress( 0 );
				console.log( error );
			});
		}

		window.riot.mount( 'post-form', { onSubmitted: onPostSubmit, baseApiPath: '{{ url( 'api' ) }}' } );

		function getPostId( post ) {
			return post.post_id;
		}

		function loadPost( last_id, tag ) {
			window.axios.get( '{{ url( "api/timeline" ) }}' + ( last_id !== null ? '/' + last_id : '' ) )
				.then( function( response ) {
					tag.addItems( response.data );
				}).catch( function( error ) {
					tag.error();
					console.log( error );
				});
		}

		window.riot.mount( 'tag-infinite-scroller', { load: loadPost, getItemId: getPostId, component: 'post-renderer', scrollElement: document } );
	</script>
@endsection