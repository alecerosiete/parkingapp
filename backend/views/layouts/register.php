<!DOCTYPE html>
<html lang="es">
    <head>
        <title> <?= $this->layout->getTitle() ?></title>
        <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
        <!-- Bootstrap 3.3.4 -->
        <link href="<?= base_url() ?>/public/backend/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
        <!-- Font Awesome Icons -->
        <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
        <!-- Theme style -->
        <link href="<?= base_url() ?>/public/backend/dist/css/AdminLTE.min.css" rel="stylesheet" type="text/css" />
        <!-- iCheck -->
        <link href="<?= base_url() ?>/public/backend/plugins/iCheck/square/blue.css" rel="stylesheet" type="text/css" />
<link rel="shortcut icon" href="<?=base_url()?>public/frontend/web/imgwa/logo.png" type="image/png"/>
<link rel="apple-touch-icon" href="<?=base_url()?>public/frontend/web/imgwa/logo.png" type="image/png"/>

        <!-- jQuery 2.1.4 -->
        <script src="<?= base_url() ?>/public/backend/plugins/jQuery/jQuery-2.1.4.min.js"></script>
        <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
            <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
            <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
        <![endif]-->
    </head>

    <body class="login-page">
        <div class="login-box">
            <?php echo $layout_content; ?>
        </div><!-- /.login-box -->

        <!-- Bootstrap 3.3.2 JS -->
        <script src="<?= base_url() ?>/public/backend/bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
        <!-- iCheck -->
<!--        <script src="<?= base_url() ?>/public/backend/plugins/iCheck/icheck.min.js" type="text/javascript"></script>-->
    </body>
    
</html>


</body>