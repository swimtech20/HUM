<?php
	//ini_set("display_errors", true);
	//error_reporting(E_ALL);
	require_once("functions.php");
	include '../../../dbconnect.php';

	$emailErr = $dbResult = "";

	if($_SERVER['REQUEST_METHOD']=='POST'){
		/*USER CREDENTIALS*/
		$email = mysqli_real_escape_string($db, $_POST['email']);
		$email = cleanData($email);
		$emailErr = validate($email, 'email');

		$dbResult = dbCheck($email);

		//check if password = repeat password && if password meets regex && if email exists in database
		if(!empty($dbResult)){
      session_start();
      $_SESSION["userDNE"] = 1;
      redirect("../forgotPasswordEnterEmail.php");
    }//if user email dne in database
    elseif(empty($dbResult)){//else the user is in the db and we should send them a forgot password email
      //get their access_code first
      $sql = "SELECT accesskey, username FROM user_info WHERE email='$email';";
      $query = mysqli_query($GLOBALS['db'], $sql);
      $array = mysqli_fetch_assoc($query);
      $accesscode = $array['accesskey'];
      $username = $array['username'];
      session_start();
      $_SESSION["forgotPwSuc"] = 1;
      sendMail($email, $username, $accesscode);
      //redirect to sign up and display success message
      redirect("../forgotPasswordEnterEmail.php");
    }else{
			session_start();
			$_SESSION["internalErr"] = 1;
			redirect("../forgotPasswordEnterEmail.php");
		}//ifelses

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
				$sql = "SELECT UID FROM user_info WHERE email = '$data'";

				$result = mysqli_query($GLOBALS['db'], $sql);
				$count = mysqli_num_rows($result);
				if(!$result || $count == 0){
					return "This user does not exist.";
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

			default: break;

		}//switch statement
	}//validate

	function sendMail($email, $username, $accesskey){
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
		$mail->Subject  = 'HUM password recovery!';

		$mail->isHTML(true);
		$mail->Body = '
		    <html><head><link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css"><meta name="viewport" content="width=device-width, initial-scale=1">
		    <meta charset="utf-8"></head><body style="padding-left: 1cm; padding-right: 1cm;"><div class="header"><h1>House Utilities Manager</h1><h4>An application for all your house management needs. </h4></div>
		    <div class="content" style="padding-left: 1.25cm; padding-right: 1.25cm;"><h4>Hello '.$username.',</h4><p> Whoops! We are sorry you forgot your password, but don\'t worry! We got your back.</p>
				<p> To create a new password, please click the link below: </p><br>
		    <a href="http://www.houseutil.com/HTML/newPassword.php?email='.$email.'&accesskey='.$accesskey.'">Create new password</a>
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
