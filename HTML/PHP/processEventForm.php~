<?php
session_start();
include '../../../dbconnect.php';
require_once("functions.php");
ini_set("display_errors", true);
error_reporting(E_ALL);
	$eTitle = $eTime = $eDate = $roomName = $sql = "";
	$titleErr = "";
	$_SESSION["repeatEventErr"] = $_SESSION["eventSuccess"] = $_SESSION["eventDbErr"] = 0;

	if($_SERVER['REQUEST_METHOD']=='POST' && $_POST){
		$gid = $_SESSION["gid"];
		$eTime = $_POST['eventTime'];
		$eDate = $_POST['eventDate'];
		$datetime = date('Y-m-d H:i:s', strtotime("$eDate $eTime"));
		$roomID = $_POST['roomSelect'];
		
		$eTitle = cleanData($_POST['eventName'], $GLOBALS['db']);
		
			$eventErr = validate($gid, $datetime, $roomID);
			if(!empty($eventErr)){
				$_SESSION["repeatEventErr"] = 1;
				redirect("../eventSettings.php");
			}//if
			if(!$hasErrors){
				sendData($eTitle, $eTime, $eDate, $roomID, $gid);
				redirect("../eventSettings.php");
			}

	}//if

	//FUNCTIONS
	function cleanData($data, $db){
		$data = trim($data);
		$data = stripslashes($data);
		$data = htmlspecialchars($data);
		$data = mysqli_real_escape_string($db, $data);
		return $data;
	}//cleanData

//SHOULDN'T CHECK FOR SAME NAME, BUT FOR SAME TIME/DATE IN THE SAME ROOM (TOGETHER)
	function validate($gid, $time, $room) {
				$sql = "SELECT * FROM event WHERE time = '$time' AND RID = '$room' AND GID = '$gid';";
				$result = mysqli_query($GLOBALS['db'], $sql);

				$count = mysqli_num_rows($result);
				if($count != 0){
					return "Event of the same name already exists";
				}
				else {
					return "";
				}
	}//function validate

	function sendData($eTitle, $eTime, $eDate, $roomID, $gid){
				$datetime = date('Y-m-d H:i:s', strtotime("$eDate $eTime"));
				$sql = "INSERT INTO event (time, RID, name, GID) VALUES ('$datetime','$roomID','$eTitle','$gid')";
				$result = mysqli_query($GLOBALS['db'], $sql);
				if(!$result){
					$_SESSION["eventDbErr"] = 1;
					die('Error: ' . mysqli_error($GLOBALS['db']));
				}//if
				else{
					$_SESSION["eventSuccess"] = 1;		
				}
	}//function
?>
