<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<div class="container">

    <div class="row">

        <div class="col-sm-10 col-sm-offset-1" >				

            <div class="media">
                <div class="media-left">
                    <img class="media-object" src="<?= base_url() ?>public/frontend/web/imgwa/logofaqs.png" alt="FAQs logo">
                </div>
                <div class="media-body media-middle">
                    <h5 class="media-heading">FAQs</small></h5>
                </div>
            </div>

            <br>	

            <h6>¿Qué tipos de mensajes puedo enviar?</h6>
            Puede enviar mensajes de texto o multimedia (imágenes - videos). 
            <br><br>

            <h6>¿Cómo debe estar conformado un número de móvil para el envío?</h6>
            Nuestra herramienta está preparada para ayudarte a depurar y armar la base de datos en forma correcta. Conformación de número: código país (sin ceros ni signo más) + prefijo (depende de cada país y en algunos no existe) + código de ciudad + número de móvil.<br>
            Ejemplos:<br>
            <ul>
                <li>United States: 1-1234567890 
                <li>United Kingdom 44-7-123456789 
                <li>India: 91-1234567890 
                <li>Perú: 51-9-9-1297507
                <li>Argentina: 54-9-11-44054486
                <li>México: 52-1-99-8789128
            </ul>

            <h6 id="credits">¿Cómo se contabilizan los créditos cuando son de texto, de imagen o video?</h6>
            Partiendo que nuestra unidad es el crédito la tabla es la siguiente: 
            <ul>
                <li>1 texto: 1 crédito 
                <li>1 imagen: 2 créditos 
                <li>1 video: 3 créditos 
                <li>Personalización de la foto de perfil: 1 crédito extra por mensaje 
            </ul>

            Puedes añadir un texto adicional (epígrafe) a tus imágenes y videos sin costo adicional. 

            <br>
            <br>

            <h6>¿Qué caracteres puedo enviar en los textos?</h6>
            Los caracteres permitidos son: ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789!?#$%()*+,_-./|:;=@<>¿¡ñÑáéíóúüÜÁÉÍÓÚÃãâàèìòùÂÀÈÌÒÙÕõçÇôÔÊê& 
            <br><br>

            <h6>¿Qué debo tener en cuenta para subir una imagen exitosamente?</h6>
            La imagen debe ser jpg, no debe superar los 2 MB y el upload no debe superar los 30 segundos. 
            <br><br>

            <!--
            <h6>What should I take into account to upload an audio successfully?</h6>
            The audio should be in mp3 format, it should not exceed 4 MB and uploading should not exceed 30 seconds.
            <br><br>	
            -->

            <h6>¿Qué debo tener en cuenta para subir un video exitosamente?</h6>
            El video debe ser mp4, no debe superar los 6 MB y el upload no debe superar los 30 segundos. 
            <br><br>

            <h6>¿Puedo agregar un texto a una imagen o video?</h6>
            Si, puede insertar un texto para las imágenes y videos. 		
            <br><br>	

            <a name=perfil></a><h6>¿Puedo personalizar la foto de perfil?</h6>
            Si. 
            <br><br>					

            <h6>¿Qué sucede con los mensajes enviados a los números que no usan WhatsApp?</h6>
            La primera vez que envías un mensaje a un número de teléfono el sistema verificará si tiene WhatsApp o no y será cobrado. La segunda vez, si el número no tiene WhatsApp, el sistema rechazará el envío y no se cobrará.
            <br>Posteriormente podrá limpiar su base de datos exportando los números de teléfonos INVÁLIDOS para futuras campañas. 
            <br><br>

            <h6>¿Puedo ver informes del proceso de envío?</h6>
            Si, nuestro sistema le informa en tiempo real sobre el envío en proceso. Podrá exportarlo a excel o txt. 

            <br><br>

            <h6>¿Puedo desde una misma cuenta enviar mensajes a varios países en forma simultánea?</h6>
            Si, nuestro sistema permite ese tipo de envío multi-país.

            <br><br>

            <h6>Tengo la necesidad de abrir subcuentas para que cada departamento de mi empresa pueda administrar sus propios envíos, ¿eso es posible?</h6>
            Si, nuestro sistema permite la apertura de subcuentas a partir de una cuenta madre o principal. Para su apertura envíe un mail solicitando la apertura de las mismas a whasend@gmail.com 
            <br><br>

            <h6>¿Puedo programar envíos definiendo día, hora y grupo de envío?</h6>
            Si, el sistema le provee la posibilidad de definir cuándo, a quiénes y qué mensaje desea enviar. 
            <br><br>

            <h6>¿Tengo alguna limitación diaria en la cantidad de envíos?</h6>
            No, no hay límite diario siempre que tenga saldo en su cuenta. 
            <br><br>

            <h6>¿Puedo enviar un mensaje que contenga un hipervínculo?</h6>
            No, por las políticas de seguridad de WhatsApp no será efectivo. 
            <br><br>

            <h6>¿Por qué mis mensajes no han llegado todavía?</h6>
            Los mensajes dependen de un sistema de colas, en consecuencia no podemos garantizar entrega inmediata, dado que hay muchas variables en juego que actúan sobre el tiempo de entrega. En los casos donde la espera es máxima, la entrega puede llegar a tardar hasta 24 horas. 
            <br><br>



            <!--
            <h6>Why do the inscriptions "Sender Mobile Number: xxxxxxxxxx  // TransID: xxxxxxxxxx appear in the body of the message?</h6>
            It is an internal encoding needed to maintain a maximum security level in the delivery. It cannot be hidden.
            <br><br>
            -->

            <h6>Si envío una imagen o un video, ¿repercute en los tiempos de entrega?</h6>
            Si, una de las variables que define la velocidad de envío es el peso de los adjuntos si los hubiera. O sea no es lo mismo enviar un texto que un video o una imagen. Cuanto mayor es el peso del archivo menor es la velocidad de envío. 
            <br><br>

            <h6>¿Puedo ver las respuestas a los mensajes enviados?</h6>
            Si, las respuestas se recibirán en forma diferida luego de 5 horas de haber efectuado el envío. El porcentaje de recuperación será de un 80% aproximadamente. 
            <br><br>

            <h6>¿Podemos recibir llamadas?</h6>
            No, no se pueden recibir llamadas. 
            <br><br>

            <h6>¿Puedo utilizar mis propios números como remitente para enviar los mensajes?</h6>
            No, eso no es posible. 
            <br><br>

            <h6>¿Es posible configurar o enmascarar el número del remitente?</h6>
            No, eso no es posible. 
            <br><br>

            <h6>¿Cuántos caracteres puedo enviar en los mensajes de texto?</h6>
            3000 caracteres. 
            <br><br>

            <h6>¿Qué vigencia tienen mis créditos?</h6>
            Tienen vigencia por 3 meses. Luego de ese período se procederá a la baja de la cuenta. Con cada nueva compra antes de su vencimiento su cuenta con los créditos acumulados (créditos no utilizados más créditos correspondientes a la nueva compra) se renuevan automáticamente por 3 meses más. 
            <br><br>

            <h6>Política ANTI-SPAM</h6>
            Acceda al documento haciendo click <a href="<?=base_url()?>index.php/antispam">AQUÍ</a>. 

        </div>
    </div>

</div>

