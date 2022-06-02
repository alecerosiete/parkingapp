<?php
/*
require_once APPPATH . '/libraries/TicketPrinter/autoload.php';
use Mike42\Escpos\Printer;
use Mike42\Escpos\PrintConnectors\WindowsPrintConnector;

class Ticket_printer {

}
*/

if (!defined('BASEPATH')) exit('No direct script access allowed');
class Ticket_printer {
    public function __construct() {
	require_once __DIR__ . '/TicketPrinter/autoload.php';
    }
}
