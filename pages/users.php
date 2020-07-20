<?php
require_once('header.php');
//Include database connection details
require_once('includes/connection.php');
?>
<?php if ($_SESSION['SESS_PROFIL'] != $ADMIN_PROFIL) echo "<script type='text/javascript'>document.location.replace('../pages/index.php');</script>"; ?>
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
					L'utilisateur a été créé avec succès.
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
			<h1 class="page-header">Liste des utilisateurs</h1>
		</div>
		<!-- /.col-lg-12 -->
	</div>
	<!-- /.row -->
	<?php
	$todayFile = 'Liste des utilisateurs ' . date("Y-m-d H-i-s");

	//Create query
	$qry = "SELECT `mem_id`, `gender`, `fname`, `lname`, `contact`, `telephone`, `username`, s.`nom`, p.`nom`, `profil`, salon ";
	$qry .= "FROM `member` m, `profil` p, `salon` s ";
	$qry .= "where s.`id` = `salon` and p.`id` = `profil` ";
	$qry .= "order by lname asc";
	$result = mysqli_query($bd, $qry);

	//Check whether the query was successful or not
	if ($result) {
		if (mysqli_num_rows($result) > 0) {
	?>
			<div class="row">
				<div class="col-lg-12">
					<div class="panel panel-default">
						<div class="panel-heading">Tous les salons
						</div>
						<!-- /.panel-heading -->
						<div class="panel-body">
							<table width="100%" style="font-size: 14px" class="table table-striped table-bordered table-hover" id="dataTables-example">
								<thead>
									<tr>
										<th>Civilité</th>
										<th>Nom</th>
										<th>Prénom</th>
										<th>Login</th>
										<th>Email</th>
										<th>Salon</th>
										<th>Profil</th>
										<th></th>
									</tr>
								</thead>
								<tbody>
									<?php
									while ($row = mysqli_fetch_array($result, MYSQLI_BOTH)) {
										switch ($row[9]) {
											case "1":
												echo '<tr class="success">';
												break;
											case "2":
												echo '<tr class="warning">';
												break;
											case "3":
												echo '<tr class="info">';
												break;
										}
										echo '	<td>' . $row[1] . '</td>';
										echo '	<td>' . $row[3] . '</td>';
										echo '	<td>' . $row[2] . '</td>';
										echo '	<td>' . $row[6] . '</td>';
										echo '	<td>' . $row[4] . '</td>';
										switch ($row[10]) {
											case "1":
												echo '	<td class="infinite">' . $row[7] . '</td>';
												break;
											case "2":
												echo '	<td class="odyssee">' . $row[7] . '</td>';
												break;
											case "3":
												echo '	<td class="topkapi">' . $row[7] . '</td>';
												break;
										}
										echo '	<td>' . $row[8] . '</td>';
										echo '	<td style="text-align:center"><a href="details_user.php?id=' . $row[0] . '" class="btn btn-info" role="button">Détails</a></td>';
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
		} else {
			die($qry);
		}
	} else {
		die($qry);
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
		$('#dataTables-example').DataTable({
			"order": [
				[0, "desc"]
			],
			dom: 'Bfrtip',
			buttons: [{
					extend: 'copyHtml5',
					exportOptions: {
						columns: [0, 1, 2, 3, 4, 5, 6]
					}
				},
				{
					extend: 'pdfHtml5',
					title: '<?php echo $todayFile ?>',
					exportOptions: {
						columns: [0, 1, 2, 3, 4, 5, 6]
					}
				},
				{
					extend: 'excelHtml5',
					title: '<?php echo $todayFile ?>',
					exportOptions: {
						columns: [0, 1, 2, 3, 4, 5, 6]
					}
				},
				'print'
			]
		});
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