<?

	require_once("../cdatos/cusuarios.php");
	$cusuario=new cusuarios();	
	@session_start();
        $cusuario->set_idusuario((int)$_SESSION["idusuario"]);
        $cusuario->getData();

        $_SESSION["usuario_actual"]=$cusuario->get_nombres().' '.$cusuario->get_apellidos();

        

?>
