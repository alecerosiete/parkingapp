<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title> <?= $this->layout->getTitle() ?></title>
        <!-- Tell the browser to be responsive to screen width -->
        <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
        <!-- Bootstrap 3.3.6 -->
        <link rel="stylesheet" href="<?= base_url() ?>public/backend/bootstrap/css/bootstrap.min.css">
        <!-- Font Awesome -->
        <link rel="stylesheet" href="<?=base_url()?>public/backend/dist/css/font-awesome.min.css">
        <!-- Ionicons -->
        <link rel="stylesheet" href="<?=base_url()?>public/backend/dist/css/ionicons.min.css" type="text/css">
        <!-- Theme style -->
        <link rel="stylesheet" href="<?= base_url() ?>public/backend/dist/css/AdminLTE.min.css"  type="text/css">
        <!-- iCheck -->
        <link rel="stylesheet" href="<?= base_url() ?>public/backend/plugins/iCheck/square/blue.css">
	<link rel="shortcut icon" href="<?=base_url()?>public/frontend/web/imgwa/logo.png" type="image/png"/>
	<link rel="apple-touch-icon" href="<?=base_url()?>public/frontend/web/imgwa/logo.png" type="image/png"/>

    </head>

    <body class="hold-transition register-page">
        <div class="register-box">
            <?php echo $layout_content; ?>


        </div>
        <!-- /.register-box -->

        <!-- jQuery 2.2.0 -->
        <script src="<?= base_url() ?>/public/backend/plugins/jQuery/jQuery-2.2.0.min.js"></script>
        <!-- Bootstrap 3.3.6 -->
        <script src="<?= base_url() ?>/public/backend/bootstrap/js/bootstrap.min.js"></script>
        <!-- iCheck -->
        <script src="<?= base_url() ?>/public/backend/plugins/iCheck/icheck.min.js"></script>

    </body>
</html>

