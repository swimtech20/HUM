<?php
	ini_set("display_errors", true);
	error_reporting(E_ALL);
	require_once("functions.php");
	include '../../../dbconnect.php';

	$emailErr = $dbResult = "";

	if($_SERVER['REQUEST_METHOD']=='POST'){

		/*USER CREDENTIALS*/
		$taskname = mysqli_real_escape_string($GLOBALS['db'], $_POST['taskname']);

		$sql = "SELECT TID FROM task WHERE name = '$taskname';"; //sql statement
		$result = mysqli_query($GLOBALS['db'], $sql); //query db
		$count = mysqli_num_rows($result); //get number of rows in query
		if($count == 1){
			$query = mysqli_fetch_object($result); //get the task id
			$tid = $query->TID;
			$sql2 = "DELETE FROM task WHERE TID = '$tid';"; //sql statement
			$result2 = mysqli_query($db, $sql2);
			if($result2 == false){
				session_start();
				$_SESSION["taskDeleteErr"] = 1;
				redirect("../welcome.php");
    	}else{
				session_start();
				$_SESSION["taskDeleteSuc"] = 1;
				redirect("../welcome.php");
			}//ifelse
		}//if count

	}//POST if
