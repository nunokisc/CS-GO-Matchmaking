<?php
	Include "../conf/conn.php";
	session_start();
	
	$query = "SELECT id,name FROM seasons";
	$rSeasons = $conn->query($query);
	$query = "SELECT id,name FROM teams";
	$rTeams = $conn->query($query);
	$query = "SELECT id,ip,hostname FROM servers";
	$rServers = $conn->query($query);
	
 
//Caso o usuário não esteja autenticado, limpa os dados e redireciona
// if ( !isset($_SESSION['username']) and !isset($_SESSION['password']) ) {
    // //Destrói
    // session_destroy();
 
    // //Limpa
    // unset ($_SESSION['username']);
    // unset ($_SESSION['password']);
     
    // //Redireciona para a página de autenticação
    // header('location:login.php');
// }
?>
<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>SB Admin 2 - Bootstrap Admin Theme</title>

    <!-- Bootstrap Core CSS -->
    <link href="../vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

    <!-- MetisMenu CSS -->
    <link href="../vendor/metisMenu/metisMenu.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="../dist/css/sb-admin-2.css" rel="stylesheet">

    <!-- Custom Fonts -->
    <link href="../vendor/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->

</head>

<body>

    <div id="wrapper">

        <!-- Navigation -->
        <nav class="navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 0">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="index.php">Matchmaking Backstabd</a>
            </div>
            <!-- /.navbar-header -->

            <ul class="nav navbar-top-links navbar-right">
                <li class="dropdown">
                    <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                        <i class="fa fa-envelope fa-fw"></i> <i class="fa fa-caret-down"></i>
                    </a>
                    <ul class="dropdown-menu dropdown-messages">
                        <li>
                            <a href="#">
                                <div>
                                    <strong>John Smith</strong>
                                    <span class="pull-right text-muted">
                                        <em>Yesterday</em>
                                    </span>
                                </div>
                                <div>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Pellentesque eleifend...</div>
                            </a>
                        </li>
                        <li class="divider"></li>
                        <li>
                            <a href="#">
                                <div>
                                    <strong>John Smith</strong>
                                    <span class="pull-right text-muted">
                                        <em>Yesterday</em>
                                    </span>
                                </div>
                                <div>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Pellentesque eleifend...</div>
                            </a>
                        </li>
                        <li class="divider"></li>
                        <li>
                            <a href="#">
                                <div>
                                    <strong>John Smith</strong>
                                    <span class="pull-right text-muted">
                                        <em>Yesterday</em>
                                    </span>
                                </div>
                                <div>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Pellentesque eleifend...</div>
                            </a>
                        </li>
                        <li class="divider"></li>
                        <li>
                            <a class="text-center" href="#">
                                <strong>Read All Messages</strong>
                                <i class="fa fa-angle-right"></i>
                            </a>
                        </li>
                    </ul>
                    <!-- /.dropdown-messages -->
                </li>
                <!-- /.dropdown -->
                <li class="dropdown">
                    <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                        <i class="fa fa-tasks fa-fw"></i> <i class="fa fa-caret-down"></i>
                    </a>
                    <ul class="dropdown-menu dropdown-tasks">
                        <li>
                            <a href="#">
                                <div>
                                    <p>
                                        <strong>Task 1</strong>
                                        <span class="pull-right text-muted">40% Complete</span>
                                    </p>
                                    <div class="progress progress-striped active">
                                        <div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="40" aria-valuemin="0" aria-valuemax="100" style="width: 40%">
                                            <span class="sr-only">40% Complete (success)</span>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </li>
                        <li class="divider"></li>
                        <li>
                            <a href="#">
                                <div>
                                    <p>
                                        <strong>Task 2</strong>
                                        <span class="pull-right text-muted">20% Complete</span>
                                    </p>
                                    <div class="progress progress-striped active">
                                        <div class="progress-bar progress-bar-info" role="progressbar" aria-valuenow="20" aria-valuemin="0" aria-valuemax="100" style="width: 20%">
                                            <span class="sr-only">20% Complete</span>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </li>
                        <li class="divider"></li>
                        <li>
                            <a href="#">
                                <div>
                                    <p>
                                        <strong>Task 3</strong>
                                        <span class="pull-right text-muted">60% Complete</span>
                                    </p>
                                    <div class="progress progress-striped active">
                                        <div class="progress-bar progress-bar-warning" role="progressbar" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100" style="width: 60%">
                                            <span class="sr-only">60% Complete (warning)</span>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </li>
                        <li class="divider"></li>
                        <li>
                            <a href="#">
                                <div>
                                    <p>
                                        <strong>Task 4</strong>
                                        <span class="pull-right text-muted">80% Complete</span>
                                    </p>
                                    <div class="progress progress-striped active">
                                        <div class="progress-bar progress-bar-danger" role="progressbar" aria-valuenow="80" aria-valuemin="0" aria-valuemax="100" style="width: 80%">
                                            <span class="sr-only">80% Complete (danger)</span>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </li>
                        <li class="divider"></li>
                        <li>
                            <a class="text-center" href="#">
                                <strong>See All Tasks</strong>
                                <i class="fa fa-angle-right"></i>
                            </a>
                        </li>
                    </ul>
                    <!-- /.dropdown-tasks -->
                </li>
                <!-- /.dropdown -->
                <li class="dropdown">
                    <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                        <i class="fa fa-bell fa-fw"></i> <i class="fa fa-caret-down"></i>
                    </a>
                    <ul class="dropdown-menu dropdown-alerts">
                        <li>
                            <a href="#">
                                <div>
                                    <i class="fa fa-comment fa-fw"></i> New Comment
                                    <span class="pull-right text-muted small">4 minutes ago</span>
                                </div>
                            </a>
                        </li>
                        <li class="divider"></li>
                        <li>
                            <a href="#">
                                <div>
                                    <i class="fa fa-twitter fa-fw"></i> 3 New Followers
                                    <span class="pull-right text-muted small">12 minutes ago</span>
                                </div>
                            </a>
                        </li>
                        <li class="divider"></li>
                        <li>
                            <a href="#">
                                <div>
                                    <i class="fa fa-envelope fa-fw"></i> Message Sent
                                    <span class="pull-right text-muted small">4 minutes ago</span>
                                </div>
                            </a>
                        </li>
                        <li class="divider"></li>
                        <li>
                            <a href="#">
                                <div>
                                    <i class="fa fa-tasks fa-fw"></i> New Task
                                    <span class="pull-right text-muted small">4 minutes ago</span>
                                </div>
                            </a>
                        </li>
                        <li class="divider"></li>
                        <li>
                            <a href="#">
                                <div>
                                    <i class="fa fa-upload fa-fw"></i> Server Rebooted
                                    <span class="pull-right text-muted small">4 minutes ago</span>
                                </div>
                            </a>
                        </li>
                        <li class="divider"></li>
                        <li>
                            <a class="text-center" href="#">
                                <strong>See All Alerts</strong>
                                <i class="fa fa-angle-right"></i>
                            </a>
                        </li>
                    </ul>
                    <!-- /.dropdown-alerts -->
                </li>
                <!-- /.dropdown -->
                <li class="dropdown">
                    <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                        <i class="fa fa-user fa-fw"></i> <i class="fa fa-caret-down"></i>
                    </a>
                    <ul class="dropdown-menu dropdown-user">
                        <li><a href="#"><i class="fa fa-user fa-fw"></i> User Profile</a>
                        </li>
                        <li><a href="#"><i class="fa fa-gear fa-fw"></i> Settings</a>
                        </li>
                        <li class="divider"></li>
                        <li><a href="login.html"><i class="fa fa-sign-out fa-fw"></i> Logout</a>
                        </li>
                    </ul>
                    <!-- /.dropdown-user -->
                </li>
                <!-- /.dropdown -->
            </ul>
            <!-- /.navbar-top-links -->

            <div class="navbar-default sidebar" role="navigation">
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
                        <li>
                            <a href="index.html"><i class="fa fa-dashboard fa-fw"></i> Dashboard</a>
                        </li>
                        <li>
                            <a href="#"><i class="fa fa-bar-chart-o fa-fw"></i> Charts<span class="fa arrow"></span></a>
                            <ul class="nav nav-second-level">
                                <li>
                                    <a href="flot.html">Flot Charts</a>
                                </li>
                                <li>
                                    <a href="morris.html">Morris.js Charts</a>
                                </li>
                            </ul>
                            <!-- /.nav-second-level -->
                        </li>
                        <li>
                            <a href="tables.html"><i class="fa fa-table fa-fw"></i> Tables</a>
                        </li>
                        <li>
                            <a href="forms.html"><i class="fa fa-edit fa-fw"></i> Forms</a>
                        </li>
                        <li>
                            <a href="#"><i class="fa fa-wrench fa-fw"></i> UI Elements<span class="fa arrow"></span></a>
                            <ul class="nav nav-second-level">
                                <li>
                                    <a href="panels-wells.html">Panels and Wells</a>
                                </li>
                                <li>
                                    <a href="buttons.html">Buttons</a>
                                </li>
                                <li>
                                    <a href="notifications.html">Notifications</a>
                                </li>
                                <li>
                                    <a href="typography.html">Typography</a>
                                </li>
                                <li>
                                    <a href="icons.html"> Icons</a>
                                </li>
                                <li>
                                    <a href="grid.html">Grid</a>
                                </li>
                            </ul>
                            <!-- /.nav-second-level -->
                        </li>
                        <li>
                            <a href="#"><i class="fa fa-sitemap fa-fw"></i> Multi-Level Dropdown<span class="fa arrow"></span></a>
                            <ul class="nav nav-second-level">
                                <li>
                                    <a href="#">Second Level Item</a>
                                </li>
                                <li>
                                    <a href="#">Second Level Item</a>
                                </li>
                                <li>
                                    <a href="#">Third Level <span class="fa arrow"></span></a>
                                    <ul class="nav nav-third-level">
                                        <li>
                                            <a href="#">Third Level Item</a>
                                        </li>
                                        <li>
                                            <a href="#">Third Level Item</a>
                                        </li>
                                        <li>
                                            <a href="#">Third Level Item</a>
                                        </li>
                                        <li>
                                            <a href="#">Third Level Item</a>
                                        </li>
                                    </ul>
                                    <!-- /.nav-third-level -->
                                </li>
                            </ul>
                            <!-- /.nav-second-level -->
                        </li>
                        <li class="active">
                            <a href="#"><i class="fa fa-files-o fa-fw"></i> Sample Pages<span class="fa arrow"></span></a>
                            <ul class="nav nav-second-level">
                                <li>
                                    <a class="active" href="blank.html">Blank Page</a>
                                </li>
                                <li>
                                    <a href="login.html">Login Page</a>
                                </li>
                            </ul>
                            <!-- /.nav-second-level -->
                        </li>
                    </ul>
                </div>
                <!-- /.sidebar-collapse -->
            </div>
            <!-- /.navbar-static-side -->
        </nav>

        <!-- Page Content -->
        <div id="page-wrapper">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-10">
                        <h1 class="page-header">Criar nova Partida</h1>
						<form id="createMatchForm" class="form-horizontal" role="form">
							<div class="form-group">
								<label class="col-md-2 control-label">Season</label>
								<div class="col-md-2">
									<select name="season" class="form-control">
										<option value="NULL"></option>
										<?php
											while($s = mysqli_fetch_array($rSeasons))
											echo '<option value="'.$s["id"].'">'.$s["nome"].'</option>';
										?>
									</select>
								</div>
							</div>
							<div class="form-group">
								<label class="col-md-2 control-label">Team A</label>
								<div class="col-md-2">
									<select id="sTeamA" name="teamA" class="form-control">
										<option value="NULL"></option>
										<?php
											while($t = mysqli_fetch_array($rTeams)){
											echo '<option value="'.$t["id"].'">'.$t["name"].'</option>';
										?>
									</select>
								</div>
								<div id="teamAName" class="col-md-2">
									<input name="teamAName" class="form-control">
								</div>
								<div id="teamAFlag" class="col-md-2">
									<select name="teamAFlag"  class="form-control">
										<option value="NULL" selected="selected"></option>
										<option value="PT">PORTUGAL</option>
									</select>
								</div>	
							</div>
							<div class="form-group">
								<label class="col-md-2 control-label">Team B</label>
								<div class="col-md-2">
									<select id="sTeamB" name="teamB" class="form-control">
										<option value="NULL"></option>
										<?php
											echo '<option value="'.$t["id"].'">'.$t["name"].'</option>';
											}
										?>
									</select>
								</div>
								<div id="teamBName" class="col-md-2">
									<input name="teamBName" class="form-control">
								</div>
								<div id="teamBFlag" class="col-md-2">
									<select name="teamBFlag" class="form-control">
										<option value="NULL" selected="selected"></option>
										<option value="PT">PORTUGAL</option>
									</select>
									</select>
								</div>
							</div>
							<div class="form-group">
								<label class="col-md-2 control-label">Config</label>
								<div class="col-md-2">
									<input name="config" value="rules" class="form-control">
								</div>
							</div>
							<div class="form-group">
								<label class="col-md-2 control-label">Password</label>
								<div class="col-md-2">
									<input name="password" class="form-control">
								</div>
							</div>
							<div class="form-group">
								<label class="col-md-2 control-label">Max Rounds (MR)</label>
								<div class="col-md-2">
									<select name="maxRounds" class="form-control">
										<option value="15">MR15</option>
										<option value="12">MR12</option>
										<option value="9">MR9</option>
										<option value="5">MR5</option>
										<option value="3">MR3</option>
									</select>
								</div>
							</div>
							<div class="form-group">
								<label class="col-md-2 control-label">Play all Rounds</label>
								<div class="col-md-2">
									<input name="playAllRounds" type="checkbox" value="1">
								</div>
							</div>
							<div class="form-group">
								<label class="col-md-2 control-label">Streamer Ready</label>
								<div class="col-md-2">
									<input name="StreamerReady" type="checkbox" value="1">
								</div>
							</div>
							<div class="form-group">
								<label class="col-md-2 control-label">Knife Round</label>
								<div class="col-md-2">
									<input name="knifeRound" type="checkbox" checked="checked" value="1">
								</div>
							</div>
							<div class="form-group">
								<label class="col-md-2 control-label">Overtime</label>
								<div class="col-md-2">
									<input id="overtime" name="overtime" type="checkbox" value="1">
								</div>
							</div>
							<div id="overtimeStartmoney" class="form-group alert alert-info">
								<label class="col-md-4 control-label">Overtime : Startmoney</label>
								<div class="col-md-2">
									<input name="overtimeStartmoney" class="form-control">
								</div>
							</div>
							<div id="overtimeMaxRounds" class="form-group alert alert-info">
								<label class="col-md-4 control-label">Overtime : Max Rounds</label>
								<div class="col-md-2">
									<input name="overtimeMaxRounds" class="form-control">
								</div>
							</div>
							<div class="form-group">
								<label class="col-md-2 control-label">Autostart Match</label>
								<div class="col-md-2">
									<input name="AutostartMatch" type="checkbox" value="1">
								</div>
							</div>
							<div class="form-group">
								<label class="col-md-2 control-label">Map Selection mode</label>
								<div class="col-md-2">
									<select name="mapSelectionMode" class="form-control">
										<option value="normal">BO1</option>
										<option value="bo3_modeb">BO3</option>
									</select>
								</div>
							</div>
							<div class="form-group">
								<label class="col-md-2 control-label">Map</label>
								<div class="col-md-2">
									<select name="map" class="form-control">
										<option value="de_dust2">de_dust2</option>
										<option value="de_nuke">de_nuke</option>
										<option value="de_inferno">de_inferno</option>
										<option value="de_train">de_train</option>
										<option value="de_mirage">de_mirage</option>
										<option value="de_season">de_season</option>
										<option value="de_cache">de_cache</option>
										<option value="de_overpass">de_overpass</option>
										<option value="de_cbble">de_cbble</option>
										<option value="de_tuscan">de_tuscan</option>
										<option value="tba">Choose by Mapveto</option>
									</select>
								</div>
							</div>
							<div class="form-group">
								<label class="col-md-2 control-label">Server</label>
								<div class="col-md-2">
									<select name="server" class="form-control">
										<?php
											while($se = mysqli_fetch_array($rServers))
											echo '<option value="'.$se["id"].'">'.$se["hostname"].' - '.$se["ip"].'</option>';
										?>
									</select>
								</div>
							</div>
							<div class="form-group">
								<label class="col-md-2 control-label">First Side</label>
								<div class="col-md-2">
									<select name="firstSide" class="form-control">
										<option value="ct">Team A CT / Team B T</option>
										<option value="t">Team A T / Team B CT</option>
										<option value="random">Random</option>
										<option>4</option>
										<option>5</option>
									</select>
								</div>
							</div>
							<div class="form-group">
								<div class="col-md-8"></div>
								<div class="col-md-2">
									<input type="submit" value="Login" class="btn btn-primary btn-lg">
								</div>
							</div>
						</form>
                    </div>
                    <!-- /.col-lg-12 -->
                </div>
                <!-- /.row -->
            </div>
            <!-- /.container-fluid -->
        </div>
        <!-- /#page-wrapper -->

    </div>
    <!-- /#wrapper -->

    <!-- jQuery -->
    <script src="../vendor/jquery/jquery.min.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="../vendor/bootstrap/js/bootstrap.min.js"></script>

    <!-- Metis Menu Plugin JavaScript -->
    <script src="../vendor/metisMenu/metisMenu.min.js"></script>

    <!-- Custom Theme JavaScript -->
    <script src="../dist/js/sb-admin-2.js"></script>
	
	<script>
	
		var state = 0;
		$("#createMatchForm").submit(function(e) {

			var url = ".php"; // the script where you handle the form input.

			$.ajax({
				   type: "POST",
				   url: url,
				   data: $("#createMatchForm").serialize(), // serializes the form's elements.
				   success: function(data)
				   {
					   alert(data); // show response from the php script.
				   }
				 });

			e.preventDefault(); // avoid to execute the actual submit of the form.
			console.log($("#createMatchForm").serialize());
		});
		
		$('#sTeamA').on('change', function() {
			if (this.value == "NULL"){
				$("#teamAName").show();
				$("#teamAFlag").show();
			} else{
				$("#teamAName").hide();
				$("#teamAFlag").hide();
			}
		})
		$('#sTeamB').on('change', function() {
			if (this.value == "NULL"){
				$("#teamBName").show();
				$("#teamBFlag").show();
			} else{
				$("#teamBName").hide();
				$("#teamBFlag").hide();
			}
		})
		$('#overtime').on('change', function() {
			
			if (state == 0){
				$("#overtimeStartmoney").show();
				$("#overtimeMaxRounds").show();
				state = 1;
			} else {
				$("#overtimeStartmoney").hide();
				$("#overtimeMaxRounds").hide();
				state = 0;
			}
		})
	</script>

</body>

</html>
