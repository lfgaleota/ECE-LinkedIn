<div class="callout card entity">
	<div class="card-section">
		<div class="grid-x grid-margin-x header">
			<div class="cell shrink">
				<img src="{{ $entity->photo_url or \App\Entity::default_photo_url }}" />
			</div>
			<div class="cell auto name">
				{{ $entity->name }}
			</div>
		</div>
		<div class="description">{{ $entity->description }}</div>
	</div>
</div>