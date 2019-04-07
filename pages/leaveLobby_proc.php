<?php 
Include "../conf/conn.php";
session_start();
if(isset($_SESSION['uId'])){
	$uId = $_SESSION['uId'];
	$lobbyId = $_POST['lobbyId'];
}
if(isset($_SESSION['uId']) and isset($_POST['lobbyId'])){
	$query = "SELECT owner,p1User,p2User,p3User,p4User,p5User,p6User,p7User,p8User,p9User,p10User FROM lobby as lb
		inner join servers as sv ON lb.server = sv.id
		WHERE (owner='$uId' or p1User='$uId' or p2User='$uId' or p3User='$uId' or p4User='$uId' or p5User='$uId' or p6User='$uId'
		or p7User='$uId' or p8User='$uId' or p9User='$uId' or p10User='$uId') and active=1";
	$result = $conn->query($query);
	$r = mysqli_fetch_row($result);
		for ($i = 0; $i < 11; $i++) { 
			if($r[$i] == $uId){ 
				if($i == 0){
					// verificar se é o owner
					$position = $i;
					break;
				}
				// saber a posição onde se encontra o user para remover
				$position = $i;
				break;
			} 
		}
	// se for o owner
	if($i == 0){
		$owner = 1;
		echo $owner;
	}else{
		$query = "UPDATE lobby SET p".$i."User=NULL,players=players-1,updateAt=NOW() WHERE id= '$lobbyId'";
		$result = $conn->query($query);
		echo 'Saiste do lobby!!';
	}	
}
?>