<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<style>
    @media screen and (max-width: 640px) {
        #group-data-table {
            overflow-x: auto;
            display: block;
        }
    }
    
    .centered{
        text-align: center;
    }
</style>

<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>
        Listado de Grupos
        <small>Aqui puede ver la lista de todos los grupos creados</small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Inicio</a></li>
        <li class="active">Grupos</li>

    </ol>
</section>

<!-- Main content -->
<section class="content">
    <div class="row">
        <div class="col-md-12">
            <div class="box">
                <div class="box-header">
                    <h3>Grupos </h3>
                    <div class="form-group">
                        <a class="btn btn-primary btn-md" href="<?= base_url() ?>admin.php/groups/show_create">Crear Nuevo Grupo</a>
                    </div>
                    <table id="group-data-table" class="table table-bordered table-hover">
                        <thead>
                            <tr>
                                <th width="35%">Nombre</th>
                                <th width="15%">Registro</th>
                                <th width="15%" class='centered'>Borrar</th>
                                <th width="15%" class='centered'>Enviar SMS</th>
                                <th width="15%" class='centered'>Enviar Voz</th>

                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($groups as $row) : ?>
                                <tr>                    
                                    <td><a href="<?= base_url() . 'admin.php/groups/show_edit/' . $row->id ?>"><?= $row->groupName ?></a></td>
                                    <td><?= $row->registered ?></td>
                                    <td class="centered"><a onclick="show_delete('<?= $row->id ?>')" href="javascript::"><i class="fa fa-trash"></i></a></td>
                                    <td class="centered"><a href="<?= base_url() ?>admin.php/messages/show_create/<?= $row->id ?>"><i class="fa fa-send"></i></a></td>
                                    <td class="centered"><a href="<?= base_url() ?>admin.php/voice/show_create/<?= $row->id ?>"><i class="fa fa-phone"></i></a></td>

                                </tr>
                            <?php endforeach; ?>              
                        </tbody>

                    </table>
                    <!--<a href="#" class="btn btn-primary"><i class="fa fa-plus-square"></i>&nbsp;Crear Usuario</a>-->
                </div><!-- /.box-header -->
            </div>
        </div> <!-- /.col-md-12 -->
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
    $(function () {


<?= get_volatile_warning() ?>
<?= get_volatile_data() ?>
<?= get_volatile_success() ?>
<?= get_volatile_error() ?>

    });

    function show_delete(id) {
        var action = "Eliminar";
        var url = "<?= base_url() . 'admin.php/groups/delete/' ?>" + id;
        $("#alertInfo").modal("show");
        $("#alert-info-title").html("<i class='fa fa-warning fa-fw'></i> Atencion");
        $(".modal-body").html("<p>Esta siguro que desea " + action + " este Grupo?</p>");
        var modal_footer = '<button type="button" class="btn btn-defaul pull-left" data-dismiss="modal">Cancelar</button>';
        modal_footer += '<a href="' + url + '" class="btn btn-danger">Aceptar</a>';
        $(".modal-footer").html(modal_footer);
    }

</script>
