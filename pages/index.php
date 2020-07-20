<?php


require_once('header.php');
	require_once('includes/connection.php');
?>
<?php if($_SESSION['SESS_PROFIL']!=$ADMIN_PROFIL && $_SESSION['SESS_PROFIL']!=$SUPER_PROFIL && $_SESSION['SESS_PROFIL']!=$COMMERCIAL_PROFIL) echo "<script type='text/javascript'>document.location.replace('../pages/new_reservation.php');</script>"; ?>
        <div id="page-wrapper">
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">Dashboard</h1>
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
            <div class="row">
                
            </div>
            <!-- /.row -->
			
			<?php
				
			//Create query
				$todayFile = 'Liste des reservations '.date("Y-m-d H-i-s");
			
				$lastDate = "0";			
				$last15days = date("Y-m-d", strtotime("-15 days"));
				$qry="SELECT SUBSTR(date_ajout,1,10), Count(id) FROM reservation WHERE SUBSTR(date_ajout,1,10) > '$last15days' and statut <> '3' GROUP BY SUBSTR(date_ajout,1,10) ORDER BY date_ajout ASC ";
				$result=mysqli_query($bd, $qry);
				$chart_data4 = '';
				//Check whether the query was successful or not
				if($result) {
					if(mysqli_num_rows($result) > 0) {	
						while ($row = mysqli_fetch_array($result, MYSQLI_BOTH)) {
							$chart_data4 .= "{ period:'".$row[0]."'";
							$chart_data4 .= ", Total:".$row[1]."},";					
						}
						$chart_data4 = substr($chart_data4, 0, -1);
					}
				}
			
				$lastDate = "0";
				$infinite = false;
				$odyssee = false;
				$topkapi = false;				
				$last15days = date("Y-m-d", strtotime("-15 days"));
				$qry="SELECT SUBSTR(date_ajout,1,10), nom, Count(r.id) FROM salon s LEFT JOIN reservation r ON s.id = r.salon and r.statut <> '3' WHERE SUBSTR(date_ajout,1,10) > '$last15days' GROUP BY SUBSTR(date_ajout,1,10), nom ORDER BY date_ajout DESC ";
				$result=mysqli_query($bd, $qry);
				$chart_data = '';
				//Check whether the query was successful or not
				if($result) {
					if(mysqli_num_rows($result) > 0) {	
						while ($row = mysqli_fetch_array($result, MYSQLI_BOTH)) {
                            if ($row[0]!= '' && $row[0] != "0000-00-00")
							{
								list($year, $month, $day) = explode('[-: ]', $row[0]);
                                $row[0] = $year.'/'.$month.'/'.$day;
							}
                            else
                                $row[0]="0000-00-00";
							if ($row[0] != $lastDate)
							{
								if ($lastDate != '0')								
									$chart_data .= "},";
								$chart_data .= "{ period:'".$row[0]."'";
								switch ($row[1]) {
									case "INFINITE":
										$chart_data .= ", INFINITE:".$row[2]."";
										break;
									case "ODYSSEE":
										$chart_data .= ", ODYSSEE:".$row[2]."";
										break;
									case "TOPKAPI":
										$chart_data .= ", TOPKAPI:".$row[2]."";
										break;
								}								
								$lastDate=$row[0];							
							}
							else
							{
								switch ($row[1]) {
									case "INFINITE":
										$chart_data .= ", INFINITE:".$row[2]."";
										break;
									case "ODYSSEE":
										$chart_data .= ", ODYSSEE:".$row[2]."";
										break;
									case "TOPKAPI":
										$chart_data .= ", TOPKAPI:".$row[2]."";
										break;
								}
								
							}
						}
						$chart_data .= "}";
						//$chart_data = substr($chart_data, 0, -1);
					}
				}
				//echo "<script type='text/javascript'>alert(\"".$chart_data."\");</script>";
				
				
				$lastDate = "0";
				$lastWeek = date("Y-m-d", strtotime("-7 days"));
				$qry="SELECT SUBSTR(date_ajout,1,10), nom, Count(r.id) FROM compagnie c LEFT JOIN reservation r ON c.nom = r.compagnie and r.statut <> '3' WHERE SUBSTR(date_ajout,1,10) > '$lastWeek' and important = 1 GROUP BY SUBSTR(date_ajout,1,10), nom ORDER BY date_ajout DESC";
				$result=mysqli_query($bd, $qry);
				$chart_data2 = '';
				//Check whether the query was successful or not
				if($result) {
					if(mysqli_num_rows($result) > 0) {	
						while ($row = mysqli_fetch_array($result, MYSQLI_BOTH)) {
                            if ($row[0]!= '' && $row[0] != "0000-00-00")
							{
								list($year, $month, $day) = explode('[-: ]', $row[0]);
                                $row[0] = $year.'/'.$month.'/'.$day;
							}
                            else
                                $row[0]="0000-00-00";
							if ($row[0] != $lastDate)
							{
								if ($lastDate != '0')								
									$chart_data2 .= "},";
								$chart_data2 .= "{ period:'".$row[0]."'";
								switch ($row[1]) {
									case "AIR COTE D'IVOIRE":
										$chart_data2 .= ", 'AIR COTE IVOIRE':".$row[2]."";
										break;
									case "AIR FRANCE":
										$chart_data2 .= ", 'AIR FRANCE':".$row[2]."";
										break;
									case "BRUSSELS AIRLINES":
										$chart_data2 .= ", 'BRUSSELS AIRLINES':".$row[2]."";
										break;
									case "AIR SENEGAL":
										$chart_data2 .= ", 'AIR SENEGAL':".$row[2]."";
										break;
									case "EMIRATES":
										$chart_data2 .= ", 'EMIRATES':".$row[2]."";
										break;
									case "IBERIA":
										$chart_data2 .= ", 'IBERIA':".$row[2]."";
										break;
									case "ROYAL AIR MAROC":
										$chart_data2 .= ", 'ROYAL AIR MAROC':".$row[2]."";
										break;
									case "TAP AIR PORTUGAL":
										$chart_data2 .= ", 'TAP AIR PORTUGAL':".$row[2]."";
										break;
									case "TURKISH AIRLINES":
										$chart_data2 .= ", 'TURKISH AIRLINES':".$row[2]."";
										break;
								}								
								$lastDate=$row[0];							
							}
							else
							{
								switch ($row[1]) {
									case "AIR COTE D'IVOIRE":
										$chart_data2 .= ", 'AIR COTE IVOIRE':".$row[2]."";
										break;
									case "AIR FRANCE":
										$chart_data2 .= ", 'AIR FRANCE':".$row[2]."";
										break;
									case "BRUSSELS AIRLINES":
										$chart_data2 .= ", 'BRUSSELS AIRLINES':".$row[2]."";
										break;
									case "AIR SENEGAL":
										$chart_data2 .= ", 'AIR SENEGAL':".$row[2]."";
										break;
									case "EMIRATES":
										$chart_data2 .= ", 'EMIRATES':".$row[2]."";
										break;
									case "IBERIA":
										$chart_data2 .= ", 'IBERIA':".$row[2]."";
										break;
									case "ROYAL AIR MAROC":
										$chart_data2 .= ", 'ROYAL AIR MAROC':".$row[2]."";
										break;
									case "TAP AIR PORTUGAL":
										$chart_data2 .= ", 'TAP AIR PORTUGAL':".$row[2]."";
										break;
									case "TURKISH AIRLINES":
										$chart_data2 .= ", 'TURKISH AIRLINES':".$row[2]."";
										break;
								}
								
							}
						}
						$chart_data2 .= "}";
						//$chart_data = substr($chart_data, 0, -1);
					}
				}
				
				
				$lastMonth = date("Y-m-d", strtotime("-1 months"));
				$qry="SELECT nom, Count(r.id) FROM compagnie c LEFT JOIN reservation r ON c.nom = r.compagnie and r.statut <> '3' WHERE SUBSTR(date_ajout,1,10) > '$lastMonth' GROUP BY nom ORDER BY Count(r.id) DESC";
				$result=mysqli_query($bd, $qry);
				$chart_data3 = '';
				//Check whether the query was successful or not
				if($result) {
					if(mysqli_num_rows($result) > 0) {	
						while ($row = mysqli_fetch_array($result, MYSQLI_BOTH)) {
							$chart_data3 .= "{label: '".addslashes($row[0])."', value: ".$row[1]."},";						
						}
					}
					$chart_data3 = substr($chart_data3, 0, -1);
				}

				//echo "<script type='text/javascript'>alert(\"".$qry."\");</script>";
				//echo "<script type='text/javascript'>alert(\"".$chart_data2."\");</script>";
				
			?>
			
            <div class="row">
			<div class="col-lg-4">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <i class="fa fa-bar-chart-o fa-fw"></i>Passagers sur les 15 derniers jours
                            <div class="pull-right">
                                <div class="btn-group">
                                    <!--<button type="button" class="btn btn-default btn-xs dropdown-toggle" data-toggle="dropdown">
                                        Actions
                                        <span class="caret"></span>
                                    </button>
                                    <ul class="dropdown-menu pull-right" role="menu">
                                        <li><a href="#">Action</a>
                                        </li>
                                        <li><a href="#">Another action</a>
                                        </li>
                                        <li><a href="#">Something else here</a>
                                        </li>
                                        <li class="divider"></li>
                                        <li><a href="#">Separated link</a>
                                        </li>
                                    </ul> -->
                                </div>
                            </div>
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                            <div class="row">
                                <!-- /.col-lg-4 (nested) -->
                                <div class="col-lg-12">
                                    <div id="morris-bar-chart4"></div>
                                </div>
                                <!-- /.col-lg-8 (nested) -->
                            </div>
                            <!-- /.row -->
                        </div>
                        <!-- /.panel-body -->
                    </div>
                    <!-- /.panel -->
                </div>
                <div class="col-lg-8">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <i class="fa fa-bar-chart-o fa-fw"></i>Passagers par salon sur les 15 derniers jours
                            <div class="pull-right">
                                <div class="btn-group">
                                    <!--<button type="button" class="btn btn-default btn-xs dropdown-toggle" data-toggle="dropdown">
                                        Actions
                                        <span class="caret"></span>
                                    </button>
                                    <ul class="dropdown-menu pull-right" role="menu">
                                        <li><a href="#">Action</a>
                                        </li>
                                        <li><a href="#">Another action</a>
                                        </li>
                                        <li><a href="#">Something else here</a>
                                        </li>
                                        <li class="divider"></li>
                                        <li><a href="#">Separated link</a>
                                        </li>
                                    </ul> -->
                                </div>
                            </div>
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                            <div class="row">
                                <!-- /.col-lg-4 (nested) -->
                                <div class="col-lg-12">
                                    <div id="morris-bar-chart"></div>
                                </div>
                                <!-- /.col-lg-8 (nested) -->
                            </div>
                            <!-- /.row -->
                        </div>
                        <!-- /.panel-body -->
                    </div>
                    <!-- /.panel -->
                </div>
				
				<div class="col-lg-8">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <i class="fa fa-bar-chart-o fa-fw"></i> Passagers par compagnie sur les 7 derniers jours
                            <div class="pull-right">
                                <div class="btn-group">
                                    <!--<button type="button" class="btn btn-default btn-xs dropdown-toggle" data-toggle="dropdown">
                                        Actions
                                        <span class="caret"></span>
                                    </button>
                                    <ul class="dropdown-menu pull-right" role="menu">
                                        <li><a href="#">Action</a>
                                        </li>
                                        <li><a href="#">Another action</a>
                                        </li>
                                        <li><a href="#">Something else here</a>
                                        </li>
                                        <li class="divider"></li>
                                        <li><a href="#">Separated link</a>
                                        </li>
                                    </ul>-->
                                </div>
                            </div>
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                            <div class="row">
                                <!-- /.col-lg-4 (nested) -->
                                <div class="col-lg-12">
                                    <div id="morris-bar-chart2"></div>
                                </div>
                                <!-- /.col-lg-8 (nested) -->
                            </div>
                            <!-- /.row -->
                        </div>
                        <!-- /.panel-body -->
                    </div>
                    <!-- /.panel -->
                </div>
				
				<div class="col-lg-4">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <i class="fa fa-bar-chart-o fa-fw"></i> Passagers par compagnie sur les 30 derniers jours
                            <div class="pull-right">
                                <div class="btn-group">
                                    <!--<button type="button" class="btn btn-default btn-xs dropdown-toggle" data-toggle="dropdown">
                                        Actions
                                        <span class="caret"></span>
                                    </button>
                                    <ul class="dropdown-menu pull-right" role="menu">
                                        <li><a href="#">Action</a>
                                        </li>
                                        <li><a href="#">Another action</a>
                                        </li>
                                        <li><a href="#">Something else here</a>
                                        </li>
                                        <li class="divider"></li>
                                        <li><a href="#">Separated link</a>
                                        </li>
                                    </ul>-->
                                </div>
                            </div>
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                            <div class="row">
                                <!-- /.col-lg-4 (nested) -->
                                <div class="col-lg-12">
                                    <div id="morris-donut-chart"></div>
                                </div>
                                <!-- /.col-lg-8 (nested) -->
                            </div>
                            <!-- /.row -->
                        </div>
                        <!-- /.panel-body -->
                    </div>
                    <!-- /.panel -->
                </div>
				
                <!-- /.col-lg-8 -->
				<!--
				<div class="col-lg-3 col-md-6">
                    <div class="panel panel-primary">
                        <div class="panel-heading">
                            <div class="row">
                                <div class="col-xs-3">
                                    <i class="fa fa-tasks fa-5x"></i>
                                </div>
                                <div class="col-xs-9 text-right">
                                    <div class="huge">76</div>
                                    <div>Réservations de la journée</div>
                                </div>
                            </div>
                        </div>
                        <a href="#">
                            <div class="panel-footer">
                                <span class="pull-left">Voir le détails</span>
                                <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                <div class="clearfix"></div>
                            </div>
                        </a>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="panel panel-green">
                        <div class="panel-heading">
                            <div class="row">
                                <div class="col-xs-3">
                                    <i class="fa fa-check fa-5x"></i>
                                </div>
                                <div class="col-xs-9 text-right">
                                    <div class="huge">41</div>
                                    <div>Réservations validées</div>
                                </div>
                            </div>
                        </div>
                        <a href="#">
                            <div class="panel-footer">
                                <span class="pull-left">Voir le détails</span>
                                <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                <div class="clearfix"></div>
                            </div>
                        </a>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="panel panel-yellow">
                        <div class="panel-heading">
                            <div class="row">
                                <div class="col-xs-3">
                                    <i class="fa fa-shopping-cart fa-5x"></i>
                                </div>
                                <div class="col-xs-9 text-right">
                                    <div class="huge">27</div>
                                    <div>Réservations non validées</div>
                                </div>
                            </div>
                        </div>
                        <a href="#">
                            <div class="panel-footer">
                                <span class="pull-left">Voir le détails</span>
                                <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                <div class="clearfix"></div>
                            </div>
                        </a>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="panel panel-red">
                        <div class="panel-heading">
                            <div class="row">
                                <div class="col-xs-3">
                                    <i class="fa fa-times fa-5x"></i>
                                </div>
                                <div class="col-xs-9 text-right">
                                    <div class="huge">8</div>
                                    <div>Réservations annulées</div>
                                </div>
                            </div>
                        </div>
                        <a href="#">
                            <div class="panel-footer">
                                <span class="pull-left">Voir le détails</span>
                                <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                <div class="clearfix"></div>
                            </div>
                        </a>
                    </div>
                </div>
				
                <div class="col-lg-6">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <i class="fa fa-bell fa-fw"></i> Dernières réservations validées
                        </div>
                        <div class="panel-body">
                            <table width="100%" style="font-size: 14px"; class="table table-striped table-bordered table-hover" id="dataTables-example">
                                <thead>
                                    <tr>
                                        <th>Date</th>
                                        <th>Nom</th>
                                        <th>Prénom</th>
                                        <th>Vol</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr class="odd gradeX">
                                        <td>18/12/2017 19:45</td>
                                        <td>Alban</td>
                                        <td>Frédéric</td>
                                        <td>Air France</td>
                                    </tr>
                                    <tr class="even gradeC">
                                        <td>18/12/2017 19:40</td>
                                        <td>Ndiaye</td>
                                        <td>Ousmane</td>
                                        <td>Corsair</td>
                                    </tr>
                                    <tr class="odd gradeA">
                                        <td>18/12/2017 19:31</td>
                                        <td>Fall</td>
                                        <td>Ismael</td>
                                        <td>Air France</td>
                                    </tr>									
                                    <tr class="even gradeC">
                                        <td>18/12/2017 19:23</td>
                                        <td>Ndiaye</td>
                                        <td>Léon</td>
                                        <td>Corsair</td>
                                    </tr>
									<tr class="odd gradeX">
                                        <td>18/12/2017 18:45</td>
                                        <td>Alban</td>
                                        <td>Frédéric</td>
                                        <td>Air France</td>
                                    </tr>
                                    <tr class="even gradeC">
                                        <td>18/12/2017 18:40</td>
                                        <td>Ndiaye</td>
                                        <td>Ousmane</td>
                                        <td>Corsair</td>
                                    </tr>
                                    <tr class="odd gradeA">
                                        <td>18/12/2017 17:31</td>
                                        <td>Fall</td>
                                        <td>Ismael</td>
                                        <td>Air France</td>
                                    </tr>									
                                    <tr class="even gradeC">
                                        <td>18/12/2017 17:23</td>
                                        <td>Ndiaye</td>
                                        <td>Léon</td>
                                        <td>Corsair</td>
                                    </tr>
									<tr class="odd gradeX">
                                        <td>18/12/2017 16:45</td>
                                        <td>Alban</td>
                                        <td>Frédéric</td>
                                        <td>Air France</td>
                                    </tr>
                                    <tr class="even gradeC">
                                        <td>18/12/2017 16:40</td>
                                        <td>Ndiaye</td>
                                        <td>Ousmane</td>
                                        <td>Corsair</td>
                                    </tr>
                                    <tr class="odd gradeA">
                                        <td>18/12/2017 16:31</td>
                                        <td>Fall</td>
                                        <td>Ismael</td>
                                        <td>Air France</td>
                                    </tr>									
                                    <tr class="even gradeC">
                                        <td>18/12/2017 16:23</td>
                                        <td>Ndiaye</td>
                                        <td>Léon</td>
                                        <td>Corsair</td>
                                    </tr>
                                </tbody>
                            </table>
							<a class="btn btn-default btn-lg btn-block" target="_blank" href="#">Voir la list complète</a>                            
                        </div>
                    </div>
					
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <i class="fa fa-bar-chart-o fa-fw"></i> Effectifs des salons
                        </div>
                        <div class="panel-body">
                            <div id="morris-donut-chart"></div>
                            <a href="#" class="btn btn-default btn-block">View Details</a>
                        </div>
                        
                    </div>
					-->
                    <!-- /.panel -->                    
                </div>
                <!-- /.col-lg-4 -->
            </div>
            <!-- /.row -->
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

    <!-- Morris Charts JavaScript -->
    <script src="../vendor/raphael/raphael.min.js"></script>
    <script src="../vendor/morrisjs/morris.min.js"></script>
    <!--<script src="../data/morris-data.js"></script>
	
	<!-- DataTables JavaScript -->
    <script src="../vendor/datatables/js/jquery.dataTables.min.js"></script>
    <script src="../vendor/datatables-plugins/dataTables.bootstrap.min.js"></script>
    <script src="../vendor/datatables-responsive/dataTables.responsive.js"></script>

    <!-- Custom Theme JavaScript -->
    <script src="../dist/js/sb-admin-2.js"></script>
	
    <script>
    $(document).ready(function() {
        $('#dataTables-example').DataTable({
            responsive: true
        });
		
		
		 // Morris.Area({
			// element: 'morris-area-chart',
			// data: [<?php echo $chart_data; ?>],
			// xkey: 'period',
			// ykeys: ['INFINITE', 'ODYSSEE', 'TOPKAPI'],
			// labels: ['INFINITE', 'ODYSSEE', 'TOPKAPI'],
			// pointSize: 2,
			// hideHover: 'auto',
			// resize: true
		// });
		
		Morris.Line({
			element: 'morris-bar-chart4',
			data: [<?php echo $chart_data4; ?>],
			xkey: 'period',
			ykeys: ['Total'],
			labels: ['Total'],
			hideHover: 'auto',
			resize: true
		});
		Morris.Bar({
			element: 'morris-bar-chart',
			data: [<?php echo $chart_data; ?>],
			xkey: 'period',
			ykeys: ['INFINITE', 'ODYSSEE', 'TOPKAPI'],
			labels: ['INFINITE', 'ODYSSEE', 'TOPKAPI'],
			hideHover: 'auto',
			resize: true
		});
		
		Morris.Bar({
			element: 'morris-bar-chart2',
			data: [<?php echo $chart_data2; ?>],
			xkey: 'period',
			ykeys: ['AIR COTE IVOIRE', 'AIR FRANCE', 'BRUSSELS AIRLINES', 'AIR SENEGAL', 'EMIRATES', 'IBERIA', 'ROYAL AIR MAROC', 'TAP AIR PORTUGAL', 'TURKISH AIRLINES'],
			labels: ['AIR COTE IVOIRE', 'AIR FRANCE', 'BRUSSELS AIRLINES', 'AIR SENEGAL', 'EMIRATES', 'IBERIA', 'ROYAL AIR MAROC', 'TAP AIR PORTUGAL', 'TURKISH AIRLINES'],
			hideHover: 'auto',
			resize: true
		});
		
		Morris.Donut({
        element: 'morris-donut-chart',
        data: [<?php echo $chart_data3; ?>],
        resize: true
    });
    });
    </script>

</body>

</html>
