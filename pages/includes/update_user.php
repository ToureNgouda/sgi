<?php
 
	//Include database connection details
	require_once('connection.php');
 
	//Array to store validation errors
	$errmsg_arr = array();
 
	//Validation error flag
	$errflag = false;
 
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
	$username = $_POST['username'];
	$password = $_POST['password'];
	$oldpassword = $_POST['oldpassword'];
	$repassword = $_POST['repassword'];
	$email = $_POST['email'];
	$telephone = $_POST['telephone'];
	$salon = $_POST['salon'];	
	$profil = $_POST['profil'];
	
	$today = date("Y-m-d H:i:s");
    $updatePass = false;

	if(isset($_GET['id']) && (trim($_GET['id']) != ''))
	{
		//echo $password."  ".$repassword;
        $id = $_GET['id'];
        if ($password != '' && $password != $repassword) {
            header("location: ../details_users.php?id=".$id."&statut=Nok");
            exit;
        }
        else {
            if ($password != '') {
                $updatePass = true;
            }
        }
            
        
		$qry="UPDATE member ";
		$qry.="SET `gender` = '$civilite', `fname` = '$prenom', `lname` = '$nom', `contact` = '$email', `telephone` = '$telephone', `username` = '$username', `salon` = '$salon', `profil` = '$profil' ";
        if ($updatePass) {
           $qry.=", `password` = '$password' ";
        }
		$qry.="WHERE mem_id= $id ";
		if(mysqli_query($bd, $qry)) {	
			header("location: ../users.php?statut=Uok");
			exit;
		}
		else {
			die("Error updating record: " . mysqli_error($bd)."  ".$qry);
		}
		exit;
	}
	else
	{
		//Create query
		$qry="SELECT mem_id, fname, lname FROM member WHERE username='$username'";
		$result=mysqli_query($bd, $qry);
	 
		//Check whether the query was successful or not
		if($result) {
			if (mysqli_num_rows($result) > 0)
			{	
				header("location: ../new_user.php?statut=Nok");
			}
			else
			{
				$qry="INSERT INTO member ";
				$qry.="(`mem_id`, `gender`, `fname`, `lname`, `contact`, `telephone`, `username`, `password`, `salon`, `profil`) VALUES ";
				$qry.="(NULL, '$civilite', '$prenom', '$nom', '$email', '$telephone', '$username', '$password', '$salon', '$profil');";
				$result=mysqli_query($bd, $qry);
			 
				//Check whether the query was successful or not
				if($result) {
					$id_client = mysqli_insert_id($bd);
					header("location: ../users.php?statut=Cok");
				}
				else {
					header("location: ../new_user.php?statut=Error");
				}
			}
		}else {
			header("location: ../new_user.php?statut=Error");
		}
	}	
?>