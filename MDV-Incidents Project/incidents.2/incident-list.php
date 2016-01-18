<?php //incident-list.php
// This script shows all the information from de INCIDENT TABLE.
//If the user belongs to the group user he will only be able to see and edit the tickets created by himself.
//If the user belongs to the group technician he will only be able to see and edit the tickets created or assigned to himself.
//If the user belongs to the group chief_technician he will be able to see all the tickets.
session_start();
$page_title = 'View the tickets of incidents';
include ('includes/header.php');
require ('checksession.php');
checksession();

// Page header:
echo '<h1>Incidents tickets list</h1>';

require ('../mysqli_connect.php'); // Connect to the db.

  //Query to know to which group the user belongs.
    $qgroup = "SELECT  `group` FROM  `USERS` WHERE uid ={$_SESSION['uid']}";
    //Run the query
    $rgroup = mysqli_query($dbc, $qgroup);
   //Saves the result number of rows from the query in the var $num.
    $num = mysqli_num_rows($rgroup);
   //Saves the result row as an associative array in rowgroups.
    $rowgroups = mysqli_fetch_array($rgroup, MYSQLI_ASSOC);
        
//Checks if the user belongs to the group user or tehnician     
if ($rowgroups['group'] == user || $rowgroups['group'] == technician ) {			
		
//Query to get the data to fill the user and technician form.

$q = "SELECT user.uid, user.name as user,technician.name as technician,i.status, i.open_date, i.close_date, i.description, i.progress, i.iid 
FROM
  INCIDENTS i,
  USERS user,
  USERS technician
where user.uid=i.creator_uid and technician.uid=i.assigned_uid and (user.uid='".$_SESSION['uid']."' or technician.uid='".$_SESSION['uid']."')";
$r = mysqli_query ($dbc, $q); // Run the query.

// Count the number of returned rows:
$num = mysqli_num_rows($r);

}else if ($rowgroups['group'] == chief_technician) {
	//Query to get the data to fill the chief_technician form.
	$q = "SELECT user.uid, user.name as user,technician.name as technician,i.status, i.open_date, i.close_date, i.description , i.progress, i.iid
FROM
  INCIDENTS i,
  USERS user,
  USERS technician
where user.uid=i.creator_uid and technician.uid=i.assigned_uid";
$r = mysqli_query ($dbc, $q); // Run the query.

// Count the number of returned rows:
$num = mysqli_num_rows($r);


}else{
	echo "The group checked doesn't exist";
}// End of else from check of group


		if ($num > 0) { // If it ran OK, display the records.

			// Print how many users there are:
			echo "<p>There are currently $num reported incidents.</p>\n";

			// Table header.
			echo '<table align="center" cellspacing="15" cellpadding="5">
			
			<tr><td align="left"><b>Edit</b></td>
				<td align="left"><b>User</b></td>
				<td align="left"><b>Assigned Technician</b></td>
				<td align="left"><b>Current Status</b></td>
				<td align="left"><b>Open since...</b></td>
				<td align="left"><b>Closed since...</b></td>
				<td align="left"><b>Description</b></td>
				<td align="left"><b>Progress</b></td></tr>';

			// Fetch and print all the records:
			// While $row is equal to the result row (for every incident),display the options..
				while ($row = mysqli_fetch_array($r, MYSQLI_ASSOC)) {
		
			//Sets the status color. If the status is OPEN it will be displayed with green text. Otherwise it will be displayed as red.
					$sc = ($row['status']=='OPEN' ? '#509d2b' : '#ac0123');
					echo '<tr>
					<td align="left"><a href="incident-edit.php?iid='.$row['iid'].'">Edit</a></td>
					<td align="left">' . $row['user'] . '</td>
					<td align="left">' . $row['technician'] . '</td>
					<td align="left"> <font color="'.$sc.'">' . $row['status'] . '</font color></td>
					<td align="left">' . $row['open_date'] . '</td>
					<td align="left">' . $row['close_date'] . '</td>
					<td align="left">' . $row['description'] . '</td>
					<td align="left">' . $row['progress'] . '</td></tr>
					';
				}
	echo '</table>'; // Close the table.
	mysqli_free_result ($r); // Free up the resources.	

		} else { // If no records were returned.
			echo '<p class="error">There are currently no incidents reported.</p>';
}

mysqli_close($dbc); // Close the database connection.

include ('includes/footer.html');
?>