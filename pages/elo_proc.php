<?php
// LOG4PHP
include('log4php/Logger.php');
Logger::configure('../conf/logConfig.xml');
$logger = Logger::getLogger("elo_proc.php");
//
Include "../conf/conn.php";
 session_start();
 if(isset($_SESSION['uId'])){
	$uId = $_SESSION['uId'];
	$lobbyId = $_POST['lobbyId'];
 }else {
	$logger->error("Variavel SESSION['uId'] nao definida.");
}
 if(isset($_SESSION['uId']) and isset($_POST['lobbyId'])){
	$sumTeamA = 0;
	$sumTeamB = 0;
	//seleciona a informação de todos os players do lobby
	$query = "SELECT p1User,p2User,p3User,p4User,p5User,p6User,p7User,p8User,p9User,p10User FROM lobby 
		WHERE id='$lobbyId' and active=1";
	$result = $conn->query($query);
	$r = mysqli_fetch_row($result);
	//seleciona os elos de todos os jogadores no lobby e cria um array com os ids e o elo
		for ($i = 0; $i < 10; $i++) {
			$query = "SELECT elo FROM users 
					WHERE id='".$r[$i]."'";
			$result = $conn->query($query);
			$s[$i] = mysqli_fetch_assoc($result);
			$final[$i][0] = $s[$i]['elo'];
			$final[$i][1] = $r[$i];
		}
	//gera a media do elo das equipas 
	for ($i = 0; $i < 5; $i++) {
		$sumTeamA += pow(10, ($final[$i][0] / 400));
	}
	for ($i = 5; $i < 10; $i++) {
		$sumTeamB += pow(10, ($final[$i][0] / 400));
	}
	$averageTeamA = $sumTeamA / 5;
	$averageTeamB = $sumTeamB / 5;
	// echo "</br>";
	// echo $averageTeamA;
	// echo "</br>";
	// echo $averageTeamB;
	// echo "</br>";
	// echo $averageTeamA + $averageTeamB;
	//para cada jogador em função das mmedias das equipas gera um expected elo ratio
	for ($i = 0; $i < 10; $i++) {
		//$final[$i][0] 
		$transformRating = round(pow(10, ($final[$i][0] / 400)), 2, PHP_ROUND_HALF_UP);
		$expected[$i] = round(($transformRating / ($averageTeamA + $averageTeamB)), 2, PHP_ROUND_HALF_UP);
	}
	
	// $win = $final[0][0] + 60 * (1 - $expected[0]);
	// $loose = $final[0][0] + 60 * (0 - $expected[0]);
	
	$query = "SELECT * FROM lobby_expected_elo 
		WHERE lobbyId='$lobbyId'";
	$result = $conn->query($query);
	if(mysqli_num_rows($result) > 0 ){
		echo "Tabela ja foi criada!";
		$logger->warn("Tabela de elos do lobbyid: ".$lobbyId." já criada por: ".$uId);
	} else {
	$query = "INSERT INTO lobby_expected_elo 	(lobbyId, p1elo, p2elo, p3elo, p4elo, p5elo, p6elo, p7elo, p8elo, p9elo, p10elo,	
												p1expected,	p2expected,	p3expected,	p4expected,	p5expected,	p6expected,	p7expected,	p8expected,	p9expected,	p10expected) 
												VALUES ('$lobbyId','".$final[0][0]."','".$final[1][0]."','".$final[2][0]."','".$final[3][0]."','".$final[4][0]."','".$final[5][0]."','".$final[6][0]."','".$final[7][0]."','".$final[8][0]."','".$final[9][0]."',
												'$expected[0]','$expected[1]','$expected[2]','$expected[3]','$expected[4]','$expected[5]','$expected[6]','$expected[7]','$expected[8]','$expected[9]') ";
	$result = $conn->query($query);
	if(mysqli_error($conn)){
		$logger->error("Erro ao criar tabela de elos do lobbyid: ".$lobbyId);
	} else {
		$logger->info("Tabela de elos do lobbyid: ".$lobbyId." criada com sucesso!");
	}
	}
		
		// echo "</br>";
		// print_r($expected);
		// echo "</br>";
		// echo "WIN:".$win;
		// echo "</br>";
		// echo "LOOSE:".$loose;
}else {
		if(isset($_SESSION['uId'])){
			$logger->error("Variavel POST['lobbyId'] nao definida por uid: ".$uId);
		} else {
			$logger->error("Variavel POST['lobbyId'] nao definida");
		}
	}
?>