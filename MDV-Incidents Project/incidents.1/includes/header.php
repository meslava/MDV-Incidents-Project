<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<title><?php echo $page_title; 
	//Esto esta comentado por que hace bucle de redireccionamiento infinito. Mejor quizas solo poner el session_start o no poner nada.
	//Otra opcion es comprobar el inicio de sesion en un archivo include.
//	session_start();
//if (!isset($_SESSION['uid'])) {
	// Need the functions:
//	require ('login_functions.inc.php');
//	redirect_user();
//}
	?></title>	
	<link rel="stylesheet" href="includes/style.css" type="text/css" media="screen" />
	<meta http-equiv="content-type" content="text/html; charset=utf-8" />
</head>
<body>
	<div id="header">
		<h1>MDV - Incidents</h1>
		<h2>Incidents tickets web</h2>
	</div>
	<div id="navigation">
		<ul>
			<li><a href="incident-new.php">New ticket</a></li>
			<li><a href="incident-list.php">View tickets</a></li>
			<li><a href="incident-add.php">Add incident</a></li>
			<li><?php
// Create a login/logout link:
//session_start();
if (isset($_SESSION['uid'])) {
	echo '<a href="logout.php">Logout</a>';
} else {
	echo '<a href="index.php">Login</a>';
}
?></li>
		</ul>
	</div>
	<div id="content">