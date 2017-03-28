<?php
include './../../login/scripts/login.php';

if(isset($_COOKIE['arhicspass']) && isset($_COOKIE['arhicslogin']))
	check_data($_COOKIE['arhicslogin'], $_COOKIE['arhicspass']);
if(!$is_logined)
	echo <<<END
	<script type='text/javasctipt'>
		window.location = 'http://arhicoders.com/login/';
	</script>"
END;


if(isset($_POST['message'])){
	if(isset($_COOKIE['arhicslaction']))
		if($_COOKIE['arhicslaction']+2.5 > time())
			return;
	$message = htmlspecialchars($_POST['message']);
	if($message == "")
		return;
	$db	= mysqli_connect("localhost", "mesuser", "") or die("Error: ".mysqli_error($db));
	mysqli_select_db($db, "acoders") or die("Error: ".mysqli_error($db));
	
	$dt = new DateTime();
	$date= $dt->format('Y-m-d H:i:s');

	$request="INSERT messages(name, message, date) VALUES('{$_COOKIE['arhicslogin']}', '$message', '$date')";
	mysqli_query($db, $request) or die("Error: ".mysqli_error($db));
	mysqli_close($db);

	setcookie('arhicslaction', time(), time()+60*60*24);
}
?>