<?php

session_start();


if (!isset($_SESSION['uid'])) {

	// Need the functions:
	require ('login_functions.inc.php');
	redirect_user();
}
?>