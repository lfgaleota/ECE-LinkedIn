@if(Auth::check())
    @include('app.home')
@else
    @include('guest.welcome')
@endif