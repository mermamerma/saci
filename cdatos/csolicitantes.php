<?php

require_once("../librerias/db_postgresql.inc.php");
ob_end_clean();

class csolicitantes extends Datos
{

    // ********************************************** DECLARACIONES *********************************************

    private $error;
    private $info;
    
    private $validar_campos;
    private $bnuevo;

    private $idsolicitante;
    private $razon_social;
    private $rif;
    private $cedula;
    private $sexo;
    private $fecha_nac;
    private $lugar_nac;
    private $idnacionalidad;
    private $idocupacion;
    private $idcivil;
    private $direccion;
    private $telefonos;
    private $idestado;
    private $idmunicipio;
    private $idparroquia;
    private $comunidad;
    private $correo_electronico;
    private $idparentesco;
    private $edad;
    private $idusuario;
    private $idtipo_solicitante;

    private $snacionalidad;
    private $socupacion;
    private $scivil;
    private $sestado;
    private $smunicipio;
    private $sparroquia;
    private $sparentesco;
    private $idgrado_instruccion;
    private $ingreso_mensual;

    //datos informe social

    private $idinforme_social;
    private $idcaso_informe;    
    private $misiones;
    private $tipo_vivienda;
    private $tenencia_vivienda;
    private $servicios_publicos;
    private $area_fisico;
    private $area_economica;
    private $condiciones_salud;
    private $observacion;
    private $idusuario_informe;

    // ********************************************** CONSTRUCTOR *********************************************

    function __construct()
    {

    }


    // ********************************************** METODOS **************************************************

    public function get_error(){
        return $this->error;
    }
    public function set_error($val_) {
        $this->error=$val_;
    }
    public function get_info(){
        return $this->info;
    }
    public function set_info($val_) {
        $this->info=$val_;
    }
    public function get_validar_campos(){
        return $this->validar_campos;
    }
    public function set_validar_campos($val_) {
        $this->validar_campos=$val_;
    }
    public function get_bnuevo(){
        return $this->bnuevo;
    }
    public function set_bnuevo($val_) {
        $this->bnuevo=$val_;
    }
    public function get_idsolicitante(){
        return $this->idsolicitante;
    }
    public function set_idsolicitante($val_) {
        $this->idsolicitante=$val_;
    }
    public function get_razon_social(){
        return $this->razon_social;
    }
    public function set_razon_social($val_) {
        $this->razon_social=$val_;
    }
    public function get_rif(){
        return $this->rif;
    }
    public function set_rif($val_) {
        $this->rif=$val_;
    }
    public function get_cedula(){
        return $this->cedula;
    }
    public function set_cedula($val_) {
        $this->cedula=$val_;
    }
    public function get_sexo(){
        return $this->sexo;
    }
    public function set_sexo($val_) {
        $this->sexo=$val_;
    }
    public function get_fecha_nac(){
        return $this->fecha_nac;
    }
    public function set_fecha_nac($val_) {
        $this->fecha_nac=$val_;
    }
    public function get_lugar_nac(){
        return $this->lugar_nac;
    }
    public function set_lugar_nac($val_) {
        $this->lugar_nac=$val_;
    }
    public function get_idnacionalidad(){
        return $this->idnacionalidad;
    }
    public function set_idnacionalidad($val_) {
        $this->idnacionalidad=$val_;
    }
    public function get_idocupacion(){
        return $this->idocupacion;
    }
    public function set_idocupacion($val_) {
        $this->idocupacion=$val_;
    }
    public function get_idcivil(){
        return $this->idcivil;
    }
    public function set_idcivil($val_) {
        $this->idcivil=$val_;
    }
    public function get_direccion(){
        return $this->direccion;
    }
    public function set_direccion($val_) {
        $this->direccion=$val_;
    }
    public function get_telefonos(){
        return $this->telefonos;
    }
    public function set_telefonos($val_) {
        $this->telefonos=$val_;
    }
    public function get_idestado(){
        return $this->idestado;
    }
    public function set_idestado($val_) {
        $this->idestado=$val_;
    }
    public function get_idmunicipio(){
        return $this->idmunicipio;
    }
    public function set_idmunicipio($val_) {
        $this->idmunicipio=$val_;
    }
    public function get_idparroquia(){
        return $this->idparroquia;
    }
    public function set_idparroquia($val_) {
        $this->idparroquia=$val_;
    }
    public function get_comunidad(){
        return $this->comunidad;
    }
    public function set_comunidad($val_) {
        $this->comunidad=$val_;
    }

    public function get_correo_electronico(){
        return $this->correo_electronico;
    }
    public function set_correo_electronico($val_) {
        $this->correo_electronico=$val_;
    }

    public function get_idparentesco(){
        return $this->idparentesco;
    }
    public function set_idparentesco($val_) {
        $this->idparentesco=$val_;
    }

    public function get_edad(){
        return $this->edad;
    }
    public function set_edad($val_) {
        $this->edad=$val_;
    }

    public function get_idusuario(){
        return $this->idusuario;
    }
    public function set_idusuario($val_) {
        $this->idusuario=$val_;
    }

    public function get_snacionalidad(){
        return $this->snacionalidad;
    }
    public function set_snacionalidad($val_) {
        $this->snacionalidad=$val_;
    }

    public function get_socupacion(){
        return $this->socupacion;
    }
    public function set_socupacion($val_) {
        $this->socupacion=$val_;
    }

    public function get_scivil(){
        return $this->scivil;
    }
    public function set_scivil($val_) {
        $this->scivil=$val_;
    }

    public function get_sestado(){
        return $this->sestado;
    }
    public function set_sestado($val_) {
        $this->sestado=$val_;
    }

    public function get_smunicipio(){
        return $this->smunicipio;
    }
    public function set_smunicipio($val_) {
        $this->smunicipio=$val_;
    }

    public function get_sparroquia(){
        return $this->sparroquia;
    }
    public function set_sparroquia($val_) {
        $this->sparroquia=$val_;
    }

    public function get_sparentesco(){
        return $this->sparentesco;
    }
    public function set_sparentesco($val_) {
        $this->sparentesco=$val_;
    }




    public function get_idcaso_informe(){
        return $this->idcaso_informe;
    }

    public function set_idcaso_informe($val_) {
        $this->idcaso_informe=$val_;
    }
   
    public function get_tipo_vivienda(){
        return $this->tipo_vivienda;
    }

    public function set_tipo_vivienda($val_) {
        $this->tipo_vivienda=$val_;
    }

    public function get_tenencia_vivienda(){
        return $this->tenencia_vivienda;
    }

    public function set_tenencia_vivienda($val_) {
        $this->tenencia_vivienda=$val_;
    }

    public function get_servicios_publicos(){
        return $this->servicios_publicos;
    }

    public function set_servicios_publicos($val_) {
        $this->servicios_publicos=$val_;
    }

    public function get_area_fisico(){
        return $this->area_fisico;
    }

    public function set_area_fisico($val_) {
        $this->area_fisico=$val_;
    }

    public function get_area_economica(){
        return $this->area_economica;
    }

    public function set_area_economica($val_) {
        $this->area_economica=$val_;
    }

    public function get_condiciones_salud(){
        return $this->condiciones_salud;
    }

    public function set_condiciones_salud($val_) {
        $this->condiciones_salud=$val_;
    }

  
    public function get_observacion(){
        return $this->observacion;
    }
    public function set_observacion($val_) {
        $this->observacion=$val_;
    }

    public function get_idusuario_informe(){
        return $this->idusuario_informe;
    }
    public function set_idusuario_informe($val_) {
        $this->idusuario_informe=$val_;
    }

 public function get_misiones(){
        return $this->misiones;
    }
    public function set_misiones($val_) {
        $this->misiones=$val_;
    }


    public function get_idinforme_social(){
        return $this->idinforme_social;
    }
    public function set_idinforme_social($val_) {
        $this->idinforme_social=$val_;
    }

    public function get_idtipo_solicitante(){
        return $this->idtipo_solicitante;
    }
    public function set_idtipo_solicitante($val_) {
        $this->idtipo_solicitante=$val_;
    }

    public function get_idgrado_instruccion(){
        return $this->idgrado_instruccion;
    }
    public function set_idgrado_instruccion($val_) {
        $this->idgrado_instruccion=$val_;
    }

    public function get_ingreso_mensual(){
        return $this->ingreso_mensual;
    }
    public function set_ingreso_mensual($val_) {
        $this->ingreso_mensual=$val_;
    }
  
    // ********************************************** LLENAR ************************************************

    function llenar($formulario)
    {

    }



    // ********************************************** INSERTAR SOLICITANTE O BENEFICIARIO ************************************************

    function Insertar_Solic_Benef_Caso()
    {

        $id_solic_caso=0;

        if ($this->get_cedula()<>'')
        {
            $id_solic_caso=$this->getInt("solicitantes_actuales", "idsolicitante", "cedula='".$this->get_cedula()."'");
        }
        if ($this->get_rif()<>'')
        {
            $id_solic_caso=$this->getInt("solicitantes_actuales", "idsolicitante", "rif='".$this->get_rif()."'");
        }
        else if ($this->get_razon_social()<>'')
        {
            $id_solic_caso=$this->getInt("solicitantes_actuales", "idsolicitante", "lower(razon_social) ='".strtolower($this->get_razon_social())."'");
        }

        if ($id_solic_caso>0)
        {
            return $id_solic_caso;
        }
        else
        {

            if ($this->get_razon_social()<>'')
            {
                if ($this->get_idparentesco()=="0" || $this->get_idparentesco()=="") $this->set_idparentesco("12");
                if ($this->get_sexo()=="0" || $this->get_sexo()=="") $this->set_sexo("NULL");
                else $this->set_sexo("'".$this->get_sexo()."'");
                if ($this->get_idgrado_instruccion()=="0" || $this->get_idgrado_instruccion()=="") $this->set_idgrado_instruccion ("118");
                if ($this->get_idtipo_solicitante()=="0" || $this->get_idtipo_solicitante()=="") $this->set_idtipo_solicitante ("112");
                
                if ($this->get_edad()=="0" || $this->get_edad()=="") $this->set_edad("NULL");

                $sentencia_sql="Insert Into solicitantes_actuales (razon_social, rif, cedula,sexo,fecha_nac,lugar_nac,idnacionalidad,idocupacion,idcivil,direccion,telefonos,idestado,idmunicipio,idparroquia,
				comunidad, correo_electronico,idparentesco, edad, idusuario, idtipo_solicitante, idgrado_instruccion, ingreso_mensual) 
				Values ('".$this->get_razon_social()."', '".$this->get_rif()."', '".$this->get_cedula()."',".$this->get_sexo().", NULL, NULL, '66', '9', '10', NULL, '".$this->get_telefonos().
				"', '0', '0', '0', '".$this->get_comunidad()."','".$this->get_correo_electronico()."',".$this->get_idparentesco().", ".$this->get_edad().", ".$_SESSION["idusuario"].", ".
				$this->get_idtipo_solicitante().", ".$this->get_idgrado_instruccion().", '".to_moneda_bd($this->get_ingreso_mensual())."')";
  
                $insertado=$this->Ejecutarsql($sentencia_sql);

                if(validar_vacio($insertado)==false)
                {
                    $ult_registro=$this->getMax('solicitantes_actuales','idsolicitante','');
                    $this->set_idsolicitante($ult_registro);
                    return $ult_registro;
                }
                else
                {    
                    $this->registrar_error($sentencia_sql, 'Solicitantes', $this->get_idusuario());
                    return "0";
                }
            }
            else
            {
                return "0";
            }

        }//else

    }//Insertar()

    function Update_Solic_Caso()
    {
        
        if ($this->get_idsolicitante()>0)
        {

            if ($this->get_razon_social()<>'')
            {
                if ($this->get_idparentesco()=="0" || $this->get_idparentesco()=="") $this->set_idparentesco("12");                
                if ($this->get_idtipo_solicitante()=="0" || $this->get_idtipo_solicitante()=="") $this->set_idtipo_solicitante ("112");
                
                $sentencia_sql="update solicitantes_actuales set razon_social='".$this->get_razon_social()."', rif='".$this->get_rif()."', cedula='".$this->get_cedula()."', telefonos='".$this->get_telefonos()."', idparentesco=".$this->get_idparentesco().", idtipo_solicitante=".$this->get_idtipo_solicitante()." where idsolicitante = '".$this->get_idsolicitante()."' ";

                $actualizado=$this->Ejecutarsql($sentencia_sql);

                if(validar_vacio($actualizado)==false)
                {
                    return $this->get_idsolicitante();
                }
                else
                {
                    $this->registrar_error($sentencia_sql, 'Solicitantes', $this->get_idusuario());
                    return "0";
                }
            }
            else
            {
                return "0";
            }

        }
        else
        {
            return "0";
        }
        
    }
    
    
   // ********************************************** UPDATE SOLICITANTE O BENEFICIARIO ************************************************

    function Update_Solic_Benef_Caso()
    {

        if ($this->get_idsolicitante()>0)
        {

            if ($this->get_razon_social()<>'')
            {
                if ($this->get_idparentesco()=="0" || $this->get_idparentesco()=="") $this->set_idparentesco("12");
                if ($this->get_sexo()=="0" || $this->get_sexo()=="") $this->set_sexo("NULL");
                else $this->set_sexo("'".$this->get_sexo()."'");

                if ($this->get_idgrado_instruccion()=="0" || $this->get_idgrado_instruccion()=="") $this->set_idgrado_instruccion ("118");
                if ($this->get_edad()=="0" || $this->get_edad()=="") $this->set_edad("NULL");
                if ($this->get_idtipo_solicitante()=="0" || $this->get_idtipo_solicitante()=="") $this->set_idtipo_solicitante ("112");
                if ($this->get_fecha_nac()!="")     $sfecha= "'".to_fecha_bd ($this->get_fecha_nac())."'";
                else    $sfecha="NULL";
                if ($this->get_idcivil()=="0" || $this->get_idcivil()=="")  $this->set_idcivil ("10");
                if (!$this->get_direccion())    $this->set_direccion ("");

                if (!$this->get_idestado() || $this->get_idestado()=="")    $this->set_idestado ("0");
                if (!$this->get_idmunicipio() || $this->get_idmunicipio()=="")  $this->set_idmunicipio ("0");
                if (!$this->get_idparroquia() || $this->get_idparroquia()=="")  $this->set_idparroquia ("0");
                if ($this->get_idnacionalidad()=="0" || $this->get_idnacionalidad()=="")    $this->set_idnacionalidad ("66");
                if ($this->get_idocupacion()=="0" || $this->get_idocupacion()=="")  $this->set_idocupacion ("9");

                $sentencia_sql="update solicitantes set razon_social='".$this->get_razon_social()."', rif='".$this->get_rif().
				"', cedula='".$this->get_cedula()."', sexo=".$this->get_sexo().", telefonos='".$this->get_telefonos()."', comunidad='".$this->get_comunidad().
				"', correo_electronico='".$this->get_correo_electronico()."',idparentesco=".$this->get_idparentesco().", edad=".$this->get_edad().
				", idtipo_solicitante=".$this->get_idtipo_solicitante().", idgrado_instruccion=".$this->get_idgrado_instruccion().
				", ingreso_mensual='".to_moneda_bd($this->get_ingreso_mensual())."', lugar_nac='".$this->get_lugar_nac()."', fecha_nac=".$sfecha.
				", idcivil=".$this->get_idcivil().", direccion='".$this->get_direccion()."', idestado=".$this->get_idestado().
				", idmunicipio=".$this->get_idmunicipio().", idparroquia=".$this->get_idparroquia().", idnacionalidad=".$this->get_idnacionalidad().
				", idocupacion=".$this->get_idocupacion().
				" where idsolicitante = '".$this->get_idsolicitante()."' ";
				echo $sentencia_sql;	
                $actualizado=$this->Ejecutarsql($sentencia_sql);

                if(validar_vacio($actualizado)==false)
                {
                    return $this->get_idsolicitante();
                }
                else
                {
                    $this->registrar_error($sentencia_sql, 'Solicitantes', $this->get_idusuario());
                    return "0";
                }
            }
            else
            {
                return "0";
            }

        }
        else
        {
            return "0";
        }

    }//Update()
	
	
	function Update_Solic_Benef_Caso_nuevos()
    {
        if ($this->get_idsolicitante()>0)
        {

            if ($this->get_razon_social()<>'')
            {
                if ($this->get_idparentesco()=="0" || $this->get_idparentesco()=="") $this->set_idparentesco("12");
                if ($this->get_sexo()=="0" || $this->get_sexo()=="") $this->set_sexo("NULL");
                else $this->set_sexo("'".$this->get_sexo()."'");

                if ($this->get_idgrado_instruccion()=="0" || $this->get_idgrado_instruccion()=="") $this->set_idgrado_instruccion ("118");
                if ($this->get_edad()=="0" || $this->get_edad()=="") $this->set_edad("NULL");
                if ($this->get_idtipo_solicitante()=="0" || $this->get_idtipo_solicitante()=="") $this->set_idtipo_solicitante ("112");
                if ($this->get_fecha_nac()!="")     $sfecha= "'".to_fecha_bd ($this->get_fecha_nac())."'";
                else    $sfecha="NULL";
                if ($this->get_idcivil()=="0" || $this->get_idcivil()=="")  $this->set_idcivil ("10");
                if (!$this->get_direccion())    $this->set_direccion ("");

                if (!$this->get_idestado() || $this->get_idestado()=="")    $this->set_idestado ("0");
                if (!$this->get_idmunicipio() || $this->get_idmunicipio()=="")  $this->set_idmunicipio ("0");
                if (!$this->get_idparroquia() || $this->get_idparroquia()=="")  $this->set_idparroquia ("0");
                if ($this->get_idnacionalidad()=="0" || $this->get_idnacionalidad()=="")    $this->set_idnacionalidad ("66");
                if ($this->get_idocupacion()=="0" || $this->get_idocupacion()=="")  $this->set_idocupacion ("9");
				
                $sentencia_sql="update solicitantes_actuales set razon_social='".$this->get_razon_social()."', rif='".$this->get_rif().
				"', cedula='".$this->get_cedula()."', sexo=".$this->get_sexo().", telefonos='".$this->get_telefonos().
				"', comunidad='".$this->get_comunidad()."', correo_electronico='".$this->get_correo_electronico().
				"',idparentesco=".$this->get_idparentesco().", edad=".$this->get_edad().", idtipo_solicitante=".$this->get_idtipo_solicitante().
				", idgrado_instruccion=".$this->get_idgrado_instruccion().", ingreso_mensual=".to_moneda_bd($this->get_ingreso_mensual()).", lugar_nac='".$this->get_lugar_nac().
				"', fecha_nac=".$sfecha.", idcivil=".$this->get_idcivil().", direccion='".$this->get_direccion().
				"', idestado=".$this->get_idestado().", idmunicipio=".$this->get_idmunicipio().", idparroquia=".$this->get_idparroquia().
				", idnacionalidad=".$this->get_idnacionalidad().", idocupacion=".$this->get_idocupacion().
				" where idsolicitante = '".$this->get_idsolicitante()."' ";
				//echo $sentencia_sql;	
                $actualizado=$this->Ejecutarsql($sentencia_sql);

                if(validar_vacio($actualizado)==false)
                {
                    return $this->get_idsolicitante();
                }
                else
                {
                    $this->registrar_error($sentencia_sql, 'Solicitantes', $this->get_idusuario());
                    return "0";
                }
            }
            else
            {
                return "0";
            }
        }
        else
        {
            return "0";
        }
    }

    // ********************************************** ELIMINAR ************************************************

    function Eliminar()
    {

        $this->set_error("");
        $this->set_validar_campos(true);


    }//Eliminar

    // ********************************************** GETDATA ************************************************

    function getData()
    {

        if ($this->get_idsolicitante()>0)
        {
            $rs_solicitantes=$this->getRecordset("select * from vsolicitantes where idsolicitante=".$this->get_idsolicitante(), $this->conn);
            return $rs_solicitantes;
        }
        else
        {
            return "";
        }


    }//getData()

	function getDataSolicitante()
    {

        if ($this->get_idsolicitante()>0)
        {
			$sql=" SELECT s.idsolicitante, s.razon_social, s.rif, s.cedula, s.sexo, s.fecha_nac, s.lugar_nac, s.idnacionalidad, ( SELECT maestro.descripcion
					   FROM maestro
					  WHERE maestro.idmaestro = s.idnacionalidad) AS snacionalidad, s.idocupacion, ( SELECT maestro.descripcion
					   FROM maestro
					  WHERE maestro.idmaestro = s.idocupacion) AS socupacion, s.idcivil, ( SELECT maestro.descripcion
					   FROM maestro
					  WHERE maestro.idmaestro = s.idcivil) AS scivil, s.direccion, s.telefonos, s.idestado, ( SELECT estados.descripcion
					   FROM estados
					  WHERE estados.idestado = s.idestado) AS sestado, s.idmunicipio, ( SELECT municipios.descripcion
					   FROM municipios
					  WHERE municipios.idmunicipio = s.idmunicipio) AS smunicipio, s.idparroquia, ( SELECT parroquias.descripcion
					   FROM parroquias
					  WHERE parroquias.idparroquia = s.idparroquia) AS sparroquia, s.comunidad, s.correo_electronico, s.idparentesco, ( SELECT maestro.descripcion
					   FROM maestro
					  WHERE maestro.idmaestro = s.idparentesco) AS sparentesco, s.edad, s.idusuario, s.fecha_proceso, s.idtipo_solicitante, ( SELECT maestro.descripcion
					   FROM maestro
					  WHERE maestro.idmaestro = s.idtipo_solicitante) AS stipo_solicitante, s.idgrado_instruccion, ( SELECT maestro.descripcion
					   FROM maestro
					  WHERE maestro.idmaestro = s.idgrado_instruccion) AS sgrado_instruccion, s.ingreso_mensual
			   FROM solicitantes_actuales s
			   where s.idsolicitante=".$this->get_idsolicitante();
            $rs_solicitantes=$this->getRecordset($sql, $this->conn);
            return $rs_solicitantes;
        }
        else
        {
            return "";
        }


    }
	

    function insertar_Informe_Social()
    {

        if ($this->get_idsolicitante()>0)
        {

            $sql="insert into informe_social (idsolicitante, misiones, tipo_vivienda, tenencia_vivienda,servicios_publicos, area_fisico, area_economica, condiciones_salud, observacion, idusuario) values ('".$this->get_idsolicitante()."', '".$this->get_misiones()."', '".$this->get_tipo_vivienda()."', '".$this->get_tenencia_vivienda()."', '".$this->get_servicios_publicos()."', '".$this->get_area_fisico()."', '".$this->get_area_economica()."', '".$this->get_condiciones_salud()."', '".$this->get_observacion()."', ".$this->get_idusuario_informe().")";
            $insertado=$this->Ejecutarsql($sql);

            if(validar_vacio($insertado)==false)
            {

                $this->set_idusuario_seg($_SESSION["idusuario"]);
                $desc_seg=" <b>Cre&oacute;</b> el Informe Social del Comite del Caso <b>(Id: ".$this->get_idcaso_informe().")</b>";
                $this->set_descripcion_seg($desc_seg);
                $this->set_idcaso_seg($this->get_idcaso_informe());
                $this->crearSeguimiento();

                $sql="update casos set idestatus=".EN_PROCESO." where idcaso=".$this->get_idcaso_informe();
                $update=$this->Ejecutarsql($sql);

                $this->set_idusuario_seg($_SESSION["idusuario"]);
                $desc_seg=" <b>Actualiz&oacute;</b> el Estatus del Caso <b>(Id: ".$this->get_idcaso_informe().")</b> a <b>EN PROCESO</b>";
                $this->set_descripcion_seg($desc_seg);
                $this->set_idcaso_seg($this->get_idcaso_informe());
                $this->crearSeguimiento();

                return "1";
                
            }
            else
            {
                return "0";
            }

        }
        else
        {
            return "0";
        }


    }//insertar_Informe_Social
	
	function insertar_Informe_Social_nuevos()
    {

        if ($this->get_idsolicitante()>0)
        {

            $sql="insert into informe_social_actuales (idsolicitante, misiones, tipo_vivienda, tenencia_vivienda,servicios_publicos, area_fisico, area_economica, condiciones_salud, observacion, idusuario) values ('".$this->get_idsolicitante()."', '".$this->get_misiones()."', '".$this->get_tipo_vivienda()."', '".$this->get_tenencia_vivienda()."', '".$this->get_servicios_publicos()."', '".$this->get_area_fisico()."', '".$this->get_area_economica()."', '".$this->get_condiciones_salud()."', '".$this->get_observacion()."', ".$this->get_idusuario_informe().")";
            $insertado=$this->Ejecutarsql($sql);

            if(validar_vacio($insertado)==false)
            {

                $this->set_idusuario_seg($_SESSION["idusuario"]);
                $desc_seg=" <b>Cre&oacute;</b> el Informe Social del Comite del Caso <b>(Id: ".$this->get_idcaso_informe().")</b>";
                $this->set_descripcion_seg($desc_seg);
                $this->set_idcaso_seg($this->get_idcaso_informe());
                $this->crearSeguimiento();

                $sql="update casos_actuales set idestatus=".EN_PROCESO." where idcaso=".$this->get_idcaso_informe();
                $update=$this->Ejecutarsql($sql);

                $this->set_idusuario_seg($_SESSION["idusuario"]);
                $desc_seg=" <b>Actualiz&oacute;</b> el Estatus del Caso <b>(Id: ".$this->get_idcaso_informe().")</b> a <b>EN PROCESO</b>";
                $this->set_descripcion_seg($desc_seg);
                $this->set_idcaso_seg($this->get_idcaso_informe());
                $this->crearSeguimiento();

                return "1";
                
            }
            else
            {
                return "0";
            }

        }
        else
        {
            return "0";
        }


    }//insertar_Informe_Social_nuevos

    function update_Informe_Social()
    {

        if ($this->get_idinforme_social()>0)
        {

            $sql="update informe_social set misiones='".$this->get_misiones()."', tipo_vivienda='".$this->get_tipo_vivienda()."', tenencia_vivienda='".$this->get_tenencia_vivienda()."', servicios_publicos='".$this->get_servicios_publicos()."', area_fisico='".$this->get_area_fisico()."', area_economica='".$this->get_area_economica()."',condiciones_salud='".$this->get_condiciones_salud()."', observacion='".$this->get_observacion()."' where idinforme=".$this->get_idinforme_social();
            $actualizado=$this->Ejecutarsql($sql);

            if(validar_vacio($actualizado)==false)
            {

                $this->set_idusuario_seg($_SESSION["idusuario"]);
                $desc_seg=" <b>Actualiz&oacute;</b> el Informe Social del Comite del Caso <b>(Id: ".$this->get_idcaso_informe().")</b>";
                $this->set_descripcion_seg($desc_seg);
                $this->set_idcaso_seg($this->get_idcaso_informe());
                $this->crearSeguimiento();

                return "1";
            }
            else
            {
                return "0";
            }

        }
        else
        {
            return "0";
        }


    }//update_Informe_Social
	
	function update_Informe_Social_nuevos()
    {

        if ($this->get_idinforme_social()>0)
        {

            $sql="update informe_social_actuales set misiones='".$this->get_misiones()."', tipo_vivienda='".$this->get_tipo_vivienda()."', tenencia_vivienda='".$this->get_tenencia_vivienda()."', servicios_publicos='".$this->get_servicios_publicos()."', area_fisico='".$this->get_area_fisico()."', area_economica='".$this->get_area_economica()."',condiciones_salud='".$this->get_condiciones_salud()."', observacion='".$this->get_observacion()."' where idinforme=".$this->get_idinforme_social();
            $actualizado=$this->Ejecutarsql($sql);

            if(validar_vacio($actualizado)==false)
            {

                $this->set_idusuario_seg($_SESSION["idusuario"]);
                $desc_seg=" <b>Actualiz&oacute;</b> el Informe Social del Comite del Caso <b>(Id: ".$this->get_idcaso_informe().")</b>";
                $this->set_descripcion_seg($desc_seg);
                $this->set_idcaso_seg($this->get_idcaso_informe());
                $this->crearSeguimiento();

                return "1";
            }
            else
            {
                return "0";
            }

        }
        else
        {
            return "0";
        }


    }//update_Informe_Social_nuevos


    // ********************************************** GETDATA ************************************************

    function getData_Informe_Social()
    {

        if ($this->get_idsolicitante()>0)
        {
            $rs_informe=$this->getRecordset("select * from vinforme_social where idsolicitante=".$this->get_idsolicitante(), $this->conn);
            return $rs_informe;
        }
        else
        {
            return "";
        }


    }//getData()
	
	function getData_Informe_Social_nuevo()
    {

        if ($this->get_idsolicitante()>0)
        {
		
			$s="SELECT i.idinforme, i.idsolicitante, i.misiones, 
				i.tipo_vivienda, ( SELECT maestro.descripcion FROM maestro WHERE maestro.idmaestro = i.tipo_vivienda) AS stipo_vivienda, 
				i.tenencia_vivienda, ( SELECT maestro.descripcion FROM maestro WHERE maestro.idmaestro = i.tenencia_vivienda) AS stenencia_vivienda, 
				i.servicios_publicos, i.area_fisico, i.area_economica, i.condiciones_salud, 
				i.observacion, i.idusuario, 
				( SELECT (sis_usuarios.nombres::text || ' '::text) || sis_usuarios.apellidos::text FROM sis_usuarios WHERE sis_usuarios.idusuario = i.idusuario) AS susuario 
				FROM informe_social_actuales i
				where i.idsolicitante=".$this->get_idsolicitante();
			//echo $s;
            $rs_informe=$this->getRecordset($s , $this->conn);
            return $rs_informe;
        }
        else
        {
            return "";
        }


    }

    

}//clases solicitantes


?>
