<div class="callout profile-header-card">

  <h3>{{ $user->getName() }}</h3>
  <h4>{{ $user->title or 'No title' }}</h4>
  <p>{{ $user->cover_id or '' }}</p>
  <p>{{ $user->photo_id or '' }}</p>

</div>
