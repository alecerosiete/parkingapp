<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Registry extends CI_Controller {

    public function __construct() {
        parent::__construct();
    }

    public function index() {
        $this->show_regitry();
    }

    public function show_regitry() {
        $this->layout->setLayout('register');
        $this->layout->setTitle('Okivoice :: Registrese para obtener una cuenta');
        $this->layout->css(array(
            base_url() . "/public/backend/dist/css/custom.css",
            base_url() . "public/backend/plugins/iCheck/all.css",
        ));
        $this->layout->js(array(
            base_url() . "/public/backend/dist/js/pages/dashboard2.js",
            base_url() . "public/backend/plugins/iCheck/icheck.min.js",
        ));

        $country_select = $this->layout->element("country_select", null, true);
        $data['select_country'] = $country_select;

        $this->layout->view("/show_registry", $data);
    }

    public function registration() {
        $mapping = array('email', 'name', 'phone', 'terms');
        $data = input_read_post($this->input, $mapping);

        if ($data == null) {
            $this->session->set_flashdata('registerMessage', "No se encontraron datos para procesar su acceso");
            redirect('admin.php/registry', 301);
        }

        if ($this->form_validation->run("register") == FALSE) {
            $this->show_regitry();
            return;
        }

        $user = $this->profiles_model->find_first(array("username" => $data['email']));
        if ($user) {
            set_volatile_message_error("Usuario ya existe con este email");
            redirect('admin.php/registry', 301);
        } else {
            //save database new user and asign free credts
            $new_user = array(
                "username" => $data['email'],
                "fullname" => $data['name'],
                "phone" => $data['phone'],
                "userpass" => $this->generatePassword(),
                "usergroup" => "client"
            );
            //add new user
            $new_user_insert_result = $this->profiles_model->insert($new_user);
            if (!$new_user_insert_result) {
                set_volatile_message_error("No se pudo crear el usuario");
                redirect('admin.php/registry', 301);
            }
            //add credit to new user
            $credit_data = array(
                "userId" => $data['email'],
                "credit" => 0,
                "creditDemo" => DEFAULT_CREDIT_DEMO,
                "packId" => DEFAULT_CREDIT_TYPE,
            );
            $credit_insert_result = $this->credits_model->insert($credit_data);
            if (!$credit_insert_result) {
                set_volatile_message_error("No se pudo acreditar");
                redirect('admin.php/registry', 301);
            }
            if (!$this->sendMail($new_user)) {
                set_volatile_error("Ocurrio un error al tratar de enviar el email");
            } else {
                set_volatile_message("Su cuenta gratuita fue creada exitosamente. Las instrucciones para acceder fueron enviados a su e-mail: " . $new_user['username'] . ". Muchas Gracias. Okivoice.com<br>Verifique su buzon de entrada o en la carpeta SPAM  ");
                $notif = array(
                	"name"=>$data['name'],
                	"phone" => $data['phone'],
                	"clave" => $new_user['userpass'],
                	"email" => $data['email']
                );
                $this->sendMessageText($notif);
                $this->sendMessageVoice($notif);
            }
            redirect(base_url() . 'admin.php/authentication/show_login.php', 301);
        }
    }

    private function sendMail($new_user) {
        $to = $new_user['username'];
        $subject = 'Okivoice.com :: Plan Demo activado - Datos para ingresar';
        $message = "Estimado/a<br><br>";
        $message .= "Su cuenta de Okivoice se encuentra activada. Para acceder debe ingresar a la siguiente dirección:<br><br>";
        $message .= "Dirección: http://okivoice.com/admin.php<br>";
        $message .= "Email de Usuario: <strong>" . $new_user['username'] . "</strong><br>";
        $message .= "Contraseña: <strong>" . $new_user['userpass'] . "</strong><br><br>";
        $message .= "<a href='http://okivoice.com/admin.php'class='btn btn-primary' style='background-color:rgb(51,122,183);background-image:none;border-bottom-color:rgb(46,109,164);border-bottom-left-radius:2.99999976158142px;border-bottom-right-radius:2.99999976158142px;border-bottom-style:solid;border-bottom-width:1.11111116409302px;border-collapse:collapse;border-left-color:rgb(46,109,164);border-left-style:solid;border-left-width:1.11111116409302px;border-right-color:rgb(46,109,164);border-right-style:solid;border-right-width:1.11111116409302px;border-top-color:rgb(46,109,164);border-top-left-radius:2.99999976158142px;border-top-right-radius:2.99999976158142px;border-top-style:solid;border-top-width:1.11111116409302px;color:rgb(255,255,255);direction:ltr;display:inline-block;font-family:Roboto,sans-serif;font-size:18px;font-weight:normal;min-height:26.6666679382324px;line-height:26.6666679382324px;margin-bottom:0px;margin-top:10px;padding-bottom:10px;padding-left:16px;padding-right:16px;padding-top:10px;text-align:center;text-decoration:none;vertical-align:middle;white-space:nowrap;width:100.208335876465px'>INGRESAR</a><br><br>";
        $message .= "Recuerde que todos los planes incluyen: <br><br>";
        $message .= "- Acceso a la plataforma de autogestión<br>";
        $message .= "- Envío de Texto y Mensajes de voz";
        $message .= "- Filtros de optimización y depuración de bases de datos<br>";
        $message .= "- Variables de personalización<br>";
        $message .= "- Programación de envíos<br>";
        $message .= "- Soporte técnico<br>";
        $message .= "- Reportes<br><br><br>";
        $message .= "Si desea adquirir un paquete de creditos haga clic aquí:<br>";
        $message .= "<a href='http://mipago.org/okivoice'>mipago.org/okivoice</a><br><br><br>";
        $message .= "Por cuestiones éticas y legales nuestra empresa no provee ni comercializa base de datos.<br><br>";
        $message .= "Cualquier inquietud no dude en contactarse.<br><br>";
        $message .= "Atentamente,<br><br><br>";
        $message .= 'Saludos cordiales<br>El equipo de okivoice.com<br>';
        $message .= 'E-mail: info@okivoice.com<br>';
        $message .= 'Web: www.okivoice.com</br>';
        $message .= "<br><p style='color:#D9D9D9';font-size:10px>Nota de Confidencialidad. Las opiniones que se expresan en este correo electrónico son personales. Este correo y todos los archivos transmitidos con él, incluidas las respuestas y los reenvíos (que pueden incluir modificaciones) son confidenciales y de uso exclusivo del destinatario original, no se debe revelar ni utilizar por una persona distinta al destinatario ni copiar por medio alguno. Si usted ha recibido este correo por error, equivocación u omisión favor notificar en forma inmediata al remitente y eliminar dicho mensaje con sus anexos. La utilización, copia, impresión, retención, divulgación, reenvío o cualquier acción tomada sobre este mensaje y sus anexos queda estrictamente prohibida y puede ser sancionada legalmente.</p><br>";

        $from = 'From: Equipo de Okivoice.com <info@okivoice.com>';
        $replyTo = 'Reply-To: info@okivoice.com' . "\r\n";

        $headers = $from . "\r\n";
        $headers .= "Return-path: info@okivoice.com\r\n";
        $headers .= "MIME-Version: 1.0\r\n";
        $headers .= "Content-Type: text/html; charset=UTF-8\r\n";
        $headers .= $replyTo . "\r\n";

        //$headers .= 'X-Mailer: PHP/' . phpversion();

        error_log($message);
        try {
            if (mail($to, $subject, $message, $headers)) {
                return true;
            }else{
                return false;
            }
        } catch (Exception $e) {
            error_log($e . getMessage());
            return false;
        }
    }

    private function generatePassword() {
        $chars = "1234567890";
        $password = "";

        for ($i = 0; $i < 4; $i++) {
            $password .= substr($chars, rand(0, 9), 1);
        }

        return $password;
    }
    
    
    private function sendMessageText($data = null) {
        if (!$data['phone']) {
            return null;
        }

        $MessageBird = new \MessageBird\Client($this->config->item('API_KEY')); // Set your own API access key here.

        $Message = new \MessageBird\Objects\Message();
        $Message->originator = SMS_ORIGINATOR;
        $Message->recipients = array($data['phone']);
        $text = "Hola {$data['name']}, tu cuenta en www.okivoice.com ha sido creada con exito! Tu clave para ingresar es ".$data['clave'];
        $Message->body = $text;

        

        try {
            $MessageResult = $MessageBird->messages->create($Message);
            //var_dump($MessageResult);
        } catch (\MessageBird\Exceptions\AuthenticateException $e) {
            // That means that your accessKey is unknown
            //echo 'wrong login';
            return 401;
        } catch (\MessageBird\Exceptions\BalanceException $e) {
            // That means that you are out of credits, so do something about it.
            //echo 'no balance';
            return 25;
        } catch (\Exception $e) {
            error_log($e->getMessage());
            return 26;
        }
        return $MessageResult;
    }
    
    private function sendMessageVoice($data = null) {
        if (!$data['phone']) {
            return null;
        }

        $api_key = $this->config->item('API_KEY');
        $MessageBird = new \MessageBird\Client($api_key); // Set your own API access key here.

        $VoiceMessage = new \MessageBird\Objects\VoiceMessage();
        $VoiceMessage->recipients = array($data['phone']);
        $rate = 1;
        $voice = "Hola {$data['name']}, tu cuenta en okivoice.com ha sido creada con éxito y hace unos instantes te hemos enviado todas las instrucciones a {$data['email']}. Tu clave de acceso es {$data['clave']}. Al ingresar, te regalamos ".DEFAULT_CREDIT_DEMO." créditos para probar nuestra aplicación, que tengas un buen resto de jornada, hasta luego";
        $message = $voice;
        if (isset($rate)) {
            $prosody_start = "<prosody rate='-{$rate}0'>";
            $prosody_end = "</prosody>";
            $message = $prosody_start . $message . $prosody_end;
        }

        $VoiceMessage->body = $message;
        $VoiceMessage->language = "es-mx";
        $VoiceMessage->voice = "female";
        $VoiceMessage->ifMachine = 'continue'; // We don't care if it is a machine.
        $VoiceMessage->originator = VOICE_ORIGINATOR_RANDOM;

        try {
            $VoiceMessageResult = $MessageBird->voicemessages->create($VoiceMessage);
            //var_dump($VoiceMessageResult);
        } catch (\MessageBird\Exceptions\AuthenticateException $e) {
            // That means that your accessKey is unknown
            error_log(' send voice message wrong login');
            return 401;
        } catch (\MessageBird\Exceptions\BalanceException $e) {
            error_log(' send voice message no balance');
            return 25;
        } catch (\Exception $e) {
            error_log(' send voice message ' . $e->getMessage());
        }

        return $VoiceMessageResult;
    }


}
