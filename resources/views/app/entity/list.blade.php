@extends('layouts.app', ['profile_sidebar' => true])

@section('content')
	<div class="callout card">
		<div class="card-divider">
			Mes entreprises/écoles
			@if( isset( $editable ) && $editable )
				<a href="{{ route( 'entity.create' ) }}" class="button tiny success force-right"><i class="fas fa-plus"></i></a>
			@endif
		</div>
		<div class="card-section nopadding">
			<table class="hover profile_img noborder">
				<thead>
				<tr>
					<th></th>
					<th>Nom</th>
					<th>Description</th>
					<th>Localisation</th>
					<th>Actions</th>
				</tr>
				</thead>
				<tbody>
				@foreach( $entities as $entity )
					<tr>
						<td><img src="{{ $entity->photo_url or \App\Entity::default_photo_url }}" /></td>
						<td>{{ $entity->name }}</td>
						<td>{{ \Illuminate\Support\Str::limit( $entity->description, 100 ) }}</td>
						<td>{{ $entity->location }}</td>
						<td>
							@if( isset( $editable ) && $editable )
								<a href="{{ route( 'entity.edit', [ 'id' => $entity->entity_id ] ) }}" class="button tiny secondary"><i class="fas fa-edit"></i></a>
								<a href="{{ route( 'entity.delete', [ 'id' => $entity->entity_id ] ) }}" class="button tiny alert"><i class="fas fa-times"></i></a>
							@endif
						</td>
					</tr>
				@endforeach
				</tbody>
			</table>

			{{ $entities->links() }}
		</div>
	</div>
@endsection