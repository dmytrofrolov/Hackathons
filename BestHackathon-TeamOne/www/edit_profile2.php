<?php

require 'php/config.php'; 
$sql = "UPDATE `users` SET `name`='".$_POST['fname']."' WHERE `id`=".$_SESSION['id'];
$sql2 = "UPDATE `users` SET `surname`='".$_POST['lname']."' WHERE `id`=".$_SESSION['id'];
$query = mysql_query($sql) or trigger_error("Query Failed: " . mysql_error());
$query = mysql_query($sql2) or trigger_error("Query Failed: " . mysql_error());
$_SESSION['name'] = $_POST['fname'];
$_SESSION['surname'] = $_POST['lname'];
?>