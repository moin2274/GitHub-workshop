<?php   
session_start();  
unset($_SESSION['app_id']);  
session_destroy();  
header("location:../../index.html");  
?>  