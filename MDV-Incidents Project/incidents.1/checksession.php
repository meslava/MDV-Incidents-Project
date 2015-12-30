<?php

function checksession() {

session_start();


if (!isset($_SESSION['uid'])) {

	// Need the functions:
	require ('login_functions.inc.php');
	redirect_user();
}
}

function checksessionorkill(){
	session_start();


if (!isset($_SESSION['uid'])) {

	// Need the functions:
	require ('login_functions.inc.php');
	redirect_user();
} else { // Cancel the session:

	$_SESSION = array(); // Clear the variables array.
	session_destroy(); // Destroy the session itself.
	setcookie ('PHPSESSID', '', time()-3600, '/', '', 0, 0); // Destroy the cookie.

}
	
}
?>