<tag-infinite-scroller>
	<div ref="scroller">
		<virtual each={ item in items }>
			<div data-is={ opts.component } item={ item }></div>
		</virtual>
		<spinner if={ loading }></spinner>
		<div class="text-center" if={ hasError }>
			<h5>Une erreur est survenue durant le chargement.</h5>
		</div>
	</div>

	<style>
		:scope {
			width: 0;
			height: 0;
			margin: 0;
		}

		spinner {
			margin: 0.5em auto;
		}
	</style>

	<script>
		this.items = [];
		this.loading = false;
		this.hasError = false;
		this.noMore = false;

		let that = this;

		reload() {
			that.loadInitial();
		}

		loadInitial() {
			that.loading = true;
			that.hasError = false;
			that.noMore = false;
			that.items = [];
			opts.load( null, that );
		}

		loadMore() {
			that.loading = true;
			that.hasError = false;
			that.noMore = false;
			if( that.items.length === 0 ) {
				opts.load( null, that );
			} else {
				that.scrollElement[ 0 ].scrollTop = getHeight();
				let last_id = opts.getItemId( that.items[ that.items.length - 1 ] );
				opts.load( last_id, that );
			}
		}

		addItems( items ) {
			that.loading = false;
			if( items == null || items.length === 0 ) {
				that.noMore = true;
			} else {
				that.items = that.items.concat( items );
			}
			that.update();
		}

		error() {
			that.loading = false;
			that.hasError = false;
		}

		function getHeight() {
			return ( that.scrollElementIsDocument ? getDocHeight() : that.scrollElement[ 0 ].scrollHeight );
		}

		// https://gist.github.com/theskumar/3447654
		function getDocHeight() {
			var D = document;
			return Math.max(
				Math.max(D.body.scrollHeight, D.documentElement.scrollHeight),
				Math.max(D.body.offsetHeight, D.documentElement.offsetHeight),
				Math.max(D.body.clientHeight, D.documentElement.clientHeight)
			);
		}

		this.on( 'mount', function() {
			that.scrollElementIsDocument = opts.scrollElement === document;
			that.scrollElement = $( opts.scrollElement ? opts.scrollElement : that.refs.scroller );
			that.loadInitial();
			that.scrollElement.on( 'scroll', function() {
				if( !that.loading ) {
					if( that.scrollElement.scrollTop() + that.scrollElement.innerHeight() >= getHeight() ) {
						that.loadMore();
					}
				}
			});
		});
	</script>
</tag-infinite-scroller>