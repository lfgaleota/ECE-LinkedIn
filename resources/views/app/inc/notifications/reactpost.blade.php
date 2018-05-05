@php($sender = $notification->data['sender'] )
@php($name=$sender['name'] ." ".$sender['surname'])

<a href="{{ route( 'post.get', [ 'post_id' => $notification->data['post']['post_id'] ] ) }}">{{ $name }} a réagit à votre publication.</a>