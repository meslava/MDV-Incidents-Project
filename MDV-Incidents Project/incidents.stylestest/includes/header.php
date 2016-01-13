<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1">
<meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0" />

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
	<link rel="stylesheet" href="includes/propio.css" type="text/css" media="screen" />
	<meta http-equiv="content-type" content="text/html; charset=utf-8" />
</head>
<body>
	<div id="header">
		<h1>MDV - Incidents</h1>
		<h2>Incidents tickets web</h2>
	</div>
	<div id="menu">
		<ul>
			<li><a href="incident-new.php">New ticketaaaaaaaaaaaa</a></li>
			<li><a href="incident-list.php">View tickets</a></li>
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
	
		
	
