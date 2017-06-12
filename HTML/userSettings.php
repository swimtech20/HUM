<!DOCTYPE html>
<html lang="en">
<?php session_start();
include '../../dbconnect.php';
require_once("./PHP/functions.php");
if($_SESSION["valid"]==true){?>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="Capstone" >
    <link rel="icon" href="../images/logo.png">
    <link href="../bootstrap/css/sticky-footer-navbar.css" rel="stylesheet">
    <link rel="stylesheet" href="../bootstrap/css/bootstrap.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>

    <title>User Settings</title>

    <!-- user form css -->
    <link href="../CSS/roomForm.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="../CSS/normalize.css"/> <!-- normalize -->
    <link rel="stylesheet" type="text/css" href="../CSS/psuedoWelcome.css"/> <!-- css -->

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]-->
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <!--[endif]-->
    <script type="text/javascript">
		$(document).ready(function(){
  			$('#showPassword1').on('click', function(){

    			var passwordField = $('#newpass');
    			var passwordFieldType = passwordField.attr('type');
    			if(passwordFieldType == 'password')
    			{
        			passwordField.attr('type', 'text');
        			$(this).val('Hide');
    			} else {
        			passwordField.attr('type', 'password');
        			$(this).val('Show');
    			}
  			});
  			$('#showPassword2').on('click', function(){

    			var passwordField = $('#rnewpass');
    			var passwordFieldType = passwordField.attr('type');
    			if(passwordFieldType == 'password')
    			{
        			passwordField.attr('type', 'text');
        			$(this).val('Hide');
    			} else {
        			passwordField.attr('type', 'password');
        			$(this).val('Show');
    			}
  			});
  		});

    </script>
</head>

<body>
<div id="layout">
  <div id="main">

    <div class="header">
        <h1>House Utilities Manager</h1>
        <h2>An application for all your home management needs. </h2>
    </div>

    <!-- Navigation -->
    <nav class="navbar navbar-default">
      <div class="container-fluid">
        <div class="navbar-header">
           <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#mainNavBar" aria-expanded="false">
               <span class="sr-only">Toggle navigation</span>
               <span class="icon-bar"></span>
               <span class="icon-bar"></span>
               <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="./welcome.php">My Dashboard</a>
        </div>
        <div class="collapse navbar-collapse" id="mainNavBar">
          <ul class="nav navbar-nav">
            <li><a href="./houseSettings.php">House</a></li>
            <li><a href="./choreSettings.php">Chores</a></li>
            <li><a href="./taskSettings.php">Tasks</a></li>
            <li><a href="./eventSettings.php">Events</a></li>
            <li class="active"><a href="./userSettings.php">My Settings <span class="sr-only">(current)</span></a></li>
            <li><a href="./logout.php">Logout</a></li>
          </ul>
        </div><!-- /.navbar-collapse -->
      </div><!-- /.container-fluid -->
    </nav>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js">       </script>

    <!-- Page Content -->
    <div class="container">

        <!-- Page Heading -->
        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header">User Settings
                    <small>Change your password, username, or leave your group.</small>
                </h1>
            </div>
        </div>
        <!-- /.row -->

      <?php
      if($_SERVER['REQUEST_METHOD']=="GET"){
        if($_SESSION["successPwChange"] == 1){?>
          <div class="alert alert-success">
      			<strong>Success!</strong> Your password has been changed.
      		</div>
        <?php $_SESSION["successPwChange"] = 0;}
        elseif($_SESSION["emptyPwErr"] == 1){?>
          <div class="alert alert-danger">
      			<strong>Error!</strong> Please enter a new password.
      		</div>
        <?php $_SESSION["emptyPwErr"] = 0;}
        elseif($_SESSION["emptyRPwErr"] == 1){?>
          <div class="alert alert-danger">
      			<strong>Error!</strong> Please enter your new password twice.
      		</div>
        <?php $_SESSION["emptyRPwErr"] = 0;}
        elseif($_SESSION["mismatchPwErr"] == 1){?>
          <div class="alert alert-danger">
      			<strong>Error!</strong> Make sure you entered the same password twice.
      		</div>
        <?php $_SESSION["mismatchPwErr"] = 0;}
        elseif($_SESSION["invalidPwErr"] == 1){?>
          <div class="alert alert-danger">
      			<strong>Error!</strong> Your password must contain a number and be at least 6 characters long.
      		</div>
        <?php $_SESSION["invalidPwErr"] = 0;}
        elseif($_SESSION["incorrectOldPw"] == 1){?>
          <div class="alert alert-danger">
      			<strong>Error!</strong> Your current password is incorrect.
      		</div>
        <?php $_SESSION["incorrectOldPw"] = 0;}
        elseif($_SESSION["internalErr"] == 1){?>
          <div class="alert alert-danger">
      			<strong>Error!</strong> We've encountered a problem. Our bad.
      		</div>
        <?php $_SESSION["internalErr"] = 0;}
        elseif($_SESSION["changeUnameSuc"] == 1){?>
          <div class="alert alert-success">
      			<strong>Success!</strong> Your username has been changed.
      		</div>
        <?php $_SESSION["changeUnameSuc"] = 0;}
        elseif($_SESSION["usernameErr"] == 1){?>
          <div class="alert alert-danger">
      			<strong>Error!</strong> Your username failed to update.
      		</div>
        <?php $_SESSION["usernameErr"] = 0;}
        elseif($_SESSION["emptyUsernameErr"] == 1){?>
          <div class="alert alert-danger">
      			<strong>Error!</strong> Your username failed to update.
      		</div>
        <?php $_SESSION["emptyUsernameErr"] = 0;}
        elseif($_SESSION["deleteErr"] == 1){?>
          <div class="alert alert-danger">
      			<strong>Error!</strong> System failed to remove your account, please try again later.
      		</div>
        <?php $_SESSION["deleteErr"] = 0;}?>

        <div class="container">
	         <div class="row">

             <div class="col-md-4">
		             <div class="form_main">
                   <h4 class="heading"><strong>Change Password</strong> <span></span></h4>
                   <div class="form">
                     <form action="./PHP/processUserSettings.php" method="POST" id="passwordForm" name="passwordForm">
                       <input type="password" required="" placeholder="Current Password" value="" name="currentpass" class="txt"/>
                       <input type="button" id="showPassword1" value="Show" class="txt4" style="float: right" />
                       <div style="overflow: hidden; padding-right: 1em;">
                       		<input type="password" required="" name="newpass" id="newpass" value="" placeholder="New Password" class="txt" />
							  </div>
                       <input type="button" id="showPassword2" value="Show" class="txt4" style="float: right" />
                       <div style="overflow: hidden; padding-right: 1em;">
                       		<input type="password" required="" placeholder="Repeat New Password" value="" id="rnewpass" name="rnewpass" class="txt" />
							  </div>

                       <input type="submit" value="Submit" name="submit" class="txt2"/>
                     </form>
                  </div>
                </div>
              </div>

              <div class="col-md-4">
		            <div class="form_main">
                  <h4 class="heading"><strong>Change Username</strong> <span></span></h4>
                  <div class="form">
                    <form action="./PHP/processChangeUname.php" method="POST" id="changeAliasForm" name="changeAliasForm">
                      <input type="text" id="idtxt" required="" placeholder="New Username" value="" name="newAlias" class="txt"/>
                      <br><br>
                      <input type="submit" value="Submit" name="submit" class="txt2"/>
                    </form>
                  </div>
               </div>
	        </div>

            <div class="col-md-3">
                <div class="form_main">
                    <h4 class="heading"><strong>Delete account?</strong> <span></span></h4>
                    <div class="form">
                      <form action="./PHP/deleteAccountForm.php" method="POST" id="deleteAccountForm" name="deleteAccountForm">
                        <input type="submit" value="Delete" name="submit" class="txt2"/>
                      </form><!-- action -->
                  </div><!--form-->
                 </div><!--form_main-->

            <?php
              $userID = $_SESSION["login_user"];
              $sql = "SELECT GID FROM sys.user_info WHERE UID = '$userID'";
              $result = mysqli_query($db, $sql);
              $obj = mysqli_fetch_object($result);
              $userGID = $obj->GID;
              if($userGID == '0'){
            ?>
            <div class="header">
              <h2>Please create a group before you can leave a group.</h2>
              <h4>Click <a href="./houseSettings.php">here</a> to do so.</h4>
            </div><!--header-->
            <?php }//if
               else { ?>

                <div class="form_main">
                    <h4 class="heading"><strong>Ready to Move Out?<strong> <span></span></h4>
                    <div class="form">
                      <form action="./PHP/leaveGroupForm.php" method="POST" id="leaveGroupForm" name="leaveGroupForm">
                        <input style="font-weight: normal;" type="submit" value="Leave Group" name="submit" class="txt2"/>
                      </form><!-- action = "./PHP/leaveGroup.php" or something like that -->
                  </div><!--form-->
                 </div><!--form_main-->
            </div><!-- col-md-4 -->
          </div><!--row-->

        </div><!--container-->

        <hr>

        <?php }//else gid != 0

      }//if Request = GET ?>

      <ul class="nav pull-right scroll-top">
        <li><a href="#" title="Scroll to top"><i class="glyphicon glyphicon-chevron-up"></i></a></li>
      </ul>

    </div><!-- /.container -->
  </div><!--container-->
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
<?php
}//if validated
else{
  redirect("./login.php");
}//else?>
