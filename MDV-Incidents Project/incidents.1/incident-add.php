<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <?php session_start();
         $page_title = 'add incident';
         include ('includes/header.php');
         require ('checksession.php');
        checksession();
?>
	<title></title>
	</head>
<body>
    <p>Insert your incidence</p>
<form action="incident_add.php" method="POST">
    <textarea name="description" rows="4" cols="40" class=estilotextarea> write here</textarea> </br>
    <input type="submit" value="submit"/>
</form>
</body>


<?php 

if ($_SERVER['REQUEST_METHOD'] !== 'POST') { //if not is post end the script here
    die;
}



require ('../mysqli_connect.php'); //connect to sql


	if (empty($_POST['description'])) { //see if is empty the value
		$errors[] = 'You forgot enter you incidence.';
	} else {
		$tex = mysqli_real_escape_string($dbc, trim($_POST['description'])); 
	}


if(empty($errors)){ //if all is ok
    	$ins =  "INSERT INTO INCIDENTS (status, open_date, description, creator_uid) VALUES ('OPEN',curdate(),'$tex',{$_SESSION['uid']})" ;
    	$r = @mysqli_query ($dbc, $ins); 
    	if ($r){
    	echo "Successful";
    	    
    	}else{
    	echo "Error to insert";
    	
    	    
    	}
}else{ //if have errors
    echo"Error";
   foreach ($errors as $error){
       echo $error;
   }
    
}
	mysqli_close($dbc); // Close the database connection.
		
		exit();
?>