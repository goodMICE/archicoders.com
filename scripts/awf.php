<?php
function awf_get($path, $key='', $locale=''){
	$key=trim($key);
	$locale = trim($locale);
	if(!file_exists($path))
		$path.='.awf';
	if(!file_exists($path))
		return '';
	$full_text = file_get_contents($path);
	if(!strripos($full_text, $key))
		return '';
	$strs = explode('.};', $full_text);
	$key_vals = array('lang' => array('ru_RU' => 'Русский', 'en_US' => 'English'));
	foreach ($strs as &$str) {
		$tmp = explode(':{.(', $str);
		if(count($tmp) <= 1)
			break;
		$tmp_key = trim($tmp[0]);
		$locale_value = explode('.}{.(', $tmp[1]);
		foreach ($locale_value as $lvt) {
			$tmp2 = explode(').,', $lvt);
			$key_vals[$tmp_key][$tmp2[0]]=$tmp2[1];
		}
	}

	if($key != ''){
		if ($locale != ''){
			return $key_vals[$key][$locale];
		}else{
			return $key_vals[$key];
		}
	}else{
		if($locale != ''){
			$ret = array('key' => 'Value.');
			foreach ($key_vals as $tmp_key => $tmp_value) {
				$ret[$tmp_key] = $tmp_value;
			}
			return $ret;
		}else{
			return $key_vals;
		}
	}
}
?>