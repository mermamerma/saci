<?php
// Array que vincula los IDs de los selects declarados en el HTML con el nombre de la tabla donde se encuentra su contenido
$listadoSelects_estados=array(
"estado"=>"lista_estado",
"municipio"=>"lista_municipio",
"parroquia"=>"lista_parroquia"
);

function validaSelect_estados($selectDestino)
{
	global $listadoSelects_estados;
	if(isset($listadoSelects_estados[$selectDestino])) return true;
	else return false;
}

function validaOpcion_estados($opcionSeleccionada)
{
	// Se valida que la opcion seleccionada por el usuario en el select tenga un valor numerico
	if(is_numeric($opcionSeleccionada)) return true;
	else return false;
}

$selectDestino=$_GET["select"]; $opcionSeleccionada=$_GET["opcion"];

if(validaSelect_estados($selectDestino) )
{
	$tabla=$listadoSelects_estados[$selectDestino];

	include_once ('db_postgresql.inc.php');
        $dat->Conectar();

	if ($selectDestino=="municipio" && validaOpcion_estados($opcionSeleccionada))
	{
		$rs=new Recordset("select idmunicipio, descripcion from municipios where idestado='$opcionSeleccionada' order by descripcion", $dat->conn);

		echo "<select name='".$selectDestino."' id='".$selectDestino."'style='width:160px;' class='inputbox' onChange='cargaContenido_Estados(this.id)'>";
		echo "<option value=\"0\">Seleccione...</option>";

		while($rs->Mostrar())
		{

		echo "<option value='".$rs->rowset["idmunicipio"]."'>".$rs->rowset["descripcion"]."</option>";
		$rs->Siguiente();
		}

		echo "</select>";
	}
	else
	{
		$rs=new Recordset("select idparroquia, descripcion from parroquias where idmunicipio='$opcionSeleccionada' order by descripcion", $dat->conn);

		echo "<select name='".$selectDestino."' id='".$selectDestino."' style='width:160px;' class='inputbox' onChange='cargaContenido_Estados(this.id)'>";
		echo "<option value=\"0\">Seleccione...</option>";

		while($rs->Mostrar())
		{

		echo "<option value='".$rs->rowset["idparroquia"]."'>".$rs->rowset["descripcion"]."</option>";

		$rs->Siguiente();
		}

		echo "</select>";
	}



}
?>