<!-- #logout.php
// This page lets the user logout.
// This version uses sessions.-->

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<title><?php echo $page_title;?>
	</title>	
	<link rel="stylesheet" href="includes/style.css" type="text/css" media="screen" />
	<meta http-equiv="content-type" content="text/html; charset=utf-8" />
</head>
<body>
	<div id="header">
		<h1>MDV - Incidents</h1>
		<h2>Incidents tickets web</h2>
	</div>
	<div id="content">


<?php
//With the function cheksessionorkill from checksession.php, the session will close.
require ('checksession.php');
checksessionorkill();

// Set the page title and include the HTML header:
$page_title = 'Logged Out!';


// Print a customized message:
echo "<h1>Logged Out!</h1>
<p>You are now logged out!</p>
<p>Do you want <a href='index.php'>Login in</a>?</p>";
include ('includes/footer.html');
?>