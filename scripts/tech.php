<?php
	$lastrequest =  isset($_COOKIE['arhicslaction']) ? $_COOKIE['arhicslaction'] : 0;

	if(isset($_POST['name']) && isset($_POST['mail']) && isset($_POST['textfield'])){

		$name = htmlspecialchars($_POST['name']);
		$mail = strtolower(htmlspecialchars($_POST['mail']));
		$text = htmlspecialchars($_POST['textfield']);
		$text = wordwrap($text, 70, "\r\n");

		$db=mysqli_connect("localhost", "reguser", "HN2UWaMCQrJSLzKa") or die("Error: ".mysqli_error($db));
		mysqli_select_db($db, "acoders") or die("Error: ".mysqli_error($db));

		$request = "SELECT mail FROM Profiles WHERE mail='{$mail}'";
		$result = mysqli_query($db, $request) or die("Error: ".mysqli_error($db));
		
		if(!isset($result) || count($result) <= 0){
			$dt = new DateTime();
			$date= $dt->format('Y-m-d H:i:s');

			$request = "INSERT profiles(login, name, mail, joindate) VALUES('','{$name}','{$mail}','{$date}')";
			mysqli_query($db,$request)or die("Error".mysqli_error($db));
		}

		mysqli_free_result($result);
		mysqli_close($db);

		if($lastrequest+30 < time()){
			mail("hamel2517@gmail.com", "Для техподдержки ({$name})", $text, "From: $mail");
			setcookie('arhicslaction', time(), time()+60*60*24);
		}
	}
?>