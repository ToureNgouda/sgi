<?php
require_once('header.php');
//Include database connection details
require_once('includes/connection.php');
?>

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
<?php
if (isset($_GET['idreservation'])) {
    $idreservation = $_GET['idreservation'];
    $qryinf = "SELECT r.`compagnie`, r.`vol`, r.`date`, r.`porte` from `reservation` r where r.`id` = $idreservation";
    $resultqryinf =  mysqli_query($bd, $qryinf);
    if ($resultqryinf) {
        while ($rowinf = mysqli_fetch_array($resultqryinf, MYSQLI_BOTH)) {
            $numdel = $rowinf[3];
            $compagniedel = $rowinf[0];
            $voldel = $rowinf[1];
            $datedel = $rowinf[2];
        }
    }
}
?>
<div class="modal fade" id="deleteReservation" role="dialog">
    <div class="modal-dialog">

        <!-- Modal content-->
        <form action="all_reservations.php" method="POST" id="annulerrs">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body" style="text-align: center;">
                    <div class="row">
                        <div class="form-group col-lg-12">
                            Etes vous sùr de vouloir supprimer la reservation n° <b> <?php echo $numdel ?></b> de la compagnie <b><?php echo $compagniedel ?></b>
                            pour le vol <b><?php echo $voldel ?> </b>du <b><?php echo $datedel ?></b>
                        </div>

                    </div>
                    <div class="row">
                        <div class="form-group">
                            <label for="">motif d'annulation: </label>
                            <textarea name="motif" id="motifannul" class="form-control col-lg-6" rows="5"></textarea>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" id="annuler">Annuler</button>
                    <button class="btn btn-secondary" type="submit" id="deletereser" name="confirmerdeletereser" value="<?php echo $idreservation ?>">Confirmer</button>
                </div>
            </div>
        </form>

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

    $sqlTotalRser = "SELECT COUNT(*) FROM reservation ";
    $resultTotalRser = mysqli_query($bd, $sqlTotalRser);
    $values = mysqli_fetch_row($resultTotalRser);
    $nbReservations = $values[0];
    $limit = 10;
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
    $filename = 'search_' . $_SESSION['SESS_FIRST_NAME'] . '_' . $_SESSION['SESS_LAST_NAME'] . '.txt';
    $filenamesearchCritere = 'searchcritere_' . $_SESSION['SESS_FIRST_NAME'] . '_' . $_SESSION['SESS_LAST_NAME'] . '.txt';
    if (file_get_contents($filename) &&  file_get_contents($filenamesearchCritere)) {
        $searchcritereValue =  file_get_contents($filenamesearchCritere);
        $searchValue = file_get_contents($filename);
        $offset = ($currentpage - 1) * $limit;
        if ($searchcritereValue == 'nom') {
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
                $sqlTotalRserSearch = "SELECT COUNT(*) FROM `reservation` r where r.`id_client` in ($keys) ";
            }
            $resultTotalRser = mysqli_query($bd, $sqlTotalRserSearch);
            $values = mysqli_fetch_row($resultTotalRser);
            $nbReservations = $values[0];
            $totalpages = ceil($nbReservations / $limit);
            if (!empty($keys)) {
                $qry = "SELECT date, t.nom, c.nom, c.prenom,  r.vol, compagnie, porte, s.nom, o.nom, r.date_validation, s.id, r.id, id_client, sl.nom, salon, r.date_ajout, carte, ag.nom , r.id ";
                $qry .= "FROM `reservation` r, tranche t, client c, statut s, origine o, salon sl, age ag ";
                $qry .= "where r.`id_client` IN ($keys) and r.`id_client` = c.id and r.`statut` = s.id and r.`id_tranche` = t.id and r.id_origine = o.id and sl.id = salon and r.`statut` <> '3' and ag.id = r.id_age ";
                $qry .= "ORDER BY r.`date_ajout` DESC LIMIT $offset, $limit";
                $result = mysqli_query($bd, $qry);
            }
        } elseif ($searchcritereValue == 'prenom') {
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
                $sqlTotalRserSearch = "SELECT COUNT(*) FROM `reservation` r where r.`id_client` in ($keys) ";
            }
            $resultTotalRser = mysqli_query($bd, $sqlTotalRserSearch);
            $values = mysqli_fetch_row($resultTotalRser);
            $nbReservations = $values[0];
            $totalpages = ceil($nbReservations / $limit);
            if (!empty($keys)) {
                $qry = "SELECT date, t.nom, c.nom, c.prenom,  r.vol, compagnie, porte, s.nom, o.nom, r.date_validation, s.id, r.id, id_client, sl.nom, salon, r.date_ajout, carte, ag.nom,  r.id ";
                $qry .= "FROM `reservation` r, tranche t, client c, statut s, origine o, salon sl, age ag ";
                $qry .= "where r.`id_client` in ($keys) and r.`id_client` = c.id and r.`statut` = s.id and r.`id_tranche` = t.id and r.id_origine = o.id and sl.id = salon and r.`statut` <> '3' and ag.id = r.id_age ";
                $qry .= "ORDER BY r.`date_ajout` DESC LIMIT $offset, $limit";
                $result = mysqli_query($bd, $qry);
            }
        } elseif ($searchcritereValue == 'compagnie') {
            $sqlTotalRserSearch = "SELECT COUNT(*) FROM `reservation` r where r.`compagnie` LIKE  '%$searchValue%'";
            $resultTotalRser = mysqli_query($bd, $sqlTotalRserSearch);
            $values = mysqli_fetch_row($resultTotalRser);
            $nbReservations = $values[0];
            $totalpages = ceil($nbReservations / $limit);
            $qry = "SELECT date, t.nom, c.nom, c.prenom,  r.vol, compagnie, porte, s.nom, o.nom, r.date_validation, s.id, r.id, id_client, sl.nom, salon, r.date_ajout, carte, ag.nom, r.id ";
            $qry .= "FROM `reservation` r, tranche t, client c, statut s, origine o, salon sl, age ag ";
            $qry .= "where r.`compagnie` LIKE  '%$searchValue%' and r.`id_client` = c.id and r.`statut` = s.id and r.`id_tranche` = t.id and r.id_origine = o.id and sl.id = salon and r.`statut` <> '3' and ag.id = r.id_age ";
            $qry .= "ORDER BY r.`date_ajout` DESC LIMIT $offset, $limit";
            $result = mysqli_query($bd, $qry);
        } elseif ($searchcritereValue == 'vol') {
            $sqlTotalRserSearch = "SELECT COUNT(*) FROM `reservation` r where r.`vol` LIKE  '%$searchValue%'";
            $resultTotalRser = mysqli_query($bd, $sqlTotalRserSearch);
            $values = mysqli_fetch_row($resultTotalRser);
            $nbReservations = $values[0];
            $totalpages = ceil($nbReservations / $limit);
            $qry = "SELECT date, t.nom, c.nom, c.prenom,  r.vol, compagnie, porte, s.nom, o.nom, r.date_validation, s.id, r.id, id_client, sl.nom, salon, r.date_ajout, carte, ag.nom , r.id ";
            $qry .= "FROM `reservation` r, tranche t, client c, statut s, origine o, salon sl, age ag ";
            $qry .= "where r.`vol` LIKE  '%$searchValue%' and r.`id_client` = c.id and r.`statut` = s.id and r.`id_tranche` = t.id and r.id_origine = o.id and sl.id = salon and r.`statut` <> '3' and ag.id = r.id_age ";
            $qry .= "ORDER BY r.`date_ajout` DESC LIMIT $offset, $limit";
            $result = mysqli_query($bd, $qry);
        } elseif ($searchcritereValue == 'salon') {
            $searchSalon = "SELECT s.`id` FROM `salon` s where s.`nom` LIKE  '%$searchValue%'";
            $resultsearchSalon = mysqli_query($bd, $searchSalon);
            while ($searchSalonRow = mysqli_fetch_array($resultsearchSalon, MYSQLI_BOTH)) {
                $idSalon = $searchSalonRow[0];
            }
            if ($idSalon) {
                $sqlTotalRserSearch = "SELECT COUNT(*) FROM `reservation` r where r.`salon` = '$idSalon' ";
            }
            $resultTotalRser = mysqli_query($bd, $sqlTotalRserSearch);
            $values = mysqli_fetch_row($resultTotalRser);
            $nbReservations = $values[0];
            $totalpages = ceil($nbReservations / $limit);
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
        } elseif ($searchcritereValue == "categorie") {
            $searchCategorie = "SELECT o.`id` FROM `origine` o where o.`nom` LIKE  '%$searchValue%'";
            $resultsearchCategorie = mysqli_query($bd, $searchCategorie);
            while ($searchCategorieRow = mysqli_fetch_array($resultsearchCategorie, MYSQLI_BOTH)) {
                $idCategorie = $searchCategorieRow[0];
            }
            if ($idCategorie) {
                $sqlTotalRserSearch = "SELECT COUNT(*) FROM `reservation` r where r.`id_origine` = '$idCategorie' ";
            }
            $resultTotalRser = mysqli_query($bd, $sqlTotalRserSearch);
            $values = mysqli_fetch_row($resultTotalRser);
            $nbReservations = $values[0];
            $totalpages = ceil($nbReservations / $limit);
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
        } elseif ($searchcritereValue == 'numerobillet') {
            $sqlTotalRserSearch = "SELECT COUNT(*) FROM `reservation` r where r.`porte` LIKE  '%$searchValue%'";
            $resultTotalRser = mysqli_query($bd, $sqlTotalRserSearch);
            $values = mysqli_fetch_row($resultTotalRser);
            $nbReservations = $values[0];
            $totalpages = ceil($nbReservations / $limit);
            $qry = "SELECT date, t.nom, c.nom, c.prenom,  r.vol, compagnie, porte, s.nom, o.nom, r.date_validation, s.id, r.id, id_client, sl.nom, salon, r.date_ajout, carte, ag.nom,  r.id ";
            $qry .= "FROM `reservation` r, tranche t, client c, statut s, origine o, salon sl, age ag ";
            $qry .= "where r.`porte` LIKE  '%$searchValue%' and r.`id_client` = c.id and r.`statut` = s.id and r.`id_tranche` = t.id and r.id_origine = o.id and sl.id = salon and r.`statut` <> '3' and ag.id = r.id_age ";
            $qry .= "ORDER BY r.`date_ajout` DESC LIMIT $offset, $limit";
            $result = mysqli_query($bd, $qry);
        } elseif ($searchcritereValue == 'date') {
            $sqlTotalRserSearch = "SELECT COUNT(*) FROM `reservation` r where r.`date` LIKE  '%$searchValue%'";
            $resultTotalRser = mysqli_query($bd, $sqlTotalRserSearch);
            $values = mysqli_fetch_row($resultTotalRser);
            $nbReservations = $values[0];
            $totalpages = ceil($nbReservations / $limit);
            $qry = "SELECT date, t.nom, c.nom, c.prenom,  r.vol, compagnie, porte, s.nom, o.nom, r.date_validation, s.id, r.id, id_client, sl.nom, salon, r.date_ajout, carte, ag.nom , r.id ";
            $qry .= "FROM `reservation` r, tranche t, client c, statut s, origine o, salon sl, age ag ";
            $qry .= "where r.`date` LIKE  '%$searchValue%' and r.`id_client` = c.id and r.`statut` = s.id and r.`id_tranche` = t.id and r.id_origine = o.id and sl.id = salon and r.`statut` <> '3' and ag.id = r.id_age ";
            $qry .= "ORDER BY r.`date_ajout` DESC LIMIT $offset, $limit";
            $result = mysqli_query($bd, $qry);
        } elseif ($searchcritereValue == 'carte') {
            $sqlTotalRserSearch = "SELECT COUNT(*) FROM `reservation` r where r.`carte` LIKE  '%$searchValue%'";
            $resultTotalRser = mysqli_query($bd, $sqlTotalRserSearch);
            $values = mysqli_fetch_row($resultTotalRser);
            $nbReservations = $values[0];
            $totalpages = ceil($nbReservations / $limit);

            $qry = "SELECT date, t.nom, c.nom, c.prenom,  r.vol, compagnie, porte, s.nom, o.nom, r.date_validation, s.id, r.id, id_client, sl.nom, salon, r.date_ajout, carte, ag.nom , r.id ";
            $qry .= "FROM `reservation` r, tranche t, client c, statut s, origine o, salon sl, age ag ";
            $qry .= "where r.`carte` LIKE  '%$searchValue%' and r.`id_client` = c.id and r.`statut` = s.id and r.`id_tranche` = t.id and r.id_origine = o.id and sl.id = salon and r.`statut` <> '3' and ag.id = r.id_age ";
            $qry .= "ORDER BY r.`date_ajout` DESC LIMIT $offset, $limit";
            $result = mysqli_query($bd, $qry);
        } else {
            $qry = "SELECT date, t.nom, c.nom, c.prenom,  r.vol, compagnie, porte, s.nom, o.nom, r.date_validation, s.id, r.id, id_client, sl.nom, salon, r.date_ajout, carte, ag.nom , r.id ";
            $qry .= "FROM `reservation` r, tranche t, client c, statut s, origine o, salon sl, age ag ";
            $qry .= "where r.`id_client` = c.id and r.`statut` = s.id and r.`id_tranche` = t.id and r.id_origine = o.id and sl.id = salon and r.`statut` <> '3' and ag.id = r.id_age ";
            $qry .= "ORDER BY r.`date_ajout` DESC LIMIT $offset, $limit";
            $result = mysqli_query($bd, $qry);
        }
    } else {
        $sqlTotalRser = "SELECT COUNT(*) FROM reservation ";
        $resultTotalRser = mysqli_query($bd, $sqlTotalRser);
        $values = mysqli_fetch_row($resultTotalRser);
        $nbReservations = $values[0];
        $totalpages = ceil($nbReservations / $limit);
        $filename = 'search_' . $_SESSION['SESS_FIRST_NAME'] . '_' . $_SESSION['SESS_LAST_NAME'] . '.txt';
        $filenamesearchCritere = 'searchcritere_' . $_SESSION['SESS_FIRST_NAME'] . '_' . $_SESSION['SESS_LAST_NAME'] . '.txt';
        file_put_contents($filename, '');
        file_put_contents($filenamesearchCritere, '');
        $searchcritereValue =  file_get_contents($filenamesearchCritere);
        $searchValue = file_get_contents($filename);
        $qry = "SELECT date, t.nom, c.nom, c.prenom,  r.vol, compagnie, porte, s.nom, o.nom, r.date_validation, s.id, r.id, id_client, sl.nom, salon, r.date_ajout, carte, ag.nom , r.id ";
        $qry .= "FROM `reservation` r, tranche t, client c, statut s, origine o, salon sl, age ag ";
        $qry .= "where r.`id_client` = c.id and r.`statut` = s.id and r.`id_tranche` = t.id and r.id_origine = o.id and sl.id = salon and r.`statut` <> '3' and ag.id = r.id_age ";
        $qry .= "ORDER BY r.`date_ajout` DESC LIMIT $offset, $limit";
        $result = mysqli_query($bd, $qry);
    }

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
                    <table width="100%" style="font-size: 14px" class="table table-striped table-bordered table-hover">
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
								<a href="details_reservation.php?id=' . $row[11] . '&id_client=' . $row[12] . '" class="btn btn-info" ><i class="fa fa-info-circle" aria-hidden="true"></i></a>
								<a href="deleteReservation.php?idreservation=' . $row[18] . '" class="btn btn-danger">
								<i class="fa fa-remove" ></i>
								<a>
							</td>
								</tr>';
                            }
                            ?>
                        </tbody>
                        <tfooter style="margin-top: 0px;">
                            <!--?php if ($searchValue == '') {
										<form action="all_reservations.php" method="post">
									// } else {
									// 	echo '<form action="all_reservations.php?search='.$searchValue.'" method="post">';
									// } ?-->

                            <form action="all_reservations.php" method="post">
                                <div class="row pull-right">
                                    <div class="col-lg-5" style="margin-top: -2px;">
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
                                    <div class="col-lg-5">
                                        <input type="text" name="search" class="form-control" style="margin-top: -2px;" placeholder="search" value="<?php echo $searchValue ?>">
                                    </div>
                                    <div class="col-lg-2" style="margin-top: -2px;">
                                        <button class="btn btn-primary" name="searchSubmit">
                                            <span class="fa fa-search"></span>
                                        </button>
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
                        $range = 3;

                        if ($currentpage > 1) {
                            // if ($searchValue != '') {
                            // 	echo " <a href='{$_SERVER['PHP_SELF']}?search=$searchValue&currentpage=1'><<</a> ";
                            // } else {
                            echo " <a href='{$_SERVER['PHP_SELF']}?currentpage=1'><<</a> ";
                            // }

                            $prevpage = $currentpage - 1;
                            // if ($searchValue != '') {
                            // 	echo " <a href='{$_SERVER['PHP_SELF']}?search=$searchValue&currentpage=$prevpage'>Prev</a> ";
                            // } else {
                            echo " <a href='{$_SERVER['PHP_SELF']}?currentpage=$prevpage'>Prev</a> ";
                            // }
                        } // end if 

                        for ($x = ($currentpage - $range); $x < (($currentpage + $range) + 1); $x++) {
                            if (($x > 0) && ($x <= $totalpages)) {
                                if ($x == $currentpage) {
                                    echo " [<b>$x</b>] ";
                                } else {
                                    // if ($searchValue != '') {
                                    // 	echo " <a href='{$_SERVER['PHP_SELF']}?search=$searchValue&currentpage=$x'>$x</a> ";
                                    // } else {
                                    echo " <a href='{$_SERVER['PHP_SELF']}?currentpage=$x'>$x</a> ";
                                    // }
                                }
                            }
                        }

                        if ($currentpage != $totalpages) {
                            $nextpage = $currentpage + 1;
                            // if ($searchValue != '') {
                            // 	echo " <a href='{$_SERVER['PHP_SELF']}?search=$searchValue&currentpage=$nextpage'>Next</a> ";
                            // 	echo " <a href='{$_SERVER['PHP_SELF']}??search=$searchValue&currentpage=$totalpages'>>></a> ";
                            // } else {
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
    <script>
        $('#deleteReservation').modal('show');
    </script>
    <script type='text/javascript'>
        $('#annuler').click(function() {
            document.location.replace('all_reservations.php');
        });
        $('#page-wrapper').mouseenter(function() {
            document.location.replace('all_reservations.php');
        });
    </script>

    </body>

    </html>