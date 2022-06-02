<?php
$salida = array();
$out = $_GET["action"];
$relay = $_GET["relay"];
$python = "C:\Python\python.exe";
if($_GET["action"] == "on"){
	$command = "COM7 {$relay} on";
	exec($python." relay.py ".$command, $out);
	error_log(json_encode($out));
	if($out[0] == 1){
		echo json_encode(array("status" => "OK", "message" => $out[0]));	
	}else{
		echo json_encode(array("status" => "ERROR", "message" => $out[0]));
	}
	
	exit();
}else if($_GET["action"] == "off"){	
	$command = "COM7 {$relay} off";
	exec($python." relay.py ".$command, $out);
	if($out[0] == 1){
		echo json_encode(array("status" => "OK", "message" => $out[0]));	
	}else{
		echo json_encode(array("status" => "ERROR", "message" => $out[0]));
	}
}else if($_GET["action"] == "read"){
	$command = "COM7 {$relay}";
	exec($python." relayRead.py ".$command, $out);
	if($out[0] == 1){
		echo json_encode(array("status" => "OK", "message" => $out[0]));	
	}else{
		echo json_encode(array("status" => "ERROR", "message" => $out[0]));
	}
}

