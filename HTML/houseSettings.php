<?php session_start();
include '../../dbconnect.php';
require_once("./PHP/functions.php");

if($_SESSION["valid"]==true){?>
<!DOCTYPE html>
<html lang="en">
<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="Server" >

    <title>House Settings</title>
    <link rel="icon" href="../images/logo.png">
    <link href="../bootstrap/css/sticky-footer-navbar.css" rel="stylesheet">
    <link rel="stylesheet" href="../bootstrap/css/bootstrap.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>

    <!-- house form css -->
    <link href="../CSS/roomForm.css" rel="stylesheet"/>
    <link rel="stylesheet" type="text/css" href="../CSS/normalize.css"/> <!-- normalize -->
    <link rel="stylesheet" type="text/css" href="../CSS/psuedoWelcome.css"/> <!-- css -->
    <!-- scripts for dynamic buttons -->

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]-->
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <!--[endif]-->

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
              <li class="active"><a href="./houseSettings.php">House <span class="sr-only">(current)</span></a></li>
              <li><a href="./choreSettings.php">Chores</a></li>
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
                <h1 class="page-header">House Settings
                    <small>Create a group and edit group name, add rooms, and invite members to join.</small>
                </h1>
            </div>
        </div><!-- /.row -->
        <?php if($_SESSION["gnameErr"] == 1){ ?>
<!--INVALID GROUPNAME -->
          <div class="alert alert-danger">
            <strong>Error!</strong> Invalid group name. Must be 6-30 characters without single quotes.
          </div>
        <?php $_SESSION["gnameErr"] = 0;
            }else if($_SESSION["gnameSuc"] == 1){ ?>
<!--SUCCESSFUL GROUPNAME CHANGE -->
          <div class="alert alert-success">
            <strong>Success!</strong> Group name changed!
          </div>
        <?php $_SESSION["gnameSuc"] = 0;
            }else if($_SESSION["groupSuc"] == 1){ ?>
<!--SUCCESSFUL GROUPNAME CREATION -->
          <div class="alert alert-success">
            <strong>Success!</strong> Group successfully created!
          </div>
        <?php $_SESSION["groupSuc"] = 0;
            }else if($_SESSION["groupErr"] == 1){ ?>
<!--OTHER ERROR -->
          <div class="alert alert-danger">
            <strong>Error!</strong> Something went wrong, try a different group name!
          </div>
        <?php $_SESSION["groupErr"] = 0;
            }//elseif
        if($_SESSION["roomDup"] == 1){ ?>
<!--ROOM ALREADY EXISTS -->
          <div class="alert alert-danger">
            <strong>Error!</strong> Room already exists.
          </div>
        <?php $_SESSION["roomDup"] = 0;
            } elseif($_SESSION["roomSuc"] == 1){ ?>
<!--ROOM SUCCESS -->
          <div class="alert alert-success">
            <strong>Success!</strong> Room successfully added!
          </div>
        <?php $_SESSION["roomSuc"] = 0; }//elseif
        if($_SESSION["inviteMemErr"] == 1){ ?>
<!--USER WASN'T INVITED -->
          <div class="alert alert-danger">
            <strong>Error!</strong> User was unable to be invited. Check for valid email.
          </div>
        <?php $_SESSION["inviteMemErr"] = 0;
        }elseif($_SESSION["inviteMemSuc"] == 1){ ?>
<!--USER SUCCESSFULLY INVITED -->
          <div class="alert alert-success">
            <strong>Success!</strong> User succesfully invited!
          </div>
        <?php  $_SESSION["inviteMemSuc"] = 0; }//elseif
          elseif($_SESSION["emptyEmailErr"] == 1){?>
            <div class="alert alert-danger">
              <strong>Error!</strong> Please enter a valid email address.
            </div>
          <?php $_SESSION["emptyEmailErr"] = 0;}?>

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
             <div class="col-xs-12 col-md-4">
              <div class="form_main">
                <h4 class="heading"><strong>Create a Group</strong> <span></span></h4>
                <div class="form">
                  <form action="./PHP/processGroupNameForm.php" method="POST" id="groupNameForm" name="groupNameForm">
                    <input type="text" id="idtxt" required="" name="groupName" class="txt"
                         placeholder="Create New Group Name"/>
                    <br><br>
                    <input type="submit" value="Submit" name="submit" class="txt2"/>
                  </form>
                </div><!--form-->
              </div>
            </div><!--col-md-4-->
          </div><!--row-->
            <?php }//if
              else { ?>
             <div class="col-xs-12 col-md-4">
              <div class="form_main">
                 <h4 class="heading"><strong>Edit Group Name</strong> <span></span></h4>
                 <div class="form">
                   <form action="./PHP/processGroupNameForm.php" method="POST" id="groupNameForm" name="groupNameForm">
                     <input type="text" id="idtxt" required="" name="groupName" class="txt"
                          <?php
                              $userGroupID = $_SESSION["gid"];
                              $sql2 = "SELECT group_name FROM sys.group_info, sys.user_info WHERE group_info.GID = '$userGroupID'";
                              $result2 = mysqli_query($db, $sql2);
                              $obj = mysqli_fetch_object($result2);
                              $gname = $obj->group_name;
                          ?>
                              value="<?php echo $gname ?>"/>
                     <br><br>
                     <input type="submit" value="Change" name="submit" class="txt2"/>
                   </form>
                 </div>
              </div>
            </div>

             <div class="col-xs-12 col-md-4">
                <div class="form_main">
                   <h4 class="heading"><strong>Add Rooms</strong> <span></span></h4>
                   <div class="form">
                     <form action="./PHP/processRoomForm.php" method="POST" id="roomForm" name="roomForm">
                       <input type="text" id="idtxt" required="" placeholder="Add Room" value="" name="room1" class="txt">

                       <!--input type="button" id="idbtn" value="Add Room" /-->
                       <br><br>
                       <input type="submit" value="Submit" name="submit" class="txt2">
                     </form>
                  </div>
                </div>
              </div>

            </div><!-- row -->

            <div class="row">

					    <div class="col-xs-12 col-md-4">
		            <div class="form_main">
                  <?php
                    //sql statement that selects gid for logged in user
                    //if gid != 0 then display this form
                    //otherwise display bootstrap banner saying "must create group before inviting members"
                  ?>
                  <h4 class="heading"><strong>Invite Members</strong> <span></span></h4>
                  <form action="./PHP/processInviteForm.php" method="POST" id="inviteForm" name="inviteForm" class="form-inline">
                    <div class="form-group">
                      <input type="text" name="uname" class="form-control" id="idtxt" required="" placeholder="Name">
                    </div>
                    <div class="form-group">
                      <input type="email" class="form-control" id="idtxt" required="" name="newMem" placeholder="jane.doe@example.com">
                    </div>
                    <input type="submit" name="submit" class="txt2" value="Send invite"/>
                </form>

            </div><!-- form_main -->
	        </div><!-- col-md-4 -->
        </div><!-- container -->
        <?php }//else ?>

        <hr>
    </div>  <!-- /.container -->

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
<?php }//if
else{
  redirect("./login.php");
}?>
