<?php
	//Start session
	session_start();
 
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
	$username = $_POST['username'];
	$password = $_POST['password'];
 
	//Input Validations
	if($username == '') {
		$errmsg_arr[] = 'Login manquant';
		$errflag = true;
	}
	if($password == '') {
		$errmsg_arr[] = 'Mot de passe manquant';
		$errflag = true;
	}
 
	//If there are input validations, redirect back to the login form
	if($errflag) {
		$_SESSION['ERRMSG_ARR'] = $errmsg_arr;
		session_write_close();
		header("location: index.php");
		exit();
	}
	
 
	//Create query
	$qry="SELECT mem_id, fname, lname, s.nom AS nom, salon, profil FROM member , salon s WHERE username='$username' AND password='$password' AND salon=s.id ";
	$result=mysqli_query($bd, $qry);
 
	//Check whether the query was successful or not
	if($result) {
		if(mysqli_num_rows($result) > 0) {
            
			//Login Successful
			session_regenerate_id();
			$member = mysqli_fetch_assoc($result);
            
			$_SESSION['SESS_MEMBER_ID'] = $member['mem_id'];
			$_SESSION['SESS_FIRST_NAME'] = $member['fname'];
			$_SESSION['SESS_LAST_NAME'] = $member['lname'];
			$_SESSION['SESS_SALON'] = $member['nom'];
			$_SESSION['SESS_SALON_ID'] = $member['salon'];
			$_SESSION['SESS_PROFIL'] = $member['profil'];
			//echo "<script type='text/javascript'>alert('".$_SESSION['SESS_FIRST_NAME']."');</script>";
			
			//session_write_close();
            switch ($_SESSION['SESS_PROFIL']) {
                case "1":
                    header("location: ../index.php");
                    exit();
                    break;
                case "2":
                    header("location: ../new_reservation.php");
                    exit();
                    break;
                case "3":
                    header("location: ../reservations.php");
                    exit();
					break;
				case "4":
					header("location: ../index.php");
                    exit();
                    break;
            }
		}else {
			//Login failed
			$errmsg_arr[] = 'Login ou mot de passe incorrect';
			$errflag = true;
			if($errflag) {
				$_SESSION['ERRMSG_ARR'] = $errmsg_arr;
				session_write_close();
				header("location: ../index.php");
				exit();
			}
		}
	}else {
		die("Query failed");
	}
?>