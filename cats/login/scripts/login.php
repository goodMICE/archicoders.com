<?php

if(isset($_COOKIE['arhicspass']) && isset($_COOKIE['arhicslogin'])){
	$is_logined = check_data($_COOKIE['arhicslogin'], $_COOKIE['arhicspass']);
}

if (isset($_POST['llogin']) && isset($_POST['lpassword'])){
	$is_logined = check_data($_POST['llogin'], $_POST['lpassword']);
}

if($is_logined)
	header ('Location: http://www.arhicoders.com/');

function check_data($login, $password){
	$login = strtolower(htmlspecialchars($login));
	$password = htmlspecialchars($password);
	if($login == "" || $password == "")
		return false;

	$db = mysqli_connect("localhost", "loginuser", "2ZdcY3yn7WDedAv8") or die("Error: ".mysqli_error($db));
	mysqli_select_db($db, "acoders") or die("Error: ".mysqli_error($db));
	$query = "SELECT salt, password FROM Profiles WHERE login='{$login}' OR mail='{$login}'";
	$result = mysqli_query($db, $query) or die("Error: ".mysqli_error($db));
	while ($line = mysqli_fetch_array($result, MYSQL_ASSOC)) {
		$salt = $line['salt'];
		$cpass = md5(md5($password, $salt), $salt.$password.$salt);
		if($cpass == $line['password']){
			setcookie("arhicslogin", $login, time()+24*60*60);
			setcookie("arhicspass", $password, time()+24*60*60);
			mysqli_free_result($result);
			mysqli_close($db);
			return true;
		}
	}
	return false;
}
?>