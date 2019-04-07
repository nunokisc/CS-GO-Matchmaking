<?php
	Include "../conf/conn.php";
	require("vendor/autoload.php");
	use ElephantIO\Client;
	use ElephantIO\Engine\SocketIO\Version1X;
	$client = new Client(new Version1X('http://91.121.84.50:4001'));
	
	while(true){
		$query = "CALL dispacherQueue(@retorno); select @retorno as retorno;";
		$conn->multi_query($query);
		$conn->next_result(); 
		$result = $conn->store_result();
		$json = $result->fetch_object()->retorno;
		echo $json;
		$jsonObject =  json_decode($json);
		foreach($jsonObject->lobbys as $lobbys){
			echo $lobbys->lobby;
			if($lobbys->lobby != 0){
				echo "lol";
				$lobbyId = $lobbys->lobby;
				//seleciona todos os ids do users do lobby
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
				// ordena de forma crescente o array de elos do maior para o menor
				rsort($final);
				//print_r($num);
				$aux = 0;
				$aux1 = 0;
				// organiza os 8 primeiro registos da forma 1-4-5-8 | 2-3-6-7
				for ($i = 0; $i < 8; $i++) {
					if($i == 0 || $i == 3 || $i == 4 || $i == 7 ){
						$teamA[$aux] = $final[$i][0];
						$sqlA[$aux][0] = $final[$i][0];
						$sqlA[$aux][1] = $final[$i][1];
						$aux ++;
						} else if ($i == 1 || $i == 2 || $i == 5 || $i == 6 ){
						$teamB[$aux1] = $final[$i][0];
						$sqlB[$aux1][0] = $final[$i][0];
						$sqlB[$aux1][1] = $final[$i][1];
						$aux1 ++;
					}
				}
				// verifica o balanceamento das equipas e com os ultimos 2 users equilibra da melhor forma
				if (array_sum($teamA) > array_sum($teamB)){
					if($final[8][0] > $final[9][0]){
						$teamA[4] = $final[9][0];
						$sqlA[4][0] = $final[9][0];
						$sqlA[4][1] = $final[9][1];
						
						$teamB[4] = $final[8][0];
						$sqlB[4][0] = $final[8][0];
						$sqlB[4][1] = $final[8][1];
						} else {
						$teamB[4] = $final[9][0];
						$sqlB[4][0] = $final[9][0];
						$sqlB[4][1] = $final[9][1];
						
						$teamA[4] = $final[8][0];
						$sqlA[4][0] = $final[8][0];
						$sqlA[4][1] = $final[8][1];
					}
					} else {
					if($final[8][0] > $final[9][0]){
						$teamB[4] = $final[9][0];
						$sqlB[4][0] = $final[9][0];
						$sqlB[4][1] = $final[9][1];
						
						$teamA[4] = $final[8][0];
						$sqlA[4][0] = $final[8][0];
						$sqlA[4][1] = $final[8][1];
						} else {
						$teamA[4] = $final[9][0];
						$sqlA[4][0] = $final[9][0];
						$sqlA[4][1] = $final[9][1];
						
						$teamB[4] = $final[8][0];
						$sqlB[4][0] = $final[8][0];
						$sqlB[4][1] = $final[8][1];
					}
				}
				//faz update no lobby das equipas ja balanceadas
				$query = "UPDATE lobby SET p1User='".$sqlA[0][1]."',p2User='".$sqlA[1][1]."',p3User='".$sqlA[2][1]."',p4User='".$sqlA[3][1]."',p5User='".$sqlA[4][1]."'
				,p6User='".$sqlB[0][1]."',p7User='".$sqlB[1][1]."',p8User='".$sqlB[2][1]."',p9User='".$sqlB[3][1]."',p10User='".$sqlB[4][1]."',
				updateAt=NOW(),teamBalanced=1 WHERE id= '$lobbyId'";
				if($conn->query($query)){
					//$logger->info("Lobbyid: ".$lobbyId." equilibrado com sucesso por uid: ".$uId);
					echo "Equilibrado com sucesso!";
				} 
				$client->initialize();
				for ($i = 0; $i < 10; $i++) {
					$client->emit('update', [$r[$i]]);
				}
				$client->close();
			}
			
			
		}
		sleep(30);
	}
?>