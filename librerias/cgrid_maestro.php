<?

require_once("db_postgresql.inc.php");

class cgrid_maestro extends Datos
{
	private $arrTable = "vtablas";
	public $arrFields = array('idmaestro', 'descripcion', 'alias');
	
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
				$textout .= '<tr style="font-size: 12px; background-color: #EFEFEF; text-align:center; font-weight:bold;">';
				for ( $i = 0 ; $i < count($this->arrFields) ; $i ++ )
				{
					$textout .= ($_GET['param'] == $this->arrFields[$i])?'<td><a href="#" onClick=getagents("'.$this->arrFields[$i].'","")>'.$this->arrFields[$i].'</a> <img src="../comunes/imagenes/titmini_orddec.gif" alt="Cancelar" width="9" title="Ordenar" height="7" border="0" /></td>':'<td><a href="#" onClick=getagents("'.$this->arrFields[$i].'","")>'.$this->arrFields[$i].'</a></td>';
				}
				$textout .= '<td></td><td><a href="#" onClick=newRecord("new","'.$param.'","'.$dir.'")><img src="../comunes/imagenes/page_add.png" alt="Guardar" title="Nueva Tabla" width="16" height="16" border="0" /></a></td>';
				$textout .= '</tr>';
			}
			else
			{
				$orden=" order by ".$param." asc";
				$textout .= '<tr style="font-size: 12px; background-color: #EFEFEF; text-align:center; font-weight:bold;">';
				for ( $i = 0 ; $i < count($this->arrFields) ; $i ++ )
				{					
					$textout .= ($_GET['param'] == $this->arrFields[$i])?'<td><a href="#" onClick=getagents("'.$this->arrFields[$i].'","desc")>'.$this->arrFields[$i].'</a> <img src="../comunes/imagenes/titmini_ordasc-selected.gif" alt="Cancelar" width="9" title="Ordenar" height="7" border="0" /></td>':'<td><a href="#" onClick=getagents("'.$this->arrFields[$i].'","desc")>'.$this->arrFields[$i].'</a></td>';
				}
				$textout .= '<td></td><td><a href="#" onClick=newRecord("new","'.$param.'","'.$dir.'")><img src="../comunes/imagenes/page_add.png" alt="Guardar" title="Nueva Tabla" width="16" height="16" border="0" /></a></td>';
				$textout .= '</tr>';
			}			

//end fields generation

				$arrf='';
				for ( $i = 0 ; $i < count($this->arrFields) ; $i ++ )
				{
					$arrf .= ','.$this->arrFields[$i];
				}

                                $this->Conectar();
				$rs_tabla=new Recordset("select idmaestro, descripcion, alias from ".$this->arrTable.$orden, $this->conn);	

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
						<td><input type="text" size=40" class="textbox" name="descripcion" id="descripcion" value='.$rs_tabla->rowset["descripcion"].'></td>
						<td><input type="text" size="40" class="textbox" name="alias" id="alias" value="'.$rs_tabla->rowset["alias"].'"></td>
						<td><a href="#" onClick=saveRecord("save",'.$rs_tabla->rowset["idmaestro"].',"'.$param.'","'.$dir.'")><img src="../comunes/imagenes/disk.png" alt="Guardar"  width="12" height="12" border="0" /></a> </td>
						
						<td> <a href="#" onClick=getagents("'.$param.'","'.$dir.'")><img src="../comunes/imagenes/cancelar.jpg" alt="Cancelar" width="12" title="Cancelar" height="12" border="0" /></a></td>
						
						</tr>';					  
					}
					else		//mostrar registro normal
					{
					
						$var="?id=".$rs_tabla->rowset["idmaestro"]."&nombre=".$rs_tabla->rowset["descripcion"];
						
						if ($swfondo)
						{
							$textout .= '<tr>';
							$textout .= '<td width="18%" align="center"> <a  target="_self" href="lst_registros.php'.$var.'" >'.$rs_tabla->rowset["idmaestro"].' </a></td>
						<td><a  target="_self" href="lst_registros.php'.$var.'">'.$rs_tabla->rowset["descripcion"].'</a></td>
						<td><a  target="_self" href="lst_registros.php'.$var.'">'.$rs_tabla->rowset["alias"].'</a></td>';	
							$swfondo=false;
						}
						else
						{
							$textout .= '<tr style="background:#CCCCCC;">';
							$textout .= '<td width="18%" align="center"> <a  target="_self" href="lst_registros.php'.$var.'" >'.$rs_tabla->rowset["idmaestro"].' </a></td>
						<td><a  target="_self" href="lst_registros.php'.$var.'" >'.$rs_tabla->rowset["descripcion"].'</a></td>
						<td><a  target="_self" href="lst_registros.php'.$var.'" >'.$rs_tabla->rowset["alias"].'</a></td>';		
							$swfondo=true;
						}//if swfondo
												
						
						$textout .= '<td width="2%"><a href="#" onClick=manipulateRecord("update",'.$rs_tabla->rowset["idmaestro"].',"'.$param.'","'.$dir.'")><img src="../comunes/imagenes/page_edit.png" alt="Editar" title="Editar Registro" width="12" height="12" border="0" /></a> </td>
						<td width="2%"> <a href="#" onClick=manipulateRecord("delete",'.$rs_tabla->rowset["idmaestro"].',"'.$param.'","'.$dir.'")> <img src="../comunes/imagenes/cross.png" alt="Eliminar" title="Eliminar Registro" width="12" height="12" border="0" /></a></td>
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
                    <td><input type="text" size="40" class="textbox" name="alias" id="alias" value=""></td>
                    <td><a href="#" onClick=saveNewRecord("newsave","'.$param.'","'.$dir.'")><img src="../comunes/imagenes/disk.png" alt="Guardar" width="12" height="12" border="0" /></a> </td>
                    <td> <a href="#" onClick=getagents("'.$param.'","'.$dir.'")><img src="../comunes/imagenes/cancelar.jpg" alt="Cancelar" width="12" height="12" border="0" /></a></td>
                    </tr>
                    ';
		}		
		
		echo "<table cellspacing=\"0\" border=\"0\" cellpadding=\"2\" align=\"center\" width=\"100%\">".$textout."</table>";
					
	  }//showList
	
	public function deleteRecord($id='')
	{
                $existe=$this->Count("maestro", "idpadre=".$id);
                if (!$existe>0)
                {
                    $result=$this->Ejecutarsql("delete from maestro where idmaestro = ".$id);
                }
	}	
	
	public function saveEditedRecord()
	{
		$result=$this->Ejecutarsql("update maestro set descripcion = '".$_REQUEST['descripcion']."', alias='".$_REQUEST['alias']."' where idmaestro =".$_REQUEST['codigo']);
		
	}
	
	public function saveNewRecord()
	{
	
		$existe=$this->Count("maestro", "idpadre=0 and upper(descripcion)='".trim(strtoupper($_REQUEST['descripcion']))."'");
		
		if ($existe>0) return false;
		
		$result=$this->Ejecutarsql("insert into maestro (descripcion, alias, estatus) values('".$_REQUEST['descripcion']."','".$_REQUEST['alias']."', 0)");		
	
	}
	
}//class

$obj = new cgrid_maestro();

if ( $_REQUEST['mode'] == "delete" )
{        
	$obj->deleteRecord($_REQUEST['id']);
        $obj->showList();       
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