<?php
	Include "../conf/conn.php";

session_start();
	
 
//Caso o usuário esteja autenticado, redireciona
if ( isset($_SESSION['username']) and isset($_SESSION['password']) ) {
 
    //Redireciona para a página de autenticação
    header('location:index.php');
}
?>
        <!-- Page Content -->
					<h1 class="alert" style="text-align:center;">Registo</h1>
                    <div class="col-md-12 alert " style="margin-top:20px;">
							<form method="POST" action="register_proc.php" id="formregister" name="formregister" role="form">
								<div class="form-group">
									<label>STEAMID*</label>
									<?php if(!isset($_SESSION['steamid64'])){ ?>
									<a href="?getSteamId"><img  src="http://steamcommunity-a.akamaihd.net/public/images/signinthroughsteam/sits_01.png"></a>
									<?php } else {echo $_SESSION['steamid64'];} ?>
									<input class="form-control" value="<?php echo $_SESSION['steamid64']; ?>" name="steamid64" type="hidden">
                                </div>
								<div class="form-group">
									<label>Username*</label>
									<input class="form-control" placeholder="Username" name="username" type="text">
                                </div>
								<div class="form-group">
									<label>E-Mail*</label>
									<input class="form-control" placeholder="E-Mail" name="email" type="email">
                                </div>
								<div class="form-group">
									<label>Password*</label>
									<input class="form-control" placeholder="Password" name="password" type="password">
                                </div>
								<div class="form-group">
									<label>Re-Password*</label>
									<input class="form-control" placeholder="Re-Password" name="repassword" type="password">
                                </div>
								</br>
								<input type="submit" value="Registar" class="btn btn-default btn-lg">
							</form>
                    </div>
                    <!-- /.col-lg-12 -->
        <!-- /#page-wrapper -->

   