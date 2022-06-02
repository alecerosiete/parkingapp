<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

if (!function_exists('active_link')) {

    function active_link($controller) {
        $CI = & get_instance();
        $class = $CI->router->fetch_class();
        return ($class == $controller) ? 'active' : '';
    }

}


if (!function_exists('get_volatile_message')) {

    function get_volatile_message($type = "alert-info") {
        $CI = &get_instance();
        $notif = $CI->session->flashdata('volatile_data_message');
	$CI->session->set_flashdata("volatile_data_message","");

        if ($notif) {
            $notif = "<div class='alert " . $type . " '><a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>" . $notif . "</div>";
        }
        return $notif;
    }

}

if (!function_exists('set_volatile_message')) {

    function set_volatile_message($msg) {
        $CI = &get_instance();
        $CI->session->set_flashdata('volatile_data_message', $msg);
    }

}

if (!function_exists('get_volatile_message_error')) {

    function get_volatile_message_error() {
        $CI = &get_instance();
        $notif = $CI->session->flashdata('volatile_data_message_error');
	$CI->session->set_flashdata("volatile_data_message_error","");
        if ($notif) {
            $notif = "<div class='alert alert-danger'><a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>" . $notif . "</div>";
        }
        return $notif;
    }

}


if (!function_exists('set_volatile_message_error')) {

    function set_volatile_message_error($msg) {
        $CI = &get_instance();
        $CI->session->set_flashdata('volatile_data_message_error', $msg);
    }

}


if (!function_exists('get_volatile_data')) {

    function get_volatile_data() {
        $CI = &get_instance();
        $notif = $CI->session->flashdata('volatile_data_info');
	$CI->session->set_flashdata("volatile_data_info","");
        if ($notif) {
            $template = "$.notify({"
                    . "icon: 'glyphicon glyphicon-info-sign',"
                    . " message: '" . $notif . "'},"
                    . "{type: 'info'"
                    . " });";
        } else {
            $template = "";
        }
        return $template;
    }

}

if (!function_exists('set_volatile_data')) {

    function set_volatile_data($msg) {
        $CI = &get_instance();
        $CI->session->set_flashdata('volatile_data_info', $msg);
    }

}
if (!function_exists('get_volatile_error')) {

    function get_volatile_error() {
        $CI = & get_instance();
        $notif = $CI->session->flashdata('volatile_data_danger');
	$CI->session->set_flashdata("volatile_data_danger","");

        if ($notif) {
            $template = "$.notify({"
                    . "icon: 'glyphicon glyphicon-alert',"
                    . " message: '" . $notif . "'} ,"
                    . "{type: 'error'"
                    . " });";
        } else {
            $template = "";
        }
        return $template;
    }

}

if (!function_exists('set_volatile_error')) {

    function set_volatile_error($msg) {
        $CI = & get_instance();
        $CI->session->set_flashdata('volatile_data_danger', $msg);
    }

}

if (!function_exists('get_volatile_warning')) {

    function get_volatile_warning() {
        $CI = & get_instance();
        $notif = $CI->session->flashdata('volatile_data_warn');
	$CI->session->set_flashdata("volatile_data_warn","");
        if ($notif) {
            $template = "$.notify({"
                    . "icon: 'glyphicon glyphicon-warning-sign',"
                    . " message: '" . $notif . "'} ,"
                    . "{type: 'warning'"
                    . " });";
        } else {
            $template = "";
        }
        return $template;
    }

}

if (!function_exists('set_volatile_success')) {

    function set_volatile_success($msg) {
        $CI = & get_instance();
        $CI->session->set_flashdata('volatile_data_success', $msg);
    }

}

if (!function_exists('get_volatile_success')) {

    function get_volatile_success() {
        $CI = & get_instance();
        $notif = $CI->session->flashdata('volatile_data_success');
        $CI->session->set_flashdata('volatile_data_success','');

        if ($notif) {
            $template = "$.notify({"
                    . "icon: 'glyphicon glyphicon-ok',"
                    . " message: '" . $notif . "'} ,"
                    . "{type: 'success'"
                    . " });";
        } else {
            $template = "";
        }
        return $template;
    }

}

if (!function_exists('set_volatile_warning')) {

    function set_volatile_warning($msg) {
        $CI = & get_instance();
        $CI->session->set_flashdata('volatile_data_warn', $msg);
    }

}


if (!function_exists('current_user')) {

    function current_user() {
        $CI = & get_instance();
        return $CI->session->userdata('user');
    }

}


if (!function_exists('check_user')) {

    function check_user() {
        $CI = & get_instance();
        $user = $CI->session->userdata('user');
        return $user && $user->username;
    }

}

if (!function_exists('assert_user')) {

    function assert_user() {
        if (!check_user()) {
            redirect(LOGOUT_URL);
        }
    }

}

if (!function_exists('check_role')) {

    function check_role($role) {
        $CI = & get_instance();
        $user = $CI->session->userdata('user');
        return $user && $user->$role ? true : false;
    }

}

if (!function_exists('check_roles')) {

    function check_roles($roles) {
        $CI = & get_instance();
        $user = $CI->session->userdata('user');
        foreach ($roles as $role) {
            if ($user && $user->$role ? false : true) {
                return false;
            }
        }

        return true;
    }

}

if (!function_exists('check_some_role')) {

    function check_some_role($roles) {
        $CI = & get_instance();
        $user = $CI->session->userdata('user');
        foreach ($roles as $role) {
            if ($user && $user->$role ? true : false) {
                return true;
            }
        }

        return false;
    }

}

if (!function_exists('assert_role')) {

    function assert_role($role) {
        if (!check_role($role)) {
            redirect(LOGOUT_URL);
        }
    }

}

if (!function_exists('assert_roles')) {

    function assert_roles($roles) {
        if (!check_roles($roles)) {
            redirect(LOGOUT_URL);
        }
    }

}

if (!function_exists('assert_some_role')) {

    function assert_some_role($roles) {
        if (!check_some_role($roles)) {
            redirect(LOGOUT_URL);
        }
    }

}

if (!function_exists('assert_realm')) {

    function assert_realm($userrealm, $entityrealm, $agentrealm) {

        if ($userrealm == $entityrealm) {
            return;
        } else if ($userrealm == $agentrealm && check_role(ROLE_AGENT)) {
            return;
        } else if (check_role(ROLE_STAFF)) {
            return;
        }

        redirect(LOGOUT_URL, 301);
    }

}

if (!function_exists('assert_existence')) {

    function assert_existence($value, $page = null, $message = null) {
        if ($value == null) {
            if ($message) {
                set_volatile_warning($message);
            }

            if ($page == null) {
                redirect(LOGOUT_URL, 301);
            } else {
                redirect($page);
            }
        }
    }

}

if (!function_exists('assert_insert')) {

    function assert_insert($value, $page = null, $message = null) {
        if ($value == 0) {
            if ($message) {
                set_volatile_data($message);
            }

            if ($page == null) {
                redirect(LOGOUT_URL, 301);
            } else {
                redirect($page);
            }
        }
    }

}

if (!function_exists('assert_update')) {

    function assert_update($value, $page = null, $message = null) {
        if (!$value) {
            if ($message) {
                set_volatile_data($message);
            }

            if ($page == null) {
                redirect(LOGOUT_URL, 301);
            } else {
                redirect($page);
            }
        }
    }

}



/* form helper */

if (!function_exists('input_read_post')) {

    function input_read_post($input, $mapping = array()) {

        if ($input->post()) {
            $result = array();

            foreach ($mapping as $k => $v) {
                $key = gettype($k) == "integer" ? $v : $k;
                $val = $input->post($v, true);
                if ($val != "") {
                    $result[$key] = $val;
                }
            }

            return $result;
        }

        return null;
    }

}


/* database helper */

if (!function_exists('db_mapping_filter')) {

    function db_mapping_filter($input, $mapping = array()) {
        if (!is_array($input)) {
            return array();
        }

        // TODO...
        $filter = array();
        foreach ($mapping as $k => $v) {
            if (isset($input[$v])) {
                $mapping[$k] = $input[$v];
            } else if (isset($input[$k])) {
                $mapping[$k] = $input[$k];
            }
        }

        return $filter;
    }

}

if (!function_exists('db_mapping_and_set')) {

    function db_mapping_and_set($db, $input, $filter = array()) {
        if ($input) {
            foreach ($filter as $k) {
                if (isset($input[$k])) {
                    $db->set($k, $input[$k]);
                }
            }
        }
    }

}


if (!function_exists('db_mapping_result')) {

    function db_mapping_result($input, $mapping = array()) {
        if ($input) {
            $result = array();

            //TODO modificar!
            foreach ($mapping as $k => $v) {
                $val = $input->post($v, true);
                if ($val != "") {
                    $result[$k] = $val;
                }
            }

            return $result;
        }

        return null;
    }

}

if (!function_exists('create_dir')) {

    function create_dir($dir) {
        mkdir($dir, 0777, true);
    }

}


if (!function_exists('validate_date')) {

    function validate_date($date = null) {
        $a_date = explode("/", $date);
        if (count($a_date) != 3) {
            return "";
        } else if ($a_date[0] < 1 || $a_date[0] > 31) {
            return "";
        } else if ($a_date[1] < 1 || $a_date[1] > 12) {
            return "";
        } else if ($a_date[2] < date("Y")) {
            return "";
        }
        return $a_date[2] . "-" . $a_date[1] . "-" . $a_date[0];
    }

}


if (!function_exists('get_extension_file')) {

    function get_extension_file($format = null) {
        error_log("FORMATO : " . $format);
        $extension = ".jpg";
        switch ($format) {
            case "image/jpeg":
                $extension = ".jpg";
                break;
            case "image/png":
                $extension = ".png";
                break;
            case "image/gif":
                $extension = ".gif";
                break;
            case "video/mp4":
                $extension = ".mp4";
                break;
            default:
                break;
        }
        return $extension;
    }

}
if (!function_exists('upload_message_content')) {

    function upload_message_content($file = null, $path = null, $file_name = null, $content_type = null) {
        try {
            if (!isset($file['error'])) {
                throw new RuntimeException('Ocurrió un error al subir el logo');
            }
            switch ($file['error']) {
                case UPLOAD_ERR_OK:
                    break;
                case UPLOAD_ERR_NO_FILE:
                    throw new RuntimeException('Parece ser que no ha seleccionado ninguna imagen.');
                case UPLOAD_ERR_INI_SIZE:
                case UPLOAD_ERR_FORM_SIZE:
                    throw new RuntimeException('El archivo seleccionado excede el tamaño permitido.');
                default:
                    throw new RuntimeException('Error desconocido.');
            }

            //tamaño maximo
            if ($file['size'] > 6000000) {
                throw new RuntimeException('El archivo seleccionado excede el tamaño permitido.');
            }

            $format = get_file_format($file);

            if ($content_type == IMAGE) {
                $types = array(
                    'img' => array('image/jpeg', 'image/jpg')
                );
            } elseif ($content_type == VIDEO) {
                $types = array(
                    'video' => array('video/mp4')
                );
            }
            if (false === $ext = recursive_array_search($format, $types)) {
                throw new RuntimeException('El formato de su imagen no es válida. Seleccione JPG');
            }

            if (!move_uploaded_file($file['tmp_name'], sprintf('%s', $path . "/" . $file_name))) {
                throw new RuntimeException('Ocurrió un error al tratar de guardar la imagen');
            }
        } catch (RuntimeException $e) {
            return $e->getMessage();
        }
    }

}



if (!function_exists('get_file_format')) {

    function get_file_format($file = null) {
        $finfo = new finfo(FILEINFO_MIME_TYPE);
        return $finfo->file($file['tmp_name']);
    }

}

if (!function_exists('recursive_array_search')) {

    function recursive_array_search($needle, $haystack) {
        foreach ($haystack as $key => $value) {
            if ($needle === $value OR ( is_array($value) && recursive_array_search($needle, $value))) {
                return true;
            }
        }
        return false;
    }

}


if (!function_exists('convert_datetime')) {

    function convert_datetime($datetime = null) {
        $a_datetime = explode("-", $datetime);
        return $a_datetime[2] . "/" . $a_datetime[1] . "/" . $a_datetime[0];
    }

}


if (!function_exists('current_user_ip')) {

    function current_user_ip() {

        if ($_SERVER) {
            if (isset($_SERVER["HTTP_X_FORWARDED_FOR"]) && $_SERVER["HTTP_X_FORWARDED_FOR"]) {
                $realip = $_SERVER["HTTP_X_FORWARDED_FOR"];
            } elseif (isset($_SERVER["HTTP_CLIENT_IP"]) && $_SERVER["HTTP_CLIENT_IP"]) {
                $realip = $_SERVER["HTTP_CLIENT_IP"];
            } else {
                $realip = $_SERVER["REMOTE_ADDR"];
            }
        } else {
            if (getenv('HTTP_X_FORWARDED_FOR')) {
                $realip = getenv('HTTP_X_FORWARDED_FOR');
            } elseif (getenv('HTTP_CLIENT_IP')) {
                $realip = getenv('HTTP_CLIENT_IP');
            } else {
                $realip = getenv('REMOTE_ADDR');
            }
        }
        return $realip;
    }

}

if (!function_exists('diffDate')) {
    function diffDate($in = null, $out = null) {
        if ($in == null || $out == null) {
            return null;
        }

        $dteStart = new DateTime($in);
        $dteEnd = new DateTime($out);

        $dteDiff = $dteStart->diff($dteEnd);
        $day = $dteDiff->format("%D");
        if ($day > 0) {
            $diff = array(
                "days" => $day,
                "hours" => $dteDiff->format("%H"),
                "mins" => $dteDiff->format("%I"),
            );
        } else {
            $diff = array(
                "days" => 0,
                "hours" => $dteDiff->format("%H"),
                "mins" => $dteDiff->format("%I"),
            );
        }

        return $diff;
    }

}

if (!function_exists('getBarCodeDate')) {
    function getBarCodeDate($barCode = null) {
        if ($barCode == null) {
            return null;
        }

        //0020190520032700
        $year = substr($barCode, 2, 4);
        $month = substr($barCode, 6, 2);
        $day = substr($barCode, 8, 2);
        $hour = substr($barCode, 10, 2);
        $min = substr($barCode, 12, 2);
        $sec = substr($barCode, 14, 2);
        
        return $year . "-" . $month . "-" . $day . " " . $hour . ":" . $min . ":" . $sec;
    }
}

if (!function_exists('getRandomBarcode')) {
    function getRandomBarcode() {
        //10190520032700 cuando empieza con 10 es ticket extraviado
              
        return "10".date("YmdHis");
    }
}
