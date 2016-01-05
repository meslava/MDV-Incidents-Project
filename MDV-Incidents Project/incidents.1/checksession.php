<?php # script - cheksession.php
// This page contain functions for check that the session has been isset through the user id and so, avoid repeat the code.
// Also, this functions call another functions from login_functions.inc.php.

/*The function cheksession is used for check through the session uid created in the login, if is isset. In afirmative case, the user can see the pages than have this check.
If is not isset because for example the user have accessed for accident, the function will call another function called redirect_user from login_functions_inc.php 
and it will send the user to index.php and can login and so avoid see the pages the accidental form or maliciously form.
This function is required by incidenl-list.php, incident-edit.php and incident-register.php. */

function checksession() {

session_start();


if (!isset($_SESSION['uid'])) {

	// Need the functions:
	require ('includes/login_functions.inc.php');
	redirect_user();
}
}

/*The function cheksessionorkill is used for check through the session uid created in the login, if is isset. In afirmative case, 
the user could logout and then, the session will be destroyed.
If is not isset because for example the user have accessed for accident, the function will call another function called redirect_user from login_functions_inc.php 
and it will send the user to index.php and can login and so avoid see the pages the accidental form or maliciously form.
This function is required by incidenl-list.php, incident-edit.php and incident-register.php. */

function checksessionorkill(){
	session_start();

//This function is required by logout.php.
if (!isset($_SESSION['uid'])) {

	// Need the functions:
	require ('includes/login_functions.inc.php');
	redirect_user();
} else { // Cancel the session:

	$_SESSION = array(); // Clear the variables array.
	session_destroy(); // Destroy the session itself.
	setcookie ('PHPSESSID', '', time()-3600, '/', '', 0, 0); // Destroy the cookie.

}
	
}
?>