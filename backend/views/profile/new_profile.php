<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

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
        <div class="col-md-12">
            <!-- general form elements -->
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title">Nuevo Perfil de Usuario</h3>
                </div>
                <!-- /.box-header -->
                <!-- form start -->
                <form role="form" action="<?= base_url() ?>admin.php/profiles/create" method='POST' enctype="multipart/form-data">
                    <div class="box-body">

                        <div class="form-group">
                            <label for="fullname">Nombre Completo</label>
                            <input type="text" class="form-control" required id="fullname" name="fullname" value="<?php echo set_value('fullname'); ?>" placeholder="Ingrese nombre completo">
                        </div>
                        <div class="form-group">
                            <label for="username">E-mail</label>
                            <input type="email" class="form-control" required id="username" name="username" value="<?php echo set_value('username'); ?>" placeholder="Ingrese nombre de usuario">
                        </div>
                        <div class="form-group">
                            <label for="phone">Telefono</label>
                            <input type="tel" class="form-control" required id="phone" name="phone" value="<?php echo set_value('phone'); ?>" placeholder="Ingrese Numero de Tel&eacute;fono">
                        </div>
                        <!-- usergroup-->
                        <div class="form-group">
                            <label>Grupo de usuario</label>

                            <select class="form-control" name="usergroup">
                                <?php foreach ($usergroups as $group) { ?>
                                    <option value="<?= $group->id ?>" <?php echo set_select('usergroup', $group->id); ?>><?= $group->description ?></option>
                                <?php } ?>                    
                            </select>
                        </div>
                        <!--profile image-->
                        <div class="form-group">
                              <label>Imagen perfil</label>
                              <input type="file" title="Buscar imagen" value="" accept="jpg" name="avatar" id="avatar" >
                            <br>
                            <div class="alert alert-info ">
                                <p>Seleccione una imagen  de dimensi&oacute;n 128px por 128px,  que no supere los <span class="badge"> 2Mb</span>.<br>
                                    Formato permitido: <span class="badge">JPG</span>.</p>
                            </div>
                        </div>
                        <!--                password-->
                        <div class="form-group">
                            <label for="userpass">Nueva Contrase&ntilde;a</label>
                            <input type="password" class="form-control" id="userpass" name="userpass" placeholder="Nueva Contrase&ntilde;a">
                        </div>

                        <div class="form-group">
                            <label for="retryUserpass">Repite la Contrase&ntilde;a</label>
                            <input type="password" class="form-control" id="retryUserpass" name="retryUserpass" placeholder="Vuelva a ingresar su Contrase&ntilde;a">
                        </div> 
                    </div>
                    <!-- /.box-body -->

                    <div class="box-footer">
                        <button type="submit" class="btn btn-primary">Guardar</button>
                    </div>
                </form>
            </div>
            <!-- /.box -->
        </div>
        <!--/.col md-12 -->

    </div><!-- /.row -->
</section><!-- /.content -->

<script type="text/javascript">
    $(document).ready(function() {

        $("#avatar").fileinput({
            showUpload: false,
            language: 'es',
            showUploadedThumbs: true,
            allowedFileExtensions: ['jpg'],
            maxFileSize: 2000

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
</script>