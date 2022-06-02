<style>
@media screen and (max-width: 640px) {
        #reports-data-table {
                overflow-x: auto;
                display: block;
        }
}

th, td {
    white-space: nowrap;
}

</style>
<?php
$RATE_TYPE = array(
    -1 => "Extravio de Ticket",
    0 => "Sin Costo",
    1 => "Fraccion",
    2 => "Hora Completa",
    3 => "Dia",
    4 => "Mes"
    
);

$subtotal = 0;
$discount = 0;
$total = 0;
$arrayClients = array();
$arrayClients[0] = "Ocacional";
foreach($clients as $client){
    $arrayClients[$client->id] = $client->name;
}
?>
<section class="content-header">
  <h1>
    Reporte por Clientes
    <small>Puede obtener los reportes por cliente</small>
  </h1>
  <ol class="breadcrumb">
    <li><a href="#"><i class="fa fa-dashboard"></i> Inicio</a></li>
    <li><a href="#">Reportes</a></li>
    <li class="active">Reporte por cliente</li>
  </ol>
</section>

<!-- Main content -->
<section class="content">
  <div class="row">
    <div class="col-xs-12">
        <form action="<?=base_url()?>admin.php/reports/byClients" method="post">
            <div class="box">
                <div class="box-header">
                    Filtrar la busqueda
                </div><!-- /.box-header -->
                <div class="box-body">
                    <div class='col-sm-12 col-md-12 col-lg-4'>
                        <div class="form-group">
                            <label for="name">Cliente:</label>
                            <select name="clientId" id="clientId" class="form-control select2">
                                <option value="">Seleccione un cliente</option>
                                <?php foreach($clients as $client): ?>   
                                <option value="<?=$client->id?>" <?= ($client->id == @$filter->clientId) ? "selected" : "" ?>><?=$client->name?></option>
                                <?php endforeach; ?>
                            </select>
                            <!--input type="text" class="form-control" id="username" name="username" value="<?= isset($filter->username) ? $filter->username : "" ?>" placeholder="Nombre de usuario"-->
                        </div>
                    </div>
                    <div class='col-sm-12 col-md-12 col-lg-4'>
                        <div class="form-group">
                            <label for="name">Rango de Fechas:</label>
                            <div class="input-group">
                              <div class="input-group-addon">
                                <i class="fa fa-calendar"></i>
                              </div>
                              <input class="form-control" id="daterange" name="daterange" type="text" value="<?=@$filter->daterange?>" />
                            </div>
                            <!-- /.input group -->
                        </div>
    
                    </div>
                    <div class='col-sm-12 col-md-12 col-lg-4'>
                        <div class="form-group">
                            <label for="rateType">Tipo de Tarifa:</label>
                             <select name="rateType" id="rateType" class="form-control select2">
                                <option value="" "selected">Todos</option>
                                <?php foreach($RATE_TYPE  as $rateId => $rateValue): ?>   
                                <option value="<?=$rateId?>" <?= (isset($filter->rateType) && $rateId == $filter->rateType) ? "selected" : "" ?>><?=$rateValue?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                    <div class="col-sm-12 col-md-12 col-lg-12">
                        <input type="submit" class="form-control btn btn-primary" id="filter" name="filter" value="Filtrar">
                    </div>
                </div>
                <div class="box-footer">
                        <div class="col-lg-4 col-xs-12">
                            <div class="info-box bg-orange">
                                <span class="info-box-icon">Gs.</span>

                                <div class="info-box-content">
                                    <span class="info-box-text">Tarifado</span>
                                    <span class="info-box-number" style="font-size:36px" id="subtotal">0</span>
                                </div>
                                <!-- /.info-box-content -->
                            </div>
                            <!-- /.info-box -->
                        </div>
                        <div class="col-lg-4 col-xs-12">
                            <div class="info-box bg-yellow">
                                <span class="info-box-icon">Gs.</span>

                                <div class="info-box-content">
                                    <span class="info-box-text">Descuento</span>
                                    <span class="info-box-number" style="font-size:36px" id="discount">0</span>
                                </div>
                                <!-- /.info-box-content -->
                            </div>
                            <!-- /.info-box -->
                        </div>
                        <div class="col-lg-4 col-xs-12">
                            <div class="info-box bg-green">
                                <span class="info-box-icon">Gs.</span>

                                <div class="info-box-content">
                                    <span class="info-box-text">Total</span>
                                    <span class="info-box-number" style="font-size:36px" id="total">0</span>
                                </div>
                                <!-- /.info-box-content -->
                            </div>
                            <!-- /.info-box -->
                        </div>
                </div>
            </div>
        </form>
    </div>
    <div class="col-xs-12">
      <div class="box">
        <div class="box-header">
          
        </div><!-- /.box-header -->
        <div class="box-body">
          <?php if ($reports): ?>
            <table id="reports-data-table" class="table table-bordered table-hover" cellspacing="0" width="100%">
              <thead>
                <tr>

                  <th>Entrada</th>
                  <th>Salida</th>
                  <th>Usuario</th>
                  <th>Nombre Tarifa</th> 
                  <th>Comentarios</th>
                  <th>Total Calculado</th>
                  <th>Descuento</th>
                  <th>Otros Gastos</th>
                  <th>Total</th>
                    <th>Cliente</th>
                  <th>Imprimir</th>
                </tr>
              </thead>
              <tbody>
                <?php foreach ($reports as $report) : ?>
                  <tr>                    
                    <td><?= $report->in ?></td>
                    <td><?= $report->out ?></td>
                    <td><?= $report->username ?></td>
                    <td><?= $report->rateName ?></td>
                    <td><?= $report->comments ?></td>
                    <td style="text-align:right"><?= $report->totalCalculate ?></td>
                    <td style="text-align:right"><?= $report->discount ?></td>
                    <td style="text-align:right"><?= $report->otherPayments ?></td>
                    <td style="text-align:right"><?= $report->totalToPay ?></td>
                    <?php $subtotal += $report->totalCalculate; ?>
                     <td><?= @$arrayClients[$report->clientId] ?></td>
                    <?php $discount += $report->discount; ?>
                    <td><button type="button" onClick="printTicket('<?= $report->id ?>')" id="printTicket" class="btn btn-default btn-xs">Imprimir</button></td>
                  </tr>
                <?php endforeach; ?>        
                <?php $total += $subtotal - $discount?>
              </tbody>
              <tfoot>
                <tr class="pdf-include">
                  <th>Entrada</th>
                  <th>Salida</th>
                  <th>Usuario</th>
                  <th>Nombre Tarifa</th> 
                   <th>Comentarios</th>
                  
                  <th>Total Calculado</th>
                  <th>Descuento</th>
                  <th>Otros Gastos</th>
                  <th>Total</th>
                   <th>Cliente</th>
                  <th>Imprimir</th>
                </tr>
              </tfoot>
            </table>
          <?php else: ?>
            <div class="callout callout-warning">No se encontr&oacute; ning&uacute;n registro cargado</div>
          <?php endif; ?>
        </div><!-- /.box-body -->
      </div><!-- /.box -->     
    </div><!-- /.col -->
  </div><!-- /.row -->
</section><!-- /.content -->


<div class="example-modal">
  <div class="modal"  id="alertInfo">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title" id="alert-info-title"></h4>
        </div>
        <div class="modal-body">
        </div>
        <div class="modal-footer">           
        </div>
      </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
  </div><!-- /.modal -->
</div><!-- /.example-modal -->



<script type="text/javascript">
  $(function() {



    $("#username").select2();
    $("#rateType").select2();


        $('#daterange').daterangepicker({
          autoUpdateInput: false,
          timePicker: true,
          timePicker24Hour:true,
          timePickerSeconds:true,
          timePickerIncrement:1,
          
          locale: {
              cancelLabel: 'Cancelar',
              format: 'YYYY-MM-DD HH:mm:ss'
          }
        });
        
        $('#daterange').on('apply.daterangepicker', function(ev, picker) {
            $(this).val(picker.startDate.format('YYYY-MM-DD HH:mm:ss') + ' - ' + picker.endDate.format('YYYY-MM-DD HH:mm:ss'));
        });

        $('#daterange').on('cancel.daterangepicker', function(ev, picker) {
          $(this).val('');
        });
            

    $('#reports-data-table').dataTable({
        "sScrollX": true,
        "searching": true,
        "autoWidth":true,
        "order": [ 1, 'desc' ],
        "dom": 'Bfrtip',
        "buttons": [
            
            { extend: 'excelHtml5', footer: true },
            { extend: 'csvHtml5', footer: true },
             'print',
            { extend: 'pdfHtml5',
                orientation: 'landscape',
                pageSize: 'LEGAL',
                footer: true 
            }
        ],
        "language": {
          "url": "<?=base_url()?>public/backend/dist/lang/Spanish.json"
        },
        "footerCallback": function ( row, data, start, end, display ) {
            var api = this.api(), data;
 
            // Remove the formatting to get integer data for summation
            var intVal = function ( i ) {
                return typeof i === 'string' ?
                    i.replace(/[\$,]/g, '')*1 :
                    typeof i === 'number' ?
                        i : 0;
            };
 
            // Total over all pages
            total = api
                .column( 8 )
                .data()
                .reduce( function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0 );
            // Total over all pages
            subTotal = api
                .column( 5 )
                .data()
                .reduce( function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0 );
            subTotal = subTotal.toLocaleString('de-DE', { style: 'decimal', decimal: '0' })
            
            totalDiscount = api
                .column( 6)
                .data()
                .reduce( function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0 );        
            totalDiscount = totalDiscount.toLocaleString('de-DE', { style: 'decimal', decimal: '0' })
            
            //other
            otherPay = api
                .column(7)
                .data()
                .reduce( function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0 );        
            otherPay = otherPay.toLocaleString('de-DE', { style: 'decimal', decimal: '0' })
            
            // Total over this page
            pageTotal = api
                .column( 8, { page: 'current'} )
                .data()
                .reduce( function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0 );
 
            // Update footer
            total = total.toLocaleString('de-DE', { style: 'decimal', decimal: '0' })
            $( api.column( 8 ).footer() ).html(
              
                'Gs. '+ total
            );
            $( api.column( 5 ).footer() ).html(
              
                'Gs. '+ subTotal
            );
            $( api.column( 6 ).footer() ).html(
              
                'Gs. '+ totalDiscount
            );
             $( api.column( 7 ).footer() ).html(
              
                'Gs. '+ otherPay
            );
            $("#total").html(total);
            $("#discount").html(totalDiscount);
            $("#subtotal").html(subTotal);
            
        }
        
        
            
    });
    


    //Datemask dd/mm/yyyy
    $(".date-mask").inputmask("dd/mm/yyyy", {"placeholder": "dd/mm/yyyy"});
    // $(".date-mask").daterangepicker({timePicker: true});
  <?= get_volatile_warning() ?>
  <?= get_volatile_data() ?>
  <?= get_volatile_success() ?>
  <?= get_volatile_error() ?>

  });

	function printTicket(id) {
		var href = "<?=base_url()?>admin.php/main/printTicket/"+id;
		window.open(href,'_blank');
		//document.location.reload(true)
	}
	
  function show_delete(id) {
    var action = "Eliminar";
    var url = "<?= base_url() . 'admin.php/reports/delete/' ?>" + id;
    $("#alertInfo").modal("show");
    $("#alert-info-title").html("<i class='fa fa-warning fa-fw'></i> Atencion");
    $(".modal-body").html("<p>Esta siguro que desea " + action + " este Registro?</p>");
    var modal_footer = '<button type="button" class="btn btn-defaul pull-left" data-dismiss="modal">Cancelar</button>';
    modal_footer += '<a href="' + url + '" class="btn btn-danger">Aceptar</a>';
    $(".modal-footer").html(modal_footer);
  }

</script>
