<?php 
//Starts the session that already exists.
session_start();
//Checks if the user has arrived here by error. If that is the case the user is redirected to index.php where he can stat the session.
if (!isset($_SESSION['uid'])) {
	//Need the functions:
	require ('includes/login_functions.inc.php');
	redirect_user();
}

$page_title = 'Welcome to incidents report page';
include ('includes/header.php');

echo "<h1>Wellcome {$_SESSION['name']}!</h1>
<p><a href=\"logout.php\">Logout</a></p>";

include ('includes/footer.html');
?>