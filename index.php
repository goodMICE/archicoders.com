<?php
include './scripts/locale.php';
include './cats/login/scripts/login.php';

$locales = array(0 => 'ru_RU', 1 => 'en_US');

if(isset($_COOKIE['arhicsloc'])){
	$currLoc = $_COOKIE['arhicsloc'];
}else{
	$currLoc = 0;
}

$loc_path = './locales/main/main.awf';

$page = get_page(file_get_contents("index.html"), $locales[$currLoc], $loc_path);
echo $page;

$is_logined = false;
if(isset($_COOKIE['arhicspass']) && isset($_COOKIE['arhicslogin'])){
	$is_logined = check_data(htmlspecialchars($_COOKIE['arhicslogin']), htmlspecialchars($_COOKIE['arhicspass']));
}
if($is_logined){
	$sing_out = get_sent("sing_out", $locales[$currLoc], $loc_path);
	echo $sing_out;
	echo "<tr><a href='' onClick='javascript: document.cookie=\"arhicspass=;path=/;expires=-1\";document.cookie=\"arhicslogin=;path=/;expires=-1\"'>{$sing_out}</a></tr>";
}else{
	$sing_in = get_sent("sing_in", $locales[$currLoc], $loc_path);
	$sing_up = get_sent("sing_up", $locales[$currLoc], $loc_path);
	echo <<<END
		<tr>
		<a href="./cats/login/index.php">{$sing_in}</a>
		<a href="./cats/registration/index.php">{$sing_up}</a>
		</tr>
END;
}
$lang = get_sent("lang", $locales[!$currLoc], $loc_path);
echo <<<END
<form method="post">
<input type="hidden" name="langbox" value="1"/>
<input type="submit" value="{$lang}"/>
</form>
END;

if(isset($_POST['langbox'])){
	$currLoc = !$currLoc;
	echo "
	<script type='text\javascript'>document.cookie='arhicsloc={$currLoc};path=/;expires=86400';</script>
	<meta http-equiv='refresh' content=\"0; url={$_SERVER['PHP_SELF']}\">";
}
?>