<?php
//ini_set("display_errors", true);
//error_reporting(E_ALL);
session_start();

include '../../../dbconnect.php';
require("functions.php");
	$roomName = $sql = "";
	$roomErr = "";

	if($_SERVER['REQUEST_METHOD']=='POST' && $_POST){
		$_SESSION["roomErr"] = 0;
		$roomName = $_POST['room1'];
		$roomName = cleanData($GLOBALS['db'], $roomName);
		$roomErr = validate($roomName, $_SESSION["gid"], $GLOBALS['db']);
			if(empty($roomErr)){
				sendData($roomName, $_SESSION["gid"]);
				redirect("../houseSettings.php");
			}else{
				$_SESSION["roomErr"] = 1;
				redirect("../houseSettings.php");
			}//ifelse

	}//if

	//FUNCTIONS
	function cleanData($db, $data){
		$data = trim($data);
		$data = stripslashes($data);
		$data = htmlspecialchars($data);
		$data = mysqli_real_escape_string($db, $data);
		return $data;
	}//cleanData

	function validate($data, $gid, $db1) {

				$data = strtolower($data);
				$data = ucfirst($data);
				$sql = "SELECT * FROM room WHERE name = '$data' AND GID = '$gid'";
				$result = mysqli_query($db1, $sql);

				$count = mysqli_num_rows($result);
				if($count != 0){
					$_SESSION["roomDup"] = 1;
					return "Room already exists";
				}//if
				return "";

	}//function validate

	function sendData($name, $group){
		if($_SERVER['REQUEST_METHOD']=='POST' && $_POST){
      $sql = "INSERT INTO room (name, GID) VALUES ('$name', '$group')";
      $result = mysqli_query($GLOBALS['db'], $sql);
      if(!$result){
        die('Error: ' . mysqli_error($db). ' Error: '. mysqli_errno($db));
      }//if
      else{
        $_SESSION["roomSuc"] = 1;
      }//else
		}//if
	}//function sendData
?>
