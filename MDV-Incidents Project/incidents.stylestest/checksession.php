<?php # script - cheksession.php
// This page contains functions to check if the session has been set (using !isset) through the user id and so, avoid repeat the code.
// Also, this functions call another functions from login_functions.inc.php.

/*The function cheksession is used to check through the session uid created in the login, if is set. In afirmative case, the user can see the pages that have this check.
If it's not set because for example the user has accessed for accident, the function will call another function called redirect_user from login_functions_inc.php 
and it will send the user to index.php and he will be able to login and avoid to see the pages the accidental form or maliciously form.
This function is required by incident-list.php, incident-edit.php and incident-register.php. */

function checksession() {

session_start();


if (!isset($_SESSION['uid'])) {

	// Need the functions:
	require ('includes/login_functions.inc.php');
	redirect_user();
}
}

/*The function cheksessionorkill is used to check, through the session uid created in the login, if it is set. In afirmative case, 
the user could logout and then, the session will be ended.
If it's not set because for example the user has accessed for accident, the function will call another function called redirect_user from login_functions_inc.php 
and it will send the user to index.php and he will be able to login and avoid to see the pages the accidental form or maliciously form.
This function is required by logout.php. */

function checksessionorkill(){
	session_start();

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