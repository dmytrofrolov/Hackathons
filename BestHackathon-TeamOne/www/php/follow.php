<?php
require_once('config.php');

$myid = $_POST['myid'];
$hisid = $_POST['hisid'];
if(isset($_SESSION['id']) && $_SESSION['id'] == $myid){

$sql = "SELECT * FROM users WHERE `id` = '" . $_SESSION['id'] . "' LIMIT 1";	
$query = mysql_query($sql) or trigger_error("Query Failed: " . mysql_error());
$row = mysql_fetch_assoc($query);

if($row['followings']=="")$newRowForUserFollowers=$hisid;
else $newRowForUserFollowers = $row['followings']."-".$hisid;
echo "$newRowForUserFollowers";

$sql = "UPDATE users SET followings='".$newRowForUserFollowers."' WHERE id=".$_SESSION['id']."";
$query = mysql_query($sql) or trigger_error("Query Failed: " . mysql_error());
echo true;
}else{
	echo false;
}
?>