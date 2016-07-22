<!DOCTYPE html>
<html>

<head>

  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
  <title>Wilaya de Marrakech-Safi | Gestion de stages </title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">

  <link rel="stylesheet" href="{{asset('assets/bootstrap/css/bootstrap.min.css')}}">

  <link rel="stylesheet" href="{{asset('assets/bootstrap/css/font-awesome.min.css')}}">
  <link rel="stylesheet" href="{{asset('assets/bootstrap/css/dialog.css')}}">

  <link rel="stylesheet" href="{{asset('/assets/dist/css/ionicons.min.css')}}">

  <link rel="stylesheet" href="{{asset('/assets/dist/css/AdminLTE.min.css')}}">

  <link rel="stylesheet" href="{{asset('assets/dist/css/skins/_all-skins.min.css')}}">

  <link rel="stylesheet" href="{{asset('assets/plugins/colorpicker/bootstrap-colorpicker.min.css')}}">

  <link rel="stylesheet" href="{{asset('assets/plugins/timepicker/bootstrap-timepicker.min.css')}}">

  <link rel="stylesheet" href="{{asset('assets/plugins/select2/select2.min.css')}}">
  <link rel="stylesheet" href="{{asset('assets/plugins/daterangepicker/daterangepicker-bs3.css')}}">
  <link rel="stylesheet" href="{{asset('assets/plugins/iCheck/all.css')}}">

  <link rel="stylesheet" href="{{asset('assets/plugins/datatables/dataTables.bootstrap.css')}}">

  <link rel="stylesheet" href="{{asset('assets/dist/sweetalert/sweetalert.css')}}">
  <link rel="stylesheet" href="{{asset('assets/bootstrap/css/jquery.tokenize.css')}}">

  <link rel="stylesheet" href="{{asset('assets/bootstrap/css/jupload/jquery.fileupload.css')}}">
  <link rel="stylesheet" href="{{asset('assets/bootstrap/css/jupload/jquery.fileupload-ui.css')}}">

</head>

<body class="hold-transition skin-blue sidebar-mini">
<div class="wrapper">

  <header class="main-header">

    <a href="index2.html" class="logo">
      <span class="logo-mini"><b><</b>{}<b>></b></span>
      <span class="logo-lg"><b>Gestion</b>Stages</span>
    </a>
    <nav class="navbar navbar-static-top">
      <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
        <span class="sr-only">Toggle navigation</span>
      </a>
      <!-- Navbar Right Menu -->
      <div class="navbar-custom-menu">
        <ul class="nav navbar-nav">
          <!-- Messages: style can be found in dropdown.less-->
          <li class="dropdown messages-menu">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
              <i class="fa fa-envelope-o"></i>
              <span class="label label-success">{{"4"}}</span>
            </a>
            <ul class="dropdown-menu">
              <li class="header">
                @if(0 == 0)
                  Vous avez {{"4"}} message
                @else
                  Vous n'avez pas de messages
                @endif
              </li>
              <li>
                <!-- inner menu: contains the actual data -->
                <ul class="menu">
                  <li><!-- start message -->
                    <a href="#">
                      <div class="pull-left">
                        <img src="{{asset('assets/img/avatar.png')}}" class="img-circle" alt="User Image">
                      </div>
                      <h4>
                        {{"sender"}}
                        <small><i class="fa fa-clock-o"></i> {{"00:00"}}</small>
                      </h4>
                      <p>{{"objet message"}}</p>
                    </a>
                  </li>
                  <!-- end message -->
                </ul>
              </li>
              <li class="footer"><a href="{{'routeallmsg'}}">Voir tout les messages</a></li>
            </ul>
          </li>
          <!-- Notifications: style can be found in dropdown.less -->
          <li class="dropdown notifications-menu">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
              <i class="fa fa-bell-o"></i>
              <span class="label label-warning">{{"10"}}</span>
            </a>
            <ul class="dropdown-menu">
              <li class="header">
                @if(0 == 0)
                  Vous avez {{"10"}} notifications
                @else
                  Vous n'avez pas de notifications
                @endif
              </li>
              <li>
                <!-- inner menu: contains the actual data -->
                <ul class="menu">
                  <li>
                    <a href="{{"linktonotification"}}">
                      <i class="fa fa-users text-aqua"></i> {{"type of notification"}}
                      <!--
                        types of notifications :
                          - taches : 
                            - ajouter
                            - confirmer
                            - non aprouver
                          - sujets :
                            - proposer
                            - confirmer
                            - en cours 
                            - realisé
                          - stage :
                            - documents signer
                            - stage conclu
                      -->
                    </a>
                  </li>
                </ul>
              </li>
              <li class="footer"><a href="{{"routeallnotifs"}}">Voir tout les notifications</a></li>
            </ul>
          </li>
          <!-- User Account: style can be found in dropdown.less -->
          <li class="dropdown user user-menu">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
              <img src="{{asset('assets/img/avatar.png')}}" class="user-image" alt="">
              <span class="hidden-xs">{{Auth::User()->fullName()}}</span>
            </a>
            <ul class="dropdown-menu">
              <!-- User image -->
              <li class="user-header">
                <img src="{{asset('assets/img/avatar.png')}}" class="img-circle" alt="">

                <p>
                  {{Auth::User()->fullName()}} {{Auth::User()->deptName()}}
                </p>
              </li>
              <li class="user-footer">
                <div class="pull-left">
                  <a href="#" class="btn btn-default btn-flat">Profile</a>
                </div>
                <div class="pull-right">
                  <a href="#" class="btn btn-default btn-flat">Sign out</a>
                </div>
              </li>
            </ul>
          </li>
        </ul>
      </div>

    </nav>
  </header>