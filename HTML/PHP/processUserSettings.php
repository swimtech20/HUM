<?php
	session_start();
	//ini_set("display_errors", true);
	//error_reporting(E_ALL);
	include '../../../dbconnect.php';
	require_once("functions.php");
	$emptyPwErr1 = $emptyPwErr2 = $mismatchPwErr = $invalidPwErr = "";

	if($_SERVER["REQUEST_METHOD"] == "POST") {

			$currentPass = mysqli_real_escape_string($db, $_POST['currentpass']);

			$uid = $_SESSION["login_user"];
			//grab stored hashed password
			$sqlPswd = "SELECT password FROM user_info WHERE user_info.UID = '$uid'";

			//get the hashed password from the db in form of a string
			$pswdResult = mysqli_query($db, $sqlPswd) or die("Error: ".mysqli_error($db));
			$temp = mysqli_fetch_object($pswdResult);
			$dbpassword = $temp->password;

			if(password_verify($currentPass,$dbpassword)){
				$newPass = mysqli_real_escape_string($db, $_POST['newpass']);
				$newPass = cleanData($newPass);
				$rNewPass = mysqli_real_escape_string($db, $_POST['rnewpass']);
				$rNewPass = cleanData($rNewPass);

				$emptyPwErr1 = passVerify1a($newPass);
				$emptyPwErr2 = passVerify1b($rNewPass);
				$mismatchPwErr = passVerify2($newPass, $rNewPass);
				$invalidPwErr = passVerify3($newPass);

				if(empty($emptyPwErr1) && empty($emptyPwErr2) && empty($mismatchPwErr) && empty($invalidPwErr)){
					$hash = password_hash($newPass, PASSWORD_BCRYPT);
					$sql = "UPDATE user_info SET password = '$hash' WHERE user_info.UID = '$uid'";
					$result = mysqli_query($db, $sql) or die("Error: ".mysqli_error($db));
					if($result){
						$_SESSION["successPwChange"] = 1;
						redirect("../userSettings.php");
					}//if result is not false
				} elseif(!empty($emptyPwErr1)){
					$_SESSION["emptyPwErr"] = 1;
					redirect("../userSettings.php");
				} elseif(!empty($emptyPwErr2)){
					$_SESSION["emptyRPwErr"] = 1;
					redirect("../userSettings.php");
				} elseif(!empty($mismatchPwErr)){
					$_SESSION["mismatchPwErr"] = 1;
					redirect("../userSettings.php");
				} elseif(!empty($invalidPwErr)){
					$_SESSION["invalidPwErr"] = 1;
					redirect("../userSettings.php");
				} else {
					$_SESSION["internalErr"] = 1;
					redirect("../userSettings.php");
				}//ifelses
			}else{
				$_SESSION["incorrectOldPw"] = 1;
				redirect("../userSettings.php");
			}//ifelse password_verify
	}//request method post if()

	function cleanData($data){
		$data = trim($data);
		$data = stripslashes($data);
		$data = htmlspecialchars($data);
		return $data;
	}//cleanData

	function passVerify1a($data){
			if(empty($data)){
				return "Please enter password.";
			}//if
			return "";
	}//passVerify1

	function passVerify1b($data){
			if(empty($data)){
				return "Please enter password.";
			}//if
			return "";
	}//passVerify1

	function passVerify2($data, $data2){
		if(strcmp($data, $data2) !== 0){
			return "Passwords must match.";
		}//if
		return "";
	}//passVerify2

	function passVerify3($data){
		if(!preg_match('/^(?=.*\d)(?=.*[a-zA-Z])(?!.*[\W_\x7B-\xFF]).{6,15}$/', $data)){
			return "Invalid password.";
		}//if
		return "";
	}//passVerify3
?>
