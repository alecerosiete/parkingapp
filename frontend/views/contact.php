<script type="text/javascript" src="<?=base_url()?>public/frontend/web/js/valForm.js"></script>

<!--JS-->
<!--FIN JS-->
<style type="text/css">
    body
    {
        ddmargin: 0px;
        ssfont-family: verdana, arial, sans-serif;
        ssfont-size: 13px;
        dddcolor: #FFFFFF;
    }


    .miboton
    {
        hchfont-family: verdana, arial, sans-serif;
        font-size: 19px;

        -webkit-appearance: none;
        -webkit-box-shadow: rgba(0, 0, 0, 0.6) 0px 1px 4px 0px;
        -webkit-writing-mode: horizontal-tb;
        align-items: flex-start;
        background-color: rgb(32, 126, 169);
        border-bottom-color: rgb(255, 255, 255);
        border-bottom-left-radius: 0px;
        border-bottom-right-radius: 0px;
        border-bottom-style: none;
        border-bottom-width: 0px;
        border-image-outset: 0px;
        border-image-repeat: stretch;
        border-image-slice: 100%;
        border-image-source: none;
        border-image-width: 1;
        border-left-color: rgb(255, 255, 255);
        border-left-style: none;
        border-left-width: 0px;
        border-right-color: rgb(255, 255, 255);
        border-right-style: none;
        border-right-width: 0px;
        border-top-color: rgb(255, 255, 255);
        border-top-left-radius: 0px;
        border-top-right-radius: 0px;
        border-top-style: none;
        border-top-width: 0px;
        box-shadow: rgba(0, 0, 0, 0.6) 0px 1px 4px 0px;
        box-sizing: border-box;
        color: rgb(255, 255, 255);
        cursor: pointer;
        direction: ltr;
        display: block;
        float: right;
        font-stretch: normal;
        font-style: normal;
        font-variant: normal;
        font-weight: bold;
        height: 36px;
        letter-spacing: normal;
        line-height: 26.6000003814697px;
        margin-bottom: 0px;
        margin-left: 10px;
        margin-right: 0px;
        margin-top: 0px;
        max-width: 35%;
        padding-bottom: 5px;
        padding-left: 8px;
        padding-right: 8px;
        padding-top: 5px;
        text-align: center;
        text-indent: 0px;
        text-shadow: none;
        text-transform: none;
        dwidth: 94.8125px;
        word-spacing: 0px;
        writing-mode: lr-tb;
    }

    .micasilla
    {
        -webkit-appearance: none;
        -webkit-box-shadow: rgba(0, 0, 0, 0.6) 0px 1px 4px 0px;
        -webkit-rtl-ordering: logical;
        -webkit-user-select: text;
        -webkit-writing-mode: horizontal-tb;
        background-color: rgb(255, 255, 255);
        border-bottom-color: rgb(32, 126, 169);
        border-bottom-left-radius: 0px;
        border-bottom-right-radius: 0px;
        border-bottom-style: solid;
        border-bottom-width: 0px;
        border-image-outset: 0px;
        border-image-repeat: stretch;
        border-image-slice: 100%;
        border-image-source: none;
        border-image-width: 1;
        border-left-color: rgb(32, 126, 169);
        border-left-style: solid;
        border-left-width: 0px;
        border-right-color: rgb(32, 126, 169);
        border-right-style: solid;
        border-right-width: 0px;
        border-top-color: rgb(32, 126, 169);
        border-top-left-radius: 0px;
        border-top-right-radius: 0px;
        border-top-style: solid;
        border-top-width: 0px;
        box-shadow: rgba(0, 0, 0, 0.6) 0px 1px 4px 0px;
        box-sizing: border-box;
        color: rgb(96, 94, 94);
        cursor: auto;
        direction: ltr;
        display: inline-block;
        hchfont-family: verdana, arial, sans-serif;
        font-size: 17px;
        font-stretch: normal;
        font-style: normal;
        font-variant: normal;
        font-weight: normal;
        height: 33px;
        letter-spacing: normal;
        line-height: 23.7999992370605px;
        margin-bottom: 5px;
        margin-left: 0px;
        margin-right: 0px;
        margin-top: 0px;
        padding-bottom: 5px;
        padding-left: 5px;
        padding-right: 5px;
        padding-top: 5px;
        text-align: start;
        text-indent: 0px;
        text-shadow: none;
        text-transform: none;
        width: 100%;
        word-spacing: 0px;
        writing-mode: lr-tb;
    }

    .mitexto
    {
        border-bottom-color: rgb(32, 126, 169);
        border-bottom-left-radius: 0px;
        border-bottom-right-radius: 0px;
        border-bottom-style: solid;
        border-bottom-width: 0px;
        border-left-color: rgb(32, 126, 169);
        border-left-style: solid;
        border-left-width: 0px;
        border-right-color: rgb(32, 126, 169);
        border-right-style: solid;
        border-right-width: 0px;
        border-top-color: rgb(32, 126, 169);
        border-top-left-radius: 0px;
        border-top-right-radius: 0px;
        border-top-style: solid;
        border-top-width: 0px;
        color: rgb(96, 94, 94);
        cursor: auto;
        display: inline-block;
        hchfont-family: verdana, arial, sans-serif;
        font-size: 17px;
        font-stretch: normal;
        font-style: normal;
        font-variant: normal;
        font-weight: normal;
        height: 33px;
    }

    .mitextogrande
    {
        font-size:20px;
    }
</style>

<SCRIPT language=Javascript>
    <!--
  function isNumberKey(evt)
    {
        var charCode = (evt.which) ? evt.which : event.keyCode
        if (charCode > 31 && (charCode < 48 || charCode > 57))
            return false;

        return true;
    }
    //-->
</SCRIPT>

<script src="http://code.jquery.com/jquery-1.10.1.min.js"></script>
<script>
    // document ready
    $(function() {

        // capture all enter and do nothing
        $('#Email').keypress(function(e) {
            if (e.which == 13) {
                $('#Email').trigger('focusout');
                return false;
            }
        });


    });

    // while the lookup is performing
    function validation_in_progress() {
        $('#status').html("<img src='/img/loading.gif' height='16'/>");
    }



    // if email successfull validated
    function validation_success(data) {
        $('#status').html(get_suggestion_str(data['is_valid'], data['did_you_mean']));
    }



    // if email is invalid
    function validation_error(error_message) {
        $('#status').html(error_message);
    }



    // suggest a valid email
    function get_suggestion_str(is_valid, alternate) {
        if (alternate) {
            return '<span class="warning"><b>Did you mean <em><a href="javascript://" onclick="document.getElementById(\'Email\').value=\'' + alternate + '\';$(\'#Email\').trigger(\'focusout\');">' + alternate + '</a></em>?</b><br></span><br>';
        } else if (is_valid) {
            return '';
        } else {
            return '<span class="error"><b>Invalid email!</b><br></span><br>';
        }
    }


</script>
<style>
    .success{color:#2ECC40;}
    .error{color:#FF4136;}
    .warning{color:#FF851B;}

    .success, .success A{color:#FFFFFF;}
    .error, .error A{color:#FFFFFF;}
    .warning, .warning A{color:#FFFFFF;}
</style>

<!--VALIDADOR MAILGUN FIN-->


<div class="container">

    <div class="row">

        <div class="col-sm-10 col-sm-offset-1" >				

            <div class="media">

                <div class="media-left">
                    <img class="media-object" src="<?= base_url() ?>public/frontend/web/imgwa/logocontacto.png" alt="Contacto">
                </div>

                <div class="media-body media-middle">
                    <h5 class="media-heading">Contacto <small>/ Demo / Ventas</small></h5>
                </div>

            </div>

        </div>

        <div class="col-sm-10 col-sm-offset-1" >				
<?php
if(isset($message)){
        echo "<div class='alert alert-success'>".$message."</div>";
}
?>
            <div id="contactoformulario" class="col-sm-6" style="border-right: 1px solid grey" >
                <br><br>

                <form action="<?=base_url()?>index.php/contact/send" method="POST" name="form-c" id="form-c">
                    <input name=recipient value="sales@whappend.com" type=hidden>
                    <input name=email2 value="" type=hidden>
                    <input type=hidden name=redirect value="send-registration-ok.asp">
                    <input type=hidden name=subject value="Contact from Okivoice.com">

                    <label for="Nombre"><strong>Nombre:</strong> (*)</label><br>
                    <input class="micasilla" name="Nombre" id=Nombre><br>

                    <label for="País"><strong>Pais:</strong> (*)</label><br>

                    <input type=hidden name="whatsappidpais" id=whatsappidpais value="">
                    <select tabindex=5 name=Pais id=Pais class="micasilla" onchange="
                            var mi_opcion = $('#Pais').find('option:selected');
                            mi_id = mi_opcion.attr('data-id');
                            $('#whatsappidpais').val(mi_id);
                            ">
                        <OPTION value="">	
                        <option value="Afganistán" data-id="1">Afghanistan<option value="Albania" data-id="2">Albania<option value="Algeria" data-id="3">Algeria<option value="Andorra" data-id="5">Andorra<option value="Angola" data-id="6">Angola<option value="Argentina" data-id="9">Argentina<option value="Armenia" data-id="10">Armenia<option value="Aruba" data-id="11">Aruba<option value="Isla Ascensión" data-id="12">Ascension Island<option value="Santa Elena" data-id="175">Ascension y Tristan de Acuña<option value="Austria" data-id="14">Austria<option value="Azerbayán" data-id="15">Azerbaijan<option value="Bahrein" data-id="17">Bahrain<option value="Bangladesh" data-id="18">Bangladesh<option value="Bielorrusia" data-id="20">Belarus<option value="Bélgica" data-id="21">Belgium<option value="Belice" data-id="22">Belize<option value="Benín" data-id="23">Benin<option value="Bhután" data-id="25">Bhutan<option value="Bolivia" data-id="26">Bolivia<option value="Bosnia y Herzegovina" data-id="27">Bosnia and Herzegovina<option value="Botsuana" data-id="28">Botswana<option value="Brasil" data-id="29">Brazil<option value="Brunéi" data-id="31">Brunei<option value="Bulgaria" data-id="32">Bulgaria<option value="Burkina Faso" data-id="33">Burkina Faso<option value="Burundi" data-id="34">Burundi<option value="Camboya" data-id="35">Cambodia<option value="Camerún" data-id="36">Cameroon<option value="Canadá" data-id="225">Canada<option value="Cabo Verde" data-id="38">Cape Verde<option value="República Centroafricana" data-id="40">Central African Republic<option value="Chad" data-id="41">Chad<option value="Chile" data-id="42">Chile<option value="China" data-id="43">China<option value="Islas Cocos (Keeling)" data-id="13">Cocos (Keeling) Islands<option value="Colombia" data-id="44">Colombia<option value="Comoras" data-id="45">Comoros<option value="Congo (242)" data-id="46">Congo (242)<option value="Congo (243)" data-id="54">Congo (243)<option value="Islas Cook" data-id="47">Cook Islands<option value="Costa Rica" data-id="48">Costa Rica<option value="Croacia" data-id="49">Croatia<option value="Cuba" data-id="50">Cuba<option value="Chipre" data-id="52">Cyprus<option value="República Checa" data-id="53">Czech Republic<option value="Dinamarca" data-id="55">Denmark<option value="Diego Garcia" data-id="56">Diego Garcia<option value="Yibuti" data-id="57">Djibouti<option value="República Dominicana" data-id="59">Dominican Republic<option value="Timor Oriental" data-id="60">East Timor<option value="Ecuador" data-id="61">Ecuador<option value="Egipto" data-id="62">Egypt<option value="El Salvador" data-id="63">El Salvador<option value="Guinea Ecuatorial" data-id="64">Equatorial Guinea<option value="Eritrea" data-id="65">Eritrea<option value="Micronesia" data-id="134">Estados Federados de<option value="Estonia" data-id="66">Estonia<option value="Etiopía" data-id="67">Ethiopia<option value="Islas Malvinas" data-id="68">Falkland Islands (Malvinas)<option value="Islas Feroe" data-id="69">Faroe Islands<option value="Fiyi" data-id="70">Fiji<option value="Finlandia" data-id="71">Finland<option value="Francia" data-id="72">France<option value="Guayana Francesa" data-id="73">French Guiana<option value="Polinesia Francesa" data-id="74">French Polynesia<option value="Gabón" data-id="75">Gabon<option value="Gambia" data-id="76">Gambia<option value="Georgia" data-id="77">Georgia<option value="Alemania" data-id="78">Germany<option value="Ghana" data-id="79">Ghana<option value="Gibraltar" data-id="80">Gibraltar<option value="Grecia" data-id="81">Greece<option value="Groenlandia" data-id="82">Greenland<option value="Guatemala" data-id="86">Guatemala<option value="Guinea" data-id="87">Guinea<option value="Guinea-Bissau" data-id="88">Guinea-Bissau<option value="Guyana" data-id="89">Guyana<option value="Haití" data-id="90">Haiti<option value="Honduras" data-id="91">Honduras<option value="Hong kong" data-id="92">Hong Kong<option value="Hungría" data-id="93">Hungary<option value="Islandia" data-id="94">Iceland<option value="India" data-id="95">India<option value="Indonesia" data-id="96">Indonesia<option value="Irán" data-id="97">Iran<option value="Irak" data-id="98">Iraq<option value="Irlanda" data-id="99">Ireland<option value="Israel" data-id="100">Israel<option value="Italia" data-id="101">Italy<option value="Costa de Marfil" data-id="102">Ivory Coast<option value="Japón" data-id="104">Japan<option value="Jordania" data-id="105">Jordan<option value="Kenia" data-id="107">Kenya<option value="Kiribati" data-id="108">Kiribati<option value="Kuwait" data-id="109">Kuwait<option value="Kirgizstán" data-id="110">Kyrgyzstan<option value="Laos" data-id="111">Laos<option value="Letonia" data-id="112">Latvia<option value="Líbano" data-id="237">Lebanon<option value="Líbano 7" data-id="113">Lebanon 7<option value="Lesoto" data-id="114">Lesotho<option value="Liberia" data-id="115">Liberia<option value="Libia" data-id="116">Libya<option value="Liechtenstein" data-id="117">Liechtenstein<option value="Lituania" data-id="118">Lithuania<option value="Luxemburgo" data-id="119">Luxembourg<option value="Macao" data-id="120">Macao<option value="Macedônia" data-id="121">Macedonia<option value="Madagascar" data-id="122">Madagascar<option value="Malawi" data-id="123">Malawi<option value="Malasia" data-id="124">Malaysia<option value="Islas Maldivas" data-id="125">Maldives<option value="Mali" data-id="126">Mali<option value="Malta" data-id="127">Malta<option value="Islas Marshall" data-id="128">Marshall Islands<option value="Martinica" data-id="129">Martinique<option value="Mauritania" data-id="130">Mauritania<option value="Mauricio" data-id="131">Mauritius<option value="Mayotte" data-id="171">Mayotte<option value="México" data-id="133">Mexico<option value="Moldavia" data-id="135">Moldova<option value="Mónaco" data-id="136">Monaco<option value="Mongolia" data-id="137">Mongolia<option value="Montenegro" data-id="138">Montenegro<option value="Marruecos" data-id="140">Morocco<option value="Mozambique" data-id="141">Mozambique<option value="Birmania" data-id="142">Myanmar<option value="Namibia" data-id="143">Namibia<option value="Nauru" data-id="144">Nauru<option value="Nepal" data-id="145">Nepal<option value="Países Bajos" data-id="146">Netherlands<option value="Antillas Neerlandesas" data-id="51">Netherlands Antilles<option value="Nueva Caledonia" data-id="148">New Caledonia<option value="Nueva Zelanda" data-id="149">New Zealand<option value="Nicaragua" data-id="150">Nicaragua<option value="Niger" data-id="151">Niger<option value="Nigeria" data-id="152">Nigeria<option value="Niue" data-id="153">Niue<option value="Isla Norfolk" data-id="154">Norfolk Island<option value="Corea del Norte" data-id="155">North Korea<option value="Noruega" data-id="157">Norway<option value="Omán" data-id="158">Oman<option value="Pakistán" data-id="159">Pakistan<option value="Palau" data-id="160">Palau<option value="Palestina" data-id="161">Palestine<option value="Panamá" data-id="162">Panama<option value="Papúa Nueva Guinea" data-id="163">Papua New Guinea<option value="Paraguay" data-id="164">Paraguay<option value="Perú" data-id="165">Peru<option value="Filipinas" data-id="166">Philippines<option value="Polonia" data-id="167">Poland<option value="Portugal" data-id="168">Portugal<option value="Puerto Rico" data-id="169">Puerto Rico<option value="Qatar" data-id="170">Qatar<option value="Rumanía" data-id="172">Romania<option value="Rusia" data-id="173">Russia<option value="Ruanda" data-id="174">Rwanda<option value="San Bartolomé" data-id="84">Saint Barthelemy<option value="San Pedro y Miquelón" data-id="180">Saint Pierre and Miquelon<option value="Samoa" data-id="182">Samoa<option value="San Marino" data-id="183">San Marino<option value="Santo Tomé y Príncipe" data-id="184">Sao Tome and Principe<option value="Arabia Saudita" data-id="185">Saudi Arabia<option value="Senegal" data-id="186">Senegal<option value="Serbia" data-id="187">Serbia<option value="Seychelles" data-id="188">Seychelles<option value="Sierra Leona" data-id="189">Sierra Leone<option value="Singapur" data-id="190">Singapore<option value="Eslovaquia" data-id="192">Slovakia<option value="Eslovenia" data-id="193">Slovenia<option value="Islas Salomón" data-id="194">Solomon Islands<option value="Somalia" data-id="195">Somalia<option value="Sudáfrica" data-id="196">South Africa<option value="Corea del Sur" data-id="197">South Korea<option value="Sudán del Sur" data-id="198">South Sudan<option value="España" data-id="199">Spain<option value="Sri lanka" data-id="200">Sri Lanka<option value="Sudán" data-id="201">Sudan<option value="Surinám" data-id="202">Suriname<option value="Swazilandia" data-id="203">Swaziland<option value="Suecia" data-id="204">Sweden<option value="Suiza" data-id="205">Switzerland<option value="Siria" data-id="206">Syria<option value="Taiwán" data-id="207">Taiwan<option value="Tadjikistán" data-id="208">Tajikistan<option value="Tanzania" data-id="209">Tanzania<option value="Tailandia" data-id="210">Thailand<option value="Thuraya Satellite" data-id="211">Thuraya Satellite<option value="Togo" data-id="212">Togo<option value="Tokelau" data-id="213">Tokelau<option value="Tonga" data-id="214">Tonga<option value="Trinidad y Tobago" data-id="7">Trinidad and Tobago<option value="Tunez" data-id="216">Tunisia<option value="Turquía" data-id="217">Turkey<option value="Turkmenistán" data-id="218">Turkmenistan<option value="Tuvalu" data-id="220">Tuvalu<option value="Uganda" data-id="221">Uganda<option value="Ucrania" data-id="222">Ukraine<option value="Emiratos Árabes Unidos" data-id="223">United Arab Emirates<option value="Reino Unido" data-id="224">United Kingdom<option value="Estados Unidos - Islas vírgenes" data-id="226">United States - Virgin Islands<option value="Estados Unidos de América" data-id="37">United States of America<option value="Uruguay" data-id="227">Uruguay<option value="Uzbekistán" data-id="228">Uzbekistan<option value="Vanuatu" data-id="229">Vanuatu<option value="Ciudad de el Vaticano" data-id="230">Vatican City<option value="Venezuela" data-id="231">Venezuela<option value="Vietnam" data-id="232">Vietnam<option value="Wallis y Futuna" data-id="233">Wallis and Futuna<option value="Yemen" data-id="234">Yemen<option value="Zambia" data-id="235">Zambia<option value="Zimbabue" data-id="236">Zimbabwe

                    </select><br>

                    <label for="Email"><strong>E-mail:</strong> (*)</label><br>
                    <input class="micasilla" tabindex=2 name="Email" id="Email" type="text"><br> 
                    <div id="status"></div>


                    <label for="Movil"><strong>Celular:</strong></label><br>	
                    <input class="micasilla" tabindex=8 name="MovilNumero" id="MovilNumero" type="text" maxlength=13 onkeypress="return isNumberKey(event)">

                    <br>
                    <!--div class="checkbox checkbox-success checkbox-inline" style="" >
                            <input type="checkbox" id=checkboxdemo name="Demo" value=true checked><strong>Would you like to receive a Demo of our service?</strong>
                    </div-->



                    <br><br><label for="Mensaje" style=""><strong>Mensaje:</strong></label><br>
                    <textarea class="micasilla" style="height:100px;" tabindex=11 name="Mensaje" rows="5" id="Mensaje" cols="40" onfocus="this.value = this.value.replace('Write your comments here:', '')" placeholder="Su mensaje aqui:" minlength="10"></textarea>


                    <input class="miboton" tabindex=12 name="submit" type="submit" class="btnlarge" id="submit" onClick="
                            var o = document.getElementById('Mensaje');
                            o.value = o.value.replace('Write your comments here:', '')

                            //MM_validateForm('Nombre','','R','Email','','RisEmail','Pais','','R','Mensaje','','R','ServicioInteres','','R');
                            MM_validateForm('Nombre', '', 'R', 'Email', '', 'RisEmail', 'Pais', '', 'R', 'ServicioInteres', '', 'R');

                            //alert(document.getElementById('Mensaje').required)

                            if (document.getElementById('checkboxdemo').checked)
                            {

                                document.getElementById('Mensaje').required = false;

                            } else {

                                document.getElementById('Mensaje').required = true;
                            }

                            //return false;
                            return document.MM_returnValue;" value="Send">
                    </p>

                </form>



            </div>

            <div class="col-sm-4" >

                <br><br>
                <h4>Complete el formulario, solicite el Plan Demo y pruebe nuestro sistema.</h4>

                <div class="media">
                    <div class="media-left">
                        <img class="media-object" src="<?= base_url() ?>public/frontend/web/imgwa/contactodemogratis.png" alt="Contacto Demo Gratis">
                    </div>
                    <div class="media-body media-middle">
                        <h6 class="media-heading">Gs. 5.000</h6>
                        <h5 class="media-heading">GRATIS</h5>
                    </div>
                </div>

                <br><br>


                <br>
                <h6>Ventas:</h6>
                <h4>
                    <a style="color:#ffffff;" href="mailto:whasend@whasend.com?subject=[Whasend.com] Contacto" target=_blank>okivoicepy@gmail.com</a>
                </h4>

                <br><br><br><br><br><br>
                No comercializamos BASES DE DATOS. 


            </div>

        </div>

    </div>

</div>

<script>

$(document).ready(function () {


});

</script>
