<?php # Script 9.6 - view_users.php #2
// This script retrieves all the records from the incidents table.

$page_title = 'View the reported incidents list';
include ('includes/header.html');

// Page header:
echo '<h1>Reported incidents list</h1>';

require ('../mysqli_connect.php'); // Connect to the db.
		
// Make the query:
$q = "SELECT IID, user, technician, status, open_date, close_date, description FROM incidents ORDER BY open_date DESC";
$r = mysqli_query ($dbc, $q); // Run the query.

// Count the number of returned rows:
$num = mysqli_num_rows($r);

if ($num > 0) { // If it ran OK, display the records.

	// Print how many users there are:
	echo "<p>There are currently $num reported incidents.</p>\n";

	// Table header.
	echo '<table align="center" cellspacing="15" cellpadding="3" width="90%">
			<tr class="colorh1"><td align="left"><b>Edit</b></td>
			<td align="left"><b>User</b></td>
			<td align="left"><b>Assigned Technician</b></td>
			<td align="left"><b>Current Status</b></td>
			<td align="left"><b>Open since...</b></td>
			<td align="left"><b>Closed since...</b></td>
			<td align="left"><b>Description</b></td></tr>
		';
	// Fetch and print all the records:
	while ($row = mysqli_fetch_array($r, MYSQLI_ASSOC)) {
		//Sets the status color. If the status is OPEN it will be displayed with green text. Otherwise it will be displayed as red.
		$sc = ($row['status']=='OPEN' ? '#509d2b' : '#ac0123');
		echo '<tr>
		      <td align="left"><a href="incident-edit.php?IID='.$row['IID'].'">Edit</a></td>
			  <td align="left">' . $row['user'] . '</td>
			  <td align="left">' . $row['technician'] . '</td>
			  <td align="left"> <font color="'.$sc.'">' . $row['status'] . '</font color></td>
			  <td align="left">' . $row['open_date'] . '</td>
			  <td align="left">' . $row['close_date'] . '</td>
			  <td align="left">' . $row['description'] . '</td></tr>
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