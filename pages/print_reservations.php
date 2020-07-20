<?php
require_once('includes/connection.php');

function multiexplode($delimiters, $string)
{
    $ready = str_replace($delimiters, $delimiters[0], $string);
    $launch = explode($delimiters[0], $ready);
    return  $launch;
}

$searchcritereValue = $_GET['searchcritereValue'];
$searchValue = $_GET['searchValue'];
$searchValueJour = $_GET['searchValueJour'];
$searchValueMois = $_GET['searchValueMois'];
$searchValueAnnee = $_GET['searchValueAnnee'];
if ($searchcritereValue == 'nom') {
    if ($searchValueMois != 'Mois' && $searchValueAnnee != 'Année') {
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
            $qry .= "ORDER BY r.`date_ajout` DESC";
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
            $qry .= "ORDER BY r.`date_ajout` DESC";
            $result = mysqli_query($bd, $qry);
        }
    }
} elseif ($searchcritereValue == 'prenom') {
    if ($searchValueMois != 'Mois' && $searchValueAnnee != 'Année') {
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
            $qry .= "ORDER BY r.`date_ajout` DESC";
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
            $qry .= "ORDER BY r.`date_ajout` DESC";
            $result = mysqli_query($bd, $qry);
        }
    }
} elseif ($searchcritereValue == 'compagnie') {
    if ($searchValueMois != 'Mois' && $searchValueAnnee != 'Année') {
        $dateS = $searchValueAnnee . '-' . $searchValueMois . '-' . $searchValueJour;
        $qry = "SELECT date, t.nom, c.nom, c.prenom,  r.vol, compagnie, porte, s.nom, o.nom, r.date_validation, s.id, r.id, id_client, sl.nom, salon, r.date_ajout, carte, ag.nom , r.id ";
        $qry .= "FROM `reservation` r, tranche t, client c, statut s, origine o, salon sl, age ag ";
        $qry .= "where r.`compagnie` LIKE  '%$searchValue%' and r.`date` LIKE '%$dateS%' and r.`id_client` = c.id and r.`statut` = s.id and r.`id_tranche` = t.id and r.id_origine = o.id and sl.id = salon and r.`statut` <> '3' and ag.id = r.id_age ";
        $qry .= "ORDER BY r.`date_ajout` DESC";
        $result = mysqli_query($bd, $qry);
    } else {
        $qry = "SELECT date, t.nom, c.nom, c.prenom,  r.vol, compagnie, porte, s.nom, o.nom, r.date_validation, s.id, r.id, id_client, sl.nom, salon, r.date_ajout, carte, ag.nom , r.id ";
        $qry .= "FROM `reservation` r, tranche t, client c, statut s, origine o, salon sl, age ag ";
        $qry .= "where r.`compagnie` LIKE  '%$searchValue%' and r.`id_client` = c.id and r.`statut` = s.id and r.`id_tranche` = t.id and r.id_origine = o.id and sl.id = salon and r.`statut` <> '3' and ag.id = r.id_age ";
        $qry .= "ORDER BY r.`date_ajout` DESC";
        $result = mysqli_query($bd, $qry);
    }
} elseif ($searchcritereValue == 'vol') {
    if ($searchValueMois != 'Mois' && $searchValueAnnee != 'Année') {
        $dateS = $searchValueAnnee . '-' . $searchValueMois . '-' . $searchValueJour;
        $qry = "SELECT date, t.nom, c.nom, c.prenom,  r.vol, compagnie, porte, s.nom, o.nom, r.date_validation, s.id, r.id, id_client, sl.nom, salon, r.date_ajout, carte, ag.nom ,  r.id ";
        $qry .= "FROM `reservation` r, tranche t, client c, statut s, origine o, salon sl, age ag ";
        $qry .= "where r.`vol` LIKE  '%$searchValue%'  and r.`date` LIKE '%$dateS%' and r.`id_client` = c.id and r.`statut` = s.id and r.`id_tranche` = t.id and r.id_origine = o.id and sl.id = salon and r.`statut` <> '3' and ag.id = r.id_age ";
        $qry .= "ORDER BY r.`date_ajout` DESC";
        $result = mysqli_query($bd, $qry);
    } else {
        $qry = "SELECT date, t.nom, c.nom, c.prenom,  r.vol, compagnie, porte, s.nom, o.nom, r.date_validation, s.id, r.id, id_client, sl.nom, salon, r.date_ajout, carte, ag.nom ,  r.id ";
        $qry .= "FROM `reservation` r, tranche t, client c, statut s, origine o, salon sl, age ag ";
        $qry .= "where r.`vol` LIKE  '%$searchValue%' and r.`id_client` = c.id and r.`statut` = s.id and r.`id_tranche` = t.id and r.id_origine = o.id and sl.id = salon and r.`statut` <> '3' and ag.id = r.id_age ";
        $qry .= "ORDER BY r.`date_ajout` DESC";
        $result = mysqli_query($bd, $qry);
    }
} elseif ($searchcritereValue == 'salon') {
    if ($searchValueMois != 'Mois' && $searchValueAnnee != 'Année') {
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
            $qry .= "ORDER BY r.`date_ajout` DESC";
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
            $qry .= "ORDER BY r.`date_ajout` DESC";
            $result = mysqli_query($bd, $qry);
        }
    }
} elseif ($searchcritereValue == "categorie") {
    if ($searchValueMois != 'Mois' && $searchValueAnnee != 'Année') {
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
            $qry .= "ORDER BY r.`date_ajout` DESC";
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
            $qry .= "ORDER BY r.`date_ajout` DESC";
            $result = mysqli_query($bd, $qry);
        }
    }
} elseif ($searchcritereValue == 'numerobillet') {
    if ($searchValueMois != 'Mois' && $searchValueAnnee != 'Année') {
        $dateS = $searchValueAnnee . '-' . $searchValueMois . '-' . $searchValueJour;
        $qry = "SELECT date, t.nom, c.nom, c.prenom,  r.vol, compagnie, porte, s.nom, o.nom, r.date_validation, s.id, r.id, id_client, sl.nom, salon, r.date_ajout, carte, ag.nom,  r.id ";
        $qry .= "FROM `reservation` r, tranche t, client c, statut s, origine o, salon sl, age ag ";
        $qry .= "where r.`porte` LIKE  '%$searchValue%' and r.`date` LIKE '%$dateS%' and r.`id_client` = c.id and r.`statut` = s.id and r.`id_tranche` = t.id and r.id_origine = o.id and sl.id = salon and r.`statut` <> '3' and ag.id = r.id_age ";
        $qry .= "ORDER BY r.`date_ajout` DESC";
        $result = mysqli_query($bd, $qry);
    } else {
        $qry = "SELECT date, t.nom, c.nom, c.prenom,  r.vol, compagnie, porte, s.nom, o.nom, r.date_validation, s.id, r.id, id_client, sl.nom, salon, r.date_ajout, carte, ag.nom,  r.id ";
        $qry .= "FROM `reservation` r, tranche t, client c, statut s, origine o, salon sl, age ag ";
        $qry .= "where r.`porte` LIKE  '%$searchValue%' and r.`id_client` = c.id and r.`statut` = s.id and r.`id_tranche` = t.id and r.id_origine = o.id and sl.id = salon and r.`statut` <> '3' and ag.id = r.id_age ";
        $qry .= "ORDER BY r.`date_ajout` DESC";
        $result = mysqli_query($bd, $qry);
    }
} elseif ($searchcritereValue == 'date') {
    if ($searchValueMois != 'Mois' && $searchValueAnnee != 'Année') {
        $dateS = $searchValueAnnee . '-' . $searchValueMois . '-' . $searchValueJour;
        $qry = "SELECT date, t.nom, c.nom, c.prenom,  r.vol, compagnie, porte, s.nom, o.nom, r.date_validation, s.id, r.id, id_client, sl.nom, salon, r.date_ajout, carte, ag.nom , r.id";
        $qry .= "FROM `reservation` r, tranche t, client c, statut s, origine o, salon sl, age ag ";
        $qry .= "where r.`date` LIKE  '%$dateS%' and r.`id_client` = c.id and r.`statut` = s.id and r.`id_tranche` = t.id and r.id_origine = o.id and sl.id = salon and r.`statut` <> '3' and ag.id = r.id_age ";
        $qry .= "ORDER BY r.`date_ajout` DESC";
        $result = mysqli_query($bd, $qry);
    } else {
        $qry = "SELECT date, t.nom, c.nom, c.prenom,  r.vol, compagnie, porte, s.nom, o.nom, r.date_validation, s.id, r.id, id_client, sl.nom, salon, r.date_ajout, carte, ag.nom , r.id";
        $qry .= "FROM `reservation` r, tranche t, client c, statut s, origine o, salon sl, age ag ";
        $qry .= "where r.`date` LIKE  '%$searchValue%' and r.`id_client` = c.id and r.`statut` = s.id and r.`id_tranche` = t.id and r.id_origine = o.id and sl.id = salon and r.`statut` <> '3' and ag.id = r.id_age ";
        $qry .= "ORDER BY r.`date_ajout` DESC";
        $result = mysqli_query($bd, $qry);
    }
} elseif ($searchcritereValue == 'carte') {
    if ($searchValueMois != 'Mois' && $searchValueAnnee != 'Année') {
        $dateS = $searchValueAnnee . '-' . $searchValueMois . '-' . $searchValueJour;
        $qry = "SELECT date, t.nom, c.nom, c.prenom,  r.vol, compagnie, porte, s.nom, o.nom, r.date_validation, s.id, r.id, id_client, sl.nom, salon, r.date_ajout, carte, ag.nom , r.id";
        $qry .= "FROM `reservation` r, tranche t, client c, statut s, origine o, salon sl, age ag ";
        $qry .= "where r.`carte` LIKE  '%$searchValue%' and r.`date` LIKE '%$dateS%' and r.`id_client` = c.id and r.`statut` = s.id and r.`id_tranche` = t.id and r.id_origine = o.id and sl.id = salon and r.`statut` <> '3' and ag.id = r.id_age ";
        $qry .= "ORDER BY r.`date_ajout` DESC";
        $result = mysqli_query($bd, $qry);
    } else {
        $qry = "SELECT date, t.nom, c.nom, c.prenom,  r.vol, compagnie, porte, s.nom, o.nom, r.date_validation, s.id, r.id, id_client, sl.nom, salon, r.date_ajout, carte, ag.nom , r.id";
        $qry .= "FROM `reservation` r, tranche t, client c, statut s, origine o, salon sl, age ag ";
        $qry .= "where r.`carte` LIKE  '%$searchValue%' and r.`id_client` = c.id and r.`statut` = s.id and r.`id_tranche` = t.id and r.id_origine = o.id and sl.id = salon and r.`statut` <> '3' and ag.id = r.id_age ";
        $qry .= "ORDER BY r.`date_ajout` DESC";
        $result = mysqli_query($bd, $qry);
    }
} elseif ($searchValueMois != 'Mois' && $searchValueAnnee != 'Année' && ($searchcritereValue == '' || $searchValue == '')) {
    $dateS = $searchValueAnnee . '-' . $searchValueMois . '-' . $searchValueJour;
    $qry = "SELECT date, t.nom, c.nom, c.prenom,  r.vol, compagnie, porte, s.nom, o.nom, r.date_validation, s.id, r.id, id_client, sl.nom, salon, r.date_ajout, carte, ag.nom , r.id";
    $qry .= "FROM `reservation` r, tranche t, client c, statut s, origine o, salon sl, age ag ";
    $qry .= "where r.`date` LIKE  '%$dateS%' and r.`id_client` = c.id and r.`statut` = s.id and r.`id_tranche` = t.id and r.id_origine = o.id and sl.id = salon and r.`statut` <> '3' and ag.id = r.id_age ";
    $qry .= "ORDER BY r.`date_ajout` DESC";
    $result = mysqli_query($bd, $qry);
}


?>
<br>
<table width="100%" id="table">
    <thead>
        <tr>
            <th width="15%">Date</th>
            <th width="15%">Heure</th>
            <th width="15%">Nom</th>
            <th width="15%">Prenom</th>
            <th width="15%">Vol</th>
            <th width="15%">Compagnie</th>
            <th width="15%">Numero billet</th>
            <th width="15%">Categorie</th>
            <th width="15%"> Age</th>
            <th width="15%">Carte</th>
            <th width="15%">Salon</th>
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
            echo '</tr>';
        }
        ?>
    </tbody>
</table>
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
<script>
    var printme = document.getElementById('table');
    var printopen = window.open("", "", "width=2800,height=2500");
    printopen.document.write(printme.outerHTML);
    printopen.document.close();
    printopen.focus();
    printopen.print();
    printopen.close();
    document.location.replace('all_reservations.php');
   
</script>

</html>