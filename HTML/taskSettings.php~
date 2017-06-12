<!DOCTYPE html>
<html lang="en">
<?php session_start();
include '../../dbconnect.php';
require_once("./PHP/functions.php");
//ini_set("display_errors", true);
//error_reporting(E_ALL);
if($_SESSION["valid"]==true){?>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="Server" >
    <link rel="icon" href="../images/logo.png">
    <link rel="stylesheet" href="../bootstrap/css/bootstrap.css">
    <link href="../bootstrap/css/sticky-footer-navbar.css" rel="stylesheet">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>

    <title>Task Settings</title>

    <!-- task form css -->
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
            <li><a href="./choreSettings.php">Chores</a></li>
            <li class="active"><a href="./taskSettings.php">Tasks <span class="sr-only">(current)</span></a></li>
            <li><a href="./eventSettings.php">Events</a></li>
            <li><a href="./userSettings.php">My Settings</a></li>
            <li><a href="./logout.php">Logout</a></li>
          </ul>
        </div><!-- /.navbar-collapse -->
      </div><!-- /.container-fluid -->
    </nav>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js">        </script>

    <!-- Page Content -->
    <div class="container">

        <!-- Page Heading -->
        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header">Task Settings
                    <small>Add tasks that need to be done.</small>
                </h1>
            </div>
        </div>
        <!-- /.row -->

        <?php if($_SESSION["tErr"] == 1){ ?>
          <div class="alert alert-danger">
            <strong>Error!</strong> That task already exists!
          </div>
        <?php $_SESSION["tErr"] = 0;
            }else if($_SESSION["taskSuc"] == 1){ ?>
          <div class="alert alert-success">
            <strong>Success!</strong> Task successfully created!
          </div>
        <?php $_SESSION["taskSuc"] = 0;
            }else if($_SESSION["createErr"] == 1){ ?>
          <div class="alert alert-danger">
            <strong>Error!</strong> Something went wrong, task was not created. Try again later.
          </div>
        <?php $_SESSION["createErr"] = 0; }?>

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
                   <h4 class="heading"><strong>Add a Task</strong> <span></span></h4>
                   <div class="form">
                     <form action="./PHP/processTaskForm.php" method="POST" id="taskForm" name="taskForm">
                       <input type="text" id="idtxt" required="" placeholder="Add a Task" value="" name="task" class="txt">
                       <label class="">Date to be done by: </label>
                       <input type="date" required="" value="" name="taskDate" class="date">
                       <!--input type="button" id="idbtn" value="Add Task" /-->
                       <br><br>
                       <input type="submit" value="submit" name="submit" class="txt2">
                     </form>
                  </div>
                </div>


            </div><!-- col-md-4 -->

	            <div class="col-md-4">
			       <div class="form_main">
			       <h4 class="heading"><strong>Task List</strong><small>- bolded tasks are due today.<span></span></h4>
			       <p>
			         <table>
			             <?php
			             	$gid = $_SESSION["gid"];
			               $sql = "SELECT name, time FROM task WHERE GID = $gid";
			               $result = mysqli_query($db, $sql);

			               $count = mysqli_num_rows($result);

			               if($count == 0){
			                 $emptyMessage = "<tr><td>Your group has no tasks yet.</td></tr>";
			                 echo $emptyMessage;
			               }
			               else{
			                 while ($line = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
			                 		$task = $line['name'];
			                 		$date = $line['time'];

										$format = 'm-d-Y';

			                 		if(date($format) == date($format, strtotime($date))) {
			                 			echo "\t\t<tr><td style=\"font-size: 14px;\"><b>$task</b></td><td style=\"font-size: 14px;\"><b>"."---by---"."</b></td>
                              <td style=\"font-size: 14px;\"><b>".date($format, strtotime($date))."</b></td></tr>";//as bold
			                 		}
			                 		else{
											      echo "\t\t<tr><td style=\"font-size: 14px;\">$task</td><td style=\"font-size: 14px;\">"."---by---"."</td>
                              <td style=\"font-size: 14px;\">".date($format, strtotime($date))."</td></tr>";
			                 		}//ifelse
			                 }//while
			               }//else
			             ?>
			       </table>
			       </p>
			       </div><!-- task list form_main -->
		       </div><!-- col-md-4 -->

	        </div><!-- row -->
        </div><!-- container -->

        <hr>
        <?php }//else ?>

    </div>
    <!-- /.container -->

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
