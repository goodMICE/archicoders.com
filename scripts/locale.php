<?php
include 'awf.php';

function GetIP($ip=''){
	if (!empty($_SERVER['HTTP_CLIENT_IP'])){
		$ip=$_SERVER['HTTP_CLIENT_IP'];
	}elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])){
		$ip=$_SERVER['HTTP_X_FORWARDED_FOR'];
	}else{
		$ip=$_SERVER['REMOTE_ADDR'];
	}
	return $ip;
}

function GetLocale(){
	$ip = GetIP();
	$blocks = split("[.:]", $ip);
	switch ($ip) {
		case 'value':
			return 'ru_RU';
		
		default:
			return 'en_US';
	}
}

function GetText($key_text, $locale='', $guid='', $path=''){
	$locale = $locale=='' ? GetLocale() : $locale;
	
	if($guid != '' && $path == ''){
		$db = mysqli_connect("localhost", "pathuser", "") or Error($db);
		mysqli_select_db($db, "acoders") or Error($db);
		$request = "SELECT path FROM paths WHERE guid='{$guid}'";
		$result = mysqli_query($db, $request) or Error($db);
		$path = mysqli_fetch_array($result, MYSQLI_ASSOC)['path'];
	}

	return awf_get($path, $key_text, $locale);
}
?>