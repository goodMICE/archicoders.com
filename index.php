<?php
include 'index.html';
include './cats/login/scripts/login.php';
$is_logined = false;
if(isset($_COOKIE['arhicspass']) && isset($_COOKIE['arhicslogin'])){
	$is_logined = check_data(htmlspecialchars($_COOKIE['arhicslogin']), htmlspecialchars($_COOKIE['arhicspass']));
}
if($is_logined){
	echo "<a href='' onClick='javascript: document.cookie=\"arhicspass=;path=/;expires=-1\";document.cookie=\"arhicslogin=;path=/;expires=-1\"'>Sing Out!</a>";
}else{
	echo <<<END
		<tr>
		<a href="./cats/login/index.php">Sing in</a>
		<a href="./cats/registration/index.php">Sing up</a>
		</tr>
END;
}
?>