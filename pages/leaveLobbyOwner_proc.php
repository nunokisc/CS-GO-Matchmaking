<?php 
Include "../conf/conn.php";
session_start();
if(isset($_SESSION['uId'])){
	$uId = $_SESSION['uId'];
	$lobbyId = $_POST['lobbyId'];
}
if(isset($_SESSION['uId']) and isset($_POST['lobbyId'])){
	$query = "DELETE FROM lobby WHERE id= '$lobbyId'";
	$result = $conn->query($query);
	echo "Lobby eliminado com sucesso!";
}