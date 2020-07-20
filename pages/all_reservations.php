<?php
require_once('header.php');
//Include database connection details
require_once('includes/connection.php');

require_once __DIR__ . '/../vendor/autoload.php';

// include '../vendor/autoload.php';
?>
<?php
if (isset($_POST['confirmerdeletereser'])) {
	$idreservation = $_POST['confirmerdeletereser'];
	$motif = $_POST['motif'];
	$qrydel = "UPDATE  reservation  SET `statut` = '3', `motif_annulation` = '$motif' where id  = $idreservation";
	$resultqrydel = mysqli_query($bd, $qrydel);
	// while($rowdel){

	// }
}
?>

<!--?php
$searchValue = file_get_contents('search.txt');
?-->
<div class="se-pre-con">
	<div style="height:20%">
	</div>
	<div width="100%">
		<img width="250px" src="../img/INFINITE-LOGO.png">
	</div>
	<div width="100%">
		<a class="navbar-brand" style="width:100%;color:#e6d5b7">Merci de patienter pendant le chargement de la page</a>
	</div>
</div>
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
<!-- alert search submit -->
<div class="modal fade" id="searchByModal" role="dialog">
	<div class="modal-dialog">

		<!-- Modal content-->
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">&times;</button>
			</div>
			<div class="modal-body">
				<div class="alert alert-success">
					Svp veulliez saisir une critére de recherche.
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
	$annee = array('Année', '2017', '2018', '2019', '2020', '2021', '2022', '2023', '2024', '2025', '2026', '2027', '2028', '2029', '2030');
	$monthArray = array('Mois', '01', '02', '03', '04', '05', '06', '07', '08', '09', '10', '11', '12');
	$jourArray = array('Jour', '01', '02', '03', '04', '05', '06', '07', '08', '09', '10', '11', '12', '13', '14', '15', '16', '17', '18', '19', '20', '21', '22', '23', '24', '25', '26', '27', '28', '29', '30', '31');
	function multiexplode($delimiters, $string)
	{
		$ready = str_replace($delimiters, $delimiters[0], $string);
		$launch = explode($delimiters[0], $ready);
		return  $launch;
	}
	//Create query
	$todayFile = 'Liste des reservations ' . date("Y-m-d H-i-s");

	$today = date("Y-m-d");
	$lastMonth = date("Y-m-d", strtotime("-1 months"));

	if (!isset($_POST['searchSubmit']) && !isset($_GET['currentpage'])) {
		$filename = 'search_' . $_SESSION['SESS_FIRST_NAME'] . '_' . $_SESSION['SESS_LAST_NAME'] . '.txt';
		file_put_contents($filename, '');
		$searchValue = file_get_contents($filename);
		$filenamesearchCritere = 'searchcritere_' . $_SESSION['SESS_FIRST_NAME'] . '_' . $_SESSION['SESS_LAST_NAME'] . '.txt';
		file_put_contents($filenamesearchCritere, '');
		$searchcritereValue = file_get_contents($filenamesearchCritere);
		$filenameJour = 'searchValueJour_' . $_SESSION['SESS_FIRST_NAME'] . '_' . $_SESSION['SESS_LAST_NAME'] . '.txt';
		$filenameMois = 'searchValueMois_' . $_SESSION['SESS_FIRST_NAME'] . '_' . $_SESSION['SESS_LAST_NAME'] . '.txt';
		$filenameAnnee = 'searchValueAnnee_' . $_SESSION['SESS_FIRST_NAME'] . '_' . $_SESSION['SESS_LAST_NAME'] . '.txt';
		file_put_contents($filenameJour, 'Jour');
		file_put_contents($filenameMois, 'Mois');
		file_put_contents($filenameAnnee, 'Année');
		$searchValueJour = file_get_contents($filenameJour);
		$searchValueMois = file_get_contents($filenameMois);
		$searchValueAnnee = file_get_contents($filenameAnnee);
	} elseif (isset($_POST['searchSubmit'])) {
		$filename = 'search_' . $_SESSION['SESS_FIRST_NAME'] . '_' . $_SESSION['SESS_LAST_NAME'] . '.txt';
		$searchValue = file_get_contents($filename);
		$filenamesearchCritere = 'searchcritere_' . $_SESSION['SESS_FIRST_NAME'] . '_' . $_SESSION['SESS_LAST_NAME'] . '.txt';
		$searchcritereValue = file_get_contents($filenamesearchCritere);
		$filenameJour = 'searchValueJour_' . $_SESSION['SESS_FIRST_NAME'] . '_' . $_SESSION['SESS_LAST_NAME'] . '.txt';
		$filenameMois = 'searchValueMois_' . $_SESSION['SESS_FIRST_NAME'] . '_' . $_SESSION['SESS_LAST_NAME'] . '.txt';
		$filenameAnnee = 'searchValueAnnee_' . $_SESSION['SESS_FIRST_NAME'] . '_' . $_SESSION['SESS_LAST_NAME'] . '.txt';
		$searchValueJour = file_get_contents($filenameJour);
		$searchValueMois = file_get_contents($filenameMois);
		$searchValueAnnee = file_get_contents($filenameAnnee);
	} else {
		$filename = 'search_' . $_SESSION['SESS_FIRST_NAME'] . '_' . $_SESSION['SESS_LAST_NAME'] . '.txt';
		$searchValue = file_get_contents($filename);
		$filenamesearchCritere = 'searchcritere_' . $_SESSION['SESS_FIRST_NAME'] . '_' . $_SESSION['SESS_LAST_NAME'] . '.txt';
		$searchcritereValue = file_get_contents($filenamesearchCritere);
		$filenameJour = 'searchValueJour_' . $_SESSION['SESS_FIRST_NAME'] . '_' . $_SESSION['SESS_LAST_NAME'] . '.txt';
		$filenameMois = 'searchValueMois_' . $_SESSION['SESS_FIRST_NAME'] . '_' . $_SESSION['SESS_LAST_NAME'] . '.txt';
		$filenameAnnee = 'searchValueAnnee_' . $_SESSION['SESS_FIRST_NAME'] . '_' . $_SESSION['SESS_LAST_NAME'] . '.txt';
		$searchValueJour = file_get_contents($filenameJour);
		$searchValueMois = file_get_contents($filenameMois);
		$searchValueAnnee = file_get_contents($filenameAnnee);
	}
	// if (isset($_POST['searchSubmit'])) {

	// }


	$limit = 10;
	$sqlTotalRser = "SELECT COUNT(*) FROM reservation ";
	$resultTotalRser = mysqli_query($bd, $sqlTotalRser);
	$values = mysqli_fetch_row($resultTotalRser);
	$nbReservations = $values[0];
	// le nombre de pages dans la liste des reservations
	if ($searchValue != '') {
		$filenameTotalpage = 'totalpage_' . $_SESSION['SESS_FIRST_NAME'] . '_' . $_SESSION['SESS_LAST_NAME'] . '.txt';
		$nbReservations = 	file_get_contents($filenameTotalpage);
	}
	$filenameTotalpage = 'totalpage_' . $_SESSION['SESS_FIRST_NAME'] . '_' . $_SESSION['SESS_LAST_NAME'] . '.txt';
	file_put_contents($filenameTotalpage, $nbReservations);
	$nbReservations = 	file_get_contents($filenameTotalpage);
	$totalpages = ceil($nbReservations / $limit);
	if (isset($_GET['currentpage']) && is_numeric($_GET['currentpage'])) {
		$currentpage = (int) $_GET['currentpage'];
	} else {
		$currentpage = 1;
	} // end if
	if ($currentpage > $totalpages) {
		$currentpage = $totalpages;
	} // end if
	if ($currentpage < 1) {
		$currentpage = 1;
	} // end if

	$offset = ($currentpage - 1) * $limit;
	if (isset($_POST['searchSubmit'])) {
		$critereSearch = $_POST['searchBy'];
		$key = $_POST['search'];
		$filename = 'search_' . $_SESSION['SESS_FIRST_NAME'] . '_' . $_SESSION['SESS_LAST_NAME'] . '.txt';
		$key = mb_strtoupper($key);
		file_put_contents($filename, $key);
		$searchValue = file_get_contents($filename);
		$filenamecritereSearch = 'searchcritere_' . $_SESSION['SESS_FIRST_NAME'] . '_' . $_SESSION['SESS_LAST_NAME'] . '.txt';
		file_put_contents($filenamecritereSearch, $critereSearch);
		$searchcritereValue = file_get_contents($filenamecritereSearch);
		$filenameJour = 'searchValueJour_' . $_SESSION['SESS_FIRST_NAME'] . '_' . $_SESSION['SESS_LAST_NAME'] . '.txt';
		$filenameMois = 'searchValueMois_' . $_SESSION['SESS_FIRST_NAME'] . '_' . $_SESSION['SESS_LAST_NAME'] . '.txt';
		$filenameAnnee = 'searchValueAnnee_' . $_SESSION['SESS_FIRST_NAME'] . '_' . $_SESSION['SESS_LAST_NAME'] . '.txt';
		$searchValueJour = $_POST['jour'];
		$searchValueMois = $_POST['mois'];
		$searchValueAnnee = $_POST['annee'];
		file_put_contents($filenameJour, $searchValueJour);
		file_put_contents($filenameMois, $searchValueMois);
		file_put_contents($filenameAnnee, $searchValueAnnee);
		$searchValueJour = file_get_contents($filenameJour);
		$searchValueMois = file_get_contents($filenameMois);
		$searchValueAnnee = file_get_contents($filenameAnnee);

		if ($searchValueJour == 'Jour')
			$searchValueJour = '';

		// if ($critereSearch == '0') {
		if ($searchValue != '') {
			if ($searchcritereValue == 'nom') {
				if ($searchValueJour != 'Jour' && $searchValueMois != 'Mois' && $searchValueAnnee != 'Année') {
					$dateS = $searchValueAnnee . '-' . $searchValueMois . '-' . $searchValueJour;
					$searchClient = "SELECT c.`id` FROM `client` c where c.`nom` LIKE  '%$searchValue%'";
					$resultsearchClient = mysqli_query($bd, $searchClient);
					// $list = mysqli_fetch_array($resultsearchClient, MYSQLI_BOTH);
					// $list = implode(' ,',  $list);
					$in_list = array();
					while ($srch = mysqli_fetch_array($resultsearchClient, MYSQLI_BOTH)) {
						foreach ($srch as $sr) {
							$key = $sr;
							$in_list[$key] = array('id' => $sr);
						}
					}
					$keys = implode(', ', array_keys($in_list));
					if (!empty($keys)) {
						$sqlTotalRserSearch = "SELECT COUNT(*) FROM `reservation` r where r.`id_client` in ($keys) AND r.`date` LIKE '%$dateS%'";
					}
				} else {
					$searchClient = "SELECT c.`id` FROM `client` c where c.`nom` LIKE  '%$searchValue%'";
					$resultsearchClient = mysqli_query($bd, $searchClient);
					// $list = mysqli_fetch_array($resultsearchClient, MYSQLI_BOTH);
					// $list = implode(' ,',  $list);
					$in_list = array();
					while ($srch = mysqli_fetch_array($resultsearchClient, MYSQLI_BOTH)) {
						foreach ($srch as $sr) {
							$key = $sr;
							$in_list[$key] = array('id' => $sr);
						}
					}
					$keys = implode(', ', array_keys($in_list));
					if (!empty($keys)) {
						$sqlTotalRserSearch = "SELECT COUNT(*) FROM `reservation` r where r.`id_client` in ($keys) ";
					}
				}
			} elseif ($searchcritereValue == 'prenom') {
				if ($searchValueJour != 'Jour' && $searchValueMois != 'Mois' && $searchValueAnnee != 'Année') {
					$dateS = $searchValueAnnee . '-' . $searchValueMois . '-' . $searchValueJour;
					$searchClient = "SELECT c.`id` FROM `client` c where c.`prenom` LIKE  '%$searchValue%'";
					$resultsearchClient = mysqli_query($bd, $searchClient);
					// $list = mysqli_fetch_array($resultsearchClient, MYSQLI_BOTH);
					// $list = implode(' ,',  $list);
					$in_list = array();
					while ($srch = mysqli_fetch_array($resultsearchClient, MYSQLI_BOTH)) {
						foreach ($srch as $sr) {
							$key = $sr;
							$in_list[$key] = array('id' => $sr);
						}
					}
					$keys = implode(', ', array_keys($in_list));
					if (!empty($keys)) {
						$sqlTotalRserSearch = "SELECT COUNT(*) FROM `reservation` r where r.`id_client` in ($keys) AND r.`date` LIKE '%$dateS%'";
					}
				} else {
					$searchClient = "SELECT c.`id` FROM `client` c where c.`prenom` LIKE  '%$searchValue%'";
					$resultsearchClient = mysqli_query($bd, $searchClient);
					// $list = mysqli_fetch_array($resultsearchClient, MYSQLI_BOTH);
					// $list = implode(' ,',  $list);
					$in_list = array();
					while ($srch = mysqli_fetch_array($resultsearchClient, MYSQLI_BOTH)) {
						foreach ($srch as $sr) {
							$key = $sr;
							$in_list[$key] = array('id' => $sr);
						}
					}
					$keys = implode(', ', array_keys($in_list));
					if (!empty($keys)) {
						$sqlTotalRserSearch = "SELECT COUNT(*) FROM `reservation` r where r.`id_client` in ($keys) ";
					}
				}
			} elseif ($searchcritereValue == 'compagnie') {
				if ($searchValueJour != 'Jour' && $searchValueMois != 'Mois' && $searchValueAnnee != 'Année') {
					$dateS = $searchValueAnnee . '-' . $searchValueMois . '-' . $searchValueJour;
					$sqlTotalRserSearch = "SELECT COUNT(*) FROM `reservation` r where r.`compagnie` LIKE  '%$searchValue%' AND r.`date` LIKE '%$dateS%'";
				} else {
					$sqlTotalRserSearch = "SELECT COUNT(*) FROM `reservation` r where r.`compagnie` LIKE  '%$searchValue%'";
				}
			} elseif ($searchcritereValue == 'numerobillet') {
				if ($searchValueJour != 'Jour' && $searchValueMois != 'Mois' && $searchValueAnnee != 'Année') {
					$dateS = $searchValueAnnee . '-' . $searchValueMois . '-' . $searchValueJour;
					$sqlTotalRserSearch = "SELECT COUNT(*) FROM `reservation` r where r.`porte` LIKE  '%$searchValue%' AND r.`date` LIKE '%$dateS%'";
				} else {
					$sqlTotalRserSearch = "SELECT COUNT(*) FROM `reservation` r where r.`porte` LIKE  '%$searchValue%'";
				}
			} elseif ($searchcritereValue == 'date') {
				if ($searchValueJour != 'Jour' && $searchValueMois != 'Mois' && $searchValueAnnee != 'Année') {
					$dateS = $searchValueAnnee . '-' . $searchValueMois . '-' . $searchValueJour;
					$sqlTotalRserSearch = "SELECT COUNT(*) FROM `reservation` r where r.`date` LIKE  '%$dateS%'";
				} else {
					$sqlTotalRserSearch = "SELECT COUNT(*) FROM `reservation` r where r.`date` LIKE  '%$searchValue%'";
				}
			} elseif ($searchcritereValue == 'carte') {
				if ($searchValueJour != 'Jour' && $searchValueMois != 'Mois' && $searchValueAnnee != 'Année') {
					$dateS = $searchValueAnnee . '-' . $searchValueMois . '-' . $searchValueJour;
					$sqlTotalRserSearch = "SELECT COUNT(*) FROM `reservation` r where r.`carte` LIKE  '%$searchValue%' AND r.`date` LIKE '%$dateS%'";
				} else {
					$sqlTotalRserSearch = "SELECT COUNT(*) FROM `reservation` r where r.`carte` LIKE  '%$searchValue%'";
				}
			} elseif ($searchcritereValue == 'vol') {
				if ($searchValueJour != 'Jour' && $searchValueMois != 'Mois' && $searchValueAnnee != 'Année') {
					$dateS = $searchValueAnnee . '-' . $searchValueMois . '-' . $searchValueJour;
					$sqlTotalRserSearch = "SELECT COUNT(*) FROM `reservation` r where r.`vol` LIKE  '%$searchValue%' AND r.`date` LIKE '%$dateS%'";
				} else {
					$sqlTotalRserSearch = "SELECT COUNT(*) FROM `reservation` r where r.`vol` LIKE  '%$searchValue%'";
				}
			} elseif ($searchcritereValue == 'salon') {
				if ($searchValueJour != 'Jour' && $searchValueMois != 'Mois' && $searchValueAnnee != 'Année') {
					$dateS = $searchValueAnnee . '-' . $searchValueMois . '-' . $searchValueJour;
					$searchSalon = "SELECT s.`id` FROM `salon` s where s.`nom` LIKE  '%$searchValue%'";
					$resultsearchSalon = mysqli_query($bd, $searchSalon);
					while ($searchSalonRow = mysqli_fetch_array($resultsearchSalon, MYSQLI_BOTH)) {
						$idSalon = $searchSalonRow[0];
					}
					if ($idSalon) {
						$sqlTotalRserSearch = "SELECT COUNT(*) FROM `reservation` r where r.`salon` = '$idSalon' AND r.`date` LIKE '%$dateS%'";
					}
				} else {
					$searchSalon = "SELECT s.`id` FROM `salon` s where s.`nom` LIKE  '%$searchValue%'";
					$resultsearchSalon = mysqli_query($bd, $searchSalon);
					while ($searchSalonRow = mysqli_fetch_array($resultsearchSalon, MYSQLI_BOTH)) {
						$idSalon = $searchSalonRow[0];
					}
					if ($idSalon) {
						$sqlTotalRserSearch = "SELECT COUNT(*) FROM `reservation` r where r.`salon` = '$idSalon' ";
					}
				}
			} elseif ($searchcritereValue == 'categorie') {
				if ($searchValueJour != 'Jour' && $searchValueMois != 'Mois' && $searchValueAnnee != 'Année') {
					$dateS = $searchValueAnnee . '-' . $searchValueMois . '-' . $searchValueJour;
					$searchCategorie = "SELECT o.`id` FROM `origine` o where o.`nom` LIKE  '%$searchValue%'";
					$resultsearchCategorie = mysqli_query($bd, $searchCategorie);
					while ($searchCategorieRow = mysqli_fetch_array($resultsearchCategorie, MYSQLI_BOTH)) {
						$idCategorie = $searchCategorieRow[0];
					}
					if ($idCategorie) {
						$sqlTotalRserSearch = "SELECT COUNT(*) FROM `reservation` r where r.`id_origine` = '$idCategorie' AND r.`date` LIKE '%$dateS%' ";
					}
				} else {
					$searchCategorie = "SELECT o.`id` FROM `origine` o where o.`nom` LIKE  '%$searchValue%'";
					$resultsearchCategorie = mysqli_query($bd, $searchCategorie);
					while ($searchCategorieRow = mysqli_fetch_array($resultsearchCategorie, MYSQLI_BOTH)) {
						$idCategorie = $searchCategorieRow[0];
					}
					if ($idCategorie) {
						$sqlTotalRserSearch = "SELECT COUNT(*) FROM `reservation` r where r.`id_origine` = '$idCategorie' ";
					}
				}
			} else {
				if ($searchValueJour != 'Jour' && $searchValueMois != 'Mois' && $searchValueAnnee != 'Année') {
					$dateS = $searchValueAnnee . '-' . $searchValueMois . '-' . $searchValueJour;
					$sqlTotalRserSearch = "SELECT COUNT(*) FROM `reservation` r WHERE r.`date` LIKE '%$dateS%'";
				} else {
					$sqlTotalRserSearch = "SELECT COUNT(*) FROM `reservation` r";
				}
			}
		} else {
			if ($searchValueMois != 'Mois' && $searchValueAnnee != 'Année') {
				$dateS = $searchValueAnnee . '-' . $searchValueMois;
				$sqlTotalRserSearch = "SELECT COUNT(*) FROM `reservation` r WHERE r.`date` LIKE '%$dateS%'";
			} else {
				$sqlTotalRserSearch = "SELECT COUNT(*) FROM `reservation` r";
			}
		}

		$resultTotalRserSearch = mysqli_query($bd, $sqlTotalRserSearch);
		$values = mysqli_fetch_row($resultTotalRserSearch);
		$nbReservations = $values[0];
		$filenameTotalpage = 'totalpage_' . $_SESSION['SESS_FIRST_NAME'] . '_' . $_SESSION['SESS_LAST_NAME'] . '.txt';
		file_put_contents($filenameTotalpage, $nbReservations);
		//file_put_contents($filenameTotalpage, $sqlTotalRserSearch);
		$nbReservations = 	file_get_contents($filenameTotalpage);
		$limit = 10;
		$totalpages = ceil($nbReservations / $limit);
		if (isset($_GET['currentpage']) && is_numeric($_GET['currentpage'])) {
			$currentpage = (int) $_GET['currentpage'];
		} else {
			$currentpage = 1;
		}
		if ($currentpage > $totalpages) {
			$currentpage = $totalpages;
		}
		if ($currentpage < 1) {
			$currentpage = 1;
		}
		if ($searchValue == '' || $searchcritereValue == '') {
			if ($searchValueJour != 'Jour' && $searchValueMois != 'Mois' && $searchValueAnnee != 'Année') {
				$dateS = $searchValueAnnee . '-' . $searchValueMois . '-' . $searchValueJour;
				$offset = ($currentpage - 1) * $limit;
				$qry = "SELECT date, t.nom, c.nom, c.prenom,  r.vol, compagnie, porte, s.nom, o.nom, r.date_validation, s.id, r.id, id_client, sl.nom, salon, r.date_ajout, carte, ag.nom , r.id ";
				$qry .= "FROM `reservation` r, tranche t, client c, statut s, origine o, salon sl, age ag ";
				$qry .= "where r.`date` LIKE '%$dateS%' and r.`id_client` = c.id and r.`statut` = s.id and r.`id_tranche` = t.id and r.id_origine = o.id and sl.id = salon and r.`statut` <> '3' and ag.id = r.id_age ";
				$qry .= "ORDER BY r.`date_ajout` DESC LIMIT $offset, $limit";
				$result = mysqli_query($bd, $qry);
			} else {
				$offset = ($currentpage - 1) * $limit;
				$qry = "SELECT date, t.nom, c.nom, c.prenom,  r.vol, compagnie, porte, s.nom, o.nom, r.date_validation, s.id, r.id, id_client, sl.nom, salon, r.date_ajout, carte, ag.nom , r.id ";
				$qry .= "FROM `reservation` r, tranche t, client c, statut s, origine o, salon sl, age ag ";
				$qry .= "where r.`id_client` = c.id and r.`statut` = s.id and r.`id_tranche` = t.id and r.id_origine = o.id and sl.id = salon and r.`statut` <> '3' and ag.id = r.id_age ";
				$qry .= "ORDER BY r.`date_ajout` DESC LIMIT $offset, $limit";
				$result = mysqli_query($bd, $qry);
			}
		} else {
			$offset = ($currentpage - 1) * $limit;
			if ($searchcritereValue == 'nom') {
				if ($searchValueJour != 'Jour' && $searchValueMois != 'Mois' && $searchValueAnnee != 'Année') {
					$dateS = $searchValueAnnee . '-' . $searchValueMois . '-' . $searchValueJour;
					$searchClient = "SELECT c.`id` FROM `client` c where c.`nom` LIKE  '%$searchValue%'";
					$resultsearchClient = mysqli_query($bd, $searchClient);
					$in_list = array();
					while ($srch = mysqli_fetch_array($resultsearchClient, MYSQLI_BOTH)) {
						foreach ($srch as $sr) {
							$key = $sr;
							$in_list[$key] = array('id' => $sr);
						}
					}
					$keys = implode(', ', array_keys($in_list));

					if (!empty($keys)) {
						$qry = "SELECT date, t.nom, c.nom, c.prenom,  r.vol, compagnie, porte, s.nom, o.nom, r.date_validation, s.id, r.id, id_client, sl.nom, salon, r.date_ajout, carte, ag.nom , r.id ";
						$qry .= "FROM `reservation` r, tranche t, client c, statut s, origine o, salon sl, age ag ";
						$qry .= "where r.`id_client` IN ($keys) and r.`date` LIKE '%$dateS%' and r.`id_client` = c.id and r.`statut` = s.id and r.`id_tranche` = t.id and r.id_origine = o.id and sl.id = salon and r.`statut` <> '3' and ag.id = r.id_age ";
						$qry .= "ORDER BY r.`date_ajout` DESC LIMIT $offset, $limit";
						$result = mysqli_query($bd, $qry);
					}
				} else {
					$searchClient = "SELECT c.`id` FROM `client` c where c.`nom` LIKE  '%$searchValue%'";
					$resultsearchClient = mysqli_query($bd, $searchClient);
					$in_list = array();
					while ($srch = mysqli_fetch_array($resultsearchClient, MYSQLI_BOTH)) {
						foreach ($srch as $sr) {
							$key = $sr;
							$in_list[$key] = array('id' => $sr);
						}
					}
					$keys = implode(', ', array_keys($in_list));

					if (!empty($keys)) {
						$qry = "SELECT date, t.nom, c.nom, c.prenom,  r.vol, compagnie, porte, s.nom, o.nom, r.date_validation, s.id, r.id, id_client, sl.nom, salon, r.date_ajout, carte, ag.nom , r.id ";
						$qry .= "FROM `reservation` r, tranche t, client c, statut s, origine o, salon sl, age ag ";
						$qry .= "where r.`id_client` IN ($keys) and r.`id_client` = c.id and r.`statut` = s.id and r.`id_tranche` = t.id and r.id_origine = o.id and sl.id = salon and r.`statut` <> '3' and ag.id = r.id_age ";
						$qry .= "ORDER BY r.`date_ajout` DESC LIMIT $offset, $limit";
						$result = mysqli_query($bd, $qry);
					}
				}
			} elseif ($searchcritereValue == 'prenom') {
				if ($searchValueJour != 'Jour' && $searchValueMois != 'Mois' && $searchValueAnnee != 'Année') {
					$dateS = $searchValueAnnee . '-' . $searchValueMois . '-' . $searchValueJour;
					$searchClient = "SELECT c.`id` FROM `client` c where c.`prenom` LIKE  '%$searchValue%'";
					$resultsearchClient = mysqli_query($bd, $searchClient);
					$in_list = array();
					while ($srch = mysqli_fetch_array($resultsearchClient, MYSQLI_BOTH)) {
						foreach ($srch as $sr) {
							$key = $sr;
							$in_list[$key] = array('id' => $sr);
						}
					}
					$keys = implode(', ', array_keys($in_list));
					if (!empty($keys)) {
						$qry = "SELECT date, t.nom, c.nom, c.prenom,  r.vol, compagnie, porte, s.nom, o.nom, r.date_validation, s.id, r.id, id_client, sl.nom, salon, r.date_ajout, carte, ag.nom,  r.id ";
						$qry .= "FROM `reservation` r, tranche t, client c, statut s, origine o, salon sl, age ag ";
						$qry .= "where r.`id_client` in ($keys) and r.`date` LIKE '%$dateS%' and r.`id_client` = c.id and r.`statut` = s.id and r.`id_tranche` = t.id and r.id_origine = o.id and sl.id = salon and r.`statut` <> '3' and ag.id = r.id_age ";
						$qry .= "ORDER BY r.`date_ajout` DESC LIMIT $offset, $limit";
						$result = mysqli_query($bd, $qry);
					}
				} else {
					$searchClient = "SELECT c.`id` FROM `client` c where c.`prenom` LIKE  '%$searchValue%'";
					$resultsearchClient = mysqli_query($bd, $searchClient);
					$in_list = array();
					while ($srch = mysqli_fetch_array($resultsearchClient, MYSQLI_BOTH)) {
						foreach ($srch as $sr) {
							$key = $sr;
							$in_list[$key] = array('id' => $sr);
						}
					}
					$keys = implode(', ', array_keys($in_list));
					if (!empty($keys)) {
						$qry = "SELECT date, t.nom, c.nom, c.prenom,  r.vol, compagnie, porte, s.nom, o.nom, r.date_validation, s.id, r.id, id_client, sl.nom, salon, r.date_ajout, carte, ag.nom,  r.id ";
						$qry .= "FROM `reservation` r, tranche t, client c, statut s, origine o, salon sl, age ag ";
						$qry .= "where r.`id_client` in ($keys) and r.`id_client` = c.id and r.`statut` = s.id and r.`id_tranche` = t.id and r.id_origine = o.id and sl.id = salon and r.`statut` <> '3' and ag.id = r.id_age ";
						$qry .= "ORDER BY r.`date_ajout` DESC LIMIT $offset, $limit";
						$result = mysqli_query($bd, $qry);
					}
				}
			} elseif ($searchcritereValue == 'compagnie') {
				if ($searchValueJour != 'Jour' && $searchValueMois != 'Mois' && $searchValueAnnee != 'Année') {
					$dateS = $searchValueAnnee . '-' . $searchValueMois . '-' . $searchValueJour;
					$qry = "SELECT date, t.nom, c.nom, c.prenom,  r.vol, compagnie, porte, s.nom, o.nom, r.date_validation, s.id, r.id, id_client, sl.nom, salon, r.date_ajout, carte, ag.nom, r.id ";
					$qry .= "FROM `reservation` r, tranche t, client c, statut s, origine o, salon sl, age ag ";
					$qry .= "where r.`compagnie` LIKE  '%$searchValue%' and r.`date` LIKE '%$dateS%' and r.`id_client` = c.id and r.`statut` = s.id and r.`id_tranche` = t.id and r.id_origine = o.id and sl.id = salon and r.`statut` <> '3' and ag.id = r.id_age ";
					$qry .= "ORDER BY r.`date_ajout` DESC LIMIT $offset, $limit";
					$result = mysqli_query($bd, $qry);
				} else {
					$qry = "SELECT date, t.nom, c.nom, c.prenom,  r.vol, compagnie, porte, s.nom, o.nom, r.date_validation, s.id, r.id, id_client, sl.nom, salon, r.date_ajout, carte, ag.nom, r.id ";
					$qry .= "FROM `reservation` r, tranche t, client c, statut s, origine o, salon sl, age ag ";
					$qry .= "where r.`compagnie` LIKE  '%$searchValue%' and r.`id_client` = c.id and r.`statut` = s.id and r.`id_tranche` = t.id and r.id_origine = o.id and sl.id = salon and r.`statut` <> '3' and ag.id = r.id_age ";
					$qry .= "ORDER BY r.`date_ajout` DESC LIMIT $offset, $limit";
					$result = mysqli_query($bd, $qry);
				}
			} elseif ($searchcritereValue == 'vol') {
				if ($searchValueJour != 'Jour' && $searchValueMois != 'Mois' && $searchValueAnnee != 'Année') {
					$dateS = $searchValueAnnee . '-' . $searchValueMois . '-' . $searchValueJour;
					$qry = "SELECT date, t.nom, c.nom, c.prenom,  r.vol, compagnie, porte, s.nom, o.nom, r.date_validation, s.id, r.id, id_client, sl.nom, salon, r.date_ajout, carte, ag.nom , r.id ";
					$qry .= "FROM `reservation` r, tranche t, client c, statut s, origine o, salon sl, age ag ";
					$qry .= "where r.`vol` LIKE  '%$searchValue%' and r.`date` LIKE '%$dateS%' and r.`id_client` = c.id and r.`statut` = s.id and r.`id_tranche` = t.id and r.id_origine = o.id and sl.id = salon and r.`statut` <> '3' and ag.id = r.id_age ";
					$qry .= "ORDER BY r.`date_ajout` DESC LIMIT $offset, $limit";
					$result = mysqli_query($bd, $qry);
				} else {
					$qry = "SELECT date, t.nom, c.nom, c.prenom,  r.vol, compagnie, porte, s.nom, o.nom, r.date_validation, s.id, r.id, id_client, sl.nom, salon, r.date_ajout, carte, ag.nom , r.id ";
					$qry .= "FROM `reservation` r, tranche t, client c, statut s, origine o, salon sl, age ag ";
					$qry .= "where r.`vol` LIKE  '%$searchValue%' and r.`id_client` = c.id and r.`statut` = s.id and r.`id_tranche` = t.id and r.id_origine = o.id and sl.id = salon and r.`statut` <> '3' and ag.id = r.id_age ";
					$qry .= "ORDER BY r.`date_ajout` DESC LIMIT $offset, $limit";
					$result = mysqli_query($bd, $qry);
				}
			} elseif ($searchcritereValue == 'salon') {
				if ($searchValueJour != 'Jour' && $searchValueMois != 'Mois' && $searchValueAnnee != 'Année') {
					$dateS = $searchValueAnnee . '-' . $searchValueMois . '-' . $searchValueJour;
					$searchSalon = "SELECT s.`id` from `salon` s where s.`nom` LIKE  '%$searchValue%'";
					$resultsearchSalon = mysqli_query($bd, $searchSalon);
					while ($searchSalonRow = mysqli_fetch_array($resultsearchSalon, MYSQLI_BOTH)) {
						$idSalon = $searchSalonRow[0];
					}
					if ($idSalon) {
						$qry = "SELECT date, t.nom, c.nom, c.prenom,  r.vol, compagnie, porte, s.nom, o.nom, r.date_validation, s.id, r.id, id_client, sl.nom, salon, r.date_ajout, carte, ag.nom , r.id ";
						$qry .= "FROM `reservation` r, tranche t, client c, statut s, origine o, salon sl, age ag ";
						$qry .= "where r.`salon` = '$idSalon' and r.`date` LIKE '%$dateS%' and r.`id_client` = c.id and r.`statut` = s.id and r.`id_tranche` = t.id and r.id_origine = o.id and sl.id = salon and r.`statut` <> '3' and ag.id = r.id_age ";
						$qry .= "ORDER BY r.`date_ajout` DESC LIMIT $offset, $limit";
						$result = mysqli_query($bd, $qry);
					}
				} else {
					$searchSalon = "SELECT s.`id` from `salon` s where s.`nom` LIKE  '%$searchValue%'";
					$resultsearchSalon = mysqli_query($bd, $searchSalon);
					while ($searchSalonRow = mysqli_fetch_array($resultsearchSalon, MYSQLI_BOTH)) {
						$idSalon = $searchSalonRow[0];
					}
					if ($idSalon) {
						$qry = "SELECT date, t.nom, c.nom, c.prenom,  r.vol, compagnie, porte, s.nom, o.nom, r.date_validation, s.id, r.id, id_client, sl.nom, salon, r.date_ajout, carte, ag.nom , r.id ";
						$qry .= "FROM `reservation` r, tranche t, client c, statut s, origine o, salon sl, age ag ";
						$qry .= "where r.`salon` = '$idSalon' and r.`id_client` = c.id and r.`statut` = s.id and r.`id_tranche` = t.id and r.id_origine = o.id and sl.id = salon and r.`statut` <> '3' and ag.id = r.id_age ";
						$qry .= "ORDER BY r.`date_ajout` DESC LIMIT $offset, $limit";
						$result = mysqli_query($bd, $qry);
					}
				}
			} elseif ($searchcritereValue == "categorie") {
				if ($searchValueJour != 'Jour' && $searchValueMois != 'Mois' && $searchValueAnnee != 'Année') {
					$dateS = $searchValueAnnee . '-' . $searchValueMois . '-' . $searchValueJour;
					$searchCategorie = "SELECT o.`id` from `origine` o where o.`nom` LIKE  '%$searchValue%'";
					$resultsearchCategorie = mysqli_query($bd, $searchCategorie);
					while ($searchCategorieRow = mysqli_fetch_array($resultsearchCategorie, MYSQLI_BOTH)) {
						$idCategorie = $searchCategorieRow[0];
					}
					if ($idCategorie) {
						$qry = "SELECT date, t.nom, c.nom, c.prenom,  r.vol, compagnie, porte, s.nom, o.nom, r.date_validation, s.id, r.id, id_client, sl.nom, salon, r.date_ajout, carte, ag.nom,  r.id ";
						$qry .= "FROM `reservation` r, tranche t, client c, statut s, origine o, salon sl, age ag ";
						$qry .= "where r.`id_origine` = '$idCategorie' and r.`date` LIKE '%$dateS%' and r.`id_client` = c.id and r.`statut` = s.id and r.`id_tranche` = t.id and r.id_origine = o.id and sl.id = salon and r.`statut` <> '3' and ag.id = r.id_age ";
						$qry .= "ORDER BY r.`date_ajout` DESC LIMIT $offset, $limit";
						$result = mysqli_query($bd, $qry);
					}
				} else {
					$searchCategorie = "SELECT o.`id` from `origine` o where o.`nom` LIKE  '%$searchValue%'";
					$resultsearchCategorie = mysqli_query($bd, $searchCategorie);
					while ($searchCategorieRow = mysqli_fetch_array($resultsearchCategorie, MYSQLI_BOTH)) {
						$idCategorie = $searchCategorieRow[0];
					}
					if ($idCategorie) {
						$qry = "SELECT date, t.nom, c.nom, c.prenom,  r.vol, compagnie, porte, s.nom, o.nom, r.date_validation, s.id, r.id, id_client, sl.nom, salon, r.date_ajout, carte, ag.nom,  r.id ";
						$qry .= "FROM `reservation` r, tranche t, client c, statut s, origine o, salon sl, age ag ";
						$qry .= "where r.`id_origine` = '$idCategorie' and r.`id_client` = c.id and r.`statut` = s.id and r.`id_tranche` = t.id and r.id_origine = o.id and sl.id = salon and r.`statut` <> '3' and ag.id = r.id_age ";
						$qry .= "ORDER BY r.`date_ajout` DESC LIMIT $offset, $limit";
						$result = mysqli_query($bd, $qry);
					}
				}
			} elseif ($searchcritereValue == 'numerobillet') {
				if ($searchValueJour != 'Jour' && $searchValueMois != 'Mois' && $searchValueAnnee != 'Année') {
					$dateS = $searchValueAnnee . '-' . $searchValueMois . '-' . $searchValueJour;
					$qry = "SELECT date, t.nom, c.nom, c.prenom,  r.vol, compagnie, porte, s.nom, o.nom, r.date_validation, s.id, r.id, id_client, sl.nom, salon, r.date_ajout, carte, ag.nom,  r.id ";
					$qry .= "FROM `reservation` r, tranche t, client c, statut s, origine o, salon sl, age ag ";
					$qry .= "where r.`porte` LIKE  '%$searchValue%' and r.`date` LIKE '%$dateS%' and r.`id_client` = c.id and r.`statut` = s.id and r.`id_tranche` = t.id and r.id_origine = o.id and sl.id = salon and r.`statut` <> '3' and ag.id = r.id_age ";
					$qry .= "ORDER BY r.`date_ajout` DESC LIMIT $offset, $limit";
					$result = mysqli_query($bd, $qry);
				} else {
					$qry = "SELECT date, t.nom, c.nom, c.prenom,  r.vol, compagnie, porte, s.nom, o.nom, r.date_validation, s.id, r.id, id_client, sl.nom, salon, r.date_ajout, carte, ag.nom,  r.id ";
					$qry .= "FROM `reservation` r, tranche t, client c, statut s, origine o, salon sl, age ag ";
					$qry .= "where r.`porte` LIKE  '%$searchValue%' and r.`id_client` = c.id and r.`statut` = s.id and r.`id_tranche` = t.id and r.id_origine = o.id and sl.id = salon and r.`statut` <> '3' and ag.id = r.id_age ";
					$qry .= "ORDER BY r.`date_ajout` DESC LIMIT $offset, $limit";
					$result = mysqli_query($bd, $qry);
				}
			} elseif ($searchcritereValue == 'date') {
				if ($searchValueJour != 'Jour' && $searchValueMois != 'Mois' && $searchValueAnnee != 'Année') {
					$dateS = $searchValueAnnee . '-' . $searchValueMois . '-' . $searchValueJour;
					$qry = "SELECT date, t.nom, c.nom, c.prenom,  r.vol, compagnie, porte, s.nom, o.nom, r.date_validation, s.id, r.id, id_client, sl.nom, salon, r.date_ajout, carte, ag.nom , r.id ";
					$qry .= "FROM `reservation` r, tranche t, client c, statut s, origine o, salon sl, age ag ";
					$qry .= "where r.`date` LIKE  '%$dateS%' and r.`id_client` = c.id and r.`statut` = s.id and r.`id_tranche` = t.id and r.id_origine = o.id and sl.id = salon and r.`statut` <> '3' and ag.id = r.id_age ";
					$qry .= "ORDER BY r.`date_ajout` DESC LIMIT $offset, $limit";
					$result = mysqli_query($bd, $qry);
				} else {
					$qry = "SELECT date, t.nom, c.nom, c.prenom,  r.vol, compagnie, porte, s.nom, o.nom, r.date_validation, s.id, r.id, id_client, sl.nom, salon, r.date_ajout, carte, ag.nom , r.id ";
					$qry .= "FROM `reservation` r, tranche t, client c, statut s, origine o, salon sl, age ag ";
					$qry .= "where r.`date` LIKE  '%$searchValue%' and r.`id_client` = c.id and r.`statut` = s.id and r.`id_tranche` = t.id and r.id_origine = o.id and sl.id = salon and r.`statut` <> '3' and ag.id = r.id_age ";
					$qry .= "ORDER BY r.`date_ajout` DESC LIMIT $offset, $limit";
					$result = mysqli_query($bd, $qry);
				}
			} elseif ($searchcritereValue == 'carte') {
				if ($searchValueJour != 'Jour' && $searchValueMois != 'Mois' && $searchValueAnnee != 'Année') {
					$dateS = $searchValueAnnee . '-' . $searchValueMois . '-' . $searchValueJour;
					$qry = "SELECT date, t.nom, c.nom, c.prenom,  r.vol, compagnie, porte, s.nom, o.nom, r.date_validation, s.id, r.id, id_client, sl.nom, salon, r.date_ajout, carte, ag.nom , r.id ";
					$qry .= "FROM `reservation` r, tranche t, client c, statut s, origine o, salon sl, age ag ";
					$qry .= "where r.`carte` LIKE  '%$searchValue%' and r.`date` LIKE '%$dateS%' and r.`id_client` = c.id and r.`statut` = s.id and r.`id_tranche` = t.id and r.id_origine = o.id and sl.id = salon and r.`statut` <> '3' and ag.id = r.id_age ";
					$qry .= "ORDER BY r.`date_ajout` DESC LIMIT $offset, $limit";
					$result = mysqli_query($bd, $qry);
				} else {
					$qry = "SELECT date, t.nom, c.nom, c.prenom,  r.vol, compagnie, porte, s.nom, o.nom, r.date_validation, s.id, r.id, id_client, sl.nom, salon, r.date_ajout, carte, ag.nom , r.id ";
					$qry .= "FROM `reservation` r, tranche t, client c, statut s, origine o, salon sl, age ag ";
					$qry .= "where r.`carte` LIKE  '%$searchValue%' and r.`id_client` = c.id and r.`statut` = s.id and r.`id_tranche` = t.id and r.id_origine = o.id and sl.id = salon and r.`statut` <> '3' and ag.id = r.id_age ";
					$qry .= "ORDER BY r.`date_ajout` DESC LIMIT $offset, $limit";
					$result = mysqli_query($bd, $qry);
				}
			} else {
				if ($searchValueJour != 'Jour' && $searchValueMois != 'Mois' && $searchValueAnnee != 'Année') {
					$dateS = $searchValueAnnee . '-' . $searchValueMois . '-' . $searchValueJour;
					$qry = "SELECT date, t.nom, c.nom, c.prenom,  r.vol, compagnie, porte, s.nom, o.nom, r.date_validation, s.id, r.id, id_client, sl.nom, salon, r.date_ajout, carte, ag.nom , r.id ";
					$qry .= "FROM `reservation` r, tranche t, client c, statut s, origine o, salon sl, age ag ";
					$qry .= "where r.`date` LIKE '%$dateS%' and r.`id_client` = c.id and r.`statut` = s.id and r.`id_tranche` = t.id and r.id_origine = o.id and sl.id = salon and r.`statut` <> '3' and ag.id = r.id_age ";
					$qry .= "ORDER BY r.`date_ajout` DESC LIMIT $offset, $limit";
					$result = mysqli_query($bd, $qry);
				} else {
					$qry = "SELECT date, t.nom, c.nom, c.prenom,  r.vol, compagnie, porte, s.nom, o.nom, r.date_validation, s.id, r.id, id_client, sl.nom, salon, r.date_ajout, carte, ag.nom , r.id ";
					$qry .= "FROM `reservation` r, tranche t, client c, statut s, origine o, salon sl, age ag ";
					$qry .= "where r.`id_client` = c.id and r.`statut` = s.id and r.`id_tranche` = t.id and r.id_origine = o.id and sl.id = salon and r.`statut` <> '3' and ag.id = r.id_age ";
					$qry .= "ORDER BY r.`date_ajout` DESC LIMIT $offset, $limit";
					$result = mysqli_query($bd, $qry);
				}
			}
		}
	} else {
		$qry = "SELECT date, t.nom, c.nom, c.prenom,  r.vol, compagnie, porte, s.nom, o.nom, r.date_validation, s.id, r.id, id_client, sl.nom, salon, r.date_ajout, carte, ag.nom , r.id ";
		$qry .= "FROM `reservation` r, tranche t, client c, statut s, origine o, salon sl, age ag ";
		$qry .= "where r.`id_client` = c.id and r.`statut` = s.id and r.`id_tranche` = t.id and r.id_origine = o.id and sl.id = salon and r.`statut` <> '3' and ag.id = r.id_age ";
		$qry .= "ORDER BY r.`date_ajout` DESC LIMIT $offset, $limit";
		$result = mysqli_query($bd, $qry);
	}

	if (isset($_GET['currentpage']) && $searchValue != '') {
		if ($searchcritereValue == 'nom') {
			if ($searchValueJour != 'Jour' && $searchValueMois != 'Mois' && $searchValueAnnee != 'Année') {
				$dateS = $searchValueAnnee . '-' . $searchValueMois . '-' . $searchValueJour;
				$searchClient = "SELECT c.`id` FROM `client` c where c.`nom` LIKE  '%$searchValue%'";
				$resultsearchClient = mysqli_query($bd, $searchClient);
				$in_list = array();
				while ($srch = mysqli_fetch_array($resultsearchClient, MYSQLI_BOTH)) {
					foreach ($srch as $sr) {
						$key = $sr;
						$in_list[$key] = array('id' => $sr);
					}
				}
				$keys = implode(', ', array_keys($in_list));
				if (!empty($keys)) {
					$qry = "SELECT date, t.nom, c.nom, c.prenom,  r.vol, compagnie, porte, s.nom, o.nom, r.date_validation, s.id, r.id, id_client, sl.nom, salon, r.date_ajout, carte, ag.nom, r.id ";
					$qry .= "FROM `reservation` r, tranche t, client c, statut s, origine o, salon sl, age ag ";
					$qry .= "where r.`id_client` IN ($keys) and r.`date` LIKE '%$dateS%' and r.`id_client` = c.id and r.`statut` = s.id and r.`id_tranche` = t.id and r.id_origine = o.id and sl.id = salon and r.`statut` <> '3' and ag.id = r.id_age ";
					$qry .= "ORDER BY r.`date_ajout` DESC LIMIT $offset, $limit";
					$result = mysqli_query($bd, $qry);
				}
			} else {
				$searchClient = "SELECT c.`id` FROM `client` c where c.`nom` LIKE  '%$searchValue%'";
				$resultsearchClient = mysqli_query($bd, $searchClient);
				$in_list = array();
				while ($srch = mysqli_fetch_array($resultsearchClient, MYSQLI_BOTH)) {
					foreach ($srch as $sr) {
						$key = $sr;
						$in_list[$key] = array('id' => $sr);
					}
				}
				$keys = implode(', ', array_keys($in_list));
				if (!empty($keys)) {
					$qry = "SELECT date, t.nom, c.nom, c.prenom,  r.vol, compagnie, porte, s.nom, o.nom, r.date_validation, s.id, r.id, id_client, sl.nom, salon, r.date_ajout, carte, ag.nom, r.id ";
					$qry .= "FROM `reservation` r, tranche t, client c, statut s, origine o, salon sl, age ag ";
					$qry .= "where r.`id_client` IN ($keys) and r.`id_client` = c.id and r.`statut` = s.id and r.`id_tranche` = t.id and r.id_origine = o.id and sl.id = salon and r.`statut` <> '3' and ag.id = r.id_age ";
					$qry .= "ORDER BY r.`date_ajout` DESC LIMIT $offset, $limit";
					$result = mysqli_query($bd, $qry);
				}
			}
		} elseif ($searchcritereValue == 'prenom') {
			if ($searchValueJour != 'Jour' && $searchValueMois != 'Mois' && $searchValueAnnee != 'Année') {
				$dateS = $searchValueAnnee . '-' . $searchValueMois . '-' . $searchValueJour;
				$searchClient = "SELECT c.`id` FROM `client` c where c.`prenom` LIKE  '%$searchValue%'";
				$resultsearchClient = mysqli_query($bd, $searchClient);
				$in_list = array();
				while ($srch = mysqli_fetch_array($resultsearchClient, MYSQLI_BOTH)) {
					foreach ($srch as $sr) {
						$key = $sr;
						$in_list[$key] = array('id' => $sr);
					}
				}
				$keys = implode(', ', array_keys($in_list));
				if (!empty($keys)) {
					$qry = "SELECT date, t.nom, c.nom, c.prenom,  r.vol, compagnie, porte, s.nom, o.nom, r.date_validation, s.id, r.id, id_client, sl.nom, salon, r.date_ajout, carte, ag.nom , r.id ";
					$qry .= "FROM `reservation` r, tranche t, client c, statut s, origine o, salon sl, age ag ";
					$qry .= "where r.`id_client` IN ($keys) and r.`date` LIKE '%$dateS%' and r.`id_client` = c.id and r.`statut` = s.id and r.`id_tranche` = t.id and r.id_origine = o.id and sl.id = salon and r.`statut` <> '3' and ag.id = r.id_age ";
					$qry .= "ORDER BY r.`date_ajout` DESC LIMIT $offset, $limit";
					$result = mysqli_query($bd, $qry);
				}
			} else {
				$searchClient = "SELECT c.`id` FROM `client` c where c.`prenom` LIKE  '%$searchValue%'";
				$resultsearchClient = mysqli_query($bd, $searchClient);
				$in_list = array();
				while ($srch = mysqli_fetch_array($resultsearchClient, MYSQLI_BOTH)) {
					foreach ($srch as $sr) {
						$key = $sr;
						$in_list[$key] = array('id' => $sr);
					}
				}
				$keys = implode(', ', array_keys($in_list));
				if (!empty($keys)) {
					$qry = "SELECT date, t.nom, c.nom, c.prenom,  r.vol, compagnie, porte, s.nom, o.nom, r.date_validation, s.id, r.id, id_client, sl.nom, salon, r.date_ajout, carte, ag.nom , r.id ";
					$qry .= "FROM `reservation` r, tranche t, client c, statut s, origine o, salon sl, age ag ";
					$qry .= "where r.`id_client` IN ($keys) and r.`id_client` = c.id and r.`statut` = s.id and r.`id_tranche` = t.id and r.id_origine = o.id and sl.id = salon and r.`statut` <> '3' and ag.id = r.id_age ";
					$qry .= "ORDER BY r.`date_ajout` DESC LIMIT $offset, $limit";
					$result = mysqli_query($bd, $qry);
				}
			}
		} elseif ($searchcritereValue == 'compagnie') {
			if ($searchValueJour != 'Jour' && $searchValueMois != 'Mois' && $searchValueAnnee != 'Année') {
				$dateS = $searchValueAnnee . '-' . $searchValueMois . '-' . $searchValueJour;
				$qry = "SELECT date, t.nom, c.nom, c.prenom,  r.vol, compagnie, porte, s.nom, o.nom, r.date_validation, s.id, r.id, id_client, sl.nom, salon, r.date_ajout, carte, ag.nom , r.id ";
				$qry .= "FROM `reservation` r, tranche t, client c, statut s, origine o, salon sl, age ag ";
				$qry .= "where r.`compagnie` LIKE  '%$searchValue%' and r.`date` LIKE '%$dateS%' and r.`id_client` = c.id and r.`statut` = s.id and r.`id_tranche` = t.id and r.id_origine = o.id and sl.id = salon and r.`statut` <> '3' and ag.id = r.id_age ";
				$qry .= "ORDER BY r.`date_ajout` DESC LIMIT $offset, $limit";
				$result = mysqli_query($bd, $qry);
			} else {
				$qry = "SELECT date, t.nom, c.nom, c.prenom,  r.vol, compagnie, porte, s.nom, o.nom, r.date_validation, s.id, r.id, id_client, sl.nom, salon, r.date_ajout, carte, ag.nom , r.id ";
				$qry .= "FROM `reservation` r, tranche t, client c, statut s, origine o, salon sl, age ag ";
				$qry .= "where r.`compagnie` LIKE  '%$searchValue%' and r.`id_client` = c.id and r.`statut` = s.id and r.`id_tranche` = t.id and r.id_origine = o.id and sl.id = salon and r.`statut` <> '3' and ag.id = r.id_age ";
				$qry .= "ORDER BY r.`date_ajout` DESC LIMIT $offset, $limit";
				$result = mysqli_query($bd, $qry);
			}
		} elseif ($searchcritereValue == 'vol') {
			if ($searchValueJour != 'Jour' && $searchValueMois != 'Mois' && $searchValueAnnee != 'Année') {
				$dateS = $searchValueAnnee . '-' . $searchValueMois . '-' . $searchValueJour;
				$qry = "SELECT date, t.nom, c.nom, c.prenom,  r.vol, compagnie, porte, s.nom, o.nom, r.date_validation, s.id, r.id, id_client, sl.nom, salon, r.date_ajout, carte, ag.nom ,  r.id ";
				$qry .= "FROM `reservation` r, tranche t, client c, statut s, origine o, salon sl, age ag ";
				$qry .= "where r.`vol` LIKE  '%$searchValue%'  and r.`date` LIKE '%$dateS%' and r.`id_client` = c.id and r.`statut` = s.id and r.`id_tranche` = t.id and r.id_origine = o.id and sl.id = salon and r.`statut` <> '3' and ag.id = r.id_age ";
				$qry .= "ORDER BY r.`date_ajout` DESC LIMIT $offset, $limit";
				$result = mysqli_query($bd, $qry);
			} else {
				$qry = "SELECT date, t.nom, c.nom, c.prenom,  r.vol, compagnie, porte, s.nom, o.nom, r.date_validation, s.id, r.id, id_client, sl.nom, salon, r.date_ajout, carte, ag.nom ,  r.id ";
				$qry .= "FROM `reservation` r, tranche t, client c, statut s, origine o, salon sl, age ag ";
				$qry .= "where r.`vol` LIKE  '%$searchValue%' and r.`id_client` = c.id and r.`statut` = s.id and r.`id_tranche` = t.id and r.id_origine = o.id and sl.id = salon and r.`statut` <> '3' and ag.id = r.id_age ";
				$qry .= "ORDER BY r.`date_ajout` DESC LIMIT $offset, $limit";
				$result = mysqli_query($bd, $qry);
			}
		} elseif ($searchcritereValue == 'salon') {
			if ($searchValueJour != 'Jour' && $searchValueMois != 'Mois' && $searchValueAnnee != 'Année') {
				$dateS = $searchValueAnnee . '-' . $searchValueMois . '-' . $searchValueJour;
				$searchSalon = "SELECT s.`id` from `salon` s where s.`nom` LIKE  '%$searchValue%'";
				$resultsearchSalon = mysqli_query($bd, $searchSalon);
				while ($searchSalonRow = mysqli_fetch_array($resultsearchSalon, MYSQLI_BOTH)) {
					$idSalon = $searchSalonRow[0];
				}
				if ($idSalon) {
					$qry = "SELECT date, t.nom, c.nom, c.prenom,  r.vol, compagnie, porte, s.nom, o.nom, r.date_validation, s.id, r.id, id_client, sl.nom, salon, r.date_ajout, carte, ag.nom,  r.id ";
					$qry .= "FROM `reservation` r, tranche t, client c, statut s, origine o, salon sl, age ag ";
					$qry .= "where r.`salon` = '$idSalon' and r.`date` LIKE '%$dateS%' and r.`id_client` = c.id and r.`statut` = s.id and r.`id_tranche` = t.id and r.id_origine = o.id and sl.id = salon and r.`statut` <> '3' and ag.id = r.id_age ";
					$qry .= "ORDER BY r.`date_ajout` DESC LIMIT $offset, $limit";
					$result = mysqli_query($bd, $qry);
				}
			} else {
				$searchSalon = "SELECT s.`id` from `salon` s where s.`nom` LIKE  '%$searchValue%'";
				$resultsearchSalon = mysqli_query($bd, $searchSalon);
				while ($searchSalonRow = mysqli_fetch_array($resultsearchSalon, MYSQLI_BOTH)) {
					$idSalon = $searchSalonRow[0];
				}
				if ($idSalon) {
					$qry = "SELECT date, t.nom, c.nom, c.prenom,  r.vol, compagnie, porte, s.nom, o.nom, r.date_validation, s.id, r.id, id_client, sl.nom, salon, r.date_ajout, carte, ag.nom,  r.id ";
					$qry .= "FROM `reservation` r, tranche t, client c, statut s, origine o, salon sl, age ag ";
					$qry .= "where r.`salon` = '$idSalon' and r.`id_client` = c.id and r.`statut` = s.id and r.`id_tranche` = t.id and r.id_origine = o.id and sl.id = salon and r.`statut` <> '3' and ag.id = r.id_age ";
					$qry .= "ORDER BY r.`date_ajout` DESC LIMIT $offset, $limit";
					$result = mysqli_query($bd, $qry);
				}
			}
		} elseif ($searchcritereValue == "categorie") {
			if ($searchValueJour != 'Jour' && $searchValueMois != 'Mois' && $searchValueAnnee != 'Année') {
				$dateS = $searchValueAnnee . '-' . $searchValueMois . '-' . $searchValueJour;
				$searchCategorie = "SELECT o.`id` from `origine` o where o.`nom` LIKE  '%$searchValue%'";
				$resultsearchCategorie = mysqli_query($bd, $searchCategorie);
				while ($searchCategorieRow = mysqli_fetch_array($resultsearchCategorie, MYSQLI_BOTH)) {
					$idCategorie = $searchCategorieRow[0];
				}
				if ($idCategorie) {
					$qry = "SELECT date, t.nom, c.nom, c.prenom,  r.vol, compagnie, porte, s.nom, o.nom, r.date_validation, s.id, r.id, id_client, sl.nom, salon, r.date_ajout, carte, ag.nom,  r.id ";
					$qry .= "FROM `reservation` r, tranche t, client c, statut s, origine o, salon sl, age ag ";
					$qry .= "where r.`id_origine` = '$idCategorie' and r.`date` LIKE '%$dateS%' and r.`id_client` = c.id and r.`statut` = s.id and r.`id_tranche` = t.id and r.id_origine = o.id and sl.id = salon and r.`statut` <> '3' and ag.id = r.id_age ";
					$qry .= "ORDER BY r.`date_ajout` DESC LIMIT $offset, $limit";
					$result = mysqli_query($bd, $qry);
				}
			} else {
				$searchCategorie = "SELECT o.`id` from `origine` o where o.`nom` LIKE  '%$searchValue%'";
				$resultsearchCategorie = mysqli_query($bd, $searchCategorie);
				while ($searchCategorieRow = mysqli_fetch_array($resultsearchCategorie, MYSQLI_BOTH)) {
					$idCategorie = $searchCategorieRow[0];
				}
				if ($idCategorie) {
					$qry = "SELECT date, t.nom, c.nom, c.prenom,  r.vol, compagnie, porte, s.nom, o.nom, r.date_validation, s.id, r.id, id_client, sl.nom, salon, r.date_ajout, carte, ag.nom,  r.id ";
					$qry .= "FROM `reservation` r, tranche t, client c, statut s, origine o, salon sl, age ag ";
					$qry .= "where r.`id_origine` = '$idCategorie' and r.`id_client` = c.id and r.`statut` = s.id and r.`id_tranche` = t.id and r.id_origine = o.id and sl.id = salon and r.`statut` <> '3' and ag.id = r.id_age ";
					$qry .= "ORDER BY r.`date_ajout` DESC LIMIT $offset, $limit";
					$result = mysqli_query($bd, $qry);
				}
			}
		} elseif ($searchcritereValue == 'numerobillet') {
			if ($searchValueJour != 'Jour' && $searchValueMois != 'Mois' && $searchValueAnnee != 'Année') {
				$dateS = $searchValueAnnee . '-' . $searchValueMois . '-' . $searchValueJour;
				$qry = "SELECT date, t.nom, c.nom, c.prenom,  r.vol, compagnie, porte, s.nom, o.nom, r.date_validation, s.id, r.id, id_client, sl.nom, salon, r.date_ajout, carte, ag.nom,  r.id ";
				$qry .= "FROM `reservation` r, tranche t, client c, statut s, origine o, salon sl, age ag ";
				$qry .= "where r.`porte` LIKE  '%$searchValue%' and r.`date` LIKE '%$dateS%' and r.`id_client` = c.id and r.`statut` = s.id and r.`id_tranche` = t.id and r.id_origine = o.id and sl.id = salon and r.`statut` <> '3' and ag.id = r.id_age ";
				$qry .= "ORDER BY r.`date_ajout` DESC LIMIT $offset, $limit";
				$result = mysqli_query($bd, $qry);
			} else {
				$qry = "SELECT date, t.nom, c.nom, c.prenom,  r.vol, compagnie, porte, s.nom, o.nom, r.date_validation, s.id, r.id, id_client, sl.nom, salon, r.date_ajout, carte, ag.nom,  r.id ";
				$qry .= "FROM `reservation` r, tranche t, client c, statut s, origine o, salon sl, age ag ";
				$qry .= "where r.`porte` LIKE  '%$searchValue%' and r.`id_client` = c.id and r.`statut` = s.id and r.`id_tranche` = t.id and r.id_origine = o.id and sl.id = salon and r.`statut` <> '3' and ag.id = r.id_age ";
				$qry .= "ORDER BY r.`date_ajout` DESC LIMIT $offset, $limit";
				$result = mysqli_query($bd, $qry);
			}
		} elseif ($searchcritereValue == 'date') {
			if ($searchValueJour != 'Jour' && $searchValueMois != 'Mois' && $searchValueAnnee != 'Année') {
				$dateS = $searchValueAnnee . '-' . $searchValueMois . '-' . $searchValueJour;
				$qry = "SELECT date, t.nom, c.nom, c.prenom,  r.vol, compagnie, porte, s.nom, o.nom, r.date_validation, s.id, r.id, id_client, sl.nom, salon, r.date_ajout, carte, ag.nom , r.id";
				$qry .= "FROM `reservation` r, tranche t, client c, statut s, origine o, salon sl, age ag ";
				$qry .= "where r.`date` LIKE  '%$dateS%' and r.`id_client` = c.id and r.`statut` = s.id and r.`id_tranche` = t.id and r.id_origine = o.id and sl.id = salon and r.`statut` <> '3' and ag.id = r.id_age ";
				$qry .= "ORDER BY r.`date_ajout` DESC LIMIT $offset, $limit";
				$result = mysqli_query($bd, $qry);
			} else {
				$qry = "SELECT date, t.nom, c.nom, c.prenom,  r.vol, compagnie, porte, s.nom, o.nom, r.date_validation, s.id, r.id, id_client, sl.nom, salon, r.date_ajout, carte, ag.nom , r.id";
				$qry .= "FROM `reservation` r, tranche t, client c, statut s, origine o, salon sl, age ag ";
				$qry .= "where r.`date` LIKE  '%$searchValue%' and r.`id_client` = c.id and r.`statut` = s.id and r.`id_tranche` = t.id and r.id_origine = o.id and sl.id = salon and r.`statut` <> '3' and ag.id = r.id_age ";
				$qry .= "ORDER BY r.`date_ajout` DESC LIMIT $offset, $limit";
				$result = mysqli_query($bd, $qry);
			}
		} else {
			if ($searchValueJour != 'Jour' && $searchValueMois != 'Mois' && $searchValueAnnee != 'Année') {
				$dateS = $searchValueAnnee . '-' . $searchValueMois . '-' . $searchValueJour;
				$qry = "SELECT date, t.nom, c.nom, c.prenom,  r.vol, compagnie, porte, s.nom, o.nom, r.date_validation, s.id, r.id, id_client, sl.nom, salon, r.date_ajout, carte, ag.nom , r.id";
				$qry .= "FROM `reservation` r, tranche t, client c, statut s, origine o, salon sl, age ag ";
				$qry .= "where r.`carte` LIKE  '%$searchValue%' and r.`date` LIKE '%$dateS%' and r.`id_client` = c.id and r.`statut` = s.id and r.`id_tranche` = t.id and r.id_origine = o.id and sl.id = salon and r.`statut` <> '3' and ag.id = r.id_age ";
				$qry .= "ORDER BY r.`date_ajout` DESC LIMIT $offset, $limit";
				$result = mysqli_query($bd, $qry);
			} else {
				$qry = "SELECT date, t.nom, c.nom, c.prenom,  r.vol, compagnie, porte, s.nom, o.nom, r.date_validation, s.id, r.id, id_client, sl.nom, salon, r.date_ajout, carte, ag.nom , r.id";
				$qry .= "FROM `reservation` r, tranche t, client c, statut s, origine o, salon sl, age ag ";
				$qry .= "where r.`carte` LIKE  '%$searchValue%' and r.`id_client` = c.id and r.`statut` = s.id and r.`id_tranche` = t.id and r.id_origine = o.id and sl.id = salon and r.`statut` <> '3' and ag.id = r.id_age ";
				$qry .= "ORDER BY r.`date_ajout` DESC LIMIT $offset, $limit";
				$result = mysqli_query($bd, $qry);
			}
		}
	}
	// }elseif(isset($_GET['currentpage']) && $searchValueMois != 'Mois' && $searchValueAnnee != 'Année'){
	// 	$dateS = $searchValueAnnee . '-' . $searchValueMois;
	// 	$sqlTotalRserSearch = "SELECT COUNT(*) FROM `reservation` r WHERE r.`date` LIKE '%$dateS%'";
	// 	$resultTotalRserSearch = mysqli_query($bd, $sqlTotalRserSearch);
	// 	$values = mysqli_fetch_row($resultTotalRserSearch);
	// 	$nbReservations = $values[0];
	// 	$filenameTotalpage = 'totalpage_' . $_SESSION['SESS_FIRST_NAME'] . '_' . $_SESSION['SESS_LAST_NAME'] . '.txt';
	// 	file_put_contents($filenameTotalpage, $nbReservations);
	// 	$nbReservations = 	file_get_contents($filenameTotalpage);
	// 	$limit = 10;
	// 	$totalpages = ceil($nbReservations / $limit);
	// 	$qry = "SELECT date, t.nom, c.nom, c.prenom,  r.vol, compagnie, porte, s.nom, o.nom, r.date_validation, s.id, r.id, id_client, sl.nom, salon, r.date_ajout, carte, ag.nom , r.id";
	// 	$qry .= "FROM `reservation` r, tranche t, client c, statut s, origine o, salon sl, age ag ";
	// 	$qry .= "where r.`date` LIKE '%$dateS%'and r.`id_client` = c.id and r.`statut` = s.id and r.`id_tranche` = t.id and r.id_origine = o.id and sl.id = salon and r.`statut` <> '3' and ag.id = r.id_age ";
	// 	$qry .= "ORDER BY r.`date_ajout` DESC LIMIT $offset, $limit";
	// 	$result = mysqli_query($bd, $qry);
	// }

	if ($result) {
		if (mysqli_num_rows($result) > 0) {
		}
	}
	?>

	<div class="row">
		<div class="col-lg-12">
			<div class="panel panel-default">
				<div class="panel-heading">Tous les salons
				</div>
				<!-- /.panel-heading -->
				<div class="panel-body">
					<table width="100%" style="font-size: 14px" class="table table-striped table-bordered table-hover" id="table">
						<thead>
							<tr>
								<th>Date</th>
								<th>Heure</th>
								<th>Nom</th>
								<th>Prénom</th>
								<th>Vol</th>
								<th>Compagnie</th>
								<th>Numéro billet</th>
								<th>Catégorie</th>
								<th>Age</th>
								<th>Carte</th>
								<th>Salon</th>
								<th style="width: 9%;"></th>
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
								if ($row[15] != '' && $row[15] != "0000-00-00") {
									list($year, $month, $day, $hour, $min, $sec) = multiexplode(array("-", "/", " ", ":"), $row[15]);
								}
								echo '	<td>' . $year . '/' . $month . '/' . $day . '</td>';
								echo '	<td>' . $hour . ':' . $min . ':' . $sec . '</td>';
								//echo '	<td>'.$row[15].'</td>';
								echo '	<td>' . $row[2] . '</td>';
								echo '	<td>' . $row[3] . '</td>';
								echo '	<td>' . $row[4] . '</td>';
								echo '	<td>' . $row[5] . '</td>';
								echo '	<td>' . $row[6] . '</td>';
								echo '	<td>' . $row[8] . '</td>';
								echo '	<td>' . $row[17] . '</td>';
								echo '	<td>' . $row[16] . '</td>';
								switch ($row[14]) {
									case "1":
										echo '<td class="infinite">' . $row[13] . '</td>';
										break;
									case "2":
										echo '<td class="odyssee">' . $row[13] . '</td>';
										break;
									case "3":
										echo '<td class="topkapi">' . $row[13] . '</td>';
										break;
								}
								echo '<td>
								<a href="details_reservation.php?id=' . $row[11] . '&id_client=' . $row[12] . '" class="btn btn-info" ><i class="fa fa-info-circle" aria-hidden="true"></i></a>';
								echo '&nbsp';
								if ($_SESSION['SESS_PROFIL'] != $RECEP_PROFIL) {
									echo '<a href="deleteReservation.php?idreservation=' . $row[18] . '" class="btn btn-danger">';
									echo '<i class="fa fa-remove" ></i>';
									echo '<a>';
								}


								echo '</td>';
								echo '</tr>';
							}
							?>
						</tbody>

						<div class="col-lg-2">
							<div class="row">
								<div class="form-group">
									<?php
									if ($searchValue != '' && $searchcritereValue != '') {
										echo '<a href="uploadexcel.php?searchValue=' . $searchValue . '&searchcritereValue=' . $searchcritereValue . '&searchValueJour=' . $searchValueJour . '&searchValueMois=' . $searchValueMois . '&searchValueAnnee=' . $searchValueAnnee . '">'; ?>
										<button class="btn btn-primary" type="submit" name="exportExcel">
											<i class="fa fa-download"></i>
											<i class="fa fa-file-excel-o"></i>
										</button>
										</a>
										<?php
										echo '<a href="print_reservations.php?searchValue=' . $searchValue . '&searchcritereValue=' . $searchcritereValue . '&searchValueJour=' . $searchValueJour . '&searchValueMois=' . $searchValueMois . '&searchValueAnnee=' . $searchValueAnnee . '">'; ?>
										<button class="btn btn-primary print" name="print">
											print
										</button>
										</a>
										<!-- </form> -->

									<?php } ?>
								</div>
							</div>
						</div>
						<div class="col-lg-10">
							<div class="row">
								<form action="all_reservations.php" method="post">
									<div class="col-lg-2">
										<div class="form-group">
											<select name="jour" id="jour" class="form-control">
												<?php
												foreach ($jourArray as $j) { ?>
													<option value="<?php echo $j ?>" <?php if ($j == $searchValueJour) echo 'selected ="selected";' ?>><?php echo $j ?></option>';

												<?php } ?>

											</select>
										</div>
									</div>
									<div class="col-lg-2">
										<div class="form-group">
											<select name="mois" id="mois" class="form-control">
												<?php
												foreach ($monthArray as $m) { ?>
													<option value="<?php echo $m ?>" <?php if ($m == $searchValueMois) echo 'selected ="selected";' ?>><?php echo $m ?></option>';

												<?php } ?>

											</select>
										</div>
									</div>
									<div class="col-lg-2">
										<div class="form-group">
											<select name="annee" id="annee" class="form-control">
												<?php
												foreach ($annee as $an) { ?>
													<option value="<?php echo $an ?>" <?php if ($an == $searchValueAnnee) echo 'selected ="selected";' ?>><?php echo  $an ?></option> ';
												<?php } ?>

											</select>
										</div>
									</div>
									<div class="col-lg-2 form-group">
										<select name="searchBy" id="searchBy" class="form-control" value="searchcritereValue">
											<option value="0">Rechercher Par</option>
											<option value="nom" <?php if ('nom' == $searchcritereValue) echo 'selected="selected"' ?>>Nom</option>
											<option value="prenom" <?php if ('prenom' == $searchcritereValue) echo 'selected="selected"' ?>>Prenom<moption>
											<option value="date" <?php if ('date' == $searchcritereValue) echo 'selected="selected"' ?>>date</option>
											<option value="compagnie" <?php if ('compagnie' == $searchcritereValue) echo 'selected="selected"' ?>>Compagnie</option>
											<option value="vol" <?php if ('vol' == $searchcritereValue) echo 'selected="selected"' ?>>Vol</option>
											<option value="numerobillet" <?php if ('numerobillet' == $searchcritereValue) echo 'selected="selected"' ?>>Numero Billet</option>
											<option value="categorie" <?php if ('categorie' == $searchcritereValue) echo 'selected="selected"' ?>>Categorie</option>
											<option value="salon" <?php if ('salon' == $searchcritereValue) echo 'selected="selected"' ?>>Salon</option>
											<option value="carte" <?php if ('carte' == $searchcritereValue) echo 'selected="selected"' ?>>carte</option>
										</select>
									</div>
									<div class="col-lg-2 form-group">
										<input type="text" name="search" class="form-control" placeholder="search" value="<?php echo $searchValue ?>">
									</div>
									<div class="col-lg-2 form-group">
										<button class="btn btn-primary" type="submit" name="searchSubmit">
											<span class="fa fa-search"></span>
										</button>
									</div>
								</form>
							</div>
						</div>

				</div>
				</table>
				<div style="margin-top: 15px;">
					<div>
						page <?php echo $currentpage . '/' . $totalpages ?>
					</div>
				</div>
				<div class="pull-right" style="margin-top: -15px;">
					<?php
					$range = 3;

					if ($currentpage > 1) {
						// if ($searchValue != '') {
						// 	echo " <a href='{$_SERVER['PHP_SELF']}?search=$searchValue&currentpage=1'><<</a> ";
						// } else {
						echo " <a href='{$_SERVER['PHP_SELF']}?currentpage=1'><<</a> ";
						// }

						$prevpage = $currentpage - 1;
						echo " <a href='{$_SERVER['PHP_SELF']}?currentpage=$prevpage'>Prev</a> ";
					} // end if 

					for ($x = ($currentpage - $range); $x < (($currentpage + $range) + 1); $x++) {
						if (($x > 0) && ($x <= $totalpages)) {
							if ($x == $currentpage) {
								echo " [<b>$x</b>] ";
							} else {
								echo " <a href='{$_SERVER['PHP_SELF']}?currentpage=$x'>$x</a> ";
							}
						}
					}

					if ($currentpage != $totalpages) {
						$nextpage = $currentpage + 1;
						echo " <a href='{$_SERVER['PHP_SELF']}?currentpage=$nextpage'>Next</a> ";
						echo " <a href='{$_SERVER['PHP_SELF']}?currentpage=$totalpages'>>></a> ";
						// }
					}
					?>
					<div>
					</div>
					<!-- /.panel-body -->
				</div>
				<!-- /.panel -->
			</div>
			<!-- /.col-lg-12 -->
		</div>
		<?php
		// 	} else {
		// 	}
		// } else {
		// 	die("Query failed");
		// }
		?>
	</div>
	<!-- /#page-wrapper -->


</div>
<!-- /#wrapper -->

<!-- jQuery -->
<script src="https://code.jquery.com/jquery-1.12.4.js"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<script>
	$('.print').click(function(e) {
	// e.preventDefault();

	})
</script>
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
	function searchFunction(val) {
		console.log("search", val);
		var searchSubmit = val;
		$.ajax({
			type: "POST",
			url: "all_reservations.php",
			data: {
				searchSubmit: searchSubmit
			}
		});
	}
</script>
<script>
	$("#searchBy").click(function() {
		if ($("#searchBy").val == '0') {
			$('#searchByModal').modal('show');
		}

	})
</script>
<!-- Page-Level Demo Scripts - Tables - Use for reference -->
<script>
	$(window).load(function() {
		// Animate loader off screen
		$(".se-pre-con").fadeOut("slow");;
	});
	$(document).ready(function() {
		$('#dataTables-example tfoot th').each(function() {
			var title = $(this).text();
			$(this).html('<input type="text" placeholder="Rechercher" />');
		});
		var table = $('#dataTables-example').DataTable({
			"order": [
				[0, "desc"],
				[1, "desc"]
			],
			dom: 'Bfrtip',
			buttons: [{
					extend: 'copyHtml5',
					exportOptions: {
						columns: [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10]
					}
				},
				{
					extend: 'pdfHtml5',
					title: '<?php echo $todayFile ?>',
					exportOptions: {
						columns: [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10]
					}
				},
				{
					extend: 'excelHtml5',
					title: '<?php echo $todayFile ?>',
					exportOptions: {
						columns: [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10]
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