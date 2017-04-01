<?php
include './../login/scripts/login.php';
$is_logined = false;
if(isset($_COOKIE['arhicspass']) && isset($_COOKIE['arhicslogin']))
	$is_logined = check_data($_COOKIE['arhicslogin'], $_COOKIE['arhicspass']);
if(!$is_logined)
		header ('Location: http://www.arhicoders.com/cats/login/');

$db = mysqli_connect("localhost", "mesuser", "SzLJ6B9SLzZ4ZCKK") or die("Error: ".mysqli_error($db));
mysqli_select_db($db, "acoders") or die("Error: ".mysqli_error($db));
$result = mysqli_query($db, "SELECT * FROM messages") or die("Error: ".mysqli_error($db));
while ($line = mysqli_fetch_array($result, MYSQL_ASSOC)) {
	echo <<<END
	<form method="post">
		<input type="hidden" name="answerId" value="{$line['id']}"/>
		<pre>{$line['name']}({$line['date']})</pre>
		<pre>{$line['message']}</pre>
		<input type="submit" value="Answer"/>
	</form>
END;
}

if(isset($_POST['message'])){
	if(isset($_COOKIE['arhicslaction']))
		if($_COOKIE['arhicslaction']+1 > time())
			return;
	$message = htmlspecialchars($_POST['message']);
	if($message == "")
		return;
	$db	= mysqli_connect("localhost", "mesuser", "SzLJ6B9SLzZ4ZCKK") or die("Error: ".mysqli_error($db));
	mysqli_select_db($db, "acoders")or die("Error: ".mysqli_error($db));
	
	$dt = new DateTime();
	$date= $dt->format('Y-m-d H:i:s');

	$request="INSERT messages(id, name, message, date) VALUES(0, '{$_COOKIE['arhicslogin']}', '$message', '$date')";
	mysqli_query($db, $request) or die("Error: ".mysqli_error($db));
	mysqli_close($db);
	
	setcookie('arhicslaction', time(), time()+60*60*24);
	unset($_POST['message']);
}
?>