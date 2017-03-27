<?php
	function Login($login, $pass, $salt){
		$db=mysql_connect("localhost", "loginuser") or die("Connect terminate: ".mysql_error());
		mysql_select_db("archicoders.com") or die("Database don't exist!".mysql_error());
		$query="SELECT  FROM users";
	}

	function Register($login, $pass, $salt, $nick, $email){
		//
	}

	function Hex($login, $pass, $salt){
		if($salt >= 1000 && $salt <= 5000){
			if($salt % 2 == 0){
				$p = crypt($pass.(crypt($salt/2,$salt)), $salt);
			}elseif($salt % 3 == 0){
				$p = crypt($pass.($salt/3), $salt);
			}else{
				$p = crypt($pass.(crypt($salt*5)), $salt);
			}
		}elseif ($salt > 5000){
			if($salt % 10 == 1 || (int)$login > 100){
				$p = crypt((crypt($salt/10, $login)).$pass, $login+1);
			}elseif($salt % 13 == 1){
				$p = crypt($login.$pass, $login);
			}else{
				$p = crypt((crypt($login, $salt)).$login.(crypt($salt, $login)).$pass, $pass);
			}
		}else{
			if((int)$login.$pass <= 100){
				$p = crypt($pass.(crypt($salt, $pass)).$salt, crypt($login.$pass, $salt));
			}else{
				$p = crypt($login.(crypt($login,$salt)), crypt($pass.$salt, $salt.$login));
			}
		}
		return $p;
	}
?>