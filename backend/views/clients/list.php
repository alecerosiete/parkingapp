<?php
    $tipo_cliente = array(1 => "Ocacional",2 => "Funcionario", 3 => "Cliente Fiel", 4 => "Mensual"	 );
?>
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
    Listado de Clientes
    <small>Aqui se listan todos los clientes, puede crear, editar, etc</small>
  </h1>
  <ol class="breadcrumb">
    <li><a href="#"><i class="fa fa-dashboard"></i> Inicio</a></li>
    <li><a href="#">Clientes</a></li>
    <li class="active">Lista de Clientes</li>
  </ol>
</section>

<!-- Main content -->
<section class="content">
  <div class="row">
    <div class="col-xs-12">
      <div class="box">
        <div class="box-header">
          <a href="<?= base_url() ?>admin.php/clients/new_client" class="btn btn-primary"><i class="fa fa-plus-square"></i>&nbsp;Crear Nuevo Cliente</a>
        </div><!-- /.box-header -->
        <div class="box-body">
          <?php if ($clients): ?>
            <table id="rate-data-table" class="table table-bordered table-hover">
              <thead>
                <tr>
                  <th width="40%">Nombre</th>
                  <th width="10%">Email</th>
                  <th width="10%">Tel&eacute;fono</th>
                  <th width="10%">Tipo</th>
                  <th width="13%">Registrado</th>
                  <th class="align-center" width="17%">Acciones</th>
                </tr>
              </thead>
              <tbody>
                <?php foreach ($clients as $client) : ?>
                  <tr>                    
                    <td><?= $client->name ?></td>
                    <td><?= $client->email ?></td>
                    <td><?= $client->phone ?></td>
                    <td><?= $tipo_cliente[$client->clientType] ?></td>
                    <td><?= $client->registered ?></td>
                    <td align='center'>
                      <a href="<?= base_url() ?>admin.php/clients/show/<?= $client->id ?>" class="btn btn-primary btn-xs">Editar</a>
                      <div onclick="show_delete('<?= $client->id ?>')" class="btn btn-primary btn-xs">Borrar</div>
                      <a href="<?= base_url() ?>admin.php/clients/detail/<?= $client->id ?>" class="btn btn-primary btn-xs">Detalles</a>
                    </td>
                  </tr>
                <?php endforeach; ?>              
              </tbody>
              <tfoot>
                <tr>
                  <th width="40%">Nombre</th>
                  <th width="10%">Email</th>
                  <th width="10%">Tel&eacute;fono</th>
                  <th width="10%">Tipo</th>
                  <th width="13%">Registrado</th>
                  <th class="align-center" width="17%">Acciones</th>
                </tr>
              </tfoot>
            </table>
          <?php else: ?>
            <div class="callout callout-warning">No se encontr&oacute; ning&uacute;n cliente cargado</div>
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
    var url = "<?= base_url() . 'admin.php/clients/delete/' ?>" + id;
    $("#alertInfo").modal("show");
    $("#alert-info-title").html("<i class='fa fa-warning fa-fw'></i> Atencion");
    $(".modal-body").html("<p>Esta siguro que desea " + action + " este Cliente?</p>");
    var modal_footer = '<button type="button" class="btn btn-defaul pull-left" data-dismiss="modal">Cancelar</button>';
    modal_footer += '<a href="' + url + '" class="btn btn-danger">Aceptar</a>';
    $(".modal-footer").html(modal_footer);
  }

</script>
