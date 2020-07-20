<?php
	require_once('header.php');
	//Include database connection details
	require_once('includes/connection_agence.php');
?>
		<!-- Modal -->
		  <div class="modal fade" id="updateModal" role="dialog">
			<div class="modal-dialog">
			
			  <!-- Modal content-->
			  <div class="modal-content">
				<div class="modal-header">
				  <button type="button" class="close" data-dismiss="modal">&times;</button>
				</div>
				<div class="modal-body">
					<div class="alert alert-success">
						Votre mise à jour a été effectuée avec succès.
					</div>
				</div>
				<div class="modal-footer">
				  <button type="button" class="btn btn-default" data-dismiss="modal">Fermer</button>
				</div>
			  </div>
			  
			</div>
		  </div>
		  <div class="modal fade" id="createModal" role="dialog">
			<div class="modal-dialog">
			
			  <!-- Modal content-->
			  <div class="modal-content">
				<div class="modal-header">
				  <button type="button" class="close" data-dismiss="modal">&times;</button>
				</div>
				<div class="modal-body">
					<div class="alert alert-success">
						Votre réservation a été effectuée avec succès.
					</div>
				</div>
				<div class="modal-footer">
				  <button type="button" class="btn btn-default" data-dismiss="modal">Fermer</button>
				</div>
			  </div>
			  
			</div>
		  </div>
        <div id="page-wrapper">
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">Liste des réservations</h1>
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
			<?php
				function multiexplode ($delimiters,$string) {
                  $ready = str_replace($delimiters, $delimiters[0], $string);
                  $launch = explode($delimiters[0], $ready);
                  return  $launch;
              }
			//Create query
				$todayFile = 'Liste des reservations '.date("Y-m-d H-i-s");				
				//$agence = $_SESSION['SESS_SALON_ID'];
			
				$qry="SELECT date, t.nom, c.nom, c.prenom,  r.vol, compagnie, porte, s.nom, o.nom, r.date_validation, s.id, r.id, id_client, sl.nom, agence, r.date_ajout ";
				$qry.="FROM `reservation_agence` r, tranche t, client_agence c, statut s, origine o, agence sl ";
				$qry.="where r.`id_client` = c.id and r.`statut` = s.id and r.`id_tranche` = t.id and r.id_origine = o.id and sl.id = agence ";
				$qry.="ORDER BY r.`date` DESC";
				$result=mysqli_query($bd, $qry);
			 
				//Check whether the query was successful or not
				if($result) {
					if(mysqli_num_rows($result) > 0) {			
						?>
						<div class="row">
							<div class="col-lg-12">
								<div class="panel panel-default">
									<div class="panel-heading">Réservations de l'agence
									</div>
									<!-- /.panel-heading -->
									<div class="panel-body">
										<table width="100%" style="font-size: 14px" class="table table-striped table-bordered table-hover" id="dataTables-example">
											<thead>
												<tr>
													<th>Date</th>
													<th>Tranche</th>
													<th>Nom</th>
													<th>Prénom</th>
													<th>Agence</th>
													<th>Vol</th>
													<th>Compagnie</th>
													<th>N° billet</th>
													<th></th>
												</tr>
											</thead>
											<tbody>
						<?php
						while ($row = mysqli_fetch_array($result, MYSQLI_BOTH)) {
							switch ($row[10]) {
								case "1":
									echo '<tr class="warning" valign="middle">';
									break;
								case "2":
									echo '<tr class="success" valign="middle">';
									break;
								case "3":
									echo '<tr class="danger" valign="middle">';
									break;
							}
							if ($row[0]!= '' && $row[0] != "0000-00-00")
							{
								list($year, $month, $day) = multiexplode(array("/"," ","-",":"), $row[0]);								
							}
							echo '	<td>'.$row[0].'</td>';
							echo '	<td>'.$row[1].'</td>';
							echo '	<td>'.$row[2].'</td>';
							echo '	<td>'.$row[3].'</td>';
							echo '	<td>'.$row[13].'</td>';
							echo '	<td>'.$row[4].'</td>';
							echo '	<td>'.$row[5].'</td>';
							echo '	<td>'.$row[6].'</td>';							
							echo '	<td style="text-align:center"><a href="details_reservation_agence.php?id='.$row[11].'&id_client='.$row[12].'" class="btn btn-info" role="button">Détails</a></td>';
							echo '</tr>';
						}
						?>
								</tbody>
									</table>
								</div>
								<!-- /.panel-body -->
							</div>
							<!-- /.panel -->
						</div>
						<!-- /.col-lg-12 -->
					</div>
					<?php
					}else {
						
					}
				}else {
					die("Query failed");
				}
			?>
        </div>
        <!-- /#page-wrapper -->
			

    </div>
    <!-- /#wrapper -->

    <!-- jQuery -->
	<script src="https://code.jquery.com/jquery-1.12.4.js"></script>
	<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="../vendor/bootstrap/js/bootstrap.min.js"></script>

    <!-- Metis Menu Plugin JavaScript -->
    <script src="../vendor/metisMenu/metisMenu.min.js"></script>

    <!-- DataTables JavaScript -->
    <script src="../vendor/datatables/js/jquery.dataTables.min.js"></script>
    <script src="../vendor/datatables/js/dataTables.buttons.min.js"></script>
    <script src="../vendor/datatables/js/buttons.flash.min.js"></script>
    <script src="../vendor/datatables/js/jszip.min.js"></script>
    <script src="../vendor/datatables/js/pdfmake.min.js"></script>
    <script src="../vendor/datatables/js/vfs_fonts.js"></script>
    <script src="../vendor/datatables/js/buttons.html5.min.js"></script>
    <script src="../vendor/datatables/js/buttons.print.min.js"></script>
    <script src="../vendor/datatables-responsive/dataTables.responsive.js"></script>

    <!-- Custom Theme JavaScript -->
    <script src="../dist/js/sb-admin-2.js"></script>

    <!-- Page-Level Demo Scripts - Tables - Use for reference -->
    <script>
    $(document).ready(function() {
		$('#dataTables-example tfoot th').each( function () {
			var title = $(this).text();
			$(this).html( '<input type="text" placeholder="Rechercher" />' );
		} );
		var table = $('#dataTables-example').DataTable( {
			"order": [[ 0, "desc" ]],
			dom: 'Bfrtip',
			buttons: [
            {
                extend: 'copyHtml5',
				exportOptions: {
                    columns: [ 0, 1, 2, 3, 4, 5, 6, 7]
                }
            },
            {
                extend: 'pdfHtml5',
                title: '<?php echo $todayFile ?>',
				exportOptions: {
                    columns: [ 0, 1, 2, 3, 4, 5, 6, 7]
                }
            },
			{
                extend: 'excelHtml5',
                title: '<?php echo $todayFile ?>',
				exportOptions: {
                    columns: [ 0, 1, 2, 3, 4, 5, 6, 7]
                }
            },
            'print'
			],
            responsive: true
		} );
		// table.columns().every( function () {
        // var that = this;
 
        // $( 'input', this.footer() ).on( 'keyup change', function () {
            // if ( that.search() !== this.value ) {
                // that
                    // .search( this.value )
                    // .draw();
            // }
			// } );
		// } );
		var getUrlParameter = function getUrlParameter(sParam) {
			var sPageURL = decodeURIComponent(window.location.search.substring(1)),
				sURLVariables = sPageURL.split('&'),
				sParameterName,
				i;

			for (i = 0; i < sURLVariables.length; i++) {
				sParameterName = sURLVariables[i].split('=');

				if (sParameterName[0] === sParam) {
					return sParameterName[1] === undefined ? true : sParameterName[1];
				}
			}
		};
		
		var statut = getUrlParameter('statut');
		if (statut == 'Uok')
			$('#updateModal').modal('show');
		if (statut == 'Cok')
			$('#createModal').modal('show');
    });
    </script>

</body>

</html>
