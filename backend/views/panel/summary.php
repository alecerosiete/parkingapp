<?php
$te = 0;
$ts = 0;
$t = 0;
?>
<section class="content-header">
    <h1>
        Panel de Resumen
        <small>Informacion de movimiento de entrada y saldia de vehiculos</small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="<?=base_url()?>"><i class="fa fa-dashboard"></i> Inicio</a></li>
        <li><a href="#">Panel</a></li>
        <li class="active">Movimiento de vehiculos</li>
    </ol>
</section>
<section class="content">
    <h2>
        Hoy
    </h2>

    <div class="row">
        <div class="col-md-4 col-sm-4 col-xs-12">
            <div class="info-box">
                <span class="info-box-icon bg-aqua"><i class="fa fa-arrow-circle-up "></i></span>
                <div class="info-box-content">
                    <span class="info-box-text">Entrada</span>
                    <span class="info-box-number"><?=$hoy['entrada']?><small> Vehiculos</small></span>
                </div>

            </div>

        </div>

        <div class="col-md-4 col-sm-4 col-xs-12">
            <div class="info-box">
                <span class="info-box-icon bg-red"><i class="fa fa-arrow-circle-down"></i></span>
                <div class="info-box-content">
                    <span class="info-box-text">Salida</span>
                    <span class="info-box-number"><?=$hoy['salida']?><small> Vehiculos</small></span>
                </div>

            </div>

        </div>


        <div class="clearfix visible-sm-block"></div>
        <div class="col-md-4 col-sm-4 col-xs-12">
            <div class="info-box">
                <span class="info-box-icon bg-green"><i class="fa fa-car"></i></span>
                <div class="info-box-content">
                    <span class="info-box-text">En el estacionamiento</span>
                    <span class="info-box-number"><?=$hoy['dentro']?><small> Vehiculos</small></span>
                </div>

            </div>

        </div>



    </div>
</section>

<section class="content">
    <h2>
        Entradas y salidas de vehiculos por totem
    </h2>
    <div class="row">
        <div class="col-md-12">

            <div class="box">
                <form id="filter-form" action="<?=base_url()?>admin.php/panel/" method="post">
                    <div class="box">
                        <div class="box-body">
                            <div class='col-sm-12 col-md-4 col-lg-4'>
                                <div class="form-group">
                                    <label for="name">Rango de Fechas:</label>
                                    <div class="input-group">
                                        <div class="input-group-addon">
                                            <i class="fa fa-calendar"></i>
                                        </div>
                                        <input class="form-control" id="daterange" name="daterange" type="text"
                                            value="<?=@$filter?>" />
                                        <div class="input-group-addon ">
                                            <a href="#" id="filter" ><i class="fa fa-send"></i> Filtrar</a>
                                        </div>
                                    </div>
                                    <!-- /.input group -->
                                </div>
                            </div>
                        </div>

                    </div>
                </form>


                <div class="box-body">
                    <?php if ($summary): ?>
                    <table class="table table-bordered table-hover table-striped">
                        <thead>
                            <tr>
                                <th class="text-center" width="25%">Totem</th>
                                <th class="text-center" width="25%">Entrada</th>
                                <th class="text-center" width="25%">Salida</th>
                                <th class="text-center" width="25%">Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($summary as $row) : ?>
                            <tr>
                                <td class="text-center"><?=$row->totemId?></td>
                                <td class="text-center"><?=$row->TOTEMTYPE_I?></td>
                                <td class="text-center"><?=$row->TOTEMTYPE_O?></td>
                                <td class="text-center"><?=$row->cant?></td>
                            </tr>
                            <?php $te = $te +  $row->TOTEMTYPE_I?>
                            <?php $ts = $ts +  $row->TOTEMTYPE_O?>
                            <?php $t = $t +  $row->cant?>

                            <?php endforeach; ?>
                        </tbody>
                        <tfoot>
                            <tr>
                                <th class="text-center" width="25%">TOTAL</th>
                                <th class="text-center" width="25%"><?=$te?></th>
                                <th class="text-center" width="25%"><?=$ts?></th>
                                <th class="text-center" width="25%"><?=$t?></th>
                            </tr>
                        </tfoot>
                    </table>
                    <?php else: ?>
                    <div class="callout callout-warning">No se encontr&oacute; ninguna Tarifa cargada</div>
                    <?php endif; ?>

                </div>

                <div class="box-footer">
                    <div class="row">

                    </div>

                </div>

            </div>
        </div>
    </div>
</section>


<script type="text/javascript">
$(function() {
    $("#filter").click(function(e){
        e.preventDefault();
        console.log("enviar form...");
        $("#filter-form").submit();
    });
    $('#panel-data-table').dataTable({
        "bPaginate": true,
        "bLengthChange": true,
        "bFilter": true,
        "bSort": true,
        "bInfo": true,
        "bAutoWidth": true,
        "language": {
            "url": "//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/Spanish.json"
        }
    });

    $('#daterange').daterangepicker({
        autoUpdateInput: false,
        timePicker: false,
        timePicker24Hour: true,
        timePickerSeconds: true,
        timePickerIncrement: 1,
        startDate: moment().subtract(29, 'days'),
        endDate: moment(),
        
        "locale": {
            "format": 'DD/MM/YYYY',
            "separator": " - ",
            "applyLabel": "Aplicar",
            "cancelLabel": 'Cancelar',
            "fromLabel": "Desde",
            "toLabel": "Hasta",
            "customRangeLabel": "Personalizar",
            "daysOfWeek": [
                "Do",
                "Lu",
                "Ma",
                "Mi",
                "Ju",
                "vi",
                "Sa"
            ],
            "monthNames": [
                "Enero",
                "Febrero",
                "Marzo",
                "Abril",
                "Mayo",
                "Junio",
                "Julio",
                "Agosto",
                "Septiembre",
                "Octubre",
                "Noviembre",
                "Diciembre"
            ],
            "firstDay": 1
        }
    });

    $('#daterange').on('apply.daterangepicker', function(ev, picker) {
        $(this).val(picker.startDate.format('DD/MM/YYYY') + ' - ' + picker.endDate.format(
        'DD/MM/YYYY'));
    });

    $('#daterange').on('cancel.daterangepicker', function(ev, picker) {
        $(this).val('');
    });
});
</script>