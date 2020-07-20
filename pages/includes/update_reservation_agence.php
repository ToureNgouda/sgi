<?php
	session_start();
	//Include database connection details
	require_once('connection_agence.php');
	
	date_default_timezone_set("UTC");
 
	//Array to store validation errors
	$errmsg_arr = array();
 
	//Validation error flag
	$errflag = false;
    
	function multiexplode ($delimiters,$string) {
        $ready = str_replace($delimiters, $delimiters[0], $string);
        $launch = explode($delimiters[0], $ready);
        return  $launch;
    }    

	//Function to sanitize values received from the form. Prevents SQL injection
	function clean($str) {
		echo "str: ".$str;
		$str = @trim($str);
		if(get_magic_quotes_gpc()) {
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
	$dateresa = $_GET['date'];
	$tranche = $_GET['tranche'];
	
	//echo ($dateresa."  ".$tranche);
	
	$origine = '2';
	
	$invitant = '';
	
	if ($dateresa != '')
	{
		list($day, $month, $year) = multiexplode(array("/",".","-",":"), $dateresa);
		$dateresa = $year.'-'.$month.'-'.$day ;
	}
	
	$today = date("Y-m-d H:i:s");
	
	$dateNaissance = '';	
	try {
		$date = new DateTime($jour.'-'.$mois.'-'.$annee);
		$dateNaissance = $date->format('Y-m-d');
	} catch (Exception $e) {
		$dateNaissance = '';
	}

	$datePass = '';
	try {
		$date = new DateTime($jour_pass.'-'.$mois_pass.'-'.$annee_pass);
		$datePass = $date->format('Y-m-d');
	} catch (Exception $e) {
		$datePass = '';
	}
	
	$id_user = $_SESSION['SESS_MEMBER_ID'];
	$agence = $_SESSION['SESS_SALON_ID'];
	
	if(isset($_GET['id']) && (trim($_GET['id']) != ''))
	{
		if(isset($_GET['id_client']) && (trim($_GET['id_client']) != ''))
		{
			$id_resa = $_GET['id'];			
			$id_client = $_GET['id_client'];
			switch ($type) {
				case "valider":
					$statut="2";
					$date_validation = $today;
					break;
				case "modifier":
					$statut="1";
					$date_validation = "";
					break;
				case "annuler":
					$statut="3";					
					$date_validation = "";
					break;
			}
			
			$qryResa="UPDATE reservation_agence ";
			$qryResa.="SET `statut` = '$statut' ";
			$qryResa.="WHERE id= $id_resa ";
			$resultResa=mysqli_query($bd, $qryResa);
			if($resultResa) {				
				header("location: ../reservations_agence.php?statut=Uok");
				exit;
			}
			else {
				die("Query failed");
			}
		}
	}
	else
	{
		switch ($type) {
			case "valider":
				//statut valide
				$statut="2";
				$date_validation = $today;
				break;
			case "enregistrer":
				$statut="1";
				$date_validation = "";
				break;
		}
		//Create query
		$qry="INSERT INTO client_agence ";
		$qry.="(`id`, `civilite`, `nom`, `prenom`, `email`, `telephone`, `naissance`, `nationnalite`, `num_passeport`, `delivrance`, `date_ajout`) VALUES ";
		$qry.="(NULL, '$civilite', '$nom', '$prenom', '$email', '$telephone', '$dateNaissance', '$nationalite', '$num_pass', '$datePass', '$today');";
		$result=mysqli_query($bd, $qry);
	 
		//Check whether the query was successful or not
		if($result) {
			$id_client = mysqli_insert_id($bd);
			if ($id_client != '')
			{
				$qryResa="INSERT INTO reservation_agence ";
				$qryResa.="(`id`, `id_client`, `date`, `id_tranche`, `vol`, `compagnie`, `porte`, `statut`, `id_origine`, `salon`, `date_validation`, `user_validation`, `date_ajout`, `user_ajout`, `date_update`, `user_update`, `invitant`, `agence`) VALUES ";
				$qryResa.="(NULL, '$id_client', '$dateresa', '$tranche', '$vol', '$compagnie', '$porte', '$statut', '$origine', '$salon', '$date_validation', '$id_user', '$today', '$id_user', '$today', '$id_user', '$invitant', '$agence');";
				$resultResa=mysqli_query($bd, $qryResa);
				if($resultResa) {
					$id_Resa = mysqli_insert_id($bd);				
					header("location: ../reservations_agence.php?statut=Cok");
					exit;
				}else {
					die("Query failed");
				}
			}
		}else {
			die("Query failed");
		}
	}	
?>