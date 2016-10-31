<?php

$notifs_user = DB::table('notifications as n')
  ->join('notifs_msg as m','m.code','=','n.type')
  ->where('n.to',Auth::User()->id)
  ->where('n.broadcast',0)
  ->whereNull('n.date_seen')
  ->take(20)
  ->get();
$notifs_dep = DB::table('notifications as n')
  ->join('notifs_msg as m','m.code','=','n.type')
  ->where('to',Auth::User()->departement)
  ->where('broadcast',1)
  ->whereNull('date_seen')
  ->take(20)
  ->get();

$total_notif = count($notifs_dep)+count($notifs_user);

?>
<!DOCTYPE html>
<html>

<head>

  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
  <title> Wilaya de Marrakech-Safi | Gestion de stages </title>
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

  <link rel="stylesheet" href="{{asset('assets/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css')}}">

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

          <!-- Notifications: style can be found in dropdown.less -->
          <li class="dropdown notifications-menu">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
              <i class="fa fa-bell-o"></i>
              <span class="label label-warning">{{$total_notif}}</span>
            </a>
            <ul class="dropdown-menu">
              <li class="header">
                @if($total_notif>0)
                  Vous avez {{$total_notif}} notification(s)
                @else
                  Vous n'avez pas de notifications
                @endif
              </li>
              <li>
                <!-- inner menu: contains the actual data -->
                <ul class="menu">
                @if($total_notif>0)
                  @foreach($notifs_user as $notif_user)
                  <li>
                    <a onclick="notification({{$notif_user->id}},'{{$notif_user->lien}}')">
                      <i class="fa fa-users text-aqua"></i> {{"$notif_user->message"}}
                    </a>
                  </li>
                  @endforeach
                  @foreach($notifs_dep as $notif_dep)
                  <li>
                    <a onclick="notification({{$notif_dep->id}})">
                      <i class="fa fa-users text-aqua"></i> {{"$notif_dep->message"}}
                    </a>
                  </li>
                  @endforeach
                @endif
                </ul>
              </li>
              <li class="footer"><a href="{{"routeallnotifs"}}"></a></li>
            </ul>
          </li>
          <!-- User Account: style can be found in dropdown.less -->
          <li class="dropdown user user-menu">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
              <img src="{{route('profileimage',['id'=>Auth::User()->id])}}" class="user-image" alt="">
              <span class="hidden-xs">{{Auth::User()->fullName()}}</span>
            </a>
            <ul class="dropdown-menu">
              <!-- User image -->
              <li class="user-header">
                <img src="{{route('profileimage',['id'=>Auth::User()->id])}}" class="img-circle" alt="">

                <p>
                  {{Auth::User()->fullName()}} {{Auth::User()->deptName()}}
                </p>
              </li>
              <li class="user-footer">
                <div class="pull-right">
                  <a href="{{route('logout')}}" class="btn btn-default btn-flat">Sign out</a>
                </div>
              </li>
            </ul>
          </li>
        </ul>
      </div>

    </nav>
  </header>
  <script type="text/javascript">
    function notification(id) {
      var url = "{{route('seennotification',['id'=>':id'])}}";
      url = url.replace(':id',id);
      $.post(url,function (rep) {
        if(rep.code == 200) {
          window.location = rep.notif.lien;
        } else {
          swal('Erreur Inconnue est survenu !!');
        }
      });
    }
  </script>
