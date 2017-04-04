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
	$blocks = preg_split('.', $ip);
	switch ($ip) {
		case 'value':
			return 'ru_RU';
		
		default:
			return 'en_US';
	}
}

function get_page($page, $locale='', $path='', $guid=''){
	$parts = explode('{^}', $page);
	$out = '';
	foreach ($parts as &$part){
		$awf = get_text(trim($part), $locale, $path, $guid);
		$out.= $awf=='' ? $part : $awf;
	}
	return $out;
}

function get_text($text, $locale='', $path='', $guid=''){
	$keys = explode(';', $text);
	$out = '';
	if(count($keys) == 0)
		return $out;
	foreach ($keys as &$sent){
		$awf = get_sent(trim($sent), $locale, $path, $guid);
		$out.= $awf=='' ? $sent : $awf;
	}
	return $out;
}

function get_sent($key_text, $locale='', $path='', $guid=''){
	$locale = $locale=='' ? GetLocale() : $locale;
	
	/*
	if($guid != '' && $path == ''){
		$db = mysqli_connect("localhost", "pathuser", "") or Error($db);
		mysqli_select_db($db, "acoders") or Error($db);
		$request = "SELECT path FROM paths WHERE guid='{$guid}'";
		$result = mysqli_query($db, $request) or Error($db);
		$path = mysqli_fetch_array($result, MYSQLI_ASSOC)['path'];
	}
	*/

	return awf_get($path, $key_text, $locale);
}
?>