<?php
include 'index.html';
include '/scripts/message.php';

reload();

if(isset($_POST['mBox'])){
	$mes = $_POST['mBox'];
	if($mes == "" || $mes == "Message"){
		echo "<script type=\"text/javascript\">alert(\"Enter message!\");</script>";
	}else{
		sendMessage($mes);
	}
}
?>