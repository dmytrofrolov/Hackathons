<?php
require_once("config.php");

if(loggedIn()){
$sql = "SELECT * FROM users LIMIT 10";
$query = mysql_query($sql) or trigger_error("Query Failed: " . mysql_error());
while($row = mysql_fetch_assoc($query)){
	echo $row['name']."<br>\n";
}
}else{
	echo "Fuck OFF";
}

?>