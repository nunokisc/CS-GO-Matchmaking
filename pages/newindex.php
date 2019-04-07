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
    <link href="../vendor/bootstrap4/css/bootstrap.min.css" rel="stylesheet">
    <link href="../vendor/font-awesome/css/font-awesome.min.css" rel="stylesheet">
	<script src="../vendor/jquery/jquery.min.js"></script>
	<script src="../vendor/bootstrap4/js/bootstrap.min.js"></script>
	

</head>
<style>

body {
	height:100vh;
	max-width: 100%;
	overflow:hidden;
}

.container{
	width: 1400px;
}

.sidebar-left,.sidebar-right{
	background-color:#292b2c;
}

.sidebar-left{
	z-index: 2000;
    box-shadow: -1px 1px 13px 3px #000000;
}

.sidebar-right{
	z-index: 2000;
    box-shadow: -1px 1px 13px 1px #000000;
}


.content-middle{
	padding:0;
	background-color:#515b5f;
	color:#fff;
}

.bg-rusty{
	background-color:#515b5f;
}

.row{
	height:1000px;
}

.jumbotron{
	border-radius:0;
}

.jumbotron p,.jumbotron h1{
   color:#fff;
   text-shadow: 2px 1px 3px #1b5c62;
}

.btn-cyan{
	background-color:#186b72;
	color:#fff;
	cursor: pointer;
}

.btn-cyan:hover{
	background-color:#31a1ab;
	color:#fff;
}

.btn-black{
	background-color: #292b2c;
	color:#fff;
}

.btn-black:hover{
	background-color:#505050;
	color:#fff;
}

.modal-content{
	background-color: #212121;
    color: #fff;
    border: 1px solid #3f5b65;
}

.modal-backdrop{
	z-index: 9998;
}

.modal-header,.modal-footer{
	border:none;
}

.modal-backdrop.show {
    opacity: 0.85;
}

.nav-side-menu {
  overflow: auto;
  font-family: verdana;
  font-size: 12px;
  font-weight: 200;
  position: fixed;
  top: 0px;
  height: 100%;
  color: #e1ffff;
}
.nav-side-menu .brand {
  height: 150px;
  display: block;
  text-align:center;
  font-size: 14px;
  background-image:url("../img/Logo2.png");
  background-size: contain;
  background-repeat: no-repeat;
  background-position: center;
  margin-top:20px;
  margin-bottom:20px;
}
.nav-side-menu .toggle-btn {
  display: none;
}
.nav-side-menu ul,
.nav-side-menu li {
  padding: 0px;
  margin: 0px;
  line-height: 35px;
  cursor: pointer;
  /*    
    .collapsed{
       .arrow:before{
                 font-family: FontAwesome;
                 content: "\f053";
                 display: inline-block;
                 vertical-align: middle;
                 float:right;
            }
     }
*/
}
.nav-side-menu ul :not(collapsed) .arrow:before,
.nav-side-menu li :not(collapsed) .arrow:before {
  font-family: FontAwesome;
  content: "\f078";
  display: inline-block;
  padding-left: 10px;
  padding-right: 10px;
  vertical-align: middle;
  float: right;
}
.nav-side-menu ul .active,
.nav-side-menu li .active {
  border-left: 3px solid #EAC67A;
  background-color: #3f5b65;
}
.nav-side-menu ul .sub-menu li.active,
.nav-side-menu li .sub-menu li.active {
  color: #EAC67A;
}
.nav-side-menu ul .sub-menu li.active a,
.nav-side-menu li .sub-menu li.active a {
  color: #EAC67A;
}
.nav-side-menu ul .sub-menu li,
.nav-side-menu li .sub-menu li {
  background-color: #181c20;
  border: none;
  line-height: 28px;
  border-bottom: 1px solid #23282e;
  margin-left: 0px;
}
.nav-side-menu ul .sub-menu li:hover,
.nav-side-menu li .sub-menu li:hover {
  background-color: #020203;
}
.nav-side-menu ul .sub-menu li:before,
.nav-side-menu li .sub-menu li:before {
  font-family: FontAwesome;
  display: inline-block;
  padding-left: 10px;
  padding-right: 10px;
  vertical-align: middle;
}
.nav-side-menu li {
  padding-left: 0px;
  border-left: 3px solid #233237;
}
.nav-side-menu li a {
  text-decoration: none;
  color: #e1ffff;
}
.nav-side-menu li a i {
  padding-left: 10px;
  width: 20px;
  padding-right: 20px;
}
.nav-side-menu li:hover {
  border-left: 3px solid #d19b3d;
  background-color: #4f5b69;
  -webkit-transition: all 1s ease;
  -moz-transition: all 1s ease;
  -o-transition: all 1s ease;
  -ms-transition: all 1s ease;
  transition: all 1s ease;
}
@media (max-width: 767px) {
  .nav-side-menu {
    position: relative;
    width: 100%;
    margin-bottom: 10px;
  }
  .nav-side-menu .toggle-btn {
    display: block;
    cursor: pointer;
    position: absolute;
    right: 10px;
    top: 10px;
    z-index: 10 !important;
    padding: 3px;
    background-color: #ffffff;
    color: #000;
    width: 40px;
    text-align: center;
  }
  .brand {
    text-align: left !important;
    font-size: 22px;
    padding-left: 20px;
    line-height: 50px !important;
  }
}
@media (min-width: 767px) {
  .nav-side-menu .menu-list .menu-content {
    display: block;
  }
  #main {
  	width:calc(100% - 300px);
  	float: right;
  }
}



</style>
<body>

    
	<div class="row" style="margin:0;">
	<div class="col-md-2 sidebar-left" style="padding-left:0;">
		<div class="nav-side-menu">
			<div class="brand"></div>
			<i class="fa fa-bars fa-2x toggle-btn" data-toggle="collapse" data-target="#menu-content"></i>
			<div class="menu-list" style="border-top: 1px solid #3f5b65;">
				<ul id="menu-content" class="menu-content collapse out">
					<li>
						<a href="#">
							<i class="fa fa-dashboard fa-lg"></i> Dashboard
						</a>
					</li>
					
				</ul>
			</div>
		</div>
	</div>
	
	<div id="middleContent" class="col-md-8 content-middle">
      <nav id="navbar-centro" class="navbar navbar-toggleable-md navbar-inverse fixed-top bg-rusty" style="position:sticky;z-index: 2900;height: 56px;">
		  <button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
			<span class="navbar-toggler-icon"></span>
		  </button>
		  <a class="navbar-brand" href="#">Fixed navbar</a>
		  <div class="collapse navbar-collapse" id="navbarCollapse">
			<ul class="navbar-nav mr-auto">
			  <li class="nav-item active">
				<a class="nav-link" href="#">Home <span class="sr-only">(current)</span></a>
			  </li>
			  <li class="nav-item">
				<a class="nav-link" href="#">Link</a>
			  </li>
			  <li class="nav-item">
				<a class="nav-link disabled" href="#">Disabled</a>
			  </li>
			</ul>
			<form class="form-inline mt-2 mt-md-0">
			  <input class="form-control mr-sm-2" type="text" placeholder="Jogador...">
			  <a href="#" class="btn btn-cyan my-2 my-sm-0" type="submit">Procurar</a>
			</form>
		  </div>
		  <a id="btnHideShow" onclick="hideRightBar()" class="btn btn-cyan" type="button">></a>
		</nav>
		
      <div class="jumbotron" style="background-image:url('../img/Jumbotron.png'); background-position:0px -200px;">
        <h1 class="display-3">Backstabd Matchmaking</h1>
        <p class="lead">A nova plataforma baseada em sites como FACEIT, ESEA, CEVO, entre outros para jogadores portugueses!</p>
        <p><a class="btn btn-cyan my-2 my-sm-0" href="#" role="button">Regista-te hoje!</a></p>
      </div>

      
        <div class="col-md-12">
          <h4>Subheading</h4>
          <p>Donec id elit non mi porta gravida at eget metus. Maecenas faucibus mollis interdum.</p>

          <h4>Subheading</h4>
          <p>Morbi leo risus, porta ac consectetur ac, vestibulum at eros. Cras mattis consectetur purus sit amet fermentum.</p>

          <h4>Subheading</h4>
          <p>Maecenas sed diam eget risus varius blandit sit amet non magna.</p>
        </div>
</div>

	  	<div id="sidebarDireita" class="col-md-2 sidebar-right" style="padding-left:0;padding-right:0;">
			<nav id="navbar-direita" class="navbar navbar-inverse navbar-toggleable-md bg-rusty fixed-top " style="border-left:1px solid #292b2c;position:sticky;z-index: 2900;height: 56px;">
				<div id="navbarNavDropdown" class="navbar-collapse collapse">
					<ul class="navbar-nav mr-auto">
								</ul>
							<?php
							
						if ( isset($_SESSION['username']) and isset($_SESSION['password']) ) {
							echo '
								<ul class="navbar-nav mr-auto">
								</ul>
								<ul class="navbar-nav">
								<li class="nav-item"><a class="nav-link text-center">'.$_SESSION['username'].'</a></li>
								<li class="nav-item"></li>
								<li class="nav-item"><a class="nav-link" href="index.php?page=profile"><i class="fa fa-user fa-fw"></i></a>
								</li>
								<li class="nav-item"> <a class="nav-link" href="#"><i class="fa fa-gear fa-fw"></i></a>
								</li>
								<li class="nav-item"><a class="nav-link" href="#" data-toggle="modal" data-target="#changePwModal"><i class="fa fa-gear fa-fw"></i></a>
								</li>
								<li class="nav-item"></li>
								<li class="nav-item"><a class="nav-link" href="logout.php"><i class="fa fa-sign-out fa-fw"></i></a>
								</li></ul>';
						} else {
							
							?>
							<ul class="navbar-nav mr-auto">
							<li class="nav-item">
							<a class="nav-link btn btn-black" href="#" id="navbarDropdownMenuLink" data-toggle="modal" data-target="#exampleModalLong" aria-haspopup="true" aria-expanded="false">
							  Entrar
							</a>
							</li>
							</ul>
						<?php } ?>
						
					

			</nav>
		</div>
		</div>
</div>
	  
	  
    <!-- /container -->
	
	
	
	<!-- Modal -->
<div class="modal fade" id="exampleModalLong" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true" style="z-index:9999; margin-top:200px;">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle">Entrar</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="panel-body">
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
							<input name="remember" type="checkbox" value="Lembrar Me"> Lembrar Me
						</label>
						<a href="?page=register">Registar novo utilizador</a>
					</div>
					<!-- Change this to a button or input when using this as a form -->
					<input href="#" type="submit" value="Login" class="btn btn-lg btn-cyan btn-block">
				</fieldset>
			</form>
		</div>
      </div>
      <div class="modal-footer">
      </div>
    </div>
  </div>
</div>
	
	
	
	
<script>
$( document ).ready(function() {
    $('.nav-side-menu').width($('.sidebar-left').width()+15);
    
	$('#navbar-direita').height($('#navbar-centro').height());
});

$(function() {

    var $body = $(document);
    $body.bind('scroll', function() {
        // "Disable" the horizontal scroll.
        if ($body.scrollLeft() !== 0) {
            $body.scrollLeft(0);
        }
    });

}); 

$( window ).resize(function() {
  $('.nav-side-menu').width($('.sidebar-left').width()+15);
});


var hidden=false;
function hideRightBar(){
	
	if(!hidden){
	$('#sidebarDireita').hide();
	$('#middleContent').addClass('col-md-10');
	$('#btnHideShow').text('<');
	hidden=true;
	}else{
	$('#sidebarDireita').show();
	$('#middleContent').removeClass('col-md-10');
	$('#btnHideShow').text('>');
	hidden=false;
	}
}
	
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