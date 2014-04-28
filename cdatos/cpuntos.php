<?php

require_once("../librerias/db_postgresql.inc.php");
//ob_end_clean();

class cpuntos extends Datos {   
    function insertar($data)    {
		$id_usuario = $_SESSION["idusuario"] ;
		$sql = "INSERT INTO puntos_cuenta (id_caso,asunto,argumentacion,
				carta_solicitud,informe_social,informe_medico,presupuesto,copia_ci,
				monto,razon_social,rif, concepto, id_decision,observaciones,id_usuario) VALUES
				({$data['id_caso']}, '{$data['asunto']}', '{$data['argumentacion']}',
				'{$data['carta_solicitud']}', '{$data['informe_social']}', '{$data['informe_medico']}', '{$data['presupuesto']}', '{$data['copia_ci']}',
				'{$data['monto']}','{$data['razon_social']}','{$data['rif']}','{$data['concepto']}', {$data['id_decision']}, '{$data['observaciones']}', $id_usuario)
				RETURNING id_pto_cta ";
		$insert  = $this->Ejecutarsql($sql); 		
		$last_id = $this->getMax('puntos_cuenta','id_pto_cta','');        
		$this->set_idusuario_seg($_SESSION["idusuario"]);
        $desc_seg=" <b>Registró</b> el Punto de Cuenta del Caso <b>(Id: {$data['id_caso']})</b>";
        $this->set_descripcion_seg($desc_seg);
        $this->set_idcaso_seg($data['id_caso']);
		$this->crearSeguimiento();
		return $last_id ;
   }
               
   function actualizar($data)  {		
		$sql  = "UPDATE puntos_cuenta SET ";
		$sql .= "asunto = '{$data['asunto']}', argumentacion = '{$data['argumentacion']}', ";
		$sql .= "carta_solicitud = '{$data['carta_solicitud']}', informe_social = '{$data['informe_social']}', ";
		$sql .= "informe_medico = '{$data['informe_medico']}', presupuesto = '{$data['presupuesto']}', copia_ci = '{$data['copia_ci']}', ";
		$sql .= "monto = {$data['monto']}, razon_social = '{$data['razon_social']}' , ";
		$sql .= "rif = '{$data['rif']}', concepto = '{$data['concepto']}', ";
		$sql .= "id_decision = '{$data['id_decision']}', observaciones = '{$data['observaciones']}' ";
		$sql .= "WHERE id_pto_cta = {$data['id_pto_cta']} ";   
		#die($sql) ;
        $update = $this->Ejecutarsql($sql);
		# Seguimiento
		$this->set_idusuario_seg($_SESSION["idusuario"]);
        $desc_seg=" <b>Modificó</b> el Punto de Cuenta del Caso <b>(Id: {$data['id_caso']})</b>";
        $this->set_descripcion_seg($desc_seg);
        $this->set_idcaso_seg($data['id_caso']);
        $this->crearSeguimiento();	
       
    } 

    function getPunto($id_caso) {
		$sql		= "SELECT * FROM puntos_cuenta WHERE id_caso = $id_caso LIMIT 1";
		$rs = $this->getRecordset($sql, $this->conn);
		if ($rs !== FALSE) {
			$this->set_idusuario_seg($_SESSION["idusuario"]);
            $desc_seg=" <b>Accesó</b> al Punto de Cuenta del Caso <b>(Id: $id_caso)</b>";
            $this->set_descripcion_seg($desc_seg);
            $this->set_idcaso_seg($id_caso);
            $this->crearSeguimiento();			
		}
		return $rs;
    }

    
}
?>
