<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<style>
    .alert a {
        color: #fff;
        text-decoration: none;
    }
@media screen and (max-width: 640px) {
        #history-data-table {
                overflow-x: auto;
                display: block;
        }
}

</style>
<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>
        Historial
        <small>Aqui puede ver el historial de mensajes </small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Inicio</a></li>
        <li class="active">Historial</li>

    </ol>
</section>

<!-- Main content -->
<section class="content">
    <div class="row">
        <div class="col-md-12">
            <?php echo validation_errors("<div class='alert alert-danger'> <a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>", "</div>"); ?>
            <?php echo get_volatile_message("alert-danger"); ?>
            <div class="col-md-12">
                <form id="groupForm" action="<?= base_url() ?>admin.php/history/show" name="historyForm" method='POST' enctype="multipart/form-data" onsubmit="post_submit()">
                    <div class="box box-success">
                        <div class="box-header with-border">
                            <h4>Complete la casilla y podrá ver los últimos SMS intercambiados con ese contacto.</h4>
                        </div><!-- /.box-header -->
                        <div class="box-body">

                            <div class="form-group">
                                <label for="phoneNumber">Numero de Tel&eacute;fono</label>
                                <input type="text" required id="phoneNumber" class="form-control" name="phoneNumber" value="<?= set_value("phoneNumber") ?>">
                            </div>
                            <div class="form-group">
                                <input type="submit" id="showHistory" class="btn btn-md btn-primary" value="Mostrar" />
                            </div>

                            <?php
                            if (isset($history) && !empty($history)) {
                                ?>
                                <table class = "table-history table table-bordered table-hover" id="history-data-table">
                                    <thead>
                                        <tr>
                                            <th width = "15%">Enviado por</th>
                                            <th width = "60%">Mensaje</th>
                                            <th width = "25%">Fecha</th>

                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($history as $row) :
                                            ?>
                                            <tr>                    
                                                <td><?= $row->type == OUT ? "Usted" : $row->phoneNumber ?></td>
 <td><?= prepare_text($row) ?></td>
                                                <!--td><?= isset($row->messageInput) ? $row->messageInput : $row->messageText  ?></td-->
                                                <td><?= $row->registered ?></td>

                                            </tr>
                                        <?php endforeach; ?>              
                                    </tbody>

                                </table>
                                <?php
                            } else {
                                ?>
                                <div class="alert alert-warning"> <a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>No se encontro ningun resultado</div>
                                <?php
                            }
                            ?>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div><!-- /.row -->
</section><!-- /.content -->


<script>
    $(document).ready(function() {
        $('.table-history').dataTable({
            "paging": true,
            "lengthChange": false,
            "searching": true,
            "ordering": false,
            "info": true,
            "autoWidth": false,
        });
        /* end validate phonenumbers*/
<?php echo get_volatile_data(); ?>
<?php echo get_volatile_error(); ?>

    });

    function post_submit() {
        $("#showHistory").attr("disabled", "disabled");
        $("#showHistory").val("Buscando..");
    }

</script>


<?php

function prepare_text($data) {
    $text_field = "";
    if ($data->typeMessage == IMAGE) {
        $text_field .= "[<a href='".$data->imageInput."' target='_blank'>imagen</a>] ";
    } elseif ($data->typeMessage == VIDEO) {
        $text_field .= "[<a href='".$data->videoInput."' target='_blank'>video</a>] ";
    }
/*
    if (isset($data->messageInput) && !empty($data->messageInput)) {
        if (strlen($data->messageInput) > 38) {
            $text_field .= substr($data->messageInput, 0, 38) . "..";
        } else {
            $text_field .= substr($data->messageInput, 0, 38);
        }
    }
*/
 if (isset($data->messageInput) && !empty($data->messageInput)) {
         $text_field .= $data->messageInput;
 }
    return $text_field;
}
?>

