<video-popup>
	<div ref="modal" class="full reveal" id={ modal_id } data-reveal>
		<video src={ opts.item.video_url } alt={ opts.item.description } controls>
			<div class="callout alert">
				<p><i class="fas fa-exclamation-triangle"></i> Vid"o non  prise en charge par le navigateur.</p>
			</div>
		</video>
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
</video-popup>