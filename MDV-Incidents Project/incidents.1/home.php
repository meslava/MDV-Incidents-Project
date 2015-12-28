<?php 
session_start();
$page_title = 'Welcome to incidents report page';
include ('includes/header.php');

echo "<h1>Wellcome {$_SESSION['name']}!</h1>";

include ('includes/footer.html');
?>