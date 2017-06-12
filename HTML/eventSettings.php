<!DOCTYPE html>
<html lang="en">
<?php session_start();
require("../../dbconnect.php");
require_once("./PHP/functions.php");
//ini_set("display_errors", true);
//error_reporting(E_ALL);
if($_SESSION["valid"]==true){?>
<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="Capstone" >

    <title>Event Settings</title>
    <link rel="icon" href="../images/logo.png">
    <link href="../bootstrap/css/sticky-footer-navbar.css" rel="stylesheet">
    <link rel="stylesheet" href="../bootstrap/css/bootstrap.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>

    <!-- room form css -->
    <link href="../CSS/roomForm.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="../CSS/normalize.css"/> <!-- normalize -->
    <link rel="stylesheet" type="text/css" href="../CSS/psuedoWelcome.css"/> <!-- css -->

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->

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
            <li class="active"><a href="./eventSettings.php">Events <span class="sr-only">(current)</span></a></li>
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
                <h1 class="page-header">Event Settings
                    <small>Add events by giving the name, date, time, and location of the event.</small>
                </h1>
            </div>
        </div>
        <!-- /.row -->

        <?php if($_SESSION["repeatEventErr"] == 1){ ?>
          <div class="alert alert-danger">
            <strong>Error!</strong> There is already something going on in that room at that time.
          </div>
        <?php $_SESSION["repeatEventErr"] = 0;
            }else if($_SESSION["eventSuccess"] == 1){ ?>
          <div class="alert alert-success">
            <strong>Success!</strong> Event has been created.
          </div>
        <?php $_SESSION["eventSuccess"] = 0;
            }else if($_SESSION["eventDbErr"] == 1){ ?>
          <div class="alert alert-danger">
            <strong>Error!</strong> Something went wrong, event was not created. Try again later.
          </div>
        <?php $_SESSION["eventDbErr"] = 0; }
        if($_SESSION["conflictErr"] == 1){ ?>
          <div class="alert alert-danger">
            <strong>Error!</strong> There are schedule conflicts within an hour of your reservation. Please select an alternate time.
          </div>
        <?php $_SESSION["conflictErr"] = 0;
            }else if($_SESSION["laundrySuccess"] == 1){ ?>
          <div class="alert alert-success">
            <strong>Success!</strong> Laundry machines have been reserved.
          </div>
        <?php $_SESSION["laundrySuccess"] = 0;
            }else if($_SESSION["laundryDbErr"] == 1){ ?>
          <div class="alert alert-danger">
            <strong>Error!</strong> Something went wrong, machines were not reserved. Try again later.
          </div>
        <?php $_SESSION["laundryDbErr"] = 0; }?>

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
                else {

                  //BANNERS HERE

                  if($_SESSION["eventSuccess"] == 1){ ?>
                    <div class="alert alert-success">
                      <strong>Success!</strong> Your event was created.
                    </div>
                  <?php $_SESSION["repeatEventErr"] = 0;
                  }//elseif($_SESSION["repeatEventErr"] == 1){}
                  ?>

             <div class="col-md-4">
		             <div class="form_main">
                   <h4 class="heading"><strong>Add an Event</strong> <span></span></h4>
                   <div class="form">
                     <form action="./PHP/processEventForm.php" method="POST" id="eventForm" name="eventForm">
                       <input type="text" required="" placeholder="Name of Event" value="" name="eventName" class="txt"/>
                       <input type="time" required="" placeholder="Time of Event" value="" name="eventTime" class="txt"/>
		                   <input type="date" required="" value="" name="eventDate" class="date"/><br/>
                         <?php
                           $groupId = $_SESSION["gid"];
                           $sql = "SELECT name, RID FROM room WHERE GID = '$groupId'";
                           $result = mysqli_query($db, $sql);
                         ?>
                       <select name="roomSelect" class="form-control">
                          <option value="">--Please Select a Room--</option>
                          <?php while($room = mysqli_fetch_row($result)):?>
                                  <option value="<?php echo $room[1]; ?>"><?php echo $room[0]; ?></option>
                          <?php endwhile; ?>
                       </select>

		                     <hr>
                       <input type="submit" value="submit" name="submit" class="txt2">
                     </form>
                  </div>
                </div>
					</div>

					<div class="col-md-4">
		             <div class="form_main">
                   <h4 class="heading"><strong>Request Laundry Machines</strong> <span></span></h4>
                   <div class="form">
                     <form action="./PHP/processLaundryForm.php" method="POST" id="eventForm" name="eventForm">
                       <input type="time" required="" placeholder="Time of Laundry" value="" name="eventTime" class="txt">
		                   <input type="date" required="" value="" name="eventDate" class="date">
		                   <hr>
		                  <input type="submit" value="submit" name="submit" class="txt2">
		                </form>
		              </div>
		            </div>

            </div><!-- col-md-4 -->

				<div class="col-md-4">
			       <div class="form_main">
			       	 <h4 class="heading"><strong>Upcoming Events</strong> <span></span></h4>
				       <p>
				       <div id="" style="overflow-y: scroll; height:100px">
				         <table>
				             <?php
				             	$gid = $_SESSION["gid"];
				               $sql = "SELECT name, time FROM event WHERE GID = $gid ORDER BY time";
				               $result = mysqli_query($db, $sql);

				               $count = mysqli_num_rows($result);

				               if($count == 0){
				                 $emptyMessage = "<tr><td>Your group does not have any upcoming events.</td></tr>";
				                 echo $emptyMessage;
				               }
				               else{
				                 while ($line = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
				                 		$event = $line['name'];
				                 		$time = $line['time'];

											$phpdate = strtotime( $time );
				                 		$timeEvent = date("g:i A", $phpdate);
                   					$tempDate = date("m/d", $phpdate);


											$formatDate = 'm-d-Y';
											$formatAll = 'm-d-Y H:i:s';

				                 		if(date($formatDate) == date($formatDate, strtotime($time))) {
				                 			echo "<tr><td><b>$event</b></td><td><b>"."&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;"."</b></td><td><b>".$tempDate."&nbsp;".$timeEvent."</b></td></tr>";
				                 		}
				                 		else{
												echo "<tr><td>$event</td><td>"."&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;"."</td><td>".$tempDate."&nbsp;".$timeEvent."</td></tr>";
				                 		}
				                 }//while
				               }//else
				             ?>
				       </table>
				       </div><!--scroll box-->
				       </p>
			       </div><!-- task list form_main -->
			       <div class="form_main">
			       	 <h4 class="heading"><strong>Laundry Reservations</strong> <span></span></h4>
				       <p>
				       <div id="" style="overflow-y: scroll; height:100px">
				         <table>
				             <?php
				             	$gid = $_SESSION["gid"];
				               $sql = "SELECT username, time FROM laundry, user_info WHERE laundry.GID = '$gid' AND user_info.UID = laundry.UID ORDER BY time";
				               $result = mysqli_query($db, $sql);

				               $count = mysqli_num_rows($result);

				               if($count == 0){
				                 $emptyMessage = "<tr><td>Laundry machines are free for the foreseeable future.</td></tr>";
				                 echo $emptyMessage;
				               }
				               else{
				                 while ($line = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
				                 		$user = $line['username'];
				                 		$time = $line['time'];

				                 		$phpdate = strtotime( $time );
				                 		$timeEvent = date("g:i A", $phpdate);
                   					$tempDate = date("m/d", $phpdate);

											$formatDate = 'm-d-Y';
											$formatAll = 'm-d-Y H:i:s';

				                 		if(date($formatDate) == date($formatDate, strtotime($time))) {
				                 			echo "<tr><td><b>$user</b></td><td><b>"."&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;"."</b></td><td><b>".$tempDate."&nbsp;".$timeEvent."</b></td></tr>";//as bold
				                 		}
				                 		else{
												echo "<tr><td>$user</td><td>"."&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;"."</td><td>".$tempDate."&nbsp;".$timeEvent."</td></tr>";
				                 		}
				                 }//while
				               }//else
				             ?>
				       </table>
				       </div><!--scroll box-->
				       </p>
			       </div><!-- task list form_main -->
		       </div><!-- col-md-4 -->

	        </div><!-- row -->
        </div><!-- container -->

        <hr>
        <?php }//else ?>

        <!-- Footer -->
        <div class="footer">
           <p class="text-muted">Copyright ©2016-2017 PLU Capstone. House Utilities Manager.
           Authors <a target="_blank" href="https://www.linkedin.com/in/gagedgibson">Gage Gibson</a>,
             <a target="_blank" href="https://www.linkedin.com/in/jaymegreer">Jayme Greer</a> and Caleb LaVergne.</p>
        </div>

    </div><!-- /.container -->
  </div><!--main-->
</div><!--layout-->
</body>

</html>
<?php }//if
else{
  redirect("./login.php");
}?>
