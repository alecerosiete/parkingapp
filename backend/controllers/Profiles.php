<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Profiles extends CI_Controller {

    public function __construct() {
        parent::__construct();
    }

    public function index() {
        $this->list_profiles();
    }

    public function list_profiles() {
        assert_user();
        assert_role(ROLE_ADMIN);

        $this->layout->css(
                array(
                    base_url() . "public/backend/plugins/datatables/dataTables.bootstrap.css",
                    base_url() . "public/backend/plugins/iCheck/all.css")
        );
        $this->layout->js(
                array(
                    base_url() . "public/backend/plugins/iCheck/icheck.min.js")
        );
        $data = array();

        $data['profiles'] = $this->profiles_model->find();
        $this->audits_model->insert(
            array(
              "username" => isset(current_user()->username) ? current_user()->username : "Desconocido",
              "userIp" => current_user_ip(),
              "activityName" => "Visualizacion de Usuarios",
              "lastQuery" => $this->db->last_query(),
              "currentPage" => "Menu Perfiles",
              "currentMethod" => "Lista de Usuarios"
            )
        );
        $this->layout->view('/profile/list_profile', $data);
    }

    public function show_profile($id = null) {
        assert_user();
        assert_existence($id, "/admin.php/profiles/show_profile", "No se obtuvo el id de Usuario");


        $this->layout->setDescription("Pagina de Actualizacion de Perfil de Usuario");
        $this->layout->setTitle(".:: Perfil de Usuario ::.");

        $this->layout->js(array(
            base_url() . "public/backend/dist/js/pages/dashboard2.js",
            base_url() . "public/backend/bootstrap/js/fileinput.min.js",
            base_url() . "public/backend/bootstrap/js/fileinput_locale_es.js",
        ));
        $this->layout->css(array(
            base_url() . "public/backend/dist/css/fileinput.min.css",
        ));

        

        if (check_role(ROLE_ADMIN)) {            
            $data['usergroups'] = $this->usergroups_model->find();
            $profileData = $this->profiles_model->find_by_id($id);
        } else {
            $profileData = $this->profiles_model->find_first(array("username" => current_user()->username));
        }

        assert_existence($profileData, "/admin", "El usuario que intenta visualizar no es valido");

        $data['profileData'] = $profileData;

        $this->audits_model->insert(
            array(
              "username" => isset(current_user()->username) ? current_user()->username : "Desconocido",
              "userIp" => current_user_ip(),
              "activityName" => "Visualizacion de Usuario: ".$profileData->username,
              "lastQuery" => $this->db->last_query(),
              "currentPage" => "Menu Perfiles",
              "currentMethod" => "Ver datos de Usuarios"
            )
        );
        $this->layout->view('/profile/show_profile', $data);
    }

    public function new_profile() {
        assert_user();

        assert_role(ROLE_ADMIN);

        $this->layout->setDescription("Agregar Nuevo de Perfil de Usuario");
        $this->layout->setTitle(".:: Nuevo Usuario ::.");

        $this->layout->js(array(
            base_url() . "public/backend/dist/js/pages/dashboard2.js",
            base_url() . "public/backend/bootstrap/js/fileinput.min.js",
            base_url() . "public/backend/bootstrap/js/fileinput_locale_es.js",
        ));
        $this->layout->css(array(
            base_url() . "public/backend/dist/css/fileinput.min.css",
        ));

        $data['usergroups'] = $this->usergroups_model->find();
        
        $this->layout->view('/profile/new_profile', $data);
    }

    public function edit($id = null) {
        assert_user();
        assert_existence($id, "/admin.php/profiles/show_profile", "No se obtuvo el id de Usuario");

        $mapping = array('fullname', 'phone');

        if (check_role(ROLE_ADMIN)) {
            array_push($mapping, 'usergroup');
        } else {
            $currentUserData = $this->profiles_model->find_first(array("username" => current_user()->username));
            $id = $currentUserData->id;
        }

        $data = input_read_post($this->input, $mapping);

        if ($this->form_validation->run("update_profile") == FALSE) {
            $this->show_profile($id);
            return;
        }

        if (isset($_FILES['avatar']) && $_FILES['avatar']['error'] != UPLOAD_ERR_NO_FILE) {

            $imgsize = getimagesize($_FILES['avatar']['tmp_name']);
            $width = $imgsize[0];
            $height = $imgsize[1];
            if ($width < 127 && $height < 127) {
                set_volatile_error("La imagen debe ser 128px de ancho por 128px de alto" . $width . " " . $height);
                redirect("/admin.php/profiles/edit/" . $id, 301);
            }
            $data['avatar'] = $this->get_image_url($_FILES['avatar']);
        } else {
            $data['avatar'] = "";
        }

        $data['id'] = $id;
        $update_result = $this->profiles_model->update($data);

        if ($update_result) {
            $user = current_user();
            $new_datas = $this->profiles_model->find_session($user->username);
            assert_existence($new_datas, '/profile/new_profile', 'Ocurrió un error, no se pudó verificar el usuario');
            //$user_data = $this->profiles_model->find_first(array("username" => $user->username));
            $new_datas->user_id = $new_datas->id;
            $this->session->set_userdata('user', $new_datas);
            $this->audits_model->insert(
                array(
                  "username" => isset(current_user()->username) ? current_user()->username : "Desconocido",
                  "userIp" => current_user_ip(),
                  "activityName" => "Se edito con exito datos de Usuario: ".$data['fullname'],
                  "lastQuery" => $this->db->last_query(),
                  "currentPage" => "Menu Perfiles",
                  "currentMethod" => "Editar Usuarios"
                )
            );
            set_volatile_success("Usuario Editado exitosamente!");
            redirect("/admin.php/profiles/edit/" . $id, 301);
        } else {
            $this->audits_model->insert(
                array(
                  "username" => isset(current_user()->username) ? current_user()->username : "Desconocido",
                  "userIp" => current_user_ip(),
                  "activityName" => "Fallo al editar datos de Usuario: ".$data['fullname'],
                  "lastQuery" => $this->db->last_query(),
                  "currentPage" => "Menu Perfiles",
                  "currentMethod" => "Editar Usuarios"
                )
            );
            set_volatile_error("Ocurrio un error al tratar de editar el usuario, intentelo nuevamente");
            redirect("/admin.php/profiles/edit/" . $id, 301);
        }
    }

    public function create() {
        assert_user();

        assert_role(ROLE_ADMIN);

        $mapping = array('username', 'fullname', 'phone', 'userpass', 'usergroup');
        $data = input_read_post($this->input, $mapping);

        if ($this->form_validation->run("new_profile") == FALSE) {
            $this->new_profile();
            return;
        }

        if (isset($_FILES['avatar']) && $_FILES['avatar']['error'] != UPLOAD_ERR_NO_FILE) {
            $imgsize = getimagesize($_FILES['avatar']['tmp_name']);
            $width = $imgsize[0];
            $height = $imgsize[1];
            if ($width < 127 && $height < 127) {
                set_volatile_error("La imagen debe ser 128px de ancho por 128px de alto" . $width . " " . $height);
                redirect("/admin.php/profiles/", 301);
            }

            $data['avatar'] = $this->get_image_url($_FILES['avatar']);
        }


        $insert_result = $this->profiles_model->insert($data);
        if ($insert_result) {
            $this->audits_model->insert(
                array(
                  "username" => isset(current_user()->username) ? current_user()->username : "Desconocido",
                  "userIp" => current_user_ip(),
                  "activityName" => "Se creo con exito Usuario: ".@$data['username'],
                  "lastQuery" => $this->db->last_query(),
                  "currentPage" => "Menu Perfiles",
                  "currentMethod" => "Nuevo Usuario"
                )
            );
            set_volatile_success("Usuario creado con exito");
            redirect(base_url() . "admin.php/profiles/list_profiles");
        } else {
            $this->audits_model->insert(
                array(
                  "username" => isset(current_user()->username) ? current_user()->username : "Desconocido",
                  "userIp" => current_user_ip(),
                  "activityName" => "Ocurrio un error al crear Usuario: ".@$data['username'],
                  "lastQuery" => $this->db->last_query(),
                  "currentPage" => "Menu Perfiles",
                  "currentMethod" => "Nuevo Usuario"
                )
            );
            set_volatile_error("Ocurrio un error, intente de nuevo o contacte con el administrador");
            $this->new_profile();
        }
    }

    private function get_image_url($image_file) {

        $format = get_file_format($image_file);
        $img_format = get_extension_file($format);
        if ($img_format != ".jpg") {
            set_volatile_error("Imagen de perfil no valida, Ingrese una imagen en formato: JPG ");
            redirect("/admin.php/profiles/new_profile", 301);
        }
        $name = md5(rand(0, 100)) . $img_format;
        $image_path = MESSAGES_IMAGES_PATH . "/" . $name;

        $result_upload = upload_message_content($image_file, MESSAGES_IMAGES_PATH, $name, IMAGE);

        if ($result_upload) {
            set_volatile_error("Ocurrio un error al tratar de guardar la imagen: " . $result_upload);
            redirect("/admin.php/profiles/new_profile", 301);
        }
        return base_url() . $image_path;
    }

    public function show_update($id = null) {
        assert_user();

        $this->show_profile($id);
    }

    public function delete_profile($id = null) {
        assert_user();
        assert_role(ROLE_ADMIN);
        assert_existence($id, "/admin.php/profiles/show_profile", "No se obtuvo el id de Usuario");

        $delete_data = $this->profiles_model->find_by_id($id);
        if (current_user()->username == $delete_data->username) {
            set_volatile_error("No es posible eliminarse a si mismo");
            redirect(base_url() . "admin.php/profiles/list_profiles");
            return;
        }
        $delete_result = $this->profiles_model->delete($id);
        if ($delete_result) {
           $this->audits_model->insert(
                array(
                  "username" => isset(current_user()->username) ? current_user()->username : "Desconocido",
                  "userIp" => current_user_ip(),
                  "activityName" => "Usuario eliminado con exito: ".@$data['username'],
                  "lastQuery" => $this->db->last_query(),
                  "currentPage" => "Menu Perfiles",
                  "currentMethod" => "Eliminar Usuario"
                )
            );
            set_volatile_success("Usuario eliminado con exito");
        } else {
             $this->audits_model->insert(
                array(
                  "username" => isset(current_user()->username) ? current_user()->username : "Desconocido",
                  "userIp" => current_user_ip(),
                  "activityName" => "Ocurrio un error al tratar de eliminar el usuario: ".@$delete_data->username,
                  "lastQuery" => $this->db->last_query(),
                  "currentPage" => "Menu Perfiles",
                  "currentMethod" => "Eliminar Usuario"
                )
            );
            set_volatile_data("Ocurrio un error al tratar de eliminar el usuario con id " . $id);
        }
        redirect(base_url() . "admin.php/profiles/list_profiles");
        //$this->list_profiles();
    }

    public function change_password($id = null) {
        assert_user();
        if (!check_role(ROLE_ADMIN)) {
            $change_data = $this->profiles_model->find_first(array("username" => current_user()->username));
        } else {
            $change_data = $this->profiles_model->find_first(array("id" => $id));
        }

        $id = $change_data->id;
        assert_existence($id, "/admin.php", "No se obtuvo el id de Usuario");

        $mapping = array('userpass', 'retryUserpass');
        $data = input_read_post($this->input, $mapping);

        if ($this->form_validation->run("change_pwd") == FALSE) {
            $this->show_profile($id);
            return;
        }

        assert_existence($data, "/admin.php/profiles/show_profile/" . $id, "No se pudo modificar la contrase&ntilde;a, ingrese los datos requeridos.");

        $change_result = $this->profiles_model->change_password($id, $data['userpass']);


        if ($change_result) {
            $user = current_user();
            $new_datas = $this->profiles_model->find_session($user->username);
            assert_existence($new_datas, 'admin.php/profiles/show_profile/' . $id, 'Ocurrió un error, no se pudó verificar el usuario');
            $new_datas->user_id = $new_datas->id;
            $this->session->set_userdata('user', $new_datas);
            /* notif new user by email */

            try {
                $sendMailResult = $this->sendMailRecovery($change_data->username, $data['userpass']);
                error_log("SEND MAIL RESULT: " . $sendMailResult);
                if ($sendMailResult != TRUE) {
                    $result = "failed";
                    $this->audits_model->insert(
                        array(
                          "username" => isset(current_user()->username) ? current_user()->username : "Desconocido",
                          "userIp" => current_user_ip(),
                          "activityName" => "Fallo el envio de email al modificar contraseña: ".@$change_data->username,
                          "lastQuery" => $this->db->last_query(),
                          "currentPage" => "Menu Perfiles",
                          "currentMethod" => "Notificar Cambio de Contraseña"
                        )
                    );
                    set_volatile_error("Fallo el envio de email, intentelo mas tarde, o comuniquese con el Administrador del Sistema.. " . $sendMailResult);
                    redirect(base_url() . "admin.php/profiles/show_profile/" . $id);
                    return;
                } else {
                    $this->audits_model->insert(
                        array(
                          "username" => isset(current_user()->username) ? current_user()->username : "Desconocido",
                          "userIp" => current_user_ip(),
                          "activityName" => "Contrase&ntilde;a modificada con exito: ".@$change_data->username,
                          "lastQuery" => $this->db->last_query(),
                          "currentPage" => "Menu Perfiles",
                          "currentMethod" => "Modificar Contraseña"
                        )
                    );
                    set_volatile_success("Contrase&ntilde;a modificada con exito");
                    redirect(base_url() . "admin.php/profiles/show_profile/" . $id);
                }
            } catch (Exception $e) {
                $this->audits_model->insert(
                        array(
                          "username" => isset(current_user()->username) ? current_user()->username : "Desconocido",
                          "userIp" => current_user_ip(),
                          "activityName" => "Fallo el envio de email al modificar contraseña: ".@$change_data->username,
                          "lastQuery" => $this->db->last_query(),
                          "currentPage" => "Menu Perfiles",
                          "currentMethod" => "Notificar Cambio de Contraseña"
                        )
                    );
                set_volatile_error("Fallo el envio de email, intentelo mas tarde, o comuniquese con el Administrador del Sistema");
                $result = "failed";
                redirect(base_url() . "admin.php/profiles/show_profile/" . $id);
                return;
            }
        } else {
            $this->audits_model->insert(
                        array(
                          "username" => isset(current_user()->username) ? current_user()->username : "Desconocido",
                          "userIp" => current_user_ip(),
                          "activityName" => "Fallo el envio de email al modificar contraseña: ".@$change_data->username,
                          "lastQuery" => $this->db->last_query(),
                          "currentPage" => "Menu Perfiles",
                          "currentMethod" => "Notificar Cambio de Contraseña"
                        )
                    );
            set_volatile_error("Error al tratar de cambiar la contrase&ntilde; intentelo mas tarde o contacte con el administrador");
            redirect(base_url() . "admin.php/profiles/show_profile/" . $id);
        }
    }

//  form validation functions  
    public function check_username($username = null) {
        assert_existence($username, "/admin.php/profiles/show_profile", "No se obtuvo el id de Usuario");

        if ($this->profiles_model->find_first(array("username" => $username))) {
            $this->form_validation->set_message('check_username', 'El Nombre de Usuario ya existe, ingrese otro nombre');
            return FALSE;
        } else {
            return TRUE;
        }
    }

    public function check_usergroup($group) {

        if (!$this->usergroups_model->find_by_id($group)) {
            $this->form_validation->set_message('check_usergroup', 'El Nombre de Grupo no es valido, seleccione un nombre de grupo valido');
            return FALSE;
        } else {
            return TRUE;
        }
    }

    

    private function sendMail($new_user) {
        $to = $new_user['username'];
        $subject = 'ParkingApp ::  Datos para ingresar';
        $message = "Estimado/a<br><br>";
        $message .= "Para acceder debe ingresar a la siguiente dirección:<br><br>";
        $message .= "Dirección: http://parkingapp/admin.php<br>";
        $message .= "Email de Usuario: <strong>" . $new_user['username'] . "</strong><br>";
        $message .= "Contraseña: <strong>" . $new_user['userpass'] . "</strong><br><br>";
        $message .= "<a href='http://parkingapp/admin.php'class='btn btn-primary' style='background-color:rgb(51,122,183);background-image:none;border-bottom-color:rgb(46,109,164);border-bottom-left-radius:2.99999976158142px;border-bottom-right-radius:2.99999976158142px;border-bottom-style:solid;border-bottom-width:1.11111116409302px;border-collapse:collapse;border-left-color:rgb(46,109,164);border-left-style:solid;border-left-width:1.11111116409302px;border-right-color:rgb(46,109,164);border-right-style:solid;border-right-width:1.11111116409302px;border-top-color:rgb(46,109,164);border-top-left-radius:2.99999976158142px;border-top-right-radius:2.99999976158142px;border-top-style:solid;border-top-width:1.11111116409302px;color:rgb(255,255,255);direction:ltr;display:inline-block;font-family:Roboto,sans-serif;font-size:18px;font-weight:normal;min-height:26.6666679382324px;line-height:26.6666679382324px;margin-bottom:0px;margin-top:10px;padding-bottom:10px;padding-left:16px;padding-right:16px;padding-top:10px;text-align:center;text-decoration:none;vertical-align:middle;white-space:nowrap;width:100.208335876465px'>INGRESAR</a><br><br>";

        $from = 'From: Equipo de ParkingApp <info@ParkingApp.com>';
        $replyTo = 'Reply-To: info@ParkingApp.com' . "\r\n";

        $headers = $from . "\r\n";
        $headers .= "Return-path: info@ParkingApp.com\r\n";
        $headers .= "MIME-Version: 1.0\r\n";
        $headers .= "Content-Type: text/html; charset=UTF-8\r\n";
        $headers .= $replyTo . "\r\n";

        //$headers .= 'X-Mailer: PHP/' . phpversion();

        error_log($message);
        try {
            if (mail($to, $subject, $message, $headers)) {
                return true;
            } else {
                return false;
            }
        } catch (Exception $e) {
            error_log($e . getMessage());
            return false;
        }
    }


    private function sendMailRecovery($username, $new_pass) {
        $to = $username;
        $subject = 'ParkingApp :: Recuperacion de Clave de Acceso';
        $message = 'Recientemente has solicitado recuperar tu Clave para acceder a tu cuenta<br>';
        $message .= '<h2>Su nueva Clave es: ' . $new_pass . '</h2><br><hr>';


        $from = 'From: ParkingApp.com <info@ParkingApp.com>';
        $replyTo = 'Reply-To: info@ParkingApp.com' . "\r\n";

        $headers = $from . "\r\n";
        $headers .= "Return-path: info@ParkingApp.com\r\n";
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
            //error_log($e . getMessage());
            //log_message('error', $e . getMessage());
            return $e . getMessage();
        }
    }

}
