<?php
	ini_set("display_errors", true);
	error_reporting(E_ALL);
	require_once("functions.php");
	$hasErrors = false;
	$flag = 0;

	include "/home/capstone/Desktop/DocRoot/dbconnect.php";

echo "bitch."."\n";
	if($_SERVER["REQUEST_METHOD"] == "POST") {

		//username and password sent from form
		$myusername = mysqli_real_escape_string($db, $_POST['usnm']);
		echo $myusername."\n";
		cleanData($myusername);
		$mypassword = mysqli_real_escape_string($db, $_POST['pswd']);
		echo $mypassword."\n";
		cleanData($mypassword);

		//Database queries
		$sqlPswd = "SELECT password FROM user_info WHERE username= '$myusername'";//grab stored hashed password
		echo "sqlPswd = ".$sqlPswd."\n";
		$pswdResult = mysqli_query($db, $sqlPswd);

		echo "myusername = ".$myusername."\n";
		//echo "hashed pword = ".$pswdResult[0]."\n";

		//if statement to allow login and start session if account exists and password is correct
		if (password_verify($mypassword, $pswdResult)) {
			echo "after pw verify in processLogin";
			$sql = "SELECT UID FROM user_info WHERE username = '$myusername'";
			$result = mysqli_query($db, $sql);
			//** line not necessary $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
			$count = mysqli_num_rows($result);
			if($count == 1){
    			session_start();
					$_SESSION["login_user"] = $myusername;
	    			$_SESSION["valid"] = true;
	    			$_SESSION["timeout"] = time() + 300;

					redirect("../welcome.php");
			}//if
		} else {
			$hasErrors = true;
			redirect("../login.php");
		}//ifelse
	}//POST if

	function cleanData($data){
		$data = trim($data);
		$data = stripslashes($data);
		$data = htmlspecialchars($data);
		return $data;
	}//cleanData
?>
