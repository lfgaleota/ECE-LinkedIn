@extends('layouts.app')

@section('content')
	<div id="home" class="grid-container">
		<div class="grid-x grid-margin-x">
			<div class="cell medium-4 large-3 hide-for-small-only">
				@include( 'app.inc.users.profile-card', [ 'user' => Auth::user() ] )
				<div class="callout card search-companion">
					<div class="card-section">
						<ul class="accordion" data-accordion>
							<li class="accordion-item is-active" data-accordion-item>
								<a href="#" class="accordion-title">Noms</a>
								<div class="accordion-content" data-tab-content>
									<div id="refinement-list-surname"></div>
								</div>
							</li>
							<li class="accordion-item" data-accordion-item>
								<a href="#" class="accordion-title">Prénoms</a>
								<div class="accordion-content" data-tab-content>
									<div id="refinement-list-name"></div>
								</div>
							</li>
							<li class="accordion-item" data-accordion-item>
								<a href="#" class="accordion-title">Statuts</a>
								<div class="accordion-content" data-tab-content>
									<div id="refinement-list-title"></div>
								</div>
							</li>
						</ul>
					</div>
				</div>
			</div>
			<div class="cell small-12 medium-8 large-9">
				<div class="callout card search-panel">
					<div class="card-divider">
						<ul class="menu">
							<li class="is-active"><a>Utilisateurs</a></li>
							<li><a>Offres d'emplois</a></li>
						</ul>
						<div id="search-box"></div>
						<a href="http://algolia.com/" title="Fourni par Algolia" target="_blank">
							<svg class="provider" viewBox="0 0 95 95" xmlns="http://www.w3.org/2000/svg"><path d="M0 12.37C0 5.54 5.532 0 12.367 0h69.31c6.831 0 12.368 5.533 12.368 12.37v69.331c0 6.832-5.532 12.371-12.367 12.371h-69.31C5.536 94.072 0 88.539 0 81.702V12.37zm48.125 11.405c-14.671 0-26.58 11.898-26.58 26.588 0 14.69 11.895 26.588 26.58 26.588 14.685 0 26.58-11.912 26.58-26.602S62.81 23.775 48.125 23.775zm0 45.307c-10.343 0-18.727-8.386-18.727-18.733 0-10.346 8.384-18.732 18.727-18.732 10.344 0 18.727 8.386 18.727 18.732 0 10.347-8.383 18.733-18.727 18.733zm0-33.6v13.955c0 .408.436.68.803.49L61.3 43.501a.548.548 0 0 0 .217-.762c-2.572-4.506-7.335-7.596-12.834-7.8a.549.549 0 0 0-.558.544zM30.76 25.246l-1.62-1.62a4.082 4.082 0 0 0-5.77 0l-1.933 1.933a4.085 4.085 0 0 0 0 5.773l1.606 1.606c.245.245.64.204.844-.068a30.572 30.572 0 0 1 3.116-3.662 29.723 29.723 0 0 1 3.689-3.131c.272-.19.3-.6.068-.83zm26.063-4.234v-3.226a4.078 4.078 0 0 0-4.083-4.084h-9.5a4.078 4.078 0 0 0-4.083 4.084v3.308c0 .368.354.626.708.531a29.562 29.562 0 0 1 8.275-1.157c2.722 0 5.403.367 7.989 1.075a.55.55 0 0 0 .694-.53z" fill-rule="evenodd"></path></svg>
						</a>
					</div>
					<div class="card-section">
						<div id="hits"></div>
					</div>
				</div>
			</div>
		</div>
	</div>
@endsection

@section('scripts')
	@parent

	<script>
		let generateTemplate = function( item ) {
			let url = '{{ route( 'user.profile', [ 'username' => "#username#" ] ) }}';
				url = url.replace( '#username#', item.username );
				console.log( item );
			let name = item._highlightResult.name.value.length > 0 ? item._highlightResult.name.value : item.name;
			let surname = item._highlightResult.surname.value.length > 0 ? item._highlightResult.surname.value : item.surname;
			return '<a href="' + url + '" class="friend-line grid-x grid-padding-x">\n' +
					'<div class="cell shrink">\n' +
					'<img src="' + __getProfileUrl( item.photo_url ) + '" />\n' +
					'</div>\n' +
					'<div class="cell auto">\n' +
					'<p>' + name + ' ' + surname + '</p>\n' +
					'</div>\n' +
					'</a>';
		};

		const search = window.instantsearch({
			appId: '{{ env( 'ALGOLIA_APP_ID', '' ) }}',
			apiKey: '{{ env( 'ALGOLIASEARCH_API_KEY_SEARCH', '' ) }}',
			indexName: '{{ (new \App\User)->getTable() }}',
			urlSync: true
		});

		// initialize RefinementList
		search.addWidget(
			window.instantsearch_widgets.refinementList( {
				container: '#refinement-list-name',
				attributeName: 'name'
			} )
		);
		search.addWidget(
			window.instantsearch_widgets.refinementList( {
				container: '#refinement-list-surname',
				attributeName: 'surname'
			} )
		);
		search.addWidget(
			window.instantsearch_widgets.refinementList( {
				container: '#refinement-list-title',
				attributeName: 'title'
			} )
		);

		// initialize SearchBox
		search.addWidget(
			window.instantsearch_widgets.searchBox( {
				container: '#search-box',
				placeholder: 'Rechercher...'
			} )
		);

		// initialize hits widget
		search.addWidget(
			window.instantsearch_widgets.hits( {
				container: '#hits',
				templates: {
					empty: '<p class="text-center">Aucun résultat.</p>',
					item: generateTemplate
				}
			} )
		);

		search.start();
	</script>
@endsection