<?php
	$lastid=0;
	function reload(){
		$db=mysql_connect("localhost", "chatuser") or die("Connect terminate: ".mysql_error());
		mysql_select_db("archicoders.com") or die("Database don't exist!".mysql_error());
		$query="SELECT * FROM chat";
		$mesarr = mysql_query($query) or die("Request terminated".mysql_error());
		while ($line = mysql_fetch_array($mesarr, MYSQL_ASSOC)) {
			foreach ($line as $value) {
				echo "<td>";print_r($value);echo "</td>";
				$lastid = ((int)$value['id'] > $lastid) ? $value['id'] : $lastid;
			}
		}
		mysql_free_result($mesarr);
		mysql_close($db);
		echo "Last id $lastid";
	}

	function sendMessage($mes){
		echo "Hi";
		$db=mysql_connect("localhost", "chatuser") or die("Connect terminate: ".mysql_error());
		mysql_select_db("archicoders.com") or die("Database don't exist!".mysql_error());
		$query="INSERT INTO chat(Nick, Email, Message, id, Date) VALUES (Player, test, $mes, $lastid, 14.07.2001);";
		mysql_query($query) or die("Request terminated".mysql_error());
	}
?>