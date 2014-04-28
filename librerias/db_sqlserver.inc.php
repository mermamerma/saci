<?php

try {
    ## conexion a sql server…
    $link=mssql_connect("ALEXIS7\ALEXIS7","user_layher","layher2010");
    ## seleccionamos la base de datos
    mssql_select_db("layher",$link);
    ## generamos el query
    $result=mssql_query("select * from MAEEDO$",$link);
    ## recorremos todos los registros
    while($row=mssql_fetch_array($result))
    {
        $counter++;
        echo ("$counter Empresa: ".$row['empresa'].", Nudo: ".$row['nudo']."");
        echo "";
    }
    } catch (Exception $e) {
    echo "Caught Exception ('{$e->getMessage()}')\n{$e}\n";
    }
    ## cerramos la conexion
    mssql_close($link);

?>
