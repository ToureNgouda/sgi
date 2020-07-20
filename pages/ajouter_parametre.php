<?php
require_once('header.php');
//Include database connection details
require_once('includes/connection.php');
?>
<!--?php if ($_SESSION['SESS_PROFIL'] != $ADMIN_PROFIL) echo "<script type='text/javascript'>document.location.replace('../pages/index.php');</script>"; ?>
Modal -->
<?php
if (isset($_POST['enregistre'])) {
	$id =  $_POST['enregistre'];
	$test = "fonction  appele";
	$ordre = $_POST['ordre'];
	$code_iata = $_POST['codeiata'];
	$tva = $_POST['tva'];
	$tarif = $_POST['tarif'];
	$idCompagnie = $_POST['compagnie'];
	$adresse = $_POST['adresse'];

	$qry = "UPDATE parametres ";
	$qry .= "SET  `code_iata` = '$code_iata',`code_iata` = '$code_iata', `tva` = '$tva', `odre` = '$ordre' , `adresse_de_facturation` = '$adresse', `tarif_ht` = '$tarif', `compagnie` = '$idCompagnie' ";
	$qry .= "WHERE `id` = $id ";
	$result = mysqli_query($bd, $qry);

	// recupere l'id de la compagnie
	// $qryCompagnieId= "SELECT p.`compagnie` from `parametres` p where p.`id`= $id";
	// $resultCompagnieId = mysqli_query($bd, $qryCompagnieId);
	// if($resultCompagnieId && mysqli_num_rows($resultCompagnieId) > 0){
	// 	if($rwCompagnie = mysqli_fetch_array($resultCompagnieId, MYSQLI_BOTH)){
	// 		$idCompagnie = $rwCompagnie[0];
	// 	}
	// }

	// recupere l'id du type facturation admin
	$qrytypeFactuAdmin = "SELECT t.`id` from `typefacturation` t where t.`statut`= 'ADMIN'";
	$resultFactuAdmin = mysqli_query($bd, $qrytypeFactuAdmin);
	if ($resultFactuAdmin && mysqli_num_rows($resultFactuAdmin) > 0) {
		if ($rwFactuAdmin = mysqli_fetch_array($resultFactuAdmin, MYSQLI_BOTH)) {
			$idAdmin = $rwFactuAdmin[0];
		}
	}



	if (isset($_POST['admin'])) {
		$qryAdmin = "SELECT t.`compagnie_id`, t.`typefacturation_id` from `typefacturation_compagnie` t WHERE `compagnie_id` = $idCompagnie and `typefacturation_id` = $idAdmin";
		$result = mysqli_query($bd, $qryAdmin);
		if ($result &&  mysqli_num_rows($result) > 0) {
		} else {
			$qryAdmin = "INSERT INTO  typefacturation_compagnie(compagnie_id, typefacturation_id) VALUES ( $idCompagnie , $idAdmin)";
			$result = mysqli_query($bd, $qryAdmin);
		}
	} else {
		$qryAdmin = "DELETE  from typefacturation_compagnie WHERE `compagnie_id` = $idCompagnie and `typefacturation_id` = $idAdmin";
		$result = mysqli_query($bd, $qryAdmin);
	}

	// recupere l'id du type facturation carte
	$qrytypeFactuCarte = "SELECT t.`id` from `typefacturation` t where t.`statut`= 'CARTE'";
	$resultFactuCarte = mysqli_query($bd, $qrytypeFactuCarte);
	if ($resultFactuCarte && mysqli_num_rows($resultFactuCarte) > 0) {
		if ($rwFactuCarte = mysqli_fetch_array($resultFactuCarte, MYSQLI_BOTH)) {
			$idCarte = $rwFactuCarte[0];
		}
	}



	if (isset($_POST['carte'])) {
		$qryCarte = "SELECT t.`compagnie_id`, t.`typefacturation_id` from `typefacturation_compagnie` t WHERE `compagnie_id` = $idCompagnie and `typefacturation_id` = $idCarte";
		$result = mysqli_query($bd, $qryCarte);
		if ($result &&  mysqli_num_rows($result) > 0) {
		} else {
			$qryCarte = "INSERT INTO  typefacturation_compagnie(compagnie_id, typefacturation_id) VALUES ( $idCompagnie , $idCarte)";
			$result = mysqli_query($bd, $qryCarte);
		}
	} else {
		$qryCarte = "DELETE  from typefacturation_compagnie WHERE `compagnie_id` = $idCompagnie and `typefacturation_id` = $idCarte";
		$result = mysqli_query($bd, $qryCarte);
	}

	// recupere l'id du type facturation business
	$qrytypeFactuBus = "SELECT t.`id` from `typefacturation` t where t.`statut`= 'BUSINESS'";
	$resultFactuBus = mysqli_query($bd, $qrytypeFactuBus);
	if ($resultFactuBus && mysqli_num_rows($resultFactuBus) > 0) {
		if ($rwFactuBus = mysqli_fetch_array($resultFactuBus, MYSQLI_BOTH)) {
			$idBus = $rwFactuBus[0];
		}
	}



	if (isset($_POST['business'])) {
		$qryBus = "SELECT t.`compagnie_id`, t.`typefacturation_id` from `typefacturation_compagnie` t WHERE `compagnie_id` = $idCompagnie and `typefacturation_id` = $idBus";
		$result = mysqli_query($bd, $qryBus);
		if ($result &&  mysqli_num_rows($result) > 0) {
		
		} else {
			$qryBus = "INSERT INTO  typefacturation_compagnie(compagnie_id, typefacturation_id) VALUES ( $idCompagnie , $idBus)";
			$result = mysqli_query($bd, $qryBus);
		}
	} else {
		$qryBus = "DELETE  from typefacturation_compagnie WHERE `compagnie_id` = $idCompagnie and `typefacturation_id` = $idBus";
		$result = mysqli_query($bd, $qryBus);
	}


	// recupere l'id du type facturation invitation
	$qrytypeFactuInv = "SELECT t.`id` from `typefacturation` t where t.`statut`= 'INVITATION'";
	$resultFactuInv = mysqli_query($bd, $qrytypeFactuInv);
	if ($resultFactuInv && mysqli_num_rows($resultFactuInv) > 0) {
		if ($rwFactuInv = mysqli_fetch_array($resultFactuInv, MYSQLI_BOTH)) {
			$idInv = $rwFactuInv[0];
		}
	}



	if (isset($_POST['invitation'])) {
		$qryInv = "SELECT t.`compagnie_id`, t.`typefacturation_id` from `typefacturation_compagnie` t WHERE `compagnie_id` = $idCompagnie and `typefacturation_id` = $idInv";
		$result = mysqli_query($bd, $qryInv);
		if ($result &&  mysqli_num_rows($result) > 0) {
		} else {
			$qryInv = "INSERT INTO  typefacturation_compagnie(compagnie_id, typefacturation_id) VALUES ( $idCompagnie , $idInv)";
			$result = mysqli_query($bd, $qryInv);
		}
	} else {
		$qryInv = "DELETE  from typefacturation_compagnie WHERE `compagnie_id` = $idCompagnie and `typefacturation_id` = $idInv";
		$result = mysqli_query($bd, $qryInv);
	}



	// recupere l'id du type facturation Payant
	$qrytypeFactuPay = "SELECT t.`id` from `typefacturation` t where t.`statut`= 'PAYANT'";
	$resultFactuPay = mysqli_query($bd, $qrytypeFactuPay);
	if ($resultFactuPay && mysqli_num_rows($resultFactuPay) > 0) {
		if ($rwFactuPay = mysqli_fetch_array($resultFactuPay, MYSQLI_BOTH)) {
			$idPay = $rwFactuPay[0];
		}
	}



	if (isset($_POST['payant'])) {
		$qryPay = "SELECT t.`compagnie_id`, t.`typefacturation_id` from `typefacturation_compagnie` t WHERE `compagnie_id` = $idCompagnie and `typefacturation_id` = $idPay";
		$result = mysqli_query($bd, $qryPay);
		if ($result &&  mysqli_num_rows($result) > 0) {
		} else {
			$qryPay = "INSERT INTO  typefacturation_compagnie(compagnie_id, typefacturation_id) VALUES ( $idCompagnie , $idPay)";
			$result = mysqli_query($bd, $qryPay);
		}
	} else {
		$qryPay = "DELETE  from typefacturation_compagnie WHERE `compagnie_id` = $idCompagnie and `typefacturation_id` = $idPay";
		$result = mysqli_query($bd, $qryPay);
	}


	// recupere l'id du type facturation First
	$qrytypeFactuFirst = "SELECT t.`id` from `typefacturation` t where t.`statut`= 'FIRST'";
	$resultFactuFirst = mysqli_query($bd, $qrytypeFactuFirst);
	if ($resultFactuFirst && mysqli_num_rows($resultFactuFirst) > 0) {
		if ($rwFactuFirst = mysqli_fetch_array($resultFactuFirst, MYSQLI_BOTH)) {
			$idFirst = $rwFactuFirst[0];
		}
	}



	if (isset($_POST['first'])) {
		$qryFirst = "SELECT t.`compagnie_id`, t.`typefacturation_id` from `typefacturation_compagnie` t WHERE `compagnie_id` = $idCompagnie and `typefacturation_id` = $idFirst";
		$result = mysqli_query($bd, $qryFirst);
		if ($result &&  mysqli_num_rows($result) > 0) {
		} else {
			$qryFirst = "INSERT INTO  typefacturation_compagnie(compagnie_id, typefacturation_id) VALUES ( $idCompagnie , $idFirst)";
			$result = mysqli_query($bd, $qryFirst);
		}
	} else {
		$qryFirst = "DELETE  from typefacturation_compagnie WHERE `compagnie_id` = $idCompagnie and `typefacturation_id` = $idFirst";
		$result = mysqli_query($bd, $qryFirst);
	}

	// update contact compagnie
	$qrycontact =  "SELECT  c.`id` ";
	$qrycontact .= "FROM `contact` c ";
	$qrycontact .= "where c.`compagnie` = $idCompagnie";
	$resultcontact = mysqli_query($bd, $qrycontact);

	if ($resultcontact && mysqli_num_rows($resultcontact) > 0) {
		while ($rowc = mysqli_fetch_array($resultcontact)) {
			$idc = $rowc[0];
			$q = "DELETE from contact WHERE `id` = $idc ";
			$r = mysqli_query($bd, $q);
		}
	}
	if (!empty($_POST['contactMail'])) {
		foreach ($_POST['contactMail'] as $cMail) {
			if (!empty($cMail)) {
				$qc = "INSERT INTO contact ";
				$qc .= "(`id`,`libelle`,`type`,`compagnie`) VALUES ";
				$qc .= "(NULL, '$cMail', 'mail','$idCompagnie');";
				$rs = mysqli_query($bd, $qc);
			}
		}
	}
	if (!empty($_POST['contactTel'])) {
		foreach ($_POST['contactTel'] as $cTel) {
			if (!empty($cTel)) {
				$qc = "INSERT INTO contact ";
				$qc .= "(`id`,`libelle`,`type`,`compagnie`) VALUES ";
				$qc .= "(NULL, '$cTel', 'tel','$idCompagnie');";
				$rs = mysqli_query($bd, $qc);
			}
		}
	}
	if (!empty($_POST['contactNom'])) {
		foreach ($_POST['contactNom'] as $cNom) {
			if ($cNom) {
				$qc = "INSERT INTO contact ";
				$qc .= "(`id`,`libelle`,`type`,`compagnie`) VALUES ";
				$qc .= "(NULL, '$cNom', 'nom','$idCompagnie');";
				$rs = mysqli_query($bd, $qc);
			}
		}
	}
}

?>

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
	$id = 0;

	//Check whether the query was successful or not
	if ($result) {
		if (mysqli_num_rows($result) > 0) {

	?>
	       <button class="btn btn-default pull-right" style="margin-top: -5px;"> <i class="fa fa-plus"></i> </button>
			<div class="row">
				<div class="col-lg-12">
					<div class="panel panel-default" style="margin-top: 4px;">
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
										$id = $row[0];
										$idComp = $row[8];
										$tfactu =  "SELECT  t.`compagnie_id` , t.`typefacturation_id`, tf.`statut` ";
										$tfactu .= "FROM `typefacturation_compagnie` t , `typefacturation` tf ";
										$tfactu .= "where t.`compagnie_id` = $idComp and t.typefacturation_id = tf.id";
										$resultFactu = mysqli_query($bd, $tfactu);
										$qrycontact =  "SELECT  c.`id`, c.`libelle`, c.`type` ";
										$qrycontact .= "FROM `contact` c ";
										$qrycontact .= "where c.`compagnie` = $idComp  order by c.type ASC";
										$resultcontact = mysqli_query($bd, $qrycontact);
										$resultc = mysqli_query($bd, $qrycontact);
										echo  '<tr>';
										echo '<th scope="row">';
										echo '<label class="lab">' . $row[7] . '</label>';
										echo '</th>';
										echo '<td>' . '<label class="lab">' . $row[1] . '</label></td>';
										echo '<td>' . '<label class="lab">' . $row[2] . '</label></td>';
										// echo '<td>' . $row[3] . '</td>';
										echo '<td>';
										if ($row[3] == "ACTIF") {
											echo '<input type="checkbox" checked="checked" value="ACTIF"  disabled>';
										} else {
											echo  '<input type="checkbox" value="INACTIF"  disabled>';
										}
										echo  '</td>';
										echo '<td>' . '<label class="lab">' . $row[5] . '</label></td>';
										echo '<td>';
										if ($resultFactu) {
											if (mysqli_num_rows($resultFactu) > 0) {
												while ($rowfac = mysqli_fetch_array($resultFactu, MYSQLI_BOTH)) {
													echo '<label class="lab">' . $rowfac[2] . '</label>';
													echo ' ';
												}
											}
										}
										echo '</td>';
										echo '<td>' .  '<label
										border:none;" class="lab">' . $row[4] . ' </label>' . '</td>';
										echo '<td>';
										if ($resultcontact) {
											if (mysqli_num_rows($resultcontact) > 0) {
												while ($rowcontact = mysqli_fetch_array($resultcontact, MYSQLI_BOTH)) {
													if ($rowcontact[2] === "nom") {
														echo '<label class="lab"
														  >' . $rowcontact[1] . '</label><br>';
													}
													if ($rowcontact[2] === "tel") {
														// echo '<br>';
														echo '<label class="lab">' . $rowcontact[1] . ' </label>';
													}
												}
											}
											echo '</td>';
											echo '<td>';
											while ($rowc = mysqli_fetch_array($resultc, MYSQLI_BOTH)) {
												if ($rowc[2] === "mail") {
													echo '<label class="lab">' . $rowc[1] . '</label>';
												}
											}
											echo '</td>';
										}
										echo '<td>
										<a href="update_parametre.php?id=' . $row[0] . '" class="btn btn-info" role="button"><i class="fa fa-edit" ></i></a>
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
<div class="modal fade" id="createModal" role="dialog">
	<div class="modal-dialog">
		<?php
		$idParam = $_GET["id"];
		echo "id" . $idParam;
		$qry = "SELECT p.`id`, p.`odre`, p.`code_iata`, p.`tva`, p.`adresse_de_facturation`, p.`tarif_ht` ";
		$qry .= "FROM `parametres` p ";
		$qry .= "where p.`id` = $idParam";
		$result = mysqli_query($bd, $qry);
		?>
		<!-- Modal content-->
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">&times;</button>
			</div>
			<div class="modal-body">
				<form action="">
					<div class="row">
						<div class="col-lg-4">
							<div class="form-group">
								<label>Ordre</label>
								<?php
								if ($result) {
									if (mysqli_num_rows($result) > 0) {
										while ($row = mysqli_fetch_array($result, MYSQLI_BOTH)) {
											echo '<input id="ordre" name="ordre" class="form-control" value="' . $row[1] . '"  type="number">';
											echo '</div>';
											echo '</div>';
											echo '<div class="col-lg-4">';
											echo '<div class="form-group">';
											echo '<label>Code iata</label>';
											echo '<input id="codeiata" name="codeiata" class="form-control" value="' . $row[2] . '"  type="text">';
											echo '</div>';
											echo '</div>';
											echo '<div class="col-lg-4">';
											echo '<div class="form-group">';
											echo '<label>Tarif HT</label>';
											echo '<input id="tarif" name="tarif" class="form-control" value="' . $row[3] . '"  type="text">';
											echo '</div>';
											echo '</div>';
											echo '</div>';
											echo '<div class="row">';
											echo '<div class="col-lg-6">';
											echo '<div class="form-group">';
											echo '<label for="">Adresse de Facturation</label>';
											echo '<textarea name="adresse" id="adresse" cols="35" rows="4">';
											echo $row[4];
											echo '</textarea>';
											echo '</div>';
											echo '</div>';
											echo '<div class="col-lg-6">';
											echo '<div class="form-group">';
											echo '<label >A Facturer</label>';
											echo '<select name="" id="" class="custom-select form-control" multiple>';
											echo '<option value="1">CARTE</option>';
											echo '<option value="1">BUSINESS</option>';
											echo '<option value="1">INVITATION</option>';
											echo '<option value="1">PAYANT</option>';
											echo '<option value="1">ADMIN</option>';
											echo '<option value="1">FIRST</option>';
											echo '</select>';
											echo '</div>';
											echo '</div>';
											echo '</div>';
											echo '<div class="row">';
											echo '<div class="col-lg-12">';
											echo '<label for="">Contact Telephone</label>';
											echo '</div>';
											echo '</div>';
											echo '<div class="row">';
											echo '<div class="col-lg-4">';
											echo '<div class="form-group" style="margin-left:10px;">';
											echo '<label for="">Nom</label>';
											echo '<input class="form-control" value="">';
											echo '</div>';
											echo '</div>';
											echo '<div class="col-lg-4">';
											echo '<div class="form-group">';
											echo '<label for="">Prenom</label>';
											echo '<input class="form-control" value="">';
											echo '</div>';
											echo '</div>';
											echo '<div class="col-lg-4">';
											echo '<div class="form-group">';
											echo '<label for="">Telephone</label>';
											echo '<input class="form-control" value="">';
											echo '</div>';
											echo '</div>';
											echo '</div>';
											echo '<div class="row">';
											echo '<div class="col-lg-12">';
											echo '<label for="">Contact Mail</label>';
											echo '</div>';
											echo '</div>';
											echo '<div class="row">';
											echo '<div class="col-lg-4">';
											echo '<div class="form-group" style="margin-left:10px;">';
											echo '<label for="">Mail 1</label>';
											echo '<input class="form-control" value="">';
											echo '</div>';
											echo '</div>';
											echo '<div class="col-lg-4">';
											echo '<div class="form-group">';
											echo '<label for="">Mail 2</label>';
											echo '<input class="form-control" value="">';
											echo '</div>';
											echo '</div>';
											echo '<div class="col-lg-4">';
											echo '<div class="form-group">';
											echo '<label for="">Mail 3</label>';
											echo '<input class="form-control" value="">';
											echo '</div>';
											echo '</div>';
											echo '</div>';

											echo '</form>';

											echo '</div>';
											echo '<div class="modal-footer">';
											echo '<button type="button" class="btn btn-default" data-dismiss="modal">Annuler</button>';
											echo 	'<button type="button" class="btn btn-primary" data-dismiss="modal">Enregistrer</button>';
											echo '</div>';
										}
									}
								}
								?>
							</div>

						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
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
	// $(".btn").click(function() {
	// 	var idParam = $('#openModal').val();
	// 	console.log("id param",idParam)
	// 	// $("#loginParam").submit(function(event) {
	// 	// 	event.preventDefault();
	// 	// });
	// 	$.get("#", {
	// 		id: idParam
	// 	}).done(function(data) {
	// 		//Success do whatever you want.
	// 		console.log("done done",data);
	// 	}).fail(function() {
	// 		//Something bad happened.
	// 	});
	// 	$('#createModal').modal('show');
	// });
</script>
<style>
	.lab{
		font-weight: normal;
		font-size: 12px;
	}
</style>

</body>

</html>