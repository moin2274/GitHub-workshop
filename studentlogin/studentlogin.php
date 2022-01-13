<?php
session_start();
include "../config.php";
if(isset($_POST['login'])){
	$username=$_POST['username'];
	$userpassword=$_POST['password'];
	$sqll = "SELECT * FROM `regis_detail` WHERE `app_id` LIKE '$username' AND `password` LIKE '$userpassword'";
	$qry=mysqli_query($conn,$sqll);
	$row = mysqli_fetch_array($qry);
//	if(strcasecmp($row[5],$username)==0 && strcasecmp($row[6],$userpassword)==0){
	if($row > 0){
        $_SESSION['app_id']=$username;
		$_SESSION['password']=$userpassword;
		header( "Location:studenthome.php" );
	}else {
		header("location:../studentlogin.html");
	}
}
?>