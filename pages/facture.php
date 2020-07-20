<?php
require_once('header.php');
//Include database connection details
require_once('includes/connection.php');

use Mpdf\Mpdf;

require_once __DIR__ . '/../vendor/autoload.php';
?>
<!--?php if ($_SESSION['SESS_PROFIL'] !=$ADMIN_PROFIL) echo "<script type='text/javascript'>document.location.replace('../pages/index.php');</script>" ; ?> -->
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

<!-- generer les factures de tous les  compagnies du mois passe -->
<?php
function multiexplode($delimiters, $string)
{
    $ready = str_replace($delimiters, $delimiters[0], $string);
    $launch = explode($delimiters[0], $ready);
    return  $launch;
}
if (isset($_POST['confirmer'])) {
    $nomC = $_POST['compagnie'];
    $allCompa = "SELECT c.`id`, c.`nom` from `compagnie` c where c.`id` = '$nomC' ";
    $resultAllCompa = mysqli_query($bd, $allCompa);
    if ($resultAllCompa && mysqli_num_rows($resultAllCompa) > 0) {
        while ($rowrAllCompa = mysqli_fetch_array($resultAllCompa, MYSQLI_BOTH)) {
            $nomCompagnie = $rowrAllCompa[1];
            $idCompagnie =  $rowrAllCompa[0];

            // recupere les parametrers de la compagnie 
            $param = "SELECT p.`id`, p.`odre`, p.`code_iata`, p.`tva`, p.`adresse_de_facturation`, p.`tarif_ht` FROM `parametres` p WHERE p.`compagnie` = '$idCompagnie' ";
            $resultParam = mysqli_query($bd, $param);
            if ($resultParam && mysqli_num_rows($resultParam) > 0) {
                while ($rowrParam = mysqli_fetch_array($resultParam, MYSQLI_BOTH)) {
                    $odre    =     $rowrParam[1];
                    $code    =     $rowrParam[2];
                    $tva     =     $rowrParam[3];
                    $adresse =     $rowrParam[4];
                    $tarif   =     $rowrParam[5];
                }
            }

            // $dayOfPreviousMonth = date('Y-m-01', strtotime('-1 MONTH'));
            // $a_date =  date("Y-m-d");
            // $firstDay = date('Y-m-01'); 
            // $time = strtotime($dayOfPreviousMonth);
            // $month = date("m", $time);
            // $year = date("Y", $time);
            $year =  $_POST['annee'];
            $month =  $_POST['mois'];
            $dayOfPreviousMonth = $year . '-' . $month . '-01';
            $lastDay = date("Y-m-t", strtotime($dayOfPreviousMonth));


            //recupere les type de facturation de la compagnie
            $tfactu =  "SELECT  t.`compagnie_id` , t.`typefacturation_id`, tf.`statut` ";
            $tfactu .= "FROM `typefacturation_compagnie` t , `typefacturation` tf ";
            $tfactu .= "where t.`compagnie_id` = $idCompagnie and t.typefacturation_id = tf.id";
            $resultFactu = mysqli_query($bd, $tfactu);
            $idTypePayant = 0;
            $idTypeBusiness = 0;
            $idTypeAdmin = 0;
            $idTypeFirst = 0;
            $idTypeCarte = 0;
            $idTypeInv = 0;
            if ($resultFactu && mysqli_num_rows($resultFactu)) {
                while ($rowFactu = mysqli_fetch_array($resultFactu, MYSQLI_BOTH)) {
                    $nom = $rowFactu[2];
                    $orig = "SELECT o.`id` from `origine` o where o.`nom` = '$nom' ";
                    $resultOrigin = mysqli_query($bd, $orig);
                    if ($resultOrigin) {
                        $val = mysqli_fetch_assoc($resultOrigin);

                        if ($nom == "PAYANT") {
                            $idTypePayant = $val['id'];
                        }
                        if ($nom == "BUSINESS") {
                            $idTypeBusiness = $val['id'];
                        }
                        if ($nom == "CARTE") {
                            $idTypeCarte = $val['id'];
                        }
                        if ($nom == "INVITATION") {
                            $idTypeInv = $val['id'];
                        }
                        if ($nom == "ADMIN") {
                            $idTypeAdmin = $val['id'];
                        }
                        if ($nom == "FIRST") {
                            $idTypePayant = $val['id'];
                        }
                    }
                }
            }

            // recupere les contacts de la compagnie
            $qrycontact =  "SELECT  c.`id`, c.`libelle`, c.`type` ";
            $qrycontact .= "FROM `contact` c ";
            $qrycontact .= "where c.`compagnie` = $idCompagnie  order by c.type ASC";
            $resultcontactTel = mysqli_query($bd, $qrycontact);
            $resultcontactMail = mysqli_query($bd, $qrycontact);
            $resultcontactNom = mysqli_query($bd, $qrycontact);
            $contactNom = '';
            $contactMail = '';
            $contactTel = '';
            while ($rowContactTel = mysqli_fetch_array($resultcontactTel, MYSQLI_BOTH)) {
                if ($rowContactTel[2] == "tel") {
                    $contactTel = '/' . $rowContactTel[1];
                    break;
                }
            }
            while ($rowContactMail = mysqli_fetch_array($resultcontactMail, MYSQLI_BOTH)) {
                if ($rowContactMail[2] == "mail") {
                    $contactMail = $rowContactMail[1];
                    break;
                }
            }
            while ($rowContactNom = mysqli_fetch_array($resultcontactNom, MYSQLI_BOTH)) {
                if ($rowContactNom[2] == "nom") {
                    $contactNom = $rowContactNom[1];
                    break;
                }
            }

            // recupere les reservations de la compagnie
            // recupere les parametrers de la compagnie
            $dayOfPrev = $dayOfPreviousMonth . ' 00:00:00';
            $reser = "SELECT count(id) AS nb FROM `reservation` r WHERE r.`compagnie` = '$nomCompagnie'  AND  r.`date` >= '$dayOfPreviousMonth' AND r.`date` <= '$lastDay' AND  ";
            $reser .= "( r.`id_origine` = '$idTypeAdmin' OR r.`id_origine` = '$idTypeFirst' OR r.`id_origine` = '$idTypeCarte' OR r.`id_origine` = '$idTypeBusiness' OR r.`id_origine` = '$idTypeInv' OR r.`id_origine` = '$idTypePayant' ) AND r.`statut` <> '3' ";
            $resultReser = mysqli_query($bd, $reser);
            if ($resultReser) {
                // $values = mysqli_fetch_assoc($resultReser);
                // //$nombrePersonnes = 100;
                // $nombrePersonnes = $values['nb'];
                while ($rReser = mysqli_fetch_array($resultReser, MYSQLI_BOTH)) {
                    $nombrePersonnes = $rReser[0];
                }
                // var_dump($resultReser);
            } else {
                $nombrePersonnes = 1;
            }
            $prixTotalHt =  $tarif * $nombrePersonnes;

            if ($tva == 'ACTIF') {
                $prixTva = $prixTotalHt * 18 / 100;
            } else {
                $prixTva     =  0;
            }
            $prixTotal = $prixTotalHt + $prixTva;
           $prixTotalEuro = $prixTotal / 655.657;

            $data = '
    <img src="../img/logo2.png" alt="phto profil" style="width: 50%;margin-left:25%">
    <div style="border-bottom:2px solid black;"></div>
    <div class="col-lg-6" style="margin-top:30px;font-size:12px;">
       <label  style="font-weight: bold;">Infinite SA</label><br>
       <br>
       <div>LOT 18 CITE BIAGUI </div>
       <div>ROUTE DE L\'AEROPORT </div>
       <div>DAKAR - SENEGAL</div>
    </div>
    <div class="col-lg-6" style="margin-left:420px;margin-top:-80px;font-size:12px;">
       <div >Facture n° '     . $code . '.' . $month . '-' . $year . '</div>
       <div>Date de la facture: ' . $lastDay . ' </div>
       <br>
       <div>facturer à: '        . $nomCompagnie . '</div><br>
       <div>adresse:          ' . $adresse . '</div><br>
       <div>contact: <span>'
                . $contactMail . '' . $contactTel .
                '</span></div><br>
    </div>
    <table class="table table-bordered table-striped" style="border: 1px solid black;width:700px;background-color: #F7F2F1;">
       <thead style="background-color: #ECE3E1;">
           <tr>
               <th >Periode de facturation</th>
               <th>Tarif par PAX (XOF)</th>
               <th>nombre de PAX</th>
               <th>Montant</th>
           </tr>
       </thead>
       <tbody >
          <tr style="background-color: #FBF7F6 !important;" >
          <td style="border-top:1px solid black;height:20px;"> </td>
          <td style="border-top:1px solid black;"> </td>
          <td style="border-top:1px solid black;"> </td>
          <td style="border-top:1px solid black;"></td>
          </tr>
           <tr style="background-color: #FBF7F6 !important;">
               <td style="border-top:1px solid black;font-size:12px;"> ' . $month . '-' . $year . ' (du ' . $dayOfPreviousMonth . ' au ' . $lastDay . ')' . '</td>
               <td style="border-top:1px solid black;text-align:center;font-size:12px;">  ' . number_format($tarif, 0, ',', ' ') . '</td>
               <td style="border-top:1px solid black;text-align:center;font-size:12px;">' . number_format($nombrePersonnes, 0, ',', ' ') . ' </td>
               <td style="border-top:1px solid black;text-align:center;font-size:12px;">' . number_format($prixTotalHt, 0, ',', ' ') . ' XOF' . '</td>
           </tr>
           <tr style="background-color: #FBF7F6 !important;" >
           <td style="border-top:1px solid black;height:20px;"> </td>
           <td style="border-top:1px solid black;"> </td>
           <td style="border-top:1px solid black;"> </td>
           <td style="border-top:1px solid black;"></td>
           </tr>
           <tr style="background-color: #FBF7F6 !important;" >
           <td style="border-top:1px solid black;height:20px;"> </td>
           <td style="border-top:1px solid black;"> </td>
           <td style="border-top:1px solid black;"> </td>
           <td style="border-top:1px solid black;"></td>
           </tr>
           <tr style="background-color: #FBF7F6 !important;" >
           <td style="border-top:1px solid black;height:20px;"> </td>
           <td style="border-top:1px solid black;"> </td>
           <td style="border-top:1px solid black;"> </td>
           <td style="border-top:1px solid black;border-left:1px solid black;"></td>
           </tr>
           <tr style="background-color: #FBF7F6 !important;" >
           <td style="border-top:1px solid black;height:20px;padding-left:220px;font-size:12px" colspan="3"> Sous-total de la facture HT </td>
           <td style="border-left:1px solid black;border-top:1px solid black;text-align:center;font-size:12px">' . number_format($prixTotalHt, 0, ',', ' ') . ' XOF' . ' </td>
           </tr>
           <tr style="background-color: #FBF7F6 !important;" >
           <td colspan="3" style="padding-left:325px;height:50px;font-size:12px"> TVA (18%) </td>
           <td style="border-left:1px solid black;text-align:center;font-size:12px">' . number_format($prixTva, 0, ',', ' ') . ' XOF' . ' </td>
           </tr>
           <tr style="background-color: #F7F2F1 !important;" >
           <td colspan="3" style="padding-left:325px;height:20px;border-top:1px solid black;font-weight:bold;"> TOTAL TTC  </td>
           <td style="border-left:1px solid black;border-top:1px solid black;text-align:center;font-size:12px;font-weight:bold;">' . number_format($prixTotal, 0, ',', ' ') . ' XOF' . ' </td>
           </tr>
           <tr style="background-color: #F7F2F1 !important;" >
           <td colspan="3" style="padding-left:325px;height:20px;border-top:1px solid black;font-weight:bold;"> TOTAL TTC(euros)  </td>
           <td style="border-left:1px solid black;border-top:1px solid black;text-align:center;font-size:12px;font-weight:bold;">' . number_format($prixTotalEuro, 0, ',', ' ') . ' €' . ' </td>
           </tr>
       </tbody>
    </table>
    <br>
    <div style="font-size:10px;font-weight: bold;">Le règlement de la facture doit être effectué sous 30 jours par virement bancaire sur le compte suivant :
    </div>
    <div style="font-size:12px;">INTITULE : INFINITE SA </div>
    <div  style="font-size:12px;">SOCIETE GENERALE DE BANQUES AU SENEGAL</div>	
    <div  style="font-size:12px;">CODE PAYS : SN</div>	
    <div  style="font-size:12px;">CODE BANQUE : SN011 (opérations locale) / SN08SN011 (opération internationale)</div>
    <div  style="font-size:12px;">CODE AGENCE : 01005</div>
    <div  style="font-size:12px;">NUMERO DE COMPTE : 00500010180 6 RIB 59</div>	
    <div  style="font-size:12px;">IBAN : SN08SN011 01005 005000101806 59</div>	
    <div  style="font-size:12px;">CODE SWIFT : SGSNSNDA	</div>
    </div>
    <div style="font-size:10px;font-weight: bold;">En cas de retard de paiement, une pénalité égale à 5% du montant facturé sera appliquée</div>
    <br>
    <br>
    <br>
    <div style="margin-left:450px;font-size:12px;">La Direction Administrative
    </div>
    <img src="../img/signatureInfinite.png" alt="signature" style="margin-left:450px;width:28%">
    <br>
    <br>
    <div style="margin-left:170px;font-size:10px;">INFINITE SA Société Anonyme à Capital de 10.000.000 FCFA 
    </div>
    <div style="margin-left:195px;font-size:10px;">RCCM: SN DKR 2017 B 20488    NINEA: 64802642V3  
    </div>
    <div style="margin-left:220px;font-size:10px;">Point-E, Rue AX3, Immeuble Cathy, 2e étage  
    </div>
    <div style="margin-left:270px;font-size:10px;">www.infiniteairport.com 
    </div>
    ';
            $mpdf = new Mpdf();
            $mpdf->WriteHTML($data);
            $filename = preg_replace('/s/', ' ', $nomCompagnie);
            $filename .= '_' . $year . '_' . $month . '.pdf';
            $mpdf->Output('../files/' . $filename, 'F');
            $img_url = 'files/' . $filename;
            $numFacture =  $code . '.' . $month . '-' . $year;
            $datenow = date("Y-m-d H:i:s");
            $qryFirst = "INSERT INTO  factures(`id`,`date_creation`,`compagnie`,`numero_facture`,`img_url`,`name`,`montant_ht`,`date_debut`,`date_fin`,`prix_total`, `tva`) VALUES (NULL,'$datenow','$idCompagnie','$numFacture','$img_url','$filename','$prixTotalHt','$dayOfPreviousMonth','$lastDay','$prixTotal','$tva')";
            $result = mysqli_query($bd, $qryFirst);
            break;
        }
    }
}
?>
<?php
$annee = array(2017, 2018, 2019, 2020, 2021, 2022, 2023, 2024, 2025, 2026, 2027, 2028, 2029, 2030);
$monthArray = array('01', '02', '03', '04', '05', '06', '07', '08', '09', '10', '11', '12');
?>

<div class="modal fade" id="deleteFacture" role="dialog">
    <div class="modal-dialog">
        <form action="facture.php" method="POST">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <div>
                        Etes vous sùr de vouloir supprimer cette facture
                    </div>
                </div>
                <div class="modal-footer ">
                    <button class="btn btn-default" data-dismiss="modal">Annuler</button>
                    <button class="btn btn-secondary" type="submit" id="deleteFact" name="confirmeDeleteFact">confirmer</button>
                </div>
            </div>
        </form>
    </div>
</div>
<?php
if (isset($_POST['confirmeDeleteFact'])) {
    $idFac = $_POST['confirmeDeleteFact'];
    $qrySelect = "SELECT f.`name`, f.`img_url` from `factures` f where f.`id` = $idFac";
    $resultqrySelect = mysqli_query($bd, $qrySelect);
    if ($resultqrySelect) {
        while ($fact = mysqli_fetch_array($resultqrySelect, MYSQLI_BOTH)) {
            $imgUrl = '../' . $fact[1];
            $qryDelete = "DELETE from factures where id = $idFac";
            $resultqryDelete = mysqli_query($bd, $qryDelete);
            if ($resultqryDelete) {
                unlink($imgUrl);
            }
        }
    }
}
?>

<div class="modal fade" id="createModal" role="dialog">
    <div class="modal-dialog">
        <form action="facture.php" method="POST">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <?php
                $dayOfPreviousMonth = date('Y-m-01');
                $time = strtotime($dayOfPreviousMonth);
                $monthNow = date("m", $time);
                $yearNow = date("Y", $time);
                ?>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-lg-4">
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
                        <div class="col-lg-4">
                            <div class="form-group">
                                <label for="">Mois</label>
                                <select name="mois" id="mois" class="form-control">
                                    <?php
                                    foreach ($monthArray as $m) { ?>
                                        <option value="<?php echo $m ?>" <?php if ($m == $monthNow) echo 'selected="selected"'; ?>><?php echo $m ?></option>';

                                    <?php } ?>

                                </select>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="form-group">
                                <label for="">Annee</label>
                                <select name="annee" id="annee" class="form-control">
                                    <?php
                                    foreach ($annee as $an) { ?>
                                        <option value="<?php echo $an ?>" <?php if ($an == $yearNow) echo 'selected="selected"'; ?>><?php echo  $an ?></option> ';
                                    <?php } ?>

                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer ">
                    <button class="btn btn-default" data-dismiss="modal">Annuler</button>
                    <button class="btn btn-secondary" type="submit" id="confirmer" name="confirmer">confirmer</button>
                </div>
            </div>
        </form>
    </div>
</div>

<div id="page-wrapper">
    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">Factures</h1>
        </div>
        <!-- /.col-lg-12 -->
    </div>
    <!-- /.row -->
    <?php

    $limit = 10;
    $sqlTotalFact = "SELECT COUNT(*) FROM factures ";
    $resultTotalFac = mysqli_query($bd, $sqlTotalFact);
    $values = mysqli_fetch_row($resultTotalFac);
    $nbFacts = $values[0];
    // le nombre de pages dans la liste des reservations
    $totalpages = ceil($nbFacts / $limit);
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
        $mois = $_POST['mois'];
        $an = $_POST['annee'];
        $datesearch = $an . '-' . $mois;
        $filenameAnnee = 'searchAnnee_' . $_SESSION['SESS_FIRST_NAME'] . '_' . $_SESSION['SESS_LAST_NAME'] . '.txt';
        $filenameMois = 'searchMois_' . $_SESSION['SESS_FIRST_NAME'] . '_' . $_SESSION['SESS_LAST_NAME'] . '.txt';

        file_put_contents($filenameAnnee, $an);
        file_put_contents($filenameMois, $mois);
        $searchValueAnnee = file_get_contents($filenameAnnee);
        $searchValueMois = file_get_contents($filenameMois);
        $qry = "SELECT f.`id` , f.`compagnie`, f.`date_debut`, f.`date_fin`, f.`name`, f.`img_url`, f.`prix_total`, f.`tva`, f.`montant_ht`,f.`numero_facture`,f.`date_creation`";
        $qry .= "FROM `factures` f  where f.`date_fin` like '%$datesearch%' order by  f.`date_creation` desc ";
        $result = mysqli_query($bd, $qry);

        $qryca = "SELECT SUM(montant_ht) ";
        $qryca .= "FROM `factures` f where f.`date_debut` like '%$datesearch%' order by  f.`date_creation` desc ";
        $resultChiffreAff = mysqli_query($bd, $qryca);

        $qrycattc = "SELECT SUM(prix_total) ";
        $qrycattc .= "FROM `factures` f where f.`date_debut` like '%$datesearch%' order by  f.`date_creation` desc ";
        $resultChiffreAffttc = mysqli_query($bd, $qrycattc);
    } else {
        //Create q
        $filenameAnnee = 'searchAnnee_' . $_SESSION['SESS_FIRST_NAME'] . '_' . $_SESSION['SESS_LAST_NAME'] . '.txt';
        $filenameMois = 'searchMois_' . $_SESSION['SESS_FIRST_NAME'] . '_' . $_SESSION['SESS_LAST_NAME'] . '.txt';
        $dayOfPreviousMonth = date('Y-m-01');
        $time = strtotime($dayOfPreviousMonth);
        $monthNow = date("m", $time);
        $yearNow = date("Y", $time);
        $datesearch = $yearNow . '-' . $monthNow;
        $filenameAnnee = 'searchAnnee_' . $_SESSION['SESS_FIRST_NAME'] . '_' . $_SESSION['SESS_LAST_NAME'] . '.txt';
        $filenameMois = 'searchMois_' . $_SESSION['SESS_FIRST_NAME'] . '_' . $_SESSION['SESS_LAST_NAME'] . '.txt';
        file_put_contents($filenameAnnee, $yearNow);
        file_put_contents($filenameMois, $monthNow);
        $searchValueAnnee = file_get_contents($filenameAnnee);
        $searchValueMois = file_get_contents($filenameMois);
        // }
        $qry = "SELECT f.`id` , f.`compagnie`, f.`date_debut`, f.`date_fin`, f.`name`, f.`img_url`, f.`prix_total`, f.`tva`,f.`montant_ht`,f.`numero_facture`,f.`date_creation`";
        $qry .= "FROM `factures` f   where f.`date_debut` like '%$dayOfPreviousMonth%' order by  f.`date_creation` desc ";
        $result = mysqli_query($bd, $qry);

        $qryca = "SELECT SUM(montant_ht) ";
        $qryca .= "FROM `factures` f where f.`date_debut` like '%$dayOfPreviousMonth%' order by  f.`date_creation` desc ";
        $resultChiffreAff = mysqli_query($bd, $qryca);

        $qrycattc = "SELECT SUM(prix_total) ";
        $qrycattc .= "FROM `factures` f where f.`date_debut` like '%$dayOfPreviousMonth%' order by  f.`date_creation` desc ";
        $resultChiffreAffttc = mysqli_query($bd, $qrycattc);
    }





    //Check whether the query was successful or not

    echo ' <!-- <form action="includes/generatepdf.php" method="post"> -->';
    echo '<div class="row">';
    echo '<div class="col-lg-12">';
    echo ' <div class="panel panel-default">';
    echo '<div class="panel-head">';
    // echo '<form action="facture.php" method="POST">';
    echo '<button name="generer" id="generer" class="btn btn-primary" style="margin-left: 15px;margin-top: 5px;">
                                    Generer facture 
                               </button>';
    if ($result) {
        if (mysqli_num_rows($result) > 0) {
            echo '<a href="uploadfactureExcel.php?searchValueMois=' . $searchValueMois . '&searchValueAnnee=' . $searchValueAnnee . '" style="margin-left:15px;">';
            echo '<button class="btn btn-primary" type="submit" name="exportExcel">';
            echo '<i class="fa fa-download"></i>';
            echo '<i class="fa fa-file-excel-o"></i>';
            echo '</button></a>';
            echo '</div>';
        }
    }
    if ($result) {
        if (mysqli_num_rows($result) > 0) {

    ?>
            <div class="panel-body">
                <table width="100%" style="font-size: 14px" class="table table-bordered ">
                    <thead>
                        <tr>
                            <!-- <th>COMPAGNIE</th> -->
                            <th style="width: 4%">Date </th>
                            <th style="width: 4%">Heure </th>
                            <th style="width: 8%">Compagnie</th>
                            <th style="width: 7%">Date de facture</th>
                            <th style="width: 5%">Numéro facture</th>
                            <th style="width: 5%">Montant ht(XOF)</th>
                            <th style="width: 2%">Tva</th>
                            <th style="width: 5%">Montant ttc(XOF)</th>
                            <th style="width: 5%">Montant ttc(EUROS)</th>
                            <th style="width: 5%"></th>
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
                        echo '<td>' . '<label  class="lab">' . $year . '/' . $month . '/' . $day . '</label></td>';
                        echo '<td>' . '<label  class="lab">' . $hour . ':' . $min . ':' . $sec . '</label></td>';
                        echo '<td>';
                        echo '<label name="compagnie" class="lab">' . $nom . '</label>';
                        echo '</td>';
                        // echo '<td>' . '<label  class="lab">' . $row[2] . '</label></td>';
                        echo '<td>' . '<label  class="lab">' . $row[3] . '</label></td>';
                        echo '<td>' . '<label  class="lab">' . $row[9] . '</label></td>';
                        $montanthtdel = number_format($row[8], 0, ',', ' ');
                        echo '<td>' . '<label  class="lab">' . $montanthtdel . '</label></td>';
                        $tvaFac = $row[7];
                        if ($tvaFac == 'ACTIF') {
                            echo '<td>' . '<input type="checkbox" checked disabled class="form-check"></td>';
                        } else {
                            echo '<td>' . '<input type="checkbox" disabled class="form-check"></td>';
                        }
                        $montantdel = number_format($row[6], 0, ',', ' ');
                        $montanteuros =  number_format($row[6] / 655.657, 0, ',', ' ');
                        echo '<td>' . '<label  class="lab">' . $montantdel . '</label></td>';
                        echo '<td>' . '<label  class="lab">' . $montanteuros . '</label></td>';

                        // echo '<td>' . $row[3] . '</td>';


                        echo "<td>
                                             <a href=' $url' class='btn btn-primary' download><i class='fa fa-download' ></i></a>
                                             <span>
                                             <a href='deleteFacture.php?idFacture=$row[0]'>
                                             <button class='btn btn-danger' type='submit' id='openDelFact' name='deleteFact' >
                                             <i class='fa fa-remove' ></i>
                                             </button>
                                             <a>
                                             </span>
                                             </td>";
                        echo '</tr>';
                    }
                    while ($rowca = mysqli_fetch_array($resultChiffreAff, MYSQLI_BOTH)) {
                        $chiffreAffaireht = number_format($rowca[0], 0, ',', ' ');
                    }
                    while ($rowcattc = mysqli_fetch_array($resultChiffreAffttc, MYSQLI_BOTH)) {
                        $chiffreAffairettc = number_format($rowcattc[0], 0, ',', ' ');
                        $chiffreAffairettcEuros = number_format($rowcattc[0] / 655.657, 0, ',', ' ');
                    }
                    echo '<tr>';
                    echo '<td>' . '<label  class="lab">' . '' . '</label></td>';
                    echo '<td>' . '<label  class="lab">' . '' . '</label></td>';
                    echo '<td>' . '<label  class="lab">' . '' . '</label></td>';
                    echo '<td>' . '<label  class="lab">' . '' . '</label></td>';
                    echo '<td>' . '<label  class="lab">' . '' . '</label></td>';
                    echo '<td>' . '<label  class="lab">' . '' . '</label></td>';
                    echo '<td>' . '<label  class="lab">' . '' . '</label></td>';
                    echo '<td>' . '<label  class="lab">' . '' . '</label></td>';
                    echo '<td>' . '<label  class="lab">' . '' . '</label></td>';
                    echo '<td>' . '<label  class="lab">' . '' . '</label></td>';

                    echo '</tr>';
                    echo '<tr>';
                    echo '<td colspan="2">' . '<label  class="lab" style="font-weight:bold;color:red";>' . 'chiffre d\'affaire du mois' . '</label></td>';
                    echo '<td>' . '<label  class="lab">' . '' . '</label></td>';
                    echo '<td>' . '<label  class="lab">' . '' . '</label></td>';
                    echo '<td>' . '<label  class="lab" style="font-size:23px;">' . ' ' . '</label></td>';
                    echo '<td>' . '<label  class="lab" style="font-weight:bold;color:red";>' . $chiffreAffaireht . '</label></td>';
                    echo '<td>' . '<label  class="lab" style="font-size:23px;">' . ' ' . '</label></td>';
                    echo '<td>' . '<label  class="lab" style="font-weight:bold;color:red";>' . $chiffreAffairettc . '</label></td>';
                    echo '<td>' . '<label  class="lab" style="font-weight:bold;color:red";>' . $chiffreAffairettcEuros . '</label></td>';
                    echo '<td >' . '<label  class="lab" style="font-size:23px;">' . ' ' . '</label></td>';

                    echo '</tr>';
                } else {
                    echo '<div style="color:red;text-align:center;font-weight:bold;">Aucune facture n\'a été enregistré pour ce mois</div>';
                }


                    ?>
                    </tbody>
                    <!-- </form> -->

                    <form action="facture.php" method="POST">
                        <div class="row" style="margin-left:72%;">

                            <div class="col-lg-4">
                                <div class="form-group" style="margin-top: -45%;">
                                    <label for="">Mois</label>
                                    <select name="mois" id="mois" class="form-control">
                                        <?php
                                        foreach ($monthArray as $m) { ?>
                                            <option value="<?php echo $m ?>" <?php if ($m == $searchValueMois) echo 'selected="selected"' ?>><?php echo $m ?>
                                            </option>
                                        <?php } ?>

                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="form-group" style="margin-top: -45%;">
                                    <label for="">Annee</label>
                                    <select name="annee" id="annee" class="form-control">
                                        <?php
                                        foreach ($annee as $an) { ?>
                                            <option value="<?php echo $an ?>" <?php if ($an == $searchValueAnnee) echo 'selected ="selected"' ?>><?php echo $an ?>
                                            </option>
                                        <?php } ?>

                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-2" style="margin-top: -3%;">
                                <button class="btn btn-primary" type="submit" name="searchSubmit">
                                    <span class="fa fa-search"></span>
                                </button>
                            </div>

                        </div>
                    </form>

                </table>
                <!-- <div style="margin-top: 15px;">
                        <div>
                            page <?php echo $currentpage . '/' . $totalpages ?>
                        </div>
                    </div> -->
                <!-- <div class="pull-right" style="margin-top: -15px;">
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
                    </div> -->

            </div>
            <!-- /.panel-body -->
</div>
<!-- /.panel -->
</div>
<!-- /.col-lg-12 -->
</div>
<!-- </form> -->
<?php
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
<script>
    $(window).load(function() {
        // Animate loader off screen
        $(".se-pre-con").fadeOut("slow");;
    });
</script>

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
    $('#generer').click(function() {
        $('#createModal').modal('show');
    });
</script>
<script>

</script>

<!-- Page-Level Demo Scripts - Tables - Use for reference -->
<style>
    .lab {
        font-weight: normal;
        font-size: 12px;
    }
</style>

</body>

</html>