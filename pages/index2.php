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
	<script src="http://91.121.84.50:4000/socket.io/socket.io.js"></script>
	<script src="http://91.121.84.50:4001/socket.io/socket.io.js"></script>

    <!-- Bootstrap Core CSS -->
    <link href="../vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

    <!-- MetisMenu CSS -->
    <link href="../vendor/metisMenu/metisMenu.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="../dist/css/sb-admin-2.css" rel="stylesheet">

    <!-- Morris Charts CSS -->
    <link href="../vendor/morrisjs/morris.css" rel="stylesheet">

    <!-- Custom Fonts -->
    <link href="../vendor/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->

</head>
<style>
body{
	background-color: #424242 !important;
}

a {
    color: #f21d1d;
    text-decoration: none;
}

a:focus, a:hover {
    color: #fff;
    text-decoration: underline;
}



@media (min-width: 768px)
#page-wrapper {
    position: inherit;
    margin: 0 0 0 250px;
    padding: 0 30px;
    border-left: none !important;
    border-top: 1px solid #a20e0e;
}

#page-wrapper {
    padding: 0 15px;
    min-height: 568px;
    background-color: #424242;
    border-left: none !important;
    border-top: 1px solid #a20e0e;
}

.navbar-inverse{
	border-color:#222;
}

.nav > li > a:focus, .nav > li > a:hover {
    text-decoration: none;
    background-color: #a20e0e;
}

.sidebar ul li {
    border-bottom: none;
	font-size: 14px;
	text-transform: uppercase;
	font-weight: bold;
}




</style>
<body>

    <div id="wrapper">

        <!-- Navigation -->
        <nav class="navbar navbar-inverse navbar-static-top" role="navigation" style="margin-bottom: 0">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="index.php">Matchmaking - Backstabd</a>
            </div>
            <!-- /.navbar-header -->

            <ul class="nav navbar-top-links navbar-right">
			<?php
				if ( isset($_SESSION['username']) and isset($_SESSION['password']) ) { ?>

                <li class="dropdown">
                    <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                        <i class="fa fa-envelope fa-fw"></i> <i class="fa fa-caret-down"></i>
                    </a>
                    <ul class="dropdown-menu dropdown-messages">
                        
                        <li class="divider"></li>
                        <li>
                            <a class="text-center" href="#">
                                <strong>Ler todas as mensagens</strong>
                                <i class="fa fa-angle-right"></i>
                            </a>
                        </li>
                    </ul>
                    <!-- /.dropdown-messages -->
                </li>
                <!-- /.dropdown -->
                
                <!-- /.dropdown -->
                <li class="dropdown">
                    <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                        <i class="fa fa-bell fa-fw"></i> <i class="fa fa-caret-down"></i>
                    </a>
                    <ul class="dropdown-menu dropdown-alerts">
                       
                        <li class="divider"></li>
                        <li>
                            <a class="text-center" href="#">
                                <strong>Ver todas as notificações</strong>
                                <i class="fa fa-angle-right"></i>
                            </a>
                        </li>
                    </ul>
                    <!-- /.dropdown-alerts -->
                </li>
				<?php }
				?>
                <!-- /.dropdown -->
                <li class="dropdown">
                    <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                        <i class="fa fa-user fa-fw"></i> <i class="fa fa-caret-down"></i>
                    </a>
                    <ul class="dropdown-menu dropdown-user">
					<?php
						if ( isset($_SESSION['username']) and isset($_SESSION['password']) ) {
							echo '
								<li><p class="text-center">Olá ' . $_SESSION['username'] . ' </p></li>
								<li class="divider"></li>
								<li><a href="index.php?page=profile"><i class="fa fa-user fa-fw"></i> User Profile</a>
								</li>
								<li><a href="#"><i class="fa fa-gear fa-fw"></i> Settings</a>
								</li>
								<li><a href="#" data-toggle="modal" data-target="#changePwModal"><i class="fa fa-gear fa-fw"></i> Mudar Password</a>
								</li>
								<li class="divider"></li>
								<li><a href="logout.php"><i class="fa fa-sign-out fa-fw"></i> Logout</a>
								</li>';
						} else {
							echo '<div class="panel-body">
									<form method="POST" action="login_proc.php" id="formlogin" name="formlogin" role="form">
										<fieldset>
											<div class="form-group">
												<input class="form-control" placeholder="Username" name="username" type="text" autofocus>
											</div>
											<div class="form-group">
												<input class="form-control" placeholder="Password" name="password" type="password" value="">
											</div>
											<div class="checkbox">
												<label>
													<input name="remember" type="checkbox" value="Lembrar Me">Lembrar Me
												</label>
												<a href="?page=register">Registar</a>
											</div>
											<!-- Change this to a button or input when using this as a form -->
											<input type="submit" value="Login" class="btn btn-lg btn-success btn-block">
										</fieldset>
									</form>
									</div>';
						}
					?>
                    </ul>
                    <!-- /.dropdown-user -->
                </li>
                <!-- /.dropdown -->
            </ul>
			</nav>
            <!-- /.navbar-top-links -->
		
            <div class="navbar-inverse sidebar" role="navigation" style="margin-top:0 !important;min-height:100%;border-right:1px solid #a20e0e">
                <div class="sidebar-nav navbar-collapse">
                    <ul class="nav" id="side-menu">
                        <li class="sidebar-search">
                            <div class="input-group custom-search-form">
                                <input type="text" class="form-control" placeholder="Search...">
                                <span class="input-group-btn">
                                <button class="btn btn-default" type="button">
                                    <i class="fa fa-search"></i>
                                </button>
                            </span>
                            </div>
                            <!-- /input-group -->
                        </li>
						<?php
							if ( isset($_SESSION['username']) and isset($_SESSION['password'])) {
								echo '
										<li><a data-toggle="collapse" href="#collapseLobby" aria-expanded="true"><span class="glyphicon glyphicon-chevron-down"></span> Lobby</a>
											<div id="collapseLobby" class="panel-collapse collapse" aria-expanded="true">
											<div class="panel-group">
												<div class="panel panel-danger">

													
													<div class="panel-body">';
																			if($haveLobby == 0 and $haveQueue == 0){
																				echo '<form id="createLobby" role="form">
																							<div class="form-group">
																								<label>Nome:</label>
																								<input name="name" class="form-control">
																							</div>
																							<input type="submit" value="Criar Lobby" class="btn btn-default">
																						</form>';
																			} else {
																				echo '<a href="index.php?page=lobby"><button type="submit" class="btn btn-default">Ir para Lobby</button></a>';
																			}
											echo '</div>
											</div>
											</div>
											</div>
										</li>';
							}
						?>
						<?php if($haveLobby == 0 and isset($_SESSION['username']) and isset($_SESSION['password'])){ ?>
						<li><a data-toggle="collapse" href="#collapseQueue" aria-expanded="true"><span class="glyphicon glyphicon-chevron-down"></span> Queue</a>
							<div id="collapseQueue" class="panel-collapse collapse" aria-expanded="true">
								<div class="panel-group">
									<div class="panel panel-danger">
										<div id="panelQueue" class="panel-body">
											<a href="#" button type="submit" onclick="startQueue();" class="btn btn-default">Iniciar Queue</button></a>
										</div>
									</div>
								</div>
							</div>
						</li>
						<?php } ?>
                        <li>
						<?php
							if ( isset($_SESSION['username']) and isset($_SESSION['password'])) { ?>
								<a href="?page=profile"><span class="glyphicon glyphicon-chevron-right"></span> Perfil</a>
							<?php } else{ ?>
								<a href="login.php"><span class="glyphicon glyphicon-chevron-right"></span> Login</a>
							<?php } ?>
                        </li>
                        
                            </ul>
                            <!-- /.nav-second-level -->
                        </li>
                    </ul>
                </div>
                <!-- /.sidebar-collapse -->
            </div>
            <!-- /.navbar-static-side -->

        <div id="page-wrapper"> 
			<?php
				if ( isset($_GET['error']) ) {
					echo'
							<div class="alert alert-danger">
									O username ou a password estão incorrectos.
							</div> ';
				}
			?>
			
			<div class="progress" style="margin-top:20px;">
			  <div class="progress-bar progress-bar-striped active" role="progressbar" aria-valuenow="45" aria-valuemin="0" aria-valuemax="100" style="width: 30%">
				<span class="sr-only">30% Complete</span>
			  </div>
			</div>
			
        </div>
        <!-- /#page-wrapper -->

    </div>
    <!-- /#wrapper -->
	
	<!-- MODAL CHANGE PASSWORD -->
<!-- Trigger the modal with a button -->
		<button type="button" class="btn btn-info btn-lg" >Open Modal</button>

		<!-- Modal -->
		<div id="changePwModal" class="modal fade" role="dialog">
		  <div class="modal-dialog">

			<!-- Modal content-->
			<div class="modal-content">
			  <div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">&times;</button>
				<h4 class="modal-title">Mudar password</h4>
			  </div>
			  <div class="modal-body">
				<form id="changePassword" role="form">
				  <div class="input-group">
					<span class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></span>
					<input id="oldPassword" type="password" class="form-control" name="oldpassword" placeholder="Password Atual">
				  </div>
				  <div class="input-group">
					<span class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></span>
					<input id="newPassword" type="password" class="form-control" name="password" placeholder="Nova Password">
				  </div>
				  <div class="input-group">
					<span class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></span>
					<input id="newPasswordConfirm" type="password" class="form-control" name="repassword" placeholder="Confirmar Nova Password">
				  </div>
				
			  </div>
			  <div class="modal-footer">
				<button type="submit" class="btn btn-success" >Confirmar</button>
				<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
			  </div>
			  </form>
			</div>

		  </div>
		</div>

    <!-- jQuery -->
    <script src="../vendor/jquery/jquery.min.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="../vendor/bootstrap/js/bootstrap.min.js"></script>

    <!-- Metis Menu Plugin JavaScript -->
    <script src="../vendor/metisMenu/metisMenu.min.js"></script>

    <!-- Morris Charts JavaScript -->
    <script src="../vendor/raphael/raphael.min.js"></script>
    <!--<script src="../vendor/morrisjs/morris.min.js"></script>-->
     <!--<script src="../data/morris-data.js"></script>-->

    <!-- Custom Theme JavaScript -->
    <script src="../dist/js/sb-admin-2.js"></script>
	<script >
	
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
					$('#panelQueue').html(data);
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
					$('#panelQueue').html(data);
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

</html>
