<?php

require_once('includes/connection.php');

function multiexplode($delimiters, $string)
{
    $ready = str_replace($delimiters, $delimiters[0], $string);
    $launch = explode($delimiters[0], $ready);
    return  $launch;
}

$mois = $_GET['searchValueMois'];
$an = $_GET['searchValueAnnee'];
header("Content-type: application/vnd.ms-excel");
$file_name = 'factures_' . $mois . '_' . $an . '.xls';
header("Content-disposition: attachment; filename=\"" . $file_name . "\"");
header("Pragma: no-cache");
header("Expires: 0");
$datesearch = $an . '-' . $mois;
$qry = "SELECT f.`id` , f.`compagnie`, f.`date_debut`, f.`date_fin`, f.`name`, f.`img_url`, f.`prix_total`, f.`tva`, f.`montant_ht`,f.`numero_facture`,f.`date_creation`";
$qry .= "FROM `factures` f  where f.`date_fin` like '%$datesearch%' order by  f.`date_creation` desc ";
$result = mysqli_query($bd, $qry);

$qryca = "SELECT SUM(montant_ht) ";
$qryca .= "FROM `factures` f where f.`date_debut` like '%$datesearch%' order by  f.`date_creation` desc ";
$resultChiffreAff = mysqli_query($bd, $qryca);

$qrycattc = "SELECT SUM(prix_total) ";
$qrycattc .= "FROM `factures` f where f.`date_debut` like '%$datesearch%' order by  f.`date_creation` desc ";
$resultChiffreAffttc = mysqli_query($bd, $qrycattc);
?>
 <table width="100%" style="font-size: 14px"border="1px">
                    <thead>
                        <tr>
                            <!-- <th>COMPAGNIE</th> -->
                            <th >Date </th>
                            <th >Heure </th>
                            <th >Compagnie</th>
                            <th >Date de facture</th>
                            <th >Numero facture</th>
                            <th >Montant ht(XOF)</th>
                            <th >Tva</th>
                            <th >Montant ttc(XOF)</th>
                            <th >Montant ttc(EUROS)</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php
                    while ($row = mysqli_fetch_array($result, MYSQLI_BOTH)) {
                        $idComp = $row[1];
                        $tfactu =  "SELECT  c.`id` , c.`nom` ";
                        $tfactu .= "FROM `compagnie` c ";
                        $tfactu .= "where c.`id` = $idComp";
                        $resultCompagnie = mysqli_query($bd, $tfactu);
                        if ($resultCompagnie && mysqli_num_rows($resultCompagnie) > 0) {
                            while ($rowC = mysqli_fetch_array($resultCompagnie, MYSQLI_BOTH)) {
                                $nom = $rowC[1];
                            }
                        }
                        $url = '../' . $row[5];
                        echo  '<tr>';
                        if ($row[10] != '' && $row[10] != "0000-00-00") {
                            list($year, $month, $day, $hour, $min, $sec) = multiexplode(array("-", "/", " ", ":"), $row[10]);
                        }
                        echo '<td class="lab" style="text-align:center">' .  $year . '/' . $month . '/' . $day . '</td>';
                        echo '<td class="lab" style="text-align:center">' .  $hour . ':' . $min . ':' . $sec . '</td>';
                        echo '<td class="lab" style="text-align:center">';
                        echo '<label name="compagnie" class="lab">' . $nom . '';
                        echo '</td>';
                        // echo '<td>' .  $row[2] . '</td>';
                        echo '<td class="lab" style="text-align:center">' .  $row[3] . '</td>';
                        echo '<td class="lab" style="text-align:center">' .  $row[9] . '</td>';
                        $montanthtdel = number_format($row[8], 0, ',', ' ');
                        echo '<td class="lab" style="text-align:center">' .  $montanthtdel . '</td>';
                        $tvaFac = $row[7];
                        echo '<td class="lab" style="text-align:center">' .  $tvaFac . '</td>';
                        $montantdel = number_format($row[6], 0, ',', ' ');
                        $montantdelEuro = number_format($row[6] / 655.657, 0, ',', ' ');
                        echo '<td class="lab" style="text-align:center">' .  $montantdel . '</td>';
                        echo '<td class="lab" style="text-align:center">' .  $montantdelEuro . '</td>';


                        // echo '<td>' . $row[3] . '</td>';


                        echo '</tr>';
                    }
                    while ($rowca = mysqli_fetch_array($resultChiffreAff, MYSQLI_BOTH)) {
                        $chiffreAffaireht = number_format($rowca[0], 0, ',', ' ');
                    }
                    while ($rowcattc = mysqli_fetch_array($resultChiffreAffttc, MYSQLI_BOTH)) {
                        $chiffreAffairettc = number_format($rowcattc[0], 0, ',', ' ');
                        $chiffreAffairettcEuro = number_format($rowcattc[0] / 655.657, 0, ',', ' ');
                    }
                    echo '<tr>';
                    echo '<td>' .  '' . '</td>';
                    echo '<td>' .  '' . '</td>';
                    echo '<td>' .  '' . '</td>';
                    echo '<td>' .  '' . '</td>';
                    echo '<td>' .  '' . '</td>';
                    echo '<td>' .  '' . '</td>';
                    echo '<td>' .  '' . '</td>';
                    echo '<td>' .  '' . '</td>';
                    echo '<td>' .  '' . '</td>';
                    echo '</tr>';
                    echo '<tr>';
                    echo '<td colspan="2" >'  . 'chiffre d\'affaire du mois' . '</td>';
                    echo '<td>' .  '' . '</td>';
                    echo '<td>' .  '' . '</td>';
                    echo '<td>'  . ' ' . '</td>';
                    echo '<td style="text-align:center">' . $chiffreAffaireht . '</td>';
                    echo '<td>' . ' ' . '</td>';
                    echo '<td style="text-align:center">'  . $chiffreAffairettc . '</td>';
                    echo '<td style="text-align:center">'  . $chiffreAffairettcEuro . '</td>';
                    echo '</tr>';


                    ?>
                    </tbody>

                </table>
