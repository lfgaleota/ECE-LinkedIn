<tag-infinite-scroller>
	<div ref="scroller">
		<virtual each={ item in items }>
			<div data-is={ opts.component } item={ item } addsopts={ parent.opts.addsopts }></div>
		</virtual>
		<div class="text-center" if={ loading }>
			<spinner></spinner>
		</div>
		<div class="callout alert" if={ hasError }>
			<p><i class="fas fa-exclamation-triangle"></i> Erreur lors du chargements des données.</p>
		</div>
	</div>

	<style>
		:scope {
			width: 0;
			height: 0;
			margin: 0;
		}

		spinner {
			display: inline-block;
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
			that.update();
			opts.load( null, that );
		}

		loadMore() {
			that.loading = true;
			that.hasError = false;
			that.noMore = false;
			that.update();
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
			that.hasError = true;
			that.update();
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
			if( opts.onMounted ) {
				opts.onMounted( that );
			}
		});
	</script>
</tag-infinite-scroller>