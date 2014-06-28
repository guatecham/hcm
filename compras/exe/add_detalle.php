<?php 
include('../../utilidades/conex.php');

$id_compra = $_REQUEST["id_compra"];
$nombre_producto = $_REQUEST["listaProductos"];
$cantidad = $_REQUEST["cantidad"];  


$sql="SELECT id_producto, costo FROM producto WHERE nombre LIKE '$nombre_producto'";
$rs=  mysql_query($sql);
if (mysql_num_rows($rs) > 0) { // si el producto existe en la base de datos
	$row=  mysql_fetch_object($rs);
	$id_producto = $row->id_producto;


// Verifico si dicho producto ya esta registrado en ESTA compra
$sql="SELECT * FROM detalle_compra WHERE compra_id = $id_compra AND producto_id = $id_producto";
$rs=mysql_query($sql);
if (mysql_num_rows($rs) > 0) {
	$sql="UPDATE detalle_compra SET ";
	$sql.="cantidad = cantidad + $cantidad, ";
	$sql.="costo= $row->costo";
	$sql.="WHERE compra_id = $id_compra AND producto_id = $id_producto";
} else {
	$sql="INSERT INTO detalle_compra SET ";
	$sql.="compra_id = $id_compra, ";
	$sql.="producto_id = $id_producto, ";
	$sql.="cantidad = $cantidad, ";
	$sql.="costo= $row->costo";
}

$rs=  mysql_query($sql);


// Modifico la existencia del producto
$sql="UPDATE producto SET existencia = existencia + $cantidad WHERE id_producto = $id_producto";
$rs=mysql_query($sql);

header("Location:../show_compra.php?id=$id_compra");

} else { // si el producto no existe en la base de datos
	header("Location:../show_compra.php?id=$id_compra&notfound=1&n=$nombre_producto");
}

?>
