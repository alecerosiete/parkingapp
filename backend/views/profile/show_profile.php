<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<?php
$avatar_src = null;
if ($profileData->avatar) {
    $avatar_src = "<img src=" . $profileData->avatar . " class='file-preview-image' alt='Imagen' title='Imagen'>";
} else {
    $avatar_src = false;
}
?>

<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>
        Perfil
        <small>Version 2.0</small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Inicio</a></li>
        <li class="active">Perfil</li>
    </ol>
</section>

<!-- Main content -->
<section class="content">
    <div class="row">
        <!-- left column -->
        <div class="col-md-12 col-sm-12 col-xs-12">
            <!-- general form elements -->
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title">Actualiza tus datos</h3>
                </div>
                <!-- /.box-header -->
                <!-- form start -->
                <form role="form" action="<?= base_url() ?>admin.php/profiles/edit/<?= $profileData->id ?>" method='POST' enctype="multipart/form-data" onsubmit="post_submit()">
                    <div class="box-body">

                        <div class="form-group">
                            <label for="profileUsername">Nombre Completo</label>
                            <input type="text" class="form-control" id="fullname" name="fullname" value="<?= $profileData->fullname ?>">
                        </div>
                        <div class="form-group">
                            <label for="username">E-mail</label>
                            <input type="text" class="form-control disabled" disabled id="username" name="username" value="<?= $profileData->username ?>">
                        </div>
                        <div class="form-group">
                            <label for="profilePhone">Tel&eacute;fono</label>
                            <input type="tel" class="form-control" id="phone" name="phone" value="<?= $profileData->phone ?>" placeholder="Ingrese su numero de tel&eacute;fono">
                        </div>
                        <?php if (check_role(ROLE_ADMIN)) { ?>
                            <div class="form-group">
                                <label>Grupo de usuario</label>

                                <select class="form-control" name="usergroup">
                                    <?php foreach ($usergroups as $group) { ?>
                                        <option value="<?= $group->id ?>" <?= $group->id == $profileData->usergroup ? "selected" : "" ?> <?php echo set_select('usergroup', $group->id); ?>><?= $group->description ?></option>
                                    <?php } ?>                    
                                </select>
                            </div>
                        <?php } ?>

                        <!--profile image-->
                        <div class="form-group">
                            <label>Imagen perfil</label>
                            <input type="file" title="Buscar imagen" value="<?php   if($avatar_src) { echo $avatar_src; }  ?>" accept="jpg" name="avatar" id="avatar" >
                            <br>
                            <div class="alert alert-info ">
                                <p>Seleccione una imagen de dimension 128px por 128px, que no supere los <span class="badge"> 2Mb</span>.<br>
                                    Formato permitido: <span class="badge">JPG</span>.</p>
                            </div>
                        </div>


                        <div class="form-group">
                            <label for="registered">Fecha de Creaci&oacute;n</label>
                            <input type="text" class="form-control" id="registered" disabled name="registered" value="<?= $profileData->registered ?>" >
                        </div>
                        <div class="form-group">
                            <label for="lastUpdate">&Uacute;ltima Modificaci&oacute;n</label>
                            <input type="text" class="form-control" id="lastUpdate" disabled name="lastUpdate" value="<?= $profileData->last_update ?>" >
                        </div>
                    </div>
                    <!-- /.box-body -->

                    <div class="box-footer">
                        <button type="submit" class="btn btn-primary" id="sendProfile">Guardar</button>
                    </div>
                </form>
            </div>
            <!-- /.box -->

            <!-- Form Element sizes -->
            <div class="box box-success">
                <div class="box-header with-border">
                    <h3 class="box-title">Modifica tu contrase&ntilde;a</h3>
                </div>
                <form role="form" action="<?= base_url() ?>admin.php/profiles/change_password/<?= $profileData->id ?>" method='POST' enctype="multipart/form-data">
                    <input type="hidden" class="form-control disable" name="username" value="<?= $profileData->username ?>">
                    <div class="box-body">
                        <div class="form-group">
                            <label for="userpass">Nueva Contrase&ntilde;a</label>
                            <input type="password" class="form-control"  name="userpass" required placeholder="Nueva Contrase&ntilde;a">
                        </div>

                        <div class="form-group">
                            <label for="retryPassword">Repite la Contrase&ntilde;a</label>
                            <input type="password" class="form-control" id="retryPassword" required name="retryPassword" placeholder="Vuelva a ingresar su Contrase&ntilde;a">
                        </div>               
                    </div>

                    <div class="box-footer">
                        <button type="submit" class="btn btn-primary" id="sendPass">Guardar</button>
                    </div>
                </form>
                <!-- /.box-body -->
            </div>
            <!-- /.box -->
        </div>
        <!--/.col md-12 -->
     
    </div><!-- /.row -->
</section><!-- /.content -->
<script type="text/javascript">
    $(function() {


        $("#avatar").fileinput({
            showUpload: false,
            language: 'es',
            showUploadedThumbs: true,
            allowedFileExtensions: ['jpg'],
            maxFileSize: 2000,

            <?php   if($avatar_src) {  ?> initialPreview: [ "<?= $avatar_src; ?>" ] <?php }  ?>

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

    function post_submit() {
        $("#sendProfile").attr("disabled", "disabled");
        $("#sendProfile").val("Guardando..");
    }


</script>
