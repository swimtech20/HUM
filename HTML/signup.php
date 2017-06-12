<!DOCTYPE html>
<?php session_start();
require_once("./PHP/functions.php");
?>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<title>HUM signup</title>
		<meta http-equiv="cache-control" content="no-cache"/>
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<link rel="stylesheet" type="text/css" href="../CSS/normalize.css">
		<link rel="icon" href="../images/logo.png"/>
		<link rel="stylesheet" type="text/css" href="../CSS/psuedoWelcome.css"/>
    <!--<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">-->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>

		<title>HUM Signup</title>
		<!-- bootstrap
		<link href="../bootstrap/css/starter-template.css" rel="stylesheet">-->
		<link href="../bootstrap/css/sticky-footer-navbar.css" rel="stylesheet">
		<link href="../bootstrap/css/bootstrap.css" rel="stylesheet">
		<link href="../bootstrap/css/signin.css" rel="stylesheet">

		<!--[if lte IE 8]>
		<link rel="stylesheet" href="/combo/1.18.13?/css/layouts/side-menu-old-ie.css">
	    <![endif]-->
    	<!--[if gt IE 8]><!-->
    	<!--<![endif]-->
	<!--[if lt IE 9]>
    	<script src="http://cdnjs.cloudflare.com/ajax/libs/html5shiv/3.7/html5shiv.js"></script>
	 <![endif]-->

	</head>

<body>
	<div id="layout">
    <div id="main">

      <div class="header">
        <h1>House Utilities Manager</h1>
        <h2>An application for all your house management needs. </h2>
      </div>
		<nav class="navbar navbar-default">
			<div class="container-fluid">
				<div class="navbar-header">
					<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#mainNavBar" aria-expanded="false">
							<span class="sr-only">Toggle navigation</span>
							<span class="icon-bar"></span>
							<span class="icon-bar"></span>
							<span class="icon-bar"></span>
					 </button>
						<a class="navbar-brand" href="../index.html">House Utilities Manager</a>
				</div>
				<div class="collapse navbar-collapse" id="mainNavBar">
					<ul class="nav navbar-nav">
						<li><a href="./login.php">Log In</a></li>
					</ul>
				</div><!-- /.navbar-collapse -->
			</div><!-- /.container-fluid -->
		</nav>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js">        </script>

	<div class="container">


	<?php include '../../dbconnect.php'; ?>
	<?php include './PHP/processSignupForm.php';
	//GET URL variables if they exist
	$urlEmail = $_GET['email'];
	$urlGID = $_GET['gid'];

	 if($_SERVER['REQUEST_METHOD']=="GET" ){
		 if($_SESSION["signupRepeatPswdErr"] == 1){ ?>
 				<div class="alert alert-danger">
 					<strong>Error!</strong> Passwords must match. Enter the same password twice for verification.
	 			</div>
<?php
		$_SESSION["signupRepeatPswdErr"] = 0;
		}elseif($_SESSION["signupRepeatEmailErr"] == 1) { ?>
 			<div class="alert alert-danger">
 				<strong>Error!</strong> Email has already been used for an account. Please use a different email.
 			</div>
<?php
		$_SESSION["signupRepeatEmailErr"] = 0;
		}elseif($_SESSION["signupRegexErr"] == 1) { ?>
 			<div class="alert alert-danger">
 				<strong>Error!</strong> Passwords must contain a number and be at least 6 characters long.
 			</div>
 <?php
		$_SESSION["signupRegexErr"] = 0;
		}elseif($_SESSION["invalidEmailErr"] == 1) { ?>
			<div class="alert alert-danger">
				<strong>Error!</strong> Invalid Email.
			</div>
<?php
		$_SESSION["invalidEmailErr"] = 0;
		}elseif($_SESSION["signupSuccess"] == 1) { ?>
		<div class="alert alert-success">
			<strong>Congratulations!</strong> You have successfully registered.
				You should receive an account activation email shortly. Click on the link in the email to activate your account.
		</div>
<?php
 		$_SESSION["signupSuccess"] = 0;
	}elseif($_SESSION["signupInternalErr"] == 1){?>
		<div class="alert alert-danger">
			<strong>Error!</strong> Whoops, something went wrong.
		</div>
<?php $_SESSION["signupInternalErr"] = 0; } //elseifs?>
				 <div class="content">
						 <form id="SignUp" class="form-signin" method="POST" action="./PHP/processSignupForm.php">
						 <h2 class="form-signin-heading"> Sign Up </h2>

						 <input type="email" id="useremail" class="form-control"
						 		name="email" placeholder="Email Address" autofocus required/>

							<input type="hidden" id="urlgid" class="form-control"
	 							name="urlgid" value="<?echo $urlGID;?>" required/>

						 <input type="username" id="username" class="form-control"
							  name="username" placeholder="Username" required/>

						 <input type="password" id="pswd" name="pswd"
						 		pattern="(?=.*\d).{6,}" class="form-control"
						 		placeholder="Password" required/>

						 <input type="password" id="rpswd" name="rpswd"
						 		pattern="(?=.*\d).{6,}" class="form-control"
						 		placeholder="Re-Enter Password" required/>
								<br><br>
						 <button class="btn btn-lg btn-primary btn-block" type="submit">Sign up</button>
	 			 	</form>
	<?php }//request method if ?>

			 </div><!-- /.content -->
	 </div> <!-- /.container -->
 	</div><!--main-->
 </div><!--layout-->
			 <!-- Footer -->
			 <div class="footer">
	        <p class="text-muted">Copyright ©2016-2017 PLU Capstone. House Utilities Manager.
	        Authors <a target="_blank" href="https://www.linkedin.com/in/gagedgibson">Gage Gibson</a>,
	          <a target="_blank" href="https://www.linkedin.com/in/jaymegreer">Jayme Greer</a> and Caleb LaVergne.</p>
	     </div>


	</body>
</html>
