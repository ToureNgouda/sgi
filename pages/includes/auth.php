<?php
	
	//echo "<script>alert('first ".$_SESSION['SESS_FIRST_NAME']."')</script>";
	//Check whether the session variable SESS_MEMBER_ID is present or not
	if(!isset($_SESSION['SESS_MEMBER_ID']) || (trim($_SESSION['SESS_MEMBER_ID']) == '')) {
        echo "<script type='text/javascript'>document.location.replace('../pages/login.php');</script>";
	}
	//echo "<script type='text/javascript'>document.location.replace('../error/index.html');</script>";
?>