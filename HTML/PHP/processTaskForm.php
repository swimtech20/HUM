<?php
session_start();
include '../../../dbconnect.php';
require_once("functions.php");
ini_set("display_errors", true);
error_reporting(E_ALL);
	$tTitle = $taskDate = $sql = "";
	$titleErr = $taskDateErr = "";
	$hasErrors = false;

	if($_SERVER['REQUEST_METHOD']=='POST'){
		$tTitle = cleanData($_POST['task']);
			$titleErr = validate($tTitle, 'tTitle');
			if(!empty($titleErr)){
				$hasErrors = true;
			}//if
		$time = $_POST['taskDate'];
		if(!$hasErrors){
			sendData($tTitle, $_SESSION["gid"], $time);
			redirect("../taskSettings.php");
		}
		else{
			redirect("../taskSettings.php");
		}
	}//if

	//FUNCTIONS
	function cleanData($data){
		$data = trim($data);
		$data = stripslashes($data);
		$data = htmlspecialchars($data);
		return $data;
	}//cleanData

	function validate($data, $field) {
			$data = strtolower($data);
			$data = ucfirst($data);
			$gid = $_SESSION["gid"];

			switch($field){

				case 'tTitle':{
					$sql = "SELECT * FROM task WHERE name = '$data' AND GID = '$gid'";
					$result = mysqli_query($GLOBALS['db'], $sql);

					$count = mysqli_num_rows($result);
					if($count != 0){
						return "Task of the same name already exists";
					}
					else {
						return "";
					}
				}//case tTitle
			 case 'taskDate':{

			 }//case taskDate

			}//switch

	}//function validate

	function sendData($task, $gid, $time){
			$sql = "INSERT INTO task (name, GID, time) VALUES ('$task','$gid', '$time' )";
			$result = mysqli_query($GLOBALS['db'], $sql);

			if(!$result){
				die('Error: ' . mysqli_error($GLOBALS['db']));
			}
			else{
				//echo "Task successfully created and assigned!";
			}//ifelse
	}//function sendData
?>
