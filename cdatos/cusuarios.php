<?php

require_once("../librerias/db_postgresql.inc.php");
//ob_end_clean();

class cusuarios extends Datos
{

    // ********************************************** DECLARACIONES *********************************************

    private $error;
    private $info;
    private $validar_campos;
    private $bnuevo;
    private $idusuario;
    private $idgrupo;
    private $nombres;
    private $apellidos;
    private $cedula;
    private $email;
    private $login;
    private $clave;
    private $fecha_proceso;
    private $idestatus;
    private $iniciales;
    private $firma;

    private $consultar;
    private $insertar;
    private $eliminar;
    private $actualizar;
    private $ejecutar;
    private $objeto;



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
    public function get_idusuario(){
        return $this->idusuario;
    }
    public function set_idusuario($val_) {
        $this->idusuario=$val_;
    }
    public function get_idgrupo(){
        return $this->idgrupo;
    }
    public function set_idgrupo($val_) {
        $this->idgrupo=$val_;
    }
    public function get_nombres(){
        return $this->nombres;
    }
    public function set_nombres($val_) {
        $this->nombres=$val_;
    }
    public function get_apellidos(){
        return $this->apellidos;
    }
    public function set_apellidos($val_) {
        $this->apellidos=$val_;
    }
    public function get_cedula(){
        return $this->cedula;
    }
    public function set_cedula($val_) {
        $this->cedula=$val_;
    }
    public function get_email(){
        return $this->email;
    }
    public function set_email($val_) {
        $this->email=$val_;
    }
    public function get_login(){
        return $this->login;
    }
    public function set_login($val_) {
        $this->login=$val_;
    }
    public function get_clave(){
        return $this->clave;
    }
    public function set_clave($val_) {
        $this->clave=$val_;
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

    public function get_iniciales(){
        return $this->iniciales;
    }
    public function set_iniciales($val_) {
        $this->iniciales=$val_;
    }

    public function get_consultar(){
        return $this->consultar;
    }
    public function set_consultar($val_) {
        $this->consultar=$val_;
    }

    public function get_insertar(){
        return $this->insertar;
    }
    public function set_insertar($val_) {
        $this->insertar=$val_;
    }

    public function get_eliminar(){
        return $this->eliminar;
    }
    public function set_eliminar($val_) {
        $this->eliminar=$val_;
    }

    public function get_actualizar(){
        return $this->actualizar;
    }
    public function set_actualizar($val_) {
        $this->actualizar=$val_;
    }

    public function get_ejecutar(){
        return $this->ejecutar;
    }
    public function set_ejecutar($val_) {
        $this->ejecutar=$val_;
    }

    public function get_objeto(){
        return $this->objeto;
    }
    public function set_objeto($val_) {
        $this->objeto=$val_;
    }


    public function get_firma(){
        return $this->firma;
    }
    public function set_firma($val_) {
        $this->firma=$val_;
    }

    // ********************************************** INSERTAR ************************************************

    function Insertar()
    {      

        $sentencia_sql="Insert Into sis_usuarios (idgrupo,nombres,apellidos,cedula,email,login,clave, idestatus, iniciales, firma) Values ";
        $sentencia_sql.=" ('".$this->get_idgrupo()."', '".$this->get_nombres()."', '".$this->get_apellidos()."', '".$this->get_cedula()."', '".$this->get_email()."', '". $this->get_login()."', 'e10adc3949ba59abbe56e057f20f883e', '".$this->get_idestatus()."', '".$this->get_iniciales()."', '".$this->get_firma()."')";
        $insertado=$this->Ejecutarsql($sentencia_sql);        
        
        if(validar_vacio($insertado)==false)
        {
            $ult_registro=$this->getMax('sis_usuarios','idusuario','');
            $this->set_idusuario($ult_registro);
            return $ult_registro;
        }
        else
        {
            $this->set_error("Han Ocurrido Errores al Intentar Insertar el sis_usuarios ");
            $this->set_validar_campos(false);
            $this->registrar_error($sentencia_sql, 'sis_usuarios', 0);
            //echo $sentencia_sql;
            return ("0");
        }
               
    }//Insertar()

    // ********************************************** UPDATE ************************************************

    function Update()
    {

        
        $sentencia_sql="update sis_usuarios set idgrupo='".$this->get_idgrupo()."', nombres='".$this->get_nombres()."', apellidos='".$this->get_apellidos()."', cedula='".$this->get_cedula()."', email='".$this->get_email()."', login='".$this->get_login()."', iniciales='".$this->get_iniciales()."', firma='".$this->get_firma()."' where idusuario = '".$this->get_idusuario()."' ";
        $actualizado=$this->Ejecutarsql($sentencia_sql);

        if(validar_vacio($actualizado)==false)
        {
              return $this->get_idusuario();
        }
        else
        {
            $this->set_error("Han Ocurrido Errores al Intentar Actualizar el Usuario ");
            $this->set_validar_campos(false);
            $this->registrar_error($sentencia_sql, 'sis_usuarios', $this->get_idusuario());
            return ("0");
        }
       
    }//Update()

    // ********************************************** ELIMINAR ************************************************

  /*  function Eliminar()
    {
        $this->set_error("");
        $this->set_validar_campos(true);
    }//Eliminar*/

    // ********************************************** GETDATA ************************************************

    function getData()
    {
        
        if (!validar_vacio($this->get_idusuario()))
        {

            $this->Conectar();
            $rs_sis_usuarios=new Recordset("select * from vusuarios where idusuario=".$this->get_idusuario(), $this->conn);
            //$rs_sis_usuarios=$this->getRecordset();
            
            if($rs_sis_usuarios->Mostrar())
            {                 
                
                $this->set_idusuario($rs_sis_usuarios->rowset["idusuario"]);
                $this->set_idgrupo($rs_sis_usuarios->rowset["idgrupo"]);
                $this->set_nombres($rs_sis_usuarios->rowset["nombres"]);
                $this->set_apellidos($rs_sis_usuarios->rowset["apellidos"]);                
                $this->set_cedula($rs_sis_usuarios->rowset["cedula"]);
                $this->set_email($rs_sis_usuarios->rowset["email"]);
                $this->set_login($rs_sis_usuarios->rowset["login"]);
                $this->set_idestatus($rs_sis_usuarios->rowset["idestatus"]);
                $this->set_iniciales($rs_sis_usuarios->rowset["iniciales"]);
                $this->set_firma($rs_sis_usuarios->rowset["firma"]);
                $this->set_clave($rs_sis_usuarios->rowset["clave"]);

                
            }//Mostrar
            
        }


    }//getData()


    function getPermisos()
    {

        if (!validar_vacio($this->get_idusuario()))
        {
			$id_grupo = ($this->get_idgrupo() == '') ? -1 : $this->get_idgrupo();
            $rs_permisos=$this->getRecordset("select * from vsis_permisos where idobjeto=".$this->get_objeto()." and idgrupo=".$id_grupo, $this->conn);

            if(!validar_vacio($rs_permisos))
            {                
                $this->set_consultar($rs_permisos->rowset["seleccionar"]);
                $this->set_insertar($rs_permisos->rowset["insertar"]);
                $this->set_eliminar($rs_permisos->rowset["eliminar"]);
                $this->set_actualizar($rs_permisos->rowset["actualizar"]);
                $this->set_ejecutar($rs_permisos->rowset["ejecutar"]);
                $this->set_objeto($rs_permisos->rowset["idobjeto"]);
            }
            else
            {
                $this->set_consultar('0');
                $this->set_insertar('0');
                $this->set_eliminar('0');
                $this->set_actualizar('0');
                $this->set_ejecutar('0');
                $this->set_objeto('0');
            }

        }

    }//getPermisos()


}//clases sis_usuarios



?>
