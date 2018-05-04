<education-renderer>
	<div class="callout card profile-content-card">
		<div class="card-divider">
			Education
			<button type="button" class="button success align-right add" if={ opts.canedit } onclick={ openAdd }><i class="fas fa-plus"></i></button>
		</div>
		<div class="card-section">
			<div class="paragraph" each={ item in items }>
				<button type="button" class="button alert remove" if={ opts.canedit } onclick={ remove }><i class="fas fa-times"></i></button>
				<button type="button" class="button secondary edit" if={ opts.canedit } onclick={ openEdit }><i class="fas fa-edit"></i></button>
				<p><strong>{ item.company }</strong></p>
				<p>{ item.title }</p>
				<p class="period">{ moment( item.from ).format( 'MMM YY' ) }-{ item.to != null ? moment( item.to ).format( 'MMM YY' ) : 'maintenant' }</p>
				<p class="description">{ item.description }</p>
			</div>
			<div class="paragraph" if={ items.length == 0 }>
				<p class="text-center"><i class="fas fa-ban"></i></p>
			</div>
		</div>
	</div>
	<div ref="modal" class="reveal" id={ modalId } data-reveal data-close-on-click="true">
		<form onsubmit={ submit }>
			<div>
				<label for={ modalId + 'title' } class="">Diplôme</label>
				<input required ref="title" class="" name="title" type="text" id={ modalId + 'title' }>
			</div>

			<div>
				<label for={ modalId + 'company' } class="">Institution</label>
				<input required ref="company" class="" name="company" type="text" id={ modalId + 'company' }>
			</div>

			<div>
				<label for={ modalId + 'description' } class="">Description</label>
				<input required ref="description" class="" name="description" type="text" id={ modalId + 'description' }>
			</div>

			<div>
				<label for={ modalId + 'start' } class="">De</label>
				<input required ref="start" class="" name="start" type="date" id={ modalId + 'start' }>
			</div>

			<div>
				<label for={ modalId + 'end' } class="">A</label>
				<input required ref="end" name="end" type="date" id={ modalId + 'end' }>
				<label>
					<input ref="currentWork" name="currentWork" type="checkbox" onclick={ currentWorkClicked }>
					J'y travaille actuellement
				</label>
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

		.paragraph p.period,
		.paragraph p.description {
			font-size: 0.9em;
			color: #666;
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
			$( that.refs.title ).val( '' );
			$( that.refs.company ).val( '' );
			$( that.refs.description ).val( '' );
			$( that.refs.start ).val( '' );
			$( that.refs.end ).val( '' );
			$( that.refs.currentWork ).prop( 'checked', false );
			$( that.refs.end ).prop( 'disabled', false );
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
			that.items[ that.itemIndex ] = {};
			for( let property in item ) {
				if( item.hasOwnProperty( property ) ) {
					that.items[ that.itemIndex ][ property ] = item[ property ];
				}
			}
			that.update();
			that.save();
		}

		openAdd( e ) {
			e.preventDefault();
			e.stopImmediatePropagation();
			$( that.refs.modal ).foundation( 'open' );
		}

		openEdit( e ) {
			console.log( e.item );
			e.preventDefault();
			e.stopImmediatePropagation();
			$( that.refs.title ).val( e.item.item.diploma );
			$( that.refs.company ).val( e.item.item.institution );
			$( that.refs.description ).val( e.item.item.description );
			$( that.refs.start ).val( e.item.item.from );
			$( that.refs.end ).val( e.item.item.to );
			if( e.item.item.end == null ) {
				$( that.refs.currentWork ).prop( 'checked', true );
				that.currentWorkClicked();
			}
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
			return {
				diploma: $( that.refs.title ).val(),
				institution: $( that.refs.company ).val(),
				description: $( that.refs.description ).val(),
				from: $( that.refs.start ).val(),
				to: $( that.refs.currentWork ).prop( "checked" ) ?  null : $( that.refs.end ).val()
			};
		}

		save() {
			window.axios.post( opts.baseapipath + '/' + opts.username + '/education', { 'data': that.items } ).catch( function( error ) {
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
</education-renderer>