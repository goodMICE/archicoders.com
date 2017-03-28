<?php
include './../../login/scripts/login.php';

if(isset($_COOKIE['arhicspass']) && isset($_COOKIE['arhicslogin']))
	check_data($_COOKIE['arhicslogin'], $_COOKIE['arhicspass']);
if($is_logined)
	echo <<<END
	<script type="text/javascript">
		window.location = 'http://arhicoders.com/';
	</script>
END;

$mail_free = false;
$login_free = false;

$db=mysqli_connect("localhost", "reguser") or die("Error: ".mysqli_error($db));
mysqli_select_db($db, "acoders") or die("Error".mysqli_error($db));
$login_result = mysqli_query($db, "SELECT login FROM chat") or die("Error: ".mysqli_error($db));
$mail_result = mysqli_query($db, "SELECT mail FROM Profiles") or die("Error: ".mysqli_error());
mysqli_close($db);

if(isset($_POST['login'])){
	while ($line = mysqli_fetch($result)) {
		if($line == $_POST['login']){
			echo "Login already used!";
			$login_free = false;
			break;
		}
	}
	echo "Login is free!";
	$login_free = true;
}

if(isset($_POST['mail'])){
	while ($line = mysqli_fetch($mail_result)) {
		if($line == $_POST['mail']){
			echo "E-mail already used!";
			$mail_free = false;
			break;
		}
	}
	echo "E-mail is free!";
	$mail_free = true;
}


if(isset($_POST['login'])  && isset($_POST['mail']) && isset($_POST['password'])){
	if(!$mail_free || !$login_free){
		echo "Login or E-mail already used!";
		return;
	}
	$db=mysqli_connect("localhost", "reguser") or die("Error: ".mysqli_error($db));
	mysqli_select_db($db, "acoders") or die("Error".mysqli_error($db));
	
	$salt = salt_gen();
	$pass_hex = crypt(crypt($password, $salt), $salt.$password.$salt);
	mysqli_query($db, "INSERT chat(id, login, password, salt) VALUES(0, '{$login}', '{$pass_hex}', '{$salt}')");
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

?>