<?php
  session_start();
  require("functions.php");
  include "../../../dbconnect.php";

  $uid = $_SESSION["login_user"];
  $sql = "UPDATE user_info SET GID='0' WHERE UID='$uid';";
  $result = mysqli_query($db, $sql) or die('Error: '.mysqli_error($GLOBALS['db']));
  if($result){
    $_SESSION["gid"] = 0;
    redirect("../userSettings.php");
  }//if
?>
