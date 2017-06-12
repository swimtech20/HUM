<?php
	include '../../../dbconnect.php';
	require("functions.php");
	ini_set("display_errors", true);
	error_reporting(E_ALL);

	$email = $username = "";
	$sql = "";
	$emailErr = "";

	if($_SERVER['REQUEST_METHOD']=='POST' && $_POST){
		/*USER CREDENTIALS*/
		$username = $_POST['uname'];
		$username = trim($username);
		$username = stripslashes($username);
		$username = htmlspecialchars($username);

		$email = $_POST['newMem'];
		$email = trim($email);
		$email = stripslashes($email);
		$email = htmlspecialchars($email);
			//$emailErr = validate($email, 'email');
			if(!empty($email) && !empty($username)){
				if(filter_var($email, FILTER_VALIDATE_EMAIL) == false){
					session_start();
				 $_SESSION["inviteMemErr"]= 1;
				 redirect("../houseSettings.php");
				}else{
					session_start();
					sendMail($username, $email);
					$_SESSION["inviteMemSuc"] = 1;
					redirect("../houseSettings.php");
				}//inner ifelse
			}else{
				session_start();
				$_SESSION["emptyEmailErr"] = 1;
			}//outer ifelse
	}//if

	function sendMail($username, $email){
		date_default_timezone_set('America/Los_Angeles');
		require '/var/app/current/DocRoot/CSCI499/PHPMailer/PHPMailerAutoload.php';
		//require '/var/www/html/CSCI499/PHPMailer/PHPMailerAutoload.php';

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

		//SQL to fetch GID and username of sender
		$uid = $_SESSION["login_user"];
		$sql = "SELECT GID, username FROM user_info WHERE UID='$uid';";
		$result = mysqli_query($GLOBALS['db'], $sql);
		$obj = mysqli_fetch_object($result);
		$sentUserName = $obj->username;
		$GID = $obj->GID;

		//$mail->msgHTML(file_get_contents('content.html'));
		$mail->isHTML(true);
		$mail->Body = '
		    <html><head><link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css"><meta name="viewport" content="width=device-width, initial-scale=1">
		    <meta charset="utf-8"></head><body style="padding-left: 1cm; padding-right: 1cm;"><div class="header"><h1>House Utilities Manager</h1><h4>An application for all your house management needs. </h4></div>
		    <div class="content" style="padding-left: 1.25cm; padding-right: 1.25cm;"><h4>Hello '.$username.'!</h4><p> You have been invited to a group on House Utilities Manager
		    by '. $sentUserName .'. We are very excited to have you on board.</p> <p> To get started using HUM, please create an account by selecting the link below: </p>
		    <a href="http://www.houseutil.com/HTML/signup.php?email='.$email.'&gid='.$GID.'">Sign Up</a> <br><br><p> If you already have a verified account then please click this link: <p>
		    <a href="http://www.houseutil.com/HTML/login.php?gid='.$GID.'&email2='.$email.'"> Log In </a> <p> Thanks, <br> The HUM Team </br> </p></body></html>';

		$mail->AltBody = "Hello! You have been invited to a group on House Utilities Manager by '.$sentUserName. '. We are very
		    excited to have you on board! To get started using HUM, please open this email with an HTML supported view.
		    Thanks, The HUM Team";

		    if(!$mail->send()) {
		      //echo 'Message was not sent.';
		      echo 'Mailer error: ' . $mail->ErrorInfo;
		    } else {
		      //echo 'Message has been sent.';
		    }

	}
?>
