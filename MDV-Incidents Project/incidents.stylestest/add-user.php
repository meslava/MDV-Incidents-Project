<?php 


$page_title = 'Add a new user';
include ('includes/header.php');
require ('checksession.php');
checksession();

//Starts the connection to the database.
require ('../mysqli_connect.php'); 

  //Query to know the group of the user that is logged in.
    $qgroup = "SELECT  `group` FROM  `USERS` WHERE uid ={$_SESSION['uid']}";
    //Run the query
    $rgroup = mysqli_query($dbc, $qgroup);
    //Saves the number of rows result of the query in the var $num
    $num = mysqli_num_rows($rgroup);
    $rowgroups = mysqli_fetch_array($rgroup, MYSQLI_ASSOC);

if ($rowgroups['group'] != chief_technician) {
	
	require ('includes/login_functions.inc.php');
	redirect_user(home.php);
}      

// Check for form submission:
if ($_SERVER['REQUEST_METHOD'] == 'POST') {

	$errors = array(); // Initialize an error array.
	
	// Check for a first name:
	if (empty($_POST['name'])) {
		$errors[] = 'You forgot to enter your first name.';
	} else {
		$name = mysqli_real_escape_string($dbc, trim($_POST['name']));
	}
	
	// Check for a last name:
	if (empty($_POST['last_name'])) {
		$errors[] = 'You forgot to enter your last name.';
	} else {
		$lastname = mysqli_real_escape_string($dbc, trim($_POST['last_name']));
	}
	
	// Check for a password and match against the confirmed password:
	if (!empty($_POST['pass1'])) {
		if ($_POST['pass1'] != $_POST['pass2']) {
			$errors[] = 'Your password did not match the confirmed password.';
		} else {
			$passwd = mysqli_real_escape_string($dbc, trim($_POST['pass1']));
		}
	} else {
		$errors[] = 'You forgot to enter your password.';
	}
	
	//This is just in case. The valorsto insert on the group filed are defined by the form and can't be modified by the user.
	$group=mysqli_real_escape_string($dbc, trim($_POST['group']));

	
	if (empty($errors)) { // If everything's OK.
	
		//Generate an email for the new user, based of the first letter of the name and the complete last_name
		
		$email=substr($name,0,1).$lastname.'@company.com';
		$email=strtolower($email);
	
		// Register the user in the database...
		
		// Make the query:
		$q = "INSERT INTO USERS (name, last_name, email, `group`, passwd) VALUES ('$name', '$lastname', '$email', '$group', SHA1('$passwd'))";		
		$r = @mysqli_query ($dbc, $q); // Run the query.
		if ($r) { // If it ran OK.
		
			// Print a message:
			echo '<h1>User registred succesfully!</h1>
		<p>You registred a user with the following data.</p>
		<ul>
		<li>Name:'.$name.'</li>
		<li>Last name:'.$lastname.'</li>
		<li>Group:'.$group.'</li>
		<li>Email:'.$email.'</li>
		</ul>';	
		
		} else { // If it did not run OK.
			
			// Public message:
			echo '<h1>System Error</h1>
			<p class="error">You could not register a new user due to a system error. We apologize for any inconvenience.</p>'; 
			
			// Debugging message:
			echo '<p>' . mysqli_error($dbc) . '<br /><br />Query: ' . $q . '</p>';
						
		} // End of if ($r) IF.
		
		mysqli_close($dbc); // Close the database connection.

		// Include the footer and quit the script:
		include ('includes/footer.html'); 
		exit();
		
	} else { // Report the errors.
	
		echo '<h1>Error!</h1>
		<p class="error">The following error(s) occurred:<br />';
		foreach ($errors as $msg) { // Print each error.
			echo " - $msg<br />\n";
		}
		echo '</p><p>Please try again.</p><p><br /></p>';
		
	} // End of if (empty($errors)) IF.
	
	mysqli_close($dbc); // Close the database connection.

} // End of the main Submit conditional.
?>
<h1>Register</h1>
<form action="add-user.php" method="post">
	<p>First Name: <input type="text" name="name" size="15" maxlength="20" value="<?php if (isset($_POST['name'])) echo $_POST['name']; ?>" /></p>
	<p>Last Name: <input type="text" name="last_name" size="15" maxlength="40" value="<?php if (isset($_POST['last_name'])) echo $_POST['last_name']; ?>" /></p>
	<p>Group <select name="group">
					<option selected value="user">User</option>
					<option value="technician">Technician</option>
					<option value="chief_technician">Chief technician</option>
				</select></p>
	<p>Password: <input type="password" name="pass1" size="10" maxlength="20" value="<?php if (isset($_POST['pass1'])) echo $_POST['pass1']; ?>"  /></p>
	<p>Confirm Password: <input type="password" name="pass2" size="10" maxlength="20" value="<?php if (isset($_POST['pass2'])) echo $_POST['pass2']; ?>"  /></p>
	<p><input type="submit" name="submit" value="Register" /></p>
</form>
<?php include ('includes/footer.html'); ?>