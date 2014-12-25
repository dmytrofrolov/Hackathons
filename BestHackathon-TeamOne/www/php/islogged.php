<?php
require_once("config.php");
if(loggedIn()){
	echo "true";
}else{
	echo "false";
}
?>