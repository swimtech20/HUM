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
    <meta name="author" content="Server" >

    <title>Chore Settings</title>
    <link rel="icon" href="../images/logo.png">
    <link href="../bootstrap/css/sticky-footer-navbar.css" rel="stylesheet">
    <link rel="stylesheet" href="../bootstrap/css/bootstrap.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>

    <!-- chore form css -->
    <link href="../CSS/roomForm.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="../CSS/normalize.css"/> <!-- normalize -->
    <link rel="stylesheet" type="text/css" href="../CSS/psuedoWelcome.css"/> <!-- css -->

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
    <script type="text/javascript">
      $(function()
      {
          $('#idbtn').click(function()
          {
              $('#idtxt').clone().attr('id', 'idtxt' + $(this).index()).insertAfter('#idtxt');
          })
      })
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
            <li class="active"><a href="./choreSettings.php">Chores <span class="sr-only">(current)</span></a></li>
            <li><a href="./taskSettings.php">Tasks</a></li>
            <li><a href="./eventSettings.php">Events</a></li>
            <li><a href="./userSettings.php">My Settings</a></li>
            <li><a href="./logout.php">Logout</a></li>
          </ul>
        </div><!-- /.navbar-collapse -->
      </div><!-- /.container-fluid -->
    </nav>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"> </script>

    <!-- Page Content -->
    <div class="container">

        <!-- Page Heading -->
        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header">Chore Settings
                    <small>Add Chores, remove chores, and assign chores to house members.</small>
                </h1>
            </div>
        </div>
        <!-- /.row -->

		  <?php if($_SESSION["tErr"] == 1){ ?>
          <div class="alert alert-danger">
            <strong>Error!</strong> That chore already exists!
          </div>
        <?php $_SESSION["tErr"] = 0;
            }else if($_SESSION["choreSuc"] == 1){ ?>
          <div class="alert alert-success">
            <strong>Success!</strong> Chore created and assigned!
          </div>
        <?php $_SESSION["choreSuc"] = 0;
            }else if($_SESSION["uErr"] == 1){ ?>
          <div class="alert alert-danger">
            <strong>Error!</strong> The chore must be assigned to a group member.
          </div>
        <?php $_SESSION["uErr"] = 0;
            }else if($_SESSION["assignErr"] == 1){ ?>
          <div class="alert alert-danger">
            <strong>Error!</strong> Something went wrong, chore could not be assigned to that user.
          </div>
        <?php $_SESSION["assignErr"] = 0;
            }//elseif
        if($_SESSION["remErr"] == 1){ ?>
          <div class="alert alert-danger">
            <strong>Error!</strong> Unsuccessful, Chore may not exist.
          </div>
        <?php $_SESSION["remErr"] = 0;
            }elseif($_SESSION["remSuc"] == 1){ ?>
          <div class="alert alert-success">
            <strong>Success!</strong> Chore removed!
          </div>
        <?php $_SESSION["remSuc"] = 0;
        		}//elseif ?>


        <div class="container">
	         <div class="row">
             <?php
               $userID = $_SESSION["login_user"];
               $sql = "SELECT GID FROM sys.user_info WHERE UID = '$userID'";
               $result = mysqli_query($db, $sql);
               $obj = mysqli_fetch_object($result);
               $userGID = $obj->GID;
               if($userGID == '0'){
             ?>
             <div class="header">
               <h2>Please create a group before editing these settings.</h2>
               <h4>Click <a href="./houseSettings.php">here</a> to do so.</h4>
             </div><!--header-->
             <?php }//if
                else { ?>
             <div class="col-md-4">
		             <div class="form_main">
                   <h4 class="heading"><strong>Add/Assign Chores</strong> <span></span></h4>
                   <div class="form">
                     <form action="./PHP/processChoreForm.php" method="POST" id="choreForm" name="choreForm">
                       <input type="text" required="" placeholder="Add Chore" value="" name="chore" class="txt">
                       <?php
                         $groupId = $_SESSION["gid"];
                         $sql = "SELECT username, UID FROM user_info WHERE GID = '$groupId'";
                         $result = mysqli_query($db, $sql);
                       ?>
                       <select name="choreOwner" class="form-control">
                        <option value="">--Who is Doing this Chore?--</option>
                        <?php while($room = mysqli_fetch_row($result)):?>
                                <option value="<?php echo $room[1]; ?>"><?php echo $room[0]; ?></option>
                        <?php endwhile; ?>
                       </select>
                       <input type="submit" value="submit" name="submit" class="txt2">
                     </form>
                  </div>
                </div>
            </div>

				<div class="col-md-4">
		            <div class="form_main">
                  <h4 class="heading"><strong>Remove Chores</strong> <span></span></h4>
                  <div class="form">
                    <form action="./PHP/processChoreRemoveForm.php" method="POST" id="removeChoreForm" name="removeChoreForm">
                      <?php
                      $groupId = $_SESSION["gid"];
                        $sql = "SELECT title, CID FROM chore WHERE GID = '$groupId'";
                        $result = mysqli_query($db, $sql);
                      ?>
                      <select name="choreList" class="form-control">
                       <option value="">--What chore do you want to remove?--</option>
                       <?php while($chore = mysqli_fetch_row($result)):?>
                               <option value="<?php echo $chore[1]; ?>"><?php echo $chore[0]; ?></option>
                       <?php endwhile; ?>
                      </select>
                      <br><br>
                      <input type="submit" value="submit" name="submit" class="txt2">
                    </form>
                  </div>
               </div>
            </div><!-- col-md-4 -->

          <!-- CHORES LIST -->
          <div class="col-md-4">
		       <div class="form_main">
		       <h4 class="heading"><strong>Chore List</strong><small>- bolded chores are yours.</small><span></span></h4>
		       <p>
		         <table>
		             <?php
		             	$gid = $_SESSION["gid"];
		               $user = $_SESSION["login_user"];
		               $sql = "SELECT title, UID FROM chore WHERE GID = $gid";
		               $result = mysqli_query($db, $sql);

		               $count = mysqli_num_rows($result);

		               if($count == 0){
		                 $emptyMessage = "<tr><td style=\"font-size: 14px;\">Your group has no chores yet.</td></tr>";
		                 echo $emptyMessage;
		               }
		               else{
		                 while ($line = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
		                 		$chore = $line['title'];
		                 		$cUID = $line['UID'];
		                 		if($cUID == $user){
		                 			echo "\t\t<tr><td><b>$chore</b></td></tr>";//as bold
		                 		}
		                 		else{
										echo "\t\t<tr><td>$chore</td></tr>";
		                 		}
		                 }//while
		               }//else
		             ?>
		       </table>
		       </p>
		       </div><!-- chores list form_main -->
	       </div><!-- col-md-4 -->

	        </div><!-- row -->
        </div><!-- container -->

        <hr>

        <?php }//else ?>

    </div><!-- /.container -->
  </div><!--main-->
  <!-- Footer -->
  <div class="footer">
     <p class="text-muted">Copyright ©2016-2017 PLU Capstone. House Utilities Manager.
     Authors <a target="_blank" href="https://www.linkedin.com/in/gagedgibson">Gage Gibson</a>,
       <a target="_blank" href="https://www.linkedin.com/in/jaymegreer">Jayme Greer</a> and Caleb LaVergne.</p>
  </div>


  </body><!--layout-->
</html>
<?php }//if
else{
  redirect("./login.php");
}?>
