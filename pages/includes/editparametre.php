
<?php
session_start();
//Include database connection details
require_once('connection.php');

date_default_timezone_set("UTC");

//Array to store validation errors
$errmsg_arr = array();

//Validation error flag
$errflag = false;


//Sanitize the POST values

$id = $_POST['id'];
$ordre = $_POST['ordre'];
$code_iata = $_POST['codeiata'];
$tva = $_POST['tva'];
$tarif = $_POST['tarif'];
$adresse = $_POST['adresse'];

$qry = "UPDATE parametres ";
$qry .= "SET `ordre` = '$ordre', `code_iata` = '$code_iata', `tva` = '$tva', `adresse_de_facturation` = '$adresse', `tarif_ht` = '$tarif' ";
$qry .= "WHERE id= $id ";
$result = mysqli_query($bd, $qry);
if($result){
    echo "<script type='text/javascript'>document.location.replace('../parametre.php');</script>"; 
}else{
    echo "<script type='text/javascript'>document.location.replace('../parametre.php');</script>"; 
 
}

?>
<script>
     console.log("edit php appele");
</script>
</body>
</html>
