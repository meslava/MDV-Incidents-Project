<!--This page is used for the header, navegation bar and content being used for all the principal web pages.
Here is produced the change of login to logout by means of check the session. The add-user.php will appears only for the chief_technician.-->

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

// Create a login/logout link depedents from the session if is set or if is not set.

if (isset($_SESSION['uid'])) {
	echo '<li><a href="logout.php">Logout</a></li>';
	
	//Determines if there should be a "New user" link.
	require ('../mysqli_connect.php'); 
	//Query to know the group of the user that is logged in.
    $qgroup = "SELECT  `group` FROM  `USERS` WHERE uid ={$_SESSION['uid']}";
    //Run the query
    $rgroup = mysqli_query($dbc, $qgroup);
    //Saves the result number of rows from the query in the var $num.
    $num = mysqli_num_rows($rgroup);
    if ($num > 0) { 
    // If it ran OK then saves the result row as an associative array in rowgroups.
    $rowgroups = mysqli_fetch_array($rgroup, MYSQLI_ASSOC);
    
    //Creates the new user link if the user is a chief technician.
	if ($rowgroups['group'] == chief_technician) {
		echo '<li><a href="add-user.php">New user</a></li>';
	}
} else {
	echo '<li><a href="index.php">Login</a></li>';
}
}else{
	echo '<p class="error">There are currently no registered groups.</p>';
}


//mysqli_close is commented because produce a error.
//mysqli_close($dbc);
?>
			<li><a href="changepasswd.php"> Change your password</a></li>
		</ul>
	</div>
	<div id="content">