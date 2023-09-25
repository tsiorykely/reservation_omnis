<?php 

session_start();
unset($_SESSION['utilisateurs']);
if (session_destroy()) {
	header('location:../../index.php');
}
 ?>