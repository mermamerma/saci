<?
    include("../librerias/formato.inc.php"); 
	#session_start();
	@session_destroy(); 
	unset($_REQUEST);
	@session_unset();
	@session_destroy();
	redirect("login.php","_self");
?>