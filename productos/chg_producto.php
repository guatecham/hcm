<?php 
include('../utilidades/conex.php');

if (isset($_REQUEST["id"])) {
	$id_producto = $_REQUEST["id"];	
} else {
	$id_producto = 0;
}

if (isset($_REQUEST["clave"])) {
	$clave = $_REQUEST["clave"];
} else {
	header("Location: index.php");
}


if ($clave != "123456") {
	header("Location: index.php?id=$id_producto&error=1");
}


if ($id_producto != 0) {
	$sql="SELECT * FROM producto WHERE id_producto = $id_producto";
	$rs=mysql_query($sql);
	$row=mysql_fetch_object($rs);
	$nombre 		= $row->nombre;
	$costo	 		= $row->costo;
	$precio 		= $row->precio;
	$generico 		= $row->generico;
	$existencia		= $row->existencia;	
	$reorden		= $row->reorden;
	$presentacion	= $row->presentacion_id;
	$boton			= "Modificar";
} else {
	$nombre = "[Nuevo Producto]";
	$costo = $precio = 0;
	$generico 	= "";
	$existencia	=  $reorden = $presentacion = 0;
	$boton = "Ingresar";
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
<?php
 /*
	<link rel="stylesheet" href="utilidades/960gs/code/css/demo.css" />
*/
?>

<script>
$(function() {
	$( "#mainmenu" ).buttonset();	
});
</script>

<script>

function validar() {


	if (document.getElementById('nombre').value == "" || document.getElementById('nombre').value == "[Nuevo Producto]") {
		alert ('Debe ingresar un nombre de producto');
		document.getElementById('nombre').focus();
		return 0;
	}

	if (isNaN(document.getElementById('costo').value) || document.getElementById('costo').value < 0) {
		alert('El costo debe ser un valor mayor que 0');
		document.getElementById('costo').value=0;
		document.getElementById('costo').focus();
		return 0;
	} 
	
	
	if (isNaN(document.getElementById('precio').value) || document.getElementById('precio').value < 0) {
		alert('El precio debe ser un valor numerico');
		document.getElementById('precio').value=0;
		document.getElementById('precio').focus();
		return 0;
	} 	
	
	if (isNaN(document.getElementById('existencia').value)) {
		alert('La existencia debe ser un valor numerico');
		ocument.getElementById('existencia').value=0;
		document.getElementById('existencia').focus();
		return 0;
	}
	
	if (isNaN(document.getElementById('reorden').value)|| document.getElementById('reorden').value < 0) {
		alert('La existencia debe ser un valor numerico');
		ocument.getElementById('reorden').value=0;
		document.getElementById('reorden').focus();
		return 0;
	}
	
	document.getElementById('frm_producto').submit();
} // end function
</script>

</head>
<body>

<div class="container_24">


<div class="prefix_4 grid_10 alpha" id="mainmenu" align="center">
	<h1 align="center">Hospital Centro Medico</h1>
	
	<input type="radio" id="radio1" name="radio"checked="checked" ><label for="radio1" onclick="location.href='index.php?id=<?php echo $id_producto ?>'">Ver</label>
	<input type="radio" id="radio2" name="radio"><label for="radio2" onclick="location.href='../ventas/index.php'">Ventas</label>
	<input type="radio" id="radio3" name="radio"><label for="radio3" onclick="location.href='../compras/index.php'">Compras</label>
<hr>
<h2 class="textoBig"><?php echo $nombre ?></h2>
</div>
<div class="grid_8 omega" align="right">
	<img src="../images/logohcm.jpeg" align="right">
</div>
<div class="clear"></div>

<form action="exe/add_edit_producto.php" name="frm_producto" id="frm_producto" method="post">
<input type="hidden" name="id_producto" id="id_producto" value="<?php echo $id_producto ?>">

<div class="prefix_4 grid_10 suffix_10">
<table width="100%" cellspacing="0" cellpadding="3">
	<tr bgcolor="#f1f4f6">
		<td align="right" class="textoMed1">Nombre:</div></td>
		<td align="left" class="textoMed2"><input class="txt_input" size="30" type="text" name="nombre" id="nombre" value="<?php echo $nombre ?>"></td>
	</tr>
	<tr bgcolor="#e5f0fb">
		<td align="right" class="textoMed1">Costo:</div></td>
		<td align="left" class="textoMed2"><input class="txt_input" type="text" name="costo" id="costo" value="<?php echo $costo ?>"></td>
	</tr>
	<tr bgcolor="#f1f4f6">
		<td align="right" class="textoMed1">Precio:</div></td>
		<td align="left" class="textoMed2"><input class="txt_input" type="text" name="precio" id="precio" value="<?php echo $precio ?>"></td>
	</tr>
	<tr bgcolor="#e5f0fb">
		<td align="right" class="textoMed1">Generico:</div></td>
		<td align="left" class="textoMed2"><input class="txt_input" type="text" name="generico" id="generico" value="<?php echo $generico ?>"></td>
	</tr>
	<tr bgcolor="#f1f4f6">
		<td align="right" class="textoMed1">Existencia:</div></td>
		<td align="left" class="textoMed2"><input class="txt_input" type="text" name="existencia" id="existencia" value="<?php echo $existencia ?>"></td>
	</tr>
	<tr bgcolor="#e5f0fb">
		<td align="right" class="textoMed1">Reorden:</div></td>
		<td align="left" class="textoMed2"><input class="txt_input" type="text" name="reorden" id="reorden" value="<?php echo $reorden ?>"></td>
	</tr>
	<tr bgcolor="#f1f4f6">
		<td align="right" class="textoMed1">Presentacion:</div></td>
		<td align="left" class="textoMed2"><select class="txt_input" name="presentacion" id="presentacion">
<?php
$sql="SELECT * FROM presentacion ORDER BY id_presentacion";
$rs=mysql_query($sql);
while ($row=mysql_fetch_object($rs)) {
	if ($row->id_presentacion == $presentacion) {
		$selected = "selected='selected'";
	} else {
		$selected = "";
	}


?>	
	<option value="<?php echo $row->id_presentacion ?>" <?php echo $selected ?>><?php echo $row->presentacion ?></option>
<?php
}
?>
</select></td>
	</tr>
</table>
</div>
<div class="clear"></div>
<div class="prefix_4 grid_10 alpha" align="center"><hr></div>
<div class="clear"></div>
<br>
<div class="prefix_4 grid_6" align="right"><input type="button" onclick="validar()" value="<?php echo $boton ?>"></div>

</form>
</div>
</body>
</html>
