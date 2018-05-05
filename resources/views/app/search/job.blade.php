@extends('layouts.app')

@section('content')
	<div id="home" class="grid-container">
		<div class="grid-x grid-margin-x">
			<div class="cell medium-4 large-3 hide-for-small-only">
				@include( 'app.inc.users.profile-card', [ 'user' => Auth::user() ] )
				<div class="callout card search-companion">
					<div class="card-section">
						<ul class="accordion" data-accordion>
							@php($i = 0)
							@foreach( [ 'position' => 'Poste', 'entity_location' => 'Localisation', 'entity_name' => 'Entreprise/école' ] as $tag => $name )
								<li class="accordion-item {{ $i == 0 ? 'is-active' : '' }}" data-accordion-item>
									<a href="#" class="accordion-title">{{ $name }}</a>
									<div class="accordion-content" data-tab-content>
										<div id="refinement-list-{{ $tag }}"></div>
									</div>
								</li>
								@php($i++)
							@endforeach
						</ul>
					</div>
				</div>
			</div>
			<div class="cell small-12 medium-8 large-9">
				<div class="callout card search-panel">
					<div class="card-divider">
						<ul class="menu">
							<li><a href="{{ route( 'search.user', [ 'q' => $query ] ) }}">Utilisateurs</a></li>
							<li class="is-active"><a>Offres d'emplois</a></li>
						</ul>
						<div id="search-box"></div>
						<a href="http://algolia.com/" title="Fourni par Algolia" target="_blank">
							<svg class="provider" viewBox="0 0 95 95" xmlns="http://www.w3.org/2000/svg">
								<path d="M0 12.37C0 5.54 5.532 0 12.367 0h69.31c6.831 0 12.368 5.533 12.368 12.37v69.331c0 6.832-5.532 12.371-12.367 12.371h-69.31C5.536 94.072 0 88.539 0 81.702V12.37zm48.125 11.405c-14.671 0-26.58 11.898-26.58 26.588 0 14.69 11.895 26.588 26.58 26.588 14.685 0 26.58-11.912 26.58-26.602S62.81 23.775 48.125 23.775zm0 45.307c-10.343 0-18.727-8.386-18.727-18.733 0-10.346 8.384-18.732 18.727-18.732 10.344 0 18.727 8.386 18.727 18.732 0 10.347-8.383 18.733-18.727 18.733zm0-33.6v13.955c0 .408.436.68.803.49L61.3 43.501a.548.548 0 0 0 .217-.762c-2.572-4.506-7.335-7.596-12.834-7.8a.549.549 0 0 0-.558.544zM30.76 25.246l-1.62-1.62a4.082 4.082 0 0 0-5.77 0l-1.933 1.933a4.085 4.085 0 0 0 0 5.773l1.606 1.606c.245.245.64.204.844-.068a30.572 30.572 0 0 1 3.116-3.662 29.723 29.723 0 0 1 3.689-3.131c.272-.19.3-.6.068-.83zm26.063-4.234v-3.226a4.078 4.078 0 0 0-4.083-4.084h-9.5a4.078 4.078 0 0 0-4.083 4.084v3.308c0 .368.354.626.708.531a29.562 29.562 0 0 1 8.275-1.157c2.722 0 5.403.367 7.989 1.075a.55.55 0 0 0 .694-.53z"
								      fill-rule="evenodd"></path>
							</svg>
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
			let url = '{{ route( 'job.show', [ 'id' => '#job_id#' ] ) }}';
			url = url.replace( '#job_id#', item.job_id );
			let position = item._highlightResult.position.value.length > 0 ? item._highlightResult.position.value : item.position;
			let entity_location = item._highlightResult.entity_location.value.length > 0 ? item._highlightResult.entity_location.value : item.entity_location;
			let entity_name = item._highlightResult.entity_name.value.length > 0 ? item._highlightResult.entity_name.value : item.entity_name;
			let description = item._highlightResult.description.value.length > 0 ? item._highlightResult.description.value : item.description;
			let entity_description = item._highlightResult.entity_description.value.length > 0 ? item._highlightResult.entity_description.value : item.entity_description;
			return '<a class="cell thumbnail job-offer small-12 medium-6 large-4 no-height" href="' + url + '">'+
				'<p class="entity-photo"><img src="' + __getEntityPhotoUrl( item.entity_photo_url ) + '" /></p>'+
				'<p class="position">' + item.position + '</p>'+
				'<p class="entity-name">' + item.entity_name + '</p>'+
				'<p class="entity-location">' + item.entity_location + '</p>'+
				'<p class="description">'+ _.truncate( item.description, { length: 100 } ) +'</div>'+
				'<p class="date">' + moment( item.created_at ).fromNow() + '</p>'+
				'</a>';
		};

		const search = window.instantsearch( {
			appId: '{{ env( 'ALGOLIA_APP_ID', '' ) }}',
			apiKey: '{{ env( 'ALGOLIASEARCH_API_KEY_SEARCH', '' ) }}',
			indexName: '{{ (new \App\JobOffer)->getTable() }}',
			urlSync: true
		} );

		// initialize RefinementList
		_.forEach( [ 'position', 'entity_location', 'entity_name' ], function( criter ) {
			search.addWidget(
				window.instantsearch_widgets.refinementList( {
					container: '#refinement-list-' + criter,
					attributeName: criter
				} )
			);
		} );

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

@section('styles')
	@parent
	{{ Html::style( 'css/job-list.css' ) }}
@endsection