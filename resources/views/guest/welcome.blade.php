@php($is_index = true)
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
            <div class="cell hidden-for-small-only medium-7 large-9 welcome-left">
                <h1>Bienvenue sur Calamar Flamboyant</h1>
                <h4>Le réseau social des professionnels</h4>
                <div class="text-center hide-for-small-only">
                    <img src="{{asset('images/logo.png')}}" alt="Logo">
                </div>
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
                                <p class="separator">ou</p>
                                <a id="register_switch" href="#" class="button expanded">S'inscrire</a>
                            </div>
                            <div id="register_pane">
                                @if(old('registration'))
                                    @include('auth.inc.register')
                                @else
                                    @include('auth.inc.register', ['errors' => new \Illuminate\Support\ViewErrorBag()])
                                @endif
                                <p class="separator">ou</p>
                                <a id="login_switch" href="#" class="button expanded">Se connecter</a>
                            </div>
                        </section>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="video-bg">
        <video loop muted autoplay>
            <source src="http://99deaefa0b5ada8f76c5-300aeeb3886c20b990a2b7efeaace3cd.r77.cf5.rackcdn.com/bg.mp4" type="video/mp4">
        </video>
    </div>
@endsection
