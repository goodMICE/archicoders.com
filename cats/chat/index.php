<?php
include './../login/scripts/login.php';
if(isset($_COOKIE['arhicspass']) && isset($_COOKIE['arhicslogin']))
	$is_logined = check_data(htmlspecialchars($_COOKIE['arhicslogin']), htmlspecialchars($_COOKIE['arhicspass']));
if(!$is_logined)
		header ('Location: http://arhicoders.ru/arhicoders.com/cats/login/');
include 'index.html';
include './scripts/chat.php';
?>