<?php
	//Start session
	session_start();	
	//Unset the variables stored in session
	unset($_SESSION['SESS_MEMBER_ID']);
	unset($_SESSION['SESS_FIRST_NAME']);
	unset($_SESSION['SESS_LAST_NAME']);
?>

<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>SGI - INFINITE</title>
	<link rel="shortcut icon" href="../img/favicon.ico">

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

    <div class="container">
        <div class="row">
            <div class="col-md-4">
                <div class="login-panel panel panel-info">
                    <div class="panel-heading" style="text-align:center">
                        <h3 class="panel-title"><b>Connectez vous</b></h3>
                    </div>
                    <div class="panel-body">
						<img style="width: 100%;padding-bottom: 17px;" src="../img/logo.png" />
                        <form name="loginform" action="includes/login_exec.php" method="post">
                            <fieldset style="text-align:center">
                                <div class="form-group">
                                    <input class="form-control" placeholder="Login" name="username" type="text" autofocus>
                                </div>
                                <div class="form-group">
                                    <input class="form-control" placeholder="Mot de passe" name="password" type="password" value="">
                                </div>
                                <div class="checkbox">
                                    <label>
                                        <input name="remember" type="checkbox" value="Remember Me">Se souvenir de moi
                                    </label>
                                </div>
                                <!-- Change this to a button or input when using this as a form -->
                                <button type="submit" class="btn btn-warning">Se connecter</button>
								
								<!--the code bellow is used to display the message of the input validation-->
								 <?php
									if( isset($_SESSION['ERRMSG_ARR']) && is_array($_SESSION['ERRMSG_ARR']) && count($_SESSION['ERRMSG_ARR']) >0 ) {
									foreach($_SESSION['ERRMSG_ARR'] as $msg) {
										echo '<div class="alert alert-danger" style="margin-top: 20px;">',$msg,'</div>'; 
										}
									unset($_SESSION['ERRMSG_ARR']);
									}
								?>
		
                            </fieldset>
                        </form>
                    </div>
                </div>
            </div>
			<div class="col-md-8">
				<div class="panel panel-info" style="height: 400px;margin-top:12%;background: url(../img/lounge.jpg);background-size: cover;">
					<div class="panel-heading" style="text-align:center">
						<h3 class="panel-title"><b>Bienvenue dans le Système de Gestion Interne des Salons (SGI)</b></h3>
					</div>					
				</div>
			</div>
        </div>
		<div class="row">
            <div class="col-md-4">
				<button type="button" class="btn btn-outline btn-warning btn-lg btn-block">INFINITE</button>
			</div>
			<div class="col-md-4">
				<button type="button" class="btn btn-outline btn-primary btn-lg btn-block">ODYSSEE</button>
			</div>
			<div class="col-md-4">
				<button type="button" class="btn btn-outline btn-danger btn-lg btn-block">TOPKAPI</button>
			</div>
        </div>
    </div>

    <!-- jQuery -->
    <script src="../vendor/jquery/jquery.min.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="../vendor/bootstrap/js/bootstrap.min.js"></script>

    <!-- Metis Menu Plugin JavaScript -->
    <script src="../vendor/metisMenu/metisMenu.min.js"></script>

    <!-- Custom Theme JavaScript -->
    <script src="../dist/js/sb-admin-2.js"></script>

</body>

</html>
