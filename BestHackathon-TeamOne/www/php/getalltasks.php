<?php
require_once("config.php");

if(loggedIn()){
$sql = "SELECT * FROM users 
		WHERE id = '".$id."'LIMIT 1";
$query = mysql_query($sql) or trigger_error("Query Failed: " . mysql_error());
if($query!=""){
$row = mysql_fetch_assoc($query);
$allAims = explode("-", $row['aimsid']);
if($allAims[0]!=0)
foreach ($allAims as $aim) {
	$sql = "SELECT * FROM aims 
		WHERE id = '".$aim."'LIMIT 1";
	$query = mysql_query($sql) or trigger_error("Query Failed: " . mysql_error());
	$row = mysql_fetch_assoc($query);
	echo "<div class=\"task\"><div class=\"aimid\">".$aim."</div><div class=\"title\">".$row['title']."</div><div class=\"description\">".$row['description']."</div></div>\n";
}
}

}else{
	echo "Fuck OFF";
}


?>