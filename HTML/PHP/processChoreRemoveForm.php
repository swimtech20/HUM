<?php
ini_set("display_errors", true);
error_reporting(E_ALL);
	session_start();
	require_once("functions.php");
	include '../../../dbconnect.php';
 	$sql = "";
	$cErr = "";
	$_SESSION["remErr"] = $_SESSION["remSuc"] = 0;

	if($_SERVER['REQUEST_METHOD']=='POST'){
			$cid = $_POST['choreList'];
			if(!empty($cid)){
				$cErr = remove($cid);
				if(!empty($cErr)){
					$_SESSION["remErr"] = 1;
				}
				else {
					$_SESSION["remSuc"] = 1;
				}
			}//if
			redirect("../choreSettings.php");
	}//if

	//FUNCTIONS
	function remove($data) {
				$sql = "DELETE FROM chore WHERE CID = '$data';";
				$result = mysqli_query($GLOBALS['db'], $sql);

				if(!$result){
						return "error";
				}
				else{
						return "";			
				}
	}//function remove

?>
