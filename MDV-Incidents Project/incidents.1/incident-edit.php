<?php # Script - incident-edit.php
// This page is for editing an incident report.
// This page is accessed through incident-list.php.

$page_title = 'Edit an incident report';
require ('includes/header.php');
require ('checksession.php');
checksession();


echo '<h1>Edit an incident report</h1>';

// Check for a valid user ID, through GET or POST:
if ( (isset($_GET['uid'])) && (is_numeric($_GET['uid'])) ) { // From incident-list.php
	$uid = $_GET['uid'];
} elseif ( (isset($_POST['uid'])) && (is_numeric($_POST['uid'])) ) { // Form submission.
	$uid = $_POST['uid'];
} else { // No valid ID, kill the script.
	echo '<p class="error">This page has been accessed in error.</p>';
	include ('includes/footer.html'); 
	exit();
}

require ('../mysqli_connect.php'); 

// Check if the form has been submitted:
if ($_SERVER['REQUEST_METHOD'] == 'POST') {

	$errors = array();
	
/*	// Check for a first name:
	if (empty($_POST['technician'])) {
		$errors[] = 'You forgot to enter a new technician.';
	} else {
		$tc = mysqli_real_escape_string($dbc, trim($_POST['technician']));
	}
	*/
	// Check for description
	if (empty($_POST['description'])) {
		$errors[] = 'You forgot to enter a description.';
	} else {
		$descr = mysqli_real_escape_string($dbc, trim($_POST['description']));
	}
	
	if (empty($errors)) { // If everything's OK.

//This is just in case. Since status values is get from <select> should be always the values of that select.
$stat=mysqli_real_escape_string($dbc, trim($_POST['status']));
			// Make the query:
			//Checks if the incident has been closed
			//If it has been closed set the value close_date at the currentet date
		/*	if ($stat == "CLOSED"){ 
				
				
			$q = "UPDATE incidents SET technician='$tc', status='$stat', description='$descr', close_date=CURDATE() WHERE IID=$uid LIMIT 1";
	
		$q = "UPDATE incidents SET description='$descr', close_date=CURDATE() WHERE IID=$uid LIMIT 1";
	
			$r = @mysqli_query ($dbc, $q);
			//If the status is OPEN it might be a reopen incient, so this will set the close_date to NULL
			}elseif ($stat == "OPEN"){
			
			$q = "UPDATE incidents SET technician='$tc', status='$stat', description='$descr', close_date=NULL WHERE IID=$uid LIMIT 1";
			
			$q = "UPDATE INCIDENTS SET description='$descr' WHERE creator_uid=$uid LIMIT 1";
			
			
		
		*/	$q = "UPDATE INCIDENTS SET description='$descr' WHERE creator_uid=$uid LIMIT 1";
			
			$r = @mysqli_query ($dbc, $q);
		//	}
			if (mysqli_affected_rows($dbc) == 1) { // If it ran OK.

				// Print a message:
				echo '<p>The incident report has been edited.</p>';	
				
			} else { // If it did not run OK.
				echo '<p class="error">The incident report could not be edited due to a system error. We apologize for any inconvenience.</p>'; // Public message.
				echo '<p>' . mysqli_error($dbc) . '<br />Query: ' . $q . '</p>'; // Debugging message.
			}
	} else { // Report the errors.
		echo '<p class="error">The following error(s) occurred:<br />';
		foreach ($errors as $msg) { // Print each error.
			echo " - $msg<br />\n";
		}
		echo '</p><p>Please try again.</p>';
	
	} // End of if (empty($errors)) IF.

} // End of submit conditional.

// Always show the form...

// Retrieve the user's information:
/*$q = "SELECT user, technician, open_date, close_date, description, status FROM incidents WHERE IID=$uid";	*/
$q = "SELECT i.description FROM INCIDENTS i, USERS usuario where usuario.uid=i.creator_uid and usuario.uid=$uid";

$r = @mysqli_query ($dbc, $q);

if (mysqli_num_rows($r) == 1) { // Valid user ID, show the form.
	// Get the report's information:
	$row = mysqli_fetch_array ($r, MYSQLI_NUM);
	
	
	// Create the form:
		echo '<form action="incident-edit.php" method="post">
			<p>Description:</p> <p><textarea name="description" rows="10" cols="30">'.$row[0].'</textarea></p>
			<p><input type="submit" name="submit" value="Submit" /></p>
		<input type="hidden" name="uid" value="' . $uid . '" />
	</form>';


/*	echo '<form action="incident-edit.php" method="post">
		<p>User: '.$row[0].'</p>
			<p>Technician: <input type="text" name="technician" value="'.$row[1].'" </input></p>
			<p>Open since: '.$row[2].'</p>
			<p>Closed since: '.$row[3].'</p>
			<p>Status <select name="status">
				<option '.($row[5]=='OPEN' ? ' selected ': "").'value="OPEN">OPEN</option>
				<option '.($row[5]=='CLOSED' ? ' selected ': "").'value="CLOSED">CLOSED</option>
				</select></p> -->
			<p>Description:</p> <p><textarea name="description" rows="10" cols="30">'.$row[4].'</textarea></p>
			<p><input type="submit" name="submit" value="Submit" /></p>
		<input type="hidden" name="uid" value="' . $uid . '" />
	</form>'; */

} else { // Not a valid user ID.
	echo '<p class="error">This page has been accessed in error.</p>';
}

//Close mysql connection
mysqli_close($dbc);
		
include ('includes/footer.html');
?>