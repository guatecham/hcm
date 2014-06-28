<?php 
include('../utilidades/conex.php');

if (isset($_REQUEST["id"])) {
	$id_producto = $_REQUEST["id"];	
} else {
	$id_producto = 0;
}

if ($id_producto != 0) {
	$sql="SELECT * FROM producto INNER JOIN presentacion ON presentacion_id = id_presentacion WHERE id_producto = $id_producto";
	$rs=mysql_query($sql);
	$row=mysql_fetch_object($rs);
	$nombre 		= $row->nombre;
	$costo	 		= $row->costo;
	$precio 		= $row->precio;
	$generico 		= $row->generico;
	$existencia		= $row->existencia;	
	$reorden		= $row->reorden;	
	$presentacion	= $row->presentacion;
	
} else {
	$nombre = "[Nuevo Producto]";
	$costo = $precio = 0;
	$generico 	= $presentacion = "";
	$existencia	= $reorden = 0;
}


?>

<!doctype html>
<html lang="us">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1" />
	<title><?php echo $nombre ?> - Hospital Centro Medico</title>
	<link href="../utilidades/jquery/css/cupertino/jquery-ui-1.10.4.custom.css" rel="stylesheet">
	<link href="../css/estilos.css" rel="stylesheet">
	<script src="../utilidades/jquery/js/jquery-1.10.2.js"></script>
	<script src="../utilidades/jquery/js/jquery-ui-1.10.4.custom.js"></script>


<?php /*
	<link rel="stylesheet" href="utilidades/960gs/code/css/reset.css" />
	<link rel="stylesheet" href="utilidades/960gs/code/css/text.css" />
*/ ?>
	<link rel="stylesheet" href="../utilidades/960gs/code/css/960_24_col.css" />
<?php /*
	<link rel="stylesheet" href="utilidades/960gs/code/css/demo.css" />
*/
?>

<script>
$(function() {
	$( "#mainmenu" ).buttonset();
});
</script>

</head>
<body>

<div class="container_24">


<div class="prefix_4 grid_10 alpha" id="mainmenu" align="center">
	<h1 align="center" class="titulo">Hospital Centro Medico</h1>
	
	<input type="radio" id="radio1" name="radio"checked="checked"><label for="radio1" onclick="location.href='../index.php'">Volver</label>
	<input type="radio" id="radio2" name="radio"><label for="radio2" onclick="location.href='../ventas/index.php'">Ventas</label>
	<input type="radio" id="radio3" name="radio"><label for="radio3" onclick="location.href='../compras/index.php'">Compras</label>
<hr>
<h2 class="textoBig"><?php echo $nombre ?></h2>
</div>
<div class="grid_8 omega" align="right">
	<img src="../images/logohcm.jpeg" align="right">
</div>
<div class="clear"></div>

<div class="prefix_4 grid_10 suffix_10">
<table width="100%" cellspacing="0" cellpadding="3">
	<tr bgcolor="#e5f0fb">
		<td align="right" class="textoMed1">Costo:</div></td>
		<td align="left" class="textoMed2"><?php echo "Q.".number_format($costo,2) ?></td>
	</tr>
	<tr bgcolor="#f1f4f6">
		<td align="right" class="textoMed1">Precio:</div></td>
		<td align="left" class="textoMed2"><?php echo "Q.".number_format($precio,2) ?></td>
	</tr>
	<tr bgcolor="#e5f0fb">
		<td align="right" class="textoMed1">Generico:</div></td>
		<td align="left" class="textoMed2"><?php echo $generico  ?></td>
	</tr>
	<tr bgcolor="#f1f4f6">
		<td align="right" class="textoMed1">Existencia:</div></td>
		<td align="left" class="textoMed2"><?php echo $existencia ?></td>
	</tr>
	<tr bgcolor="#e5f0fb">
		<td align="right" class="textoMed1">Reorden:</div></td>
		<td align="left" class="textoMed2"><?php echo $reorden ?></td>
	</tr>
	<tr bgcolor="#f1f4f6">
		<td align="right" class="textoMed1">Presentacion:</div></td>
		<td align="left" class="textoMed2"><?php echo $presentacion ?></td>
	</tr>
</table>
</div>
<div class="clear"></div>

<div class="prefix_4 grid_10 alpha" align="center">
<hr>
<br>
<form action="chg_producto.php" name="frm_validar" id="frm_validar" method="post">
<input type="hidden" name="id" id="id" value="<?php echo $id_producto ?>">
<strong>Clave: </strong><input type="password" name="clave" id="clave"> <input type="submit" value="Modificar">
</form>
<br>
<?php 
if (isset($_REQUEST["error"])) {
	$error = $_REQUEST["error"];
} else {
	$error = 0;
}
if ($error == 1) {
?>
<div class="ui-widget">
	<div class="ui-state-error ui-corner-all" style="padding: 0 .7em;">
		<p><span class="ui-icon ui-icon-alert" style="float: left; margin-right: .3em;"></span>
		<strong>Clave incorrecta:</strong> No puede modificar los datos. Vuelva a intentarlo</p>
	</div>
</div>
<?php
}	
?>
</div>
</div>
</body>
</html>
