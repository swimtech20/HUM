<?php
session_start();
include '../../../dbconnect.php';
require_once("functions.php");
ini_set("display_errors", true);
error_reporting(E_ALL);
	$eTime = $eDate = $sql = "";
	$_SESSION["conflictErr"] = $_SESSION["laundrySuccess"] = $_SESSION["laundryDbErr"] = 0;

	if($_SERVER['REQUEST_METHOD']=='POST' && $_POST){
		$gid = $_SESSION["gid"];
		$uid = $_SESSION["login_user"];
				$eTime = $_POST['eventTime'];
				$eDate = $_POST['eventDate'];
				$datetime = date('Y-m-d H:i:s', strtotime("$eDate $eTime"));
				$conflictErr = validate($datetime);
				if(!empty($conflictErr)){
					$_SESSION["conflictErr"] = 1;
					redirect("../eventSettings.php");
				}//if
				else{
					sendData($datetime, $uid, $gid);
					redirect("../eventSettings.php");
				}//else
						
	}//if

	function validate($data) {
				$sql = "Select * from laundry where time <= date_add('$data', INTERVAL 60 MINUTE) and time >= date_sub('$data', INTERVAL 60 MINUTE);";
				$result = mysqli_query($GLOBALS['db'], $sql);

				$count = mysqli_num_rows($result);
				if($count != 0){
					return "There are schedule conflicts within an hour of your reservation. Please select an alternate time.";
				}//if
				else {
					return "";
				}//else
	}//function validate

	function sendData($eDatetime, $uid, $gid){

				$sql = "INSERT INTO laundry (time, UID, GID) VALUES ('$eDatetime','$uid','$gid')";
				$result = mysqli_query($GLOBALS['db'], $sql);
				if(!$result){
					$_SESSION["laundryDbErr"] = 1;
					die('Error: ' . mysqli_error($GLOBALS['db']));
				}//if
				else{
					$_SESSION["laundrySuccess"] = 1;
				}//else
	}//function
?>
