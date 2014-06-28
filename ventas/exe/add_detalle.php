<?php 
include('../../utilidades/conex.php');

$id_venta = $_REQUEST["id_venta"];
$nombre_producto = $_REQUEST["listaProductos"];
$cantidad = $_REQUEST["cantidad"];  


$sql="SELECT id_producto, precio FROM producto WHERE nombre LIKE '$nombre_producto'";
$rs=  mysql_query($sql);
if (mysql_num_rows($rs) > 0) { // si el producto existe en la base de datos
	$row=  mysql_fetch_object($rs);
	$id_producto = $row->id_producto;
	
	// Verifico si dicho producto ya esta registrado en ESTA venta
$sql="SELECT * FROM detalle_venta WHERE venta_id = $id_venta AND producto_id = $id_producto";
$rs=mysql_query($sql);
if (mysql_num_rows($rs) > 0) {
	$sql="UPDATE detalle_venta SET ";
	$sql.="cantidad = cantidad + $cantidad, ";
	$sql.="precio= $row->precio";
	$sql.="WHERE venta_id = $id_venta AND producto_id = $id_producto";
} else {
	$sql="INSERT INTO detalle_venta SET ";
	$sql.="venta_id = $id_venta, ";
	$sql.="producto_id = $id_producto, ";
	$sql.="cantidad = $cantidad, ";
	$sql.="precio= $row->precio";
}
$rs=  mysql_query($sql);


// Modifico la existencia del producto
$sql="UPDATE producto SET existencia = existencia - $cantidad WHERE id_producto = $id_producto";
$rs=mysql_query($sql);

header("Location:../show_venta.php?id=$id_venta");
	
} else { // si el producto no existe en la base de datos
	header("Location:../show_venta.php?id=$id_venta&notfound=1&n=$nombre_producto");
}

?>
