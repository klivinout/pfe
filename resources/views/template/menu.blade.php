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
?>
  <aside class="main-sidebar">
    <section class="sidebar">
      <ul class="sidebar-menu">
        <li class="header">MENU DE NAVIGATION</li>
        
        <li class="treeview{{active(array('newcondidat','modifycondidat','listcondidate'))}}">
          <a href="#">
            <span>Condidats et Stagiaires</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li class="{{active('newcondidat')}}"><a href="{{route('newcondidat')}}"><i class="fa fa-user-plus"></i></i> Nouveau condidat </a></li>
            <li class="{{active('listcondidate')}}"><a href="{{route('listcondidate')}}"><i class="fa fa-list"></i> Liste </a></li>
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
