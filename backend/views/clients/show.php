<?php
defined('BASEPATH') or exit('No direct script access allowed');

?>

<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>
        Clientes
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
                <div class="alert alert-warning"> No se encontraron clientes para mostrar</div>
            <?php } else { ?>
                <!-- form start -->
                <form role="form" action="<?= base_url() ?>admin.php/clients/edit/<?= $client->id ?>" method='POST' enctype="multipart/form-data" onsubmit="post_submit()">

                    <!-- general form elements -->
                    <div class="box box-primary">
                        <div class="box-header with-border">
                            <h3 class="box-title">Datos Personales</h3>
                        </div>
                        <!-- /.box-header -->

                        <div class="box-body">
                            <div class="row">

                                <div class='col-sm-12 col-md-4 col-lg-4'>
                                    <div class="form-group">
                                        <label for="name">Nombre</label>
                                        <input type="text" class="form-control" id="name" name="name" value="<?= $client->name ?>">
                                    </div>
                                </div>
                                <div class='col-sm-12 col-md-4 col-lg-4'>
                                    <div class="form-group">
                                        <label for="email">Email</label>
                                        <input type="text" class="form-control" id="email" name="email" value="<?php echo $client->email ?>" placeholder="Email del cliente">
                                    </div>
                                </div>
                                <div class='col-sm-12 col-md-4 col-lg-4'>
                                    <div class="form-group">
                                        <label for="description">Descripci&oacute;n</label>
                                        <textarea class="form-control" id="description" name="description" placeholder="Algun comentario"><?php echo $client->description ?></textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class='col-sm-12 col-md-4 col-lg-4'>
                                    <div class="form-group">
                                        <label for="phone">Tel&eacute;fono</label>
                                        <input type="text" class="form-control" id="phone" name="phone" value="<?php echo $client->phone ?>" placeholder="Tel&eacute;fono del cliente">
                                    </div>
                                </div>
                                <div class='col-sm-12 col-md-4 col-lg-4'>
                                    <div class="form-group">
                                        <label for="clientType">Tipo de Cliente</label>
                                        <select class="form-control" required id="clientType" name="clientType" placeholder="Seleccione">
                                            <option value="1" <?= $client->clientType == 1 ? "selected" : "" ?>>Ocacional</option>
                                            <option value="2" <?= $client->clientType == 2 ? "selected" : "" ?>>Funcionario</option>
                                            <option value="3" <?= $client->clientType == 3 ? "selected" : "" ?>>Cliente Fiel</option>
                                            <option value="4" <?= $client->clientType == 4 ? "selected" : "" ?>>Mensual</option>

                                        </select>
                                    </div>
                                </div>

                            </div>
                        </div>
                        <!-- /.box-body -->

                        <div class="box-footer">

                        </div>

                    </div>
                    <!-- /.box -->

                    <div class="box box-success">
                        <div class="box-header with-border">
                            <h3 class="box-title">Tarifas y Caducidad</h3>
                        </div>
                        <div class="box-body">
                            <div class="row">
                                <div class='col-sm-12 col-md-4 col-lg-4'>
                                    <div class="form-group">
                                        <label for="name">Identificador de Tarjeta</label>
                                        <input type="text" class="form-control" required id="rfid" name="rfid" value="<?= $client->rfid ?>">
                                    </div>
                                </div>

                                <div class='col-sm-12 col-md-4 col-lg-4'>
                                    <div class="form-group">
                                        <label for="vehicleType">Tipo de Vehiculo</label>
                                        <select name="vehicleType" id="vehicleType" class="form-control">
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
                                        <select name="rate" id="rate" class="form-control">
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
                                        <select name="active" id="active" class="form-control">
                                            <option value="1" <?=$client->active == 1 ? "selected" : ""?>>Si</option>
                                            <option value="0" <?=$client->active == 0 ? "selected" : ""?>>No</option>
                                        </select>
                                    </div>
                                </div>
                                <div class='col-sm-12 col-md-4 col-lg-4'>
                                    <div class="form-group">
                                        <label for="dateTime">Fecha / Hora Caducidad de Tarjeta</label>
                                        <div class='input-group date' id='picker' onkeydown="return false">
                                            <span class="input-group-addon">
                                                <span class="glyphicon glyphicon-calendar"></span>
                                            </span>
                                            <?php
                                            $f = DateTime::createFromFormat('Y-m-d H:i:s', $client->expire);
                                            $expire = $f->format('d/m/Y H:i');
                                            ?>
                                            <input type='text' class="form-control" id="dateTime" name="dateTime" value="<?= $expire ?>" />

                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="box-footer">
                            <div class='col-sm-12 col-md-12 col-lg-12'>
                                <button type="submit" class="btn btn-primary" id="sendClient">Guardar</button>
                            </div>
                        </div>
                    </div>
                </form>
            <?php } ?>
        </div>
        <!--/.col md-12 -->

    </div><!-- /.row -->
</section><!-- /.content -->
<script type="text/javascript">
    function getFormattedDate(date) {
        var day = date.getDate();
        var month = date.getMonth() + 1;
        var year = date.getFullYear().toString().slice(2);
        return day + '-' + month + '-' + year;
    }
    $(function() {
        $.fn.datetimepicker.dates['en'] = {
            days: ["Domingo", "Lunes", "Martes", "Miercoles", "Jueves", "Viernes", "Sabado", "Domingo"],
            daysShort: ["Dom", "Lun", "Mar", "<Mie", "Jue", "Vie", "Sab", "Dom"],
            daysMin: ["Do", "Lu", "Ma", "Mi", "Ju", "Vi", "Sa", "Do"],
            months: ["Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre"],
            monthsShort: ["Ene", "Feb", "Mar", "Abr", "May", "Jun", "Jul", "Ago", "Sep", "Oct", "Nov", "Dic"],
            today: "Hoy",
            meridiem: "M"
        };
        $('#picker').datetimepicker({
            autoclose: true,
            locale: 'es',
            format: 'dd/mm/yyyy HH:mm',
            minDate: getFormattedDate(new Date()),
            pickerPosition: "top-right"
        });


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