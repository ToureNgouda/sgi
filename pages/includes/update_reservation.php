<?php
session_start();
//Include database connection details
require_once('connection.php');

date_default_timezone_set("UTC");

//Array to store validation errors
$errmsg_arr = array();

//Validation error flag
$errflag = false;

//Function to sanitize values received from the form. Prevents SQL injection
function clean($str)
{
	echo "str: " . $str;
	$str = @trim($str);
	if (get_magic_quotes_gpc()) {
		$str = stripslashes($str);
	}
	return mysqli_real_escape_string($str);
}

//Sanitize the POST values
$type = $_POST['action'];

$civilite = $_POST['civilite'];
$nom = $_POST['nom'];
$prenom = $_POST['prenom'];
$jour = $_POST['jour'];
$mois = $_POST['mois'];
$annee = $_POST['annee'];
$nationalite = $_POST['nationalite'];
$num_pass = $_POST['num_pass'];
$jour_pass = $_POST['jour_pass'];
$mois_pass = $_POST['mois_pass'];
$annee_pass = $_POST['annee_pass'];
$email = $_POST['email'];
$telephone = $_POST['telephone'];
$vol = $_POST['vol'];
$compagnie = mysqli_real_escape_string($bd, $_POST['compagnie']);
$porte = $_POST['porte'];
$dateresa = $_POST['dateresa'];
$tranche = '1';
$salon = $_POST['salon'];
$age = $_POST['age'];

$origine = $_POST['origine'];

if ($origine == '4') {
	$invitant = $_POST['invitant'];
	$carte = '';
	$admin = '';
} else {
	if ($origine == '5') {
		$invitant = '';
		$admin = '';
		$carte = $_POST['numcarte'];
	} else {
		if ($origine == '8') {
			$invitant = '';
			$admin = $_POST['admin'];
			$carte = '';
		} else {
			$carte = '';
			$invitant = '';
			$admin = '';
		}
	}
}

if ($dateresa != '') {
	list($day, $month, $year) = explode('/', $dateresa);
	$dateresa = $year . '-' . $month . '-' . $day;
}

$today = date("Y-m-d H:i:s");

$dateNaissance = '';
try {
	$date = new DateTime($jour . '-' . $mois . '-' . $annee);
	$dateNaissance = $date->format('Y-m-d');
} catch (Exception $e) {
	$dateNaissance = '';
}

$datePass = '';
try {
	$date = new DateTime($jour_pass . '-' . $mois_pass . '-' . $annee_pass);
	$datePass = $date->format('Y-m-d');
} catch (Exception $e) {
	$datePass = '';
}

$id_user = $_SESSION['SESS_MEMBER_ID'];

if (isset($_GET['id']) && (trim($_GET['id']) != '')) {
	if (isset($_GET['id_client']) && (trim($_GET['id_client']) != '')) {
		$id_resa = $_GET['id'];
		$id_client = $_GET['id_client'];
		switch ($type) {
			case "valider":
				$statut = "2";
				$date_validation = $today;
				break;
			case "modifier":
				$statut = "1";
				$date_validation = "";
				break;
			case "annuler":
				$statut = "3";
				$date_validation = "";
				break;
		}

		if ($statut == "3") {
			$qryResa = "UPDATE reservation ";
			$qryResa .= "SET `statut` = '$statut', `date_update` = '$today', `user_update` = '$id_user' ";
			$qryResa .= "WHERE id= $id_resa ";
			$resultResa = mysqli_query($bd, $qryResa);
			if ($resultResa) {
				header("location: ../reservations.php?statut=Uok");
				exit;
			} else {
				die("Query failed");
			}
		} else {
			$qry = "UPDATE client ";
			$qry .= "SET `civilite` = '$civilite', `nom` = '$nom', `prenom` = '$prenom', `email` = '$email', `telephone` = '$telephone', `naissance` = '$dateNaissance', `nationnalite` = '$nationalite', `num_passeport` = '$num_pass', `delivrance` = '$datePass' ";
			$qry .= "WHERE id= $id_client ";

			$result = mysqli_query($bd, $qry);

			//Check whether the query was successful or not
			if ($result) {
				$qryResa = "UPDATE reservation ";
				$qryResa .= "SET `date` = '$dateresa', `id_tranche` = '$tranche', `vol` = '$vol', `compagnie` = '$compagnie', `porte` = '$porte', `salon` = '$salon', `statut` = '$statut', `id_origine` = '$origine', `date_validation` = '$date_validation' , `user_validation` = '$id_user', `date_update` = '$today', `user_update` = '$id_user', `invitant` = '$invitant', `carte` = '$carte', `admin` = '$admin', `id_age` = '$age' ";
				$qryResa .= "WHERE id= $id_resa ";
				$resultResa = mysqli_query($bd, $qryResa);
				if ($resultResa) {
					header("location: ../reservations.php?statut=Uok");
					exit;
				} else {
					die("Query failed");
				}
			} else {
				die("Query failed");
			}
		}
	}
} else {
	switch ($type) {
		case "valider":
			//statut valide
			$statut = "2";
			$date_validation = $today;
			break;
		case "enregistrer":
			$statut = "1";
			$date_validation = "";
			break;
	}
	// verifie doublon sur le numero de reservation
	$qrydoub = "SELECT r.`id`,r.`date` FROM `reservation` r where r.`porte` = '$porte' and r.`compagnie` = '$compagnie'";
	$resultqrydoub = mysqli_query($bd, $qrydoub);
	$isDoublon = false;
	if ($resultqrydoub && mysqli_num_rows($resultqrydoub) > 0) {
		while($rwd = mysqli_fetch_array($resultqrydoub,MYSQLI_BOTH)){
			 $d = $rwd[1];
			 if($dateresa == $d){
				$isDoublon = true;
			 }
		}
	} 
	if($isDoublon){
		header("location: ../new_reservation.php?statut=ko"); 
	}else {
		//Create query
		$qry = "INSERT INTO client ";
		$qry .= "(`id`, `civilite`, `nom`, `prenom`, `email`, `telephone`, `naissance`, `nationnalite`, `num_passeport`, `delivrance`, `date_ajout`) VALUES ";
		$qry .= "(NULL, '$civilite', '$nom', '$prenom', '$email', '$telephone', '$dateNaissance', '$nationalite', '$num_pass', '$datePass', '$today');";
		$result = mysqli_query($bd, $qry);

		//Check whether the query was successful or not
		if ($result) {
			$id_client = mysqli_insert_id($bd);
			if ($id_client != '') {
				$qryResa = "INSERT INTO reservation ";
				$qryResa .= "(`id`, `id_client`, `date`, `id_tranche`, `vol`, `compagnie`, `porte`, `statut`, `id_origine`, `salon`, `date_validation`, `user_validation`, `date_ajout`, `user_ajout`, `date_update`, `user_update`, `invitant`, `carte`, `admin`, `id_age`) VALUES ";
				$qryResa .= "(NULL, '$id_client', '$dateresa', '$tranche', '$vol', '$compagnie', '$porte', '$statut', '$origine', '$salon', '$date_validation', '$id_user', '$today', '$id_user', '$today', '$id_user', '$invitant', '$carte', '$admin', '$age');";
				$resultResa = mysqli_query($bd, $qryResa);
				if ($resultResa) {
					$id_Resa = mysqli_insert_id($bd);
					header("location: ../new_reservation.php?statut=Cok");
					exit;
				} else {
					die("Query failed : " . $qryResa);
				}
			}
		} else {
			die("Query failed : " . $qry);
		}
	}
}
