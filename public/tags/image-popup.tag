<image-popup>
	<div ref="modal" class="full reveal" id={ modal_id } data-reveal>
		<img src={ opts.item.image_url } alt={ opts.item.description }>
		<button class="close-button" data-close aria-label="Close reveal" type="button">
			<span aria-hidden="true">&times;</span>
		</button>
	</div>

	<script>
		this.modal_id = Date.now();
		let that = this;

		this.on( 'mount', function() {
			$( that.refs.modal ).foundation();
			$( that.refs.modal ).foundation( 'open' );
		});
	</script>
</image-popup>