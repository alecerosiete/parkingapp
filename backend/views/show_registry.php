<style>
.login-box, .register-box {
    width: 360px;
    margin: 1% auto!important;
}
</style>
<div class="row">
    <?php if ($this->session->flashdata('registerMessageError') != '') : ?>
        <div class="alert alert-danger">
            <p><?= $this->session->flashdata('registerMessageError') ?></p>
        </div>
    <?php endif; ?>
     <?php if ($this->session->flashdata('registerMessageSuccess') != '') : ?>
        <div class="alert alert-success">
            <p><?= $this->session->flashdata('registerMessageSuccess') ?></p>
        </div>
    <?php endif; ?>
    <?php echo validation_errors("<div class='alert alert-danger'>","</div>"); ?>
</div>
<div class="register-logo">
    <a href="<?= base_url() ?>admin.php">    <img src="<?=base_url() ?>public/frontend/web/img/logo.png"></a>
</div>

<div class="register-box-body">
    <p class="login-box-msg">Registrese para obtener una cuenta</p>

    <form action="<?= base_url() ?>admin.php/registry/registration"  method="post" onsubmit="JavaScript:return validate(document.getElementById('phone').value);">

        <div class="form-group has-feedback">
            <input type="email" required class="form-control" value="<?=set_value("email")?>" name="email" placeholder="Email">
            <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
        </div>
        <div class="form-group has-feedback">
            <input type="text" class="form-control" name="name" value="<?=set_value("name")?>"  placeholder="Nombre y Apellido">
            <span class="glyphicon glyphicon-user form-control-feedback"></span>
        </div>
        <div class="form-group has-feedback">
            <input type="tel" class="form-control" required id="phone" name="phone" value="<?=set_value("phone")?>" placeholder="Celular" onkeyup="return validate(this.value)" onpaste="return false;">
<div id="phoneError"></div>
            <span class="glyphicon glyphicon-lock form-control-feedback"></span>
        </div>
		
       
        <div class="row">
            <div class="col-xs-12">               
                    <label>
                        <input type="checkbox" <?=set_checkbox("terms")?> id="terms" value="1" name='terms' class="flat-red"/>
                        Acepto los <a href="https://docs.google.com/document/d/1p_Wwe6MRlYrMUK6DwoOUyFBZcwpygJ62qp7dy0gMM2c/edit?usp=sharing">Terminos y Condiciones</a>
                    </label>
               </div>
            <!-- /.col -->
            <div class="col-xs-12">
                <button type="submit" class="btn btn-primary btn-block btn-flat"  >Registrarse</button>
            </div>
	    <div class="col-xs-12" >
<br>
		<?php 
			echo get_volatile_message_error();
		?>
</div>
            <!-- /.col -->
        </div>
        <br>
        
    </form>

<hr>
    Ya estoy registrado, <a href="<?= base_url() ?>admin.php/authentication/" class="text-center">Acceder</a>
</div>
<!-- /.form-box -->


<script>
function validate(valor){

   var expresion = new RegExp("^(59599|59598|59597|59596|59595|59594|59593|59592|59591).[0-9]{6,9}");
   if (!expresion.test(valor)){
     document.getElementById("phone").style.color = "red";
     document.getElementById("phoneError").innerHTML = "Ingrese un numero en formato internacional (595981111111) ";
     return false;
   }else{
     document.getElementById("phone").style.color = "green";

     return true;
   }
}
</script>


