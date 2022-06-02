<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>

<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>
        Datos del Cliente
        <small>Version 2.0</small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Inicio</a></li>
        <li class="active">Clientes</li>
    </ol>
</section>

<!-- Main content -->
<section class="content">
    <div class="row">
        <!-- left column -->
        <div class="col-md-12 col-sm-12 col-xs-12">
            <?php if (!isset($client)) { ?>
                <div class="alert alert-warning"> Ocurrio un error, no se encontro el cliente</div>
            <?php } else { ?>

                <!-- general form elements -->
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title">Informacion del Cliente</h3>
                    </div>
                    <!-- /.box-header -->

                    <div class="box-body">
                        <div class="row">
                            <div class='col-sm-12 col-md-4 col-lg-4'>
                                <div class="form-group">
                                    <label for="name">Identificador de Tarjeta</label>
                                    <input type="text" class="form-control" disabled="disabled" id="rfid" name="rfid" value="<?= $client->rfid ?>">
                                </div>
                            </div>
                            <div class='col-sm-12 col-md-4 col-lg-4'>
                                <div class="form-group">
                                    <label for="name">Nombre</label>
                                    <input type="text" class="form-control" disabled="disabled" id="name" name="name" value="<?= $client->name ?>">
                                </div>
                            </div>
                            <div class='col-sm-12 col-md-4 col-lg-4'>
                                <div class="form-group">
                                    <label for="email">Email</label>
                                    <input type="text" class="form-control" disabled="disabled" id="email" name="email" value="<?php echo $client->email ?>" placeholder="Email del cliente">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class='col-sm-12 col-md-4 col-lg-4'>
                                <div class="form-group">
                                    <label for="phone">Tel&eacute;fono</label>
                                    <input type="text" class="form-control" disabled="disabled" id="phone" name="phone" value="<?php echo $client->phone ?>" placeholder="Tel&eacute;fono del cliente">
                                </div>
                            </div>
                            <div class='col-sm-12 col-md-4 col-lg-4'>
                                <div class="form-group">
                                    <label for="clientType">Tipo de Cliente</label>
                                    <select class="form-control" disabled="disabled" id="clientType" name="clientType" placeholder="Seleccione">
                                        <option value="1" <?= $client->clientType == 1 ? "selected" : "" ?>>Ocacional</option>
                                        <option value="2" <?= $client->clientType == 2 ? "selected" : "" ?>>Funcionario</option>
                                        <option value="3" <?= $client->clientType == 3 ? "selected" : "" ?>>Cliente Fiel</option>
                                        <option value="4" <?= $client->clientType == 4 ? "selected" : "" ?>>Mensual</option>

                                    </select>
                                </div>
                            </div>
                            <div class='col-sm-12 col-md-4 col-lg-4'>
                                <div class="form-group">
                                    <label for="description">Descripci&oacute;n</label>
                                    <textarea class="form-control" id="description" disabled="disabled" name="description" placeholder="Algun comentario"><?php echo $client->description ?></textarea>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class='col-sm-12 col-md-4 col-lg-4'>
                                <div class="form-group">
                                    <label for="vehicleType">Tipo de Vehiculo</label>
                                    <select name="vehicleType" id="vehicleType" disabled="disabled" class="form-control">
                                        <option value="">Seleccione una opcion</option>
                                        <?php foreach ($vehicles as $vehicle) { ?>
                                            <option value="<?= $vehicle->name ?>" <?= $vehicle->name == $client->vehicleType ? "selected" : "" ?>><?= $vehicle->name ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>
                            <div class='col-sm-12 col-md-4 col-lg-4'>
                                <div class="form-group">
                                    <label for="rate">Tarifa</label>
                                    <select name="rate" id="rate" disabled="disabled" class="form-control">
                                        <option value="">Primero seleccione un tipo de vehiculo</option>
                                        <?php foreach ($rates as $rate) { ?>
                                            <option value="<?= $rate->id ?>" <?= $rate->id == $client->rate ? "selected" : "" ?>><?= $rate->name ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>
                        </div>


                    </div>
                    <!-- /.box-body -->


                </div>

                <div class="box box-success">
                    <div class="box-header with-border">
                        <h3 class="box-title">Tarifas y Caducidad</h3>
                    </div>
                    <div class="box-body">
                        <div class="row">
                            <div class='col-sm-12 col-md-4 col-lg-4'>
                                <div class="form-group">
                                    <label for="name">Identificador de Tarjeta</label>
                                    <input type="text" class="form-control" required id="rfid" disabled name="rfid" value="<?= $client->rfid ?>">
                                </div>
                            </div>

                            <div class='col-sm-12 col-md-4 col-lg-4'>
                                <div class="form-group">
                                    <label for="vehicleType">Tipo de Vehiculo</label>
                                    <select name="vehicleType" id="vehicleType" disabled class="form-control">
                                        <option value="">Seleccione una opcion</option>
                                        <?php foreach ($vehicles as $vehicle) { ?>
                                            <option value="<?= $vehicle->name ?>" <?= $vehicle->name == $client->vehicleType ? "selected" : "" ?>><?= $vehicle->name ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>
                            <div class='col-sm-12 col-md-4 col-lg-4'>
                                <div class="form-group">
                                    <label for="rate">Tarifa</label>
                                    <select name="rate" id="rate" class="form-control" disabled>
                                        <option value="">Primero seleccione un tipo de vehiculo</option>
                                        <?php foreach ($rates as $rate) { ?>
                                            <option value="<?= $rate->id ?>" <?= $rate->id == $client->rate ? "selected" : "" ?>><?= $rate->name ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>
                            <div class='col-sm-12 col-md-4 col-lg-4'>
                                <div class="form-group">
                                    <label for="active">Tarjeta Activa</label>
                                    <select name="active" id="active" class="form-control" disabled>
                                        <option value="1" <?= $client->active == 1 ? "selected" : "" ?>>Si</option>
                                        <option value="0" <?= $client->active == 0 ? "selected" : "" ?>>No</option>
                                    </select>
                                </div>
                            </div>
                            <div class='col-sm-12 col-md-4 col-lg-4'>
                                <div class="form-group">
                                    <label for="dateTime">Fecha / Hora Caducidad de Tarjeta</label>
                                    <div class='input-group date' id='picker' onkeydown="return false" disabled>
                                        <span class="input-group-addon">
                                            <span class="glyphicon glyphicon-calendar"></span>
                                        </span>
                                        <?php
                                        $f = DateTime::createFromFormat('Y-m-d H:i:s', $client->expire);
                                        $expire = $f->format('d/m/Y H:i');
                                        ?>
                                        <input type='text' disabled class="form-control" id="dateTime" name="dateTime" value="<?= $expire ?>" />

                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="box-footer">
                        <div class='col-sm-12 col-md-12 col-lg-12'>
                            <a href='<?=base_url()?>admin.php/clients' class="btn btn-primary" >Volver</a>
                        </div>
                    </div>
                </div>
                <!-- /.box -->
            <?php } ?>
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
        $("#sendClient").attr("disabled", "disabled");
        $("#sendClient").val("Guardando..");
    }
</script>