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
	$message = htmlspecialchars($_POST['message']);
	if($message == "")
		return;
	
}
?>