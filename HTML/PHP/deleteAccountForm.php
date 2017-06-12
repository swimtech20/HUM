<?php
  session_start();
  require("functions.php");
  include "../../../dbconnect.php";

  $uid = $_SESSION["login_user"];
  $sql = "UPDATE user_info SET GID='0' WHERE UID='$uid';";
  $result = mysqli_query($db, $sql);
  $sql = "DELETE FROM chore WHERE UID='$uid';";
  $result2 = mysqli_query($db, $sql);
  if($result && $result2){
    $_SESSION["gid"] = 0;
    $sql = "DELETE FROM user_info WHERE UID = '$uid';";
    $result = mysqli_query($db, $sql);
    if($result){
		logout();
		redirect("../userSettings.php");    
    }//if
    else{
	    $_SESSION["deleteErr"] = 1;
	    redirect("../userSettings.php");
	 }//else
  }//if
  else{
	    $_SESSION["deleteErr"] = 1;
	    redirect("../userSettings.php");
	}//else
?>