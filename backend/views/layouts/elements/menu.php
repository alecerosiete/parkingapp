<!-- Logo -->
<a href="<?=base_url()?>admin.php" class="logo">
  <!-- mini logo for sidebar mini 50x50 pixels -->
  <span class="logo-mini"><b>P</b>A</span>
  <!-- logo for regular state and mobile devices -->
  <span class="logo-lg"><b>Parking</b>App</span>
</a>

<style>
.logout {
	background:red!important;
}
</style>
<!-- Header Navbar: style can be found in header.less -->
<nav class="navbar navbar-static-top" role="navigation">
  <!-- Sidebar toggle button-->
  <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
    <span class="sr-only">Toggle navigation</span>
  </a>
  <!-- Navbar Right Menu -->
  <div class="navbar-custom-menu">
    <ul class="nav navbar-nav">
      <li class="dropdown user user-menu">
        <a href="#" class="dropdown-toggle" data-toggle="dropdown">
          <img src="<?= empty(current_user()->avatar) ? base_url()."public/backend/dist/img/avatar5.png" :  current_user()->avatar?>" class="user-image" alt="User Image"/>
          <span class="hidden-xs"><?=current_user()->fullname?> (<?=current_user()->username?>)</span>
        </a>
        <ul class="dropdown-menu">
          <!-- User image -->
          <li class="user-header">
            <img src="<?= empty(current_user()->avatar) ? base_url()."public/backend/dist/img/avatar5.png" :  current_user()->avatar?>" class="img-circle" alt="User Image" />
            <p>
              <?=current_user()->fullname?>             
            </p>
          </li>
          <!-- Menu Body -->

          <!-- Menu Footer-->
          <li class="user-footer">
            <div class="pull-left">
              <a href="<?=base_url()?>admin.php/profiles/show_profile/<?=current_user()->user_id?>" class="btn btn-default btn-flat">Perfil</a>
            </div>
            <div class="pull-right">
              <a href="<?=base_url()?>admin.php/authentication/logout" class="btn btn-danger btn-flat logout">Salir</a>
            </div>
          </li>
        </ul>
      </li>
      <!-- Control Sidebar Toggle Button -->
<!--
      <li>
        <a href="#" data-toggle="control-sidebar"><i class="fa fa-gears"></i></a>
      </li>
-->
    </ul>
  </div>

</nav>
