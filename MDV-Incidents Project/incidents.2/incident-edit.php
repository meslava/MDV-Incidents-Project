<?php # Script - incident-edit.php
// This page is for editing an incident ticket.
// This page is accessed through incident-list.php.
session_start();
$page_title = 'Edit an incident ticket';
require('includes/header.php');
require('checksession.php');
checksession();


echo '<h1>Edit an incident ticket</h1>';

// Check for a valid user ID, through GET or POST:
if ((isset($_GET['uid'])) && (is_numeric($_GET['uid']))) { // From incident-list.php
    $uid = $_GET['uid'];
} elseif ((isset($_POST['uid'])) && (is_numeric($_POST['uid']))) { // Form submission.
    $uid = $_POST['uid'];
} else { // No valid ID, kill the script.
    echo '<p class="error">This page has been accessed in error.</p>';
    include('includes/footer.html');
    exit();
}

require('../mysqli_connect.php');

// Check if the form has been submitted:
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    //Query to know the group of the user that is loged in.
    $qgroup    = "SELECT  `group` FROM  `USERS` WHERE uid ={$_SESSION['uid']}";
    //Run the query
    $rgroup    = mysqli_query($dbc, $qgroup);
    //Saves the number of rows result of the query in the var $num
    $num       = mysqli_num_rows($rgroup);
    $rowgroups = mysqli_fetch_array($rgroup, MYSQLI_ASSOC);
    //One user only has one group, so the result must be equal to 1.
    if ($num == 1) {
        $errors = array();
        
        if ($rowgroups['group'] == user) {
            if (empty($_POST['description'])) {
                $errors[] = 'You forgot to enter a description.';
            } else {
                $descr = mysqli_real_escape_string($dbc, trim($_POST['description']));
            }
            
            if (empty($errors)) {
                //Set the query
                $q = "UPDATE INCIDENTS SET description='$descr' WHERE creator_uid=$uid LIMIT 1";
                //Run the query
                $r = @mysqli_query($dbc, $q);
                
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
                echo '</p><p>Please try again.</p>'; // If everything's OK.
            }
        } elseif ($rowgroups['group'] == technician) {
        	
        //Progress can be empty.
                $progress = mysqli_real_escape_string($dbc, trim($_POST['progress']));
            
        	//This is just in case. The valors insert on the status filed are defined by the form and can't be modified by the user.
        	$status = mysqli_real_escape_string($dbc, trim($_POST['status']));
        	if (empty($errors)) {
                //Set the query
                //If the status is OPEN mybe its a reopened ticket, so the close_date has to be null
                if ($status=="OPEN") {
                	$q = "UPDATE INCIDENTS SET progress='$progress', status='$status', close_date=NULL WHERE creator_uid=$uid";
                //If the status is closed, means that now the ticket is closed, so the close_date must be the date of the moment of closure.
                }elseif ($status=="CLOSED") {
                	$q = "UPDATE INCIDENTS SET progress='$progress', status='$status', close_date=CURDATE() WHERE creator_uid=$uid LIMIT 1";
                	   
                	 
                }
                
                //Run the query
                $r = @mysqli_query($dbc, $q);
                
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
                echo '</p><p>Please try again.</p>'; // If everything's OK.
            }
        
        	
        } elseif ($rowgroups['group'] == chief_technician) {
                //Progress can be empty.
                $progress = mysqli_real_escape_string($dbc, trim($_POST['progress']));
            
        	//This is just in case. The valors insert on the status filed are defined by the form and can't be modified by the user.
        	$status = mysqli_real_escape_string($dbc, trim($_POST['status']));
        	
        	//The chief technician is the only that can be able to modify the assigned technician for the incidents.
        	$assigned_uid = mysqli_real_escape_string($dbc, trim($_POST['assigned_uid']));
        	
        	if (empty($errors)) {
                //Set the query
                //If the status is OPEN mybe its a reopened ticket, so the close_date has to be null
                if ($status=="OPEN") {
                	$q = "UPDATE INCIDENTS SET progress='$progress', status='$status', close_date=NULL, assigned_uid='$assigned_uid' WHERE creator_uid=$uid";
                //If the status is closed, means that now the ticket is closed, so the close_date must be the date of the moment of closure.
                }elseif ($status=="CLOSED") {
                	$q = "UPDATE INCIDENTS SET progress='$progress', status='$status', close_date=CURDATE(), assigned_uid='$assigned_uid' WHERE creator_uid=$uid LIMIT 1";
                	   
                	 
                }
                
                //Run the query
                $r = @mysqli_query($dbc, $q);
                
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
                echo '</p><p>Please try again.</p>'; // If everything's OK.
            }
            
            
        }else{
            echo "The group checked this not allow here";
        
        
        
        
        /*	// Check for a first name:
        if (empty($_POST['technician'])) {
        $errors[] = 'You forgot to enter a new technician.';
        } else {
        $tc = mysqli_real_escape_string($dbc, trim($_POST['technician']));
        }
        */
        // Check for description
        
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
        
*/
        } // End of else from check of group
    }else{ // End of else (empty($errors)) IF.
        echo "The user have more than one group";
    } 
    
} // End of submit conditional.

//Query to know the group of the user that is loged in.
$qgroup    = "SELECT  `group` FROM  `USERS` WHERE uid ={$_SESSION['uid']}";
//Run the query
$rgroup    = mysqli_query($dbc, $qgroup);
//Saves the number of rows result of the query in the var $num
$num       = mysqli_num_rows($rgroup);
$rowgroups = mysqli_fetch_array($rgroup, MYSQLI_ASSOC);
//One user only has one group, so the result must be equal to 1.
if ($num == 1) {
    //Form generation if the user is part of the group users.
    if ($rowgroups['group'] == user) {
        
        // Retrieve the user's information:
        $q = "SELECT i.description FROM INCIDENTS i, USERS u where u.uid=i.creator_uid and u.uid=$uid";
        $r = @mysqli_query($dbc, $q);
        if (mysqli_num_rows($r) == 1) { // Valid user ID, show the form.
            // Get the report's information:
            $row = mysqli_fetch_array($r, MYSQLI_NUM);
            // Create the form:
            echo '<form action="incident-edit.php" method="post">
					<p>Description:</p> <p><textarea name="description" rows="10" cols="30">' . $row[0] . '</textarea></p>
					<p><input type="submit" name="submit" value="Submit" /></p>
					<input type="hidden" name="uid" value="' . $uid . '" />
				</form>';
            
        } else { // Not a valid user ID.
            echo '<p class="error">This page has been accessed in error.</p>';
        }
        
        //Form generation if the user is part of the group technician. 
    } elseif ($rowgroups['group'] == technician) {
        // Retrieve the user's information:
        $q = "SELECT user.name as name, i.open_date, i.close_date, i.status, i.description, i.progress
				FROM INCIDENTS i, USERS user, USERS technician
				WHERE user.uid = i.creator_uid
				AND technician.uid = i.assigned_uid
				AND i.assigned_uid ={$_SESSION['uid']}";
        
        $r = @mysqli_query($dbc, $q);
        
        if (mysqli_num_rows($r) == 1) { // Valid user ID, show the form.
            // Get the report's information:
            $row = mysqli_fetch_array($r, MYSQLI_NUM);
            
            echo '<form action="incident-edit.php" method="post">
				<p>User: ' . $row['0'] . '</p>
				<p>Open since: ' . $row['1'] . '</p>
				<p>Closed since: ' . $row['2'] . '</p>
				<p>Status <select name="status">
					<option ' . ($row['3'] == 'OPEN' ? ' selected ' : "") . 'value="OPEN">OPEN</option>
					<option ' . ($row['3'] == 'CLOSED' ? ' selected ' : "") . 'value="CLOSED">CLOSED</option>
				</select></p>
				<p>Description:' . $row['4'] . '</p>
				<p>Progress:</p> <p><textarea name="progress" rows="10" cols="30">' . $row['5'] . '</textarea></p>
				<p><input type="submit" name="submit" value="Submit" /></p>
				<input type="hidden" name="uid" value="' . $uid . '" />
			</form>';
        }
        
        //Form generation if the user is part of the group chief_technician
    } elseif ($rowgroups['group'] == chief_technician) {
        // Retrieve the user's information:
        $q = "SELECT user.name as name, i.open_date, i.close_date, i.status, i.description, i.progress, i.assigned_uid
				FROM INCIDENTS i, USERS user, USERS technician
				WHERE user.uid = i.creator_uid
				AND technician.uid = i.assigned_uid
			";
        
        $r = @mysqli_query($dbc, $q);
        
        if (mysqli_num_rows($r) == 1) { // Valid user ID, show the form.
            // Get the report's information:
            $row = mysqli_fetch_array($r, MYSQLI_NUM);
            
            echo '<form action="incident-edit.php" method="post">
				<p>User: ' . $row['0'] . '</p>
				<p>Open since: ' . $row['1'] . '</p>
				<p>Closed since: ' . $row['2'] . '</p>
				<p>Status <select name="status">
					<option ' . ($row['3'] == 'OPEN' ? ' selected ' : "") . 'value="OPEN">OPEN</option>
					<option ' . ($row['3'] == 'CLOSED' ? ' selected ' : "") . 'value="CLOSED">CLOSED</option>
				</select></p>
				<p>Description:' . $row['4'] . '</p>
				<p>Progress:</p> <p><textarea name="progress" rows="10" cols="30">' . $row['5'] . '</textarea></p>
				<p>Assigned_uid:<input type="text" name="assigned_uid" value="' . $row['6'] . '"/></p>
				<p><input type="submit" name="submit" value="Submit" /></p>
				<input type="hidden" name="uid" value="' . $uid . '" />
			</form>';
        }
    } else {
        echo '<p class="error">Something went wrong.</p>';
    }
}
//Close mysql connection
mysqli_close($dbc);

include('includes/footer.html');
?>