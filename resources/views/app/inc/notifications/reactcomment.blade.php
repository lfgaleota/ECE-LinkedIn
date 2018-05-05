@php($sender = $notification->data['sender'] )
@php($name=$sender['name'] ." ".$sender['surname'])

<a href="{{ route( 'post.get', [ 'post_id' => $notification->data['comment']['post_id'] ] ) }}">{{ $name }} a réagit à votre commentaire.</a>