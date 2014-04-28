<?php

require_once("../librerias/db_postgresql.inc.php");
//ob_end_clean();

class cfuncionarios extends Datos {   

               
   function actualizar($data)  {		
		$sql_update  = "UPDATE funcionarios SET ";
		$sql_update .= "nombre_secretario	= '{$data['nombre_secretario']}', ";
		$sql_update .= "sexo				= '{$data['sexo']}', ";
		$sql_update .= "cargo_secretario	= '{$data['cargo_secretario']}', ";
		$sql_update .= "num_resolucion		= '{$data['num_resolucion']}', ";
		$sql_update .= "fecha_resolucion	= '{$data['fecha_resolucion']}', ";
		$sql_update .= "num_gaceta			= '{$data['num_gaceta']}', ";
		$sql_update .= "fecha_gaceta		= '{$data['fecha_gaceta']}', ";
		$sql_update .= "nombre_dir_ac		= '{$data['nombre_dir_ac']}', ";
		$sql_update .= "cargo_dir_ac		= '{$data['cargo_dir_ac']}', ";
		$sql_update .= "elab_pto_cta		= '{$data['elab_pto_cta']}' ";
		$sql_update .= "WHERE id 		= 1 ";
		#die($sql) ;
        $update = $this->Ejecutarsql($sql_update);
		return $update;
       
    } 

    function getFirmantes() {
		$sql		= "SELECT * FROM funcionarios LIMIT 1";
		$rs = $this->getRecordset($sql, $this->conn);		
		return $rs;
    }

    
}
?>
