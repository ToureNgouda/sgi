<?php
    //Start session
	session_start();
?>

<html lang="fr">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">

    <title>SGI - INIFINITE</title>
	
	
    <link rel="shortcut icon" href="../img/favicon.ico">

    <!-- Bootstrap Core CSS -->
    <link href="../vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
	
	    <!-- DataTables CSS -->
    <link href="../vendor/datatables-plugins/dataTables.bootstrap.css" rel="stylesheet">
    <link href="../vendor/datatables/css/buttons.dataTables.min.css" rel="stylesheet">
    <link href="../vendor/datatables/css/jquery.dataTables.min.css" rel="stylesheet">
	
	  <!-- DataTables Responsive CSS -->
    <link href="../vendor/datatables-responsive/dataTables.responsive.css" rel="stylesheet">

    <!-- MetisMenu CSS -->
    <link href="../vendor/metisMenu/metisMenu.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="../dist/css/sb-admin-2.css" rel="stylesheet">

    <!-- Morris Charts CSS -->
    <link href="../vendor/morrisjs/morris.css" rel="stylesheet">
	
	
    
	<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">

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

<?php
   

	require_once('includes/auth.php');
	include_once('../dist/css/'.$_SESSION['SESS_SALON'].'.css');
	
	$ADMIN_PROFIL = '1';
	$RECEP_PROFIL = '2';
    $SUPER_PROFIL = '3';
    $COMMERCIAL_PROFIL = '4';
	date_default_timezone_set("UTC");
?>

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
				<a class="navbar-brand-first" >SALON <?php echo $_SESSION['SESS_SALON']?></a>
				<a class="navbar-brand">Bienvenue <?php echo $_SESSION['SESS_FIRST_NAME']." ".$_SESSION['SESS_LAST_NAME'] ?> - SYSTEME DE GESTION INTERNE DES SALONS</a>
            </div>
            <!-- /.navbar-header -->
			
            <ul class="nav navbar-top-links navbar-right">
                <!-- /.dropdown -->
                <li class="dropdown">
                    <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                        <i class="fa fa-user fa-fw"></i> <i class="fa fa-caret-down"></i>
                    </a>
                    <ul class="dropdown-menu dropdown-user">
                        <li><a href="/pages/details_users.php"><i class="fa fa-user fa-fw"></i> Profil Utilisateur</a>
                        </li>
                        <li class="divider"></li>
                        <li><a href="/pages/includes/deconnection.php"><i class="fa fa-sign-out fa-fw"></i> Déconnexion</a>
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
                                <input type="text" class="form-control" placeholder="Rechercher...">
                                <span class="input-group-btn">
                                <button class="btn btn-default" type="button" style="padding: 9px;">
                                    <i class="fa fa-search"></i>
                                </button>
                            </span>
                            </div>
                            <!-- /input-group -->
                        </li>
						<li>							
							<img style="width: 100%;" src="../img/INFINITE-LOGO.png" />
						</li>
                        <?php if($_SESSION['SESS_PROFIL']==$ADMIN_PROFIL || $_SESSION['SESS_PROFIL']==$SUPER_PROFIL || $_SESSION['SESS_PROFIL']==$COMMERCIAL_PROFIL) { ?>
                        <li>
                            <a href="index.php"><i class="fa fa-dashboard fa-fw"></i> Dashboard</a>
                        </li>
                        <?php } ?>

                        <li>
                            <a href="#"><i class="fa fa-bar-chart-o fa-fw"></i> Réservations<span class="fa arrow"></span></a>
                            <ul class="nav nav-second-level">                                
                                <li>
                                    <a href="/pages/new_reservation.php">Nouvelle réservation</a>
                                </li>
								<li>
                                    <a href="/pages/reservations.php">Réservations sur 30 jours</a>
                                </li>
								<li>
                                    <a href="/pages/all_reservations.php">Toutes les réservations</a>
                                </li>
								<li>
                                    <a href="/pages/reservations_annule.php">Réservations annulées</a>
                                </li>
                            </ul>
                            <!-- /.nav-second-level -->
                        </li>
                       

						<li>
                            <a href="/pages/reservations_agence.php"><i class="fa fa-bar-chart-o fa-fw"></i>Réservations Agences<span class="fa arrow"></span></a>                            
                            <!-- /.nav-second-level -->
                        </li>
						<?php if($_SESSION['SESS_PROFIL']==$ADMIN_PROFIL || $_SESSION['SESS_PROFIL']==$COMMERCIAL_PROFIL) { ?>
						<li>
                            <a href="#"><i class="fa fa-user fa-fw"></i> Utilisateurs<span class="fa arrow"></span></a>
                            <ul class="nav nav-second-level">                                
                                <li>
                                    <a href="/pages/new_user.php">Nouvel utilisateur</a>
                                </li>
								<li>
                                    <a href="/pages/users.php">Liste des utilisateurs</a>
                                </li>
                            </ul>
                            <!-- /.nav-second-level -->
                        </li>
                        <?php } ?>
                        <?php if($_SESSION['SESS_PROFIL']==$COMMERCIAL_PROFIL) { ?>
						<li>
                            <a href="/pages/parametres.php"><i class="fa fa-cog fa-fw"></i> Parametres</a>
                            
                            <!-- /.nav-second-level -->
                        </li>
                        <li>
                            <a href="/pages/facture.php"><i class="fa fa-list-alt fa-fw"></i> Factures</a>
                            
                            <!-- /.nav-second-level -->
                        </li>
						<?php } ?>
                    </ul>
                </div>
                <!-- /.sidebar-collapse -->
            </div>
            <!-- /.navbar-static-side -->
        </nav>


