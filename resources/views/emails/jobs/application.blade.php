@component('mail::message')

Une personne a postulée à votre offre d'emploi.

<div style="text-align: center">
	<p style="text-align: center"><img src="{{ $applicant->photo_url or \App\User::default_photo_url }}" style="width: 64px;height: 64px;border-radius:50%;border: 1px solid black;" /></p>
	<p style="text-align: center">{{ $applicant->getName() }}</p>
</div>

## Compétences
@php
	$infos = $applicant->infos;
	if( $infos == null ) {
		$infos = '{}';
	}
	$infos = json_decode( $infos, true );
	if( !isset( $infos[ 'skills' ] ) ) {
		$infos[ 'skills' ] = [];
	}
@endphp
@if( count( $infos[ 'skills' ] ) == 0 )
- Aucune répertoriée sur le profil
@endif
@foreach( $infos[ 'skills' ] as $skill )
- $skill
@endforeach

## Lettre de motivation
@foreach( preg_split("/((\r?\n)|(\r\n?))/", $coverLetter) as $line )
> {{ $line }}
@endforeach

@component('mail::button', ['url' => route( 'user.profile', [ 'username' => $applicant->username ] )])
Voir son profil
@endcomponent

— {{ config('app.name') }}
@endcomponent
