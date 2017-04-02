<?php
function awf_get($path, $key='', $locale=''){
	if(!file_exists($path))
		$path.='.awf';
	if(!file_exists($path))
		return '';
	$full_text = file_get_contents($path);
	$strs = split(').};', $full_text);
	$key_vals = array('key' => array('ru_RU' => 'Значение.', 'en_US' => 'Value.'));
	foreach ($strs as $str) {
		$tmp = split(':{.(', $str);
		$tmp_key = $tmp[0];
		$locale_value = split('.}{.(', $tmp[1]);
		foreach ($locale_value as $lvt) {
			$tmp2 = split(').,', $lvt);
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