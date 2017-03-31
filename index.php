<?php
include 'index.html';
include '/cats/login/scripts/login.php';
if(isset($_COOKIE['arhicspass']) && isset($_COOKIE['arhicslogin']))
	$is_logined = check_data($_COOKIE['arhicslogin'], $_COOKIE['arhicspass']);
if($is_logined){
	echo "<a href='javascript: setcookie(\"arhicspass\", \"\", {expires: -1})'>Sing Out!</a>";
}
?>