<?php 
Include "../conf/conn.php";
session_start();
if(isset($_SESSION['uId'])){
$teamName = $_POST['teamName'];
$teamId = $_POST['teamId'];
$lobbyId = $_POST['lobbyId'];
}
if(isset($_POST['teamName']) and isset($_POST['teamId']) and isset($_POST['lobbyId'])){
	$query = "UPDATE lobby SET ".$teamId."='$teamName',updateAt=NOW() WHERE id='$lobbyId'";
	$result = $conn->query($query);
	if (!$result) {
		die('Invalid query: ' . mysql_error());
	} else {
		echo 'Alterado com sucesso!!';
	}
}
?>