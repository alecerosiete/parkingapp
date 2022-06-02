<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<style>
    .alert a {
        color: #fff;
        text-decoration: none;
    }
</style>
<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>
        Editar Grupo
        <small>Aqui puede editar grupos de envios</small>
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

            <?php echo validation_errors("<div class='alert alert-danger'> <a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>", "</div>"); ?>
            <?php echo get_volatile_message("alert-danger"); ?>
            <div class="col-md-12">
                <form id="groupForm" action="<?= base_url() ?>admin.php/groups/update/<?= $group->id ?>" name="groupForm" method='POST' enctype="multipart/form-data" onsubmit="post_submit()">
                    <div class="box box-success">
                        <div class="box-header with-border">
                            <h3>Editar grupos de envio</h3>
                        </div><!-- /.box-header -->
                        <div class="box-body">

                            <div class="form-group">
                                <label for="groupName">Nombre del Grupo</label>
                                <input type="text" required id="groupName" class="form-control" name="groupName" value="<?= $group->groupName ?>">
                            </div>
                            <div class="form-group">
                                <label>Seleccione el pais de destino</label>
                                <?= $select_country ?>
                            </div>
                            <div class="form-group">
                                <label for="phoneNumbers">Listado de n&uacute;meros</label><small>| Ingrese los numeros uno debajo de otro</small>
                                <textarea rows="10" class="form-control" id="phoneNumbers" name="phoneNumbers" placeholder="Ingrese su numero en Formato internacional"><?= $phoneNumbers ?></textarea>
                            </div>
                            <div class="form-group">
                                <input type="button" id="validatePhoneNumbers" class="btn btn-md btn-primary" value="Validar Numeros" />
                                <div id="btn-invalid-phoneNumbers" class="btn btn-warning btn-md hide">Numeros no validos (<div class="summary-phone-number-count"></div>)</div>
                            </div>

                            <label class="invalid-phone-numbers">N&uacute;meros no v&aacute;lidos encontrados</label>
                            <div class="form-group invalid-phone-numbers">
                                <textarea id="invalidPhones" class="form-control "  name="invalidPhones" rows="5" ></textarea>
                            </div>
                            <div class="form-group">
                                <input type="submit" id="saveGroup" class="btn btn-md btn-primary" value="Guardar" />
                                <a href="<?= base_url() ?>admin.php/groups/show_list" class="btn btn-md btn-primary" >Descartar</a>
                            </div>

                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div><!-- /.row -->
</section><!-- /.content -->

<script>
    $(document).ready(function () {
        $(".select2").select2();

        $(".invalid-phone-numbers").hide();
        $("#invalidPhones").val("");

        var phoneNumberPlaceholder = "Código de país + Código móvil + Número de teléfono, Ejemplo: \n" + $("#country").find(':selected').data('formato');
        $("#phoneNumbers").attr("placeholder", phoneNumberPlaceholder);

        $(".select2").change(function () {
            var phoneNumberPlaceholder = "Código de país + Código móvil + Número de teléfono, Ejemplo: \n" + $("#country").find(':selected').data('formato');
            $("#phoneNumbers").attr("placeholder", phoneNumberPlaceholder);
        })

        $("#validatePhoneNumbers").click(function () {
            var err_message = "Error!";
            var err = false;
            /* Validate Phone Numbers */
            if (!$("#phoneNumbers").val()) {
                err = true;
                err_message += ", Ingrese al menos un numero valido";
                $.notify({
                    icon: 'glyphicon glyphicon-alert',
                    message: err_message,
                }, {type: 'error',
                    mouse_over: 'pause',
                    delay: 7000,
                    animate: {
                        enter: 'animated shake',
                        exit: 'animated fadeOutUp'
                    }});

                return false;
            }

            //validate lines
            var validPhones = [];
            var invalidPhones = [];
            var countryPrefix = $("#country").find(':selected').data('formato');
            $.each($('#phoneNumbers').val().split(/\n/), function (i, line) {
                var linePhone = line.split(/\//);

                if (linePhone[0] && linePhone[0].length && is_valid(linePhone[0], countryPrefix)) {
                    validPhones.push($.trim(line));

                } else {
                    invalidPhones.push(line);
                }
            });

            if (validPhones.length < 1) {
                err = true;
                err_message += ", Los numeros no son correctos";
            }
            if (invalidPhones.length > 0) {
                $(".invalid-phone-numbers").show();
                $("#invalidPhones").val(invalidPhones.join("\n"));
            } else {
                $(".invalid-phone-numbers").hide();
            }

            var countPhones = validPhones.length;
            validPhones = $.unique(validPhones);
            if (validPhones.length < countPhones) {
                $.notify({
                    icon: 'glyphicon glyphicon-alert',
                    message: 'Numero(s) duplicado(s): ' + (countPhones - validPhones.length) + '. ',
                }, {type: 'warning',
                    mouse_over: 'pause',
                    delay: 7000,
                    animate: {
                        enter: 'animated',
                        exit: 'animated fadeOutUp'
                    }});

            }

            $("#phoneNumbers").val(validPhones.join("\n"));
            if (err) {
                $.notify({
                    icon: 'glyphicon glyphicon-alert',
                    message: err_message,
                }, {type: 'error',
                    mouse_over: 'pause',
                    delay: 7000,
                    animate: {
                        enter: 'animated shake',
                        exit: 'animated fadeOutUp'
                    }});

                return false;
            }
            //only valid number in textarea

            $(".summary-phone-number-count").text($("#phoneNumbers").val().split("\n").length);
        });
        /* end validate phonenumbers*/
<?php echo get_volatile_data(); ?>
<?php echo get_volatile_error(); ?>

    });

    function post_submit() {
        $("#validatePhoneNumbers").click();
        $("#saveGroup").attr("disabled", "disabled");
        $("#saveGroup").val("Guardando..");
    }
    function is_valid(phoneNumber, countryPrefix) {
        var prefix = countryPrefix.split("-")[0];
        if (isNaN(phoneNumber)) {
            return false;
        } else if (phoneNumber.length < 7 || phoneNumber.length > 20) {
            return false;
        } else if (prefix != 0 && !phoneNumber.match(new RegExp('\^' + prefix))) {
            return false;
        }
        return true;
    }
</script>
