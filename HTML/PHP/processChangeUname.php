<?php
	session_start();
	//ini_set("display_errors", true);
	//error_reporting(E_ALL);
	include '../../../dbconnect.php';
	require_once("functions.php");

	if($_SERVER["REQUEST_METHOD"] == "POST") {

		$newAlias = mysqli_real_escape_string($db, $_POST['newAlias']);
		if(!empty($newAlias)){
			$newAlias = cleanData($newAlias);
			$uid = $_SESSION["login_user"];
			$sql = "UPDATE user_info SET username = '$newAlias' WHERE user_info.UID = '$uid'";
			$result = mysqli_query($db, $sql);
			if($result){
				$_SESSION["changeUnameSuc"] = 1;
				redirect("../userSettings.php");
			}else{
				$_SESSION["usernameErr"] = 1;
			}//ifelse result
		}elseif(empty($newAlias)){
			$_SESSION["emptyUsernameErr"] = 1;
			redirect("../userSettings.php");
		}//elseif empty

	}//request method post if()


	function cleanData($data){
		$data = trim($data);
		$data = stripslashes($data);
		$data = htmlspecialchars($data);
		return $data;
	}//cleanData
?>
