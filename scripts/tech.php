<?php

	if(isset($_POST['name']) && isset($_POST['mail']) && isset($_POST['textfield'])){
		$name = htmlspecialchars($_POST['name']);

		$mail = strtolower(htmlspecialchars($_POST['mail']));

		$text = htmlspecialchars($_POST['textfield']);
		$text = wordwrap($text, 70, "\r\n");

		$onbase = true;
		$lastrequest = 0;

		$db=mysqli_connect("localhost", "chatuser") or die("Error: ".mysqli_error($db));
		mysqli_select_db($db, "acoders") or die("Error".mysqli_error($db));
		$result = mysqli_query($db, "SELECT * FROM Profiles") or die("Error: ".mysqli_error($db));
		while ($line = mysqli_fetch_array($result, MYSQL_ASSOC)) {
			if($line['mail'] == $mail){
				$onbase = false;
				$lastrequest = $line['lastrequest'];
				break;
			}
		}
		if($onbase){
			$dt = new DateTime();
			$date= $dt->format('Y-m-d H:i:s');
			$lastrequest = time();
			mysqli_query($db, "INSERT profiles(id, name, mail, phone, joindate, role, lastrequest) VALUES(0,'{$name}','{$mail}','null','{$date}','null', {$lastrequest});") or die("Error".mysqli_error($db));
			mysqli_free_result($result);
			mysqli_close($db);
		}
		$onbase = true;

		if($lastrequest+30 < time())
			mail("hamel2517@gmail.com", "Для техподдержки ({$name})", $text, "From: $mail");
	}
?>