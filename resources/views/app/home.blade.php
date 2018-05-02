@extends('layouts.app')

@section('content')
    <post-form></post-form>
    <h1>Votre fil</h1>
    <ul>
        @foreach( $timeline as $post )
            <li><?php var_dump( $post ); ?></li>
        @endforeach
    </ul>
@endsection

@section( 'scripts' )
    @parent
    <script data-src="{{ asset( 'tags/post-form.tag' ) }}" type="riot/tag"></script>
    <script data-src="{{ asset( 'tags/tag-selector.tag' ) }}" type="riot/tag"></script>
    <script data-src="{{ asset( 'tags/friend-renderer.tag' ) }}" type="riot/tag"></script>
    <!--<script data-src="{{ asset( 'tags/friend-selector.tag' ) }}" type="riot/tag"></script>-->
    <script>
        function onPostSubmit( form ) {
        	window.axios.put( '{{ url( "api/post" ) }}', form )
                .then(function( response ) {
                    document.location.reload();
                }).catch(function( error ) {
                	console.log( error );
                });
        }
        riot.mount( 'post-form', { callback: onPostSubmit, baseApiPath: '{{ url( 'api' ) }}' } );
    </script>
@endsection