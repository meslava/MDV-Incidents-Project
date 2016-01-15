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
	<div id="navigation">
		<ul>
			<li><a href="incident-add.php">New Ticket</a></li>
			<li><a href="incident-list.php">View Tickets</a></li>
			<?php
// Create a login/logout link:

if (isset($_SESSION['uid'])) {
	echo '<li><a href="logout.php">Logout</a></li>';
	
	//Determines if there should be a "New user" link.
	require ('../mysqli_connect.php'); 
	//Query to know the group of the user that is logged in.
    $qgroup = "SELECT  `group` FROM  `USERS` WHERE uid ={$_SESSION['uid']}";
    //Run the query
    $rgroup = mysqli_query($dbc, $qgroup);
    //Saves the number of rows result of the query in the var $num
    $num = mysqli_num_rows($rgroup);
    $rowgroups = mysqli_fetch_array($rgroup, MYSQLI_ASSOC);

	if ($rowgroups['group'] == chief_technician) {
		echo '<li><a href="add-user.php">New user</a></li>';
	}
} else {
	echo '<li><a href="index.php">Login</a></li>';
}


//Close mysql connection
//mysqli_close($dbc);
?>
			<li><a href="changepasswd.php">Change your password</a></li>
		</ul>
	</div>
	<div id="content">