<?php 
Include "../conf/conn.php";
session_start();
	if(isset($_SESSION['uId'])){
	$uId = $_SESSION['uId'];
	$lobbyId = $_POST['lobbyId'];
	$freePlace = null;
	}
			
	if(isset($_SESSION['uId']) and isset($_POST['lobbyId'])){
		
		$query = "SELECT * FROM lobby as lb
		inner join servers as sv ON lb.server = sv.id
		WHERE (owner='$uId' or p1User='$uId' or p2User='$uId' or p3User='$uId' or p4User='$uId' or p5User='$uId' or p6User='$uId'
		or p7User='$uId' or p8User='$uId' or p9User='$uId' or p10User='$uId') and active=1";
		$result = $conn->query($query);
			if(mysqli_num_rows($result) > 0 ){
				echo 'Já estas num lobby';
			} else {
				$query = "SELECT * FROM lobby as lb
					inner join servers as sv ON lb.server = sv.id
					WHERE lb.id='$lobbyId' and active=1";
				$result = $conn->query($query);
				$r = mysqli_fetch_row($result);
			
			
			for ($i = 7; $i < 17; $i++) { 
				if($r[$i] == ""){ 
					//echo " Lugar ". ($i-6) ." Vazio!!";
					$freePlace = $i;
					break;
				} 
			}
			if($freePlace != null){
				$query = "UPDATE lobby SET p".($i-6)."User='$uId',players=players+1,updateAt=NOW() WHERE id= '$lobbyId'";
				$result = $conn->query($query);
				echo "Adicionado ao lobby com sucesso!!";
			} else {
				echo "Lobby cheio!!";
			}
		}
	}
?>