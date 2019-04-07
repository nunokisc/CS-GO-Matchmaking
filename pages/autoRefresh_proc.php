<?php 
Include "../conf/conn.php";
session_start();
if(isset($_SESSION['uId'])){
	$uId = $_SESSION['uId'];
	$lobbyId = $_GET['lobbyId'];
	$lastUpdate = date("Y-m-d H:i:s",strtotime($_GET['lastUpdate']));
}
if(isset($_SESSION['uId']) and isset($_GET['lobbyId'])and isset($_GET['lastUpdate'])){
	$query = "SELECT updateAt FROM lobby WHERE id='$lobbyId' and active=1";
	$result = $conn->query($query);
	$r = mysqli_fetch_row($result);
		if(mysqli_num_rows($result) > 0 ){
			$updateAt = date("Y-m-d H:i:s", strtotime($r[0]));
			 if($lastUpdate < $updateAt){
				echo 1;
			 } else {
				 echo 0;
			 }
		} else {
			echo -1;	
		}
} else {
	echo 2;
}
?>