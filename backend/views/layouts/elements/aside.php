<section class="sidebar">
    <!-- sidebar menu: : style can be found in sidebar.less -->
    <ul class="sidebar-menu">
        <li class="header">MENU PRINCIPAL</li>
        <li class="<?= active_link("main") ?> treeview">
            <a href="<?= base_url() ?>admin.php/main">
                <i class="fa fa-dashboard"></i>
                <span>Inicio</span>
                <span class="fa fa-angle-right  pull-right"></span>
            </a>      
        </li>
        <li class="<?= active_link("panel") ?>">
            <a href="<?= base_url() ?>admin.php/panel">
                <i class="fa fa-bar-chart"></i>
                <span>Panel</span>            
            </a>      
        </li>

<?php if (check_role(ROLE_ADMIN)): ?>
        <li class="<?= active_link("rates").  active_link("vehicles")?> treeview">
            <a href="#">
                <i class="fa fa-truck"></i>
                <span>Estacionamiento</span>
                <i class="fa fa-angle-right pull-right"></i>
            </a>
            <ul class="treeview-menu">
                <li>
                    <a class="<?= active_link("rates") ?>" href="<?= base_url() ?>admin.php/rates/show_list">
                        <i class="fa  fa-dollar"></i> Tarifas
                    </a>
                </li>
                <li>
                    <a class="<?= active_link("vehicles") ?>" href="<?= base_url() ?>admin.php/vehicles/show_list">
                        <i class="fa fa-taxi"></i> Tipos de Vehiculos
                    </a>
                </li>
            </ul>
           

        </li>
 <?php endif; ?>
 
        <!--Clientes-->
        <li class="<?= active_link("clients") ?> treeview">
            <a href="<?= base_url() ?>admin.php/clients/show_list">
                <i class="fa fa-user"></i>
                <span>Clientes</span>
                <i class="fa fa-angle-right pull-right"></i>
            </a>
        </li>
        
<?php if (check_role(ROLE_ADMIN)): ?>
        <!--Configuraciones-->
        <li class="<?= active_link("configurations") ?> treeview">
            <a href="<?= base_url() ?>admin.php/configurations/">
                <i class="fa fa-gear"></i>
                <span>Sistema</span>
                <i class="fa fa-angle-right pull-right"></i>
            </a>
        </li>
        <!--Configuraciones-->
 <?php endif; ?>

        <!-- reportes -->
        <li class="<?= active_link("reports") ?> treeview">
            <a href="#">
                <i class="fa fa-pie-chart"></i>
                <span>Reportes</span>
                <i class="fa fa-angle-right pull-right"></i>
            </a>
             <ul class="treeview-menu">
                    <li class="<?= active_link("reports") ?>"><a href="<?= base_url() ?>admin.php/reports/byUsers"><i class="fa fa-circle-o"></i> Por Usuarios</a></li>
                    <li class="<?= active_link("reports") ?>"><a href="<?= base_url() ?>admin.php/reports/byClients"><i class="fa fa-circle-o"></i>Solo Clientes</a></li>
                </ul>
        </li>
        <!--end reportes -->




        <?php if (check_role(ROLE_ADMIN)): ?>
            <!--Usuarios del sistema-->
            <li class="<?= active_link("profiles") ?> treeview">
                <a href="#">
                    <i class="fa fa-users"></i> <span>Usuarios</span>
                    <i class="fa fa-angle-right pull-right"></i>
                </a>
                <ul class="treeview-menu">
                    <li class="<?= active_link("profiles") ?>"><a href="<?= base_url() ?>admin.php/profiles/new_profile"><i class="fa fa-circle-o"></i> Agregar</a></li>
                    <li class="<?= active_link("profiles") ?>"><a href="<?= base_url() ?>admin.php/profiles/list_profiles"><i class="fa fa-circle-o"></i> Listar</a></li>
                </ul>
            </li>
            <li class="<?= active_link("audit") ?> treeview">
                <a href="<?= base_url() ?>admin.php/audits/show">
                    <i class="fa fa-users"></i> <span>Registro de actividades</span>
                    <i class="fa fa-angle-right pull-right"></i>
                </a>
               
            </li>
             <li>
                <a href="<?= base_url() ?>admin.php/barcodeReader/show_read" target="_blank" ><i class="fa fa-barcode"></i> Barcode Reader</a>
            </li>
        <?php endif; ?>


    </ul>
</section>

