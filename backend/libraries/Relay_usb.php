<?php

class Relay_usb {

    private $action;
    private $scriptPath = RELAY_PATH;
    private $port;
    private $relayNumber;
    private $command;
    private $RELAY_ON = "on";
    private $RELAY_OFF = "off";
    private $RELAY_READ = "read";
    private $python = PYTHON_PATH;
	
    private $out = array();

    public function __construct($port = null, $relayNumber = null, $action = "read") {
        $this->CI = & get_instance();
        $this->port = $port;
        $this->relayNumber = $relayNumber;
        $this->action = $action;

        $this->setCommand($this->action);
    }

    public function exec_relay() {
        $response = array();
	try {
		//$e = exec($this->python . " " . $this->scriptPath . " " . $this->command, $response);
		$e = exec("py " . $this->scriptPath . " " . $this->command, $response);
	}catch(Exception $e){
		error_log("Exception> Ocurrio un error.. no se pudo ejectuar el relay ".$e->getMessage()."\n");
		return false;
	}
        
        return isset($response[0]) ? $response[0] : false;
    }

    public function setAction($action = "read") {
        $this->action = $action;
    }

    public function setCommand($action = null) {
        switch ($action) {
            case $this->RELAY_ON:
                $this->command = "{$this->port} {$this->relayNumber} {$this->RELAY_ON}";
                break;
            case $this->RELAY_OFF:
                $this->command = "{$this->port} {$this->relayNumber} {$this->RELAY_OFF}";
                break;
            case $this->RELAY_READ:
                $this->command = "{$this->port} {$this->relayNumber}";
                break;
            default:
                $this->command = "{$this->port} {$this->relayNumber}";
                break;
        }
    }

    public function getCommand() {
        return $this->command;
    }

    public function setScriptPath($script = null) {
        $this->scriptPath = $script;
    }

    public function setPort($port = null) {
        $this->port = $port;
    }

    public function setRelayNumber($relayNumber = null) {
        $this->relayNumber = $relayNumber;
    }

    public function getAction() {
        return $this->action;
    }

    public function getScriptPath() {
        return $this->scriptPath;
    }

    public function getPort() {
        return $this->port;
    }

    public function getRelayNumber() {
        return $this->relayNumber;
    }


}
