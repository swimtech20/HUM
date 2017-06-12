<?php
session_start();
include '../../../dbconnect.php';
require_once("functions.php");
ini_set("display_errors", true);
error_reporting(E_ALL);
	$tTitle = $taskDate = $sql = "";
	$titleErr = $taskDateErr = "";
	$_SESSION["tErr"] = $_SESSION["taskSuc"] = $_SESSION["createErr"] = 0;

	if($_SERVER['REQUEST_METHOD']=='POST'){
		$tTitle = cleanData($GLOBALS['db'], $_POST['task']);
			$titleErr = validate($tTitle);
			if(!empty($titleErr)){
				$_SESSION["tErr"] = 1;
				redirect("../taskSettings.php");
			}//if
			$time = $_POST['taskDate'];
			else{
				sendData($tTitle, $_SESSION["gid"], $time);
				redirect("../taskSettings.php");
			}
	}//if

	//FUNCTIONS
	function cleanData($db, $data){
		$data = trim($data);
		$data = stripslashes($data);
		$data = htmlspecialchars($data);
		$data = mysqli_real_escape_string($db, $data);
		return $data;
	}//cleanData

	function validate($data) {
			$data = strtolower($data);
			$data = ucfirst($data);
			$gid = $_SESSION["gid"];

					$sql = "SELECT * FROM task WHERE name = '$data' AND GID = '$gid'";
					$result = mysqli_query($GLOBALS['db'], $sql);

					$count = mysqli_num_rows($result);
					if($count != 0){
						return "Task of the same name already exists";
					}
					else {
						return "";
					}

	}//function validate

	function sendData($task, $gid, $time){
			$sql = "INSERT INTO task (name, GID, time) VALUES ('$task','$gid', '$time' )";
			$result = mysqli_query($GLOBALS['db'], $sql);

			if(!$result){
				$_SESSION["createErr"] = 1;
			}
			else{
				$_SESSION["taskSuc"] = 1;
			}//ifelse
	}//function sendData
?>
