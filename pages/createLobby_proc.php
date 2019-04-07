<?php
// LOG4PHP
include('log4php/Logger.php');
Logger::configure('../conf/logConfig.xml');
$logger = Logger::getLogger("createLobby_proc.php");
//
Include "../conf/conn.php";
session_start();
if(isset($_SESSION['uId'])){
$value = rand(0,32);
$value1 = rand(0,32);
$name = md5($value.$value1);
$uId = $_SESSION['uId'];
}else {
	$logger->error("Variavel SESSION['uId'] nao definida.");
}
if(isset($_SESSION['uId'])){
		$query = "SELECT * FROM lobby WHERE name='$name'";
		$result = $conn->query($query);
			if(mysqli_num_rows($result) > 0 ){
				echo 'Nome de Lobby já existe';
				$logger->info("uid: ".$uId." tentou criar lobby com nome já existente.");
			} else {
				$query = "INSERT INTO lobby (owner, name, type, players, p1User, active, createAt) 
				VALUES ('$uId','$name','5on5',1,'$uId','1',NOW())";
				$result = $conn->query($query);
				$lobbyId = $conn->insert_id;
				echo 'Lobby criado com exito!';
				$logger->info("Lobby ".$name." id: ".$lobbyId." criado por uid: ".$uId);
			}
	
} else {
	if(isset($_SESSION['uId'])){
		$logger->error("Variavel POST['name'] nao definida por uid: ".$uId);
	} else {
		$logger->error("Variavel POST['name'] nao definida");
	}
}

?>