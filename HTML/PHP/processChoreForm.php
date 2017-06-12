<?php
ini_set("display_errors", true);
error_reporting(E_ALL);
	session_start();
	require_once("functions.php");
	include '../../../dbconnect.php';
	$cTitle = $username = $sql = "";
	$titleErr = $uidErr = "";
	$_SESSION["tErr"] = $_SESSION["uErr"] = $_SESSION["choreSuc"] = $_SESSION["assignErr"] = 0;

	if($_SERVER['REQUEST_METHOD']=='POST'){
			$giD = $_SESSION["gid"];
			$cTitle = cleanData($GLOBALS['db'], $_POST['chore']);
			$titleErr = validate($cTitle, 'chore', $giD);
			$username = $_POST['choreOwner'];
			$uidErr = validate($username, 'choreOwner', $giD);
			
			if(!empty($titleErr)){
				$_SESSION["tErr"] = 1;
				redirect("../choreSettings.php");
			}//if
			elseif(!empty($uidErr)) {
				$_SESSION["uErr"]	= 1;
				redirect("../choreSettings.php");
			}
			else{
				sendData($cTitle, $username, $giD);
				redirect("../choreSettings.php");
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

	function validate($data, $field, $gid) {
		switch($field) {
			case 'chore':{
				$data = strtolower($data);
				$data = ucfirst($data);
				$sql = "SELECT * FROM chore WHERE title = '$data' AND GID = '$gid'";
				$result = mysqli_query($GLOBALS['db'], $sql);

				$count = mysqli_num_rows($result);
				if($count != 0){
					return "Chore already exists";
				}
				else {
					return "";
				}
				return "";
			}//case cTitle

			case 'choreOwner':{
				if(empty($data)){
					return "Must select someone to do the chore.";
				}
				return "";
			}//case choreOwner
		}
	}

	function sendData($name, $owner, $group){
					$sql = "INSERT INTO chore (title, GID, UID) VALUES ('$name', '$group', '$owner')";
					$result = mysqli_query($GLOBALS['db'], $sql);

					if(!$result){
						$_SESSION["assignErr"] = 1;
					}
					else{
						$_SESSION["choreSuc"] = 1;
					}//ifelse

	}//function sendData
?>
