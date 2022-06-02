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
    1 => "Fracción",
    2 => "Hora Completa",
    3 => "Dia",
    4 => "Mes"
)
?>
<section class="content-header">
  <h1>
    Reporte de Salida
    <small>Aqui se listan todos las salidas procesadas</small>
  </h1>
  <ol class="breadcrumb">
    <li><a href="#"><i class="fa fa-dashboard"></i> Inicio</a></li>
    <li><a href="#">Reportes</a></li>
    <li class="active">Listado de salidas</li>
  </ol>
</section>

<!-- Main content -->
<section class="content">
  <div class="row">
    <div class="col-xs-12">
      <div class="box">
        <div class="box-header">
          
        </div><!-- /.box-header -->
        <div class="box-body">
          <?php if ($reports): ?>
            <table id="reports-data-table" class="table table-bordered table-hover" cellspacing="0" width="100%">
              <thead>
                <tr>
                  <th>Usuario</th>
                  <th>Entrada</th>
                  <th>Salida</th>
                  <th>Vehiculo</th>
                  <th>Nombre Tarifa</th>
                  <th>Costo Tarifa</th>
                  <th>Tipo Tarifa</th>
                  <th>Descripci&oacute;n Tarifa</th>
                  <th>Comentarios</th>
                  <th>Total Calculado</th>
                  <th>Descuento</th>
                  <th>Otros Gastos</th>
                  <th>Total</th>
                  <th class="align-center">Acciones</th>
                </tr>
              </thead>
              <tbody>
                <?php foreach ($reports as $report) : ?>
                  <tr>                    
                    <td><?= $report->username ?></td>
                    <td><?= $report->in ?></td>
                    <td><?= $report->out ?></td>
                    <td><?= $report->vehicleType ?></td>
                    <td><?= $report->rateName ?></td>
                    <td><?= $report->ratePrice ?></td>
                    <td><?= $RATE_TYPE[$report->rateType] ?></td>
                    <td><?= $report->rateDescription ?></td>
                     <td><?= $report->comments ?></td>
                    <td><?= $report->totalCalculate ?></td>
                    <td style="text-align:right"><?= $report->discount ?></td>
                    <td><?= $report->otherPayments ?></td>
                    <td><?= $report->totalToPay ?></td>
                    <td align='center'>
                      <div onclick="show_delete('<?= $report->id ?>')" class="btn btn-primary btn-xs">Borrar</div>
                      <button type="button" onClick="printTicket('<?= $report->id ?>')" id="printTicket" class="btn btn-default btn-xs">Imprimir</button>
                    </td>
                  </tr>
                <?php endforeach; ?>              
              </tbody>
              <tfoot>
                <tr>
                  <th>Usuario</th>
                  <th>Entrada</th>
                  <th>Salida</th>
                  <th>Vehiculo</th>
                  <th>Nombre Tarifa</th>
                  <th>Costo Tarifa</th>
                  <th>Tipo Tarifa</th>
                  <th>Descripci&oacute;n Tarifa</th>
                  <th>Comentarios</th>
                  <th>Total Calculado</th>
                  <th>Descuento</th>
                  <th>Otros Gastos</th>
                  <th>Total</th>
                  <th class="align-center">Acciones</th>
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
    $('#reports-data-table').dataTable({
        "sScrollX": true,
        "searching": true,
        "autoWidth":true,
        "order": [ 2, 'desc' ],
        "dom": 'Bfrtip',
        "buttons": [
            'copy', 'csv', 'excel',  'print',{
             extend: 'pdfHtml5',
                orientation: 'landscape',
                pageSize: 'LEGAL'
            }
        ],
        "language": {
          "url": "<?=base_url()?>public/backend/dist/lang/Spanish.json"
        },"footerCallback": function ( row, data, start, end, display ) {
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
                .column( 12 )
                .data()
                .reduce( function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0 );
            // Total over all pages
            subTotal = api
                .column( 9 )
                .data()
                .reduce( function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0 );
            subTotal = subTotal.toLocaleString('de-DE', { style: 'decimal', decimal: '0' })
            
            totalDiscount = api
                .column( 10)
                .data()
                .reduce( function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0 );        
            totalDiscount = totalDiscount.toLocaleString('de-DE', { style: 'decimal', decimal: '0' })
            
            //other
            otherPay = api
                .column(11)
                .data()
                .reduce( function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0 );        
            otherPay = otherPay.toLocaleString('de-DE', { style: 'decimal', decimal: '0' })
            
            // Total over this page
            pageTotal = api
                .column( 12, { page: 'current'} )
                .data()
                .reduce( function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0 );
 
            // Update footer
            total = total.toLocaleString('de-DE', { style: 'decimal', decimal: '0' })
            $( api.column( 12 ).footer() ).html(
              
                'Gs. '+ total
            );
            $( api.column(9 ).footer() ).html(
              
                'Gs. '+ subTotal
            );
            $( api.column( 10).footer() ).html(
              
                'Gs. '+ totalDiscount
            );
             $( api.column( 11 ).footer() ).html(
              
                'Gs. '+ otherPay
            );
            $("#total").html(total);
            $("#discount").html(totalDiscount);
            $("#subtotal").html(subTotal);
            
        }
            
    });



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
