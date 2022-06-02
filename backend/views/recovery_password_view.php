<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Okivoice :: Recuperar mi Password</title>
        <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
        <!-- Bootstrap 3.3.4 -->
        <link href="<?= base_url() ?>public/backend/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
        <!-- Font Awesome Icons -->
        <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
        <!-- Theme style -->
        <link href="<?= base_url() ?>public/backend/dist/css/AdminLTE.min.css" rel="stylesheet" type="text/css" />

        <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
            <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
            <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
        <![endif]-->
        <style>
            html {
                
                background-color:#d4d4d4;
                -webkit-background-size: cover;
                -moz-background-size: cover;
                -o-background-size: cover;
                background-size: cover;
            }

            .lockscreen{
                background:none!important;
            }

            .lockscreen-wrapper a, .lockscreen-wrapper h4, .lockscreen-name,.help-block,.lockscreen-footer{
                color: #000!important;
            }
            .btn-default{
                color: #000!important;
            }
        </style>
    </head>
    <body class="hold-transition lockscreen">
        <!-- Automatic element centering -->
        <div class="lockscreen-wrapper">
            <div class="lockscreen-logo">
               <h1>ParkingApp</h1>
            </div>

            <!-- START LOCK SCREEN ITEM -->
            <div class="login-box-body">
                <!-- lockscreen image -->

                <!-- /.lockscreen-image -->

                <!-- lockscreen credentials (contains the form) -->
                <form action="<?= base_url() ?>admin.php/recovery_password/recovery" method="post">

                     <div class="form-group has-feedback">
                         <label>Ingrese su E-mail</label>
                         <input type="email" class="form-control" name="email" placeholder="email" required />
                         <span class="glyphicon glyphicon-user form-control-feedback"></span>
                     </div>
                    
                     <div class="form-group">
                         <button type="submit" class="btn btn-primary"></i>Recuperar</button>
                     </div>
                </form>
                <!-- /.lockscreen credentials -->

            </div>
            <!-- /.lockscreen-item -->
	 <div class="help-block text-center">
          <?php

           echo get_volatile_message_error();
		echo get_volatile_message();	
          ?>
	<br>
		 Ingrese su email para enviarle las instrucciones de recuperaci&oacute;n.
        </div>

           
            <div class="lockscreen-footer text-center">
                <a class="btn btn-xs btn-default" style="color: #000!important;" href="<?= base_url() ?>admin.php">Vover al inicio</a><br>
                Copyright &copy; <?= date("Y") ?> <b>ParkingApp
                    <br/>
                    Todos los derechos reservados
            </div>
        </div>
        <!-- /.center -->

    </body>

    <!-- jQuery 2.1.4 -->
    <script src="<?= base_url() ?>public/backend/plugins/jQuery/jQuery-2.1.4.min.js"></script>
    <!-- Bootstrap 3.3.2 JS -->
    <script src="<?= base_url() ?>public/backend/bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
        <script src="<?= base_url() ?>public/backend/plugins/notify/bootstrap-notify.js" type="text/javascript"></script>
    <script src="<?= base_url() ?>public/backend/plugins/notify/bootstrap-notify.min.js" type="text/javascript"></script>
</html>
