<?php
$salida = array();
$out = $_POST["action"];
$python = "C:\Python37-32\Python.exe";
if($_POST["action"] == "on"){
	$command = "COM6 0 on";
	exec($python." relay.py ".$command, $out);
	error_log(json_encode($out));
	if($out[0] == 1){
		echo json_encode(array("status" => "OK", "message" => $out[0]));	
	}else{
		echo json_encode(array("status" => "ERROR", "message" => $out[0]));
	}
	
	exit();
}else if($_GET["action"] == "off"){	
	$command = "COM6 0 off";
	exec($python." relay.py ".$command, $out);
	if($out[0] == 1){
		echo json_encode(array("status" => "OK", "message" => $out[0]));	
	}else{
		echo json_encode(array("status" => "ERROR", "message" => $out[0]));
	}
}else if($_GET["action"] == "read"){
	$command = "COM6 0";
	exec($python." relayRead.py ".$command, $out);
	if($out[0] == 1){
		echo json_encode(array("status" => "OK", "message" => $out[0]));	
	}else{
		echo json_encode(array("status" => "ERROR", "message" => $out[0]));
	}
}

