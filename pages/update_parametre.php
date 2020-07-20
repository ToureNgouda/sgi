<?php
require_once('header.php');
//Include database connection details
require_once('includes/connection.php');
?>
<<!--?php if ($_SESSION['SESS_PROFIL'] != $ADMIN_PROFIL) echo "<script type='text/javascript'>document.location.replace('../pages/index.php');</script>"; ?> -->
<!-- Modal -->




<div class="modal fade" id="createModal" role="dialog">
	<div class="modal-dialog">
		<?php
		$idParam = $_GET["id"];
		$qry = "SELECT p.`id`, p.`odre`, p.`code_iata`, p.`tva`, p.`adresse_de_facturation`, p.`tarif_ht`,p.`compagnie` ";
		$qry .= "FROM `parametres` p ";
		$qry .= "where p.`id` = $idParam";
		$result = mysqli_query($bd, $qry);
		if ($result && mysqli_num_rows($result) > 0) {
			while ($row = mysqli_fetch_array($result, MYSQLI_BOTH)) {
				$id = $row[0];
				$odre = $row[1];
				$codeiata = $row[2];
				$tva = $row[3];
				$adresse = $row[4];
				$tarif = $row[5];
				$compagnie = $row[6];
				$query = "SELECT c.`id`, c.`nom` from `compagnie` c where c.id = $compagnie";
				$rsl = mysqli_query($bd, $query);
				$tfactu =  "SELECT  t.`compagnie_id` , t.`typefacturation_id`, tf.`statut`, tf.`id` ";
				$tfactu .= "FROM `typefacturation_compagnie` t , `typefacturation` tf ";
				$tfactu .= "where t.`compagnie_id` = $compagnie and t.typefacturation_id = tf.id";
				$resultFactu = mysqli_query($bd, $tfactu);
				$qrycontact =  "SELECT  c.`id`, c.`libelle`, c.`type` ";
				$qrycontact .= "FROM `contact` c ";
				$qrycontact .= "where c.`compagnie` = $compagnie order by c.type ASC";
				$resultcontact = mysqli_query($bd, $qrycontact);
				$resultcontactTel = mysqli_query($bd, $qrycontact);
				$resultcontactMail = mysqli_query($bd, $qrycontact);
				if ($rsl && mysqli_num_rows($rsl) > 0) {
					while ($rw = mysqli_fetch_array($rsl, MYSQLI_BOTH)) {
						$nomCompagnie = $rw[1];
						$idComp = $rw[0];
					}
				}
			}
		}
		?>
		<!-- Modal content-->
		<form action="parametres.php" method="post" id="saveParam" name="saveParam">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal">&times;</button>
				</div>
				<div class="modal-body">
					<div class="row">
						<div class="col-lg-6">
							<div class="form-group">
								<label>Compagnie</label>
								<?php
								$queryC = "SELECT c.`id`, c.`nom` from `compagnie` c";
								$rslC = mysqli_query($bd, $queryC);
								echo  '<select name="compagnie" id="compagnie" class="form-control">';
								if ($rslC && mysqli_num_rows($rslC) > 0) {
									while ($rowc = mysqli_fetch_array($rslC, MYSQLI_BOTH)) {
								?>
										<option <?php if ($rowc[0] == $idComp) echo 'selected="selected"' ?> value="<?php echo $rowc[0] ?>"> <?php echo $rowc[1] ?> </option>
								<?php
									}
								}
								echo '</select>';
								?>
							</div>
						</div>
						<div class="col-lg-3">
							<div class="form-group">
								<label>Odre</label>
								<input id="ordre" name="ordre" class="form-control" value="<?php echo $odre ?>" type="number">
							</div>
						</div>

					</div>
					<div class="row">
						<div class="col-lg-3">
							<div class="form-group">
								<label>Code iata</label>
								<input id="codeiata" name="codeiata" class="form-control" value="<?php echo $codeiata ?>" type="text">
							</div>
						</div>
						<div class="col-lg-3">
							<div class="form-group">
								<label>Tva</label>
								<!-- <input id="tva" name="tva" class="form-control" value="<?php echo $tva ?>" type="text"> -->
								<select id="tva" name="tva" class="form-control">
									<option value="ACTIF" <?php if ($tva == "ACTIF") echo 'selected="selected"'; ?>>ACTIF</option>
									<option value="INACTIF" <?php if ($tva == "INACTIF") echo 'selected="selected"'; ?>>INACTIF</option>
								</select>
							</div>
						</div>
						<div class="col-lg-3">
							<div class="form-group">
								<label>Tarif HT</label>
								<input id="tarif" name="tarif" class="form-control" value="<?php echo $tarif ?>" type="number">
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-lg-6">
							<div class="form-group">
								<label for="">Adresse de Facturation</label>
								<textarea name="adresse" id="adresse" cols="32" rows="5" style="margin-top: 5px">
											<?php echo $adresse; ?>
											</textarea>
							</div>
						</div>
						<div class="col-lg-6">
							<div class="form-group">
								<label>A Facturer</label><br>
								<?php
								$querytf = "SELECT tp.`id`, tp.`statut` from `typefacturation` tp";
								$rsltf = mysqli_query($bd, $querytf);
								// if ($rsltf && mysqli_num_rows($rsltf) > 0) {
								// 	while ($rwtf = mysqli_fetch_array($rsltf)) {

								// 	}
								// }
								$isCarte = false;
								$isInv = false;
								$isAdmin = false;
								$isPayant = false;
								$isFirst = false;
								$isBus = false;
								if ($resultFactu && mysqli_num_rows($resultFactu) > 0) {
									while ($fetchTf = mysqli_fetch_array($resultFactu)) {
										if ($fetchTf[2] ==  "ADMIN") {
											$isAdmin = true;
										}
										if ($fetchTf[2]  == "CARTE") {
											$isCarte = true;
										}
										if ($fetchTf[2] == "PAYANT") {
											$isPayant = true;
										}
										if ($fetchTf[2]  == "BUSINESS") {
											$isBus = true;
										}
										if ($fetchTf[2]  == "FIRST") {
											$isFirst = true;
										}
										if ($fetchTf[2]  == "INVITATION") {
											$isInv = true;
										}
									}
								}
								?>
								<div class="row form-group">
									<div class="col-lg-6">ADMIN</div>
									<?php
									if ($isAdmin) {
										echo '<input class=" col-lg-3" type="checkbox" checked value="ADMIN" id="admin" name="admin">';
									} else {
										echo '<input class=" col-lg-3" type="checkbox" value="ADMIN" id="admin" name="admin">';
									}
									?>
								</div>
								<div class="row form-group" style="margin-top: -15px">
									<div class="col-lg-6">BUSINESS</div>
									<?php
									if ($isBus) {
										echo '<input class=" col-lg-3" type="checkbox" checked value="BUSINESS" id="business" name="business">';
									} else {
										echo '<input class=" col-lg-3" type="checkbox" value="BUSINESS" id="business" name="business">';
									}
									?>
								</div>
								<div class="row form-group" style="margin-top: -15px">
									<div class="col-lg-6">CARTE</div>
									<?php
									if ($isCarte) {
										echo '<input class=" col-lg-3" type="checkbox" checked value="CARTE" id="carte" name="carte">';
									} else {
										echo '<input class=" col-lg-3" type="checkbox" value="CARTE" id="carte" name="carte">';
									}
									?>

								</div>
								<div class="row form-group" style="margin-top: -15px">
									<div class="col-lg-6">FIRST</div>
									<?php
									if ($isFirst) {
										echo '<input class=" col-lg-3" type="checkbox" checked value="FIRST" id="first" name="first">';
									} else {
										echo '<input class=" col-lg-3" type="checkbox" value="FIRST" id="first" name="first">';
									}
									?>
								</div>
								<div class="row form-group" style="margin-top: -15px">
									<div class="col-lg-6">INVITATION</div>
									<?php
									if ($isInv) {
										echo '<input class=" col-lg-3" type="checkbox" checked value="INVITATION" id="invitation" name="invitation">';
									} else {
										echo '<input class=" col-lg-3" type="checkbox" value="INVITATION" id="invitation" name="invitation">';
									}
									?>
								</div>
								<div class="row form-group" style="margin-top: -15px">
									<div class="col-lg-6">PAYANT</div>
									<?php
									if ($isPayant) {
										echo '<input class=" col-lg-3" type="checkbox" checked value="PAYANT" id="payant" name="payant"> ';
									} else {
										echo '<input class=" col-lg-3" type="checkbox" value="PAYANT" id="payant" name="payant">';
									}
									?>
								</div>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-lg-12">
							<label for="">Contact Telephone</label>
						</div>
					</div>
					<?php
					if ($resultcontact && mysqli_num_rows($resultcontact) > 0) {
						while ($rowContactNom = mysqli_fetch_array($resultcontact)) {
							if ($rowContactNom[2] == "nom") {
								echo '<div class="col-lg-6">';
								echo '<div class="form-group" style="margin-left:10px;">';
								echo '<label for="">Prenom & Nom</label>';
								echo '<input name="contactNom[]" class="form-control" value="' . $rowContactNom[1] . '">';
								echo '</div>';
								echo '</div>';
							}
						}
					}
					?>
					<?php
					if (mysqli_num_rows($resultcontactTel) == 0) {
						echo '<div class="col-lg-6">';
						echo '<div class="form-group" style="margin-left:10px;">';
						echo '<label for="">Prenom & Nom</label>';
						echo '<input name="contactNom[]" class="form-control" value="">';
						echo '</div>';
						echo '</div>';
					}
					?>
					<?php
					if (mysqli_num_rows($resultcontactTel) == 0) {
						echo '<div class="col-lg-6">';
						echo '<div class="form-group" style="margin-left:10px;">';
						echo '<label for="">Prenom & Nom</label>';
						echo '<input name="contactNom[]" class="form-control" value="">';
						echo '</div>';
						echo '</div>';
					}
					?>

					<?php
					if ($resultcontactTel && mysqli_num_rows($resultcontactTel) > 0) {
						while ($rowContactTel = mysqli_fetch_array($resultcontactTel)) {
							if ($rowContactTel[2] == "tel") {
								echo '<div class="col-lg-6">';
								echo '<div class="form-group" style="margin-left:10px;">';
								echo '<label for="">Telephone</label>';
								echo '<input name="contactTel[]" class="form-control" value="' . $rowContactTel[1] . '">';
								echo '</div>';
								echo '</div>';
							}
						}
					}
					?>
					<?php
					if (mysqli_num_rows($resultcontactTel) == 0) {
						echo '<div class="col-lg-6">';
						echo '<div class="form-group" style="margin-left:10px;">';
						echo '<label for="">Telephone</label>';
						echo '<input name="contactTel[]" class="form-control" value="">';
						echo '</div>';
						echo '</div>';
					}
					?>
					<?php
					if (mysqli_num_rows($resultcontactTel) == 0) {
						echo '<div class="col-lg-6">';
						echo '<div class="form-group" style="margin-left:10px;">';
						echo '<label for="">Telephone</label>';
						echo '<input name="contactTel[]" class="form-control" value="">';
						echo '</div>';
						echo '</div>';
					}
					?>
					<div class="row">
						<div class="col-lg-12">
							<label for="">Contact Mail</label>
						</div>
					</div>
					<div class="row" style="margin-left:1px;">
						<?php
						if ($resultcontactMail && mysqli_num_rows($resultcontactMail) > 0) {
							while ($rowContactMail = mysqli_fetch_array($resultcontactMail)) {
								if ($rowContactMail[2] == "mail") {
									echo '<div class="col-lg-6">';
									echo '<div class="form-group" style="margin-left:10px;">';
									echo '<label for="">Mail</label>';
									echo '<input name="contactMail[]" class="form-control" value="' . $rowContactMail[1] . '">';
									echo '</div>';
									echo '</div>';
								}
							}
						}
						?>
						<?php
						if (mysqli_num_rows($resultcontactMail) == 0) {
							echo '<div class="col-lg-6">';
							echo '<div class="form-group" style="margin-left:10px;">';
							echo '<label for="">Mail</label>';
							echo '<input name="contactMail[]" class="form-control" value="">';
							echo '</div>';
							echo '</div>';
						}
						?>
						<?php
						if (mysqli_num_rows($resultcontactMail) == 0) {
							echo '<div class="col-lg-6">';
							echo '<div class="form-group" style="margin-left:10px;">';
							echo '<label for="">Mail</label>';
							echo '<input name="contactMail[]" class="form-control" value="">';
							echo '</div>';
							echo '</div>';
						}
						?>
					</div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-default" data-dismiss="modal" id="annuler">Annuler</button>
					<button type="submit" name="enregistre" class="btn btn-primary" id="enregistre" value="<?php echo $id ?>">Enregistrer</button>
				</div>
			</div>
		</form>
	</div>
</div>


<div id="page-wrapper">
	<div class="row">
		<div class="col-lg-12">
			<h1 class="page-header">Parametres</h1>
		</div>
		<!-- /.col-lg-12 -->
	</div>
	<!-- /.row -->
	<?php

	//Create query
	$qry = "SELECT p.`id`, p.`odre`, p.`code_iata`, p.`tva`, p.`adresse_de_facturation`, p.`tarif_ht`, p.`compagnie`,c.`nom`, c.`id` ";
	$qry .= "FROM `parametres` p, `compagnie` c ";
	$qry .= "where p.`compagnie` = c.`id`";
	$result = mysqli_query($bd, $qry);


	//Check whether the query was successful or not
	if ($result) {
		if (mysqli_num_rows($result) > 0) {

	?>
			<div class="row">
				<div class="col-lg-12">
					<div class="panel panel-default">
						<!-- /.panel-heading -->
						<div class="panel-body">
							<table width="100%" style="font-size: 14px" class="table table-bordered table-hover" id="dataTables-example">
								<thead>
									<tr>
										<!-- <th>COMPAGNIE</th> -->
										<th style="width: 160px;"></th>
										<th>ORDRE</th>
										<th>CODE IATA</th>
										<th>TVA</th>
										<th>TARIF HT</th>
										<th>A FACTURER</th>
										<th>ADRESSE DE FACTURATION</th>
										<th>CONTACT TELEPHONE</th>
										<th>CONTACT MAIL</th>
										<th></th>
									</tr>
								</thead>
								<tbody>
									<?php
									while ($row = mysqli_fetch_array($result, MYSQLI_BOTH)) {
										$idComp = $row[8];
										$tfactu =  "SELECT  t.`compagnie_id` , t.`typefacturation_id`, tf.`statut` ";
										$tfactu .= "FROM `typefacturation_compagnie` t , `typefacturation` tf ";
										$tfactu .= "where t.`compagnie_id` = $idComp and t.typefacturation_id = tf.id";
										$resultFactu = mysqli_query($bd, $tfactu);
										$qrycontact =  "SELECT  c.`id`, c.`libelle`, c.`type` ";
										$qrycontact .= "FROM `contact` c ";
										$qrycontact .= "where c.`compagnie` = $idComp";
										$resultcontact = mysqli_query($bd, $qrycontact);
										$resultc = mysqli_query($bd, $qrycontact);
										echo  '<tr>';
										echo '<th scope="row">';
										echo '<div name="compagnie" class="lab">' . $row[7] . '</div>';
										echo '</th>';
										echo '<td>' . '<label  class="lab">' . $row[1] . '</label></td>';
										echo '<td>' . '<label  class="lab">' . $row[2] . '</label></td>';
										// echo '<td>' . $row[3] . '</td>';
										echo '<td>';
										if ($row[3] === "ACTIF") {
											echo '<input type="checkbox" checked value="ACTIF" name="tva" disabled>';
										} else {
											echo  '<input type="checkbox"  value="INACTIF" name="tva" disabled>';
										}
										echo  '</td>';
										echo '<td>' . '<label name="tarifht"  class="lab">' . $row[5] . '</label></td>';
										echo '<td>';
										if ($resultFactu) {
											if (mysqli_num_rows($resultFactu) > 0) {
												while ($rowfac = mysqli_fetch_array($resultFactu, MYSQLI_BOTH)) {
													echo '<label  class="lab">' . $rowfac[2] . '</label>';
													echo ' ';
												}
											}
										}
										echo '</td>';
										echo '<td>' .  '<label
										border:none;"  class="lab">' . $row[4] . ' </label>' . '</td>';
										echo '<td>';
										if ($resultcontact) {
											if (mysqli_num_rows($resultcontact) > 0) {
												while ($rowcontact = mysqli_fetch_array($resultcontact, MYSQLI_BOTH)) {
													if ($rowcontact[2] === "nom") {
														echo '<label  class="lab"
														  >' . $rowcontact[1] . '</label>';
													}
													if ($rowcontact[2] === "tel") {
														// echo '<br>';
														echo '<label  class="lab">' . $rowcontact[1] . ' </label>';
													}
												}
											}
											echo '</td>';
											echo '<td>';
											while ($rowc = mysqli_fetch_array($resultc, MYSQLI_BOTH)) {
												if ($rowc[2] === "mail") {
													echo '<label  class="lab">' . $rowc[1] . '</label>';
												}
											}
											echo '</td>';
										}
										echo '<td>
										     <button class="btn btn-primary" id="openModal" value="' . $row[0] . '">  <i class="fa fa-edit" ></i>
										     </button>
											 </td>';
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
	$('#createModal').modal('show');
</script>
<script type='text/javascript'>
	$('#annuler').click(function() {
		document.location.replace('parametres.php');
	});
	$('#page-wrapper').mouseenter(function() {
		document.location.replace('parametres.php');
	});
</script>
<style>
	.lab {
		font-weight: normal;
		font-size: 12px;
	}
</style>
<script type='text/javascript'>
	// $('#enregistre').click(function() {
	// 	var id = $('#enregistre').val();
	// 	var ordre = $('#ordre').val();
	// 	var code_iata = $('#codeiata').val();
	// 	var tva = $('#tva').val();
	// 	var tarif = $('#tarif').val();
	// 	var adresse = $('#adresse').val();
	// 	console.log("id ", id, "ordre ", ordre, "code_iata ", code_iata, "tva ", tva, "adresse ", adresse);
	// 	$.post("../new_reservation.php", {
	// 		id: id,
	// 		ordre: ordre,
	// 		code_iata: code_iata,
	// 		tva: tva,
	// 		tarif: tarif,
	// 		adresse: adresse
	// 	}).done(function(data) {
	// 		console.log('function appele');
	// 	})
	// });
</script>

</body>

</html>