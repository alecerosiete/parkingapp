<!DOCTYPE html>
<html lang="es">
  <head>
    <!-- Import Headers -->
    <?php echo $layout_headers; ?>
    <!-- jQuery 2.1.4 -->
    <script src="<?= base_url() ?>public/backend/plugins/jQuery/jQuery-2.1.4.min.js"></script>
    <?= $this->layout->css ?>
  </head>
  <body class="sidebar-mini skin-black sidebar-mini">
    <div class="wrapper">
      <!-- Import navbar -->
      <header class="main-header">
        <?php echo $layout_menu; ?>
      </header>
      <!-- /navbar -->

      <!--aside-->
      <aside class="main-sidebar">
        <?php echo $layout_aside; ?>
      </aside>
      <!--/aside-->


      <div class="content-wrapper">

      <!-- Content Wrapper. Contains page content -->
        <?php echo $layout_content; ?>
      </div>
      <!-- /container --> 


      <!-- Footer -->
      <footer class="main-footer">
        <?php echo $layout_footer; ?>
      </footer>
      <!-- /Footer -->

        <?php 
        /*
      <aside class="control-sidebar control-sidebar-dark">
        <?php echo $layout_control_sidebar; ?>
      </aside>
      */
        ?>
    </div>


    <!-- Bootstrap 3.3.2 JS -->
    <script src="<?= base_url() ?>public/backend/bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
    <!--Data Tables-->
    <script src="<?= base_url() ?>public/backend/plugins/datatables/jquery.dataTables.min.js" type="text/javascript"></script>
    <script src="<?= base_url() ?>public/backend/plugins/datatables/dataTables.bootstrap.min.js" type="text/javascript"></script>
    <!-- FastClick -->
    <script src='<?= base_url() ?>public/backend/plugins/fastclick/fastclick.min.js'></script>
    <!-- AdminLTE App -->
    <script src="<?= base_url() ?>public/backend/dist/js/app.min.js" type="text/javascript"></script>
    <!-- Sparkline -->
    <script src="<?= base_url() ?>public/backend/plugins/sparkline/jquery.sparkline.min.js" type="text/javascript"></script>
    <!-- jvectormap -->
    <script src="<?= base_url() ?>public/backend/plugins/jvectormap/jquery-jvectormap-1.2.2.min.js" type="text/javascript"></script>
    <script src="<?= base_url() ?>public/backend/plugins/jvectormap/jquery-jvectormap-world-mill-en.js" type="text/javascript"></script>
    <!-- SlimScroll 1.3.0 -->
    <script src="<?= base_url() ?>public/backend/plugins/slimScroll/jquery.slimscroll.min.js" type="text/javascript"></script>
    <!-- ChartJS 1.0.1 -->
<!--    <script src="<?= base_url() ?>/public/backend/plugins/chartjs/Chart.min.js" type="text/javascript"></script>-->
    <?= $this->layout->js ?>
    <!-- AdminLTE dashboard demo (This is only for demo purposes) -->
    <!--<script src="<?= base_url() ?>/public/backend/dist/js/pages/dashboard2.js" type="text/javascript"></script>-->

    <!-- AdminLTE for demo purposes -->
    <script src="<?= base_url() ?>public/backend/dist/js/demo.js" type="text/javascript"></script>
    <script src="<?= base_url() ?>public/backend/plugins/notify/bootstrap-notify.js" type="text/javascript"></script>
    <script src="<?= base_url() ?>public/backend/plugins/notify/bootstrap-notify.min.js" type="text/javascript"></script>

        <!-- script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.11.2/moment.min.js"></script -->
        <!-- script src="<?= base_url() ?>public/backend/plugins/daterangepicker/daterangepicker.js"></script -->
        <!-- bootstrap datepicker -->
        <!-- script src="<?= base_url() ?>public/backend/plugins/datepicker/bootstrap-datepicker.js"></script -->
        
  </body>
</html>
