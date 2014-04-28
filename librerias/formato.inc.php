<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
</head>

<?


function rpt_texto($texto, $maximo)
{
	
	$longitud=strlen($texto);
	
	if($longitud>$maximo)
	{
		$texto_cambiar=substr($texto, 0, $maximo);
	}
	else
	{
		$texto_cambiar=str_pad($texto, $maximo, " ");
	}
	
	return $texto_cambiar;
	
}

function elim_comillas($var)//caracter '
{
	$caracter = array('"');
	$caracter_cambiar   = array('\"');
	
	$cad = str_replace($caracter, $caracter_cambiar, $var);
	
	$caracter = array("'");
	$caracter_cambiar   = array("\'");
	
	$cad2 = str_replace($caracter, $caracter_cambiar, $cad);
	return $cad2;
}

function duplicar_comillas($var)
{
	$caracter = array("'");
	$caracter_cambiar   = array("''");
	
	$cad = str_replace($caracter, $caracter_cambiar, $var);	
	return $cad;
}

function restar($valor1, $valor2)
{

    try
    {
            if ($valor1=="") $valor1=0;
            if ($valor2=="") $valor2=0;

            $resta=bcsub($valor1,$valor2,2);
            return $resta;

    }
    catch(exception $e)
    {
            return 0;
    }

}//restar

function sumar($valor1, $valor2)
{

    try
    {
            if ($valor1=="") $valor1=0;
            if ($valor2=="") $valor2=0;

            $suma=bcadd($valor1,$valor2,2);
            return $suma;
    }
    catch(exception $e)
    {
            return 0;
    }

}//sumar

function dividir($valor1, $valor2)
{

    try
    {
            if ($valor2>0)
            {
                    $dividir=bcdiv($valor1,$valor2,4);
            }
            else
            {
                    $dividir=0;
            }
            return $dividir;
    }
    catch(exception $e)
    {
            return 0;
    }

}


function multiplicar($valor1, $valor2)
{

    try
    {
            $multiplicar=bcmul($valor1,$valor2,4);
            return $multiplicar;
    }
    catch(exception $e)
    {
            return 0;
    }

}


function obtener_interes($monto, $tasa, $plazo)
{
    try
    {
              $porcen=bcdiv($tasa,100,20);
              $div_det=bcdiv($plazo,360,20);
              $multi_detalle=bcmul($porcen, $div_det,20);
              $monto_interes=bcmul($multi_detalle, $monto,3);

              return round($monto_interes,2);
    }
    catch(exception $e)
    {
            return 0;
    }
}//obtener_interes
	
function validar_vacio($valor)
{
    try
    {
            if (isset($valor))
            {
                if ($valor=='')
                {
                        return true;
                }
                else
                {
                        return false;
                }
            }
            else
            {
                 return false;
            }
    }
    catch(exception $e)
    {
            return false;
    }
}//validar_vacio

function to_moneda($string)
{

    $Negative = 0;

    if(preg_match("/^\-/",$string))
    {
        $Negative = 1;
        $string = preg_replace("|\-|","",$string);
    }

    $string = preg_replace("|\,|","",$string);	

    $Full = @split("[\.]",$string);
	
    $Count = count($Full);

    if($Count > 1)
    {
        $First = $Full[0];
        $Second = $Full[1];
        $NumCents = strlen($Second);

        if($NumCents == 2)
        {

        }
        else if($NumCents < 2)
        {
            $Second = $Second . "0";
        }
        else if($NumCents > 2)
        {
            $Temp = substr($Second,0,3);
            $Second = substr($Temp,0,2);
        }
    }
    else
    {
        $First = $Full[0];
        $Second = "00";
    }

    $length = strlen($First);

    if( $length <= 3 )
    {
        $string = $First . "," . $Second;

        if($Negative == 1)
        {
            $string = "-" . $string;
        }

        return $string;
    }
    else
    {
        $loop_count = intval( ( $length / 3 ) );
        $section_length = -3;

        for( $i = 0; $i < $loop_count; $i++ )
        {
            $sections[$i] = substr( $First, $section_length, 3 );
            $section_length = $section_length - 3;
        }

        $stub = ( $length % 3 );
        if( $stub != 0 )
        {
            $sections[$i] = substr( $First, 0, $stub );
        }

        $Done = implode( ".", array_reverse( $sections ) );
        $Done = $Done . "," . $Second;

        // if negative flag is set, add negative to number
        if($Negative == 1)
        {
            $Done = "-" . $Done;
        }

        return $Done;

    }
}
/***********************************************************************/

function to_moneda_bd($string)
{

    $Negative = 0;

    if(preg_match("/^\-/",$string))
    {
        $Negative = 1;
        $string = preg_replace("|\-|","",$string);
    }

    $string = preg_replace("|\.|","",$string);
    $Full = @split("[\,]",$string);

    $Count = count($Full);

    if($Count > 1)
    {
        $First = $Full[0];
        $Second = $Full[1];
        $NumCents = strlen($Second);
        if($NumCents == 2)
        {

        }
        else if($NumCents < 2)
        {
            $Second = $Second . "0";
        }
    }
    else if(@$NumCents > 2)
    {
        $Temp = substr($Second,0,3);
        $Second = substr($Temp,0,2);
    }else
    {
        $First = $Full[0];
        $Second = "00";
    }

    $length = strlen($First);

    if( $length <= 3 )
    {
        $string = $First . "." . $Second;

    // if negative flag is set, add negative to number
        if($Negative == 1)
        {
            $string = "-" . $string;
        }

        return $string;
    }
    else
    {
        $loop_count = intval( ( $length / 3 ) );
        $section_length = -3;
        for( $i = 0; $i < $loop_count; $i++ )
        {
            $sections[$i] = substr( $First, $section_length, 3 );
            $section_length = $section_length - 3;
        }

        $stub = ( $length % 3 );
        if( $stub != 0 )
        {
            $sections[$i] = substr( $First, 0, $stub );
        }

        $Done = implode( "", array_reverse( $sections ) );
        $Done = $Done . "." . $Second;

        if($Negative == 1)
        {
            $Done = "-" . $Done;
        }

        return $Done;

    }
}

/***********************************************************************/
function moneda($moneda)
{
    $valor='';
    $a=1;
    $i=0;
    $str_valor=$moneda;
    while ($a<>0)
    {
        if (isset($str_valor[$i]))
        {
            if ($str_valor[$i]<>'$')
            {
                $valor.=$str_valor[$i];
            }
            $i=$i+1;
        }
        else
        {
            $a=0;
        }
    }
    $moneda=$valor;
    return ($moneda);
}


function punto($moneda)
{
    $valor='';
    $a=1;
    $i=0;
    $str_valor=$moneda;
    while ($a<>0)
    {
        if (isset($str_valor[$i]))
        {
            if ($str_valor[$i]<>'.')
            {
                $valor.=$str_valor[$i];
            }
            $i=$i+1;
        }
        else
        {
            $a=0;
        }
    }
    
    $moneda=$valor;
    return ($moneda);

}


function to_fecha_bd($fec)// dd/mm/yyyy to yyyy/mm/dd
{

    if (validar_vacio($fec)) return '';
    else if ($fec=='NULL') return 'NULL';

    $day='';
    $mes='';
    $ano='';

    for ($i=0;$i<10;$i++)
    {
        if ($i<2)
        {
            $day.=$fec[$i];
        }

        if (($i>2) and ($i<5))
        {
            $mes.=$fec[$i];
        }

        if (($i>5) and ($i<10))
        {
            $ano.=$fec[$i];
        }
    }

    $fecha=$ano.'-'.$mes.'-'.$day;
    return ($fecha);

}

function fecha($fec)// yyyy/mm/dd to dd/mm/yyyy
{

    if ($fec!="")
    {
        
        $day='';
        $mes='';
        $ano='';

        for ($i=0;$i<10;$i++)
        {
            if ($i<4)
            {
                $ano.=$fec[$i];
            }

            if (($i>4) and ($i<7))
            {
                $mes.=$fec[$i];
            }

            if (($i>7) and ($i<10))
            {
                $day.=$fec[$i];
            }
        }

        $fecha=$day.'/'.$mes.'/'.$ano;
        return ($fecha);

    }

    

}

function fecha_hora($fec)// yyyy/mm/dd to dd/mm/yyyy hh:mm:ss
{

    $day='';
    $mes='';
    $ano='';
    $hora='';
    $fecha_hora='';
    $minutos='';

    //2007-11-08 11:34:56.745884

    for ($i=0;$i<17;$i++)
    {
        if ($i<4)
        {
            $ano.=$fec[$i];
        }

        if (($i>4) and ($i<7))
        {
            $mes.=$fec[$i];
        }

        if (($i>7) and ($i<10))
        {
            $day.=$fec[$i];
        }

        if (($i>10) and ($i<13))
        {
            $hora.=$fec[$i];
        }

        if (($i>13) and ($i<16))
        {
            $minutos.=$fec[$i];
        }

    }

    if ($hora>12)
    {
        $hora=intval(restar($hora, 12));
        if (strlen($hora)==1) $hora="0".$hora;
        $am_pm='PM';
    }
    else
    {
        $am_pm='AM';
    }

    $fecha_hora=$day.'/'.$mes.'/'.$ano.' '.$hora.':'.$minutos.' '.$am_pm;
    return ($fecha_hora);
	
}//fecha_hora



function gettime()//fecha_actual
{
    $ano=strftime("%Y");
    $mes=strftime("%m");
    $dia=strftime("%d");
    $fe=$ano.'-'.$mes.'-'.$dia;

    return($fe);
}

function fechaactual()
{
    $ano=strftime("%Y");
    $mes=strftime("%m");
    $dia=strftime("%d");

    $fe=$dia.'/'.$mes.'/'.$ano;
    return($fe);
}

function to_moneda_Txt($moneda)
{	
    if (isset($moneda))
    {
            $valor=moneda(to_moneda_bd(to_moneda($moneda)));
    }
    else
    {
            $valor="0.00";
    }

    return $valor;
    
}//moneda


function to_moneda_sp($string)
{

    $Negative = 0;
    if(preg_match("/^\-/",$string))
    {
        $Negative = 1;
        $string = preg_replace("|\-|","",$string);
    }

    $string = preg_replace("|\,|","",$string);
    $Full = split("[\.]",$string);

    $Count = count($Full);

    if($Count > 1)
    {
        $First = $Full[0];
        $Second = $Full[1];
        $NumCents = strlen($Second);

        if($NumCents == 2)
        {

        }
        else if($NumCents < 2)
        {
            $Second = $Second . "0";
        }
        else if($NumCents > 2)
        {
            $Temp = substr($Second,0,3);
            $Second = substr($Temp,0,2);
        }
    }
    else
    {
        $First = $Full[0];
        $Second = "00";
    }

    $length = strlen($First);

    if( $length <= 3 )
    {
        $string = $First . "," . $Second;

        if($Negative == 1)
        {
            $string = "-" . $string;
        }

        return $string;
    }
    else
    {
        $loop_count = intval( ( $length / 3 ) );
        $section_length = -3;

        for( $i = 0; $i < $loop_count; $i++ )
        {
        $sections[$i] = substr( $First, $section_length, 3 );
        $section_length = $section_length - 3;
        }

        $stub = ( $length % 3 );
        if( $stub != 0 )
        {
            $sections[$i] = substr( $First, 0, $stub );
        }

        $Done = implode( "", array_reverse( $sections ) );
        $Done = $Done . "," . $Second;

        if($Negative == 1)
        {
            $Done = "-" . $Done;
        }

        return $Done;

    }
}

function getMes($nMes)
{
	switch($nMes)       
	{
		case "01":
			return "Enero";
			break;
			
		case "02":
			return "Febrero";
			break;	
			
		case "03":
			return "Marzo";
			break;
			
		case "04":
			return "Abril";
			break;
			
		case "05":
			return "Mayo";
			break;
			
		case "06":
			return "Junio";
			break;
			
		case "07":
			return "Julio";
			break;
			
		case "08":
			return "Agosto";
			break;
			
		case "09":
			return "Septiembre";
			break;
			
		case "10":
			return "Octubre";
			break;
			
		case "11":
			return "Noviembre";
			break;
			
		case "12":
			return "Diciembre";
			break;
			
		default: 
			echo("Mes No Válido");
			return "Mes No Válido";
			break;
			
	}//switch
	
}//getMes




function numero_en_letras($num, $fem = true, $dec = true) { 

   $matuni[2]  = "dos"; 
   $matuni[3]  = "tres"; 
   $matuni[4]  = "cuatro"; 
   $matuni[5]  = "cinco"; 
   $matuni[6]  = "seis"; 
   $matuni[7]  = "siete"; 
   $matuni[8]  = "ocho"; 
   $matuni[9]  = "nueve"; 
   $matuni[10] = "diez"; 
   $matuni[11] = "once"; 
   $matuni[12] = "doce"; 
   $matuni[13] = "trece"; 
   $matuni[14] = "catorce"; 
   $matuni[15] = "quince"; 
   $matuni[16] = "dieciseis"; 
   $matuni[17] = "diecisiete"; 
   $matuni[18] = "dieciocho"; 
   $matuni[19] = "diecinueve"; 
   $matuni[20] = "veinte"; 
   $matunisub[2] = "dos"; 
   $matunisub[3] = "tres"; 
   $matunisub[4] = "cuatro"; 
   $matunisub[5] = "quin"; 
   $matunisub[6] = "seis"; 
   $matunisub[7] = "sete"; 
   $matunisub[8] = "ocho"; 
   $matunisub[9] = "nove"; 

   $matdec[2] = "veint"; 
   $matdec[3] = "treinta"; 
   $matdec[4] = "cuarenta"; 
   $matdec[5] = "cincuenta"; 
   $matdec[6] = "sesenta"; 
   $matdec[7] = "setenta"; 
   $matdec[8] = "ochenta"; 
   $matdec[9] = "noventa"; 
   $matsub[3]  = 'mill'; 
   $matsub[5]  = 'bill'; 
   $matsub[7]  = 'mill'; 
   $matsub[9]  = 'trill'; 
   $matsub[11] = 'mill'; 
   $matsub[13] = 'bill'; 
   $matsub[15] = 'mill'; 
   $matmil[4]  = 'millones'; 
   $matmil[6]  = 'billones'; 
   $matmil[7]  = 'de billones'; 
   $matmil[8]  = 'millones de billones'; 
   $matmil[10] = 'trillones'; 
   $matmil[11] = 'de trillones'; 
   $matmil[12] = 'millones de trillones'; 
   $matmil[13] = 'de trillones'; 
   $matmil[14] = 'billones de trillones'; 
   $matmil[15] = 'de billones de trillones'; 
   $matmil[16] = 'millones de billones de trillones'; 

   $num = trim((string)@$num); 
   if ($num[0] == '-') { 
      $neg = 'menos '; 
      $num = substr($num, 1); 
   }else 
      $neg = ''; 
   while ($num[0] == '0') $num = substr($num, 1); 
   if ($num[0] < '1' or $num[0] > 9) $num = '0' . $num; 
   $zeros = true; 
   $punt = false; 
   $ent = ''; 
   $fra = ''; 
   for ($c = 0; $c < strlen($num); $c++) { 
      $n = $num[$c]; 
      if (! (strpos(".,'''", $n) === false)) { 
         if ($punt) break; 
         else{ 
            $punt = true; 
            continue; 
         } 

      }elseif (! (strpos('0123456789', $n) === false)) { 
         if ($punt) { 
            if ($n != '0') $zeros = false; 
            $fra .= $n; 
         }else 

            $ent .= $n; 
      }else 

         break; 

   } 
   $ent = '     ' . $ent; 
   if ($dec and $fra and ! $zeros) { 
      $fin = ' coma'; 
      for ($n = 0; $n < strlen($fra); $n++) { 
         if (($s = $fra[$n]) == '0') 
            $fin .= ' cero'; 
         elseif ($s == '1') 
            $fin .= $fem ? ' una' : ' un'; 
         else 
            $fin .= ' ' . $matuni[$s]; 
      } 
   }else 
      $fin = ''; 
   if ((int)$ent === 0) return 'Cero ' . $fin; 
   $tex = ''; 
   $sub = 0; 
   $mils = 0; 
   $neutro = false; 
   while ( ($num = substr($ent, -3)) != '   ') { 
      $ent = substr($ent, 0, -3); 
      if (++$sub < 3 and $fem) { 
         $matuni[1] = 'una'; 
         $subcent = 'as'; 
      }else{ 
         $matuni[1] = $neutro ? 'un' : 'uno'; 
         $subcent = 'os'; 
      } 
      $t = ''; 
      $n2 = substr($num, 1); 
      if ($n2 == '00') { 
      }elseif ($n2 < 21) 
         $t = ' ' . $matuni[(int)$n2]; 
      elseif ($n2 < 30) { 
         $n3 = $num[2]; 
         if ($n3 != 0) $t = 'i' . $matuni[$n3]; 
         $n2 = $num[1]; 
         $t = ' ' . $matdec[$n2] . $t; 
      }else{ 
         $n3 = $num[2]; 
         if ($n3 != 0) $t = ' y ' . $matuni[$n3]; 
         $n2 = $num[1]; 
         $t = ' ' . $matdec[$n2] . $t; 
      } 
      $n = $num[0]; 
      if ($n == 1) { 
         $t = ' ciento' . $t; 
      }elseif ($n == 5){ 
         $t = ' ' . $matunisub[$n] . 'ient' . $subcent . $t; 
      }elseif ($n != 0){ 
         $t = ' ' . $matunisub[$n] . 'cient' . $subcent . $t; 
      } 
      if ($sub == 1) { 
      }elseif (! isset($matsub[$sub])) { 
         if ($num == 1) { 
            $t = ' mil'; 
         }elseif ($num > 1){ 
            $t .= ' mil'; 
         } 
      }elseif ($num == 1) { 
         $t .= ' ' . $matsub[$sub] . '?n'; 
      }elseif ($num > 1){ 
         $t .= ' ' . $matsub[$sub] . 'ones'; 
      }   
      if ($num == '000') $mils ++; 
      elseif ($mils != 0) { 
         if (isset($matmil[$sub])) $t .= ' ' . $matmil[$sub]; 
         $mils = 0; 
      } 
      $neutro = true; 
      $tex = $t . $tex; 
   } 
   $tex = $neg . substr($tex, 1) . $fin; 
   return ucfirst($tex); 
   
} //numero_en_letras



/***********************************************************************/

function mensaje($mensaje)
{
echo"<script languaje=\"javascript\">
alert('".$mensaje."')
</script>";
}

function mensaje_pregunta($mensaje)
{
echo"
<script languaje=\"javascript\">
var resp

resp=confirm('".$mensaje."');

</script>";

				
}



function javascript($javascript)
{
echo"<script languaje=\"javascript\">
".$javascript."
</script>";
}

function open_pag($javascript,$target)
{
echo"<script languaje=\"javascript\">
window.open('".$javascript."','".$target."');
</script>";
}

function redirect($url,$target){
   	echo "<script>window.open('".$url."','".$target."');</script>";
} 

function comparar_fechas($fecha1,$fecha2)		
{            
	  //formatos dd-mm-yyyy  � dd/mm/yyyy � yyyy/mm/dd � yyyy-mm-dd fecha1>fecha2 return positivo  fecha1<fecha2 return negativo fecha1=fecha2 return null
	  
      if (preg_match("/[0-9]{1,2}\/[0-9]{1,2}\/([0-9][0-9]){1,2}/",$fecha1)) list($dia1,$mes1,$ano1)=split("/",$fecha1);
	  if (preg_match("/([0-9][0-9]){1,2}\/[0-9]{1,2}\/[0-9]{1,2}/",$fecha1))   list($ano1,$mes1, $dia1)=split("/",$fecha1);
	  
	  if (preg_match("/[0-9]{1,2}-[0-9]{1,2}-([0-9][0-9]){1,2}/",$fecha1))   list($dia1,$mes1,$ano1)=split("-",$fecha1);
	  if (preg_match("/([0-9][0-9]){1,2}-[0-9]{1,2}-[0-9]{1,2}/",$fecha1))   list($ano1,$mes1,$dia1)=split("-",$fecha1);
	  
	  
      if (preg_match("/[0-9]{1,2}\/[0-9]{1,2}\/([0-9][0-9]){1,2}/",$fecha2)) list($dia2,$mes2,$ano2)=split("/",$fecha2);
	  if (preg_match("/([0-9][0-9]){1,2}\/[0-9]{1,2}\/[0-9]{1,2}/",$fecha2))   list($ano2,$mes2,$dia2)=split("/",$fecha2);
	  
      if (preg_match("/[0-9]{1,2}-[0-9]{1,2}-([0-9][0-9]){1,2}/",$fecha2)) list($dia2,$mes2,$ano2)=split("-",$fecha2);
	  if (preg_match("/([0-9][0-9]){1,2}-[0-9]{1,2}-[0-9]{1,2}/",$fecha2))   list($ano2,$mes2,$dia2)=split("-",$fecha2);
	   
	  
	  $dif = mktime(0,0,0,$mes1,$dia1,$ano1) - mktime(0,0,0,$mes2,$dia2,$ano2);

	  return ($dif);  

}//compara_fechas

function diferencia_dias($fecha1,$fecha2)		
{            
	  //formatos dd-mm-yyyy  n dd/mm/yyyy n yyyy/mm/dd n yyyy-mm-dd fecha1>fecha2 return positivo  fecha1<fecha2 return negativo fecha1=fecha2 return null
	  
	  $a=split("/",$fecha1);
	  $dia1=$a[0];
	  $mes1=$a[1];
	  $ano1=$a[2];
	  $a=split("/",$fecha2);
	  $dia2=$a[0];
	  $mes2=$a[1];
	  $ano2=$a[2];
	  
	  
	  
      /*if (preg_match("/[0-9]{1,2}\/[0-9]{1,2}\/([0-9][0-9]){1,2}/",$fecha1)) list($dia1,$mes1,$ano1)=split("/",$fecha1);
	  if (preg_match("/([0-9][0-9]){1,2}\/[0-9]{1,2}\/[0-9]{1,2}/",$fecha1))   list($ano1,$mes1, $dia1)=split("/",$fecha1);
	  
	  if (preg_match("/[0-9]{1,2}-[0-9]{1,2}-([0-9][0-9]){1,2}/",$fecha1))   list($dia1,$mes1,$ano1)=split("-",$fecha1);
	  if (preg_match("/([0-9][0-9]){1,2}-[0-9]{1,2}-[0-9]{1,2}/",$fecha1))   list($ano1,$mes1,$dia1)=split("-",$fecha1);
	  
	  
      if (preg_match("/[0-9]{1,2}\/[0-9]{1,2}\/([0-9][0-9]){1,2}/",$fecha2)) list($dia2,$mes2,$ano2)=split("/",$fecha2);
	  if (preg_match("/([0-9][0-9]){1,2}\/[0-9]{1,2}\/[0-9]{1,2}/",$fecha2))   list($ano2,$mes2,$dia2)=split("/",$fecha2);
	  
      if (preg_match("/[0-9]{1,2}-[0-9]{1,2}-([0-9][0-9]){1,2}/",$fecha2)) list($dia2,$mes2,$ano2)=split("-",$fecha2);
	  if (preg_match("/([0-9][0-9]){1,2}-[0-9]{1,2}-[0-9]{1,2}/",$fecha2))   list($ano2,$mes2,$dia2)=split("-",$fecha2);  */
	   
	  
	$timestamp1 = mktime(0,0,0,$mes1,$dia1,$ano1);
	$timestamp2 = mktime(0,0,0,$mes2,$dia2,$ano2);

	//resto a una fecha la otra
	$segundos_diferencia = $timestamp1 - $timestamp2;
	//echo $segundos_diferencia;
	
	//convierto segundos en dnas
	$dias_diferencia = $segundos_diferencia / (60 * 60 * 24);
	
	//obtengo el valor absoulto de los d�as (quito el posible signo negativo)
	$dias_diferencia = abs($dias_diferencia);
	
	//quito los decimales a los d�as de diferencia
	$dias_diferencia = floor($dias_diferencia);	

	  return ($dias_diferencia);  

}//compara_fechas



function isfecha($fecha1)		
{            
	  //formatos dd-mm-yyyy  � dd/mm/yyyy  
		
      if (preg_match("/[0-9]{1,2}\/[0-9]{1,2}\/([0-9][0-9]){1,2}/",$fecha1)) return true;
	  elseif (preg_match("/[0-9]{1,2}-[0-9]{1,2}-([0-9][0-9]){1,2}/",$fecha1))   return true;
      else return false; 

}//idfecha


function validar_id_vacio($valor)
{
    
	if (isset($valor))
	{		
		if(is_numeric($valor) && ($valor>0))
		{
			return false;
		}
		else
		{
			return true;
		}
	}
	else
	{
		return true;
	}
	
}//validar_vacio



function comprobar_email($email){
    $mail_correcto = 0;
    //compruebo unas cosas primeras
    if ((strlen($email) >= 6) && (substr_count($email,"@") == 1) && (substr($email,0,1) != "@") && (substr($email,strlen($email)-1,1) != "@")){
       if ((!strstr($email,"'")) && (!strstr($email,"\"")) && (!strstr($email,"\\")) && (!strstr($email,"\$")) && (!strstr($email," "))) {
          //miro si tiene caracter .
          if (substr_count($email,".")>= 1){
             //obtengo la terminacion del dominio
             $term_dom = substr(strrchr ($email, '.'),1);
             //compruebo que la terminaci�n del dominio sea correcta
             if (strlen($term_dom)>1 && strlen($term_dom)<5 && (!strstr($term_dom,"@")) ){
                //compruebo que lo de antes del dominio sea correcto
                $antes_dom = substr($email,0,strlen($email) - strlen($term_dom) - 1);
                $caracter_ult = substr($antes_dom,strlen($antes_dom)-1,1);
                if ($caracter_ult != "@" && $caracter_ult != "."){
                   $mail_correcto = 1;
                }
             }
          }
       }
    }
    if ($mail_correcto)
       return 1;
    else
       return 0;
} //comprobar_email

function lineas_reportes($texto, $max_letras, $max_lineas)
{
    $nlongitud=strlen($texto);
    if($nlongitud>$max_letras)
    {
        $nlineas=dividir($nlongitud, $max_letras);
        $ind=1;
        $slinea="";
        $inicio=0;

        while ($ind<=$max_lineas && $ind<$nlineas)
        {
            $slinea="";
            if ($ind>1) $parrafo.=" \n";
            $slinea = substr($texto, $inicio, $max_letras);
            $datos[$ind]['parrafo']=$slinea;
            $inicio=sumar($inicio, $max_letras);
            $ind++;
        }//while
        $ind--;
        $adicional=($ind*$max_letras);
        $adicional2=restar($nlongitud, $adicional);
        $ind++;
        if ($adicional2>0) $datos[$ind][parrafo]=substr($texto, $inicio, $adicional2);
        return $datos;

    }
    
}//lineas_reportes

function lineas_reportes_relleno($texto, $max_letras, $max_lineas)
{
    $nlongitud=strlen($texto);
    
    echo "longitud=".$nlongitud.'->max_letras='.$max_letras.'->max_lineas'.$max_lineas.'<br>';
    $inicio=0;


    if($nlongitud>$max_letras)
    {
        $nlineas=dividir($nlongitud, $max_letras);
        echo "lineas->".$nlineas;
        $ind=1;
        $slinea="";
        

        while ($ind<=$max_lineas && $ind<$nlineas)
        {
            $slinea="";
            if ($ind>1) $parrafo.=" \n";
            $slinea = substr($texto, $inicio, $max_letras);
            $slinea=str_pad($slinea, $max_letras, "_", STR_PAD_RIGHT);
            $datos[$ind]['parrafo']=$slinea;
            $inicio=sumar($inicio, $max_letras);
            $ind++;
        }//while
        
        $ind--;
        $adicional=($ind*$max_letras);
        $adicional2=restar($nlongitud, $adicional);
        $ind++;

        if ($adicional2>0)
        {
            $slinea=substr($texto, $inicio, $adicional2);
            $slinea=str_pad($slinea, $max_letras, "_", STR_PAD_RIGHT);
            $datos[$ind][parrafo]=$slinea;
        }

        if ($nlineas<$max_lineas)
        {
            while ($ind<=$max_lineas)
            {                
                $ind++;
                $slinea=str_pad("", $max_letras, "_", STR_PAD_BOTH);
                $datos[$ind][parrafo]=$slinea;
            }           
        }
        

    }
    else
    {
        
        $slinea = $texto;
        $slinea=str_pad($slinea, $max_letras, "_", STR_PAD_RIGHT);
        $datos[$ind]['parrafo']=$slinea;
        $nlineas=1;
        $ind=1;
        
        if ($nlineas<$max_lineas)
        {
            while ($ind<=$max_lineas)
            {
                $ind++;
                $slinea=str_pad("", $max_letras, "_", STR_PAD_BOTH);
                $datos[$ind][parrafo]=$slinea;
            }
        }

    }

    return $datos;

}//lineas_reportes_relleno

function uploadpic($file,$thumb_file,$field,$thumb_width=100)
      {

          $result=false;

          if(is_uploaded_file($_FILES[$field]['tmp_name']))

          {

              move_uploaded_file($_FILES[$field]['tmp_name'],$file);

              thumbnail($file,$thumb_file,$thumb_width);

              $result=true;

          }

          return $result;

      }//uploadpic



      function resize($orig_file,$thumb_file,$prop)
      {

          $img = $orig_file;

          $constrain = true;

          $w = $prop;

          $h = $prop;

          // get image size of img

          $x = @getimagesize($img);

          // image width

          $sw = $x[0];

          // image height

          $sh = $x[1];

              if ($percent > 0)
              {

              // calculate resized height and width if percent is defined

              $percent = $percent * 0.01;

              $w = $sw * $percent;

              $h = $sh * $percent;

              } else
              {

                  if (isset ($w) AND !isset ($h))
                  {

                  // autocompute height if only width is set

                  $h = (100 / ($sw / $w)) * .01;

                  $h = @round ($sh * $h);

                  } elseif (isset ($h) AND !isset ($w))
                  {

                  // autocompute width if only height is set

                  $w = (100 / ($sh / $h)) * .01;

                  $w = @round ($sw * $w);

                  }
                  elseif (isset ($h) AND isset ($w) AND isset ($constrain))
                  {


                  // get the smaller resulting image dimension if both height

                  // and width are set and $constrain is also set

                  $hx = (100 / ($sw / $w)) * .01;

                  $hx = @round ($sh * $hx);

                  $wx = (100 / ($sh / $h)) * .01;

                  $wx = @round ($sw * $wx);

                      if ($hx < $h)
                      {

                          $h = (100 / ($sw / $w)) * .01;

                          $h = @round ($sh * $h);

                      } else
                      {

                          $w = (100 / ($sh / $h)) * .01;

                          $w = @round ($sw * $w);

                      }

                  }

            }

          $im = @ImageCreateFromJPEG ($img) or // Read JPEG Image

          $im = @ImageCreateFromPNG ($img) or // or PNG Image

          $im = @ImageCreateFromGIF ($img) or // or GIF Image

          $im = false; // If image is not JPEG, PNG, or GIF

          if (!$im)
          {
                readfile ($img);
          }
          else
          {

              // Create the resized image destination

              $thumb = @ImageCreateTrueColor ($w, $h);

              // Copy from image source, resize it, and paste to image destination

              @ImageCopyResampled ($thumb, $im, 0, 0, 0, 0, $w, $h, $sw, $sh);

              // Output resized image

              @ImageJPEG ($thumb,$thumb_file);

          }

      }//resize

    function generarTree($id, $tipo, $titulo, $funcion, $ultimo, $ultimoPadre= false)
    {
        $retorno= "";
        $numero= uniqid();
        if($tipo == 'solo'){
            $retorno= "<div class='dTreeNode'>";
            if($ultimo){
                $retorno.= "<img src='../imagenes/joinbottom.gif' alt=''>";
            }else{
                $retorno.= "<img src='../imagenes/join.gif' alt=''>";
            }
            $retorno.= "<img id='is".$id.$numero."' src='../imagenes/page.gif' alt=''>
                        <a id='as".$id.$numero."' class='node' href=\"".$funcion."\">
                            ".$titulo."
                        </a>
                    </div>";
        }else if($tipo == 'padre'){
            $retorno= "<div class='dTreeNode'>
                        <a href=\"javascript:ver('".$id.$numero."', 'dd".$id.$numero."');\">";
            if($ultimo){
                $retorno.= "<img id='il".$id.$numero."' src='../imagenes/plusbottom.gif' alt=''>";
            }else{
                $retorno.= "<img id='il".$id.$numero."' src='../imagenes/plus.gif' alt=''>";
            }
            $retorno.= "</a>
                        <img id='ib".$id.$numero."' src='../imagenes/book.png' alt=''>
                        <a href=\"javascript:ver('".$id.$numero."', 'dd".$id.$numero."');\" class='node' onclick=\"".$funcion."\">
                            ".$titulo."
                        </a>
                    </div>
                    <div id='dd".$id.$numero."' class='clip'style='display: none;'>";
        }else if($tipo == 'hijo'){
            $retorno= " <div class='dTreeNode'>";
            if($ultimoPadre){
                $retorno.= "<img src='../imagenes/empty.gif' alt=''>";
            }else{
                $retorno.= "<img src='../imagenes/line.gif' alt=''>";
            }
            if($ultimo){
                $retorno.= "<img src='../imagenes/joinbottom.gif' alt=''>";
            }else{
                $retorno.= "<img src='../imagenes/join.gif' alt=''>";
            }
            $retorno.= "    <img id='id".$id.$numero."' src='../imagenes/page.gif' alt=''>
                            <a href=\"".$funcion."\">
                                ".$titulo."
                            </a>
                        </div>";
            if($ultimo){
                $retorno.= "</div>";
            }
        }
        return $retorno;
    }

?>

</html>