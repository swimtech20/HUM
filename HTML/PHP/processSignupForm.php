<?php
	//ini_set("display_errors", true);
	//error_reporting(E_ALL);
	require_once("functions.php");
	include '../../../dbconnect.php';

	$emailErr = "";

	if($_SERVER['REQUEST_METHOD']=='POST'){
		/*USER CREDENTIALS*/
		$email = mysqli_real_escape_string($db, $_POST['email']);
		$email = cleanData($email);
		$emailErr = validate($email, 'email');

		$urlGID = $_POST['urlgid'];

		$username = mysqli_real_escape_string($db, $_POST['username']);
		$username = cleanData($username);

		$pswd = mysqli_real_escape_string($db, $_POST['pswd']);
		$pswd = cleanData($pswd);

		$rpswd = mysqli_real_escape_string($db, $_POST['rpswd']);
		$rpswd = cleanData($rpswd);

		$dbResult = dbCheck($email);

		//check if password = repeat password && if password meets regex && if email exists in database
		if(strcmp($pswd, $rpswd)==0 && preg_match('/^(?=.*\d)(?=.*[a-zA-Z])(?!.*[\W_\x7B-\xFF]).{6,}$/', $pswd) && empty($dbResult)){
			$accesskey = uniqid();
			$hash = password_hash($pswd, PASSWORD_BCRYPT);
			$Verified = 0;
			echo "accesscode = ".$accesskey."<br/>";
			echo "hash = ".$hash."<br/>";
			$sql = "INSERT INTO user_info (username, password, email, accesskey) VALUES ('$username','$hash', '$email', '$accesskey')";
			//if sign up credentials pass the requirements then query db to insert sql
			$result = mysqli_query($db, $sql);
			if($result == 1){
				if($urlGID!=0 || $urlGID!="") {
					//select UID
					$sql = "SELECT UID FROM user_info WHERE email='$email';";
					$result = mysqli_query($GLOBALS['db'], $sql);
					$temp = mysqli_fetch_object($result);
					$dbUID = $temp->UID;
					//update GID
					$sql2 = "UPDATE user_info SET GID='$urlGID' WHERE UID='$dbUID';";
					$result2 = mysqli_query($GLOBALS['db'], $sql2);
				}//if urlGID is set (means it came from an invite)
				//if user was inserted in to database start session to access errors
				session_start();
				$_SESSION["signupSuccess"] = 1;
				//include mailer script to send user an email for verification
				//include "./sendUserConfirmMail.php";
				sendMail($email, $username, $accesskey, $Verified);
				//redirect to sign up and display success message
				redirect("../signup.php");
			}//result if
		}//password verify if
		elseif(!strcmp($pswd, $rpswd)) {
			//if password and repeat password don't match, set error to 1, and redirect to signup with error message
			session_start();
			$_SESSION["signupRepeatPswdErr"] = 1;
			redirect("../signup.php");
		}elseif(!preg_match('/^(?=.*\d)(?=.*[a-zA-Z])(?!.*[\W_\x7B-\xFF]).{6,}$/', $pswd)){
			//if password doesn't match regex, set error to 1, and redirect to signup with error message
			session_start();
			$_SESSION["signupRegexErr"] = 1;
			redirect("../signup.php");
		}//if
		elseif(!empty($dbResult)){
		// should catch if email has been used to sign up already, set error to 1, and redirect to signup with error message
			session_start();
			$_SESSION["signupRepeatEmailErr"] = 1;
			redirect("../signup.php");
		}elseif(!empty($emailErr)){
			//otherwise the email is Invalid
			session_start();
			$_SESSION["invalidEmailErr"] = 1;
			redirect("../signup.php");
		}else{
			session_start();
			$_SESSION["signupInternalErr"] = 1;
			redirect("../signup.php");
		}

	}//POST if

	//cleanData function still used
	function cleanData($data){
		$data = trim($data);
		$data = stripslashes($data);
		$data = htmlspecialchars($data);
		return $data;
	}//cleanData

	//dbCheck function still used
	function dbCheck($data){
				$sql = "SELECT email FROM user_info WHERE email = '$data'";

				$result = mysqli_query($GLOBALS['db'], $sql);
				if(!$result || mysqli_num_rows($result) != 0){
					return "This email has already been registered.";
				}//if
				else{
					return "";
				}//ifelse
				return "";

	}//function dbCheck

	//UNUSED FUNCTIONS BELOW
	function validate($data, $field){
		switch($field){
			case 'email': {
				if(!empty($data)){
					if(!filter_var($data, FILTER_VALIDATE_EMAIL)){
						return "Invalid email address.";
					}//if
				}else{
					return "Email address is required.";
				}//ifelse
				return "";
			}//case email

			//NOT USED RIGHT NOW
			/*
			case 'password': {
				if(!empty($data)){
					if(!preg_match('/^(?=.*\d)(?=.*[a-zA-Z])(?!.*[\W_\x7B-\xFF]).{6,15}$/', $data)){
						return "Invalid password.";
					}//if
				}else{
					return "Must create a password.";
				}//ifelse
				return "";
			}//case pswd
			*/

			default: break;

		}//switch statement
	}//validate

	function sendMail($email, $username, $accesskey, $Verified){
		date_default_timezone_set('America/Los_Angeles');

		require '/var/app/current/DocRoot/CSCI499/PHPMailer/PHPMailerAutoload.php';
		//require '/var/www/html/CSCI499/PHPMailer/PHPMailerAutoload.php';

		//include '../signup.php';

		$mail = new PHPMailer;
		//Enable SMTP debugging
		$mail->SMTPDebug = 0;
		$mail->Debugoutput = 'html';
		//Set PHPMailer to use SMTP
		$mail->isSMTP();
		//Set SMTP host name
		$mail->Host = "smtp.gmail.com";
		//Set this to true if SMTP host requires authentication to send email
		$mail->SMTPAuth = true;
		//Provide username and password
		$mail->Username="HouseUtilitiesManager@gmail.com";
		$mail->Password="getserved69";
		//Requires TLS encryption
		$mail->SMTPSecure = 'tls';
		//Set TCP port to connect to
		$mail->Port = 587;

		$mail->From = "HouseUtilitiesManager@gmail.com";
		$mail->FromName = "HUM";

		$mail->addAddress($email, $username);
		$mail->Subject  = 'Welcome to HUM!';

		/*SQL fetch Verified
		$sql= "SELECT Verified FROM user_info WHERE email= '$email'";
		$sqlResult = mysqli_query($db, $sql);
		$temp = mysqli_fetch_object($sqlResult);
		$Verified = $temp->Verified;
		*/

		//$mail->msgHTML(file_get_contents('content.html'));
		$mail->isHTML(true);
		$mail->Body = '
		    <html><head><link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css"><meta name="viewport" content="width=device-width, initial-scale=1">
		    <meta charset="utf-8"></head><body style="padding-left: 1cm; padding-right: 1cm;"><div class="header"><h1>House Utilities Manager</h1><h4>An application for all your house management needs. </h4></div>
		    <div class="content" style="padding-left: 1.25cm; padding-right: 1.25cm;"><h4>Hello '.$username.',</h4><p> Thanks for signing up for House Utilities Manager. We are very excited to have you on board.</p>
				<p> To get started using HUM, please confirm your account below: </p><br>
		    <a href="http://www.houseutil.com/HTML/login.php?email='.$email.'&hash='.$accesskey.'&verified='.$Verified.'">Confirm your account</a>
		    <p> Thanks, <br> The HUM Team </br> </p></body></html>';

		$mail->AltBody = "Hi '.$username.', Thanks for signing up for House Utilities Manager. We are very
		    excited to have you on board! To get started using HUM, please confirm your account below:";
		    //http://www.houseutil.com/HTML/login.php?email='.$email.'&hash='.$accesskey.'verified=1;"

		    if(!$mail->send()) {
		      //echo 'Message was not sent.';
		      echo 'Mailer error: ' . $mail->ErrorInfo;
		    } else {
		      echo "Message has been sent.";
		    }//ifelse
	}//function sendMail

?>
