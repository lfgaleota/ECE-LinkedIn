@foreach( $jobs as $job )

		<div class="cell auto">
			<h1>{{ $job->getPosition() }}</h1>
			<h2>{{ $job->getEntity()->getName() }}</h2>
			<p>{{ $job->getDescription() }}</p>
		</div>

@endforeach

