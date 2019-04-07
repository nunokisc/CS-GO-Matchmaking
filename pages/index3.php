	<?php
	Include "../conf/conn.php";
	session_start();
	require ('steamauth/steamauth.php');
	$haveLobby = null;
	$haveQueue = null;
	if(isset($_SESSION['uId'])){
		$uId = $_SESSION['uId'];
		//query para selecionar lobby onde o proprio user esta inserido
		$query = "SELECT * FROM lobby WHERE (owner='$uId' or p1User='$uId' or p2User='$uId' or p3User='$uId' or p4User='$uId' or p5User='$uId' or p6User='$uId'
					or p7User='$uId' or p8User='$uId' or p9User='$uId' or p10User='$uId') and active=1";
		$result = $conn->query($query);
			//se houver resultados tenho um lobby
			if(mysqli_num_rows($result) > 0 ){
				$haveLobby = 1;
			} else {
				$haveLobby = 0;
			}
		//query para selecionar lobby onde o proprio user esta inserido
		$query = "SELECT * FROM users WHERE id=$uId and inQueue=1 ";
		$result = $conn->query($query);
			//se houver resultados tenho um lobby
			if(mysqli_num_rows($result) > 0 ){
				$haveQueue = 1;
			} else {
				$haveQueue = 0;
			}
	} else {
		$uId = 0;
	}
	//verifica get page
	if(isset($_GET['page'])){
		$page = $_GET['page'];
	} else {
		$page = null;
	}
	//verifica get lobby
	if(isset($_GET['lobby'])){
		$lobbyId = $_GET['lobby'];
	} else {
		$lobbyId = null;
	}
?>
<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Matchmaking - Backstabd</title>
	<!-- <script src="http://91.121.84.50:4000/socket.io/socket.io.js"></script>
	<script src="http://91.121.84.50:4001/socket.io/socket.io.js"></script> -->

    <!-- Bootstrap Core CSS -->
    <link href="../vendor/bootstrap4/css/bootstrap.min.css" rel="stylesheet">
    <link href="../vendor/font-awesome/css/font-awesome.min.css" rel="stylesheet">
	<script src="../vendor/jquery/jquery.min.js"></script>
	<script src="../vendor/bootstrap4/js/bootstrap.min.js"></script>
	

</head>
<style>
body{
	background-color:#252525;
	
}

.topSite{
	margin-top:100px;
	margin-left:100px;
	padding-right: 120px;
}

.middleSite{
	margin-top:20px;
	margin-left:85px;
	padding-right: 120px;
}

.userBar, .menuBar{
	list-style-type: none;
    margin: 0;
    padding: 0;
    overflow: hidden;
    background-color: #8a8a8a;
	height:100px;
}

.menuBar{
	margin-left:5px;
}

li img{
	background-color:#000;
	height: 71px;
    width: 71px;
	object-fit: cover;
}

.userBar li .nickname{
    display: block;
    color: #141414;
    text-align: center;
    text-decoration: none;
	margin-top:12px;
	font-size: 1.5vw;
}

.menuBar li{
    float:left;
	height:100%;
	display:table;
}

.menuBar li a{
    display: table-cell;
	vertical-align:middle;
    color: #141414;
    text-align: center;
    text-decoration: none;
	height:100%;
	padding:0px 30px;
	font-size: 3vw;
}

.menuBar li a:hover {
    color: #fff;
}

.userBar li .teamname{
	display: block;
    color: #fff;
    text-align: center;
    text-decoration: none;
	font-size: 1.2vw;
}

.card{
	border-radius:0;
	border:0;
}

.card-block{
	min-height: 500px;
}

.card-footer:last-child{
	background-color:#141414;
	border-radius:0;
}

.card-header:first-child{
	background-color:#b26900;
	font-size: 3vw;
	color:#fff;
	border-radius:0;
}
</style>
<body>

<div class="topSite">
<nav class="navbar navbar-expand-lg navbar-toggleable-md navbar-light" style="background-color: #8a8a8a;font-size: 3vw;">
  <div class="container col-md-12">
        <button class="navbar-toggler border-0" type="button" data-toggle="collapse" data-target="#exCollapsingNavbar">
            &#9776;
        </button>
        <div class="collapse navbar-collapse" id="exCollapsingNavbar">
            <ul class="nav navbar-nav">
                <li class="nav-item"><a href="#" class="nav-link" style="margin-right:20px;">ÍNICIO</a></li>
                <li class="nav-item"><a href="#" class="nav-link" style="margin-right:20px;">ESTATÍSTICAS</a></li>
                <li class="nav-item"><a href="#" class="nav-link" style="margin-right:20px;">EQUIPA</a></li>
                <li class="nav-item"><a href="#" class="nav-link" style="margin-right:20px;">OPÇÕES</a></li>
            </ul>
			
            <ul class="nav navbar-nav flex-row justify-content-between ml-auto">
			<?php if ( isset($_SESSION['username']) and isset($_SESSION['password']) ) { 
			
			?>
			<li class="nav-item order-2 order-md-1"><img src="../img/de_cache.png"></img></li>
                </li>
			
			<li class="nav-item order-2 order-md-1" style="text-align: center;"><a href="#" class="nav-link" title="settings" style="font-size:1vw; text-align:center;padding: 0;"><?php echo $_SESSION['username'] ?></a><a href="#" class="nav-link" title="settings" style="font-size:1vw; text-align:center;padding: 0;"><?php echo $_SESSION['team'] ?></a><a href="logout.php" class="nav-link" style="font-size:1vw; text-align:center;padding: 0;">LOGOUT</a></li>
                </li>
			
			
			<?php
			}else{
			?>
                <li class="nav-item order-2 order-md-1"><a href="#" class="nav-link" title="settings" data-toggle="modal" data-target=".bd-example-modal-lg">LOGIN</a></li></ul>
                </li>
			<?php } ?>
            </ul>
        </div>
    </div>
   
     
</nav>
</div>
<div class="middleSite row">
	<div id="PicksMenu" class="col-md-4">
		<div class="card text-center">
		<div class="card-header">PICKS</div>
		  <div class="card-block">
			<p class="card-text">
			[][][][][][][][][][]
			
			</p>
			<a href="#" class="btn btn-primary">CRIAR PICK</a>
		  </div>
			<div class="card-footer text-muted">
				TEST
			</div>		  
		</div>
    </div>
	
	<div id="MixesMenu" class="col-md-4">
		<div class="card text-center">
		 <div class="card-header">MIXES</div>
		  <div class="card-block">
			<p class="card-text">CONTENT HERE</p>
			<a href="#" class="btn btn-primary">PROCURAR PARTIDA</a>
		  </div>
			<div class="card-footer text-muted">
				TEST
			</div>
		</div>
    </div>
	
	<div id="PraccMenu" class="col-md-4">
		<div class="card text-center">
		 <div class="card-header">PCW FINDER</div>
		  <div class="card-block">
			<p class="card-text">CONTENT HERE</p>
			<a href="#" class="btn btn-primary">CRIAR PCW</a>
		  </div>
			<div class="card-footer text-muted">
				TEST
			</div>
		</div>
    </div>
</div>	
	
	
<div class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content" style="padding: 20px;">
      
	  <div class="container">
        <form class="form-horizontal" role="form" method="POST" action="login_proc.php">
            <div class="row">
                <div class="col-md-3"></div>
                <div class="col-md-6">
                    <h2>Please Login</h2>
                    <hr>
                </div>
            </div>
            <div class="row">
                <div class="col-md-3"></div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="sr-only" for="email">E-Mail Address</label>
                        <div class="input-group mb-2 mr-sm-2 mb-sm-0">
                            <div class="input-group-addon" style="width: 2.6rem"><i class="fa fa-at"></i></div>
                            <input type="text" name="username" class="form-control" id="email"
                                   placeholder="you@example.com" required autofocus>
                        </div>
                    </div>
                </div>
                <!-- <div class="col-md-3"> -->
                    <!-- <div class="form-control-feedback"> -->
                        <!-- <span class="text-danger align-middle"> -->
                            <!-- <i class="fa fa-close"></i> Example error message -->
                        <!-- </span> -->
                    <!-- </div> -->
                <!-- </div> -->
            </div>
            <div class="row">
                <div class="col-md-3"></div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="sr-only" for="password">Password</label>
                        <div class="input-group mb-2 mr-sm-2 mb-sm-0">
                            <div class="input-group-addon" style="width: 2.6rem"><i class="fa fa-key"></i></div>
                            <input type="password" name="password" class="form-control" id="password"
                                   placeholder="Password" required>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-control-feedback">
                        <span class="text-danger align-middle">
                        <!-- Put password error message here -->    
                        </span>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-3"></div>
                <div class="col-md-6" style="padding-top: .35rem">
                    <div class="form-check mb-2 mr-sm-2 mb-sm-0">
                        <label class="form-check-label">
                            <input class="form-check-input" name="remember"
                                   type="checkbox" >
                            <span style="padding-bottom: .15rem">Remember me</span>
                        </label>
                    </div>
                </div>
            </div>
            <div class="row" style="padding-top: 1rem">
                <div class="col-md-3"></div>
                <div class="col-md-6">
                    <button type="submit" class="btn btn-success"><i class="fa fa-sign-in"></i> Login</button>
                    <a class="btn btn-link" href="/password/reset">Forgot Your Password?</a>
                </div>
            </div>
        </form>
    </div>
	  
	  
	  
    </div>
  </div>
</div>	
	
	
	
</body>
<script>

	
var page = "<?php echo $page; ?>";
	var uid = "<?php echo $uId; ?>";
	var haveLobby = "<?php echo $haveLobby; ?>";
	var lobbyId = "<?php echo $lobbyId; ?>";
	var haveQueue = "<?php echo $haveQueue; ?>";
	
	
	$('.sliderInicial').carousel();
	
	function startQueue(){
		if(haveLobby == 0 && haveQueue == 0){
		$.ajax({
			url:"queue.php",
			type:'GET',
			data : {uid: uid},
				success: function(data){
					$('#queuePanel').html("<li>" + data + "</li>");
					$('#playModal').modal('toggle');
				}
		});
		}
	}
	
	$("#changePassword").submit(function(e) {

			var url = "changePass_proc.php"; // the script where you handle the form input.

			$.ajax({
				   type: "POST",
				   url: url,
				   data: $("#changePassword").serialize(), // serializes the form's elements.
				   success: function(data)
				   {
					   alert(data); // show response from the php script.
					   window.location.replace("index.php");
				   }
				 });

			e.preventDefault(); // avoid to execute the actual submit of the form.
		});
	
	$("#createLobby").submit(function(e) {

			var url = "createLobby_proc.php"; // the script where you handle the form input.

			$.ajax({
				   type: "POST",
				   url: url,
				   data: $("#createLobby").serialize(), // serializes the form's elements.
				   success: function(data)
				   {
					   alert(data); // show response from the php script.
					   window.location.replace("index.php?page=lobby");
				   }
				 });

			e.preventDefault(); // avoid to execute the actual submit of the form.
			//console.log($("#createLobby").serialize());
		});
	if(haveQueue == 1 && haveLobby == 0){
		$.ajax({
			url:"queue.php",
			type:'GET',
			data : {uid: uid},
				success: function(data){
					$('#queuePanel').html("<li>" + data + "</li>");
				}
		});
	}
		
	if(page == "lobby" &&  uid != 0 && haveLobby == 1 && lobbyId == ""){
		$.ajax({
			url:"lobby.php",
			type:'GET',
				success: function(data){
					$('#page-wrapper').html(data);
				}
		});
	} else if (page == "lobby" &&  uid == 0){
		$('#page-wrapper').html("Fazer login!!");
	} else if (page == "lobby" &&  uid != 0 && lobbyId != ""){
		$.ajax({
			url:"lobby.php",
			type:'GET',
			data : {lobbyId: lobbyId},
				success: function(data){
					if(data == 0){
						$('#page-wrapper').html("Lobby nao existe!");
					}else{
						$('#page-wrapper').html(data);
					}
				}
		});
	} else if (page == "lobby" &&  uid != 0 && haveLobby == 0 && lobbyId == "") {
		$('#page-wrapper').html("Nao tem nenhum lobby associado!!");
	} else if (page == "profile") {
		$.ajax({
			url:"profile.php",
			type:'GET',
				success: function(data){
					$('#page-wrapper').html(data);
				}
		});
	} else if (page == "register") {
		$.ajax({
			url:"register.php",
			type:'GET',
				success: function(data){
					$('#page-wrapper').html(data);
				}
		});
	}
</script>
  

</body>