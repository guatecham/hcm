<?php 
include('../../utilidades/conex.php');
include('../../utilidades/funciones.php');


$id_venta = $_REQUEST["id_venta"];

$fecha 		= date2mysql($_REQUEST["fecha"]);
$expediente = $_REQUEST["expediente"];
$nota		= $_REQUEST["nota"];

if ($id_venta == 0) {
	$sql="INSERT INTO venta SET ";	
} else {
	$sql="UPDATE venta SET ";
}

$sql.="fecha='$fecha', ";
$sql.="expediente='$expediente', ";
$sql.="nota='$nota'";

if ($id_venta != 0) {
	$sql.=" WHERE id_venta = $id_venta";
}

$rs=mysql_query($sql);

if ($id_venta == 0) {
	$id_venta = mysql_insert_id();
}

header("Location:../show_venta.php?id=$id_venta");

?>
