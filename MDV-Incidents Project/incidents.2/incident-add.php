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
    <p>Insert your incidence:</p>
<form action="incident-add.php" method="POST">
    <textarea name="description" rows="4" cols="40"></textarea> </br>
    <input type="submit" value="submit"/>
</form>
</body>


<?php 

if ($_SERVER['REQUEST_METHOD'] !== 'POST') { //if is not post end the script here
    die;
}



require ('../mysqli_connect.php'); //connect to sql


	if (empty($_POST['description'])) { //see if is empty the value
		$errors[] = 'You forgot enter you incidence.'; // save in this array the string's error
	} else { 
	    //Save in $tex the spread characters.
		$tex = mysqli_real_escape_string($dbc, trim($_POST['description'])); //escape special caracters
	}


if(empty($errors)){ //if all is ok
    	$ins =  "INSERT INTO INCIDENTS (status, open_date, description, creator_uid) VALUES ('OPEN',curdate(),'$tex',{$_SESSION['uid']})" ; // add in sql the insert
    	$r = @mysqli_query ($dbc, $ins); //make query the database
    	if ($r){//if make it
    	echo "Successful";
    	    
    	}else{// if don't make it
    	echo "Error to insert";
    	
    	    
    	}
}else{ //if have errors
    echo"Error";
   foreach ($errors as $error){//run the var errors and show the message
       echo $error;
   }
    
}
	mysqli_close($dbc); // Close the database connection.
		
		exit();
?>