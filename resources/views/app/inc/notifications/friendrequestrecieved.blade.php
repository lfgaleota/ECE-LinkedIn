@php($sender = $notification->data['sender'] )
@php($name=$sender['name'] ." ".$sender['surname'])

<a href="{{ route( 'user.profile', [ 'username' => $sender['username'] ] ) }}">{{ $name }} vous a demandé en ami</a>