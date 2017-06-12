<?php
session_start();
include '../../../dbconnect.php';
require_once("functions.php");
//ini_set("display_errors", true);
//error_reporting(E_ALL);
	$gName = $sql = "";
	$nameErr = "";
	$_SESSION["gnameErr"] = $_SESSION["groupSuc"] = $_SESSION["groupErr"] = $_SESSION["gnameSuc"] = 0;

	if($_SERVER['REQUEST_METHOD']=='POST'){
		$gName = cleanData($GLOBALS['db'], $_POST['groupName']);
		$nameErr = validate($gName);
		if(!empty($nameErr)){
			$_SESSION["gnameErr"] = 1;
			redirect("../houseSettings.php");
		}
		else{
			if($_SESSION["gid"]==0){
				$accesscode = uniqid();
				$sql2 = "INSERT INTO group_info (group_name, access_code) VALUES ('$gName', '$accesscode');";
				mysqli_query($db, $sql2) or die("Error: ".mysqli_error($db));
				$sql2 = "SELECT GID FROM group_info WHERE group_name = '$gName' AND access_code = '$accesscode'";//and access_code = acode
				$result = mysqli_query($db, $sql2) or die("Error: ".mysqli_error($db));
				$temp = mysqli_fetch_object($result);
				$userGID = $temp -> GID;
				$uid = $_SESSION["login_user"];
				$sql2 = "UPDATE user_info SET GID = '$userGID' WHERE UID = '$uid'";
				$result = mysqli_query($db, $sql2);
				if($result){
					$_SESSION["gid"] = $userGID;
					$_SESSION["groupSuc"] = 1;
				}
				else{
					die("Error: ".mysqli_error($db));
					$_SESSION["groupErr"] = 1;
				}
				redirect("../houseSettings.php");
			}else{
				sendData($gName, $_SESSION["gid"]);
				redirect("../houseSettings.php");
			}//ifelse
		}//elseif nameErr empty
	}//if

	//FUNCTIONS
	function cleanData($db, $data){
		$data = trim($data);
		$data = stripslashes($data);
		$data = htmlspecialchars($data);
		$data = mysqli_real_escape_string($db, $data);
		return $data;
	}//cleanData

	function validate($data){
				$regex = '/^(.*[a-zA-Z0-9][^\'])$/';
				if(!empty($data)){
					if(!preg_match($regex, $data)){
						return "Groupname cannot have single quotes.";
					}//if pregmatch
				}//if empty
				return "";
	}//function validate

	function sendData($name, $gid){
			$sql = "UPDATE group_info SET group_name = '$name' WHERE GID = '$gid'";
			$result = mysqli_query($GLOBALS['db'], $sql);

			if(!$result){
				die('Error: ' . mysqli_error($GLOBALS['db']));
			}
			else{
				$_SESSION["gnameSuc"] = 1;
			}//ifelse
	}//function sendData
?>
