<?php
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
        
        <li class="treeview{{activeGroup('condidat')}}">
          <a href="#">
            <span>Condidats</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li class="{{active('newcondidat')}}"><a href="{{route('newcondidat')}}"><i class="fa fa-user-plus"></i></i> Nouveau condidat </a></li>
            <li class="{{active('listcondidate')}}"><a href="{{route('listcondidate')}}"><i class="fa fa-list"></i> Liste </a></li>
          </ul>
        </li>

        <li class="treeview{{activeGroup('sujet')}}">
          <a href="#">
            <span>Sujet</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li class="{{active('newsujet')}}"><a href="{{route('newsujet')}}"><i class="fa fa-user-plus"></i></i> Nouveau Sujet </a></li>
            <li class="{{active('listsujet')}}"><a href="{{route('listsujet')}}"><i class="fa fa-list"></i> Liste des sujets </a></li>
          </ul>
        </li>

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

        <li class="treeview">
          <a href="#">
            <i class="fa fa-circle-o text-yellow"></i> <span>Warning</span>
          </a>
        </li>
        <li class="header">&nbsp</li>
        <li class="header">&nbsp</li>
        <li class="header">TRUCS</li>
        <li class="treeview">
          <a href="#">
            <i class="fa fa-circle-o text-aqua"></i> <span>Information</span>
          </a>
        </li>
      </ul>
    </section>
    <!-- /.sidebar -->
  </aside>
