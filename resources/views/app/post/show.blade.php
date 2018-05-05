@php($title = "Publication")
@extends('layouts.app', ['profile_sidebar' => true])

@section('content')
	<post-renderer></post-renderer>
	<loader></loader>
	<div class="callout alert is-hidden">
		<i class="fas fa-exclamation-triangle"></i> Une erreur est survenue lors du chargement.
	</div>
@endsection

@section('scripts')
	@parent
	@include( 'app.inc.tags' )
	<script>
		let loader = $( 'loader' );
		let error = $( '.callout.alert' );

		window.axios.get( '{{ route( 'api.post.get', [ 'post_id' => $post_id ] ) }}' )
			.then(function( response ) {
				loader.hide();
				window.riot.mount( 'post-renderer', {
					item: response.data,
					addsopts: {
						basepath: '{{ url( '/' ) }}',
						baseapipath: '{{ url( 'api' ) }}',
						currentuserid: '{{ Auth::user()->user_id }}'
					}
				});
			}).catch(function( errors ) {
				loader.hide();
				console.log( errors );
			});
		window.riot.mount( 'loader' );
	</script>
@endsection