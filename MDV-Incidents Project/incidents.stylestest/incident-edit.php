<?php # Script - incident-edit.php
// This page is for editing an incident ticket.
// This page is accessed through incident-list.php.
session_start();
$page_title = 'Edit an incident ticket';
require('includes/header.php');
require('checksession.php');
checksession();


echo '<div id="box"><h1>Edit an incident ticket</h1>';

// Check for a valid user ID, through GET or POST:
/*if ((isset($_GET['uid'])) && (is_numeric($_GET['uid']))) { // From incident-list.php
    $uid = $_GET['uid'];
} elseif ((isset($_POST['uid'])) && (is_numeric($_POST['uid']))) { // Form submission.
    $uid = $_POST['uid'];
} else { // No valid ID, kill the script.
    echo '<p class="error">This page has been accessed in error.</p>';
    include('includes/footer.html');
    exit();
}*/

if ((isset($_GET['iid'])) && (is_numeric($_GET['iid']))) { // From incident-list.php
    $iid = $_GET['iid'];
} elseif ((isset($_POST['iid'])) && (is_numeric($_POST['iid']))) { // Form submission.
    $iid = $_POST['iid'];
} else { // No valid IID, kill the script.
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
                $q = "UPDATE INCIDENTS SET description='$descr' WHERE iid=$iid LIMIT 1";
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
                if ($status == "OPEN") {
                    $q = "UPDATE INCIDENTS SET progress='$progress', status='$status', close_date=NULL WHERE iid=$iid";
                    //If the status is closed, means that now the ticket is closed, so the close_date must be the date of the moment of closure.
                } elseif ($status == "CLOSED") {
                    $q = "UPDATE INCIDENTS SET progress='$progress', status='$status', close_date=CURDATE() WHERE iid=$iid LIMIT 1";
                    
                    
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
            //This is just incase since the assigned_uid is result of the values from the <select> that are a result from a query.
            $assigned_uid = mysqli_real_escape_string($dbc, trim($_POST['assigned_uid']));
            
            if (empty($errors)) {
                //Set the query
                //If the status is OPEN mybe its a reopened ticket, so the close_date has to be null
                if ($status == "OPEN") {
                    $q = "UPDATE INCIDENTS SET progress='$progress', status='$status', close_date=NULL, assigned_uid='$assigned_uid' WHERE creator_uid=$uid";
                    //If the status is closed, means that now the ticket is closed, so the close_date must be the date of the moment of closure.
                } elseif ($status == "CLOSED") {
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
        } else {
            echo "The group checked is not allowed here";
            
        } // End of else from check of group
    } else { // End of else (empty($errors)) IF.
        echo "The user have more than one group";
    }
    
} // End of submit conditional.

//Query to know the group of the user that is logged in.
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
        $q = "SELECT i.description FROM INCIDENTS i, USERS u where u.uid=i.creator_uid and i.iid=$iid";
        $r = @mysqli_query($dbc, $q);
        if (mysqli_num_rows($r) >=1) { // Valid user ID, show the form.
            // Get the report's information:
            $row = mysqli_fetch_array($r, MYSQLI_NUM);
            // Create the form:
            echo '<form action="incident-edit.php" method="post">
					<p>Description: </p> <p><textarea name="description" rows="10" cols="30">'.$row[0].'</textarea></p>
					<p><input type="submit" name="submit" value="Submit" /></p>
					<input type="hidden" name="iid" value="'.$iid.'" />
				</form>
				</div>';
            
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
				AND i.assigned_uid ={$_SESSION['uid']}
				AND i.iid=$iid"				;
        
        $r = @mysqli_query($dbc, $q);
        
        if (mysqli_num_rows($r) >= 1) { // Valid user ID, show the form.
            // Get the tickets's information:
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
				<input type="hidden" name="iid" value="' . $iid . '" />
			</form>
			</div>';
        }
        
        //Form generation if the user is part of the group chief_technician
    } elseif ($rowgroups['group'] == chief_technician) {
        // Retrieve the user's information:
        $q = "SELECT user.name as name, i.open_date, i.close_date, i.status, i.description, i.progress, i.assigned_uid 
				FROM INCIDENTS i, USERS user, USERS technician
				WHERE user.uid = i.creator_uid
				AND technician.uid = i.assigned_uid
				and i.iid=$iid";
        
      
        $r = @mysqli_query($dbc, $q);
        
          //Select all the names and last_name of technician to fill the technician select menu.
        $qtechnician = "SELECT concat (name,' ', last_name) as full_name, uid
                        FROM  `USERS` 
                        WHERE  `group` =  'technician'";
        
         $rtechnician = @mysqli_query($dbc, $qtechnician);
 
        
        if (mysqli_num_rows($r) >= 1) { // Valid user ID, show the form.
            // Get the report's information:
            
            $row = mysqli_fetch_array($r, MYSQLI_NUM);
          //  while ($rowtechnician = mysqli_fetch_array($rtechnician, MYSQLI_ASSOC)) {
        // while ($row = mysqli_fetch_array($r, MYSQLI_ASSOC)) {
            
            echo '<form action="incident-edit.php" method="post">
				<p>User: ' . $row['0'] . '</p>
				<p>Open since: ' . $row['1'] . '</p>
				<p>Closed since: ' . $row['2'] . '</p>
				<p>Status <select name="status">
					<option ' . ($row['3'] == 'OPEN' ? ' selected ' : "") . 'value="OPEN">OPEN</option>
					<option ' . ($row['3'] == 'CLOSED' ? ' selected ' : "") . 'value="CLOSED">CLOSED</option>
				</select></p>
				<p>Description:' . $row['4'] . '</p>
				<p>Progress: <textarea name="progress" rows="10" cols="30">' . $row['5'] . '</textarea></p>';
				
			//The chief technician can assing a technician to a ticket.
			//The values of the select are based on the result of the query done above.
	
			 echo	"<p>Assigned technician:<select name='assigned_uid'>";
			 while ($rowtechnician = mysqli_fetch_array($rtechnician)){
				   echo "<option value='".$rowtechnician['uid']."'>".$rowtechnician['full_name']."</option></p>";
				
			 }
			echo	'.</select>
			<p><input type="submit" name="submit" value="Submit" /></p>
				<input type="hidden" name="iid" value="' . $iid . '" />
			</form>
			</div>';
         
        }
    } else {
        echo '<p class="error">Something went wrong.</p>';
    }
}

//Close mysql connection
mysqli_close($dbc);

include('includes/footer.html');
?>