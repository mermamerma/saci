<?

require_once("formato.inc.php");
require_once("constantes.php");
#var_dump($_SERVER);exit;
$host = $_SERVER['HTTP_HOST'];
$ruta = ($host == '172.27.38.66') ? 'http://172.27.38.66/saci/' : 'http://saci.mppre.gob.ve/' ;
define('BASE_URL', $ruta);


//db_postgresql.php
class Recordset
{

public $result, // result id
$rowcount, // number of rows in result
$curpos, // index of current row (begin=0, end=rowcount-1)
$fieldcount, // number of fields in result 0
$fn, // Array of fields names
$rowset, // Array of fields with keys on field name
$connection, // connection id
$sql, // sql Execsql
$msgerror;

//Constructor

function Recordset($cadsql="",$Connection="")
{
	//echo "cadena: ". $cadsql;
    if ($Connection <> "")
    {
        $this->connection = $Connection;
        $this->sql = $cadsql;
        $this->fn = array();
        $this->rowset = array();
        $this->Execsql();
    }
}

// Execute Execsql

function Execsql() 
{
	$this->Close();
	$this->result = pg_query($this->connection,$this->sql);

	if (!$this->result) return(0);

	$this->rowcount = @pg_num_rows($this->result);
	$this->fieldcount = @pg_num_fields($this->result);

		for ($i=1;$i<=$this->fieldcount;$i++)
			{
			$f=@pg_field_name($this->result,$i-1);	
			$this->fn[$i]=strtolower($f);                
		}
	$this->curpos=0;
} //fin


//Move to first record

function Primero() {
$this->curpos=0;
}

function Siguiente() {
$this->curpos++;
}

function Mostrar()
{
    if (!$this->result) return(0);
    if ($this->curpos==$this->rowcount) return(0);
    for($i=1;$i<=$this->fieldcount;$i++)
    $this->rowset[$this->fn[$i]] = @pg_result($this->result,$this->curpos,$this->fn[$i]);
    return($this->rowset);
}


//Return true if last record

function Eof() {
if ($this->curpos==$this->rowcount-1)
return(1);
return(0);
}

//Return true if first record

/**
 * @return unknown
 * @desc Enter description here...
*/
function Bof() {
if (!$this->curpos)
return(1);
return(0);
}

// Free result if exist

function Close()
{
	if ($this->result && $this->rowcount)
		@pg_free_result($this->result);
		$this->result=0;
		$this->fn=array();
		$this->rowset=array();
		$this->rowcount=0;
		$this->fieldcount=0;
}

}//class


//******************************CLASE DE DATOS*********************************

class Datos {

public $conn;
public $cadconex;
public $cadena_error;

private $descripcion_seg;
private $idtipo_seg;
private $idobjeto_seg;
private $idusuario_seg;
private $idcaso_seg;
private $fecha_seg;
private $beliminado_seg;
private $idsolicitud;
private $idcomite_seg;
private $justificacion_seg;


public function get_descripcion_seg(){
    return $this->descripcion_seg;
}
public function set_descripcion_seg($val_) {
    $this->descripcion_seg=$val_;
}

public function get_idtipo_seg(){
    return $this->idtipo_seg;
}
public function set_idtipo_seg($val_) {
    $this->idtipo_seg=$val_;
}

public function get_idobjeto_seg(){
    return $this->idobjeto_seg;
}
public function set_idobjeto_seg($val_) {
    $this->idobjeto_seg=$val_;
}

public function get_idusuario_seg(){
    return $this->idusuario_seg;
}
public function set_idusuario_seg($val_) {
    $this->idusuario_seg=$val_;
}

public function get_idcaso_seg(){
    return $this->idcaso_seg;
}
public function set_idcaso_seg($val_) {
    $this->idcaso_seg=$val_;
}
public function get_fecha_seg(){
    return $this->fecha_seg;
}
public function set_fecha_seg($val_) {
    $this->fecha_seg=$val_;
}

public function get_beliminado_seg(){
    return $this->beliminado_seg;
}
public function set_beliminado_seg($val_) {
    $this->beliminado_seg=$val_;
}

public function get_idsolicitud(){
    return $this->idsolicitud;
}
public function set_idsolicitud($val_) {
    $this->idsolicitud=$val_;
}

public function get_idcomite_seg(){
    return $this->idcomite_seg;
}
public function set_idcomite_seg($val_) {
    $this->idcomite_seg=$val_;
}

public function get_justificacion_seg(){
    return $this->justificacion_seg;
}
public function set_justificacion_seg($val_) {
    $this->justificacion_seg=$val_;
}

function Datos(){

}
// Conexión a la base de datos
function Conectar(){
	
	$host = $_SERVER['HTTP_HOST'];
	if ($host == '172.27.38.66') {
		
		$B_strhost="10.11.11.9";
		$B_strusuario="saci";
		$B_strpassword="s@c1atencion1";
		$B_strbd="saci";
		$B_strpuerto="5432";
		
		/*
		$B_strhost="localhost";
		$B_strusuario="postgres";
		$B_strpassword="postgres";
		$B_strbd="saci";
		$B_strpuerto="5432";
		*/
		
	}
	else {		
			$B_strhost="10.11.11.9";
			$B_strusuario="saci";
			$B_strpassword="s@c1atencion1";
			$B_strbd="saci";
			$B_strpuerto="5432";
	}

	$this->cadconex="host=$B_strhost dbname=$B_strbd port=$B_strpuerto user=$B_strusuario password=$B_strpassword";
        $resul= pg_connect($this->cadconex);
	
    if(!$resul){
		echo "Ha ocurrido un error de conexion, Reinicie el explorador, si el error persiste: Comuniquese con Administrador del Sistema";
		return false;
	}
	else
	{
		//echo "conectada";
		$this->conn=$resul;
		return true;
	}
	
}



function Cerrarconex($conect){
	@pg_close($conect);
}



function Cargarlista_m($cadsql, $seleccion){

        $this->Conectar();
	$rs=new Recordset($cadsql, $this->conn);

	while($Fields=$rs->Mostrar())
	{
		$valor='';

		$valor=to_moneda(moneda($Fields[$rs->fn[1]]));

		if($seleccion==$valor)
		{
			$resultado=$resultado."<option value=".$valor." selected>".$valor."</option>";
		}
		else
		{
			 $resultado=$resultado."<option value=".$valor.">".$valor."</option>";
		}
		$rs->Siguiente();
	}

	$rs->Close();
        $this->Desconectar();
	return ($resultado);

}//fin cargar clista

function Cargarlista($cadsql, $seleccion)
{

    $this->Conectar();
    $rs=new Recordset($cadsql, $this->conn);

    while($Fields=$rs->Mostrar())
    {
        if($seleccion == $Fields[$rs->fn[1]])
            @$resultado=$resultado."<option value=".$Fields[$rs->fn[1]]." selected>".mb_strtoupper($Fields[$rs->fn[2]],'UTF-8')."</option>";
        else
            @$resultado=@$resultado."<option value=".$Fields[$rs->fn[1]].">".mb_strtoupper($Fields[$rs->fn[2]],'UTF-8')."</option>";

         $rs->Siguiente();
    }

    $rs->Close();
    $this->Desconectar();

    return ($resultado);

}//fin cargar clista

function Listar($cadsql)
{

    $this->Conectar();
    $rs=new Recordset($cadsql, $this->conn);

    while($Fields=$rs->Mostrar())
    {
        $resultado=$resultado."<option value=".$Fields[$rs->fn[1]].">".$Fields[$rs->fn[2]]."</option>";

         $rs->Siguiente();
    }

    $rs->Close();
    $this->Desconectar();

    return ($resultado);

}

/**
 * @return unknown
 * @param cadena sql  $cadsql
 * @param conexion $Connection
 * @desc crea una tabla dinamica
*/

function Cargartabla($cadsql)
{
    $this->Conectar();
    $rs=new Recordset($cadsql, $this->conn);
    global $resultado;
    global $fila;
    $fila=1;

    while($Fields=$rs->Mostrar())
    {
        if(($fila%2)==0) $resultado=$resultado."<tr class='tabletop3'>";
        else $resultado=$resultado."<tr class='tabletop2'>";

        for ($i=1;$i<=$rs->fieldcount;$i++)
        {
             $resultado=$resultado." <td>". $Fields[$rs->fn[$i]] ." </td>";
        }

        $resultado=$resultado."</tr>";
        $fila=$fila+1;
        $rs->Siguiente();
    }

    $rs->Close();
    $this->Desconectar();

    return ($resultado);

}//fin cargar tabla

function CargarTablaCheck($cadsql, $nbcontrol, $idsolicitud, $tipoDiv, $idusuario, $lectura)
{
    $this->Conectar();

    $rstabla=new Recordset("select idmaestro from solicitud_crediticias where idtabla=".$tipoDiv." and idsolicitud=".$idsolicitud, $this->conn);

    $rs=new Recordset($cadsql, $this->conn);
    global $resultado;
    global $fila;
    $fila=1;
    $nreg=1;
    $registros='';
    $n=0;

    $resultado="<table border=\"0\" width=\"100%\"  cellpadding=\"0\" cellspacing=\"1\" align=\"left\" valign=\"top\">";

    while($Fields=$rstabla->Mostrar())
    {
        $registros[$n]=$Fields[$rstabla->fn[1]];
        $n++;
        $rstabla->Siguiente();
    }

    while($Fields=$rs->Mostrar())
    {

        $resultado.="<tr bgcolor=\"#F0F0F0\">";
        $nreg+=1;
        $seleccion="";

        if ($registros)
        {
            if (in_array ($Fields[$rs->fn[1]], $registros)) $seleccion="checked";
        }

        if ($lectura=="1") $slectura="disabled";
        else $slectura="";

        $resultado.=" <td valign=\"top\" align=\"left\"><input type=\"checkbox\" ".$slectura." onchange=\"javascript:procesarDiv('".$Fields[$rs->fn[1]]."', '".$idsolicitud."', '".$tipoDiv."', '".$idusuario."')\"  value=\"".$Fields[$rs->fn[1]]."\" ".$seleccion.">".$Fields[$rs->fn[2]]."</td>";
        $resultado.="</tr>";
        $fila=$fila+1;
        $rs->Siguiente();

    }

    $resultado.="</table>";
    $rs->Close();
    $this->Desconectar();
    return ($resultado);

}//fin cargar tabla checkbox

function cargar_tabla_botones($cadsql, $Tabla, $Botones, $max_paginas, $campo_link, $radio, $swpaginado=true)
{

//opciones de configuracion
$etiqueta_anterior = 'Anterior';    //texto o codigo de la imagen para indicar p�gina anterior
$etiqueta_siguiente = 'Siguiente';    //texto o codigo de la imagen para indicar p�gina siguiente
$class = 'fila';        //class para mostrar la barra de la paginaci�n
$max_num_most = 8;                    //delimita el numero de "numeros" a mostrar entre Anterior y Siguiente, 0 off
$resultados_pagina=$max_paginas;


//establecemos la pagina actual
if (isset($_GET['pagina'])) {
   $pagina_actual = $_GET['pagina'];
   $_SESSION["paginaactual"]=$pagina_actual;
} else {
   $pagina_actual = 1;
    $_SESSION["paginaactual"]=1;
}
//si hay mas variables enviadas por get, las preparo para insertarlas en los href
$mas_vars = '';
foreach($_GET as $clave => $valor) {
   if ($clave != 'pagina') {
	   $mas_vars .= '&' . $clave . '=' . $valor;
   }
}

global $rstabla;
global $resultado;
global $fila_tabla;

$this->Conectar();
$rstabla=new Recordset($cadsql, $this->conn);
if($rstabla->rowcount==0) return("");


//Algunos calculos
$numero_resultados = $rstabla->rowcount;
$total_registros=$numero_resultados;
$numero_paginas = ceil($numero_resultados / $resultados_pagina);
$_SESSION["ultimapagina"]=$numero_paginas;
$primer_resultado = ($pagina_actual * $resultados_pagina) - $resultados_pagina;

//contruye la informacion de guia del user

	$resultados['1'] = $numero_resultados;
   $resultados['2'] = $primer_resultado + 1;
   $resultados_restantes = $numero_resultados - floor($resultados_pagina*$pagina_actual);
   if (($resultados_restantes > 0) || ($numero_resultados%$resultados_pagina == 0)) {
	   $resultados['3'] = $primer_resultado + $resultados_pagina;
   }
   else {
	   $resultados['3'] = $primer_resultado + (- $resultados_restantes) - 2;
   }
   $resultados['4'] = $pagina_actual;

//************************************************************

$resultado="";

$_SESSION["total"]=$resultados[1];
//mostrar resultados

$numero_resultados = count($rstabla->result);
$array_resultados_pagina = @array_slice($rstabla->result, $primer_resultado, $resultados_pagina);

	$fila_tabla=0;
	$nreg=0;

	$rstabla->curpos=$primer_resultado;

	for($nf=$primer_resultado;$nf<=$primer_resultado+$resultados_pagina-1;$nf++)
	{
		if ($registro=$rstabla->Mostrar())
		{
			if($radio=="true")
			{
				if(($fila_tabla%2)==0) 	
					@$resultado=@$resultado."<tr class=\"fila\" style=\"font-size: 12px;\"  onclick=\"javascript:seleccionado('".@$nreg."', '".@$registro[@$campo_link]."')\"  bgcolor='#eeeeee' onload=\"this.style.background='#eeeeee'\"  onMouseOver=\"this.style.background='#E1E1E1'; this.style.color='blue'\" onMouseOut=\"this.style.background='#eeeeee'; this.style.color='black'\" >";
				else 
					$resultado=$resultado."<tr class=\"fila\" style=\"font-size: 12px;\" onclick=\"javascript:seleccionado('".$nreg."', '".$registro[$campo_link]."')\" bgcolor='#FFFFFF' onload=\"this.style.background='#FFFFFF'\"  onMouseOver=\"this.style.background='#E1E1E1'; this.style.color='blue'\" onMouseOut=\"this.style.background='#FFFFFF'; this.style.color='black'\">";

				$resultado.="<td align='".$fila["alineacion"]."'><input type=\"radio\" name=\"opcion\" id=\"opcion\" value=\"".$rs_tabla->rowset["idcaso"]."\"></td>";

			}
			else
			{
				if(($fila_tabla%2)==0) 	$resultado=$resultado."<tr class=\"fila\" style=\"font-size: 12px;\"  onclick=\"respuesta('".$registro[$campo_link]."');\"  bgcolor='#eeeeee' onload=\"this.style.background='#eeeeee'\"  onMouseOver=\"this.style.background='#E1E1E1'; this.style.color='blue'\" onMouseOut=\"this.style.background='#eeeeee'; this.style.color='black'\" >";

				else $resultado=$resultado."<tr class=\"fila\" style=\"font-size: 12px;\" onclick=\"respuesta('".$registro[$campo_link]."');\" bgcolor='#FFFFFF' onload=\"this.style.background='#FFFFFF'\"  onMouseOver=\"this.style.background='#E1E1E1'; this.style.color='blue'\" onMouseOut=\"this.style.background='#FFFFFF'; this.style.color='black'\">";
			}

			foreach ($Tabla as $obj=>$fila)
			{

                                if ($nreg==0) $fila_tabla=$fila_tabla+1;

				if ($fila["columna"]<>"imagen_tabla")
				{
					if ($fila["destino"]<>"")
					{
						$resultado.= "<td onclick=\"respuesta('".$registro[$fila["columna"]]."');\"  align='".$fila["alineacion"]."' class='fila' ><a href='javascript:respuesta('".$registro[$fila["columna"]]."')'></a>".$registro[$fila["columna"]]."</td>";
					}
					else
					{
						$resultado.=  "<td align='".$fila["alineacion"]."' class='fila' >".$registro[$fila["columna"]]."</td>";
					}
				}
				else
				{
					if ($fila["destino"]<>"")
					{
						$resultado.="<td align='".$fila["alineacion"]."'><a href=\"javascript:void('0')\"><img  src=\"".$fila["imagen_tabla"]."\" border=\"0\" title=\"".$fila["titulo_mensaje"]."\"/></a></td>";
					}
					else
					{
						$resultado.="<td  align='".$fila["alineacion"]."'><a href=\"javascript:respuesta('".$registro[$fila["columna"]]."');\"><img  src=\"".$fila["imagen_tabla"]."\" border=\"0\" title=\"".$fila["titulo_mensaje"]."\"/></a></td>";
					}
				}

			}//foreach

			if(isset($Botones))
			{
				if ($Botones["eliminar"]["target"]=="_self" || $Botones["eliminar"]["target"]=="_blank")
				{
					$resultado.=  "<td align='center'>
					<a href='".$Botones["consultar"]["destino"]."?accion=consultar&".$Botones["consultar"]["id"]."=".$registro[$Botones["consultar"]["id"]]."' target='".$Botones["consultar"]["target"]."' title='".$Botones["consultar"]["titulo"]."'><img  src='".$Botones["consultar"]["imagen"]."' border=\"0\"/></a>
					<a href='".$Botones["editar"]["destino"]."?accion=editar&".$Botones["editar"]["id"]."=".$registro[$Botones["editar"]["id"]]."' target='".$Botones["editar"]["target"]."' title='".$Botones["editar"]["titulo"]."'><img  src='".$Botones["editar"]["imagen"]."' border=\"0\"/></a>
					<a href='".$Botones["eliminar"]["destino"]."?accion=eliminar&".$Botones["eliminar"]["id"]."=".$registro[$Botones["eliminar"]["id"]]."' target='".$Botones["eliminar"]["target"]."' title='".$Botones["eliminar"]["titulo"]."'><img  src='".$Botones["eliminar"]["imagen"]."' border=\"0\"/></a>
					</td>";
				}
				else
				{
					$resultado.=  "<td align='center'>
					<a href=\"javascript:void('0')\" onclick=\"javascript:abrir_ventana('".$Botones["consultar"]["destino"]."?accion=consultar&".$Botones["consultar"]["id"]."=".$registro[$Botones["consultar"]["id"]]."', '".$Botones["consultar"]["target"]."')\" title='".$Botones["consultar"]["titulo"]."'><img  src='".$Botones["consultar"]["imagen"]."' border=\"0\" title=\"".$Botones["consultar"]["titulo"]."\"/></a>
					<a href=\"javascript:void('0')\" onclick=\"javascript:abrir_ventana('".$Botones["editar"]["destino"]."?accion=editar&".$Botones["editar"]["id"]."=".$registro[$Botones["editar"]["id"]]."', '".$Botones["consultar"]["target"]."')\" title='".$Botones["consultar"]["titulo"]."'><img  src='".$Botones["editar"]["imagen"]."' border=\"0\" title=\"".$Botones["editar"]["titulo"]."\"/></a>
					<a href=\"javascript:void('0')\" onclick=\"javascript:abrir_ventana('".$Botones["eliminar"]["destino"]."?accion=eliminar&".$Botones["eliminar"]["id"]."=".$registro[$Botones["eliminar"]["id"]]."', '".$Botones["consultar"]["target"]."')\" title='".$Botones["eliminar"]["titulo"]."'><img  src='".$Botones["eliminar"]["imagen"]."' border=\"0\" title=\"".$Botones["eliminar"]["titulo"]."\"/></a>
					</td>";
				}

			}

			$resultado.= "</tr>";

			$rstabla->Siguiente();

			$nreg+=1;

		}//if

	}

        $rstabla->Close();
        $this->Desconectar();

		if ($swpaginado==true)
		{
			if($total_registros>$resultados_pagina)
			{

			   $resultado .= "<tr><td colspan=\"".($fila_tabla-1)."\"><strong>Total Registros: ".$total_registros."</strong></td><td align='right' class='paginado'>";

			  // $resultado .= "<tr><td colspan=\"6\" align='center' class='paginado'>";
					   //Trabajamos con el "rotulo" de anterior
						   if ($pagina_actual > 1) {
							   $resultado .= "<a href=\"".$_SERVER['PHP_SELF']."?pagina=".($pagina_actual - 1).$mas_vars."\" class=\"".$class."\">".$etiqueta_anterior."</a>";
						   }
					   //Trabajamos con el "rotulo" de numeros
						   //Numeros Si no se alcanza $max_num_most o $num_max_most == 0
						   if(($max_num_most%2 == 0) && ($max_num_most != 0)) { $max_num_most -= 1;}
						   if (($numero_paginas  <= $max_num_most ) || ($max_num_most == 0)) {
							   for ($i = 1; $i < ($numero_paginas + 1)  ; $i++) {
								   if ($i == $pagina_actual) {
									   $resultado .= " ".$i;
								   }
								   else {
									   $resultado .= " <a href=\"".$_SERVER['PHP_SELF']."?pagina=".$i.$mas_vars."\" class=\"".$class."\">".$i."</a>";
								   }
							   }
						   }
						   //$Numeros si se alcanza $max_num_most
						   if (($numero_paginas  > $max_num_most) && ($max_num_most != 0)) {
							   if ($pagina_actual < ceil($max_num_most/2)) {
								   for ($i = 1; $i < ($max_num_most + 1) ; $i++) {
									   if ($i == $pagina_actual) {
										   $resultado .= " ".$i;
									   }
									   else {
										   $resultado .= " <a href=\"".$_SERVER['PHP_SELF']."?pagina=".$i.$mas_vars."\" class=\"".$class."\">".$i."</a>";
									   }
								   }
							   }
							   elseif ($pagina_actual > ($numero_paginas - ceil($max_num_most/2) + 1)) {
								   for ($i = ($numero_paginas - $max_num_most + 1); $i < ($numero_paginas + 1) ; $i++) {
									   if ($i == $pagina_actual) {
										   $resultado .= " ".$i;
									   }
									   else {
										   $resultado .= " <a href=\"".$_SERVER['PHP_SELF']."?pagina=".$i.$mas_vars."\" class=\"".$class."\">".$i."</a>";
									   }
								   }
							   }
							   else {
								   for ($i = floor($max_num_most/2); $i > 0 ; $i--) {
									   $resultado .= " <a href=\"".$_SERVER['PHP_SELF']."?pagina=".($pagina_actual - $i).$mas_vars."\" class=\"".$class."\">".($pagina_actual - $i)."</a>";
								   }
								   $resultado .= " ".$pagina_actual;
								   for ($i = 1; $i < ceil($max_num_most/2) ; $i++) {
									   $resultado .= " <a href=\"".$_SERVER['PHP_SELF']."?pagina=".($pagina_actual + $i).$mas_vars."\" class=\"".$class."\">".($pagina_actual + $i)."</a>";
								   }
							   }
						   }
					   //Trabajamos con el "rotulo" de siguiente
						   if ($pagina_actual < $numero_paginas) {
							   $resultado .= " <a href=\"".$_SERVER['PHP_SELF']."?pagina=".($pagina_actual + 1).$mas_vars."\" class=\"".$class."\">".$etiqueta_siguiente."</a>";
						   }

			$resultado .= "</td></tr>";
			}
			else
			{
			 $resultado .= "<tr><td colspan=\"4\"><strong>Total Registros: ".$total_registros."</strong></td><td colspan=\"4\" align='right' class='paginado'></td></tr>";
			}

		}//swpaginado

return ($resultado);

}

function cargar_tabla_botones_Efectividad($cadsql, $Tabla, $Botones, $max_paginas, $campo_link, $radio, $swpaginado=true)
{

//opciones de configuracion
$etiqueta_anterior = 'Anterior';    //texto o codigo de la imagen para indicar p�gina anterior
$etiqueta_siguiente = 'Siguiente';    //texto o codigo de la imagen para indicar p�gina siguiente
$class = 'fila';        //class para mostrar la barra de la paginaci�n
$max_num_most = 8;                    //delimita el numero de "numeros" a mostrar entre Anterior y Siguiente, 0 off
$resultados_pagina=$max_paginas;


//establecemos la pagina actual
if (isset($_GET['pagina'])) {
   $pagina_actual = $_GET['pagina'];
   $_SESSION["paginaactual"]=$pagina_actual;
} else {
   $pagina_actual = 1;
    $_SESSION["paginaactual"]=1;
}
//si hay mas variables enviadas por get, las preparo para insertarlas en los href
$mas_vars = '';
foreach($_GET as $clave => $valor) {
   if ($clave != 'pagina') {
	   $mas_vars .= '&' . $clave . '=' . $valor;
   }
}

global $rstabla;
global $resultado;
global $fila_tabla;

$this->Conectar();

//echo $cadsql;

$rstabla=new Recordset($cadsql, $this->conn);

if($rstabla->rowcount==0) return("");


//Algunos calculos
$numero_resultados = $rstabla->rowcount;
$total_registros=$numero_resultados;
$numero_paginas = ceil($numero_resultados / $resultados_pagina);
$_SESSION["ultimapagina"]=$numero_paginas;
$primer_resultado = ($pagina_actual * $resultados_pagina) - $resultados_pagina;

//contruye la informacion de guia del user

	$resultados['1'] = $numero_resultados;
	$resultados['2'] = $primer_resultado + 1;
	$resultados_restantes = $numero_resultados - floor($resultados_pagina*$pagina_actual);
   
   if (($resultados_restantes > 0) || ($numero_resultados%$resultados_pagina == 0)) 
   {
	   $resultados['3'] = $primer_resultado + $resultados_pagina;
   }
   else
   {
	   $resultados['3'] = $primer_resultado + (- $resultados_restantes) - 2;
   }
   $resultados['4'] = $pagina_actual;

//************************************************************

$resultado="";

$_SESSION["total"]=$resultados[1];
//mostrar resultados

$numero_resultados = count($rstabla->result);
$array_resultados_pagina = @array_slice($rstabla->result, $primer_resultado, $resultados_pagina);

	$fila_tabla=1;
	$nreg=0;

	$rstabla->curpos=$primer_resultado;


	for($nf=$primer_resultado;$nf<=$primer_resultado+$resultados_pagina-1;$nf++)
	{

		if ($registro=$rstabla->Mostrar())
		{

			if($radio=="true")
			{

				if(($fila_tabla%2)==0) 	$resultado=$resultado."<tr class=\"fila\" style=\"font-size: 12px;\"  onclick=\"javascript:seleccionado('".$nreg."', '".$registro[$campo_link]."')\"  bgcolor='#eeeeee' onload=\"this.style.background='#eeeeee'\"  onMouseOver=\"this.style.background='#E1E1E1'; this.style.color='blue'\" onMouseOut=\"this.style.background='#eeeeee'; this.style.color='black'\" >";

				else $resultado=$resultado."<tr class=\"fila\" style=\"font-size: 12px;\" onclick=\"javascript:seleccionado('".$nreg."', '".$registro[$campo_link]."')\" bgcolor='#FFFFFF' onload=\"this.style.background='#FFFFFF'\"  onMouseOver=\"this.style.background='#E1E1E1'; this.style.color='blue'\" onMouseOut=\"this.style.background='#FFFFFF'; this.style.color='black'\">";

				$resultado.="<td align='".@$fila["alineacion"]."'><input type=\"radio\" name=\"opcion\" id=\"opcion\" value=\"".@$rs_tabla->rowset["idcaso"]."\"></td>";
			}
			else
			{
				if(($fila_tabla%2)==0) 	$resultado=$resultado."<tr class=\"fila\" style=\"font-size: 12px;\"  onclick=\"respuesta('".$registro[$campo_link]."');\"  bgcolor='#eeeeee' onload=\"this.style.background='#eeeeee'\"  onMouseOver=\"this.style.background='#E1E1E1'; this.style.color='blue'\" onMouseOut=\"this.style.background='#eeeeee'; this.style.color='black'\" >";

				else $resultado=$resultado."<tr class=\"fila\" style=\"font-size: 12px;\" onclick=\"respuesta('".$registro[$campo_link]."');\" bgcolor='#FFFFFF' onload=\"this.style.background='#FFFFFF'\"  onMouseOver=\"this.style.background='#E1E1E1'; this.style.color='blue'\" onMouseOut=\"this.style.background='#FFFFFF'; this.style.color='black'\">";
			}

			$ncol_tabla=1;

			foreach ($Tabla as $obj=>$fila)
			{

				if ($fila["columna"]<>"imagen_tabla")
				{
					if ($fila["destino"]<>"")
					{
						$resultado.= "<td onclick=\"respuesta('".$registro[$fila["columna"]]."');\"  align='".$fila["alineacion"]."' class='fila' ><a href='javascript:respuesta('".$registro[$fila["columna"]]."')'></a>".$registro[$fila["columna"]]."</td>";
						$ncol_tabla++;
					}
					else
					{
						$resultado.=  "<td align='".$fila["alineacion"]."' class='fila' >".$registro[$fila["columna"]]."</td>";
						$ncol_tabla++;
					}
				}
				else
				{

					if ($fila["destino"]<>"")
					{
						$resultado.="<td align='".$fila["alineacion"]."'><a href=\"javascript:void('0')\"><img  src=\"".$fila["imagen_tabla"]."\" border=\"0\" title=\"".$fila["titulo_mensaje"]."\"/></a></td>";

					}
					else
					{
						if($registro["idestatus"] == REGISTRADO ){
							$imagen= "flag_green.png";
						}else if($registro["idestatus"] == ASIGNADO_ANALISTA){
							$imagen= "flag_yellow.png";
						}else if($registro["idestatus"] == EN_PROCESO){
							$imagen= "flag_orange.png";
						}else if($registro["idestatus"] == CERRADO){
							$imagen= "flag_red.png";
						}

                        @$resultado.="<td  align='".$fila["alineacion"]."'><a href=\"javascript:respuesta('".$registro[$fila["columna"]]."');\">
						<img  src=\"../comunes/imagenes/".$imagen."\" border=\"0\" title=\"".$fila["titulo_mensaje"]."\"/></a></td>";

					}
				}

			}//foreach



			if(isset($Botones))
			{
				if ($Botones["eliminar"]["target"]=="_self" || $Botones["eliminar"]["target"]=="_blank")
				{
					$resultado.=  "<td align='center'>
					<a href='".$Botones["consultar"]["destino"]."?accion=consultar&".$Botones["consultar"]["id"]."=".$registro[$Botones["consultar"]["id"]]."' target='".$Botones["consultar"]["target"]."' title='".$Botones["consultar"]["titulo"]."'><img  src='".$Botones["consultar"]["imagen"]."' border=\"0\"/></a>
					<a href='".$Botones["editar"]["destino"]."?accion=editar&".$Botones["editar"]["id"]."=".$registro[$Botones["editar"]["id"]]."' target='".$Botones["editar"]["target"]."' title='".$Botones["editar"]["titulo"]."'><img  src='".$Botones["editar"]["imagen"]."' border=\"0\"/></a>
					<a href='".$Botones["eliminar"]["destino"]."?accion=eliminar&".$Botones["eliminar"]["id"]."=".$registro[$Botones["eliminar"]["id"]]."' target='".$Botones["eliminar"]["target"]."' title='".$Botones["eliminar"]["titulo"]."'><img  src='".$Botones["eliminar"]["imagen"]."' border=\"0\"/></a>
					</td>";
				}
				else
				{
					$resultado.=  "<td align='center'>
					<a href=\"javascript:void('0')\" onclick=\"javascript:abrir_ventana('".$Botones["consultar"]["destino"]."?accion=consultar&".$Botones["consultar"]["id"]."=".$registro[$Botones["consultar"]["id"]]."', '".$Botones["consultar"]["target"]."')\" title='".$Botones["consultar"]["titulo"]."'><img  src='".$Botones["consultar"]["imagen"]."' border=\"0\" title=\"".$Botones["consultar"]["titulo"]."\"/></a>
					<a href=\"javascript:void('0')\" onclick=\"javascript:abrir_ventana('".$Botones["editar"]["destino"]."?accion=editar&".$Botones["editar"]["id"]."=".$registro[$Botones["editar"]["id"]]."', '".$Botones["consultar"]["target"]."')\" title='".$Botones["consultar"]["titulo"]."'><img  src='".$Botones["editar"]["imagen"]."' border=\"0\" title=\"".$Botones["editar"]["titulo"]."\"/></a>
					<a href=\"javascript:void('0')\" onclick=\"javascript:abrir_ventana('".$Botones["eliminar"]["destino"]."?accion=eliminar&".$Botones["eliminar"]["id"]."=".$registro[$Botones["eliminar"]["id"]]."', '".$Botones["consultar"]["target"]."')\" title='".$Botones["eliminar"]["titulo"]."'><img  src='".$Botones["eliminar"]["imagen"]."' border=\"0\" title=\"".$Botones["eliminar"]["titulo"]."\"/></a>
					</td>";
				}

			}

			$resultado.= "</tr>";

			$rstabla->Siguiente();
			$fila_tabla=$fila_tabla+1;
			$nreg+=1;

		}//if

	}

    $rstabla->Close();
    $this->Desconectar();

		if ($swpaginado==true)
		{

			if($total_registros>$resultados_pagina)
			{

			   $resultado .= "<tr><td colspan=\"3\" class=\"total_paginado\"><strong>Total Registros: ".$total_registros."</strong></td><td colspan=\"".($ncol_tabla-2)."\" align='right' class='paginado'>";

			  // $resultado .= "<tr><td colspan=\"6\" align='center' class='paginado'>";
					   //Trabajamos con el "rotulo" de anterior
						   if ($pagina_actual > 1) {
							   $resultado .= "<a href=\"".$_SERVER['PHP_SELF']."?pagina=".($pagina_actual - 1).$mas_vars."\" class=\"".$class."\">".$etiqueta_anterior."</a>";
						   }
					   //Trabajamos con el "rotulo" de numeros
						   //Numeros Si no se alcanza $max_num_most o $num_max_most == 0
						   if(($max_num_most%2 == 0) && ($max_num_most != 0)) { $max_num_most -= 1;}
						   if (($numero_paginas  <= $max_num_most ) || ($max_num_most == 0)) {
							   for ($i = 1; $i < ($numero_paginas + 1)  ; $i++) {
								   if ($i == $pagina_actual) {
									   $resultado .= " ".$i;
								   }
								   else {
									   $resultado .= " <a href=\"".$_SERVER['PHP_SELF']."?pagina=".$i.$mas_vars."\" class=\"".$class."\">".$i."</a>";
								   }
							   }
						   }
						   //$Numeros si se alcanza $max_num_most
						   if (($numero_paginas  > $max_num_most) && ($max_num_most != 0)) {
							   if ($pagina_actual < ceil($max_num_most/2)) {
								   for ($i = 1; $i < ($max_num_most + 1) ; $i++) {
									   if ($i == $pagina_actual) {
										   $resultado .= " ".$i;
									   }
									   else {
										   $resultado .= " <a href=\"".$_SERVER['PHP_SELF']."?pagina=".$i.$mas_vars."\" class=\"".$class."\">".$i."</a>";
									   }
								   }
							   }
							   elseif ($pagina_actual > ($numero_paginas - ceil($max_num_most/2) + 1)) {
								   for ($i = ($numero_paginas - $max_num_most + 1); $i < ($numero_paginas + 1) ; $i++) {
									   if ($i == $pagina_actual) {
										   $resultado .= " ".$i;
									   }
									   else {
										   $resultado .= " <a href=\"".$_SERVER['PHP_SELF']."?pagina=".$i.$mas_vars."\" class=\"".$class."\">".$i."</a>";
									   }
								   }
							   }
							   else {
								   for ($i = floor($max_num_most/2); $i > 0 ; $i--) {
									   $resultado .= " <a href=\"".$_SERVER['PHP_SELF']."?pagina=".($pagina_actual - $i).$mas_vars."\" class=\"".$class."\">".($pagina_actual - $i)."</a>";
								   }
								   $resultado .= " ".$pagina_actual;
								   for ($i = 1; $i < ceil($max_num_most/2) ; $i++) {
									   $resultado .= " <a href=\"".$_SERVER['PHP_SELF']."?pagina=".($pagina_actual + $i).$mas_vars."\" class=\"".$class."\">".($pagina_actual + $i)."</a>";
								   }
							   }
						   }
					   //Trabajamos con el "rotulo" de siguiente
						   if ($pagina_actual < $numero_paginas) {
							   $resultado .= " <a href=\"".$_SERVER['PHP_SELF']."?pagina=".($pagina_actual + 1).$mas_vars."\" class=\"".$class."\">".$etiqueta_siguiente."</a>";
						   }

			$resultado .= "</td></tr>";
			}
			else
			{
			 $resultado .= "<tr><td class=\"paginado\" colspan=\"".($ncol_tabla-1)."\"><strong>Total Registros: ".$total_registros."</strong></td><td colspan=\"1\" align='right' class='paginado'></td></tr>";
			}

		}//swpaginado

    return ($resultado);


}


function cargar_tabla_asignacion_casos($cadsql, $Tabla, $Botones, $max_paginas, $campo_link, $tipo_asignacion, $cusuario)
{

//opciones de configuracion
$etiqueta_anterior = 'Anterior';    //texto o codigo de la imagen para indicar p�gina anterior
$etiqueta_siguiente = 'Siguiente';    //texto o codigo de la imagen para indicar p�gina siguiente
$class = 'fila';        //class para mostrar la barra de la paginaci�n
$max_num_most = 8;                    //delimita el numero de "numeros" a mostrar entre Anterior y Siguiente, 0 off
$resultados_pagina=$max_paginas;


//establecemos la p�gina actual
if (isset($_GET['pagina'])) {
   $pagina_actual = $_GET['pagina'];
   $_SESSION["paginaactual"]=$pagina_actual;
} else {
   $pagina_actual = 1;
    $_SESSION["paginaactual"]=1;
}
//si hay m�s variables enviadas por get, las preparo para insertarlas en los href
$mas_vars = '';
foreach($_GET as $clave => $valor) {
   if ($clave != 'pagina') {
	   $mas_vars .= '&' . $clave . '=' . $valor;
   }
}

global $rstabla;
global $resultado;
global $fila_tabla;

$this->Conectar();
$rstabla=new Recordset($cadsql, $this->conn);
if($rstabla->rowcount==0) return("");


//Algunos calculos
$numero_resultados = $rstabla->rowcount;
$total_registros=$numero_resultados;
$numero_paginas = ceil($numero_resultados / $resultados_pagina);
$_SESSION["ultimapagina"]=$numero_paginas;
$primer_resultado = ($pagina_actual * $resultados_pagina) - $resultados_pagina;

//contruye la informacion de guia del user

	$resultados['1'] = $numero_resultados;
   $resultados['2'] = $primer_resultado + 1;
   $resultados_restantes = $numero_resultados - floor($resultados_pagina*$pagina_actual);
   if (($resultados_restantes > 0) || ($numero_resultados%$resultados_pagina == 0)) {
	   $resultados['3'] = $primer_resultado + $resultados_pagina;
   }
   else {
	   $resultados['3'] = $primer_resultado + (- $resultados_restantes) - 2;
   }
   $resultados['4'] = $pagina_actual;

//************************************************************

$resultado="";

$_SESSION["total"]=$resultados[1];
//mostrar resultados

$numero_resultados = count($rstabla->result);
$array_resultados_pagina = @array_slice($rstabla->result, $primer_resultado, $resultados_pagina);

	$fila_tabla=1;
	$nreg=0;

	$rstabla->curpos=$primer_resultado;


	for($nf=$primer_resultado;$nf<=$primer_resultado+$resultados_pagina-1;$nf++)
	{

		if ($registro=$rstabla->Mostrar())
		{

			if(($fila_tabla%2)==0) $resultado=$resultado."<tr class=\"fila\" style=\"font-size: 12px;\"  onclick=\"respuesta('".$registro[$campo_link]."');\"  bgcolor='#eeeeee' onload=\"this.style.background='#eeeeee'\"  onMouseOver=\"this.style.background='#E1E1E1'; this.style.color='blue'\" onMouseOut=\"this.style.background='#eeeeee'; this.style.color='black'\" >";

			else $resultado=$resultado."<tr class=\"fila\" style=\"font-size: 12px;\" onclick=\"respuesta('".$registro[$campo_link]."');\" bgcolor='#FFFFFF' onload=\"this.style.background='#FFFFFF'\"  onMouseOver=\"this.style.background='#E1E1E1'; this.style.color='blue'\" onMouseOut=\"this.style.background='#FFFFFF'; this.style.color='black'\">";

			foreach ($Tabla as $obj=>$fila)
			{

                         
                            $cusuario->set_objeto(ASIGNACION_ANALISTA);
                       
                            $cusuario->getPermisos();

                            $nanalista=$this->Count("casos_analistas_actuales","estatus_asignacion='0' and idcaso=".$registro[$campo_link]);

                            if ($fila["columna"]<>"imagen_tabla")
                            {
                                if ($fila["destino"]<>"")
                                {
                                    $resultado.= "<td onclick=\"respuesta('".$registro[$campo_link]."');\"  align='".$fila["alineacion"]."' class='fila' ><a href='javascript:respuesta('".$registro[$fila["columna"]]."')'></a>".$registro[$fila["columna"]]."</td>";
                                }
                                else
                                {
                                    $resultado.=  "<td align='".$fila["alineacion"]."' class='fila' >".$registro[$fila["columna"]]."</td>";
                                }
                            }
                            else
                            {
                                if ($fila["destino"]<>"")
                                {
                                    $resultado=$resultado." <td align='".$fila["alineacion"]."' class='fila'>";
                                    //$resultado=$resultado." <a href=\"javascript:window.open('frm_asignacion_casos.php?idcaso=".$registro[$campo_link]."&tipo_proceso=asignar_analista', 'contenido')\"><img src='../comunes/imagenes/user_add.png' title='Asignar Analista' border='0' /></a>";

                                    if ($cusuario->get_insertar()=='1' && $nanalista==0)
                                    {
                                        $resultado=$resultado." <a href=\"javascript:window.open('frm_asignacion_casos.php?idcaso=".$registro[$campo_link]."&tipo_proceso=asignar_analista', 'contenido')\"><img src='../comunes/imagenes/user_add.png' title='Asignar Analista' border='0' /></a>";
                                    }

                                    if ($cusuario->get_actualizar()=='1' && $nanalista>0)
                                    {
                                        $resultado=$resultado." <a href=\"javascript:window.open('frm_asignacion_casos.php?idcaso=".$registro[$campo_link]."&tipo_proceso=reasignar_analista', 'contenido')\"><img src='../comunes/imagenes/user_go.png' title='Reasignar Analista' border='0' /></a>";
                                    }

                                    $resultado=$resultado."</td>";

                                }
                                else
                                {
                                    $resultado.="<td><a href=\"javascript:respuesta('".$registro[$campo_link]."');\"><img  src=\"".$fila["imagen_tabla"]."\" border=\"0\" title=\"".$fila["titulo_mensaje"]."\"/></a></td>";
                                }
                            }
			}//foreach

			$resultado.= "</tr>";

			$rstabla->Siguiente();
			$fila_tabla=$fila_tabla+1;
			$nreg+=1;

		}//if

	}

    $rstabla->Close();
    $this->Desconectar();

		if($total_registros>$resultados_pagina)
		{

           $resultado .= "<tr><td colspan=\"4\" class='total_paginado'>Total Registros: ".$total_registros."</td><td colspan=\"4\" align='right' class='paginado'>";

          // $resultado .= "<tr><td colspan=\"6\" align='center' class='paginado'>";
                   //Trabajamos con el "rotulo" de anterior
                       if ($pagina_actual > 1) {
                           $resultado .= "<a href=\"".$_SERVER['PHP_SELF']."?pagina=".($pagina_actual - 1).$mas_vars."\" class=\"".$class."\">".$etiqueta_anterior."</a>";
                       }
                   //Trabajamos con el "rotulo" de numeros
                       //Numeros Si no se alcanza $max_num_most o $num_max_most == 0
                       if(($max_num_most%2 == 0) && ($max_num_most != 0)) { $max_num_most -= 1;}
                       if (($numero_paginas  <= $max_num_most ) || ($max_num_most == 0)) {
                           for ($i = 1; $i < ($numero_paginas + 1)  ; $i++) {
                               if ($i == $pagina_actual) {
                                   $resultado .= " ".$i;
                               }
                               else {
                                   $resultado .= " <a href=\"".$_SERVER['PHP_SELF']."?pagina=".$i.$mas_vars."\" class=\"".$class."\">".$i."</a>";
                               }
                           }
                       }
                       //$Numeros si se alcanza $max_num_most
                       if (($numero_paginas  > $max_num_most) && ($max_num_most != 0)) {
                           if ($pagina_actual < ceil($max_num_most/2)) {
                               for ($i = 1; $i < ($max_num_most + 1) ; $i++) {
                                   if ($i == $pagina_actual) {
                                       $resultado .= " ".$i;
                                   }
                                   else {
                                       $resultado .= " <a href=\"".$_SERVER['PHP_SELF']."?pagina=".$i.$mas_vars."\" class=\"".$class."\">".$i."</a>";
                                   }
                               }
                           }
                           elseif ($pagina_actual > ($numero_paginas - ceil($max_num_most/2) + 1)) {
                               for ($i = ($numero_paginas - $max_num_most + 1); $i < ($numero_paginas + 1) ; $i++) {
                                   if ($i == $pagina_actual) {
                                       $resultado .= " ".$i;
                                   }
                                   else {
                                       $resultado .= " <a href=\"".$_SERVER['PHP_SELF']."?pagina=".$i.$mas_vars."\" class=\"".$class."\">".$i."</a>";
                                   }
                               }
                           }
                           else {
                               for ($i = floor($max_num_most/2); $i > 0 ; $i--) {
                                   $resultado .= " <a href=\"".$_SERVER['PHP_SELF']."?pagina=".($pagina_actual - $i).$mas_vars."\" class=\"".$class."\">".($pagina_actual - $i)."</a>";
                               }
                               $resultado .= " ".$pagina_actual;
                               for ($i = 1; $i < ceil($max_num_most/2) ; $i++) {
                                   $resultado .= " <a href=\"".$_SERVER['PHP_SELF']."?pagina=".($pagina_actual + $i).$mas_vars."\" class=\"".$class."\">".($pagina_actual + $i)."</a>";
                               }
                           }
                       }
                   //Trabajamos con el "rotulo" de siguiente
                       if ($pagina_actual < $numero_paginas) {
                           $resultado .= " <a href=\"".$_SERVER['PHP_SELF']."?pagina=".($pagina_actual + 1).$mas_vars."\" class=\"".$class."\">".$etiqueta_siguiente."</a>";
                       }

        $resultado .= "</td></tr>";
		}
		else
		{
		 $resultado .= "<tr><td colspan=\"2\" class='total_paginado'>Total Registros: ".$total_registros."</td><td colspan=\"2\" align='right' class='paginado'></td></tr>";
		}
return ($resultado);
}

function Ejecutarsql($sql)
{
    $this->Conectar();
    $this->cadena_error=$sql;
	$resultado = @pg_query($this->conn,$sql);
	if ($resultado == FALSE or $resultado === FALSE){
		die("<b>Error on Driver DB...! </b></br><b>Sentencia: </b>$sql  </br><b>Descripción: </b>".pg_last_error()) ; 
		exit;		
	}
	else
		return $resultado;
	# return pg_query($this->conn,$sql);
	# die(pg_last_error ($this->conn));
    //$this->Desconectar();
}

function  Desconectar(){
    return (@pg_close($this->conn));
}

function Insertar_Sql($tabla,$campos,$arr_valores)
{
        $sql="";

	if (gettype(current($arr_valores))=="string")  $valores="'".current($arr_valores)."'";
	else  $valores=current($arr_valores);

	while($valor=next($arr_valores))
        {

		if ($valor=="false")
		{
			$valores=$valores.",'0'";
		}
		else
		{
			if (gettype($valor)=="string") $valores=$valores.",'".$valor."'";
			else $valores=$valores.",".$valor;
		}
	}

	if($campos=="")$sql="Insert Into ".$tabla." Values(".$valores.")";
	else $sql="Insert Into ".$tabla." (".$campos.") Values(".$valores.")";

	$this->cadena_error=$sql;
	return ($this->Ejecutarsql($sql));
	//return $sql;


}

function Update_Sql($tabla,$campos,$arr_valores2,$condicion){

    $camp=split(",",$campos);

    $sql="Update ".$tabla." Set ";

   if (gettype(current($arr_valores2))=="string") $sql=$sql.current($camp)."='".current($arr_valores2)."'";
   else $sql=$sql.current($camp)."=".current($arr_valores2);

   while($valor=next($arr_valores2)) {

	if ($valor=="false")
	{
		$sql=$sql.", ".next($camp)."='0'";
	}
	else
	{
	  if (gettype($valor)=="string")$sql=$sql.", ".next($camp)."='".$valor."'";
      else $sql=$sql.",".next($camp)."= ".$valor;
	}

   }
   if ($condicion!="")$sql=$sql." Where ".$condicion;

   $this->cadena_error=$sql;
   //echo $this->cadena_error;
   return ($this->Ejecutarsql($sql));


   }

function Eliminar($tabla,$condicion)
{

   $sql="Delete From ".$tabla;
   if ($condicion!="")$sql=$sql." Where ".$condicion;

   return ($this->Ejecutarsql($sql));


}//Update

function getInt($tabla,$campo,$condicion)
{

    $sql="Select ".$campo."  From ".$tabla;
    if ($condicion!="")$sql=$sql." Where ".$condicion;

    $this->Conectar();
    $rs=new Recordset($sql, $this->conn);
    $rs->Mostrar();

    if(isset($rs->rowset[$campo]))return ($rs->rowset[$campo]);
    else return (0);
  //return($sql);
}


function getString($tabla,$campo,$condicion)
{

    $sql="Select ".$campo." From ".$tabla;
    if ($condicion!="")$sql=$sql." Where ".$condicion;
    $this->Conectar();
    $rs=new Recordset($sql, $this->conn);

    $rs->Mostrar();

    if(isset($rs->rowset[$campo]))return ($rs->rowset[$campo]);
    else return ("");
  //return($sql);
}

function getMonto($tabla,$campo,$condicion)
{

    $sql="Select to_money(".$campo.") as valor From ".$tabla;
    if ($condicion!="")$sql=$sql." Where ".$condicion;
    $this->Conectar();
    $rs=new Recordset($sql, $this->conn);

    $rs->Mostrar();

    if(isset($rs->rowset["valor"]))return ($rs->rowset["valor"]);
    else return ("0");
  //return($sql);
}

function Identidad($tabla,$campo,$condicion)
{

    $sql="Select indice=isnull(max(".$campo."),0) From ".$tabla;
    if ($condicion!="")$sql=$sql." Where ".$condicion;
    $this->Conectar();
    $rs=new Recordset($sql, $this->conn);
    $rs->Mostrar();
    return ($rs->rowset["indice"]+1);
  //return($sql);
}

function getMax($tabla,$campo,$condicion)
{

    $sql="Select max(".$campo.") as indice From ".$tabla;
    if ($condicion!="")$sql=$sql." Where ".$condicion;
    $this->Conectar();
    $rs=new Recordset($sql, $this->conn);
    $rs->Mostrar();
    return ($rs->rowset["indice"]);
    //return($sql);
}

function getSuma($tabla,$campo,$condicion)
{

    $sql="Select sum(".$campo.") as total From ".$tabla;
    if ($condicion!="")$sql=$sql." Where ".$condicion;
    $this->Conectar();
    $rs=new Recordset($sql, $this->conn);
    $rs->Mostrar();

    if(isset($rs->rowset["total"])) return ($rs->rowset["total"]);
    else return ("0");

}

function Count($tabla,$condicion)
{

	$sql="Select case when count(*) is null then 0 else count(*) end as indice From ".$tabla;
	
	if ($condicion!="")$sql=$sql." Where ".$condicion;
	        $this->Conectar();
	#die($sql);
	$rs=new Recordset($sql, $this->conn);
	$rs->Mostrar();
        if ($rs->rowset["indice"]>=0)   
			$nregistros=$rs->rowset["indice"];
        else
			$nregistros = 0;
        return ($nregistros);

}

function getPermiso($objeto,$permiso)
{
   if($_SESSION["id_grupo"]==1) return(true);
   $sql="Select * From v_permisos_get";
   $sql=$sql." Where ".$permiso."=1"." And nombreobj like '%".$objeto."%' And id_grupo=".$_SESSION["id_grupo"];
   $this->Conectar();
   $rs=new Recordset($sql, $this->conn);
   if($rs->rowcount>0) return (true);
   else return (false);
}

function setAuditoria($tabla,$operacion,$codigo,$nombre){
	$sql="Insert Into auditoria";
	$sql=$sql."(tabla,operacion,codigo,nombre,id_usuario) Values(";
	$sql=$sql."'$tabla',";
	$sql=$sql."'$operacion',";
	$sql=$sql."'$codigo',";
	$sql=$sql."'$nombre',";
	$sql=$sql.$_SESSION["iduser"];
	$sql=$sql.")";
	$this->Ejecutarsql($sql);
}//setAuditoria

function getRecordset($sql)
{
  $this->Conectar();

  $rs=new Recordset($sql, $this->conn);

  if ($rs->Mostrar())
  {
	return $rs;
  }
  else
  {
	return false;
  }
}//getRecordset

function getFecha($tabla,$campo,$condicion)
{
    $sql="Select to_fecha(".$campo.") as sfecha From ".$tabla;
    if ($condicion!="")$sql=$sql." Where ".$condicion;
    $this->Conectar();
    $rs=new Recordset($sql, $this->conn);
    $rs->Mostrar();
    return ($rs->rowset["sfecha"]);
}

function getValor_Campo($sql, $campo)
{
     $this->Conectar();
     $rs=new Recordset($sql, $this->conn);
     $rs->Mostrar();
     if(isset($rs->rowset[$campo]))return ($rs->rowset[$campo]);
     else return '';
  //return($sql);
}

function registrar_error($sentencia, $modulo, $idusuario)
{
    //echo $sentencia;
	$sentencia2=duplicar_comillas($sentencia);
    $this->Ejecutarsql("Insert Into errores_sistema (idusuario,sentencia,modulo) Values ('".$_SESSION["idusuario"]."', '".$sentencia2."', '".$modulo."')");
}

function get_bcoordinacion($idgerencia)
{
    return $this->getInt("vgerencias", "bcoordinaciones", "idmaestro='$idgerencia'");
}

function crearSeguimiento()
{

    $slogin=$this->getString("vusuarios", "login", "idusuario=".$this->get_idusuario_seg());
    $susuario=$this->getString("vusuarios", "snombre_usuario", "idusuario=".$this->get_idusuario_seg());

    $descripcion=$susuario." <b>(".$slogin.")</b> ".$this->get_descripcion_seg();
    $sql="insert into seguimientos (descripcion, idusuario, idcaso) values ('".$descripcion."', '".$this->get_idusuario_seg()."', '".$this->get_idcaso_seg()."')";
    $seg=$this->Ejecutarsql($sql);

    if(validar_vacio($seg)==true)
    {
        $this->registrar_error($sql, "Seguimiento", $this->get_idusuario_seg());
    }

}//setSeguimiento

}//fin class


$dat=new Datos;
$dat->Conectar();

?>
