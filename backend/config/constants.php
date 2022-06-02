<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/** CONFIGURACION PYTHON WINDOWS **/
define('PYTHON_PATH','C:\Users\parking\AppData\Roaming\Microsoft\Windows\Start Menu\Programs\Python 3.8');
define('RELAY_PATH','C:\wamp64\www\parking.sekur.com.py\backend\third_party\relay_usb\relay.py');

define('RELAY_PORT_OUTPUT','COM3'); //puerto usb asociado al relay usb

/*Activa la verificacion si el ticket se pago en 
caja (solo cuando hay conexion entre el cajero y la
barrera de salida) 0: inactivo*/

define('VERIFY_ON_EXIT',1);

/* codigo ticket que ya se utilizo para salir */
define('TICKET_OUT',1);

/* tiempo de expiracion (en minutos) del ticket para salir, 0: desactivado*/
define('TIME_TO_GO',0);

/* ticket pagado */
define('PAID_OUT_CODE',1);


define('RELAY_NUMBER_OUTPUT','0'); //numero de relay de la placa
define('RELAY_NUMBER_INCOMING','0'); //numero de relay de la placa
define('BAR_TIME','1'); //se espera 5 segundos para desactivar el rele

define('RELAY_ON',"on");
define('RELAY_OFF',"off");
define('RELAY_READ',"read");

/* urls */
define('LOGIN_URL', 'admin.php/authentication/show_login');
define('LOGOUT_URL', 'admin.php/authentication/logout');

define('MESSAGES_IMAGES_PATH','public/frontend/images/profiles');
define('IMAGE','public/backend/dist/img/avatar5.png');
/* rate type */
define('FREE',0);
define('FRACTION',1);
define('HOUR',2);
define('DAY',3);
define('MONTH',4);



/* roles */
define('ROLE_ROOT', 'role_root');
define('ROLE_ADMIN', 'role_admin');
define('ROLE_USER', 'role_user');
define('ROLE_VIEW', 'role_view');


/*
  |--------------------------------------------------------------------------
  | File and Directory Modes
  |--------------------------------------------------------------------------
  |
  | These prefs are used when checking and setting modes when working
  | with the file system.  The defaults are fine on servers with proper
  | security, but you may wish (or even need) to change the values in
  | certain environments (Apache running a separate process for each
  | user, PHP under CGI with Apache suEXEC, etc.).  Octal values should
  | always be used to set the mode correctly.
  |
 */
define('FILE_READ_MODE', 0644);
define('FILE_WRITE_MODE', 0666);
define('DIR_READ_MODE', 0755);
define('DIR_WRITE_MODE', 0755);

/*
  |--------------------------------------------------------------------------
  | File Stream Modes
  |--------------------------------------------------------------------------
  |
  | These modes are used when working with fopen()/popen()
  |
 */

define('FOPEN_READ', 'rb');
define('FOPEN_READ_WRITE', 'r+b');
define('FOPEN_WRITE_CREATE_DESTRUCTIVE', 'wb'); // truncates existing file data, use with care
define('FOPEN_READ_WRITE_CREATE_DESTRUCTIVE', 'w+b'); // truncates existing file data, use with care
define('FOPEN_WRITE_CREATE', 'ab');
define('FOPEN_READ_WRITE_CREATE', 'a+b');
define('FOPEN_WRITE_CREATE_STRICT', 'xb');
define('FOPEN_READ_WRITE_CREATE_STRICT', 'x+b');

/*
  |--------------------------------------------------------------------------
  | Display Debug backtrace
  |--------------------------------------------------------------------------
  |
  | If set to TRUE, a backtrace will be displayed along with php errors. If
  | error_reporting is disabled, the backtrace will not display, regardless
  | of this setting
  |
 */
define('SHOW_DEBUG_BACKTRACE', TRUE);

/*
  |--------------------------------------------------------------------------
  | Exit Status Codes
  |--------------------------------------------------------------------------
  |
  | Used to indicate the conditions under which the script is exit()ing.
  | While there is no universal standard for error codes, there are some
  | broad conventions.  Three such conventions are mentioned below, for
  | those who wish to make use of them.  The CodeIgniter defaults were
  | chosen for the least overlap with these conventions, while still
  | leaving room for others to be defined in future versions and user
  | applications.
  |
  | The three main conventions used for determining exit status codes
  | are as follows:
  |
  |    Standard C/C++ Library (stdlibc):
  |       http://www.gnu.org/software/libc/manual/html_node/Exit-Status.html
  |       (This link also contains other GNU-specific conventions)
  |    BSD sysexits.h:
  |       http://www.gsp.com/cgi-bin/man.cgi?section=3&topic=sysexits
  |    Bash scripting:
  |       http://tldp.org/LDP/abs/html/exitcodes.html
  |
 */
define('EXIT_SUCCESS', 0); // no errors
define('EXIT_ERROR', 1); // generic error
define('EXIT_CONFIG', 3); // configuration error
define('EXIT_UNKNOWN_FILE', 4); // file not found
define('EXIT_UNKNOWN_CLASS', 5); // unknown class
define('EXIT_UNKNOWN_METHOD', 6); // unknown class member
define('EXIT_USER_INPUT', 7); // invalid user input
define('EXIT_DATABASE', 8); // database error
define('EXIT__AUTO_MIN', 9); // lowest automatically-assigned error code
define('EXIT__AUTO_MAX', 125); // highest automatically-assigned error code
