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

<!-- ajouter parametre -->
<?php
if (isset($_POST['ajouterParam'])) {
	$test = "fonction appele";
	$ordre = $_POST['ordre'];
	$code_iata = $_POST['codeiata'];
	$tva = $_POST['tva'];
	$tarif = $_POST['tarif'];
	$idCompagnie = $_POST['compagnie'];
	$adresse = $_POST['adresse'];
	$qrydoublon = "SELECT * from `parametres` p WHERE p.`compagnie` = '$idCompagnie'";
	$resultdoublon = mysqli_query($bd, $qrydoublon);
	if ($resultdoublon && mysqli_num_rows($resultdoublon) > 0) {
		// header("location: parametres.php?statut=ko");
		echo "<script type='text/javascript'>document.location.replace('parametres.php?statut=ko');</script>";
	} else {
		$qry = "INSERT INTO  parametres ";
		$qry .= "(`id`,`odre`,`code_iata`,`tva`,`adresse_de_facturation`,`tarif_ht`,`compagnie`) VALUES ";
		$qry .= "(NULL, '$ordre' ,'$code_iata' , '$tva', '$adresse', '$tarif', '$idCompagnie') ;";
		$result = mysqli_query($bd, $qry);
	}

	// recupere l'id du type facturation admin
	$qrytypeFactuAdmin = "SELECT t.`id` from `typefacturation` t where t.`statut`= 'ADMIN'";
	$resultFactuAdmin = mysqli_query($bd, $qrytypeFactuAdmin);
	if ($resultFactuAdmin && mysqli_num_rows($resultFactuAdmin) > 0) {
		if ($rwFactuAdmin = mysqli_fetch_array($resultFactuAdmin, MYSQLI_BOTH)) {
			$idAdmin = $rwFactuAdmin[0];
		}
	}


	if ($result) {
		// suppression des types facturations et contact de cette compagnie s'il existe
		$qryTypefac = "SELECT tf.`compagnie_id`, tf.`typefacturation_id` from `typefacturation_compagnie` tf WHERE tf.`compagnie_id`= $idCompagnie";
		$resultqryTypefac = mysqli_query($bd, $qryTypefac);
		if ($resultqryTypefac && mysqli_num_rows($resultqryTypefac) > 0) {
			while ($rctf = mysqli_fetch_array($resultqryTypefac, MYSQLI_BOTH)) {
				$tfcompagnie = $rctf[0];
				$tftypefac = $rctf[1];
				$qryTypefacdel = "DELETE  from typefacturation_compagnie WHERE `compagnie_id` = $idCompagnie and `typefacturation_id` = $tftypefac";
				$resultqryTypefacdel = mysqli_query($bd, $qryTypefacdel);
			}
		}

		$qrycontactdoub = "SELECT c.`id` from `contact` c WHERE c.`compagnie`= $idCompagnie";
		$resultqrycontactdoub = mysqli_query($bd, $qrycontactdoub);
		if ($resultqrycontactdoub && mysqli_num_rows($resultqrycontactdoub) > 0) {
			while ($rcont = mysqli_fetch_array($resultqrycontactdoub, MYSQLI_BOTH)) {
				$idcontact = $rcont[0];
				$qrycontactdel = "DELETE  from contact WHERE `id` = $idcontact";
				$resultqrycontactdel = mysqli_query($bd, $qrycontactdel);
			}
		}


		if (isset($_POST['admin'])) {
			$qryAdmin = "INSERT INTO  typefacturation_compagnie(compagnie_id, typefacturation_id) VALUES ( $idCompagnie , $idAdmin)";
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
			$qryCarte = "INSERT INTO  typefacturation_compagnie(compagnie_id, typefacturation_id) VALUES ( $idCompagnie , $idCarte)";
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
			$qryBus = "INSERT INTO  typefacturation_compagnie(compagnie_id, typefacturation_id) VALUES ( $idCompagnie , $idBus)";
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
			$qryInv = "INSERT INTO  typefacturation_compagnie(compagnie_id, typefacturation_id) VALUES ( $idCompagnie , $idInv)";
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
			$qryPay = "INSERT INTO  typefacturation_compagnie(compagnie_id, typefacturation_id) VALUES ( $idCompagnie , $idPay)";
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
			$qryFirst = "INSERT INTO  typefacturation_compagnie(compagnie_id, typefacturation_id) VALUES ( $idCompagnie , $idFirst)";
			$result = mysqli_query($bd, $qryFirst);
		}

		// update contact compagnie
		$qrycontact =  "SELECT  c.`id` ";
		$qrycontact .= "FROM `contact` c ";
		$qrycontact .= "where c.`compagnie` = $idCompagnie";
		$resultcontact = mysqli_query($bd, $qrycontact);
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
}
?>
<div class="modal fade" id="doublonModal" role="dialog">
	<div class="modal-dialog">

		<!-- Modal content-->
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" id="fermer">&times;</button>
			</div>
			<div class="modal-body">
				<div class="alert alert-warning">
					cette compagnie a déja des paramétres.
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
			<h1 class="page-header">Parametres</h1>
		</div>
		<!-- /.col-lg-12 -->
	</div>
	<!-- /.row -->
	<?php
	if (!isset($_POST['searchSubmit']) && !isset($_GET['currentpage'])) {
		$filename = 'searchparametre_' . $_SESSION['SESS_FIRST_NAME'] . '_' . $_SESSION['SESS_LAST_NAME'] . '.txt';
		file_put_contents($filename, '');
		$searchValue = file_get_contents($filename);
	} elseif (isset($_POST['searchSubmit'])) {
		$filename = 'searchparametre_' . $_SESSION['SESS_FIRST_NAME'] . '_' . $_SESSION['SESS_LAST_NAME'] . '.txt';
		$searchValue = file_get_contents($filename);
	} else {
		$filename = 'searchparametre_' . $_SESSION['SESS_FIRST_NAME'] . '_' . $_SESSION['SESS_LAST_NAME'] . '.txt';
		$searchValue = file_get_contents($filename);
	}

	$limit = 5;
	$sqlTotalRser = "SELECT COUNT(*) FROM `parametres` p ";
	$resultTotalRser = mysqli_query($bd, $sqlTotalRser);
	$values = mysqli_fetch_row($resultTotalRser);
	$nbReservations = $values[0];
	// le nombre de pages dans la liste des reservations
	$totalpages = ceil($nbReservations / $limit);
	// recupere la page courante ou la page par defaut
	// get the current page or set a default
	if (isset($_GET['currentpage']) && is_numeric($_GET['currentpage'])) {
		// cast var as int
		$currentpage = (int) $_GET['currentpage'];
	} else {
		// default page num
		$currentpage = 1;
	} // end if
	//  if current page is greater than total pages...
	if ($currentpage > $totalpages) {
		// set current page to last page
		$currentpage = $totalpages;
	} // end if
	// if current page is less than first page...
	if ($currentpage < 1) {
		// set current page to first page
		$currentpage = 1;
	} // end if

	// the offset of the list, based on current page 
	$offset = ($currentpage - 1) * $limit;

	if (isset($_POST['searchSubmit'])) {
		$key = $_POST['search'];
		$searchValue = file_put_contents('searchparametre.txt', $key);
		$searchValue = file_get_contents('searchparametre.txt');
		$sqlSearchComp = "SELECT * FROM `compagnie` c where c.`nom` = '$searchValue'";
		$resultsqlSearchComp = mysqli_query($bd, $sqlSearchComp);
		$valuesComp = mysqli_fetch_row($resultsqlSearchComp);
		$idComp = $valuesComp[0];
		if ($searchValue != '') {
			$sqlTotalParamSearch = "SELECT COUNT(*) FROM `parametres` p where p.`compagnie` = '$idComp'";
			$resultsqlTotalParamSearch = mysqli_query($bd, $sqlTotalParamSearch);
			$values = mysqli_fetch_row($resultsqlTotalParamSearch);
			$nbParam = $values[0];
		} else {
			$sqlTotalParamSearch = "SELECT COUNT(*) FROM `parametres` p ";
			$resultsqlTotalParamSearch = mysqli_query($bd, $sqlTotalParamSearch);
			$values = mysqli_fetch_row($resultsqlTotalParamSearch);
			$nbParam = $values[0];
		}


		// le nombre de pages dans la liste des reservations
		$limit = 5;
		$totalpages = ceil($nbParam / $limit);
		// recupere la page courante ou la page par defaut
		// get the current page or set a default
		if (isset($_GET['currentpage']) && is_numeric($_GET['currentpage'])) {
			// cast var as int
			$currentpage = (int) $_GET['currentpage'];
		} else {
			// default page num
			$currentpage = 1;
		} // end if
		//  if current page is greater than total pages...
		if ($currentpage > $totalpages) {
			// set current page to last page
			$currentpage = $totalpages;
		} // end if
		// if current page is less than first page...
		if ($currentpage < 1) {
			// set current page to first page
			$currentpage = 1;
		} // end if

		//Create query
		if ($searchValue != '') {
			$qry = "SELECT p.`id`, p.`odre`, p.`code_iata`, p.`tva`, p.`adresse_de_facturation`, p.`tarif_ht`, p.`compagnie`,c.`nom`, c.`id` ";
			$qry .= "FROM `parametres` p, `compagnie` c ";
			$qry .= "where  p.`compagnie` = '$idComp' and p.`compagnie` = c.`id`  ORDER BY p.`odre` ASC LIMIT $offset, $limit";
			$result = mysqli_query($bd, $qry);
		} else {
			$qry = "SELECT p.`id`, p.`odre`, p.`code_iata`, p.`tva`, p.`adresse_de_facturation`, p.`tarif_ht`, p.`compagnie`,c.`nom`, c.`id` ";
			$qry .= "FROM `parametres` p, `compagnie` c ";
			$qry .= "where p.`compagnie` = c.`id`  ORDER BY p.`odre` ASC LIMIT $offset, $limit";
			$result = mysqli_query($bd, $qry);
		}
	} else {
		//Create query
		$qry = "SELECT p.`id`, p.`odre`, p.`code_iata`, p.`tva`, p.`adresse_de_facturation`, p.`tarif_ht`, p.`compagnie`,c.`nom`, c.`id` ";
		$qry .= "FROM `parametres` p, `compagnie` c ";
		$qry .= "where p.`compagnie` = c.`id`  ORDER BY p.`odre` ASC LIMIT $offset, $limit";
		$result = mysqli_query($bd, $qry);
	}
	if (isset($_GET['currentpage']) && $searchValue != '') {
		$qry = "SELECT p.`id`, p.`odre`, p.`code_iata`, p.`tva`, p.`adresse_de_facturation`, p.`tarif_ht`, p.`compagnie`,c.`nom`, c.`id` ";
		$qry .= "FROM `parametres` p, `compagnie` c ";
		$qry .= "where  p.`compagnie` = '$idComp' and p.`compagnie` = c.`id`   ORDER BY p.`odre` ASC LIMIT $offset, $limit ";
		$result = mysqli_query($bd, $qry);
	}

	//Check whether the query was successful or not
	if ($result) {
		if (mysqli_num_rows($result) > 0) {
		}
	}
	?>
	<button class="btn btn-default pull-right" id="addParam" name="addParam" style="margin-top: -5px;"> <i class="fa fa-plus"></i> </button>
	<div class="row">
		<div class="col-lg-12">
			<div class="panel panel-default" style="margin-top: 4px;">
				<!-- /.panel-heading -->
				<div class="panel-body">
					<table width="100%" style="font-size: 14px" class="table table-bordered table-hover" id="dataTables-example">
						<thead>
							<tr>
								<!-- <th>COMPAGNIE</th> -->
								<th style="width: 13%;"></th>
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
							<tfooter style="margin-top: 0px;">
								<form action="parametres.php" method="post">
									<div class="row pull-right">
										<div class="col-lg-2">
											<button class="btn btn-primary" type="submit" name="searchSubmit">
												<span class="fa fa-search"></span>
											</button>
										</div>
										<div class="col-lg-10">
											<input type="text" name="search" class="form-control" style="margin-top: -2px;" placeholder="search" value="<?php echo $searchValue ?>">
										</div>
									</div>
								</form>
							</tfooter>
					</table>
					<div style="margin-top: 15px;">
						<div>
							page <?php echo $currentpage . '/' . $totalpages ?>
						</div>
					</div>
					<div class="pull-right" style="margin-top: -15px;">
						<?php
						// range of num links to show
						$range = 3;

						// if not on page 1, don't show back links
						if ($currentpage > 1) {
							// show << link to go back to page 1
							echo " <a href='{$_SERVER['PHP_SELF']}?currentpage=1'><<</a> ";
							// get previous page num
							$prevpage = $currentpage - 1;
							// show < link to go back to 1 page
							echo " <a href='{$_SERVER['PHP_SELF']}?currentpage=$prevpage'>Prev</a> ";
						} // end if 

						// loop to show links to range of pages around current page
						for ($x = ($currentpage - $range); $x < (($currentpage + $range) + 1); $x++) {
							if (($x > 0) && ($x <= $totalpages)) {
								// if we're on current page...
								if ($x == $currentpage) {
									// 'highlight' it but don't make a link
									echo " [<b>$x</b>] ";
									// if not current page...
								} else {
									// make it a link
									echo " <a href='{$_SERVER['PHP_SELF']}?currentpage=$x'>$x</a> ";
								} // end else
							} // end if 
						} // end for

						// if not on last page, show forward and last page links        
						if ($currentpage != $totalpages) {
							// get next page
							$nextpage = $currentpage + 1;
							// echo forward link for next page 
							echo " <a href='{$_SERVER['PHP_SELF']}?currentpage=$nextpage'>Next</a> ";
							// echo forward link for lastpage
							echo " <a href='{$_SERVER['PHP_SELF']}?currentpage=$totalpages'>>></a> ";
						} // end if
						?>
					</div>
					<!-- /.panel-body -->
				</div>
				<!-- /.panel -->
			</div>
			<!-- /.col-lg-12 -->
		</div>
		<?php
		// 	} else {
		// 		die($qry);
		// 	}
		// } else {
		// 	die($qry);
		// }
		?>
	</div>
	<!-- /#page-wrapper -->

	<!-- ajouter parametre -->

	<div class="modal fade" id="addModal" role="dialog">
		<div class="modal-dialog">
			<!-- Modal content-->
			<form action="parametres.php" method="post" id="addParam" name="addParam">
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
											<option value="<?php echo $rowc[0] ?>"> <?php echo $rowc[1] ?> </option>
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
									<input id="ordre" name="ordre" class="form-control" value="0" type="number">
								</div>
							</div>

						</div>
						<div class="row">
							<div class="col-lg-3">
								<div class="form-group">
									<label>Code iata</label>
									<input id="codeiata" name="codeiata" class="form-control" value="" type="text">
								</div>
							</div>
							<div class="col-lg-3">
								<div class="form-group">
									<label>Tva</label>
									<!-- <input id="tva" name="tva" class="form-control" value="<?php echo $tva ?>" type="text"> -->
									<select id="tva" name="tva" class="form-control">
										<option value="ACTIF">ACTIF</option>
										<option value="INACTIF">INACTIF</option>
									</select>
								</div>
							</div>
							<div class="col-lg-3">
								<div class="form-group">
									<label>Tarif HT</label>
									<input id="tarif" name="tarif" class="form-control" value="0" type="number">
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-lg-6">
								<div class="form-group">
									<label for="">Adresse de Facturation</label>
									<textarea name="adresse" id="adresse" cols="32" rows="5" style="margin-top: 5px">
								</textarea>
								</div>
							</div>
							<div class="col-lg-6">
								<div class="form-group">
									<label>A Facturer</label><br>
									<div class="row form-group">
										<div class="col-lg-6">ADMIN</div>
										<input class=" col-lg-3" type="checkbox" value="ADMIN" id="admin" name="admin">
									</div>
									<div class="row form-group" style="margin-top: -15px">
										<div class="col-lg-6">BUSINESS</div>
										<input class=" col-lg-3" type="checkbox" value="BUSINESS" id="business" name="business">
									</div>
									<div class="row form-group" style="margin-top: -15px">
										<div class="col-lg-6">CARTE</div>
										<input class=" col-lg-3" type="checkbox" value="CARTE" id="carte" name="carte">

									</div>
									<div class="row form-group" style="margin-top: -15px">
										<div class="col-lg-6">FIRST</div>
										<input class=" col-lg-3" type="checkbox" value="FIRST" id="first" name="first">
									</div>
									<div class="row form-group" style="margin-top: -15px">
										<div class="col-lg-6">INVITATION</div>
										<input class=" col-lg-3" type="checkbox" value="INVITATION" id="invitation" name="invitation">';
									</div>
									<div class="row form-group" style="margin-top: -15px">
										<div class="col-lg-6">PAYANT</div>
										<input class=" col-lg-3" type="checkbox" value="PAYANT" id="payant" name="payant">
									</div>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-lg-12">
								<label for="">Contact Telephone</label>
							</div>
						</div>
						<div class="col-lg-6">
							<div class="form-group" style="margin-left:10px;">
								<label for="">Prenom & Nom</label>
								<input name="contactNom[]" class="form-control" value="">
							</div>
						</div>
						<div class="col-lg-6">
							<div class="form-group" style="margin-left:10px;">
								<label for="">Prenom & Nom</label>
								<input name="contactNom[]" class="form-control" value="">
							</div>
						</div>
						<div class="col-lg-6">
							<div class="form-group" style="margin-left:10px;">
								<label for="">Telephone</label>
								<input name="contactTel[]" class="form-control" value="">
							</div>
						</div>
						<div class="col-lg-6">
							<div class="form-group" style="margin-left:10px;">
								<label for="">Telephone</label>
								<input name="contactTel[]" class="form-control" value="">
							</div>
						</div>
						<div class="row">
							<div class="col-lg-12">
								<label for="">Contact Mail</label>
							</div>
						</div>

						<div class="row" style="margin-left:1px;">
							<div class="col-lg-6">
								<div class="form-group" style="margin-left:10px;">
									<label for="">Mail</label>
									<input name="contactMail[]" class="form-control" value="">
								</div>
							</div>
							<div class="col-lg-6">
								<div class="form-group" style="margin-left:10px;">
									<label for="">Mail</label>
									<input name="contactMail[]" class="form-control" value="">
								</div>
							</div>
						</div>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-default" data-dismiss="modal" id="annuler">Annuler</button>
						<button type="submit" name="ajouterParam" class="btn btn-primary" id="ajouterParam">Enregistrer</button>
					</div>
				</div>
			</form>
		</div>
	</div>

	<!-- end ajout paramtre -->



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
	<script>
		$("#addParam").click(function() {
			$('#addModal').modal('show');
		})
	</script>
	<style>
		.lab {
			font-weight: normal;
			font-size: 12px;
		}
	</style>

	</body>

	</html>