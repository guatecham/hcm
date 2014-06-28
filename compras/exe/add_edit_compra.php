<?php 
include('../../utilidades/conex.php');
include('../../utilidades/funciones.php');


$id_compra = $_REQUEST["id_compra"];

$fecha	= date2mysql($_REQUEST["fecha"]);
$casa	= $_REQUEST["casa"];
$nota	= $_REQUEST["nota"];

if ($id_compra == 0) {
	$sql="INSERT INTO compra SET ";	
} else {
	$sql="UPDATE compra SET ";
}

$sql.="fecha='$fecha', ";
$sql.="casa_id=$casa, ";
$sql.="nota='$nota'";

if ($id_compra != 0) {
	$sql.=" WHERE id_compra = $id_compra";
}

 $rs=mysql_query($sql);

if ($id_compra == 0) {
	$id_compra = mysql_insert_id();
}

header("Location:../show_compra.php?id=$id_compra");

?>
