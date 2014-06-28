<?php 
include('../utilidades/conex.php');

$nombre_producto = $_REQUEST["autocomplete"];
$sql="SELECT id_producto FROM producto WHERE nombre LIKE '$nombre_producto'";
$rs=mysql_query($sql);
if (mysql_num_rows($rs) > 0) {
	$row=mysql_fetch_object($rs);
	header("Location: ../productos/index.php?id=$row->id_producto");
} else {
	header("Location: ../index.php?notfound=1&n=$nombre_producto");
}


?>