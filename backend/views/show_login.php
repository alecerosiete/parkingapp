<div class="login-logo">
    <!--<img src="<?=base_url() ?>public/frontend/web/img/logo.png">-->
    <h1>ParkingApp</h1>
</div><!-- /.login-logo -->
<div class="login-box-body">
    <p class="login-box-msg">Identif&iacute;quese para iniciar sesi&oacute;n</p>
    <form action="<?= base_url() ?>admin.php/authentication/login" method="post">
        <div class="form-group has-feedback">
            <input type="email" name="username" class="form-control" placeholder="E-mail"/>
            <span class="glyphicon glyphicon-user form-control-feedback"></span>
        </div>
        <div class="form-group has-feedback">

            <input type="password" name="userpass" class="form-control" placeholder="Contrase&ntilde;a"/>      
            <span class="glyphicon glyphicon-lock form-control-feedback"></span>
            <label style='float:right'><a href="<?= base_url() ?>admin.php/recovery_password/">Olvide mi password</a></label>
        </div>
        <div class="form-group">
            <button type="submit" class="btn btn-primary btn-block btn-flat">Ingresar</button>
        </div>

    </form>



</div><!-- /.login-box-body -->
<br>
<div class="row">
    <?php if ($this->session->flashdata('ControllerMessage') != '') : ?>
        <div class="alert alert-danger">
            <p><?= $this->session->flashdata('ControllerMessage') ?></p>
        </div>
    <?php endif;
	echo get_volatile_message();
	 ?>
</div>
