<?php
//Start session
session_start();

require_once('header.php');
require_once('includes/connection.php');
?>
<div class="modal fade" id="ChampsModal" role="dialog">
	<div class="modal-dialog">

		<!-- Modal content-->
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" >&times;</button>
			</div>
			<div class="modal-body">
				<div class="alert alert-warning">
					Merci de remplir les champs obligatoires !!
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Fermer</button>
			</div>
		</div>

	</div>
</div>

<!-- alert sur l'enregistrement d'une reservation quand il y'a une doublon sur le numéro de billet -->
<div class="modal fade" id="doublonModal" role="dialog">
	<div class="modal-dialog">

		<!-- Modal content-->
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" id="fermer">&times;</button>
			</div>
			<div class="modal-body">
				<div class="alert alert-warning">
				Ce numéro de billet est déjà enregistré pour ce vol.
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal" id="fermer">Fermer</button>
			</div>
		</div>

	</div>
</div>
<!-- alert en cas de succés sur la création d'une reservation -->
<div class="modal fade" id="succesModal" role="dialog">
	<div class="modal-dialog">

		<!-- Modal content-->
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" id="fermer">&times;</button>
			</div>
			<div class="modal-body">
				<div class="alert alert-success">
				 Réservation créée avec succès
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal" id="fermer">Fermer</button>
			</div>
		</div>

	</div>
</div>
<div id="page-wrapper">
	<div class="row">
		<div class="col-lg-12">
			<h1 class="page-header">Nouvelle réservation</h1>
		</div>
		<!-- /.col-lg-12 -->
	</div>
	<!-- /.row -->
	<form name="reservation" id="reservation" action="includes/update_reservation.php" method="post">
		<div class="row">
			<div class="col-lg-6">
				<div class="panel panel-danger" style="height:450px">
					<div class="panel-heading" style="font-size: 20px;">
						<i class="fa fa-user fa-fw"></i>Passager
					</div>
					<div class="panel-body">
						<div class="row">
							<div class="col-lg-4">
								<div class="form-group">
									<label>Civilité</label>
									<select class="form-control" name="civilite" id="civilite" title="obligatoire">
										<option>Mr</option>
										<option>Mme</option>
										<option>Mlle</option>
									</select>
								</div>
							</div>
							<div class="col-lg-8">
								<div class="form-group">
									<label>Nom</label>
									<input id="nom" name="nom" class="form-control" title="obligatoire">
								</div>
							</div>
							<div class="col-lg-8">
								<div class="form-group">
									<label>Prénom</label>
									<input id="prenom" name="prenom" class="form-control" title="obligatoire">
								</div>
							</div>
							<div class="col-lg-4">
								<div class="form-group">
									<label>Age</label>
									<?php
									$select = mysqli_query($bd, "SELECT id, nom FROM age ORDER BY id DESC");
									echo '<select id="age" name="age" class="form-control">';
									while ($fetch = mysqli_fetch_array($select)) {
									?>
										<option value="<?php echo $fetch['id']; ?>"><?php echo $fetch['nom']; ?></option>
									<?php
									}
									echo '</select>';
									?>
								</div>
							</div>
							<div class="col-lg-6">
								<div class="form-group">
									<label>Salon</label>
									<?php
									$select = mysqli_query($bd, "SELECT id, nom FROM salon ORDER BY id");
									echo '<select id="salon" name="salon" class="form-control">';
									while ($fetch = mysqli_fetch_array($select)) {
									?>
										<option <?php if ($_SESSION['SESS_SALON_ID'] == $fetch['id']) echo 'selected="selected"' ?> value="<?php echo $fetch['id']; ?>"><?php echo $fetch['nom']; ?></option>
									<?php
									}
									echo '</select>';
									?>
								</div>
							</div>
							<div class="col-lg-6">
								<div class="form-group">
									<label>Date</label>
									<input id="dateresa" name="dateresa" class="form-control">
								</div>
							</div>
							<div class="col-lg-3">
								<div class="form-group">
									<label>N° de billet</label>
									<input id="porte" name="porte" class="form-control">
								</div>
							</div>
							<div class="col-lg-3">
								<div class="form-group">
									<label>N° de vol</label>
									<input id="vol" name="vol" class="form-control" title="obligatoire">
								</div>
							</div>
							<div class="col-lg-6">
								<div class="form-group">
									<label>Compagnie</label>
									<?php
									$select = mysqli_query($bd, "SELECT id, nom FROM compagnie ORDER BY nom ASC");
									echo '<select id="compagnie" name="compagnie" class="form-control">';
									//echo '<input id="compagnie" name="compagnie" list="urldata" class="form-control">';
									//echo '<datalist id="urldata">';
									while ($fetch = mysqli_fetch_array($select)) {
									?>
										<option value="<?php echo $fetch['nom']; ?>"><?php echo $fetch['nom']; ?></option>
									<?php
									}
									//echo '</datalist>';
									echo '</select>';
									?>
								</div>
							</div>

							<div class="col-lg-3">
								<div class="form-group">
									<label>Type</label>
									<?php
									$select = mysqli_query($bd, "SELECT id, nom FROM origine Where actif='1' ORDER BY ordre");
									echo '<select id="origine" name="origine" class="form-control">';
									while ($fetch = mysqli_fetch_array($select)) {
									?>
										<option value="<?php echo $fetch['id']; ?>"><?php echo $fetch['nom']; ?></option>
									<?php
									}
									echo '</select>';
									?>
								</div>
							</div>
							<div class="col-lg-9">
								<div class="form-group" id="invit" name="invit" style="display:none">
									<label>Passager invitant</label>
									<?php
									$today = date("Y-m-d");
									$yesterday = date("Y-m-d", strtotime("-1 day"));
									$qry = "SELECT r.id, c.nom, c.prenom,  r.vol, compagnie ";
									$qry .= "FROM `reservation` r, client c ";
									$qry .= "where r.`id_client` = c.id and r.date > '$yesterday' and r.statut <> '3' ";
									$qry .= "order by r.`date_ajout` desc";

									$select = mysqli_query($bd, $qry);
									echo '<select id="invitant" name="invitant" class="form-control">';
									while ($fetch = mysqli_fetch_array($select)) {
									?>
										<option value="<?php echo $fetch['id']; ?>"><?php echo $fetch['nom'] . ' ' . $fetch['prenom'] . ' - ' . $fetch['vol'] . ' - ' . $fetch['compagnie']; ?></option>
									<?php
									}
									echo '</select>';
									?>
								</div>
								<div class="form-group" id="carte" name="carte" style="display:none">
									<label>Numéro de carte</label>
									<input id="numcarte" name="numcarte" class="form-control">
								</div>
								<div class="form-group" id="administrateur" name="administrateur" style="display:none">
									<label>Administrateur invitant</label>
									<?php
									$qry = "SELECT id, nom ";
									$qry .= "FROM administrateur ";
									$qry .= "where actif = '1' ";

									$select = mysqli_query($bd, $qry);
									echo '<select id="admin" name="admin" class="form-control">';
									while ($fetch = mysqli_fetch_array($select)) {
									?>
										<option value="<?php echo $fetch['id']; ?>"><?php echo $fetch['nom']; ?></option>
									<?php
									}
									echo '</select>';
									?>
								</div>
							</div>
						</div>
						<!-- /.row (nested) -->
					</div>
					<!-- /.panel-body -->
				</div>
				<!-- /.panel -->
			</div>

			<div class="col-lg-6">
				<div class="panel panel-success" style="height:360px">
					<div class="panel-heading" style="font-size: 20px;">
						<i class="fa fa-phone fa-fw"></i>Informations complémentaires
					</div>
					<div class="panel-body">
						<div class="row">
							<div class="col-lg-8">
								<label>Date de naissance</label>
								<div class="form-group">
									<div class="col-lg-4">
										<div class="form-group">
											<input id="jour" name="jour" class="form-control" placeholder="Jour">
										</div>
									</div>
									<div class="col-lg-4">
										<div class="form-group">
											<select id="mois" name="mois" class="form-control">
												<option value="0">Mois</option>
												<option value="1">Janvier</option>
												<option value="2">Février</option>
												<option value="3">Mars</option>
												<option value="4">Avril</option>
												<option value="5">Mai</option>
												<option value="6">Juin</option>
												<option value="7">Juillet</option>
												<option value="8">Août</option>
												<option value="9">Septembre</option>
												<option value="10">Octobre</option>
												<option value="11">Novembre</option>
												<option value="12">Décembre</option>
											</select>
										</div>
									</div>
									<div class="col-lg-4">
										<div class="form-group">
											<input id="annee" name="annee" class="form-control" placeholder="Année">
										</div>
									</div>
								</div>
							</div>
							<div class="col-lg-6">
								<div class="form-group">
									<label>Nationalité</label>
									<input id="nationalite" name="nationalite" class="form-control">
								</div>
							</div>

							<div class="col-lg-6">
								<div class="form-group">
									<label>Numéro de passeport</label>
									<input id="num_pass" name="num_pass" class="form-control">
								</div>
							</div>
							<div class="col-lg-8">
								<label>Date de délivrance</label>
								<div class="form-group">
									<div class="col-lg-4">
										<div class="form-group">
											<input id="jour_pass" name="jour_pass" class="form-control" placeholder="Jour">
										</div>
									</div>
									<div class="col-lg-4">
										<div class="form-group">
											<select id="mois_pass" name="mois_pass" class="form-control">
												<option value="0">Mois</option>
												<option value="1">Janvier</option>
												<option value="2">Février</option>
												<option value="3">Mars</option>
												<option value="4">Avril</option>
												<option value="5">Mai</option>
												<option value="6">Juin</option>
												<option value="7">Juillet</option>
												<option value="8">Août</option>
												<option value="9">Septembre</option>
												<option value="10">Octobre</option>
												<option value="11">Novembre</option>
												<option value="12">Décembre</option>
											</select>
										</div>
									</div>
									<div class="col-lg-4">
										<div class="form-group">
											<input id="annee_pass" name="annee_pass" class="form-control" placeholder="Année">
										</div>
									</div>
								</div>
							</div>
							<div class="col-lg-6">
								<div class="form-group">
									<label>Email</label>
									<input id="email" name="email" class="form-control">
								</div>
							</div>
							<div class="col-lg-6">
								<div class="form-group">
									<label>Téléphone</label>
									<input id="telephone" name="telephone" class="form-control">
								</div>
							</div>
						</div>
						<!-- /.row (nested) -->
					</div>
					<!-- /.panel-body -->
				</div>
				<!-- /.panel -->
			</div>
			<div class="col-lg-6">
				<div class="panel panel-warning" style="height:70px">

					<div class="panel-body">
						<div class="row">


							<div class="col-lg-6">
								<div class="form-group" style="text-align:center">
									<button type="submit" id="action" name="action" value="valider" class="btn btn-outline btn-success">Valider la réservation</button>
								</div>
							</div>
							<div class="col-lg-6">
								<div class="form-group" style="text-align:center">
									<button type="submit" id="action" name="action" value="enregistrer" class="btn btn-outline btn-warning">Enregistrer la réservation</button>
								</div>
							</div>
						</div>
						<!-- /.row (nested) -->
					</div>
					<!-- /.panel-body -->
				</div>
				<!-- /.panel -->
			</div>


			<!-- /.col-lg-12 -->
		</div>
	</form>
	<!-- /.row -->
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

<!-- Custom Theme JavaScript -->
<script src="../dist/js/sb-admin-2.js"></script>
<script>
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
	if (statut == 'ko')
		$('#doublonModal').modal('show');
		var statut = getUrlParameter('statut');
	if (statut == 'Cok')
		$('#succesModal').modal('show');
</script>
<script type='text/javascript'>
	$('#fermer').click(function() {
		document.location.replace('new_reservation.php');
	});
	// $('#page-wrapper').mouseenter(function() {
	// 	document.location.replace('new_reservation.php');
	// });
</script>
<script type="text/javascript">
	// function disableFunction() {
	// $('#action').prop('disabled', true);
	// }

	$(function() {
		$("#dateresa").datepicker({
			dateFormat: "dd/mm/yy"
		}).val();
		var currentDate = new Date();
		$("#dateresa").datepicker("setDate", currentDate);
	});


	$("#origine").change(function() {
		if ($("#origine").val() == '4') {
			$("#carte").fadeOut(600);
			$("#administrateur").fadeOut(600);
			$("#invit").show();
		} else {
			if ($("#origine").val() == '5') {
				$("#invit").fadeOut(600);
				$("#administrateur").fadeOut(600);
				$("#carte").show();
			} else {
				if ($("#origine").val() == '8') {
					$("#invit").fadeOut(600);
					$("#carte").fadeOut(600);
					$("#administrateur").show();
				} else {
					$("#carte").fadeOut(600);
					$("#administrateur").fadeOut(600);
					$("#invit").fadeOut(600);
				}
			}
		}
	});

	$('#reservation').submit(function() {
		var allIsOk = true;

		// Check if empty of not
		$(this).find('[title="obligatoire"]').each(function() {
			if (!$(this).val()) {
				$('#ChampsModal').modal('show');
				$(this).addClass('borderR').focus();
				allIsOk = false;
				return allIsOk;
			}
		});

		return allIsOk
	});
</script>
</script>

</body>

</html>