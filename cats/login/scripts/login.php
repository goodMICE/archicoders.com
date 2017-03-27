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
		return;

	$db = mysqli_connect("localhost", "loginuser", "") or die("Error: ".mysqli_error($db));
	mysqli_select_db($db, "acoders") or die("Error: ".mysqli_error($db));
	$query = "SELECT * FROM chat WHERE (login='{$login}')";
	$result = mysqli_query($db, $query) or die("Error: ".mysqli_error($db));
	while ($line = mysqli_fetch_array($result, MYSQL_ASSOC)) {
		if(crypt(crypt($password, $line['salt']), $salt.$password.$salt) == $line['password']){
			setcookie("arhicslogin", $login, time()+24*60*60);
			setcookie("arhicspass", $password, time()+24*60*60);
			mysqli_free_result($db, $result);
			mysqli_close($db);
			$is_logined = true;
			return;
		}
	}
	$is_logined = false;
}
?>