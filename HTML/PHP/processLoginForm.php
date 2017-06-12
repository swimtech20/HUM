<?php
	/*DEBUG statements (next two lines), uncomment for bug info*/
	//ini_set("display_errors", true);
	//error_reporting(E_ALL);
	require_once("functions.php");
	$hasErrors = false;
	$flag = 0;

	include '../../../dbconnect.php';

	if($_SERVER["REQUEST_METHOD"] == "POST") {

		//username and password sent from form
		$myemail = mysqli_real_escape_string($db, $_POST['useremail']);
		//echo $myusername."\n";
		$myemail = cleanData($myemail);
		$mypassword = mysqli_real_escape_string($db, $_POST['pswd']);
		//echo $mypassword."\n";
		$mypassword = cleanData($mypassword);

		//Database queries
		$sqlPswd = "SELECT password, Verified FROM user_info WHERE email= '$myemail'";//grab stored hashed password

		/*get the hashed password from the db in form of a string*/
		$sqlResult = mysqli_query($db, $sqlPswd);
		$temp = mysqli_fetch_object($sqlResult);
		$dbpassword = $temp->password;
		$dbVerified = $temp->Verified;

		/*DEBUG BLOCK*/
		//$booltest = password_verify($mypassword, $dbpassword);

		//if statement to allow login and start session if account exists and password is correct
		if(password_verify($mypassword, $dbpassword) && $dbVerified=='1'){
			$sql = "SELECT UID, GID FROM user_info WHERE email = '$myemail'";
			$result = mysqli_query($db, $sql);
			$count = mysqli_num_rows($result);

			if($count == 1){
				/*this block splits up the result from sql into uid and gid*/
				$obj = mysqli_fetch_object($result);
				$myuid = $obj->UID;
				$GID = $obj->GID;
				/*end block*/

				/* NEED TO SET SESSION ID FIRST USE PHPs session_id()*/
    		session_start();
				$_SESSION["loginErr"] = 0;
				$_SESSION["login_user"] = $myuid;
				$_SESSION["valid"] = true;
				$_SESSION["gid"] = $GID;
	    	$_SESSION["timeout"] = time() + 300;
				redirect("../welcome.php");
			}//if
		} else {
			session_start();
			$_SESSION["loginErr"] = 1;
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
