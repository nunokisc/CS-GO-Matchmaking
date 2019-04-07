<?php
	Include "../conf/conn.php";
	session_start();
	$uId = $_SESSION['uId'];
	$query = "SELECT elo FROM users where id=$uId and inQueue=0";
	$result = $conn->query($query);
	$r = mysqli_fetch_row($result);
	$elo = $r[0];
	if(mysqli_num_rows($result) > 0 ){
		$query = "UPDATE users SET inQueue=1 WHERE id=$uId";
		$result = $conn->query($query);
		$query = "INSERT INTO queue (userid,elo) VALUES ($uId,$elo)";
		$result = $conn->query($query);
		echo "Em queue!! </br>";
		}else{
		echo "Em queue!! </br>";
	}
	$query = "SELECT count(*) FROM queue";
	$result = $conn->query($query);
	$r = mysqli_fetch_row($result);
	echo "Estao ".$r[0]." utilizadores em queue!";
?>
<script>
	var userid = <?php echo $uId ?>;
	var socketIoAddress = "91.121.84.50:4001";
	if(typeof socket == 'undefined'){
		socket = io.connect("http://"+socketIoAddress, { query: "userid="+userid+""});
	}
	socket.on('update', function(msg){
		window.location.replace("index.php?page=lobby");
	});	
</script>