<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>
        Tarifas
        <small>Version 2.0</small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Inicio</a></li>
        <li class="active">Tarifas</li>
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
                    <h3 class="box-title">Actualiza Tarifas</h3>
                </div>
                <!-- /.box-header -->
                <!-- form start -->
                <form role="form" action="<?= base_url() ?>admin.php/rates/edit/<?= $rate->id ?>" method='POST' enctype="multipart/form-data" onsubmit="post_submit()">
                    <div class="box-body">
                        <div class='col-sm-12 col-md-4 col-lg-4'>
                           <div class="form-group">
                                <label for="vehicleType">Tipo de Vehiculo</label>
                                <select name="vehicleType" id="vehicleType" class="form-control" >
                                    <?php foreach ($vehicles as $vehicle) { ?>
                                        <option value="<?= $vehicle->name ?>" <?= $vehicle->name == $rate->vehicleType ? "selected" : "" ?> ><?= $vehicle->name ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                       <div class='col-sm-12 col-md-4 col-lg-4'>
                            <div class="form-group">
                                <label for="name">Nombre</label>
                                <input type="text" class="form-control" required id="name" name="name" value="<?php echo $rate->name ?>" placeholder="Ingrese el nombre de la tarifa">
                            </div>
                        </div>
                        <div class='col-sm-12 col-md-4 col-lg-4'>
                            <div class="form-group">
                                <label for="price">Importe</label>
                                <input type="text" class="form-control" required id="price" name="price" value="<?php echo $rate->price ?>" placeholder="Ingrese el Importe de la tarifa">
                            </div>
                        </div>
                        <div class='col-sm-12 col-md-12 col-lg-12 ' >
                            <div class="row" style="text-align:center"><label>Tipo de Tarifa</label>
                                <div class="row ">
                                    <div class='col-sm-12 col-md-12 col-lg-2' style="text-align:center">
                                        <div class="form-group ">
                                            <label>
                                              <input type="radio" class="flat-green checked" name="rateType" id="rt1" value="1" <?php $rate->rateType == 1 ? "checked='true' " : "" ?> ><br>
                                              FRACCION
                                            </label>
                                        </div>
                                    </div>
                                    <div class='col-sm-12 col-md-12 col-lg-3'  style="text-align:center">
                                        <div class="form-group ">
                                            <label>
                                              <input type="radio" class="flat-green" name="rateType" value="2" id="rt2" <?php $rate->rateType == 2 ? "checked='true' ": "" ?>><br>
                                              HORA
                                            </label>
                                        </div>
                                    </div>        
                                    <div class='col-sm-12 col-md-12 col-lg-2'  style="text-align:center" >
                                        <div class="form-group ">        
                                            <label>
                                              <input type="radio" class="flat-green" name="rateType" value="3" id="rt3" <?php $rate->rateType == 3 ? "checked='true' " : "" ?>><br>
                                              DIA
                                            </label>
                                        </div>
                                    </div>       
                                    <div class='col-sm-12 col-md-12 col-lg-3'  style="text-align:center">
                                        <div class="form-group ">              
                                            <label>
                                              <input type="radio" class="flat-green" name="rateType" value="4" id="rt4" <?php $rate->rateType == 4 ? "checked='true' " : "" ?>><br>
                                              MES
                                            </label>
                                        </div>
                                    </div>
                                    <div class='col-sm-12 col-md-12 col-lg-2' style="text-align:center">
                                        <div class="form-group ">               
                                            <label>
                                              <input type="radio" class="flat-green" name="rateType" value="0" id="rt0" <?php $rate->rateType == 0 ? "checked='true' " : "" ?>><br>
                                              SIN COSTO
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class='col-sm-12 col-md-4 col-lg-12'>
                            <div class="form-group">
                                <label for="description">Descripcion</label>
                                <textarea class="form-control" required id="description" name="description" value="" placeholder="Algun comentario"><?php echo $rate->description ?></textarea>
                            </div>
                        </div>


                    </div>
                    <!-- /.box-body -->

                    <div class="box-footer">
                        <div class='col-sm-12 col-md-12 col-lg-12'>
                            <button type="submit" class="btn btn-primary" id="sendRate">Guardar</button>
                        </div>
                    </div>
                </form>
            </div>
            <!-- /.box -->

        </div>
        <!--/.col md-12 -->

    </div><!-- /.row -->
</section><!-- /.content -->
<script type="text/javascript">
    $(function () {

    //iCheck for checkbox and radio inputs
    $('input[type="checkbox"].minimal, input[type="radio"].minimal').iCheck({
      checkboxClass: 'icheckbox_minimal-blue',
      radioClass: 'iradio_minimal-blue'
    });
    //Red color scheme for iCheck
    $('input[type="checkbox"].minimal-red, input[type="radio"].minimal-red').iCheck({
      checkboxClass: 'icheckbox_minimal-red',
      radioClass: 'iradio_minimal-red'
    });
    //Flat red color scheme for iCheck
    $('input[type="checkbox"].flat-red, input[type="radio"].flat-green').iCheck({
      checkboxClass: 'icheckbox_flat-green',
      radioClass: 'iradio_flat-green'
    });
    
    var rt = <?= $rate->rateType ?>;
    $( "#rt"+rt ).iCheck( "check");

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
        $("#sendRate").attr("disabled", "disabled");
        $("#sendRate").val("Guardando..");
    }


</script>
