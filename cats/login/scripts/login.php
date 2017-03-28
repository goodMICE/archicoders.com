<?php
$is_logined = false;

if(isset($_COOKIE['arhicspass']) && isset($_COOKIE['arhicslogin']))
	check_data($_COOKIE['arhicslogin'], $_COOKIE['arhicspass']);

if (isset($_POST['login']) && isset($_POST['password']))
	check_data($_POST['login'], $_POST['password']);

function check_data($login, $password){
	$login = strtolower(htmlspecialchars($login));
	$password = htmlspecialchars($login);
	if($login == "" || $password == "")
		return false;

	$db = mysqli_connect("localhost", "loginuser", "2ZdcY3yn7WDedAv8") or die("Error: ".mysqli_error($db));
	mysqli_select_db($db, "acoders") or die("Error: ".mysqli_error($db));
	$query = "SELECT salt, password FROM Profiles WHERE login='{$login}' OR mail='{$login}'";
	$result = mysqli_query($db, $query) or die("Error: ".mysqli_error($db));
	while ($line = mysqli_fetch_array($result, MYSQL_ASSOC)) {
		$salt = $line['salt'];
		if(crypt(crypt($password, $salt), $salt.$password.$salt) == $line['password']){
			setcookie("arhicslogin", $login, time()+24*60*60);
			setcookie("arhicspass", $password, time()+24*60*60);
			mysqli_free_result($db, $result);
			mysqli_close($db);
			$is_logined = true;
			header ('Location: http://www.arhicoders.com/');
			return true;
		}
	}
	$is_logined = false;
	return false;
}
?>