<?php

if(isset($_COOKIE['arhicslaction'])){
	$arhicslaction = htmlspecialchars($_COOKIE['arhicslaction']);
}else{
	$arhicslaction = time();
}

$db = mysqli_connect("localhost", "mesuser", "SzLJ6B9SLzZ4ZCKK") or Error("Error: ".mysqli_error($db));
mysqli_select_db($db, "acoders") or Error("Error: ".mysqli_error($db));
$result = mysqli_query($db, "SELECT * FROM chat ORDER BY date DESC ") or Error("Error: ".mysqli_error($db));
while ($line = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
	$result2= mysqli_query($db, "SELECT guid, name, login FROM profiles") or Error("Error: ".mysqli_error($db));
	while($line2 = mysqli_fetch_array($result2, MYSQLI_ASSOC)){
		if($line2['guid'] == $line['senderguid']){
			$name = trim($line2['name']);
			if($name == "")
				$name = $line2['login'];
		}
	}
	echo <<<END
	<form>
		<pre><b>{$name}</b>({$line['date']})</pre>
		<pre><b>{$line['message']}</b></pre>
	</form>
END;
}

if(isset($_POST['mBox'])){
	if($arhicslaction > time())
		return;
	$message = htmlspecialchars($_POST['mBox']);
	if($message == "")
		return;
	$db	= mysqli_connect("localhost", "mesuser", "SzLJ6B9SLzZ4ZCKK") or Error("Error: ".mysqli_error($db));
	mysqli_select_db($db, "acoders") or Error("Error: ".mysqli_error($db));
	
	$date = time();
	$guid = uniqid();
	
	$login = htmlspecialchars($_COOKIE['arhicslogin']);
	$result = mysqli_query($db, "SELECT guid FROM profiles WHERE (login='{$login}')");
	$senderguid = mysqli_fetch_array($result, MYSQLI_ASSOC)['guid'];

	$request="INSERT chat(guid, senderguid, message, date) VALUES('{$guid}', '{$senderguid}', '{$message}', FROM_UNIXTIME({$date}))";
	mysqli_query($db, $request) or Error("Error: ".mysqli_error($db));
	mysqli_close($db);
	
	//setcookie('arhicslaction', time(), time()+60*60*24);
	$arhicslaction+=1;
	unset($_POST['mBox']);
	exit("<meta http-equiv='refresh' content='0; url= $_SERVER[PHP_SELF]'>");
}
?>