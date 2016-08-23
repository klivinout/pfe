<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title> Wilaya de Marrakech-Safi | Gestion de stages </title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <!-- Bootstrap 3.3.5 -->
    <!-- Bootstrap 3.3.5 -->
    <link rel="stylesheet" href="{{asset('assets/bootstrap/css/bootstrap.min.css')}}">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
    <!-- Ionicons -->
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="{{asset('/assets/dist/css/AdminLTE.min.css')}}">
    <!-- Theme style -->
    <link rel="stylesheet" href="{{asset('/assets/dist/css/AdminLTE.min.css')}}">
    <!-- iCheck -->
    <link rel="stylesheet" href="{{asset('/assets/plugins/iCheck/square/blue.css')}}">

  </head>
  <body class="hold-transition login-page">
    <div class="login-box">
      <div class="login-logo">
        <a href="#">Wilaya Marrakech-Safi</a>
      </div><!-- /.login-logo -->
      <div class="login-box-body">



        @if (Session::has('info'))

            <div class="alert alert-warning" role="alert">
                {{ Session::get('info') }}
            </div>
        @else
            <p class="login-box-msg">Authentifiez-vous</p>
        @endif




        <form action="{{ route('authlogin') }}" method="post">
          <div class="form-group has-feedback  {{ $errors->has('email') ? 'has-error' : '' }} ">
            <!--Zone et code Email-->

            <input name="email" id="email" type="email" class="form-control" placeholder="Email" value="{{ Request::old('email') ? old('email') : '' }}">


            <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
          </div>
          <div class="form-group has-feedback {{ $errors->has('password') ? 'has-error' : '' }}">
            <!--Zone et code mdp-->

            <input name="password" id="password" type="password" class="form-control" placeholder="Mot de passe">


            <span class="glyphicon glyphicon-lock form-control-feedback"></span>
          </div>
          <div class="row">
            <div class="col-xs-8">
              <div class="checkbox icheck">
                <label>
                  <input type="checkbox" name="remember" id="remember"/> Rester connecté
                </label>
              </div>
            </div><!-- /.col -->
            <div class="col-xs-6">
              <button type="submit" class="btn btn-primary btn-block btn-flat">Se Connecter</button>
            </div><!-- /.col -->
          </div>
          <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
        </form>
        <br>
    </div><!-- /.login-box -->

    <!-- jQuery 2.1.4 -->
    <script src="{{asset('/assets/plugins/jQuery/jQuery-2.1.4.min.js')}}"></script>
    <!-- Bootstrap 3.3.5 -->
    <script src="{{asset('/assets/bootstrap/js/bootstrap.min.js')}}"></script>
    <!-- iCheck -->
    <script src="{{asset('/assets/plugins/iCheck/icheck.min.js')}}"></script>
    <script>
      $(function () {
        $('input').iCheck({
          checkboxClass: 'icheckbox_square-blue',
          radioClass: 'iradio_square-blue',
          increaseArea: '20%' // optional
        });
      });
    </script>
  </body>
</html>
