<?php

   require_once("../librerias/db_postgresql.inc.php");
    require_once("csolicitantes.php");
    //ob_end_clean();

	class ccasos extends Datos
{

    // ********************************************** DECLARACIONES *********************************************

	
	
    private $error;
    private $info;

    private $validar_campos;
    private $bnuevo;

    private $idcaso;
	private $id_pto_cta;
    private $idsolicitante;
    private $idbeneficiario;
    private $fecha_registro;
    private $idremitente;
    private $idtipocaso;
    private $monto_solicitado;
    private $idestado;
    private $idmunicipio;
    private $idparroquia;
    private $descripcion_caso;
    private $idusuario;
    private $fecha_proceso;
    private $idestatus;
    private $instruccion;
    private $idcategoria;

    private $sremitente;
    private $responsable_remitente;

    private $idanalista_asignado;
    private $fecha_asignacion;
    private $fecha_resolucion;

    private $reasignacion;


    //campos informe de comite

    private $idinforme_comite;
    private $sanalisis;
    private $ssugerencia;
    private $sanexos;
    private $idusuario_informe_comite;
    private $idtipo_proyecto;
    private $idproveedor;
    private $monto_aprobado;
    private $observaciones_comite;

    // ********************************************** METODOS **************************************************


    public function get_sremitente(){
	return $this->sremitente;
    }

    public function set_sremitente($val_) {
        $this->sremitente=$val_;
    }

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
    public function get_idcaso(){
        return $this->idcaso;
    }
    public function set_idcaso($val_) {
        $this->idcaso=$val_;
    }
    public function get_idsolicitante(){
        return $this->idsolicitante;
    }
    public function set_idsolicitante($val_) {
        $this->idsolicitante=$val_;
    }
    public function get_idbeneficiario(){
        return $this->idbeneficiario;
    }
    public function set_idbeneficiario($val_) {
        $this->idbeneficiario=$val_;
    }
    public function get_fecha_registro(){
        return $this->fecha_registro;
    }
    public function set_fecha_registro($val_) {
        $this->fecha_registro=$val_;
    }
    public function get_idremitente(){
        return $this->idremitente;
    }
    public function set_idremitente($val_) {
        $this->idremitente=$val_;
    }
    public function get_idtipocaso(){
        return $this->idtipocaso;
    }
    public function set_idtipocaso($val_) {
        $this->idtipocaso=$val_;
    }
    public function get_monto_solicitado(){
        return $this->monto_solicitado;
    }
    public function set_monto_solicitado($val_) {
        $this->monto_solicitado=$val_;
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
    public function get_descripcion_caso(){
        return $this->descripcion_caso;
    }
    public function set_descripcion_caso($val_) {
        $this->descripcion_caso=$val_;
    }
    public function get_idusuario(){
        return $this->idusuario;
    }
    public function set_idusuario($val_) {
        $this->idusuario=$val_;
    }
    public function get_fecha_proceso(){
        return $this->fecha_proceso;
    }
    public function set_fecha_proceso($val_) {
        $this->fecha_proceso=$val_;
    }

    public function get_idestatus(){
        return $this->idestatus;
    }
    public function set_idestatus($val_) {
        $this->idestatus=$val_;
    }

    public function get_responsable_remitente(){
        return $this->responsable_remitente;
    }
    public function set_responsable_remitente($val_) {
        $this->responsable_remitente=$val_;
    }
    
     public function get_idanalista_asignado(){
        return $this->idanalista_asignado;
    }
    public function set_idanalista_asignado($val_) {
        $this->idanalista_asignado=$val_;
    }

    public function get_fecha_asignacion(){
        return $this->fecha_asignacion;
    }
    public function set_fecha_asignacion($val_) {
        $this->fecha_asignacion=$val_;
    }

    public function get_fecha_resolucion(){
        return $this->fecha_resolucion;
    }
    public function set_fecha_resolucion($val_) {
        $this->fecha_resolucion=$val_;
    }

    public function get_idinforme_comite(){
        return $this->idinforme_comite;
    }
    public function set_idinforme_comite($val_) {
        $this->idinforme_comite=$val_;
    }

    public function get_sanalisis(){
        return $this->sanalisis;
    }
    public function set_sanalisis($val_) {
        $this->sanalisis=$val_;
    }

    public function get_ssugerencia(){
        return $this->ssugerencia;
    }
    public function set_ssugerencia($val_) {
        $this->ssugerencia=$val_;
    }

    public function get_sanexos(){
        return $this->sanexos;
    }
    public function set_sanexos($val_) {
        $this->sanexos=$val_;
    }
    public function get_idusuario_informe_comite(){
        return $this->idusuario_informe_comite;
    }
    public function set_idusuario_informe_comite($val_) {
        $this->idusuario_informe_comite=$val_;
    }

    public function get_instruccion(){
        return $this->instruccion;
    }
    public function set_instruccion($val_) {
        $this->instruccion=$val_;
    }

    public function get_idcategoria(){
        return $this->idcategoria;
    }
    public function set_idcategoria($val_) {
        $this->idcategoria=$val_;
    }

    public function get_idtipo_proyecto()
    {
        return $this->idtipo_proyecto;
    }
    
    public function set_idtipo_proyecto($val_)
    {
        $this->idtipo_proyecto=$val_;
    }

    public function get_reasignacion()
    {
        return $this->reasignacion;
    }

    public function set_reasignacion($val_)
    {
        $this->reasignacion=$val_;
    }

    public function get_idproveedor(){
        return $this->idproveedor;
    }
    public function set_idproveedor($val_) {
        $this->idproveedor=$val_;
    }

    public function get_monto_aprobado(){
        return $this->monto_aprobado;
    }
    public function set_monto_aprobado($val_) {
        $this->monto_aprobado=$val_;
    }
    
    public function get_observaciones_comite(){
        return $this->observaciones_comite;
    }
    public function set_observaciones_comite($val_) {
        $this->observaciones_comite=$val_;
    }
    

    // ********************************************** LLENAR CAMPOS ************************************************

    function llenar($formulario)
    {

        if($formulario['f_inicio'] != "")
        {
            $fecha_tmp=to_fecha_bd($formulario['f_inicio']);       
            $this->set_fecha_registro($fecha_tmp);
        }

        if ($formulario["remitente"]>"0")
        {
            $this->set_idremitente($formulario["remitente"]);
        }
        else
        {
            $this->set_idremitente("NULL");
        }

        $this->set_responsable_remitente($formulario["responsable"]);
       
        if ($formulario["tipo_caso"]>0)
        {
            $this->set_idtipocaso($formulario["tipo_caso"]);
        }
        else
        {
            $this->set_idtipocaso("NULL");
        }


        if ($formulario["categoria_caso"]>0)
        {
            $this->set_idcategoria($formulario["categoria_caso"]);
        }
        else
        {
            $this->set_idcategoria("NULL");
        }

        if ($formulario["estado"]>0)
        {
            $this->set_idestado($formulario["estado"]);
        }
        else
        {
            $this->set_idestado("0");
        }

        if ($formulario["municipio"]>0)
        {
            $this->set_idmunicipio($formulario["municipio"]);
        }
        else
        {
            $this->set_idmunicipio("0");
        }
        
        if ($formulario["parroquia"]>0)
        {
            $this->set_idparroquia($formulario["parroquia"]);
        }
        else
        {
            $this->set_idparroquia("0");
        }

        if (@$formulario["instruccion"])
        {
            $this->set_instruccion('1');
        }
        else
        {
            $this->set_instruccion('0');
        }


        $this->set_descripcion_caso($formulario["descripcion_caso"]);
        $this->set_idusuario($_SESSION['idusuario']);

    }

    // ********************************************** INSERTAR ************************************************

    function insertar_caso($formulario)
    {
        $csolic=new csolicitantes();
        $cbenef=new csolicitantes();
        @ob_end_clean();
        
		
        $csolic->set_razon_social(to_mayuscula($formulario["razon_social_solic"]));
        $csolic->set_rif($formulario["rif_solic"]);
        $csolic->set_cedula($formulario["cedula_solic"]);
        $csolic->set_telefonos($formulario["telefonos_solic"]);
        $csolic->set_idparentesco($formulario["parentesco"]);
        $csolic->set_idtipo_solicitante($formulario["tipo_solicitante"]);
        $csolic->set_idusuario_seg($_SESSION["idusuario"]);

        $ult_solic=$csolic->Insertar_Solic_Benef_Caso();
        $this->set_idsolicitante($ult_solic);

        if (@$formulario["identico"])
        {
            $ult_benef=$ult_solic;
			$this->set_idbeneficiario($ult_solic);
        }
        else
        {
            $cbenef->set_razon_social(to_mayuscula($formulario["razon_social_benef"]));
            $cbenef->set_rif($formulario["rif_benef"]);
            $cbenef->set_cedula($formulario["cedula_benef"]);
            $cbenef->set_correo_electronico($formulario["email_benef"]);
            $cbenef->set_sexo($formulario["sexo"]);
            $cbenef->set_edad($formulario["edad"]);
            $cbenef->set_telefonos($formulario["telefonos_benef"]);
            $cbenef->set_comunidad($formulario["comunidad_benef"]);
            $cbenef->set_idtipo_solicitante($formulario["tipo_beneficiario"]);
            $cbenef->set_idusuario_seg($_SESSION["idusuario"]);

            $ult_benef=$cbenef->Insertar_Solic_Benef_Caso();
            $this->set_idbeneficiario($ult_benef);
        }

        $this->llenar($formulario);
        $this->set_idestatus("61");
		$year=date("Y");

		if(($ult_solic == 0) && ($ult_benef == 0))
		{
			return ("-1");
		}
		else
		{
			$sentencia_sql="Insert Into casos_actuales (idsolicitante,idbeneficiario,fecha_registro,idremitente,idtipocaso,idestado,".	
			"idmunicipio,idparroquia,descripcion_caso,idusuario, idestatus,".
			"responsable_remitente, instruccion, idcategoria, year) Values (".$this->get_idsolicitante().",".$this->get_idbeneficiario().",'".
			$this->get_fecha_registro()."', ".$this->get_idremitente().",".$this->get_idtipocaso().", ".$this->get_idestado().", '".
			$this->get_idmunicipio()."', '".$this->get_idparroquia()."', '".$this->get_descripcion_caso()."','".$this->get_idusuario()."', ".
			$this->get_idestatus().", '".$this->get_responsable_remitente()."', '".$this->get_instruccion()."', ".$this->get_idcategoria().",'".$year."')";
			
			//echo $sentencia_sql;
			$insertado=$this->Ejecutarsql($sentencia_sql);

			if(validar_vacio($insertado)==false)
			{
				$ult_registro=$this->getMax('casos_actuales','idcaso','');
				$this->set_idcaso($ult_registro);
				return $ult_registro;
			}
			else
			{
				$this->registrar_error($sentencia_sql, 'casos', $this->get_idusuario());
				return ("0");
			}
		}	
        
    }

   
    // ********************************************** UPDATE ************************************************

    function update_caso($formulario)
    {

        $csolic=new csolicitantes();
        $cbenef=new csolicitantes();
        @ob_end_clean();
		#var_dump($_SESSION);die();
        $csolic->set_razon_social($formulario["razon_social_solic"]);
        $csolic->set_rif($formulario["rif_solic"]);
        $csolic->set_cedula($formulario["cedula_solic"]);
        $csolic->set_telefonos($formulario["telefonos_solic"]);
        $csolic->set_idparentesco($formulario["parentesco"]);
        $csolic->set_idtipo_solicitante($formulario["tipo_solicitante"]);
        $csolic->set_idusuario_seg($_SESSION["idusuario"]);       

        if ($formulario["idsolicitante"]>0)
        {            
            $csolic->set_idsolicitante($formulario["idsolicitante"]);
            $ult_solic=$csolic->Update_Solic_Caso();
        }
        else
        {
            $ult_solic=$csolic->Insertar_Solic_Benef_Caso();
        }

        $this->set_idsolicitante($ult_solic);

        if ($formulario["identico"])    
        {
            $this->set_idbeneficiario($ult_solic);
        }
        else
        {
            $cbenef->set_razon_social($formulario["razon_social_benef"]);
            $cbenef->set_rif($formulario["rif_benef"]);
            $cbenef->set_cedula($formulario["cedula_benef"]);
            $cbenef->set_correo_electronico($formulario["email_benef"]);
            $cbenef->set_sexo($formulario["sexo"]);
            $cbenef->set_edad($formulario["edad"]);
            $cbenef->set_telefonos($formulario["telefonos_benef"]);
            $cbenef->set_comunidad($formulario["comunidad_benef"]);
            $cbenef->set_idtipo_solicitante($formulario["tipo_beneficiario"]);
            $cbenef->set_idusuario_seg($_SESSION["idusuario"]);

            if ($formulario["idbeneficiario"]>0)
            {
                $cbenef->set_idsolicitante($formulario["idbeneficiario"]);
                $ult_benef=$cbenef->Update_Solic_Benef_Caso_nuevos();
            }
            else
            {
                $ult_benef=$cbenef->Insertar_Solic_Benef_Caso();
            }

            $this->set_idbeneficiario($ult_benef);
        }
        
        $this->llenar($formulario);

        $sentencia_sql="update casos_actuales set idsolicitante=".$this->get_idsolicitante().",idbeneficiario=".$this->get_idbeneficiario().
		",fecha_registro='".$this->get_fecha_registro()."',idremitente=".$this->get_idremitente().",idtipocaso='".$this->get_idtipocaso().
		"',idestado=".$this->get_idestado().",idmunicipio=".$this->get_idmunicipio().",idparroquia=".$this->get_idparroquia().
		",descripcion_caso='".$this->get_descripcion_caso()."', responsable_remitente='".$this->get_responsable_remitente().
		"', instruccion='".$this->get_instruccion()."', idcategoria=".$this->get_idcategoria().
		" where idcaso=".$this->get_idcaso();
 
		#echo $sentencia_sql;
        $insertado=$this->Ejecutarsql($sentencia_sql);

        if(validar_vacio($insertado)==false)
        {
            $ult_registro=$this->getMax('casos_actuales','idcaso','');
            $this->set_idcaso($ult_registro);
            return $ult_registro;
        }
        else
        {        
            $this->registrar_error($sentencia_sql, 'casos', $this->get_idusuario());
            return ("0");
        }



    }//Update()

    // ********************************************** ELIMINAR ************************************************

    /*function Eliminar()
    {

        $this->set_error("");
        $this->set_validar_campos(true);


    }//Eliminar*/


    // ********************************************** GETDATA ************************************************

    function getData()
    {

        $this->set_bdatos(false);
        
        if (!validar_vacio($this->get_idcaso()))
        {

            $rs_casos=$this->datos->getRecordset("select * from casos where idcaso=".$this->get_idcaso(), $this->conn);
            
            if($rs_casos)
            {
                $this->set_bdatos(true);
                $this->set_idcaso($rs_casos->rowset["idcaso"]);
                $this->set_idsolicitante($rs_casos->rowset["idsolicitante"]);
                $this->set_idbeneficiario($rs_casos->rowset["idbeneficiario"]);
                $this->set_fecha_registro($rs_casos->rowset["fecha_registro"]);
                $this->set_idremitente($rs_casos->rowset["idremitente"]);
                $this->set_idtipocaso($rs_casos->rowset["idtipocaso"]);
                $this->set_monto_solicitado(to_moneda($rs_casos->rowset["monto_solicitado"]));
                $this->set_idestado($rs_casos->rowset["idestado"]);
                $this->set_idmunicipio($rs_casos->rowset["idmunicipio"]);
                $this->set_idparroquia($rs_casos->rowset["idparroquia"]);
                $this->set_descripcion_caso($rs_casos->rowset["descripcion_caso"]);
                $this->set_idusuario($rs_casos->rowset["idusuario"]);
                $this->set_fecha_proceso($rs_casos->rowset["fecha_proceso"]);
            }//Mostrar

        }
    }//getData()

	
	function getDataCasoActual($idcaso)
    {

        if ($idcaso>0)
        {
            //echo $idcaso;
			$sql="select idcaso, r.descripcion AS sremitente, ca.fecha_registro,ca.idsolicitante,s.idtipo_solicitante as idtipo_solicitante_solic,
				s.razon_social as razon_social_solic, b.razon_social as razon_social_benef,ca.year, ca.responsable_remitente as responsable,
				s.rif as rif_solic, s.cedula as cedula_solic, f.descripcion as sestado_solic,
				idestatus, e.descripcion AS sestatus_caso , ca.descripcion_caso, ca.responsable_remitente as responsable
				from casos_actuales ca 
				left join solicitantes_actuales s on ca.idsolicitante = s.idsolicitante
				LEFT JOIN solicitantes_actuales b ON ca.idbeneficiario = b.idsolicitante
				inner join maestro e on e.idmaestro = ca.idestatus
				left join maestro r on r.idmaestro = ca.idremitente
				left join estados f on f.idestado = s.idestado
				where ca.idcaso=".$idcaso;
				//echo $sql;
			$rs_casos=$this->getRecordset($sql, $this->conn);
            return $rs_casos;
        }
        else
        {
            return "";
        }

    }
	
    function getDataCaso($idcaso)
    {

        if ($idcaso>0)
        {
            $rs_casos=$this->getRecordset("select * from vcasos where idcaso=".$idcaso, $this->conn);
            return $rs_casos;
        }
        else
        {
            return "";
        }

    }//getData()
	
	function consultarCaso($idcaso)
    {

        if ($idcaso>0)
        {
			$l="SELECT c.idcaso, c.idsolicitante, c.idbeneficiario, c.fecha_registro, c.idremitente, r.descripcion AS sremitente, c.responsable_remitente, 
				c.idtipocaso,(SELECT maestro.descripcion FROM maestro WHERE maestro.idmaestro = c.idtipocaso) AS stipocaso, 
				c.idcategoria,(SELECT maestro.descripcion FROM maestro WHERE maestro.idmaestro = c.idcategoria) AS scategoria, 
				c.idestado,e.descripcion AS sestado,c.idmunicipio,m.descripcion AS smunicipio,c.idparroquia,p.descripcion AS sparroquia,c.descripcion_caso, 
				c.idusuario, c.fecha_proceso,c.instruccion, c.idestatus,(SELECT maestro.descripcion FROM maestro WHERE maestro.idmaestro = c.idestatus) AS sestatus_caso,
				s.razon_social as razon_social_solic, s.rif AS rif_solic, s.cedula AS cedula_solic, 
				s.idparentesco AS idparentesco_solic, (SELECT maestro.descripcion FROM maestro WHERE maestro.idmaestro = s.idparentesco) AS sparentesco_solic, 
				s.idtipo_solicitante AS idtipo_solicitante_solic,(SELECT maestro.descripcion FROM maestro WHERE maestro.idmaestro = s.idtipo_solicitante) AS stipo_solicitante_solic,
				s.telefonos AS telefonos_solic,
				b.razon_social as razon_social_benef,b.rif AS rif_benef, b.cedula AS cedula_benef, b.idtipo_solicitante AS idtipo_solicitante_benef, 
				(SELECT maestro.descripcion FROM maestro WHERE maestro.idmaestro = b.idtipo_solicitante) AS stipo_solicitante_benef,b.sexo AS sexo_benef,
				b.telefonos AS telefonos_benef,b.comunidad AS comunidad_benef, b.correo_electronico AS correo_electronico_benef,b.edad AS edad_benef
				FROM casos_actuales c 
				left join solicitantes_actuales s on c.idsolicitante = s.idsolicitante
				LEFT JOIN solicitantes_actuales b ON c.idbeneficiario = b.idsolicitante
				left join maestro r on r.idmaestro = c.idremitente
				inner join estados e on e.idestado = c.idestado
				inner join municipios m on m.idmunicipio = c.idmunicipio
				inner join parroquias p on p.idparroquia = c.idparroquia
		   where c.idcaso=".$idcaso;
		   //echo $l;
            $rs_casos=$this->getRecordset($l , $this->conn);
            return $rs_casos;
        }
        else
        {
            return "";
        }

    }//consultarCaso()

    public function insertarRemitente()
    {
        
        $sentencia_sql="Insert Into maestro (descripcion, alias, tipo_registro, idpadre, estatus) Values ('".strtolower($this->get_sremitente())."', '', 1, 55, 1)";
	$insertado=$this->Ejecutarsql($sentencia_sql);
        
        if(validar_vacio($insertado)==false)
	{
            $ult_registro=$this->getMax('maestro','idmaestro','');
        }
        else
        {
            $ult_registro="0";
        }

        return $ult_registro;

    }

    public function AsignarAnalista()
    {

        $tmp_fecha_asig=to_fecha_bd($this->get_fecha_asignacion());
        $tmp_fecha_resolucion=to_fecha_bd($this->get_fecha_resolucion());

        if ($this->get_reasignacion()=="1")
        {
            $actualizado=$this->Ejecutarsql("update casos_analistas_actuales set estatus_asignacion='1' where idcaso=".$this->get_idcaso());

        }

        $sql="insert into casos_analistas_actuales (idcaso, idanalista, fecha_asignacion, fecha_resolucion, idusuario, estatus_asignacion) values (".$this->get_idcaso().", ".$this->get_idanalista_asignado().", '".$tmp_fecha_asig."', '".$tmp_fecha_resolucion."', ".$_SESSION["idusuario"].", '0')";
        $insertado=$this->Ejecutarsql($sql);

        if(validar_vacio($insertado)==false)
        {

            $slogin=$this->getString("vusuarios", "login", "idusuario=".$this->get_idanalista_asignado());
            $susuario=$this->getString("vusuarios", "snombre_usuario", "idusuario=".$this->get_idanalista_asignado());

            $this->set_idusuario_seg($_SESSION["idusuario"]);

            if ($this->get_reasignacion()=="1")
            {
                $desc_seg=" <b>Reasign&oacute;</b> el Caso <b>(Id: ".$this->get_idcaso().")</b> al Analista ".$susuario."<b>(".$slogin.")</b>";
            }
            else
            {
                $desc_seg=" <b>Asign&oacute;</b> el Caso <b>(Id: ".$this->get_idcaso().")</b> al Analista ".$susuario."<b>(".$slogin.")</b>";
            }

            $this->set_descripcion_seg($desc_seg);
            $this->set_idcaso_seg($this->get_idcaso());
            $this->crearSeguimiento();

            $sql="update casos_actuales set idestatus=".ASIGNADO_ANALISTA." where idcaso=".$this->get_idcaso();
            $update=$this->Ejecutarsql($sql);

            $ult_registro="1";
        }
        else
        {
            $ult_registro="0";
        }

        return $ult_registro;

    }  

    function insertar_informe_comite()
    {

        if ($this->get_idcaso()>0)
        {

            $sql="insert into informe_comite (idcaso, analisis, idtipo_proyecto, sugerencia, anexos, idusuario, observaciones) values (".$this->get_idcaso().", '".$this->get_sanalisis()."', '".$this->get_idtipo_proyecto()."', '".$this->get_ssugerencia()."', '".$this->get_sanexos()."',".$this->get_idusuario_informe_comite().", '".$this->get_observaciones_comite()."')";
            $insertado=$this->Ejecutarsql($sql);

            if(validar_vacio($insertado)==false)
            {

                $this->set_idusuario_seg($_SESSION["idusuario"]);
                $desc_seg=" <b>Cre&oacute;</b> el Informe del Comite del Caso <b>(Id: ".$this->get_idcaso().")</b>";
                $this->set_descripcion_seg($desc_seg);
                $this->set_idcaso_seg($this->get_idcaso());
                $this->crearSeguimiento();

                $sql="update casos set idestatus=".EN_PROCESO." where idcaso=".$this->get_idcaso();
                $update=$this->Ejecutarsql($sql);

                $this->set_idusuario_seg($_SESSION["idusuario"]);
                $desc_seg=" <b>Actualiz&oacute;</b> el Estatus del Caso <b>(Id: ".$this->get_idcaso().")</b> a <b>EN PROCESO</b>";
                $this->set_descripcion_seg($desc_seg);
                $this->set_idcaso_seg($this->get_idcaso());
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

    }//insertar_informe_comite
	
	function insertar_informe_comite_nuevos()
    {

        if ($this->get_idcaso()>0)
        {

            $sql="insert into informe_comite_actuales (idcaso, analisis, idtipo_proyecto, sugerencia, anexos, idusuario, observaciones) values (".$this->get_idcaso().", '".$this->get_sanalisis()."', '".$this->get_idtipo_proyecto()."', '".$this->get_ssugerencia()."', '".$this->get_sanexos()."',".$this->get_idusuario_informe_comite().", '".$this->get_observaciones_comite()."')";
            $insertado=$this->Ejecutarsql($sql);

            if(validar_vacio($insertado)==false)
            {

                $this->set_idusuario_seg($_SESSION["idusuario"]);
                $desc_seg=" <b>Cre&oacute;</b> el Informe del Comite del Caso <b>(Id: ".$this->get_idcaso().")</b>";
                $this->set_descripcion_seg($desc_seg);
                $this->set_idcaso_seg($this->get_idcaso());
                $this->crearSeguimiento();

                $sql="update casos_actuales set idestatus=".EN_PROCESO." where idcaso=".$this->get_idcaso();
                $update=$this->Ejecutarsql($sql);

                $this->set_idusuario_seg($_SESSION["idusuario"]);
                $desc_seg=" <b>Actualiz&oacute;</b> el Estatus del Caso <b>(Id: ".$this->get_idcaso().")</b> a <b>EN PROCESO</b>";
                $this->set_descripcion_seg($desc_seg);
                $this->set_idcaso_seg($this->get_idcaso());
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

    }

    function actualizar_informe_comite()
    {

        if ($this->get_idcaso()>0)
        {

            $sql="update informe_comite set analisis='".$this->get_sanalisis()."', idtipo_proyecto='".$this->get_idtipo_proyecto()."', sugerencia='".$this->get_ssugerencia()."', anexos='".$this->get_sanexos()."', observaciones='".$this->get_observaciones_comite()."' where idinforme=".$this->get_idinforme_comite();
            
            $actualizado=$this->Ejecutarsql($sql);

            if(validar_vacio($actualizado)==false)
            {
                
                $this->set_idusuario_seg($_SESSION["idusuario"]);
                $desc_seg=" <b>Modific&oacute;</b> el Informe del Comite del Caso <b>(Id: ".$this->get_idcaso().")</b>";
                $this->set_descripcion_seg($desc_seg);
                $this->set_idcaso_seg($this->get_idcaso());
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

    }
	
	function actualizar_informe_comite_nuevos()
    {

        if ($this->get_idcaso()>0)
        {

            $sql="update informe_comite_actuales set analisis='".$this->get_sanalisis()."', idtipo_proyecto='".$this->get_idtipo_proyecto()."', sugerencia='".$this->get_ssugerencia()."', anexos='".$this->get_sanexos()."', observaciones='".$this->get_observaciones_comite()."' where idinforme=".$this->get_idinforme_comite();
            
            $actualizado=$this->Ejecutarsql($sql);

            if(validar_vacio($actualizado)==false)
            {
                
                $this->set_idusuario_seg($_SESSION["idusuario"]);
                $desc_seg=" <b>Modific&oacute;</b> el Informe del Comite del Caso <b>(Id: ".$this->get_idcaso().")</b>";
                $this->set_descripcion_seg($desc_seg);
                $this->set_idcaso_seg($this->get_idcaso());
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

    }

    function getData_Informe_Comite($idcaso)
    {
        if ($idcaso>0)
        {
            $rs_informe=$this->getRecordset("select * from vinforme_comite where idcaso=".$idcaso, $this->conn);
            return $rs_informe;
        }
        else
        {
            return "";
        }
    }
	
	function getData_Informe_Comite_nuevos($idcaso)
    {
        if ($idcaso>0)
        {
			$sql= "SELECT ic.idinforme, ic.idcaso, ic.idtipo_proyecto, ( SELECT maestro.descripcion
					   FROM maestro
					  WHERE maestro.idmaestro = ic.idtipo_proyecto) AS stipo_proyecto, ic.analisis, ic.sugerencia, ic.anexos, ic.idusuario, ic.idproveedor, ( SELECT maestro.descripcion
					   FROM maestro
					  WHERE maestro.idmaestro = ic.idproveedor) AS sproveedor, ic.monto_aprobado, ic.idestatus_final, ( SELECT maestro.descripcion
					   FROM maestro
					  WHERE maestro.idmaestro = ic.idestatus_final) AS sestatus_final, ( SELECT (sis_usuarios.nombres::text || ' '::text) || sis_usuarios.apellidos::text
					   FROM sis_usuarios
					  WHERE sis_usuarios.idusuario = ic.idusuario) AS susuario, ic.observaciones
			   FROM informe_comite_actuales ic
			   where ic.idcaso=".$idcaso;
            $rs_informe=$this->getRecordset($sql, $this->conn);
            return $rs_informe;
        }
        else
        {
            return "";
        }
    }

    function enviar_Informe_Comite()
    {
        if ($this->get_idcaso()>0)
        {

            $sql="update casos_actuales set idestatus=".PRE_APROBADO." where idcaso=".$this->get_idcaso();
         
            $update=$this->Ejecutarsql($sql);

            $this->set_idusuario_seg($_SESSION["idusuario"]);
            $desc_seg=" <b>Actualiz&oacute;</b> el Estatus del Caso <b>(Id: ".$this->get_idcaso().")</b> a <b>PRE-APROBADO</b>";
            $this->set_descripcion_seg($desc_seg);
            $this->set_idcaso_seg($this->get_idcaso());
            $this->crearSeguimiento();

            return "1";
        }
        else
        {
            return "0";
        }
    }

    function asignar_Estatus_Final()
    {
        if ($this->get_idcaso()>0)
        {

            $idestatus_final=$this->get_idestatus();
            $act=$this->actualizar_estatus();
            
            if($act>0)
            {
                if ($this->get_idproveedor()=="0" || $this->get_idproveedor()=="")  $this->set_idproveedor ("137");

                $this->Ejecutarsql("update informe_comite_actuales set idproveedor=".$this->get_idproveedor().", idestatus_final=".$idestatus_final.", monto_aprobado='".to_moneda_bd($this->get_monto_aprobado())."' where idcaso=".$this->get_idcaso());
                $this->set_idestatus(CERRADO);
                $act2=$this->actualizar_estatus();

                if ($act2>0)
                {
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
        }
        else
        {
            return "0";
        }
    }

    function insertar_casos_categorias($formulario)
    {

        if (@$formulario["idsubcateg"])
        {

            $sentencia_sql="delete from casos_categorias_nuevos where idcaso=".$this->get_idcaso();
            $eliminado=$this->Ejecutarsql($sentencia_sql);

            if(validar_vacio($eliminado)==false)
            {
                foreach ($formulario["idsubcateg"] as $valor)
                {                    
                    $sentencia_sql="insert into casos_categorias_nuevos (idcaso, idsubcategoria, cantidad, monto, idusuario) values  (".$this->get_idcaso().", ".$valor.", '".$formulario["txtcantidad".$valor]."', '".to_moneda_bd($formulario["txtmonto".$valor])."', '".$_SESSION["idusuario"]."')";
                    $insertado=$this->Ejecutarsql($sentencia_sql);
                }
            }
        }//if
    }	

    function insertar_persona_informe($formulario)
    {

        if ($formulario["idsolicitante"]>0)
        {

            if (!$formulario["parentesco_fami"]>0)  $formulario["parentesco_fami"]="12";
            if (!$formulario["grado_fami"]>0)  $formulario["grado_fami"]="118";
            if (!$formulario["ocupacion_fami"]>0)  $formulario["ocupacion_fami"]="9";  
			$f_nacimiento = ($formulario["f_nacimiento"] != '')?  date_to_db($formulario["f_nacimiento"]) : '' ;
            
            $sentencia_sql="
			insert into nucleo_familiar_nuevos 
			(idsolicitante, razon_social, cedula, edad, f_nacimiento, idparentesco, idgrado_instruccion, idocupacion, sexo, ingreso_mensual, idusuario)  
			values 
			(".$formulario["idsolicitante"].", '".$formulario["razon_social_fami"]."', '".$formulario["cedula_fami"]."', '".$formulario["edad_fami"]."', '$f_nacimiento',
			'".$formulario["parentesco_fami"]."', '".$formulario["grado_fami"]."', '".$formulario["ocupacion_fami"]."', '".$formulario["sexo_fami"]."', '".to_moneda_bd($formulario["ingreso_fami"])."', '".$_SESSION["idusuario"]."')";
            $insertado=$this->Ejecutarsql($sentencia_sql);
            
        }//if
    }

    function actualizar_persona_informe($formulario)
    {
        $respuesta= new xajaxResponse();
        if (($formulario["idsolicitante"]>0) && ($formulario["idpersona"]>0))
        {

            if (!$formulario["parentesco_fami"]>0)  $formulario["parentesco_fami"]="12";
            if (!$formulario["grado_fami"]>0)  $formulario["grado_fami"]="118";
            if (!$formulario["ocupacion_fami"]>0)  $formulario["ocupacion_fami"]="9";       
            $f_nacimiento = ($formulario["f_nacimiento"] != '') ? date_to_db($formulario["f_nacimiento"]) : '' ;
			
            $sentencia_sql="update nucleo_familiar_nuevos set razon_social='".$formulario["razon_social_fami"]."', cedula='".$formulario["cedula_fami"]."', 
			edad='".$formulario["edad_fami"]."', f_nacimiento = '$f_nacimiento',  idparentesco='".$formulario["parentesco_fami"]."', idgrado_instruccion='".$formulario["grado_fami"]."',
			idocupacion='".$formulario["ocupacion_fami"]."', sexo='".$formulario["sexo_fami"]."', ingreso_mensual='".to_moneda_bd($formulario["ingreso_fami"])."' where idregistro=".$formulario["idpersona"];
            $actualizado=$this->Ejecutarsql($sentencia_sql);            
        
        }//if
        
        if ($actualizado>0)
        {
            $respuesta->assign("idpersona", "value", "");
            $respuesta->assign("razon_social_fami", "value", "");
            $respuesta->assign("cedula_fami", "value", "");
            $respuesta->assign("edad_fami", "value", "");
			$respuesta->assign("f_nacimiento", "value", "");
            $respuesta->assign("parentesco_fami", "value", "0");
            $respuesta->assign("grado_fami", "value", "0");
            $respuesta->assign("ocupacion_fami", "value", "0");
            $respuesta->assign("sexo_fami", "value", "");
            $respuesta->assign("ingreso_fami", "value", "");
        }
        else
        {
            $respuesta->script("alert('Error al Intentar Actualizar el Miembro del Núcleo Familiar');");
        }
        
            
        return $respuesta;
        
    }
	
	 function getAnalistaAsignadoActual($idcaso)
    {
        if ($idcaso>0)
        {
			$q="select ca.idanalista, u.nombres || ' ' || u.apellidos as sanalista 
				from casos_analistas_actuales ca 
				inner join vusuarios u on ca.idanalista=u.idusuario 
				where ca.estatus_asignacion='0' and ca.idcaso=".$idcaso;
            $rs_analista=$this->getRecordset($q, $this->conn);            
            return $rs_analista;
        }
        else
        {
            return "";
        }
    }
	
    function getAnalistaAsignado($idcaso)
    {
        if ($idcaso>0)
        {
            $rs_analista=$this->getRecordset("select ca.idanalista, u.nombres || ' ' || u.apellidos as sanalista from casos_analistas ca inner join vusuarios u on ca.idanalista=u.idusuario where ca.estatus_asignacion='0' and ca.idcaso=".$idcaso, $this->conn);            
            return $rs_analista;
        }
        else
        {
            return "";
        }
    }

	
	function modificar_PlanteamientoComite()
    {
        if($this->get_idcaso()>0)
        {

            $sql="update casos_actuales set descripcion_caso='".$this->get_descripcion_caso()."' where idcaso=".$this->get_idcaso();
            $actualizado=$this->Ejecutarsql($sql);

            if(validar_vacio($actualizado)==false)
            {
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
    }
	
    function actualizar_estatus()
    {
        if($this->get_idcaso()>0)
        {

            $sql="update casos_actuales set idestatus=".$this->get_idestatus()." where idcaso=".$this->get_idcaso();
            $actualizado=$this->Ejecutarsql($sql);

            if(validar_vacio($actualizado)==false)
            {
                switch ($this->get_idestatus())
                {

                    case "61":
                        $sestatus="REGISTRADO";
                        break;
                    case "62":
                        $sestatus="ASIGNADO A ANALISTA";
                        break;
                    case "63":
                        $sestatus="EN PROCESO";
                        break;
                    case "68":
                        $sestatus="CERRADO";
                        break;
                    case "76":
                        $sestatus="PRE-APROBADO";
                        break;
                    case "77":
                        $sestatus="APROBADO";
                        break;
                    case "78":
                        $sestatus="NEGADO";
                        break;
                    case "79":
                        $sestatus="DIFERIDO";
                        break;
                    case "133":
                        $sestatus="EN ESPERA DE PRESUPUESTO";
                        break;
                    case "134":
                        $sestatus="EN ESPERA DE DOCUMENTACIÓN";
                        break;
					case "174":
                        $sestatus="NO SE HA LOGRADO CONTACTAR";
                        break;	
					case "277":
                        $sestatus="APOYAD0";
                        break;	
					case "280":
                        $sestatus="ARCHIVADO";
                        break;	
                }

                $this->set_idusuario_seg($_SESSION["idusuario"]);
                $desc_seg=" <b>Actualiz&oacute;</b> el Estatus del Caso <b>(Id: ".$this->get_idcaso().")</b> a <b>".$sestatus."</b>";
                $this->set_descripcion_seg($desc_seg);
                $this->set_idcaso_seg($this->get_idcaso());
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
    }

    function getMiembrosComite()
    {
        
        $rs_miembros=$this->getRecordset("select descripcion from maestro where idmaestro=139", $this->conn);
        $smiembros="";
        
        if($rs_miembros)
        {
            
            $data_usuario=  explode(",", $rs_miembros->rowset["descripcion"]);
            
            if ($data_usuario)
            {
                 foreach ($data_usuario as $valor)
                 {
                     if ($valor>0)
                     {
                         
                        $rsusuarios=$this->getRecordset("select nombres, apellidos, firma from vusuarios where idusuario=".$valor." order by idusuario", $this->conn);
                        
                        if ($rsusuarios)
                        {                             
                            $smiembros.=ucwords(strtolower($rsusuarios->rowset["nombres"])).' '.ucwords(strtolower($rsusuarios->rowset["apellidos"])).'<br>'.ucwords(strtolower($rsusuarios->rowset["firma"])).',';
                        }
                        
                     }//if valor
                
                 }//for
            }
        }
        
        return $smiembros;

    }//getData()
	
	function getPuntosCuentas($idptocta)
    {

        if ($idptocta>0)
        {
            $rs_cuentas=$this->getRecordset("SELECT
pc.*,
to_char(pc.fecha_creacion,'dd/mm/YYYY') as fechacreacion,
u.firma,
u.nombres,
u.apellidos,
f.*
FROM
puntos_cuenta pc
Inner Join sis_usuarios u ON pc.id_usuario = u.idusuario
Inner Join maestro m ON pc.id_decision = m.idmaestro ,
funcionarios f where id_caso=".$idptocta, $this->conn);
            return $rs_cuentas;
        }
        else
        {
            return "";
        }

    }//getData()
    
   }//class

    
?>
