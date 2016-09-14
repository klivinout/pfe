<?php
$privilege = Auth::User()->type;
function active($route) {
  if(is_array($route)) {
    foreach ($route as $r) {
      if(Request::url() == route($r))
        return " active";
    }
  }else if(Request::url() == route($route))
    return " active";
}
function activeGroup($group) {
  if(strpos(Request::route()->getPrefix(),$group))
    return " active";
}
?>
  <aside class="main-sidebar">
    <section class="sidebar">
      <ul class="sidebar-menu">
        <li class="header">MENU DE NAVIGATION</li>
        @if($privilege != 3) <!-- restrected for the trainer -->
        <li class="treeview{{activeGroup('condidat')}}">
          <a href="#">
            <span>Condidats</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            @if($privilege == 1 || $privilege == 10)
            <li class="{{active('newcondidat')}}"><a href="{{route('newcondidat')}}"><i class="fa fa-user-plus"></i></i> Nouveau condidat </a></li>
            @endif
            <li class="{{active('listcondidate')}}"><a href="{{route('listcondidate')}}"><i class="fa fa-list"></i> Liste </a></li>
          </ul>
        </li>
        @endif
        <li class="treeview{{activeGroup('sujet')}}">
          <a href="#">
            <span>Sujet</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            @if($privilege != 3)
            <li class="{{active('newsujet')}}"><a href="{{route('newsujet')}}"><i class="fa fa-user-plus"></i></i> Nouveau Sujet </a></li>
            @endif
            <li class="{{active('listsujet')}}"><a href="{{route('listsujet')}}"><i class="fa fa-list"></i> Liste des sujets </a></li>
          </ul>
        </li>
        @if($privilege != 3)
        <li class="treeview{{activeGroup('stagiaire')}}">
          <a href="#">
            <span>Stagiaire</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li class="{{active('liststagiaires')}}"><a href="{{route('liststagiaires')}}"><i class="fa fa-list"></i> Liste des Stagiaires </a></li>
          </ul>
        </li>
        @endif
        @if($privilege==3  || $privilege==2 || $privilege==10)
        <li class="treeview{{activeGroup('tache')}}">
          <a href="#">
            <span>Stages et Taches</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li class="{{active('newtache')}}"><a href="{{route('newtache',['id'=>'tout','tache'=>'tout'])}}"><i class="fa fa-list"></i> Nouvelle tache </a></li>
          </ul>
          <ul class="treeview-menu">
            <li class="{{active('listtache')}}"><a href="{{route('listtache')}}"><i class="fa fa-list"></i> Stages et taches </a></li>
          </ul>
        </li>
        @endif
        @if($privilege == 10)
        <li class="treeview{{activeGroup('parametre')}}">
          <a href="#">
            <span>Parametres</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li class="{{active('getparametres')}}"><a href="{{route('getparametres')}}"><i class="fa fa-list"></i> Nouveau</a></li>
          </ul>
          <ul class="treeview-menu">
            <li class="{{active('listparametres')}}"><a href="{{route('listparametres')}}"><i class="fa fa-list"></i> Liste des Departements </a></li>
          </ul>
        </li>
        @endif
        <li class="{{active('profile')}}">
          <a href="{{route('profile')}}">
            <span>Profile</span>
          </a>
        </li>
      </ul>
    </section>
    <!-- /.sidebar -->
  </aside>
