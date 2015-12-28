<?php 

//This page is the first that the user will see. 
//Is used by the user to identify himself.
include ('includes/header.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

	// Need two helper files:
	require ('includes/login_functions.inc.php');
	require ('../mysqli_connect.php');
		
	// Check the login:
	list ($check, $data) = check_login($dbc, $_POST['email'], $_POST['passwd']);
	
	if ($check) { // OK!
		
		// Set the session data:
		session_start();
		$_SESSION['uid']  = $data['uid'];
		$_SESSION['name'] = $data['name'];
	
	
		// Redirect:
		redirect_user('home.php');
			
	} else { // Unsuccessful!

		// Assign $data to $errors for login_page.inc.php:
		$errors = $data;
	}
	mysqli_close($dbc); // Close the database connection.

} // End of the main submit conditional.

// Print any error messages, if they exist:
if (isset($errors) && !empty($errors)) {
	echo '<h1>Error!</h1>
	<p class="error">The following error(s) occurred:<br />';
	foreach ($errors as $msg) {
		echo " - $msg<br />\n";
	}
	echo '</p><p>Please try again.</p>';
}

// Display the form:
?>
<h1>Login</h1>
<form action="index.php" method="post">
	<p>Email Address: <input type="text" name="email" size="20" maxlength="60"/></p>
	<p>Password: <input type="password" name="passwd" size="20" maxlength="20"/></p>
	<p><input type="submit" name="submit" value="Login" /></p>
</form>

<?php include ('includes/footer.html');
?>