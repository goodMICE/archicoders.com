<?php
include './../login/scripts/login.php';

if(isset($_COOKIE['arhicspass']) && isset($_COOKIE['arhicslogin']))
	check_data($_COOKIE['arhicslogin'], $_COOKIE['arhicspass']);
if($is_logined)
	header ('Location: http://www.arhicoders.com/');

$mail_free = false;
$login_free = false;

$db=mysqli_connect("localhost", "reguser", "HN2UWaMCQrJSLzKa") or die("Error: ".mysqli_error($db));
mysqli_select_db($db, "acoders") or die("Error".mysqli_error($db));
$result = mysqli_query($db, "SELECT login, mail FROM Profiles") or die("Error: ".mysqli_error());

if(isset($_POST['password']) && isset($_POST['password2'])){
	$password = htmlspecialchars($_POST['password']);
	$password2 = htmlspecialchars($_POST['password2']);
	if($password !== $password2){
		echo "Password isn't correct!";
		$pass_free = false;
		return;
	}
	$pass_free = true;
}

if(isset($_POST['login'])){
	$login = strlower(htmlspecialchars($_POST['login']));
	if($login == ""){
		echo "Login is null!";
		$login_free = false;
		return;
	}
	while ($line = mysqli_fetch_array($result, MYSQL_ASSOC)) {
		if($line['login'] == $login){
			echo "Login already used!";
			$login_free = false;
			break;
		}
	}
	echo "Login is free!";
	$login_free = true;
}

if(isset($_POST['mail'])){
	$mail = strlower(htmlspecialchars($_POST['mail']));
	if($mail == ""){
		echo "E-mail is null!";
		$mail_free = false;
		return;
	}
	while ($line = mysqli_fetch_array($result, MYSQL_ASSOC)) {
		if($line['mail'] == $mail && $line['login'] != ""){
			echo "E-mail already used!";
			$mail_free = false;
			break;
		}
	}
	echo "E-mail is free!";
	$mail_free = true;
}

function salt_gen(){
	$arr = array('a','b','c','d','e','f',
                 'g','h','i','j','k','l',
                 'm','n','o','p','r','s',
                 't','u','v','x','y','z',
                 'A','B','C','D','E','F',
                 'G','H','I','J','K','L',
                 'M','N','O','P','R','S',
                 'T','U','V','X','Y','Z',
                 '1','2','3','4','5','6',
                 '7','8','9','0','.',',',
                 '(',')','[',']','!','?',
                 '&','^','%','@','*','$',
                 '<','>','/','|','+','-',
                 '{','}','`','~');
	$salt = "";
	for($i = 0;$i < 500;$i++){
		$salt.=$arr[rand(0, count($arr)-1)];
	}
	return $salt;
}

if(isset($_POST['login'])  && isset($_POST['mail']) && isset($_POST['password'])){
	if(!$pass_free){
		echo "Password isn't correct!";
		return;
	}

	if(!$mail_free || !$login_free){
		echo "Login or E-mail already used!";
		return;
	}

	$login = strlower(htmlspecialchars($_POST['login']));
	$mail = strlower(htmlspecialchars($_POST['mail']));
	$password = htmlspecialchars($_POST['password']);

	$salt = salt_gen();
	$pass_hex = crypt(crypt($password, $salt), $salt.$password.$salt);

	$dt = new DateTime();
	$date= $dt->format('Y-m-d H:i:s');

	$db=mysqli_connect("localhost", "reguser", "HN2UWaMCQrJSLzKa") or die("Error: ".mysqli_error($db));
	mysqli_select_db($db, "acoders") or die("Error".mysqli_error($db));

	$request = "INSERT Profiles(login, password, salt, mail, joindate) VALUES('{$login}', '{$pass_hex}', '{$salt}', '{$mail}', {$date})";
	mysqli_query($db, $request) or die("Error: ".mysqli_error($db));
	mysqli_close($db);
	
	setcookie("arhicslogin", $login, time()+24*60*60);
	setcookie("arhicspass", $password, time()+24*60*60);
	header ('Location: http://www.arhicoders.com/');
}
?>