@extends('layouts.app')

@section( 'styles' )
    @parent
    <link href="{{ asset('css/welcome.css') }}" rel="stylesheet">
@endsection

@section( 'scripts' )
    @parent
    <script src="{{ asset('js/welcome.js') }}"></script>
@endsection

@section('content')
    <div class="grid-container">
        <div class="grid-x grid-padding-x">
            <div class="cell small-12 medium-7 large-9">
                Le réseau social des professionnels
            </div>
            <div class="cell small-12 medium-5 large-3">
                <div class="card">
                    <div class="card-section">
                        <section id="login" data-selected="{{ old( 'registration' ) ? 'register' : 'login' }}">
                            <div id="login_pane">
                                @if(old('registration'))
                                    @include('auth.inc.login', ['errors' => new \Illuminate\Support\ViewErrorBag()])
                                @else
                                    @include('auth.inc.login')
                                @endif
                                <p class="separator">or</p>
                                <a id="register_switch" href="#" class="button expanded">Register</a>
                            </div>
                            <div id="register_pane">
                                @if(old('registration'))
                                    @include('auth.inc.register')
                                @else
                                    @include('auth.inc.register', ['errors' => new \Illuminate\Support\ViewErrorBag()])
                                @endif
                                <p class="separator">or</p>
                                <a id="login_switch" href="#" class="button expanded">Login</a>
                            </div>
                        </section>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection