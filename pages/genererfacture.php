<?php
require_once('header.php');
//Include database connection details
require_once('includes/connection.php');

use Mpdf\Mpdf;

require_once __DIR__ . '/../vendor/autoload.php';
?>
<?php if ($_SESSION['SESS_PROFIL'] != $ADMIN_PROFIL) echo "<script type='text/javascript'>document.location.replace('../pages/index.php');</script>"; ?>
<!-- Modal -->


<!-- generer les factures de tous les  compagnies du mois passe -->
<?php
if (isset($_POST['confirmer'])) {

    $allCompa = "SELECT c.`id`, c.`nom` from `compagnie` c ";
    $resultAllCompa = mysqli_query($bd, $allCompa);
    if ($resultAllCompa && mysqli_num_rows($resultAllCompa) > 0) {
        while ($rowrAllCompa = mysqli_fetch_array($resultAllCompa, MYSQLI_BOTH)) {
            $nomCompagnie = $rowrAllCompa[1];
            $idCompagnie =  6;

            // recupere les parametrers de la compagnie 
            $param = "SELECT p.`id`, p.`odre`, p.`code_iata`, p.`tva`, p.`adresse_de_facturation`, p.`tarif_ht` FROM `parametres` p WHERE p.`compagnie` = $idCompagnie ";
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

            $dayOfPreviousMonth = date('Y-m-01', strtotime('-1 MONTH'));
            // $a_date =  date("Y-m-d");
            // $firstDay = date('Y-m-01'); 
            $lastDay = date("Y-m-t", strtotime($dayOfPreviousMonth));
            $time = strtotime($dayOfPreviousMonth);
            $month = date("m", $time);
            $year = date("Y", $time);

            //recupere les type de facturation de la compagnie
            $tfactu =  "SELECT  t.`compagnie_id` , t.`typeFacturation_id`, tf.`statut` ";
            $tfactu .= "FROM `typeFacturation_compagnie` t , `typeFacturation` tf ";
            $tfactu .= "where t.`compagnie_id` = $idCompagnie and t.typeFacturation_id = tf.id";
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

            // recupere les reservations de la compagnie
            // recupere les parametrers de la compagnie
            $nombrePersonnes = 0;
            $reser = "SELECT count(id) AS nb FROM reservation WHERE compagnie = 'ROYAL AIR MAROC' AND  date >= '$dayOfPreviousMonth' AND date <= '$lastDay' AND ";
            $reser .= "( id_origine = '$idTypeAdmin' or id_origine = '$idTypeFirst' or id_origine = '$idTypeCarte' or id_origine = '$idTypeBusiness' or id_origine = '$idTypeInv' or id_origine = '$idTypePayant' ) ";
            $resultReser = mysqli_query($bd, $reser);
            if ($resultReser && mysqli_num_rows($resultReser) > 0) {
                $values = mysqli_fetch_assoc($resultReser);
                //$nombrePersonnes = 100;
                $nombrePersonnes = $values['nb'];
                // var_dump($resultReser);
            }
            $prixTotalHt =  $tarif * $nombrePersonnes;
            $prixTva     =  0;

            if ($tva == "ACTIF") {
                $prixTva = $prixTotalHt * 18 / 100;
            }
            $prixTotal = $prixTotalHt + $prixTva;


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
       <div>contact: </div><br>
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
               <td style="border-top:1px solid black;text-align:center;font-size:12px;">  ' . $tarif . '</td>
               <td style="border-top:1px solid black;text-align:center;font-size:12px;">' . $nombrePersonnes . ' </td>
               <td style="border-top:1px solid black;text-align:center;font-size:12px;">' . $prixTotalHt . '</td>
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
           <td style="border-left:1px solid black;border-top:1px solid black;text-align:center;font-size:12px">' . $prixTotalHt . ' </td>
           </tr>
           <tr style="background-color: #FBF7F6 !important;" >
           <td colspan="3" style="padding-left:325px;height:50px;font-size:12px"> TVA (18%) </td>
           <td style="border-left:1px solid black;text-align:center;font-size:12px">' . $prixTva . ' </td>
           </tr>
           <tr style="background-color: #F7F2F1 !important;" >
           <td colspan="3" style="padding-left:325px;height:20px;border-top:1px solid black;font-weight:bold;"> TOTAL TTC  </td>
           <td style="border-left:1px solid black;border-top:1px solid black;text-align:center;font-size:12px">' . $prixTotal . ' </td>
           </tr>
       </tbody>
    </table>
    <br>
    <div style="font-size:10px;">Le règlement de la facture doit être effectué sous 30 jours par virement bancaire sur le compte suivant :
    </div>
    <div style="width:250px;height:80;background-color:yellow;text-align:center;font-size:12px;padding-top:70px;">REFERENCES BANCAIRES</div>
    <div style="font-size:10px;">En cas de retard de paiement, une pénalité égale à 5% du montant facturé sera appliquée</div>
    <br>
    <br>
    <br>
    <div style="margin-left:450px;font-size:12px;">La Direction Administrative
    </div>
    <br>
    <br>
    <div style="margin-left:450px;font-size:12px;color:red;">SIGNATURE
    </div>
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
            $filename = preg_replace('/s/', '', $nomCompagnie);
            $filename .= '_' . $year . '_' . $month . '.pdf';
            $mpdf->Output('../files/' . $filename, 'F');
            $img_url = 'files/' . $filename;
            $qryFirst = "INSERT INTO  factures(id,compagnie,`img_url`,`name`,`date_debut`,`date_fin`,`prix_total`, `tva`) VALUES (NULL,'$idCompagnie','$img_url','$filename','$dayOfPreviousMonth','$lastDay','$prixTotal','$tva')";
            $result = mysqli_query($bd, $qryFirst);
            break;
        }
    }
}
?>
<?php
 $annee = array(2017,2018,2019,2020,2021,2022,2023,2024,2025,2026,2027,2027,2028,2029,2030);
 $monthArray = array('01','02','03','04','05','06','07','08','09','10','11','12');
?>


<div class="modal fade" id="createModal" role="dialog">
    <div class="modal-dialog">
    <form action="facture.php" method="POST">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
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
                            <select name="" id="" class="form-control">
                                <?php
                                   foreach($monthArray as $m){
                                       echo '<option value="'.$m.'">'.$m.'</option>';
                                   }
                                ?>
                               
                            </select>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="form-group">
                            <label for="">Annee</label>
                            <select name="" id="" class="form-control">
                                <?php
                                foreach($annee as $an){
                                   echo '<option value="'.$an.'">'.$an.'</option> ';
                                }
                                ?>
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

    //Create query
    $qry = "SELECT f.`compagnie`, f.`date_debut`, f.`date_fin`, f.`name`, f.`img_url`, f.`prix_total`, f.`tva`";
    $qry .= "FROM `factures` f ";
    // $qry .= "where p.`compagnie` = c.`id`";
    $result = mysqli_query($bd, $qry);


    //Check whether the query was successful or not

    echo ' <!-- <form action="includes/generatepdf.php" method="post"> -->';
    echo '<div class="row">';
    echo '<div class="col-lg-12">';
    echo ' <div class="panel panel-default">';
    echo '<div class="panel-head">';
    // echo '<form action="facture.php" method="POST">';
    echo '     <button name="generer" id="generer" class="btn btn-primary" style="margin-left: 15px;margin-top: 5px;">
                                    Generer facture
                               </button>';
    // echo '  </form>';
    echo '  </div>';
    if ($result) {
        if (mysqli_num_rows($result) > 0) {

    ?>
            <div class="panel-body">
                <table width="100%" style="font-size: 14px" class="table table-bordered " >
                    <thead>
                        <tr>
                            <!-- <th>COMPAGNIE</th> -->
                            <th style="width: 10%">Compagnie</th>
                            <th style="width: 8%">Date Debut</th>
                            <th style="width: 8%">Date Fin</th>
                            <th style="width: 6%">Montant</th>
                            <th style="width: 4%">Tva</th>
                            <th style="width: 3%"></th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php
                    while ($row = mysqli_fetch_array($result, MYSQLI_BOTH)) {
                        $idComp = $row[0];
                        $tfactu =  "SELECT  c.`id` , c.`nom` ";
                        $tfactu .= "FROM `compagnie` c ";
                        $tfactu .= "where c.`id` = $idComp";
                        $resultCompagnie = mysqli_query($bd, $tfactu);
                        if ($resultCompagnie && mysqli_num_rows($resultCompagnie) > 0) {
                            while ($rowC = mysqli_fetch_array($resultCompagnie, MYSQLI_BOTH)) {
                                $nom = $rowC[1];
                            }
                        }
                        $url = '../' . $row[4];
                        echo  '<tr>';
                        echo '<th scope="row">';
                        echo '<div name="compagnie" class="lab">' . $nom . '</div>';
                        echo '</th>';
                        echo '<td>' . '<label  class="lab">' . $row[1] . '</label></td>';
                        echo '<td>' . '<label  class="lab">' . $row[2] . '</label></td>';
                        echo '<td>' . '<label  class="lab">' . $row[5] . '</label></td>';
                        $tvaFac = $row[6];
                        if($tvaFac == "ACTIF"){
                            echo '<td>' . '<input type="checkbox" checked disabled class="form-check"></td>'; 
                        }else{
                            echo '<td>' . '<input type="checkbox" disabled class="form-check"></td>';
                        }
                       
                        // echo '<td>' . $row[3] . '</td>';


                        echo '<td>
										     <a href="' . $url . '" class="btn btn-primary" download><i class="fa fa-download" ></i></a>
											 </td>';
                        echo '</tr>';
                    }
                }

                    ?>
                    </tbody>
                    <!-- <tfoot>
                                    <tr>
                                    <button class="btn btn-primary">
                                Generer facture 
                            </button>
                                    </tr>
                                </tfoot> -->

                </table>
                <div class="pull-right">
                    <button class="btn btn-primary">
                        Prev
                    </button>
                    <button class="btn btn-primary">
                        Next
                    </button>
                </div>

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
    })
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