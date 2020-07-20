<?php

require_once('connection.php');

use Mpdf\Mpdf;

require_once __DIR__ . '/../../vendor/autoload.php';


$mpdf = new Mpdf();
$fac = 500;
$data = '
<img src="../../img/logo2.png" alt="phto profil" style="width: 50%;margin-left:25%">
<div style="border-bottom:2px solid black;"></div>
<div class="col-lg-6" style="margin-top:30px;font-size:12px;">
   <label  style="font-weight: bold;">Infinite SA</label><br>
   <br>
   <div>LOT 18 CITE BIAGUI </div>
   <div>ROUTE DE L\'AEROPORT </div>
   <div>DAKAR - SENEGAL</div>
</div>
<div class="col-lg-6" style="margin-left:420px;margin-top:-80px;font-size:12px;">
   <div >Facture n° '.$fac.'</div>
   <div>Date de la facture</div>
   <br>
   <div>facturer à:</div><br>
   <div>adresse:</div><br>
   <div>contact:</div><br>
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
           <td style="border-top:1px solid black;">bla </td>
           <td style="border-top:1px solid black;"> bala</td>
           <td style="border-top:1px solid black;">bal </td>
           <td style="border-top:1px solid black;">bla</td>
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
       <td style="border-top:1px solid black;height:20px;padding-left:220px;" colspan="3"> Sous-total de la facture HT </td>
       <td style="border-left:1px solid black;border-top:1px solid black;">valeur </td>
       </tr>
       <tr style="background-color: #FBF7F6 !important;" >
       <td colspan="3" style="padding-left:325px;height:50px;"> TVA (18%) </td>
       <td style="border-left:1px solid black;">valeur </td>
       </tr>
       <tr style="background-color: #F7F2F1 !important;" >
       <td colspan="3" style="padding-left:325px;height:20px;border-top:1px solid black;"> TOTAL TTC  </td>
       <td style="border-left:1px solid black;border-top:1px solid black;">valeur </td>
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
         

$mpdf->WriteHTML($data);
$filename = "filename.pdf";
$mpdf->Output('../../files/'.$filename, 'F');
$img_url = 'files/'.$filename;
$qryFirst = "INSERT INTO  factures(id,compagnie,`img_url`,`name`,`date_debut`,`date_fin`) VALUES (NULL,'6','$img_url','$filename','2020-03-01','2020-03-31')";
$result = mysqli_query($bd, $qryFirst);

// echo $file;
    if($result){
        echo date('yy-m-j');
    }
?>

<!-- <div class="col-lg-6">
   <label for="">Infinite SA</label><br>
   <div>LOT 18 CITE BIAGUI </div>
   <div>ROUTE DE L'AEROPORT </div>
   <div>DAKAR - SENEGAL</div>
</div>
<div class="col-lg-6">
   <div>Facture n° </div>
   <div>Date de la facture</div>
   <div>facturer à</div>
   <div>adresse</div>
   <div>contact</div>
</div> -->
<script src="https://code.jquery.com/jquery-1.12.4.js"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>

<!-- Bootstrap Core JavaScript -->
<script src="../../vendor/bootstrap/js/bootstrap.min.js"></script>

<!-- Metis Menu Plugin JavaScript -->
<script src="../../vendor/metisMenu/metisMenu.min.js"></script>

<!-- DataTables JavaScript -->
<script src="../../vendor/datatables/js/jquery.dataTables.min.js"></script>
<script src="../../vendor/datatables/js/dataTables.buttons.min.js"></script>
<script src="../../vendor/datatables/js/buttons.flash.min.js"></script>
<script src="../../vendor/datatables/js/jszip.min.js"></script>
<script src="../../vendor/datatables/js/pdfmake.min.js"></script>
<script src="../../vendor/datatables/js/vfs_fonts.js"></script>
<script src="../../vendor/datatables/js/buttons.html5.min.js"></script>
<script src="../../vendor/datatables/js/buttons.print.min.js"></script>
<script src="../../vendor/datatables-responsive/dataTables.responsive.js"></script>

</body>


</html>