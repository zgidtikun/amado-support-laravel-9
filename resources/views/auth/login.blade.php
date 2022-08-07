<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <!-- CSRF Token -->
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ env('APP_NAME'); }}</title>

        <!-- Scripts -->
        <script src="{{ asset('js/bootstrap.bundle.min.js') }}" defer></script>
        <script src="{{ asset('js/jquery.min.js') }}" defer></script>
        <script src="{{ asset('js/app.js') }}" defer></script>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css2?family=Sarabun&display=swap" rel="stylesheet">
        <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@700&display=swap" rel="stylesheet">

        <!-- Styles -->
        <link href="{{asset('css/app.css')}}" rel="stylesheet">
        <link href="{{asset('css/styles.css')}}" rel="stylesheet">
        <link href="{{asset('css/app-custom.css')}}" rel="stylesheet">
        <link href="{{asset('vendor/fontawesome/css/all.css')}}" rel="stylesheet"> 
    </head>
    <body class="bg-login">
        <div id="app" class="h-100">  
            <div class="h-100 mt-5">
                <div class="container-fluid h-100">
                    <div class="row align-items-center h-100">
                        <div class="col-xl-6 col-md-10 col-sm-12 mx-auto">
                            <div class="card box-login justify-content-center">
                                <div class="card-body p-0">
                                    <div class="row m-0">
                                        <div class="col-md-6 col-12 p-0">
                                            <form class="row m-0 my-5" id="form-login" method="POST" action="{{ route('login-auth') }}">
                                                @csrf
                                                <div class="col-12 p-0 text-center d-md-none d-block">
                                                    <img class="logo-login" src="{{ asset('images/logo-sm-color.png') }}" alt="">
                                                    <h4 class="text-amado mt-3 font-poppins">AMADO SUPPORT</h4>
                                                    <hr>
                                                </div>
                                                <div class="col-md-12 p-0 text-center my-3">
                                                    <h3 class="font-poppins text-amado-blue">Sign In</h3>
                                                </div>
                                                @if (\Session::has('loginFail'))
                                                <div class="col-md-12 px-3 text-center">
                                                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                                        <i class="fas fa-exclamation-triangle mr-2"></i><strong>{!! \Session::get('loginFail') !!}</strong>
                                                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                                    </div>
                                                </div>
                                                @endif
                                                <div class="col-md-12 p-0 px-5 mt-3">
                                                    <div class="input-group form-group">
                                                        <div class="input-group-prepend">
                                                            <span class="input-group-text"><i class="fas fa-user text-amado-blue"></i></span>
                                                        </div>
                                                        <input type="text" class="form-control rounded-right @error('username') is-invalid @enderror" 
                                                        placeholder="Username" required autocomplete="username" autofocus
                                                        id="username" name="username" value="{{ old('username') }}">
                                                        @error('username')
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                        @enderror
                                                    </div>
                                                    <div class="input-group form-group">
                                                        <div class="input-group-prepend">
                                                            <span class="input-group-text"><i class="fas fa-key text-amado-blue"></i></span>
                                                        </div>
                                                        <input type="password" class="form-control rounded-right @error('password') is-invalid @enderror" 
                                                        placeholder="Password" required autocomplete="current-password"
                                                        id="password" name="password">
                                                        @error('password')
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="col-md-12 p-0 text-center">
                                                    <button type="submit" class="btn btn-amado my-3">
                                                        <i class="fas fa-sign-in-alt mr-2"></i> เข้าสู่ระบบ
                                                    </button>
                                                </div>
                                            </form>
                                        </div>                                        

                                        <div class="col-md-6 col-12 p-0 d-none d-md-block">
                                            <div class="bg-login-card h-100 rounded-r">
                                                <div class="row m-0 align-items-center h-100 mx-auto">
                                                    <div class="col-12 p-0 text-center">
                                                        <img class="logo-login" src="{{ asset('images/logo-sm-white.png') }}" alt="">
                                                        <h4 class="text-white mt-3 font-poppins">AMADO SUPPORT</h4>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <script>
            $('#username','#password').keypress(function(event){
                var keycode = (event.keyCode ? event.keyCode : event.which);
                if(keycode == '13'){
                    $('#form-login').submit();  
                }
            });
        </script>
    </body>
</html>