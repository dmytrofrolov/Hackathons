<?php
require_once('config.php');
if(isset($_POST['title']) && isset($_SESSION['id'])){
$title = $_POST['title'];
$description = $_POST['description'];
$i=1;
$checklist = [];
while(isset($_POST["checkitem".$i])){
	array_push($checklist, $_POST["checkitem".$i]);
	$i++;
}

$sql = "INSERT INTO aims (`title`, `description`, `checklist`) VALUES ('" . $title . "', '" . $description . "', '". json_encode($checklist) ."');";

$query = mysql_query($sql) or trigger_error("Query Failed: " . mysql_error());
$lastAimId = mysql_insert_id();
$sql = "SELECT * FROM users WHERE `id` = '" . $_SESSION['id'] . "' LIMIT 1";	
$query = mysql_query($sql) or trigger_error("Query Failed: " . mysql_error());
$row = mysql_fetch_assoc($query);
$newRowForUserAimsId = $row['aimsid']."-".$lastAimId;


$sql = "UPDATE users SET aimsid='".$newRowForUserAimsId."' WHERE id=".$_SESSION['id']."";
$query = mysql_query($sql) or trigger_error("Query Failed: " . mysql_error());
echo true;
}else{
	echo false;
}
?>