<?php
function active($route) {
  if(Request::url() == route($route))
    return " active";
}
?>
  <aside class="main-sidebar">
    <section class="sidebar">
      <ul class="sidebar-menu">
        <li class="header">MENU DE NAVIGATION</li>
        
        <li class="treeview active">
          <a href="#">
            <i class="fa fa-circle-o text-red"></i> <span>Important</span>  
          </a>
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
