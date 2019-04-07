	<?php
	Include "../conf/conn.php";
	session_start();
if(isset($_SESSION['uId'])){
	$uId = $_SESSION['uId'];
	$steamId = $_SESSION['steamid'];
	$query = "SELECT * FROM lobby WHERE (owner='$uId' or p1User='$uId' or p2User='$uId' or p3User='$uId' or p4User='$uId' or p5User='$uId' or p6User='$uId'
					or p7User='$uId' or p8User='$uId' or p9User='$uId' or p10User='$uId') and active=1";
		$result = $conn->query($query);
			if(mysqli_num_rows($result) > 0 ){
				$haveLobby = 1;
			} else {
				$haveLobby = 0;
			}
	
	// player stats por match K/D
		$query = "SELECT * FROM get5_stats_players AS play
					INNER JOIN users AS user ON play.steamid64 = user.steamid64
						WHERE user.id = '$uId'";
		$result = $conn->query($query);
		$kills = 0; $deaths = 0; $heads = 0;
		if(mysqli_num_rows($result) > 0 ){
			while($kD = mysqli_fetch_array($result)){
				$kills += $kD['kills'];
				$deaths += $kD['deaths'];
				$heads += $kD['headshot_kills'];
			}
			$kdRatio = round(($kills / $deaths), 2);
			$headshots = round((($heads / $kills)*100));
		} else {
			$kdRatio = 0;
			$headshots = 0;
		}
		// jogos jogados
		$query = "SELECT count(*) FROM get5_stats_players as play 
					INNER JOIN users as user ON play.steamid64 = user.steamid64
						WHERE user.id = '$uId'";
		$result = $conn->query($query);
		$numMatch = mysqli_fetch_row($result);
		// win rate
		$query = "SELECT team, team1_score, team2_score FROM get5_stats_players AS play
					INNER JOIN users AS user ON play.steamid64 = user.steamid64
						INNER JOIN get5_stats_matches as mat ON mat.matchid = play.matchid
							WHERE user.id = '$uId'";
		$result = $conn->query($query);
		if(mysqli_num_rows($result) > 0 ){
			$wins = 0;
			while($win = mysqli_fetch_array($result)){
				$team = $win['team'];
				if($win[$team.'_score'] == 1){
					$wins ++;
				} 
			}
			$winRate =  (($wins / $numMatch[0])*100);
		} else {
			$winRate = 0;
		}
		// elo atual
		$query = "SELECT elo FROM users 
					WHERE id='$uId'";
		$result = $conn->query($query);
	    $currElo = mysqli_fetch_row($result);
} else {
		$uId = 0;
	}	
?>

			<div class="row " style="margin-top:20px;">
				<div class="col-md-3" style="text-align:center;font-size:16px;">
				  <img class="card-img-top" src="../img/de_cbble.png" alt="[IMAGEM]" style="width:100%;padding-top:15px;">
				  <div class="card-block">
					<h4 class="card-title">Jogados</h4>
					<p class="card-text"><?php echo $numMatch[0]; ?></p>
				  </div>
				</div>
				<div class="col-md-3" style="text-align:center;font-size:16px;">
				  <img class="card-img-top" src="../img/de_cbble.png" alt="[IMAGEM]" style="width:100%;padding-top:15px;">
				  <div class="card-block">
					<h4 class="card-title">Percentagem de Vitória</h4>
					<p class="card-text"><?php echo $winRate; ?>%</p>
				  </div>
				</div>
				<div class="col-md-3" style="text-align:center;font-size:16px;">
				  <img class="card-img-top" src="../img/de_cbble.png" alt="[IMAGEM]" style="width:100%;padding-top:15px;">
				  <div class="card-block">
					<h4 class="card-title">Média de Rácio K/D</h4>
					<p class="card-text"><?php echo $kdRatio; ?></p>
				  </div>
				</div>
				<div class="col-md-3" style="text-align:center;font-size:16px;">
				  <img class="card-img-top" src="../img/de_cbble.png" alt="[IMAGEM]" style="width:100%;padding-top:15px;">
				  <div class="card-block">
					<h4 class="card-title">Média de Headshot </h4>
					<p class="card-text"><?php echo $headshots; ?>%</p>
				  </div>
				</div>
			</div>
        </div>
		
		<div class="col-md-12 alert alert-success" style="margin-top:20px;text-align:center;font-size:20px;">
			Rating Atual: <?php echo $currElo[0]; ?>
		</div>
        <!-- /#page-wrapper -->

