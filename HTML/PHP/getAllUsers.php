<?php
	include '../../../dbconnect.php';
	/*This need to be different, needs to be dynamic to fill a drop box.*/
	if($_SERVER['REQUEST_METHOD']=='GET' && $_GET){
		$sql="SELECT username FROM user_info WHERE GID = '$gid'";
		$result = mysqli_query($db, $sql);
		$count = mysqli_num_rows($result);
		if($count == 0){
    		die('Error: ' . mysqli_error());
		}
		else{
    		$users = array();
    		$i = 0;
    		while($row = mysqli_fetch_array($result)){
     			$users[$i] = $row['name'];
      		echo $row['name'];
      		$i = $i+1;
     		}
		}
	}//if
?>
