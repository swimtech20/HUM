<?php
	session_start();
	
	require('./PHP/functions.php');

	logout();

	redirect("../index.html");

?>
