@php($title = "Créer une offre d'emploi")
@extends('layouts.app', ['profile_sidebar' => true])

@section('content')
	<div class="callout card">
		<div class="card-divider">
			Créer une offre d'emploi
		</div>
		<div class="card-section">
			@include( 'app.inc.forms.job' )
		</div>
	</div>
@endsection

@section( 'scripts' )
	@parent
	@include( 'app.inc.tags' )
	<script>
		var apiurl = '{{ url( 'api' ) }}';
	</script>
	{{ Html::script( 'js/form-job.js' ) }}
@endsection