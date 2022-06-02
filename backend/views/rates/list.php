<style>
@media screen and (max-width: 640px) {
        #profile-data-table {
                overflow-x: auto;
                display: block;
        }
}
</style>

<section class="content-header">
  <h1>
    Listado de Tarifas
    <small>Aqui se listan todas las tarifas, puede crear nuevas tarifas, editar, etc</small>
  </h1>
  <ol class="breadcrumb">
    <li><a href="#"><i class="fa fa-dashboard"></i> Inicio</a></li>
    <li><a href="#">Tarifas</a></li>
    <li class="active">Lista de Tarifas</li>
  </ol>
</section>

<!-- Main content -->
<section class="content">
  <div class="row">
    <div class="col-xs-12">
      <div class="box">
        <div class="box-header">
          <a href="<?= base_url() ?>admin.php/rates/new_rate" class="btn btn-primary"><i class="fa fa-plus-square"></i>&nbsp;Crear Nueva Tarifa</a>
        </div><!-- /.box-header -->
        <div class="box-body">
          <?php if ($rates): ?>
            <table id="rate-data-table" class="table table-bordered table-hover">
              <thead>
                <tr>
                  <th width="20%">Tipo de Vehiculo</th>
                  <th width="20%">Nombre</th>
                  <th width="10%">Importe</th>
                  <th width="30%">Descripcion</th>

                  <th class="align-center" width="20%">Acciones</th>
                </tr>
              </thead>
              <tbody>
                <?php foreach ($rates as $rate) : ?>
                  <tr>                    
                    <td><?= $rate->vehicleType ?></td>
                    <td><?= $rate->name ?></td>
                    <td><?= $rate->price ?> Gs.</td>
                    <td><?= $rate->description ?></td>

                    <td align='center'>
                      <a href="<?= base_url() ?>admin.php/rates/show_rate/<?= $rate->id ?>" class="btn btn-primary btn-xs">Editar</a>
                      <div onclick="show_delete('<?= $rate->id ?>')" class="btn btn-primary btn-xs">Borrar</div>
                     
                    </td>
                  </tr>
                <?php endforeach; ?>              
              </tbody>
              <tfoot>
                <tr>
                  <th width="20%">Tipo de Vehiculo</th>
                  <th width="20%">Nombre</th>
                  <th width="10%">Importe</th>
                  <th width="30%">Descripcion</th>
                  <th class="align-center" width="20%">Acciones</th>
                </tr>
              </tfoot>
            </table>
          <?php else: ?>
            <div class="callout callout-warning">No se encontr&oacute; ninguna Tarifa cargada</div>
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
    $('#rate-data-table').dataTable({
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

    //Flat red color scheme for iCheck
    $('input[type="checkbox"].flat-red, input[type="radio"].flat-red').iCheck({
      checkboxClass: 'icheckbox_flat-green',
      radioClass: 'iradio_flat-green'
    });


  <?= get_volatile_warning() ?>
  <?= get_volatile_data() ?>
  <?= get_volatile_success() ?>
  <?= get_volatile_error() ?>

  });

  function show_delete(id) {
    var action = "Eliminar";
    var url = "<?= base_url() . 'admin.php/rates/delete/' ?>" + id;
    $("#alertInfo").modal("show");
    $("#alert-info-title").html("<i class='fa fa-warning fa-fw'></i> Atencion");
    $(".modal-body").html("<p>Esta siguro que desea " + action + " este Usuario?</p>");
    var modal_footer = '<button type="button" class="btn btn-defaul pull-left" data-dismiss="modal">Cancelar</button>';
    modal_footer += '<a href="' + url + '" class="btn btn-danger">Aceptar</a>';
    $(".modal-footer").html(modal_footer);
  }

</script>
