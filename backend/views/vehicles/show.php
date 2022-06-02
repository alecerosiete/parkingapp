<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>
        Vehiculos
        <small>Version 2.0</small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Inicio</a></li>
        <li class="active">Vehiculos</li>
    </ol>
</section>

<!-- Main content -->
<section class="content">
    <div class="row">
        <!-- left column -->
        <div class="col-md-12 col-sm-12 col-xs-12">
            <!-- general form elements -->
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title">Actualiza Tipo de Vehiculos</h3>
                </div>
                <!-- /.box-header -->
                 <?php if(!isset($vehicle)){ ?>
                <div class="alert alert-warning"> No se encontraron registros para mostrar</div>
                <?php }else{ ?>
                <!-- form start -->
                <form role="form" action="<?= base_url() ?>admin.php/vehicles/edit/<?= $vehicle->id ?>" method='POST' enctype="multipart/form-data" onsubmit="post_submit()">
                    <div class="box-body">
                        <div class='col-sm-12 col-md-12 col-lg-12'>
                            <div class="form-group">
                                <label for="name">Nombre</label>
                                <input type="text" class="form-control" id="name" name="name" value="<?= $vehicle->name ?>">
                            </div>
                        </div>                      

                    </div>
                    <!-- /.box-body -->

                    <div class="box-footer">
                        <div class='col-sm-12 col-md-12 col-lg-12'>
                            <button type="submit" class="btn btn-primary" id="sendVehicle">Guardar</button>
                        </div>
                    </div>
                </form>
                <?php } ?>
            </div>
            <!-- /.box -->

        </div>
        <!--/.col md-12 -->

    </div><!-- /.row -->
</section><!-- /.content -->
<script type="text/javascript">
    $(function () {

<?= validation_errors("$.notify({
      icon: 'glyphicon glyphicon-alert',
      message:'", "'
    }, {
      type: 'error',
      mouse_over: 'pause',
      delay: 7000,
      animate:{
      enter: 'animated shake',
      exit: 'animated fadeOutUp'
    }
  
    });") ?>
<?= get_volatile_warning() ?>
<?= get_volatile_data() ?>
<?= get_volatile_success() ?>
<?= get_volatile_error() ?>
    });

    function post_submit() {
        $("#sendVehicle").attr("disabled", "disabled");
        $("#sendVehicle").val("Guardando..");
    }


</script>
