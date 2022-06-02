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
    0 => "Sin Costo",
    1 => "Fracci&oacute;n",
    2 => "Hora Completa",
    3 => "Dia",
    4 => "Mes"
)
?>
<section class="content-header">
  <h1>
    Listado de Actividades de usuario
    <small>Aqui se listan las acciones de todos los usuario dentro de la aplicacion</small>
  </h1>
  <ol class="breadcrumb">
    <li><a href="#"><i class="fa fa-dashboard"></i> Inicio</a></li>
    <li><a href="#">Auditoria</a></li>
    <li class="active">Listado de actividades</li>
  </ol>
</section>

<!-- Main content -->
<section class="content">
  <div class="row">
    <div class="col-xs-12">
        <form action="<?=base_url()?>admin.php/audits/show_list" method="post">
          <div class="box">
            <div class="box-header">
              
            </div><!-- /.box-header -->
            <div class="box-body">
                <div class='col-sm-12 col-md-12 col-lg-4'>
                    <div class="form-group">
                        <label for="name">Usuario:</label>
                        <select name="username" id="username" class="form-control select2">
                            <option value="">Seleccione un usuario</option>
                            <?php foreach($users as $user): ?>   
                            <option value="<?=$user->username?>" <?= ($user->username == @$filter->username) ? "selected" : "" ?>><?=$user->username?></option>
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
                        <label for="rateType">&nbsp;</label>
                         <input type="submit" class="form-control btn btn-primary" id="filter" name="filter" value="Filtrar">
                    </div>
                </div>
            </div>
          </div><!-- /.box -->     
        </form>
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
        "order": [ 0, 'desc' ],
        "dom": 'Bfrtip',
        "buttons": [
            'copy', 'csv', 'excel', 'pdf', 'print'
        ],
        "language": {
          "url": "//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/Spanish.json"
        }
            
    });

 //$(".date-mask").inputmask("dd/mm/yyyy", {"placeholder": "dd/mm/yyyy"});

  <?= get_volatile_warning() ?>
  <?= get_volatile_data() ?>
  <?= get_volatile_success() ?>
  <?= get_volatile_error() ?>

  });

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
