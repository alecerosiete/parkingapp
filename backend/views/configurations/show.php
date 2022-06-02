<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>
        Configuraciones del Sistema
        <small>Version 2.0</small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Inicio</a></li>
        <li class="active">Configuraciones</li>
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
                    <h3 class="box-title">Actualiza Configuraciones</h3>
                </div>
                <!-- /.box-header -->
                <?php if(isset($configuarations)){?>
                <div class='alert alert-warning'>No se encontro ninguna configuraci&oacute;n</div>
                <?php }?>
                <!-- form start -->
                <form role="form" action="<?= base_url() ?>admin.php/configurations/edit" method='POST' enctype="multipart/form-data" onsubmit="post_submit()">
                    <div class="box-body">
                        <div class="row">
                            <div class="col-sm-12 col-md-6 col-lg-4">
                                <div class="form-group">
                                    <label for="defaultPrice">Tarifa por Extrav&iacute;o</label>
                                    <input type="text" class="form-control" id="defaultPrice" name="defaultPrice" value="<?= @$configurations->defaultPrice ?>">
                                    <small>Costo que se aplica por el extravio de ticket de entrada del estacionamiento</small>
                                </div>
                            </div>
                            
                            <div class="col-sm-12 col-md-6 col-lg-4">
                                <div class="form-group">
                                    <label for="company">Empresa o Razon Social</label>
                                    <input type="text" class="form-control" id="company" name="company" value="<?= @$configurations->company ?>">
                                    <small>Nombre que aparecer&aacute; en el ticket</small>
                                </div>
                            </div>
                            
                            <div class="col-sm-12 col-md-6 col-lg-4">
                                <div class="form-group">
                                    <label for="address">Direcci&oacute;n</label>
                                    <input type="text" class="form-control" id="address" name="address" value="<?= @$configurations->address ?>">
                                    <small>Direcci&oacute;n que aparecer&aacute; en el ticket</small>
                                </div>
                            </div>
                            
                            <div class="col-sm-12 col-md-6 col-lg-4">
                                <div class="form-group">
                                    <label for="ruc">RUC</label>
                                    <input type="text" class="form-control" id="ruc" name="ruc" value="<?= @$configurations->ruc ?>">
                                    <small>Ruc</small>
                                </div>
                            </div>
                            
                             <div class="col-sm-12 col-md-6 col-lg-4">
                                <div class="form-group">
                                    <label for="phone">Tel&eacute;fono</label>
                                    <input type="text" class="form-control" id="phone" name="phone" value="<?= @$configurations->phone ?>">
                                    <small>Tel&eacute;fono</small>
                                </div>
                            </div>
                            <div class="col-sm-12 col-md-6 col-lg-4">
                                <div class="form-group">
                                    <label for="freeTime">Minutos sin costo</label>
                                    <input type="number" min="0" max="1440" class="form-control" id="freeTime" name="freeTime" value="<?= @$configurations->freeTime ?>">
                                    <small>Define el tiempo en minutos de permanencia sin costo en el establecimiento. (por defecto 120 minutos = 2 horas)</small>
                                </div>
                            </div>
                            <div class="col-sm-12 col-md-6 col-lg-4">
                                <div class="form-group">
                                    <label for="timeToGo">Expiraci&oacute;n del ticket de salida (Minutos)</label>
                                    <input type="number" min="0" max="1440" class="form-control" id="timeToGo" name="timeToGo" value="<?= @$configurations->timeToGo ?>">
                                    <small>Define el tiempo maximo en minutos que tendr&aacute; el usuario para salir del estacionamiento, una vez que su ticket se haya registrado en caja</small>
                                </div>
                            </div>
                            <div class="col-sm-12 col-md-6 col-lg-4">
                                <div class="form-group">
                                    <label for="verifyOnExit">Validaci&oacute;n del ticket de salida</label>
                                    <select class="select2 form-control" name="verifyOnExit" id="verifyOnExit" >
                                        <option value="1" <?=@$configurations->verifyOnExit == 1 ? "selected='selected' " : "" ?>>Activado</option>
                                        <option value="0" <?=@$configurations->verifyOnExit == 0 ? "selected='selected' " : "" ?>>Desactivado</option>
                                    </select>
                                    <small>Si esta activo, solo se puede utilizar el ticket de salida una sola vez, la proxima vez que se intente utilizar la barrera de salida no se abrir&aacute;</small>
                                </div>
                            </div>
		<div class="col-sm-12 col-md-6 col-lg-4">
                                <div class="form-group">
                                    <label for="verifyOnExit">Tiempo para salir sin pagar</label>
				    <input type="number" min="0" max="1440" class="form-control" id="toExitFree" name="toExitFree" value="<?= @$configurations->toExitFree ?>">
                                    <small>Define el tiempo maximo en minutos que tendr&aacute; el usuario para salir del estacionamiento sin pagar</small>
                                </div>
                            </div>


                        </div>
                        
                       

                    </div>
                    <!-- /.box-body -->

                    <div class="box-footer">
                        <button type="submit" class="btn btn-primary" id="sendConfig">Guardar</button>
                    </div>
                </form>
            </div>
            <!-- /.box -->

        </div>
        <!--/.col md-12 -->
     
    </div><!-- /.row -->
</section><!-- /.content -->
<script type="text/javascript">
    $(function() {

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
        $("#sendConfig").attr("disabled", "disabled");
        $("#sendConfig").val("Guardando..");
    }


</script>
