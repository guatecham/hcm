<?php 
include('../../utilidades/conex.php');

$numero_expediente = $_REQUEST["listaExpedientes"];
$sql="SELECT id_venta FROM venta WHERE expediente LIKE '$numero_expediente'";
$rs=mysql_query($sql);
$row=mysql_fetch_object($rs);


header("Location: ../show_venta.php?id=$row->id_venta");
?>