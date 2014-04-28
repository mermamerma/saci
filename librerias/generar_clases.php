<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>Generador de Clases</title>

<body>
          <form name="form1" action="generar_clases.php" method="post"  >
		      <table width="541" cellpadding="0" cellspacing="0" border="0">
                      <tr>
					   <td width="255">
		  <input type="text" name="tabla" id="tabla" size="54" maxlength="64" value="<? if(isset($_POST["tabla"])){ echo $_POST["tabla"]; } ?>"   />
		  </td>
		  </tr>
		  </table>
		   <div style="padding:5px; text-align:left;">
                       <input name="SUBMIT" type="button" value="Generar" alt="GUARDAR" "/></input>
                       
                    </div>
		  
<?php

                include_once("db_postgresql.inc.php");

		if (isset($tabla))
		{
                    
                                $dat->Conectar();
				$rs_tabla=new Recordset("select * from ".$tabla, $dat->conn);
				$variables="";
				$metodos="";
				$validaciones="";
				$campo_clave="";
				$campos_insertar="";
				$valores_insertar="";
				$valores_actualizar="";	
				$valores_mostrar="";					
				
				$variables.=" private \$error;<br>";
				$variables.=" private \$info;<br>";				
				$variables.=" private \$validar_campos;<br>";
				$variables.=" private \$bnuevo;<br>";
				
			
				$metodos.= "public function get_error(){<br> &nbsp;&nbsp;&nbsp;&nbsp;return \$this->error;<br>}<br> ";
				$metodos.= "public function set_error(\$val_) {<br>&nbsp;&nbsp;&nbsp;&nbsp;\$this->error=\$val_;<br>}<br>";	
				$metodos.= "public function get_info(){<br> &nbsp;&nbsp;&nbsp;&nbsp;return \$this->info;<br>}<br> ";
				$metodos.= "public function set_info(\$val_) {<br>&nbsp;&nbsp;&nbsp;&nbsp;\$this->info=\$val_;<br>}<br>";					
				$metodos.= "public function get_validar_campos(){<br> &nbsp;&nbsp;&nbsp;&nbsp;return \$this->validar_campos;<br>}<br> ";
				$metodos.= "public function set_validar_campos(\$val_) {<br>&nbsp;&nbsp;&nbsp;&nbsp;\$this->validar_campos=\$val_;<br>}<br>";	
				$metodos.= "public function get_bnuevo(){<br> &nbsp;&nbsp;&nbsp;&nbsp;return \$this->bnuevo;<br>}<br> ";
				$metodos.= "public function set_bnuevo(\$val_) {<br>&nbsp;&nbsp;&nbsp;&nbsp;\$this->bnuevo=\$val_;<br>}<br>";	
				
				for ($i=1;$i<=$rs_tabla->fieldcount;$i++) {
				
					$variables.=" private \$".$rs_tabla->fn[$i].";<br>";
					$metodos.= "public function get_".$rs_tabla->fn[$i]."(){<br> &nbsp;&nbsp;&nbsp;&nbsp;return \$this->".$rs_tabla->fn[$i].";<br>}<br> ";
					$metodos.= "public function set_".$rs_tabla->fn[$i]."(\$val_) {<br> &nbsp;&nbsp;&nbsp;&nbsp;\$this->".$rs_tabla->fn[$i]."=\$val_;<br>}<br>";	
					
					if($i=="1")
					{
						$campo_clave=$rs_tabla->fn[$i];
					 	$validaciones="<br> if (validar_vacio(\$this->get_".$rs_tabla->fn[$i]."())) <br>
					    {<br>
						 &nbsp;&nbsp;&nbsp;&nbsp;\$this->set_error(\"Debe Introducir el ".$rs_tabla->fn[$i]."\");
						 <br>
						 &nbsp;&nbsp;&nbsp;&nbsp;\$this->set_validar_campos(false);";
							
						$campos_insertar=$rs_tabla->fn[$i];
						$valores_insertar="'\".\$this->get_".$rs_tabla->fn[$i]."().\"'";		
						$valores_actualizar=$rs_tabla->fn[$i]."='\".\$this->get_".$rs_tabla->fn[$i]."().\"'";
						$valores_mostrar="\$this->set_".$rs_tabla->fn[$i]."(\$rs_".$tabla."->rowset[\"".$rs_tabla->fn[$i]."\"]);<br>";
					}
					else
					{
						$validaciones.="<br>}else  if (validar_vacio(\$this->get_".$rs_tabla->fn[$i]."()))<br>{<br>";
						$validaciones.="&nbsp;&nbsp;&nbsp;&nbsp;\$this->set_error(\"Debe Introducir el ".$rs_tabla->fn[$i]."\");<br>
							&nbsp;&nbsp;&nbsp;&nbsp;\$this->set_validar_campos(false);";
						$campos_insertar.=",".$rs_tabla->fn[$i];
						$valores_insertar.=", '\".\$this->get_".$rs_tabla->fn[$i]."().\"'";
						$valores_actualizar.=", ".$rs_tabla->fn[$i]."='\".\$this->get_".$rs_tabla->fn[$i]."().\"'";
						$valores_mostrar.="\$this->set_".$rs_tabla->fn[$i]."(\$rs_".$tabla."->rowset[\"".$rs_tabla->fn[$i]."\"]);<br>";
					}
							
				}//for
				
				echo  "class c".$tabla." extends Datos { <br><br>
// **********************************************  DECLARACIONES  *********************************************<br><br> ";
				echo $variables."<br><br>";

				echo "// **********************************************  CONSTRUCTOR  ********************************************* <br><br>
	
	function __construct()<br>
	{
		<br>		
		<br>
	}
	<br>
	
	<br><br>
	
	// **********************************************  METODOS  ************************************************** <br><br>";
	echo $metodos."<br><br>";		
			
				
	echo "// **********************************************  INSERTAR  ************************************************ <br><br>
	
	function Insertar() <br>
	{<br><br>
	
		 \$this->set_error(\"\");<br>
		 \$this->set_validar_campos(true);<br>";
	
	
    echo $validaciones."<br>}<br><br>";
	$procedimientos="";
	
	$procedimientos.="if (\$this->get_validar_campos())<br>
	{<br>
		
		&nbsp;&nbsp;&nbsp;&nbsp;\$this->set_bnuevo(true);<br>
		&nbsp;&nbsp;&nbsp;&nbsp;\$sentencia_sql=\"Insert Into ".$tabla." (".$campos_insertar.") Values (".$valores_insertar.")\";<br>
		&nbsp;&nbsp;&nbsp;&nbsp;\$insertado=\$this->Ejecutarsql(\$sentencia_sql);<br>
		
			if(validar_vacio(\$insertado)==false)<br>
			{<br>
				&nbsp;&nbsp;&nbsp;&nbsp;\$ult_registro=\$this->getMax('".$tabla."','".$campo_clave."','');		<br>					 
				&nbsp;&nbsp;&nbsp;&nbsp;\$this->set_".$campo_clave."(\$ult_registro);<br>
				&nbsp;&nbsp;&nbsp;&nbsp;return \$ult_registro;<br>
			}<br>
			else<br>
			{<br>			
				&nbsp;&nbsp;&nbsp;&nbsp;\$this->set_error(\"Han Ocurrido Errores al Intentar Insertar el ".$tabla." \");<br>		
				&nbsp;&nbsp;&nbsp;&nbsp;\$this->set_validar_campos(false);<br>
				&nbsp;&nbsp;&nbsp;&nbsp;\$this->registrar_error(\$sentencia_sql, '".$tabla."', \$this->get_idusuario());<br>
				&nbsp;&nbsp;&nbsp;&nbsp;return (\"0\");<br>
			}	<br>	
	}//validar_campos<br>
	else<br>
	{<br>
		&nbsp;&nbsp;&nbsp;&nbsp;return \"0\";<br>											
	}//if get_validar_campos<br><br>";						
				
	echo $procedimientos."<br><br>}//Insertar()<br><br>";
	$procedimientos="";

	echo "// **********************************************  UPDATE  ************************************************ <br><br>
	
	function Update() <br>
	{<br><br>
	
		 \$this->set_error(\"\");<br>
		 \$this->set_validar_campos(true);<br>";
	
	
    echo $validaciones."<br>}<br><br>";
	$procedimientos="";
	
	$procedimientos.="if (\$this->get_validar_campos())<br>
	{<br>
	
			&nbsp;&nbsp;&nbsp;&nbsp;\$this->set_bnuevo(false);<br>
			&nbsp;&nbsp;&nbsp;&nbsp;\$sentencia_sql=\"update ".$tabla." set ".$valores_actualizar."  where ".$campo_clave." = '\".\$this->get_".$campo_clave."().\"' \";<br>
			&nbsp;&nbsp;&nbsp;&nbsp;\$actualizado=\$this->Ejecutarsql(\$sentencia_sql);<br>
			if(validar_vacio(\$actualizado)==false)<br>
			{<br>
				&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;return \$this->get_".$campo_clave."();<br>
			}<br>
			else<br>
			{<br>			
				&nbsp;&nbsp;&nbsp;&nbsp;\$this->set_error(\"Han Ocurrido Errores al Intentar Actualizar el ".$tabla." \");<br>		
				&nbsp;&nbsp;&nbsp;&nbsp;\$this->set_validar_campos(false);<br>
				&nbsp;&nbsp;&nbsp;&nbsp;\$this->registrar_error(\$sentencia_sql, '".$tabla."', \$this->get_idusuario());<br>
				&nbsp;&nbsp;&nbsp;&nbsp;return (\"0\");<br>
			}	<br>	
	}//validar_campos<br>
	else<br>
	{<br>
		&nbsp;&nbsp;&nbsp;&nbsp;return \"0\";<br>											
	}//if get_validar_campos<br><br>";						
				
	echo $procedimientos."<br><br>}//Update()<br><br>";
	$procedimientos="";	

echo "// **********************************************  ELIMINAR  ************************************************ <br><br>
	
	function Eliminar() <br>
	{<br><br>
	
		 \$this->set_error(\"\");<br>
		 \$this->set_validar_campos(true);<br><br><br>}//Eliminar<br><br>";
	
	$procedimientos="";	

echo "// **********************************************  GETDATA  ************************************************ <br><br>
	
	function getData() <br>
	{<br><br>
	
		 \$this->set_bdatos(false);<br>";
	
	$procedimientos="if (!validar_vacio(\$this->get_".$campo_clave."()))<br>
		{<br><br>
	
			\$rs_".$tabla."=\$this->getRecordset(\"select *  from ".$tabla." where ".$campo_clave."=\".\$this->get_".$campo_clave."(), \$this->conn);<br>	
	
			if(\$rs_".$tabla.")<br>
			{<br>	
				&nbsp;&nbsp;&nbsp;&nbsp;\$this->set_bdatos(true);<br>	
				&nbsp;&nbsp;&nbsp;&nbsp;".$valores_mostrar."<br>				
			}//Mostrar<br>
		}<br>";	
	
	echo $procedimientos."<br><br>}//getData()<br><br>";
	
	
	echo "}//clases ".$tabla."<br><br>";

}
	
?>

</form>
</body>
</html>
