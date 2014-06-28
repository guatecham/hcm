<?php 
include('utilidades/conex.php');


// Preparacion del arreglo que sirve para el autocompletar de jquery
$listado_php = array();
$sql="SELECT nombre FROM producto ORDER BY nombre";
$rs=mysql_query($sql);

if (mysql_num_rows($rs) == 0) {
	array_push($listado_php,"No hay productos en la base de datos");
} else {
	while ($rs_producto = mysql_fetch_object($rs)) {
		array_push($listado_php, $rs_producto->nombre );	
	} // end while
} // end if
// Fin de preparacion de arreglo para autocompletar de jquery


?>


<!doctype html>
<html lang="es">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1" />
	<title>Hospital Centro Medico</title>
	<link href="utilidades/jquery/css/cupertino/jquery-ui-1.10.4.custom.css" rel="stylesheet">
	<link href="css/estilos.css" rel="stylesheet">
	<script src="utilidades/jquery/js/jquery-1.10.2.js"></script>
	<script src="utilidades/jquery/js/jquery-ui-1.10.4.custom.js"></script>



<?php /*
	<link rel="stylesheet" href="utilidades/960gs/code/css/reset.css" />
	<link rel="stylesheet" href="utilidades/960gs/code/css/text.css" />
*/
?>
	<link rel="stylesheet" href="utilidades/960gs/code/css/960_24_col.css" />
<?php /*
	<link rel="stylesheet" href="utilidades/960gs/code/css/demo.css" />
*/
?>

<script type="text/javascript">
$(document).ready(function() {
    setTimeout(function() {
        $(".content").fadeOut(1500);
    },3000);
});
</script>

<script>
$(function() {

var productosDisponibles = new Array();
<?php 
for ($i=0;$i<count($listado_php);$i++) { ?>
	productosDisponibles.push('<?php echo $listado_php[$i]; ?>');
<?php } ?>

		$( "#autocomplete" ).autocomplete({
			source: productosDisponibles
		});
		
		$( "#mainmenu" ).buttonset();
		$( "#secondmenu" ).buttonset();
		
		$( "#abecedario" ).tabs();
		
});
</script>

</head>
<body>
<div class="container_24">


<div class="prefix_4 grid_12 alpha" id="mainmenu" align="center">
	<h1 align="center" class="titulo">Hospital Centro Medico</h1>
	
	<input type="radio" id="radio1" name="radio" checked="checked"><label for="radio1">Productos</label>
	<input type="radio" id="radio2" name="radio"><label for="radio2" onclick="location.href='ventas/index.php'">Ventas</label>
	<input type="radio" id="radio3" name="radio"><label for="radio3" onclick="location.href='compras/index.php'">Compras</label>
<hr>
<?php
if (isset($_REQUEST["notfound"])) {
?>
<div class="content" align="justify">
<div class="ui-widget">
	<div class="ui-state-highlight ui-corner-all" style="margin-top: 20px; padding: 0 .7em;">
		<p><span class="ui-icon ui-icon-info" style="float: left; margin-right: .3em;"></span>
		<strong><?php echo $_REQUEST["n"] ?></strong> No encontrado</p>
	</div>
</div>
</div>
<?php
} // end if
?>
</div>
<div class="grid_6 omega" align="right">
	<img src="images/logohcm.jpeg" align="right">
</div>
<div class="clear"></div>



<div class="prefix_3 grid_13 suffix_6" align="center">
<p>&nbsp;</p>
<form action="exe/buscar_producto.php" method="post">
	<input class="txt_busqueda" name="autocomplete" id="autocomplete" title="type &quot;a&quot;" size="40" value="Buscar producto" onclick="this.value=''" onblur="if (this.value == '') {this.value='Buscar producto'}" >
</form>
</div>
<div class="clear"></div>
<p>&nbsp;</p>
<!-- Tabs -->
<div id="secondmenu">
	<input type="radio" id="radio4" name="radio"><label for="radio4" onclick="location.href='productos/index.php?id=0'">Nuevo Producto</label>
</div>
<p>&nbsp;</p>
<div id="abecedario">
	<ul>
<?php
for ($i=65;$i<=90;$i++) { 
	$letra = chr($i);
	$sql="SELECT id_producto FROM producto WHERE nombre lIKE '$letra%' ORDER BY nombre";
	$rs=mysql_query($sql);
	$n=mysql_num_rows($rs);	
	if ($n>0) {
?>	
		<li><a href="#tabs-<?php echo $i ?>"><?php echo "$letra" ?></a></li>
<?php
	} // end if
} // end for
?>
	</ul>

<?php
for ($i=65;$i<=90;$i++) { 
	$letra = chr($i);
	$sql="SELECT id_producto FROM producto WHERE nombre lIKE '$letra%' ORDER BY nombre";
	$rs=mysql_query($sql);
	$n=mysql_num_rows($rs);	
	if ($n>0) {
		$mitad = ceil($n/2);
?>	
	<div id="tabs-<?php echo $i ?>">
		
<?php
	$inf=0;
	$sup=$mitad;
	for ($j=0;$j<2;$j++) {
?>	
		<div class="grid_7 alpha">
<?php
$sql="SELECT id_producto, nombre, existencia FROM producto WHERE nombre lIKE '$letra%' ORDER BY nombre LIMIT $inf, $sup";
$rs=mysql_query($sql);
if (mysql_num_rows($rs) > 0) {
?>			
			<table cellpadding="3" cellspacing="0">
				<td><strong>PRODUCTO</strong></td>
				<td><strong>CANT.</strong></td>
			<?php 
				while ($row=mysql_fetch_object($rs)) {
			?>
<tr onmouseover='this.style.background="#72BAE9"; this.style.color="#ffffff"' onmouseout='this.style.background=""; this.style.color="#000000"'>
	<td onclick='document.location.href="productos/index.php?id=<?php echo $row->id_producto ?>"'><?php echo $row->nombre ?></td>
	<td align="center"><?php echo $row->existencia ?></td>
</tr>
<?php	
} // end while
?>
</table>
<?php
} else {
?>
<p>&nbsp;</p>
<?php
} // end if
?>
		</div>
<?php
	$inf+=$mitad;
	$sup+=$mitad;
} // end for ($i<2)
?>		

	
		<div class="grid_9 omega" align="right">
		<h2><?php echo "Total productos $n" ?></h2>
		</div>
		
		<div class="clear"></div>
		
	</div>
<?php 
	} // end if
} // end for
?>

</div>
<p>&nbsp;</p>
<div class="prefix_4 grid_16 suffix_4">
<?php
		$sql="SELECT id_producto, nombre, existencia FROM producto WHERE existencia < reorden ORDER BY nombre";
		$rs=mysql_query($sql);
		$m=mysql_num_rows($rs);
		if ($m>0) {
		?>
		<div class="ui-state-error ui-corner-all" style="padding: 0 .7em;">
		<h2><span class="ui-icon ui-icon-alert" style="float: left; margin-right: .3em;"></span>
		<?php echo "Productos bajos en existencia" ?><strong> <?php echo $m ?></strong> </h2>
		</div>
		
		<table width="100%" align="left" cellpadding="3" cellspacing="0">
			<tr>	
				<td><strong>PRODUCTO</strong></td>
				<td align="right"><strong>EXISTENCIA</strong></td>
				<td align="right"><strong>REORDEN</strong></td>
			</tr>	
		<?php
			$i=0;
			$sql="SELECT id_producto, nombre, existencia, reorden FROM producto WHERE existencia < reorden ORDER BY nombre";
			$rs=mysql_query($sql);
			while ($row=mysql_fetch_object($rs)) {
				if ($i % 2 == 0) {
				$color = "#e5f0fb";
			} else {
				$color = "#f1f4f6";
			}
			$i++;
			
		?>
			<tr bgcolor="<?php echo $color ?>" onmouseover='this.style.background="#c5011B"; this.style.color="#ffffff"' onmouseout='this.style.background="<?php echo $color ?>"; this.style.color="#000000"'>
				<td onclick='document.location.href="productos/index.php?id=<?php echo $row->id_producto ?>"'><?php echo $row->nombre ?></td>
				<td align="right"><?php echo $row->existencia ?></td>
				<td align="right"><?php echo $row->reorden ?></td>
			</tr>
		<?php
			} // end while
		?>	
		</table>
		<?php
		} // end if ($m >0)
		?>
</div>		
</div>
</body>
</html>
