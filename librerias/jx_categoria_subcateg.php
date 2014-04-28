<?php
// Array que vincula los IDs de los selects declarados en el HTML con el nombre de la tabla donde se encuentra su contenido
$listadoSelects_categorias=array(
"tipo_caso"=>"lista_tipo_caso",
"categoria"=>"lista_categoria",
"subcategoria"=>"lista_subcategoria"
);

function validaSelect_categorias($selectDestino)
{
	global $listadoSelects_categorias;
	if(isset($listadoSelects_categorias[$selectDestino])) return true;
	else return false;
}

function validaOpcion_categorias($opcionSeleccionada)
{
	// Se valida que la opcion seleccionada por el usuario en el select tenga un valor numerico
	if(is_numeric($opcionSeleccionada)) return true;
	else return false;
}

$selectDestino=$_GET["select"]; $opcionSeleccionada=$_GET["opcion"];

if(validaSelect_categorias($selectDestino) )
{
    $tabla=$listadoSelects_categorias[$selectDestino];

    include_once ('db_postgresql.inc.php');
    $dat->Conectar();

    if ($selectDestino=="categoria" && validaOpcion_categorias($opcionSeleccionada))
    {
       $opcionSeleccionada = ($opcionSeleccionada == '') ? -1 : $opcionSeleccionada;
		$rs=new Recordset("select distinct(scategoria) as scategoria, idcategoria from vtipocasos_categorias where idtipocaso='$opcionSeleccionada' order by scategoria", $dat->conn);

        echo "<select name='".$selectDestino."' id='".$selectDestino."'style='width:166px;' class='inputbox' onChange='cargaContenido_Categoria(this.id)' >";
        echo "<option value=\"0\">Seleccione...</option>";

        while($rs->Mostrar())
        {

        echo "<option value='".$rs->rowset["idcategoria"]."'>".$rs->rowset["scategoria"]."</option>";
        $rs->Siguiente();
        }

        echo "</select>";
    }
    else 
    {        
         $rs=new Recordset("select distinct(ssubcategoria) as ssubcategoria, idsubcategoria  from vtipocasos_categorias where idcategoria='$opcionSeleccionada' order by ssubcategoria", $dat->conn);

        echo "<select name='".$selectDestino."' id='".$selectDestino."'style='width:166px;' class='inputbox'>";
        echo "<option value=\"0\">Seleccione...</option>";

        while($rs->Mostrar())
        {

        echo "<option value='".$rs->rowset["idsubcategoria"]."'>".$rs->rowset["ssubcategoria"]."</option>";
        $rs->Siguiente();
        }

        echo "</select>";
    }

}
?>