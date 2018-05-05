var entity_id = $( 'input[name="entity_id"]' );
var entity_is_selected = $( '#post_entity_isselected' );

function entitiesGet( tag ) {
	tag.isLoading();
	window.axios.get( apiurl + '/entity' )
	.then( function( response ) {
		tag.notLoading();
		let items = response.data;
		for( let i = 0; i < items.length; i++ ) {
			if( items[ i ].entity_id == entity_id.val() ) {
				items[ i ].selected = true;
			}
		}
		tag.setItems( items );
	}).catch( function( error ) {
		tag.notLoading();
		console.log( error );
	});
}

function onEntitySelected( entities ) {
	if( entities.length > 0 ) {
		entity_id.val( entities[ 0 ].entity_id );
		entity_is_selected.show();
	} else  {
		entity_id.val();
		entity_is_selected.hide();
	}
}

function onEntityCancelled() {
	entity_id.val();
	entity_is_selected.hide();
}

$( '#post_entity_selector' ).click( function( e ) {
	e.preventDefault();
	e.stopImmediatePropagation();
	$( 'body' ).append( $( '<tag-selector></tag-selector>' ) );
	window.riot.mount( 'tag-selector', {
		onSelected: onEntitySelected,
		onCancelled: onEntityCancelled,
		component: 'entity-renderer',
		itemGetInitier: entitiesGet,
		hasAdd: false,
		unique: true
	});
});