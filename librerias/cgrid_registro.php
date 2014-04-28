<?

require_once("db_postgresql.inc.php");

class cgrid_maestro extends Datos
{
	private $arrTable = "vregistros";
	public $arrFields = array('idmaestro', 'descripcion');
	
	public function __construct()
	{	
	}
	
	public function showList($id='')
	{	

		$textout = "";
		$orden="";
		$param = $_GET['param'];
		$dir = $_GET['dir'];

		if(strlen($param)>0){				
			
			$param = $_REQUEST['param'];
			$dir = $_REQUEST['dir'];
			
//start fields generation

			if ( $_GET['dir'] == 'desc' )
			{
				$orden=" order by ".$param." desc";
				$textout .= '<tr style="font-size: 10px; background-color: #EFEFEF; text-align:center; font-weight:bold;">';
				for ( $i = 0 ; $i < count($this->arrFields) ; $i ++ )
				{
			
					$textout .= ($_GET['param'] == $this->arrFields[$i])?'<td><a href="#" onClick=getagents("'.$this->arrFields[$i].'","")>'.$this->arrFields[$i].'</a> <img src="../comunes/imagenes/titmini_orddec.gif" alt="Cancelar" width="12" title="Ordenar" height="12" border="0" /></td>':'<td><a href="#" onClick=getagents("'.$this->arrFields[$i].'","")>'.$this->arrFields[$i].'</a></td>';
				}
				$textout .= '<td></td><td></td><td>&nbsp;</td><td><a href="#" onClick=newRecord("new","'.$param.'","'.$dir.'")><img src="../comunes/imagenes/page_add.png" alt="Guardar" title="Nuevo Registro" width="16" height="16" border="0" /></a></td>';
				$textout .= '</tr>';
			}
			else
			{
				$orden=" order by ".$param." asc";
				$textout .= '<tr style="font-size: 10px; background-color: #EFEFEF; text-align:center; font-weight:bold;">';
				for ( $i = 0 ; $i < count($this->arrFields) ; $i ++ )
				{
					$textout .= ($_GET['param'] == $this->arrFields[$i])?'<td><a href="#" onClick=getagents("'.$this->arrFields[$i].'","desc")>'.$this->arrFields[$i].'</a> <img src="../comunes/imagenes/titmini_ord_asc.gif" alt="Cancelar" width="12" title="Ordenar" height="12" border="0" /></td>':'<td><a href="#" onClick=getagents("'.$this->arrFields[$i].'","desc")>'.$this->arrFields[$i].'</a></td>';
				}
				$textout .= '<td></td><td></td><td>&nbsp;</td><td><a href="#" onClick=newRecord("new","'.$param.'","'.$dir.'")><img src="../comunes/imagenes/page_add.png" alt="Guardar" title="Nuevo Registro" width="16" height="16" border="0" /></a></td>';
				$textout .= '</tr>';
			}			

//end fields generation

				$arrf='';
				for ( $i = 0 ; $i < count($this->arrFields) ; $i ++ )
				{
					$arrf .= ','.$this->arrFields[$i];
				}

                                $this->Conectar();
				$rs_tabla=new Recordset("select idmaestro, descripcion, estatus from ".$this->arrTable." where idpadre=".$_SESSION["npadre"]." ".$orden, $this->conn);	

				$swfondo=true;
				
				while ($rs_tabla->Mostrar())
				{	
				
					if ( $id == $rs_tabla->rowset["idmaestro"] )	//actualizando
					{	
						
						if ($swfondo)
						{
							$textout .= '<tr style="background:#CCCCCC;">';
							$swfondo=false;
						}
						else
						{
							$textout .= '<tr>';
							$swfondo=true;
						}
						
					 	$textout .= '
						<td align="center"><input name="codigo" id="codigo" type="hidden" value='.$rs_tabla->rowset["idmaestro"].'></td>									
						<td><input type="text" size="60" class="textbox" name="descripcion" id="descripcion" value="'.$rs_tabla->rowset["descripcion"].'"></td>
						<td>
						<select name="estatus" id="estatus" style="width:80px" class="inputbox">';
						$textout .= $this->Cargarlista("select idestatus, descripcion from estatus_tablas order by descripcion", $rs_tabla->rowset["estatus"]);
						$textout .='
    </select>
						</td>		<td>&nbsp;</td>					
						<td><a href="#" onClick=saveRecord("save",'.$rs_tabla->rowset["idmaestro"].',"'.$param.'","'.$dir.'")><img src="../comunes/imagenes/disk.png" alt="Guardar"  width="12" height="12" border="0" /></a> </td>
						<td> <a href="#" onClick=getagents("'.$param.'","'.$dir.'")><img src="../comunes/imagenes/cancelar.jpg" alt="Cancelar" width="12" title="Cancelar" height="12" border="0" /></a></td>
								</tr>
							';					  
					}
					else		//mostrar registro normal
					{
					
						$var="?id=".$rs_tabla->rowset["idmaestro"]."&nombre=".$rs_tabla->rowset["descripcion"];
						if ($rs_tabla->rowset["estatus"]=="1") 
						{
							$tdestatus='<td width="15%"><img src="../comunes/imagenes/activo.gif" alt="Registro Activo" title="Registro Activo" width="12" height="12" border="0" />Activo</td>';
						}
						else
						{
							$tdestatus='<td width="15%"><img src="../comunes/imagenes/inactivo.gif" alt="Registro Activo" title="Registro Inactivo" width="12" height="12" border="0" />Inactivo</td>';
						}
									
						if ($swfondo)
						{
							$textout .= '<tr>';
							$textout .= '<td width="15%" align="center">'.$rs_tabla->rowset["idmaestro"].'</td>
						<td width="60%">'.$rs_tabla->rowset["descripcion"].'</td>
						<td width="10%">'.@$rs_tabla->rowset["alias"].'</td>'.$tdestatus;	
							$swfondo=false;
						}
						else
						{
							$textout .= '<tr style="background:#CCCCCC;">';
							$textout .= '<td width="15%" align="center">'.$rs_tabla->rowset["idmaestro"].'</td>
						<td width="60%">'.$rs_tabla->rowset["descripcion"].'</td>
						<td width="10%">'.@$rs_tabla->rowset["alias"].'</td>'.$tdestatus;		
							$swfondo=true;
						}//if swfondo
			
						$textout .= '<td width="5%"><a href="#" onClick=manipulateRecord("update",'.$rs_tabla->rowset["idmaestro"].',"'.$param.'","'.$dir.'")><img src="../comunes/imagenes/page_edit.png" alt="Editar" title="Editar Registro" width="12" height="12" border="0" /></a> </td>
						<td width="5%"> <a href="#" onClick=manipulateRecord("delete",'.$rs_tabla->rowset["idmaestro"].',"'.$param.'","'.$dir.'")> <img src="../comunes/imagenes/cross.png" alt="Eliminar" title="Eliminar Registro" width="12" height="12" border="0" /></a></td>
								</tr>';
					}
					$rs_tabla->Siguiente();
					
				}//while
								
		} else {	//param=0
			$textout='<tr><td colspan="6">Registro No Disponible</td></tr>';
		}


	   if ( $_REQUEST['mode'] == "new" )
		{			
                    $textout .= '
                    <tr >
                    <td align="center"><input name="codigo" id="codigo" type="hidden" value='.$rs_tabla->rowset["idmaestro"].'></td>
                    <td><input type="text" size="40" class="textbox" name="descripcion" id="descripcion" value=""></td>
                    <td>&nbsp;</td><td>&nbsp;</td>
                    <td><a href="#" onClick=saveNewRecord("newsave","'.$param.'","'.$dir.'")><img src="../comunes/imagenes/disk.png" alt="Guardar" width="12" height="12" border="0" /></a> </td>
                    <td> <a href="#" onClick=getagents("'.$param.'","'.$dir.'")><img src="../comunes/imagenes/cancelar.jpg" alt="Cancelar" width="12" height="12" border="0" /></a></td>
                    </tr>
                    ';
		}		
		
		echo "<table cellspacing=\"0\" border=\"0\" cellpadding=\"2\" align=\"center\" width=\"100%\">".$textout."</table>";
		
		
		
	  }//showList
	
	public function deleteRecord($id='')
	{
		$result=$this->Ejecutarsql('delete from maestro where idmaestro = '.$id);		
	}	
	
	public function saveEditedRecord()
	{		
		$result=$this->Ejecutarsql("update maestro set descripcion = '".$_REQUEST['descripcion']."', estatus=".$_REQUEST['estatus']." where idmaestro =".$_REQUEST["codigo"]);		
	}
	
	public function saveNewRecord()
	{
		
		$existe=$this->Count("maestro", "idpadre=".$_SESSION["npadre"]." and upper(descripcion)='". trim(strtoupper($_REQUEST['descripcion']))."'");
		
		if ($existe>0) return false;
		
		$result=$this->Ejecutarsql("insert into maestro (descripcion, tipo_registro, idpadre, alias) values('".$_REQUEST['descripcion']."', 1, ".$_SESSION["npadre"].", '')");
		
	}
	
}//class

$obj = new cgrid_maestro();

if ( $_REQUEST['mode'] == "delete" )
{
	$obj->deleteRecord($_REQUEST['id']);
	echo $obj->showList();
}

if ( $_REQUEST['mode'] == "update" )
{
	$obj->showList($_REQUEST['id']);
}

if ( $_REQUEST['mode'] == "save" )
{
	$obj->saveEditedRecord();
	$obj->showList();
}

if ( $_REQUEST['mode'] == "newsave" )
{
	$obj->saveNewRecord();
	$obj->showList();
}

if ( $_REQUEST['mode'] == "new" )
{
	$obj->showList();
}

if ( $_REQUEST['mode'] == "list" )
{
	$obj->showList();
}
?>