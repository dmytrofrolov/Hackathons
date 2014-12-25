<?php
/*****************************
	File: login.php
	Written by: Frost of Slunked.com
	Tutorial: User Registration and Login System
******************************/
if(!headers_sent())
	header('Content-Type: text/html; charset=utf8');
require_once('config.php');

// If the user is logging in or out
// then lets execute the proper functions
if (isset($_GET['action'])) {
	switch (strtolower($_GET['action'])) {
		case 'login':
			if (isset($_POST['email']) && isset($_POST['password'])) {
				// We have both variables. Pass them to our validation function
				$validateUserReturn = validateUser($_POST['email'], $_POST['password']);
				if (!$validateUserReturn) {
					// Well there was an error. Set the message and unset
					// the action so the normal form appears.
					$_SESSION['error'] = "Bad email or password supplied. $validateUserReturn";
					unset($_GET['action']);
				}
			}else {
				$_SESSION['error'] = "email and Password are required to login.";
				unset($_GET['action']);
			}			
		break;
		case 'logout':
			// If they are logged in log them out.
			// If they are not logged in, well nothing needs to be done.
			if (loggedIn()) {
				logoutUser();
				$sOutput .= '<h1>Logged out!</h1><br>You have been logged out successfully. 
						<br><h4>Would you like to go to <a href="index.php">site index</a>?</h4>';
				$sOutput.= '<script type="text/javascript">  $(document).ready(function() {	location.reload(); });</script>';
			}else {
				// unset the action to display the login form.
				unset($_GET['action']);
			}
		break;
	}
}

$sOutput .= '<div id="index-body">';

// See if the user is logged in. If they are greet them 
// and provide them with a means to logout.
if (loggedIn()) {
	$sOutput .= '<h1>Logged In!</h1><br><a href="" onclick=\'$.ajax({
    type: "POST",
    url: "/php/login.php?action=logout",
    data: "",
    success: function(html){
        location.reload();
    }
    });\'>Log out</a>

	<br>
		Hello, ' . $_SESSION["email"] . ' how are you today?<br><br>';
}elseif (!isset($_GET['email'])) {
	// incase there was an error 
	// see if we have a previous email
	$sEmail = "";
	if (isset($_POST['email'])) {
		$sEmail = $_POST['email'];
	}
	
	$sError = "";
	if (isset($_SESSION['error'])) {
		$sError = '<span id="error">' . $_SESSION['error'] . '</span>';
	}
	$sOutput.=$sError;
	///php/login.php?action=login
	if(!isset($_POST['email']))
	$sOutput .= '<div><h2>Login to our site</h2><br>
		<div id="login-form">
			<form name="login" method="post" action="" onsubmit="return false">
				Email:<br><input type="text" name="email" id="email" value="' . $sEmail . '" /><br>
				Password: <br><input type="password" name="password" id="password" value="" /><br><br>
				<input id="login" type="submit" name="submit" value="Login!" />
			</form>
		</div>
		<div id="loginreturn">
		</div>
		</div>


<script type="text/javascript">    
$(document).ready(function() {
        $(\'#login\').click(function() {
            var email = $(\'#email\').val();
            var password = $(\'#password\').val();
            var dataString = \'&email=\' + email + \'&password=\' + password;
            
            $.ajax({
			type: "POST",
			url: "/php/login.php?action=login",
			data: dataString,
			success: function(html){
				$("#loginreturn").append(html);
				location.reload();
			}
			});

        });

    });
</script>

		';
}
if(loggedIn())
	$sOutput.= '<script type="text/javascript">  $(document).ready(function() {
		//location.reload();
   			 });</script>';
$sOutput .= '</div>';

// lets display our output string.
echo $sOutput;

?>