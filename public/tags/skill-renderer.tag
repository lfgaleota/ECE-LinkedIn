<skill-renderer>
	<div class="callout card profile-content-card">
		<div class="card-divider">
			Compétences
			<button type="button" class="button success align-right add" if={ opts.canedit } onclick={ openAdd }><i class="fas fa-plus"></i></button>
		</div>
		<div class="card-section">
			<div class="paragraph" each={ item in items }>
				<button type="button" class="button alert remove" if={ opts.canedit } onclick={ remove }><i class="fas fa-times"></i></button>
				<button type="button" class="button secondary edit" if={ opts.canedit } onclick={ openEdit }><i class="fas fa-edit"></i></button>
				<p>{ item }</p>
			</div>
			<div class="paragraph" if={ items.length == 0 }>
				<p class="text-center"><i class="fas fa-ban"></i></p>
			</div>
		</div>
	</div>
	<div ref="modal" class="reveal" id={ modalId } data-reveal data-close-on-click="true">
		<form onsubmit={ submit }>
			<div>
				<label for={ modalId + 'skill' } class="">Compétence</label>
				<input required ref="skill" class="" name="skill" type="text" id={ modalId + 'skill' }>
			</div>

			<div>
				<input class="button expanded" type="submit" value={ edit ? 'Modifier' : 'Ajouter' }>
			</div>
		</form>

		<button class="close-button" data-close aria-label="Close reveal" type="button">
			<span aria-hidden="true">&times;</span>
		</button>
	</div>

	<style>
		.paragraph:not(:last-of-type) {
			border-bottom: 1px solid #e6e6e6;
		}

		.paragraph {
			position: relative;
		}

		.paragraph p {
			margin-bottom: 0;
		}

		button.add {
			font-size: 12px;
		}

		button.add,
		button.edit,
		button.remove {
			position: absolute;
			font-size: 12px;
			padding: 0.25rem;
		}

		button.edit,
		button.remove {
			top: 0;
		}

		button.add {
			right: 1rem;
		}

		button.edit {
			right: 0;
		}

		button.remove {
			right: 1.5rem;
		}
	</style>

	<script>
		this.modalId = Date.now();
		this.items = [];
		this.edit = false;
		let that = this;

		clear() {
			that.edit = false;
			that.itemIndex = null;
			$( that.refs.skill ).val( '' );
		}

		remove( e ) {
			that.items.splice( that.items.indexOf( e.item ), 1 );
			that.update();
			that.save();
		}

		add( item ) {
			that.items.push( item );
			that.update();
			that.save();
		}

		modify( item ) {
			that.items[ that.itemIndex ] = item;
			that.update();
			that.save();
		}

		openAdd( e ) {
			e.preventDefault();
			e.stopImmediatePropagation();
			$( that.refs.modal ).foundation( 'open' );
		}

		openEdit( e ) {
			e.preventDefault();
			e.stopImmediatePropagation();
			$( that.refs.skill ).val( e.item.item );
			that.edit = true;
			that.itemIndex = that.items.indexOf( e.item.item );
			$( that.refs.modal ).foundation( 'open' );
		}

		submit( e ) {
			e.preventDefault();
			e.stopImmediatePropagation();
			if( !that.edit ) {
				that.add( that.generate() );
			} else {
				that.modify( that.generate() );
			}
			that.clear();
			$( that.refs.modal ).foundation( 'close' );
		}

		currentWorkClicked( e ) {
			$( that.refs.end ).prop( 'disabled', function( i, val ) { return !val; } );
		}

		generate() {
			return $( that.refs.skill ).val();
		}

		save() {
			window.axios.post( opts.baseapipath + '/' + opts.username + '/skill', { 'data': that.items } ).catch( function( error ) {
				console.log( error );
			});
		}

		this.on( 'mount', function() {
			if( opts.initialitems != null ) {
				that.items = opts.initialitems;
				that.update();
			}
			$( that.refs.modal ).foundation();
		});
	</script>
</skill-renderer>