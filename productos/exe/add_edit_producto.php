<?php
include("../../utilidades/conex.php");

$id				= $_REQUEST["id_producto"];
$nombre			= $_REQUEST["nombre"];
$costo			= $_REQUEST["costo"];
$precio			= $_REQUEST["precio"];
$generico		= $_REQUEST["generico"];
$existencia		= $_REQUEST["existencia"];
$presentacion	= $_REQUEST["presentacion"];


if ($id == 0) {
	$sql="INSERT INTO producto SET ";
} else {
	$sql="UPDATE producto SET ";
}

$sql.="nombre = '$nombre', ";
$sql.="costo = '$costo', ";
$sql.="precio = '$precio', ";
$sql.="generico = '$generico', ";
$sql.="existencia = $existencia, ";
$sql.="presentacion_id = $presentacion";

if ($id != 0) {
	$sql.=" WHERE id_producto = $id";
}


mysql_query($sql);

header("Location:../index.php?id=$id");
?>