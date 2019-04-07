<?php
Include "../conf/conn.php";
session_start();
if(isset($_SESSION['uId'])){
	$uId = $_SESSION['uId'];
	$lobbyId = $_POST['lobbyId'];
}

	require __DIR__ . '/SourceQuery/bootstrap.php';

	use xPaw\SourceQuery\SourceQuery;
	
	// For the sake of this example
	Header( 'Content-Type: text/plain' );
	Header( 'X-Content-Type-Options: nosniff' );
	
	// Edit this ->
	define( 'SQ_SERVER_ADDR', '185.113.141.5' );
	define( 'SQ_SERVER_PORT', 27113 );
	define( 'SQ_TIMEOUT',     1 );
	define( 'SQ_ENGINE',      SourceQuery::SOURCE );
	// Edit this <-
	// Cria variavel para connectar rcon
	$sendRcon = new SourceQuery( );
if(isset($_SESSION['uId']) and isset($_POST['lobbyId'])){
	//query para verificar mapas nome das teams e o id do lobby
	$query = "SELECT teamA,teamB,de_cbble, de_train, de_overpass, de_nuke, de_inferno, de_cache, de_dust2, de_mirage, id FROM lobby 
		WHERE id='$lobbyId' and active=1";
	$result = $conn->query($query);
	$r = mysqli_fetch_assoc($result);
	// verifica qual o mapa que foi selecionado no veto
		if($r["de_cbble"] == 1){
			$map = "de_cbble";
		} else if($r["de_train"] == 1){
			$map = "de_train";
		}else if($r["de_overpass"] == 1){
			$map = "de_overpass";
		}else if($r["de_nuke"] == 1){
			$map = "de_nuke";
		}else if($r["de_inferno"] == 1){
			$map = "de_inferno";
		}else if($r["de_cache"] == 1){
			$map = "de_cache";
		}else if($r["de_dust2"] == 1){
			$map = "de_dust2";
		}else if($r["de_mirage"] == 1){
			$map = "de_mirage";
		}
		//query para selecionar os users do lobby
	$query = "SELECT p1User,p2User,p3User,p4User,p5User,p6User,p7User,p8User,p9User,p10User FROM lobby 
		WHERE id='$lobbyId' and active=1";
	$result = $conn->query($query);
	$s = mysqli_fetch_row($result);
	//vai buscar a steamid dos users por ordem e adiciona num array
	for ($i = 0; $i < 10; $i++) {
			$query = "SELECT steamid FROM users 
					WHERE id='".$s[$i]."'";
			$result = $conn->query($query);
			$d[$i] = mysqli_fetch_row($result);
			$steamIds[$i] = $d[$i][0];
		}
	// print_r($r);
	// print_r($s);
	// print_r($steamIds);
	//seleciona o ficheiro que vai ser criado
	$myfile = fopen("match.cfg", "w") or die("Unable to open file!");
	$txt = '
	"Match"
	{
		"maps_to_win"		"1" // Maps needed to win the series. 1 in a BO1, 2 in a BO3, 3 in a BO5, etc.
		"bo2_series"		"0" // If set to 1, "maps_to_win" is ignored and the series will always play out 2 maps

		"skip_veto"		"1" // If set to 1, the maps will be preset using the first maps in the maplist below.

		"side_type"		"always_knife" // Either "standard", "always_knife", or "never_knife"

		"maplist"
		{
			"'.$map.'"		""
		}

		"players_per_team"		"5"
		"min_players_to_ready"	"5"
		"min_spectators_to_ready"	"0"

		"team1"
		{
			"name"		"'.$r["teamA"].'" // You should always set a team name, otherwise some chat messages will not make sense. If there is no true team name, use "Team1" at least.
			"flag"		"PT"
			"players"
			{
				// Any of the 3 formats (steam2, steam3, steam64 profile) are acceptable.
				// Note: the "players" section may be skipped if you set get5_check_auths to 0, but this is not recommended.
				"'.$steamIds[0].'"		""
				"'.$steamIds[1].'"		""
				"'.$steamIds[2].'"		""
				"'.$steamIds[3].'"		""
				"'.$steamIds[4].'"		""
			}
		}
		"team2"
		{
			"name"		"'.$r["teamB"].'"
			"flag"		"PT"
			"players"
			{
				"'.$steamIds[5].'"		""
				"'.$steamIds[6].'"		""
				"'.$steamIds[7].'"		""
				"'.$steamIds[8].'"		""
				"'.$steamIds[9].'"		""
			}
		}
		// These will be executed on each map start or config load.
		// You should not use this as a replacement for the cfg/get5/live.cfg config.
		"cvars"
		{
			"hostname"		"Waaclive.com - Backstabd Pick #'.$r["id"].'"
			"get5_mysql_force_matchid" ""
		}
	}
	';
	// print_r($txt);
	// escreve o ficheiro e guarda o 
	fwrite($myfile, $txt);
	fclose($myfile);
	
	//configs do ftp 
	$file = 'match.cfg';
	$remote_file = 'match.cfg';
	$ftp_server = "185.113.141.5";
	$dst_dir = "/185.113.141.5-27113/csgo";
	$ftp_user_name = "backstab460";
	$ftp_user_pass = "backstabbing123";
	// set up basic connection
	$conn_id = ftp_connect($ftp_server);

	// login with username and password
	$login_result = ftp_login($conn_id, $ftp_user_name, $ftp_user_pass);

	// upload a file
	if (ftp_put($conn_id, $dst_dir."/".$file, $remote_file, FTP_ASCII)) {
		 echo "successfully uploaded $file\n";
			// envia para o servidor por rcon o comando para fazer load da match config criada e que foi feito upload no servidor
			 try
			{
				$sendRcon->Connect( SQ_SERVER_ADDR, SQ_SERVER_PORT, SQ_TIMEOUT, SQ_ENGINE );
				
				$sendRcon->SetRconPassword( 'dixon' );
				
				var_dump( $sendRcon->Rcon( 'get5_loadmatch '.$file ) );
			}
			catch( Exception $e )
			{
				echo $e->getMessage( );
			}
			$sendRcon->Disconnect( );
				// espera a match ser iniciada
				sleep(2);
					// pede o status ao servidor que retorna um json para ser retirado o match id para depois ser updated na tabela do lobby
					try
					{
						$sendRcon->Connect( SQ_SERVER_ADDR, SQ_SERVER_PORT, SQ_TIMEOUT, SQ_ENGINE );
						
						$sendRcon->SetRconPassword( 'dixon' );
						
						$status =  json_decode($sendRcon->Rcon( "get5_status" ));
					}
					catch( Exception $e )
					{
						echo $e->getMessage( );
					}
					$sendRcon->Disconnect( );
					//vai buscar o match id dentro do json
					$matchId = $status->matchid;
						//query que faz o update de tudo o que é necessario no lobby
						$query = "UPDATE lobby SET connect='connect 185.113.141.5:27113;password pracc', enable=1, updateAt=NOW(), matchId= '$matchId'
							WHERE id='$lobbyId'";
						$result = $conn->query($query);
		echo "Match started";
	} else {
		echo "There was a problem while uploading $file\n";
	}

	// close the connection
	ftp_close($conn_id);
	
 }
?>