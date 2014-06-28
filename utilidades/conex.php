<?php @	$db = mysql_connect('localhost', 'hcm', 'hcm123');

if (!$db)
{
	echo 'Error: No se puede conectar a la base de datos. Intentelo mas tarde';
	exit;
}

mysql_select_db("db_hcm");

date_default_timezone_set("America/Tegucigalpa");
//session_start(); 

?>