<?php
// LOG4PHP
include('log4php/Logger.php');
Logger::configure('../conf/logConfig.xml');
$logger = Logger::getLogger("eloUpdate_proc.php");
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
	//seleciona todos os players de um lobby fornecido
	$query = "SELECT p1User,p2User,p3User,p4User,p5User,p6User,p7User,p8User,p9User,p10User,matchId FROM lobby 
		WHERE id='$lobbyId' and active=1";
	$result = $conn->query($query);
	$r = mysqli_fetch_row($result);
	// print_r($r);
	//seleciona toda a informação sobre cada player para verificar se ganhou a match ou nao
	for ($i = 0; $i < 10; $i++) {
		$query = "SELECT team, team1_score, team2_score FROM get5_stats_players AS play
					INNER JOIN users AS user ON play.steamid64 = user.steamid64
						INNER JOIN get5_stats_matches as mat ON mat.matchid = play.matchid
							WHERE user.id = '".$r[$i]."' and mat.matchid = '$r[10]'";
		$result = $conn->query($query);
			//se ganhou cria um array com o id e com o valor 1 se perder adiciona o valor 0
			while($win = mysqli_fetch_array($result)){
				$team = $win['team'];
				if($win[$team.'_score'] == 1){
					$final[$i][0] = $r[$i];
					$final[$i][1] = 1;
					 //echo "1";
				} else {
					$final[$i][0] = $r[$i];
					$final[$i][1] = 0;
					 //echo "0";
				}
			}
	}
	//seleciona da tabela expected elo os elos quando iniciada a partida e o expected
	$query = "SELECT * FROM lobby_expected_elo 
		WHERE lobbyId='$lobbyId'";
	$result = $conn->query($query);
	$r = mysqli_fetch_row($result);
		//com o expected faz o calculo do novo elo e adiciona ao array juntamente com o id
		for ($i = 2; $i < 12; $i++) {
			$eloUpdated[$i-2][1] = $r[$i+10] + 32 * ($final[$i-2][1] - $r[$i] );
			$eloUpdated[$i-2][0] = $final[$i-2][0];
		}
	//faz update de todos os elos ja calculados
	for ($i = 0; $i < 10; $i++) {
		$query = "UPDATE users SET elo='".$eloUpdated[$i][1]."' WHERE id='".$eloUpdated[$i][0]."'";
		$result = $conn->query($query);
		if (mysqli_error($conn)){
			$updateError = 1;
			break;
		}else {
			$updateError = 0;
		}
	}
	if($updateError == 0){
		$logger->info("Update do elo do lobbyid: ".$lobbyId." com sucesso!");
		echo "Updated com sucesso \n";
	}else{
		$logger->error("Mensagem de erro: ".mysqli_error($conn));
	}
	// echo "</br>";
	// echo "</br>";
	// print_r($r);
	// echo "</br>";
	// echo "</br>";
	// print_r($final);
	// echo "</br>";
	// echo "</br>";
	// print_r($eloUpdated);
}	else {
		if(isset($_SESSION['uId'])){
			$logger->error("Variavel POST['lobbyId'] nao definida por uid: ".$uId);
		} else {
			$logger->error("Variavel POST['lobbyId'] nao definida");
		}
	}
?>