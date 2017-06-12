<!DOCTYPE html>
<?php session_start();
include '../../dbconnect.php';
require_once("./PHP/functions.php");
//ini_set("display_errors", true);
//error_reporting(E_ALL);
if($_SESSION["valid"]==true){?>
<html>
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!--<link rel="stylesheet" href="http://yui.yahooapis.com/pure/0.6.0/pure-min.css">-->
    <link rel="stylesheet" type="text/css" href="../CSS/normalize.css"/>
    <link rel="stylesheet" type="text/css" href="../CSS/welcome.css"/>
    <link rel="stylesheet" type="text/css" href="../CSS/roomForm.css"/>
    <link rel="icon" href="../images/logo.png">
    <link href="../bootstrap/css/sticky-footer-navbar.css" rel="stylesheet">
    <link rel="stylesheet" href="../bootstrap/css/bootstrap.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>

    <title>Home Utilities Manager &ndash; </title>
    <style>
      .agenda {  }

      /* Dates */
      .agenda .agenda-date { width: 170px; }
      .agenda .agenda-date .dayofmonth .dayofweek .shortdate{
      width: 100px;
      font-size: 36px;
      line-height: 36px;
      float: left;
      text-align: left;
      margin-right: 10px;
      }
      .dayofmonth{
        width: 100px;
        font-size: 36px;
        line-height: 36px;
        float: left;
        text-align: right;
        margin-right: 10px;
      }

      .agenda .agenda-date .shortdate {
      font-size: 0.75em;
      }


      /* Times */
      .agenda .agenda-time { width: 140px; }


      /* Events */
      .agenda .agenda-events {  }
      .agenda .agenda-events .agenda-event {  }

    </style>
  </head>
  <body>
    <div id="layout">
      <div id="main">

        <div class="header">
          <h1>House Utilities Manager</h1>
          <h2>An application housing all your home management needs. </h2>
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
             <a class="navbar-brand active" href="#">My Dashboard<span class="sr-only">(current)</span></a>
         </div>
         <div class="collapse navbar-collapse" id="mainNavBar">
           <ul class="nav navbar-nav">
             <li><a href="./houseSettings.php">House</a></li>
             <li><a href="./choreSettings.php">Chores</a></li>
             <li><a href="./taskSettings.php">Tasks</a></li>
             <li><a href="./eventSettings.php">Events</a></li>
             <li><a href="./userSettings.php">My Settings</a></li>
             <li><a href="./logout.php">Logout</a></li>
           </ul>
         </div><!-- /.navbar-collapse -->
       </div><!-- /.container-fluid -->
     </nav>
   <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js">        </script>
   <?php
     $userID = $_SESSION["login_user"];
     $sql = "SELECT GID FROM sys.user_info WHERE UID = '$userID'";
     $result = mysqli_query($db, $sql);
     $obj = mysqli_fetch_object($result);
     $userGID = $obj->GID;
     if($userGID == '0'){
   ?>
     <div class="header">
       <h2>Please create a group in order to view its information.</h2>
       <h4>Click <a href="./houseSettings.php">here</a> to do so.</h4>
     </div><!--header-->
   <?php }//if
       elseif($userGID!='0'){
          if($_SESSION["taskDeleteErr"] == 1){ ?>
            <div class="alert alert-danger">
              <strong>Error!</strong> Task failed to be deleted.
            </div>
        <?php $_SESSION["taskDeleteErr"] = 0; }
          elseif($_SESSION["taskDeleteSuc"] == 1){ ?>
            <div class="alert alert-success">
              <strong>Success!</strong> Task was deleted.
            </div>
        <?php $_SESSION["taskDeleteSuc"] = 0; } ?>

 <!--House info-->
   <div class="houseinfo col-xs-3 col-md-3">
       <h2 class="content-subhead2">House: </h2>
       <h4 class="content-subhead2">Members: </h4>
         <div class="phptext">
           <?php
             $groupId = $_SESSION["gid"];
             $sql = "SELECT username FROM user_info WHERE GID = '$groupId'";
             $result = mysqli_query($db, $sql);
             while($username = mysqli_fetch_row($result)):
                 echo $username[0]."<br/>";
             endwhile;
           ?>
         </div><!--phptext-->
       <h4 class="content-subhead2">Rooms: </h4>
       <div class="phptext">
         <?php
           $sql = "SELECT name FROM room WHERE GID = '$groupId'";
           $result = mysqli_query($db, $sql);
           while($roomNames = mysqli_fetch_row($result)):
               echo $roomNames[0]."<br/>";
           endwhile;
         ?>
       </div><!--phptext-->
   </div><!--houseinfo-->

   <div class="col-xs-4 col-md-9">
 <!-- CHORES -->
       <h2 class="content-subhead">Your Chore: </h2>
       <p>
         <table>
             <?php
               $user = $_SESSION["login_user"];
               $sql = "SELECT title FROM user_info, chore WHERE user_info.UID = '$user' AND user_info.UID = chore.UID";
               $result = mysqli_query($db, $sql);

               $count = mysqli_num_rows($result);
               //php end tag here

               if($count == 0){
                 $emptyMessage = "<tr><td>You currently have no chores.</td></tr>";
                 echo $emptyMessage;
               }
               else{
                 while ($line = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
                     foreach ($line as $col_value) {
                         echo "\t\t<tr><td>$col_value</td></tr>";
                     }//foreach
                 }//while
               }//else
             ?>
       </table>
       </p>

 <!-- TASKS -->
       <h2 class="content-subhead">Current Tasks: </h2>
       <p>
              <table>
                  <?php
                    //ini_set("display_errors", true);
                    //error_reporting(E_ALL);
                    $group = $_SESSION["gid"];
                    $sql = "SELECT name FROM task WHERE task.GID = '$group'";
                    $result = mysqli_query($db, $sql);

                    $count = mysqli_num_rows($result);
                    //php end tag here

                    if($count == 0){
                      $emptyMessage = "Your House currently has no tasks.";
                      echo $emptyMessage;
                    }
                    else{
                      while ($line = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
                          foreach ($line as $col_value) {
                              echo "\t\t<tr><form action=\"./PHP/completeTaskForm.php\" method=\"POST\">
                                  <td>$col_value</td><td><input type=\"hidden\" name=\"taskname\" value=\"".$col_value."\"/></td>
                                  <td><input type=\"submit\" name=\"submit\" class=\"txt3\" value=\"Complete\"/></td></form></tr>";
                          }//foreach
                      }//while
                    }//else
                  ?>
             </table>
       </p>
    </div>
    <div class = "col-xs-12 col-md-9">
 <!-- EVENTS/SCHEDULE -->
       <h2 class="content-subhead ">House schedule: </h2>
          <div id="" style="overflow: scroll; height:300px">
            <?php
              $group = $_SESSION["gid"];
              $sql = "SELECT name, time FROM event WHERE event.GID = '$group'";
              $result = mysqli_query($db, $sql);

              $count = mysqli_num_rows($result);
              //php end tag here

              if($count == 0){
                $emptyMessage = "Your House currently has no upcoming events.";
                echo $emptyMessage;
              }
              else{
                $i = 1;
                while ($line = mysqli_fetch_assoc($result)) {
                    $name = $line['name'];
                    $time = $line['time'];

                    //echo "\t\t<tr><td><strong>Event $i: <strong></td><td><strong>$name</strong></td><td> at $time.</td></tr><br/>";
                    $phpdate = strtotime( $time );
                    $day = date("d", $phpdate);
                    $monthYear = date("m/y", $phpdate);
                    $timeEvent = date("g:i A", $phpdate);
                    $tempDate = date("y-m-d", $phpdate);
                    $dayOfWeek = date('l', strtotime( $tempDate)); ?>
                      <div class="agenda">
                        <div class="table-responsive">
                          <table class="table table-condensed table-bordered">
                            <thead>
                              <tr>
                                <th>Date</th>
                                <th>Time</th>
                                <th>Event</th>
                                </tr>
                            </thead>
                            <tbody>
                            <!-- Single event in a single day -->
                            <tr>
                            <td class="agenda-date" class="active" rowspan="1">

                            <div class="dayofweek">
                                <?php echo $dayOfWeek; ?>
                            </div>
                            <div class="shortdate text-muted">
                                <?php echo $monthYear; ?>
                            </div>
                            <div class="dayofmonth">
                              <?php echo $day; ?>
                            </div>
                            </td>
                            <td class="agenda-time">
                                <?php echo $timeEvent; ?>
                            </td>
                            <td class="agenda-events">
                            <div class="agenda-event">
                                <?php echo $name; ?>
                            </div>
                        </td>
                      </tr>
                    <thead>
                  </table>
                </div>
              </div>
                    <?php
                    $i = $i+1;
                }//while
              }//else
             } elseif($userGID == '0') { ?>
                 <div class="header">
                 <h2>Please create a group in order to view its information.</h2>
                 <h4>Click <a href="./houseSettings.php">here</a> to do so.</h4>
                 </div><!--header-->
      <?php }//elseif ?>
    </div>
    <div class="footer">
       <p class="text-muted">Copyright ©2016-2017 PLU Capstone. House Utilities Manager.
       Authors <a target="_blank" href="https://www.linkedin.com/in/gagedgibson">Gage Gibson</a>,
         <a target="_blank" href="https://www.linkedin.com/in/jaymegreer">Jayme Greer</a> and Caleb LaVergne.</p>
    </div>

   </div><!-- content -->
 </div><!--main-->
 </div><!--layout-->

 </body>
 </html>
 <?php }//if
 else{
 redirect("./login.php");
 }?>
