<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>

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
        <div class="col-md-12">
            <!-- general form elements -->
            <form role="form" action="<?= base_url() ?>admin.php/clients/create" method='POST' enctype="multipart/form-data">
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title">Datos Personales</h3>
                    </div>
                    <!-- /.box-header -->
                    <!-- form start -->

                    <div class="box-body">
                        <div class="row">
                            <div class='col-sm-12 col-md-4 col-lg-4'>
                                <div class="form-group">
                                    <label for="name">Nombre</label>
                                    <input type="text" class="form-control" required id="name" name="name" value="<?php echo set_value('name'); ?>" placeholder="Nombre del cliente">
                                </div>
                            </div>
                            <div class='col-sm-12 col-md-4 col-lg-4'>
                                <div class="form-group">
                                    <label for="email">Email</label>
                                    <input type="text" class="form-control" id="email" name="email" value="<?php echo set_value('email'); ?>" placeholder="Email del cliente">
                                </div>
                            </div>
                            <div class='col-sm-12 col-md-4 col-lg-4'>
                                <div class="form-group">
                                    <label for="clientType">Tipo de Cliente</label>
                                    <select class="form-control" required id="clientType" name="clientType" placeholder="Seleccione">
                                        <option value="1" <?= set_select("clientType", 1, 1) ?>>Ocacional</option>
                                        <option value="2" <?= set_select("clientType", 2) ?>>Funcionario</option>
                                        <option value="3" <?= set_select("clientType", 3) ?>>Cliente Fiel</option>
                                        <option value="4" <?= set_select("clientType", 4) ?>>Mensual</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class='col-sm-12 col-md-4 col-lg-4'>
                                <div class="form-group">
                                    <label for="phone">Tel&eacute;fono</label>
                                    <input type="text" class="form-control" id="phone" name="phone" value="<?php echo set_value('phone'); ?>" placeholder="Tel&eacute;fono del cliente">
                                </div>
                            </div>


                            <div class='col-sm-12 col-md-4 col-lg-4'>
                                <div class="form-group">
                                    <label for="description">Descripci&oacute;n</label>
                                    <textarea class="form-control" id="description" name="description" placeholder="Algun comentario"><?php echo set_value('description'); ?></textarea>
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
                                    <label for="rfid">Identificador de Tarjeta</label>
                                    <input type="text" class="form-control" required id="rfid" name="rfid" value="<?php echo set_value('rfid'); ?>" placeholder="Identificador de la tarjeta">
                                </div>
                            </div>
                            <div class='col-sm-12 col-md-4 col-lg-4'>
                                <div class="form-group">
                                    <label for="vehicleType">Tipo de Vehiculo</label>
                                    <select name="vehicleType" id="vehicleType" class="form-control">
                                        <option value="">Seleccione una opcion</option>
                                        <?php foreach ($vehicles as $vehicle) { ?>
                                            <option value="<?= $vehicle->name ?>" <?= set_select("vehicleType", $vehicle->name) ?>><?= $vehicle->name ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>
                            <div class='col-sm-12 col-md-4 col-lg-4'>
                                <div class="form-group">
                                    <label for="rate">Tarifa</label>
                                    <select name="rate" id="rate" class="form-control">
                                        <option value="">Primero seleccione un tipo de vehiculo</option>
                                    </select>
                                </div>
                            </div>
                            <div class='col-sm-12 col-md-4 col-lg-4'>
                                <div class="form-group">
                                    <label for="active">Tarjeta Activa</label>
                                    <select name="active" id="active" class="form-control">
                                        <option value="1">Si</option>
                                        <option value="0">No</option>
                                    </select>
                                </div>
                            </div>
                            <div class='col-sm-12 col-md-4 col-lg-4'>
                                <div class="form-group">
                                    <label for="dateTime">Fecha / Hora Caducidad de Tarjeta</label>
                                    <div class='input-group date' id='picker' onkeydown="return false" >
                                        <span class="input-group-addon">
                                            <span class="glyphicon glyphicon-calendar"></span>
                                        </span>
                                        <input type='text' class="form-control" id="dateTime" name="dateTime" placeholder="<?=date('d/m/Y H:i')?>"/>

                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="box-footer">
                        <div class='col-sm-12 col-md-12 col-lg-12'>
                            <button type="submit" class="btn btn-primary">Guardar</button>
                        </div>
                    </div>
                </div>


            </form>
        </div>

    </div>
    <!--/.col md-12 -->


</section><!-- /.content -->

<script type="text/javascript">
function getFormattedDate(date) {
    var day = date.getDate();
    var month = date.getMonth() + 1;
    var year = date.getFullYear().toString().slice(2);
    return day + '-' + month + '-' + year;
}
    $(document).ready(function() {
        $.fn.datetimepicker.dates['en'] = {
            days: ["Domingo", "Lunes", "Martes", "Miercoles", "Jueves", "Viernes", "Sabado", "Domingo"],
            daysShort: ["Dom", "Lun", "Mar", "<Mie", "Jue", "Vie", "Sab", "Dom"],
            daysMin: ["Do", "Lu", "Ma", "Mi", "Ju", "Vi", "Sa", "Do"],
            months: ["Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre"],
            monthsShort: ["Ene", "Feb", "Mar", "Abr", "May", "Jun", "Jul", "Ago", "Sep", "Oct", "Nov", "Dic"],
            today: "Hoy",
            meridiem : "M"
        };
        $('#picker').datetimepicker({
            autoclose: true,
            locale: 'es',

            //dateFormat: 'DD/MM/YYYY',
            //timeFormat: 'HHMM',
            format:'dd/mm/yyyy HH:mm',
            minDate: getFormattedDate(new Date()),
            pickerPosition: "top-right"
        });

        $("body").on("change dp.change", "#picker", function(event) {
            var date = $("#picker").data("datetimepicker").getDate();
            console.log(date);
            var hours = date.getHours();
            var minutes = date.getMinutes();
            var day = date.getDate();
            var month = date.getMonth() + 1;
            var year = date.getFullYear();
            var demoTicketId =  year +"-"+ (month < 10 ? "0" + month : month) +"-"+ (day < 10 ? "0" + day : day) + ' ' + (hours < 10 ? "0" + hours : hours) + ':' + (minutes < 10 ? "0" + minutes : minutes) + ':00';
            console.log(demoTicketId);
            $("#expire").val(demoTicketId);

        })

        $("#vehicleType").change(function() {
            if ($("#missedTicket").is(":checked") == false) {
                var vehicleType = $("#vehicleType").val();
                fill_with_rate("rate", vehicleType);
            }
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
</script>