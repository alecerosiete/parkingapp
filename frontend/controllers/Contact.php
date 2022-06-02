<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Contact extends CI_Controller {

  public function __construct() {
    parent::__construct();
  }

  public function index() {
    $this->layout->setDescription("Contacto Okivoice");
    $this->layout->setTitle(".:: Contacto Okivoice ::.");
    $this->layout->setKeywords("Okivoice, Okivoice masivos, marketing");
	$data = array();
    $this->layout->view('/contact',$data);
  }
  
  public function send(){
	$mapping = array("MovilNumero","Email","Pais","Nombre","Mensaje");
$data = input_read_post($this->input, $mapping);
  $to = WHASEND_CONTACT_EMAIL;
    $subject = 'Okivoice.com :: Nuevo mensaje del formulario de contacto';

    $message = 'NOMBRE: '.@$data["Nombre"]."<br>";
    $message .= 'EMAIL: '.@$data["Email"]."<br>";
    $message .= 'TELEFONO: '.@$data["MovilNumero"]."<br>";
    $message .= 'PAIS: '.@$data["Pais"]."<br>";
    $message .= 'MENSAJE: '.@$data["Mensaje"]."<br>";
        $from = 'From: Equipo de Okivoice.com <info@okivoice.com>';
        $replyTo = 'Reply-To: info@okivoice.com' . "\r\n";

        $headers = $from . "\r\n";
        $headers .= "Return-path: info@okivoice.com\r\n";
        $headers .= "MIME-Version: 1.0\r\n";
        $headers .= "Content-Type: text/html; charset=UTF-8\r\n";
        $headers .= $replyTo . "\r\n";

       // $headers .= 'X-Mailer: PHP/' . phpversion()."\r\n";


        try {
            if (mail($to, $subject, $message, $headers)) {
               $data = array("message"=>"Su mensaje fue enviado con exito!");
	       $this->layout->view('/contact',$data);
            }else{
                $data = array("message"=>"Ocurrio un error al tratar de enviar un mail de formulario de contacto ");
                $this->layout->view('/contact',$data);
            }
        } catch (Exception $e) {
            $data = array("message"=>"Ocurrio un error al tratar de enviar un mail de formulario de contacto ");
            $this->layout->view('/contact',$data);
        }


 }  

}
