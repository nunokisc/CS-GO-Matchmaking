<?php 

Include "../conf/conn.php";
session_start();
$uId = $_SESSION['uId'];
// se houver parametro get no link 
if(isset($_GET['lobbyId'])){
	if(isset($_SESSION['uId'])){
		$lobbyId = $_GET['lobbyId'];
		$query = "SELECT * FROM users WHERE id=$uId and inQueue=1 ";
		$result = $conn->query($query);
			//se houver resultados tenho um lobby
			if(mysqli_num_rows($result) > 0 ){
				$haveQueue = 1;
			} else {
				$haveQueue = 0;
			}
		//query para retirar os dados do lobby e do servidor que esta associado a ele
		$query = "SELECT * FROM lobby as lb
			inner join servers as sv ON lb.server = sv.id
			WHERE lb.id='$lobbyId' and active=1";
		$result = $conn->query($query);
		$r = mysqli_fetch_row($result);
		// se existir resultado continua se nao morre e retorna um valor
		if(mysqli_num_rows($result) > 0 ){
			
		} else {
			die('0');
		}
		//retirar toda a inform??o dos jogadores que se encontram no lobby
		for ($i = 7; $i < 17; $i++) {
			$query = "SELECT * FROM users where id='$r[$i]'";
			$result = $conn->query($query);
			$u[$i-6] = mysqli_fetch_row($result);
		}
		// print_r($r);
		// echo '</br>';
		// print_r($u);
	} else {
		echo "Sessao expirou!!"; exit();
	}
} else {
	if(isset($_SESSION['uId'])){
		$lobbyId = null;
		//query para retirar os dados do lobby e do servidor que esta associado a ele
		$query = "SELECT * FROM lobby as lb
			inner join servers as sv ON lb.server = sv.id
			WHERE (owner='$uId' or p1User='$uId' or p2User='$uId' or p3User='$uId' or p4User='$uId' or p5User='$uId' or p6User='$uId'
			or p7User='$uId' or p8User='$uId' or p9User='$uId' or p10User='$uId') and active=1";
		$result = $conn->query($query);
		$r = mysqli_fetch_row($result);
		//retirar toda a inform??o dos jogadores que se encontram no lobby
		for ($i = 7; $i < 17; $i++) {
			$query = "SELECT * FROM users where id='$r[$i]'";
			$result = $conn->query($query);
			$u[$i-6] = mysqli_fetch_row($result);
		}
		// print_r($r);
		// echo '</br>';
		// print_r($u);
	} else {
		echo "Sessao expirou!!"; exit();
	}
}
?>

<div class="container-fluid">
                <div class="row">
                    <div class="col-lg-12">
                        <h5 >Lobby #<?php echo $r[0]; ?></h5>
                    </div>

					<div class="col-md-12 row">
					
					<div class="col-md-12">
						<div class="card card-inverse mb-3" style="background-color: #333; border-color: #333;">
						  <!-- Default panel contents -->
						  <div class="panel-heading">Match Actions</div>
						  <ul class="list-group">
							<li class="list-group-item">
								<div class="input-group input-group-sm">
								  <span class="input-group-addon" id="sizing-addon3">Invite URL</span>
								  <input type="text" readonly class="form-control" value="http://matchmaking.backstabd.com/pages/index.php?page=lobby&lobby=<?php echo $r[0]; ?>" aria-describedby="sizing-addon3">
								</div>
							</li>
							<li class="list-group-item">
								<div class="input-group input-group-sm">
								  <span class="input-group-addon" id="sizing-addon3"><a href="steam://connect/185.113.141.5:27113/pracc">Connect</a></span>
								  <input id="connect" type="text" readonly class="form-control" value="<?php 	if($r[33] == ""){echo "CONNECT_IP";} else {echo $r[33]; }?>" aria-describedby="sizing-addon3">
								</div>							
							</li>
						  </ul>
						</div>
					</div>
					
						<div class="col-md-6">
							<div class="card card-inverse mb-3" style="background-color: #333; border-color: #333;">
								<!-- Default panel contents -->
								<div class="panel-heading"><?php if($r[1] == $uId){
																	echo '<div class="input-group">
																			<span class="input-group-btn">
																				<button id="TeamA" class="btn btn-success" onclick="changeTeamName(this);" type="button">Edit</button>
																			</span>
																			<input id="inputTeamA" type="text" class="form-control" value="'.$r[4].'">
																		   </div>';
																} else {
																	echo $r[4];
																}?>
								</div>
							  <ul class="list-group" >
							  <?php 
								for ($i = 1; $i < 6; $i++) {
									if($u[$i] == ""){
										echo '<li class="card-blockquote list-group-item" style="background-color: #333;">Player'.$i.'
											<span class="badge">STEAM_ID: LOREM IPSUM</span>
										</li>';
									} else {
										if($u[$i][0] == $r[1]){
											echo '<li class="card-blockquote list-group-item" style="background-color: #333;">'.$u[$i][1].'
												<span class="glyphicon glyphicon-star" style="color:yellow" aria-hidden="true"></span>
												<span class="badge">'.$u[$i][5].'</span>
											</li>';
										} else {
											echo '<li class="card-blockquote list-group-item" style="background-color: #333;">'.$u[$i][1].'
												<span class="badge">'.$u[$i][5].'</span>
											</li>';
										}
									}
								}
								?>						
							  </ul>
							</div>
						</div>
						<div class="col-md-6">
							<div class="card card-inverse mb-3" style="background-color: #333; border-color: #333;">
								<!-- Default panel contents -->
								<div class="panel-heading"><?php if($r[1] == $uId){
																	echo '<div class="input-group">
																			<span class="input-group-btn">
																				<button id="TeamB" class="btn btn-success" onclick="changeTeamName(this);" type="button">Edit</button>
																			</span>
																			<input id="inputTeamB" type="text" class="form-control" value="'.$r[5].'">
																		   </div>';
																} else {
																	echo $r[5];
																}?>
								</div>
							  <ul class="list-group">
								<?php 
								for ($i = 6; $i < 11; $i++) {
									if($u[$i] == ""){
										echo '<li class="card-blockquote list-group-item" style="background-color: #333;">Player'.$i.'
											<span class="badge">STEAM_ID: LOREM IPSUM</span>
										</li>';
									} else {
										if($u[$i][0] == $r[1]){
											echo '<li class="card-blockquote list-group-item" style="background-color: #333;">'.$u[$i][1].'
												<span class="glyphicon glyphicon-star" style="color:yellow" aria-hidden="true"></span>
												<span class="badge">'.$u[$i][5].'</span>
											</li>';
										} else {
											echo '<li class="card-blockquote list-group-item" style="background-color: #333;">'.$u[$i][1].'
												<span class="badge">'.$u[$i][5].'</span>
											</li>';
										}
									}
								}
								?>						
							  </ul>
							</div>
						</div>
					
					<?php if ($r[30] == 1){?>	
					<div class="col-md-12">
						<div class="panel panel-danger">
						  <!-- Default panel contents -->
						  <div class="panel-heading">VETO | <?php echo $r[4]; echo ": "; echo $u[1][1]; echo " | "; echo $r[5]; echo ": "; echo $u[6][1]; ?></div>
						  <ul class="list-group"
						  <div id ="timer">
						 30
							</div>
							<li class="list-group-item">
							
							<?php 
							$maps=array("de_cbble","de_train","de_overpass","de_nuke","de_inferno","de_cache","de_dust2","de_mirage");
							for ($i = 0; $i < 8; $i++) { 
								if($r[$i+21] == 1){
									echo '<img id="'.$maps[$i].'" src="../img/'.$maps[$i].'.png" onclick="onclickImg(this);" class="img-thumbnail" alt="'.$maps[$i].'" width="12%" height="113">';
								}else{
									 echo '<img style="filter: gray;-webkit-filter: grayscale(100%);" id="'.$maps[$i].'" src="../img/'.$maps[$i].'.png" class="img-thumbnail" alt="'.$maps[$i].'" width="12%" height="113">';
								}
							}
							?>	
							</li>
						  </ul>
						</div>
					</div>
					<?php } ?>
					<div class="col-md-12">
						<div class="panel panel-danger">
						  <!-- Default panel contents -->
						  <div class="panel-heading">Match Stats</div>
						  <ul class="list-group">
							<li class="list-group-item">Game Mode - <?php echo $r[3]; ?></li>
							<li class="list-group-item">Server - <?php echo $r[36]; ?></li>
							<li class="list-group-item">Status - <?php if($r[18] == 1){echo 'Activo';}else{echo 'Inativo';} ?></li>
							<li class="list-group-item">Match info - <p class="alert alert-danger"><?php 	if($r[6] != 10){?> &Aacute; espera de Jogadores! <?php } 
																											else if ($r[6] == 10 && $r[30] == 0 ){?> &Aacute; espera de equilibrio de equipas!<?php } 
																											else if ($r[6] == 10 && $r[30] == 1 && $r[29] != 8){?> &Aacute; espera do VETO! <?php }
																											else if ($r[6] == 10 && $r[30] == 1 && $r[29] == 8 && $r[32] == 0){?> &Aacute; espera do Start Match!<?php }
																											else if ($r[34] == 1 ){?> Match come&ccedil;ou! <?php }
																											else if ($r[34] == -1 ){?> Match terminou! <?php }?></p></li>
							<?php if($r[1] == $uId && $r[30] == 1 && $r[29] == 8 && $r[34] == 0){ echo'<li class="list-group-item"><button type="button" onclick="createMatch();" class="btn btn-success btn-block">Start Match</button></li>';}?>
							<?php 	$inside=0;
									for ($i = 7; $i < 17; $i++) { 
										if($r[$i] == $uId && $r[34] == 0){ 
											echo'<li class="list-group-item"><button  onclick="leaveLobby();" type="button" class="btn btn-danger btn-block">Leave Lobby</button></li>';
											$inside = 1;
										}
									}
									if($inside == 0 && $r[34] == 0 && $haveQueue == 0 ){echo'<li class="list-group-item"><button  onclick="joinLobby();" type="button" class="btn btn-success btn-block">Join Lobby</button></li>';}
									?>
							<?php if($r[1] == $uId && $r[6] == 10 && $r[30] == 0){ echo'<li class="list-group-item"><button onclick="sortTeams();" type="button" class="btn btn-default btn-block">Equilibrar Equipas</button></li>';}?>
						  </ul>
						</div>
					</div>
					
					</div>
					
					</div>
					   
				<div class="row">

				</div>
                <!-- /.row -->
            </div>
<script>
	var lobbyId = <?php echo $r[0]; ?>;
	var lastUpdate = "<?php echo $r[20];?>";
	var vetoA = "<?php echo $r[7]; ?>";
	var vetoB = "<?php echo $r[12]; ?>";
	var trigger = <?php echo $r[29]; ?>;
	var socketIoAddress = "91.121.84.50:4000";
	var timer = <?php echo $r[35]; ?>;
	var t;
	if(typeof socket == 'undefined'){
		socket = io.connect("http://"+socketIoAddress, { query: "lobby="+lobbyId+""});
	}
	
	socket.on('update', function(msg){
		checkPageUpdates();
	});	
	clearInterval(t);
	if(timer != 0 && trigger < 8){
		t = setInterval(myFunction, 1000)
	}
	function myFunction() {
		timer = timer - 1;
		$('#timer').html(timer);
	}
		
function onclickImg(str){
	if(vetoA == "<?php echo $_SESSION['uId']; ?>" || vetoB == "<?php echo $_SESSION['uId']; ?>"){
		if(vetoA == "<?php echo $_SESSION['uId']; ?>" && (trigger == 1 ||trigger == 3||trigger == 5|| trigger == 7)){
			trigger +=1;
			$.ajax({
				   type: "POST",
				   url: "veto_proc.php",
				   data: {lobbyId: lobbyId,mapname: str.id,trigger: trigger}, // serializes the form's elements.
				   success: function(data)
				   {
					   alert(data); // show response from the php script.
					   socket.emit("update", lobbyId);
					   socket.emit("veto", {lobbyId, trigger});
				   }
				 });
		}
		if(vetoB == "<?php echo $_SESSION['uId']; ?>" && (trigger == 2 ||trigger == 4|| trigger == 6)){
			trigger +=1;
			$.ajax({
				   type: "POST",
				   url: "veto_proc.php",
				   data: {lobbyId: lobbyId,mapname: str.id,trigger: trigger}, // serializes the form's elements.
				   success: function(data)
				   {
					   alert(data); // show response from the php script.
					   socket.emit("update", lobbyId);
					   socket.emit("veto", {lobbyId, trigger});
				   }
				 });
		}
	}
}	
	
function checkPageUpdates (){
	$.ajax({
		url:"autoRefresh_proc.php",
		type:'GET',
		data : {lobbyId: lobbyId,lastUpdate: lastUpdate },
			success: function(data){
				if(data == 1){
					$.ajax({
						url:"lobby.php",
						type:'GET',
						data : {lobbyId: lobbyId},
							success: function(data){
									$('#page-wrapper').html(data);
							}
					});
				} else if(data == 0){
					//console.log("No Updates!!");
				} else if(data == -1){
					$('#page-wrapper').html("Lobby já nao existe!");
					//console.log("No page");
					//clearInterval(timerCheckUpdates);
				} else if(data == 2){
					$('#page-wrapper').html("Sessao expirou!");
					//console.log("No page");
					//clearInterval(timerCheckUpdates);
				}
			}
	});	
}

function sortTeams(){ // owner fault
	var url = "sort_proc.php"; // the script where you handle the form input.

		$.ajax({
			   type: "POST",
			   url: url,
			   data: {lobbyId: lobbyId }, // serializes the form's elements.
			   success: function(data)
			   {
				   alert(data); // show response from the php script.
				   socket.emit("update", lobbyId);
				   socket.emit("startVeto", {lobbyId, trigger});
			   }
			 });
}

	
function changeTeamName(str){//owner fault
	if(str.id == "TeamA"){
		console.log($("#inputTeamA").val());
		var url = "changeTeamName.php"; // the script where you handle the form input.

				$.ajax({
					   type: "POST",
					   url: url,
					   data: {teamName: $("#inputTeamA").val(),teamId: "teamA",lobbyId: lobbyId  }, // serializes the form's elements.
					   success: function(data)
					   {
						   alert(data); // show response from the php script.
						   socket.emit("update", lobbyId);
					   }
					 });
	}else if(str.id == "TeamB"){
		console.log($("#inputTeamB").val());
		var url = "changeTeamName.php"; // the script where you handle the form input.

			$.ajax({
				   type: "POST",
				   url: url,
				   data: {teamName: $("#inputTeamB").val(),teamId: "teamB",lobbyId: lobbyId }, // serializes the form's elements.
				   success: function(data)
				   {
					   alert(data); // show response from the php script.
					   socket.emit("update", lobbyId);
				   }
				 });
	}
}
function joinLobby(){
	var url = "joinLobby_proc.php"; // the script where you handle the form input.

			$.ajax({
				   type: "POST",
				   url: url,
				   data: {lobbyId: lobbyId }, // serializes the form's elements.
				   success: function(data)
				   {
						alert(data); // show response from the php script.
						window.location.replace("index.php?page=lobby&lobby="+lobbyId);
						socket.emit("update", lobbyId);
				   }
				 });
}
function leaveLobby(){
	var url = "leaveLobby_proc.php"; // the script where you handle the form input.

			$.ajax({
				   type: "POST",
				   url: url,
				   data: {lobbyId: lobbyId }, // serializes the form's elements.
				   success: function(data)
				   {
					   if(data == 1){
						   if (confirm('Queres eliminar o lobby?')) {
								$.ajax({
									   type: "POST",
									   url: "leaveLobbyOwner_proc.php",
									   data: {lobbyId: lobbyId }, // serializes the form's elements.
									   success: function(data)
									   {
										   alert(data); // show response from the php script.
										   window.location.replace("index.php");
									   }
									  });
							} else {
								// Do nothing!
							}
					   } else {
							alert(data); // show response from the php script.
							window.location.replace("index.php?page=lobby&lobby="+lobbyId);
							socket.emit("update", lobbyId);
					   }
					   
				   }
				 });
}
function createMatch(){//owner fault
	var url = "createMatch_proc.php"; // the script where you handle the form input.

			$.ajax({
				   type: "POST",
				   url: url,
				   data: {lobbyId: lobbyId }, // serializes the form's elements.
				   success: function(data)
				   {
						alert(data); // show response from the php script.
						console.log(data);
						socket.emit("update", lobbyId);
				   }
				 });
			$.ajax({
				   type: "POST",
				   url: "elo_proc.php",
				   data: {lobbyId: lobbyId }, // serializes the form's elements.
				   success: function(data)
				   {
						alert(data); // show response from the php script.
						socket.emit("update", lobbyId);
				   }
				 });
}

</script>