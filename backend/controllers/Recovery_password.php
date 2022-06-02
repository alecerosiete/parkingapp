<?php

class Recovery_password extends CI_Controller {

    public function __construct() {

        parent::__construct();
    }

    public function index() {
        $this->show_recovery_password();
    }

    public function show_recovery_password($extradata = null) {
        $data['result'] = "failed";
        if ($extradata != null) {
            $data['result'] = $extradata;
        }
        $this->audits_model->insert(
            array(
              "username" => isset(current_user()->username) ? current_user()->username : "Desconocido",
              "userIp" => current_user_ip(),
              "activityName" => "Mostrar pagina para recuperacion de clave",
              "lastQuery" => $this->db->last_query(),
              "currentPage" => "Pagina de recuperacion de password",
              "currentMethod" => "Mostrar pagina para recuperacion de clave"
            )
        ); 
        $this->load->view("/recovery_password_view", $data);
    }

    public function recovery($data = null) {

        $mapping = array("email");
        $data = input_read_post($this->input, $mapping);
        set_volatile_message_error("Ingrese una direccion de email v&aacute;lida");
        assert_existence($data, base_url() . "admin.php/recovery_password");

        $account = $this->profiles_model->find_first(array("username" => $data['email']));

        set_volatile_message_error("Su e-mail no esta registrado en nuestra base de datos");
        assert_existence($account, base_url() . "admin.php/recovery_password");

        $new_pass = $this->generatePassword();

        $update_pass = $this->profiles_model->update_userpass($account->username, $new_pass);
        if ($update_pass) {
            try {
                $sendMailResult = $this->sendMail($account->username, $new_pass);
                error_log("SEND MAIL RESULT: " . $sendMailResult);
                if ($sendMailResult != TRUE) {
                    $result = "failed";
                    $this->audits_model->insert(
                        array(
                          "username" => isset(current_user()->username) ? current_user()->username : "Desconocido",
                          "userIp" => current_user_ip(),
                          "activityName" => "Fallo el envio de email que notifica la recuperacion de clave",
                          "lastQuery" => $this->db->last_query(),
                          "currentPage" => "Pagina de recuperacion de password",
                          "currentMethod" => "Send mail para recuperacion de clave"
                        )
                    );
                    set_volatile_message_error("Fallo el envio de email, intentelo mas tarde, o comuniquese con el Administrador del Sistema.. " . $sendMailResult);
                    $this->show_recovery_password($result);
                    return;
                }
            } catch (Exception $e) {
                    $this->audits_model->insert(
                        array(
                          "username" => isset(current_user()->username) ? current_user()->username : "Desconocido",
                          "userIp" => current_user_ip(),
                          "activityName" => "Fallo el envio de email que notifica la recuperacion de clave",
                          "lastQuery" => $this->db->last_query(),
                          "currentPage" => "Pagina de recuperacion de password",
                          "currentMethod" => "Send mail para recuperacion de clave"
                        )
                    );
                set_volatile_message_error("Fallo el envio de email, intentelo mas tarde, o comuniquese con el Administrador del Sistema");
                $result = "failed";
                $this->show_recovery_password($result);
                return;
            }
                    $this->audits_model->insert(
                        array(
                          "username" => isset(current_user()->username) ? current_user()->username : "Desconocido",
                          "userIp" => current_user_ip(),
                          "activityName" => "Se ha enviado exitosamente un E-mail a " . $account->username ,
                          "lastQuery" => $this->db->last_query(),
                          "currentPage" => "Pagina de recuperacion de password",
                          "currentMethod" => "Send mail para recuperacion de clave"
                        )
                    );            
            set_volatile_message_error("");
            $result = "success";
            set_volatile_message("Se ha enviado exitosamente un E-mail a " . $account->username . "\nA continuacion verifique su buzon de entrada para continuar con la recuperaci&oacute;n. Si no ha recibido verifique en la carpeta de SPAM");
        } else {
                    $this->audits_model->insert(
                        array(
                          "username" => isset(current_user()->username) ? current_user()->username : "Desconocido",
                          "userIp" => current_user_ip(),
                          "activityName" => "Ocurrio un problema al tratar de recuperar su Password" ,
                          "lastQuery" => $this->db->last_query(),
                          "currentPage" => "Pagina de recuperacion de password",
                          "currentMethod" => "Send mail para recuperacion de clave"
                        )
                    );  
            $result = "failed";
            set_volatile_message__error("Ocurrio un problema al tratar de recuperar su Password.");
        }
        redirect(base_url() . "admin.php/recovery_password");
        $this->show_recovery_password($result);
    }

    private function generatePassword() {
        $chars = "1234567890";
        $password = "";

        for ($i = 0; $i < 4; $i++) {
            $password .= substr($chars, rand(0, 9), 1);
        }

        return $password;
    }

    private function sendMail($username, $new_pass) {
        $to = $username;
        $subject = 'ParkingApp.sekur.com.py :: Recuperacion de Clave de Acceso';
        $message = 'Recientemente has solicitado recuperar tu Clave para acceder a tu cuenta en ParkingApp.sekur.com.py<br>';
        $message .= '<h2>Su nueva Clave es: ' . $new_pass . '</h2><br><hr>';
        $message .= 'Saludos cordiales<br>El equipo de ParkingApp.sekur.com.py<br>';
        $message .= 'E-mail: demo@sekur.com.py<br>';
        $message .= 'Web: ParkingApp.sekur.com.py</p>';

        $from = 'From: ParkingApp.sekur.com.py <demo@sekur.com.py>';
        $replyTo = 'Reply-To: demo@sekur.com.py' . "\r\n";

        $headers = $from . "\r\n";
        $headers .= "Return-path: demo@sekur.com.py\r\n";
        $headers .= "MIME-Version: 1.0\r\n";
        $headers .= "Content-Type: text/html; charset=UTF-8\r\n";
        $headers .= $replyTo . "\r\n";

        //'X-Mailer: PHP/' . phpversion();

        error_log($message);
        try {
            if (mail($to, $subject, $message, $headers)) {
                return true;
            };
        } catch (Exception $e) {
            error_log($e . getMessage());
            log_message('error', $e . getMessage());
            return $e . getMessage();
        }
    }

}
