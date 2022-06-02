<?php
/* Dispara la orden para abriar la barrera vahicular */
?>
<!doctype html>
<html lang="en">
    <head><meta http-equiv="Content-Type" content="text/html; charset=utf-8">
        <!-- Required meta tags -->
        
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

        <!-- Bootstrap CSS -->
        <link rel="stylesheet" href="<?= base_url() ?>public/backend/reader/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">

        <title>Lectura de Ticket - ParkingApp</title>
        <style>
            .footer {
                position: absolute;
                bottom: 0;
                width: 100%;
                height: 60px; /* Set the fixed height of the footer here */
                line-height: 60px; /* Vertically center the text there */
                background-color: #f5f5f5;
            }
            #icon-result-ok{
                color:#82c91e;
            }
            #icon-result-error{
                color:#dc3545;
            }

        </style>
        <script defer src="<?= base_url() ?>public/backend/reader/fonts/all.js"></script>
    </head>
    <body>

        <?php echo $layout_content; ?>


        <!-- Optional JavaScript -->
        <!-- jQuery first, then Popper.js, then Bootstrap JS -->
        <script src="<?= base_url() ?>public/backend/reader/js/jquery-3.3.1.min.js" crossorigin="anonymous"></script>
        <!--script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script -->
        <script src="<?= base_url() ?>public/backend/reader/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
        <script src="<?= base_url() ?>public/backend/reader/js/bootstrap-notify.js"></script>
        <script>
            $.fn.delayPasteKeyUp = function (fn, ms)
            {
                var timer = 0;
                $(this).on("propertychange input", function ()
                {
                    clearTimeout(timer);
                    timer = setTimeout(fn, ms);
                });
            };

            //la utilizamos
            $(document).ready(function ()
            {
                $("#barcode").focus();
                $("#icon-result-ok").hide();
                $("#icon-result-error").hide();
                var barcode = "";
                var result = "";

                $("#barcode").delayPasteKeyUp(function () {
                    barcode = $("#barcode").val();

                    $("#barcode").val("");
                    result = setRelay("on", barcode);

                }, 400);


            });

            function setRelay(action, barcode) {
                var result = "";
                $.ajax({
                    data: {"action": action, "ticketId": barcode},
                    type: "POST",
                    dataType: "json",
                    url: "<?=base_url()?>admin.php/BarcodeReader/read",

                }).done(function (data) {
                    console.log("DAta: " + data.status);
                    showNotif(data.status, barcode);
                })


            }

            function showNotif(status, barcode) {
                var notifyType = "";
                var notifyTitle = "";
                if (status == "OK") {
                    notifyType = "success";
                    notifyTitle = "<strong>Lectura Exitosa!</strong><br>";
                    $("#icon-result-ok").show();
                    $("#icon-result-error").hide();
                } else {
                    notifyType = "danger";
                    notifyTitle = "<strong>Ocurrio un error!</strong><br>";
                    $("#icon-result-ok").hide();
                    $("#icon-result-error").show();

                }

                $.notify({
                    // options
                    title: notifyTitle,
                    message: 'Numero de Ticket Leido: ' + barcode
                }, {
                    // settings
                    type: notifyType
                });



            }

        </script>

    </body>
</html>
