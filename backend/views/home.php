<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>

<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>
        Salida
        <small>Ingresar el codigo de barras y completar las opciones para procesar el importe a abonar</small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Inicio</a></li>
        <li class="active">Salida</li>
    </ol>
</section>

<!-- Main content -->
<section class="content">
    <div class="row">
        <div class="col-md-12">
            <!-- general form elements -->
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title">Dar Salida</h3>
                </div>
                <!-- /.box-header -->
                <!-- form start -->
                <form role="form" action="<?= base_url() ?>admin.php/main/exit" method='POST' enctype="multipart/form-data">
                    <div class="box-body">
                        <div class="row">
                            <div class='col-sm-12 col-md-12 col-lg-<?= check_role(ROLE_ADMIN) ? "6" : "8" ?>'>
                                <div class="form-group">
                                    <label for="ticketId">Identificador</label>
                                    <input type="text" class="form-control input-lg" required id="ticketId" name="ticketId" value="<?php echo set_value('ticketId'); ?>" placeholder="Ingrese codigo de barras">
                                </div>
                            </div>
                            <?php if (check_role(ROLE_ADMIN)) : ?>
                                <div class='col-sm-12 col-md-12 col-lg-2'>
                                    <div class="form-group">
                                        <label for="fechaHora">Fecha / Hora</label>
                                        <div class='input-group date' id='picker'>
                                            <input type='text' class="form-control" id="fechaHora" name="fechaHora" />
                                            <span class="input-group-addon">
                                                <span class="glyphicon glyphicon-calendar"></span>
                                            </span>
                                        </div>

                                        <!--input type="text" class="form-control input-lg" required id="fechaHora" name="fechaHora" value="<?php echo set_value('fechaHora'); ?>" placeholder="DD/MM/AAAA"-->
                                    </div>
                                </div>
                            <?php endif; ?>
                            <div class='col-sm-12 col-md-12 col-lg-4'>
                                <div class="form-group">
                                    <label>Extravio de Ticket </label>
                                    <label for="missedTicket" style="font-weight:100">
                                        <input type="checkbox" class="flat-red" id="missedTicket" name="missedTicket" value="0" <?= set_checkbox("missedTicket", 1) ?>>
                                        En caso que el cliente extravie su ticket puede marcar esta opcion y seleccionar el vehiculo para procesar el cobro
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="row">
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
                                    <label for="client">Cliente</label>
                                    <select name="client" id="client" class="form-control">
                                        <option value="">Seleccione un cliente</option>
                                        <?php foreach ($clients as $client) { ?>
                                            <option value="<?= $client->id ?>" <?= set_select("client", $client->id) ?>><?= $client->name ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>
                            <div class='col-sm-12 col-md-4 col-lg-4'>
                                <div class="form-group">
                                    <label for="discount">Descuento (Gs.)</label>
                                    <input type="text" class="form-control" id="discount" name="discount" value="<?php echo set_value('discount'); ?>" placeholder="Monto del descuento">

                                </div>
                            </div>
                            <div class='col-sm-12 col-md-4 col-lg-4'>
                                <div class="form-group">
                                    <label for="otherPayments">Otros Gastos (Gs.)</label>
                                    <input type="text" class="form-control" id="otherPayments" name="otherPayments" value="<?php echo set_value('otherPayments'); ?>" placeholder="Otros Gastos">

                                </div>
                            </div>
                            <div class='col-sm-12 col-md-4 col-lg-4'>
                                <div class="form-group">
                                    <label>Comentarios</label>
                                    <textarea name="comments" id="comments" class="form-control" rows="4" placeholder="Ingrese aqui cualquier comentario adicional"></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- /.box-body -->
                    <div class="box-footer">
                        <div class='col-sm-12 col-md-12 col-lg-12'>
                            <div class="btn btn-primary" id="process">Procesar</div>
                            <!--<button type="submit" class="btn btn-primary">Procesar Importe</button>-->
                        </div>
                    </div>
                </form>
            </div>
            <!-- /.box -->
        </div>
    </div><!-- /.row -->
</section><!-- /.content -->



<div class="detail-modal">
    <div class="modal" id="detail" data-backdrop="static" data-keyboard="false" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content" id="detail-modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Confirmar Salida</h4>
                </div>
                <div class="modal-body" id="detail-modal-body">
                    <div class="row">
                        <div class="col-lg-6 col-xs-6">
                            <div class="info-box bg-aqua">
                                <span class="info-box-icon"><i class="fa fa-calendar"></i></span>

                                <div class="info-box-content">
                                    <span class="info-box-text">Entrada</span>
                                    <span class="info-box-number" id="in"></span>
                                </div>
                                <!-- /.info-box-content -->
                            </div>
                            <!-- /.info-box -->
                        </div>
                        <div class="col-lg-6 col-xs-6">
                            <div class="info-box bg-aqua">
                                <span class="info-box-icon"><i class="fa fa-calendar"></i></span>

                                <div class="info-box-content">
                                    <span class="info-box-text">Salida</span>
                                    <span class="info-box-number" id="out"></span>
                                </div>
                                <!-- /.info-box-content -->
                            </div>
                            <!-- /.info-box -->
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-4 col-xs-12">
                            <div class="info-box bg-orange">
                                <span class="info-box-icon"><i class="fa fa-clock-o"></i></span>

                                <div class="info-box-content">
                                    <span class="info-box-text">Dias</span>
                                    <span class="info-box-number" style="font-size:36px" id="days">00</span>
                                </div>
                                <!-- /.info-box-content -->
                            </div>
                            <!-- /.info-box -->
                        </div>
                        <div class="col-lg-4 col-xs-12">
                            <div class="info-box bg-green-gradient">
                                <span class="info-box-icon"><i class="fa fa-clock-o"></i></span>

                                <div class="info-box-content">
                                    <span class="info-box-text">Horas</span>
                                    <span class="info-box-number" style="font-size:36px" id="hours">00</span>
                                </div>
                                <!-- /.info-box-content -->
                            </div>
                            <!-- /.info-box -->
                        </div>
                        <div class="col-lg-4 col-xs-12">
                            <div class="info-box bg-yellow-gradient">
                                <span class="info-box-icon"><i class="fa fa-clock-o"></i></span>

                                <div class="info-box-content">
                                    <span class="info-box-text">Minutos</span>
                                    <span class="info-box-number" style="font-size:36px" id="minutes">00</span>
                                </div>
                                <!-- /.info-box-content -->
                            </div>
                            <!-- /.info-box -->
                        </div>
                    </div>

                    <div class="row">
                        <div class='col-sm-12 col-md-12 col-lg-12'>
                            <div class="info-box bg-aqua-gradient">
                                <span class="info-box-icon"><strong>Gs</strong></span>

                                <div class="info-box-content">
                                    <span class="info-box-text">Total a Abonar</span>
                                    <span class="info-box-number" style="font-size:35px" id="amount">0</span>
                                </div>
                                <!-- /.info-box-content -->
                            </div>
                            <!-- /.info-box -->
                        </div>
                    </div>
                </div>
                <div class="modal-footer">

                    <button type="button" class="btn btn-success pull-rigth" id="onConfirm" data-dismiss="modal">Confirmar</button>
                    <button type="button" onClick="openWindowReload(this)" class="btn btn-default pull-rigth">Imprimir</button>
                    <?php if (check_role(ROLE_ADMIN)) : ?>
                        <button type="button" class="btn btn-danger pull-left" id="onCancel" data-dismiss="modal">Anular</button>
                    <?php endif; ?>
                    <input type="hidden" name="insertId" value="" id="insertId">

                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
    <!-- /.modal -->
</div>
<!-- /.example-modal -->




<script type="text/javascript">
    function openWindowReload() {
        var href = "<?= base_url() ?>admin.php/main/printTicket/" + $("#insertId").val();

        window.open(href, '_blank');
        document.location.reload(true)
    }

    $(document).ready(function() {


        $('#picker').datetimepicker({
            autoclose: true,
            locale: 'es',
            dateFormat: 'YYYYMMDD',
            timeFormat: 'HHMM'

        });

        $("body").on("change dp.change", "#picker", function(event) {
            var date = $("#picker").data("datetimepicker").getDate();
            console.log($("#picker").val());
            var hours = date.getHours();
            var minutes = date.getMinutes();
            var day = date.getDate();
            var month = date.getMonth() + 1;
            var year = date.getFullYear();
            var demoTicketId = '00' + year + (month < 10 ? "0" + month : month) + (day < 10 ? "0" + day : day) + '' + (hours < 10 ? "0" + hours : hours) + '' + (minutes < 10 ? "0" + minutes : minutes) + '00';
            console.log(demoTicketId);
            $("#ticketId").val(demoTicketId);

        })


        $("#missedTicket").on('ifChanged', function(event) {
            if ($("#missedTicket").is(":checked") == true) {
                $("#missedTicket").val(1);
                $('select,input[type="text"]').prop("disabled", true);
                $('select,input[type="text"]').prop("required", false);
                $('#rate').html("<option value=''>Seleccione</option>");
                $('#vehicleType').prop("disabled", false);
                //$("#comments").prop("required",true);
                $("#vehicleType").prop("required", true);


            } else {
                $("#missedTicket").val(0);
                $('select,input[type="text"]').prop("disabled", false);
                $("#comments").prop("required", false);
                $("#vehicleType").prop("required", false);
            }
        });


        $("#vehicleType").change(function() {
            if ($("#missedTicket").is(":checked") == false) {
                var vehicleType = $("#vehicleType").val();
                fill_with_rate("rate", vehicleType);
            }
        });

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

        $("#process").click(function() {
            var ticketId = $("#ticketId").val();
            var missedTicket = $("#missedTicket").val();
            var vehicleType = $("#vehicleType").val();
            var rateId = $("#rate").val();
            var comments = $("#comments").val();
            var clientId = $("#client").val();
            var discount = $("#discount").val();
            var otherPayments = $("#otherPayments").val();
            console.log("Discount: " + discount);
            console.log("otherPayments: " + otherPayments);
            console.log("comments: " + comments);
            console.log("comments: " + clientId);
            var showError = "";
            if (ticketId == "" && $("#missedTicket").is(":checked") == false) {
                showError = "Ingrese el codigo de Barras del ticket";
            } else if (vehicleType == "") {
                showError = "Seleccione el tipo de Vehiculo a procesar";
            } else if (rateId == "" && $("#missedTicket").is(":checked") == false) {
                showError = "No se encontro ninguna tarifa para este vehiculo";
            } else if (comments == "" && $("#missedTicket").is(":checked") == true) {
                showError = "Ingrese algun texto como comentario";
            } else if (comments == "" && (discount > 0 || otherPayments > 0)) {
                showError = "Ingrese algun texto como comentario";
            }

            if (showError) {
                $.notify({
                    icon: 'glyphicon glyphicon-alert',
                    message: showError
                }, {
                    type: 'error',
                    mouse_over: 'pause',
                    delay: 7000,
                    animate: {
                        enter: 'animated shake',
                        exit: 'animated fadeOutUp'
                    }

                });
                return false;
            }

            var params = {
                ticketId: ticketId,
                missedTicket: missedTicket,
                vehicleType: vehicleType,
                rateId: rateId,
                clientId: clientId,
                comments: comments,
                discount: discount,
                otherPayments: otherPayments
            };

            fill_with_params("detail-modal-body", params);

        });

        var onresult = function(result) {
            showConfirmMessage(result);
        };

        $("#onCancel").click(function() {
            var params = {
                ticketId: $("#insertId").val()
            };
            $.ajax({
                url: '/admin.php/json_finder/cancel',
                type: 'POST',
                data: params,
                dataType: "json"
            }).done(onresult);
        });


        $("#onConfirm").click(function() {
            $.notify({
                icon: 'glyphicon glyphicon-alert',
                message: "Procesado con exito"
            }, {
                type: 'success',
                mouse_over: 'pause',
                delay: 7000,
                animate: {
                    enter: 'animated shake',
                    exit: 'animated fadeOutUp'
                }

            });

            $(location).attr('href', '/admin.php')
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

        <?php
        //echo  $this->session->flashdata('volatile_data_message');
        $this->session->set_flashdata("volatile_data_info", "");
        ?>

        <?= get_volatile_warning() ?>
        <?= get_volatile_data() ?>
        <?= get_volatile_success() ?>
        <?= get_volatile_error() ?>

    });

    function showConfirmMessage(result) {
        var html = "";

        if (result['error'].length > 0) {
            $.notify({
                icon: 'glyphicon glyphicon-alert',
                message: result['error']
            }, {
                type: 'success',
                mouse_over: 'pause',
                delay: 7000,
                animate: {
                    enter: 'animated shake',
                    exit: 'animated fadeOutUp'
                }

            });
            //return false;
        }
        $(location).attr('href', '/admin.php')
    }
</script>