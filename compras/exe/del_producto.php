<?php 
include('../../utilidades/conex.php');

$id_registro = $_REQUEST["id"];


$sql="SELECT compra_id, producto_id, cantidad FROM detalle_compra WHERE id_registro = $id_registro";
$rs=mysql_query($sql);
$row=mysql_fetch_object($rs);

$id_compra = $row->compra_id;
$id_producto = $row->producto_id;
$cantidad = $row->cantidad;

$sql="DELETE FROM detalle_compra WHERE id_registro = $id_registro";
$rs=  mysql_query($sql);

// Modifico la existencia del producto
$sql="UPDATE producto SET existencia = existencia + $cantidad WHERE id_producto = $id_producto";
$rs=mysql_query($sql);

header("Location: ../show_compra.php?id=$id_compra");

?>
