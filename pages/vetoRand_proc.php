<?php 
Include "../conf/conn.php";
$lobbyId = $argv[1];
$query = "SELECT who from lobby WHERE id= '$lobbyId'";
	$result = $conn->query($query);
	$temp = mysqli_fetch_row($result);
	$query = "SELECT de_cbble, de_train, de_overpass, de_nuke, de_inferno, de_cache, de_dust2, de_mirage from lobby WHERE id= '$lobbyId'";
		$result = $conn->query($query);
		$r = mysqli_fetch_row($result);
			for($i = 0; $i < 8; $i++){
				$s[$i][0] = $r[$i];
			}
		
		$s[0][1] = "de_cbble";
		$s[1][1] = "de_train";
		$s[2][1] = "de_overpass";
		$s[3][1] = "de_nuke";
		$s[4][1] = "de_inferno";
		$s[5][1] = "de_cache";
		$s[6][1] = "de_dust2";
		$s[7][1] = "de_mirage";
			for($i = 0; $i < 8; $i++){
				if($s[$i][0] == 1){
					$query = "UPDATE lobby SET ".$s[$i][1]."=0,who=who+1,updateAt=NOW(), timer = 30 WHERE id= '$lobbyId'";
					$result = $conn->query($query);
					$return['msg'] = "Random Mapa Banido";
					$return['status'] = $temp[0]+1;
					echo json_encode($return);
					echo mysqli_error($conn);
					break;
				}
			}
?>