<?php 
include('../utilidades/conex.php');

// Preparacion del arreglo que sirve para el autocompletar de jquery
$listado_php = array();
$sql="SELECT expediente FROM venta ORDER BY fecha";
$rs=mysql_query($sql);

if (mysql_num_rows($rs) == 0) {
	array_push($listado_php,"No hay ventas en la base de datos");
} else {
	while ($rs_venta = mysql_fetch_object($rs)) {
		array_push($listado_php, $rs_venta->expediente );	
	} // end while
} // end if

// Fin de preparacion de arreglo para autocompletar de jquery

if (isset($_REQUEST["m"])) {
    $mesactivo = $_REQUEST["m"];
} else {
    $mesactivo = date('m') - 1;
}

?>

<!doctype html>
<html lang="us">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1" />
	<title>Ventas - Hospital Centro Medico</title>
	<link href="../utilidades/jquery/css/cupertino/jquery-ui-1.10.4.custom.css" rel="stylesheet">
	<link href="../css/estilos.css" rel="stylesheet">
	<script src="../utilidades/jquery/js/jquery-1.10.2.js"></script>
	<script src="../utilidades/jquery/js/jquery-ui-1.10.4.custom.js"></script>


<?php /*
	<link rel="stylesheet" href="utilidades/960gs/code/css/reset.css" />
	<link rel="stylesheet" href="utilidades/960gs/code/css/text.css" />
*/
?>
	<link rel="stylesheet" href="../utilidades/960gs/code/css/960_24_col.css" />
<?php /*
	<link rel="stylesheet" href="utilidades/960gs/code/css/demo.css" />
*/
?>

<script>
$(function() {

var expedientesDisponibles = new Array();
<?php 
for ($i=0;$i<count($listado_php);$i++) { ?>
	expedientesDisponibles.push('<?php echo $listado_php[$i]; ?>');
<?php } ?>

		$( "#listaExpedientes" ).autocomplete({
			source: expedientesDisponibles
		});


		$( "#mainmenu" ).buttonset();
                $( "#secondmenu" ).buttonset(); 
		$( "#meses" ).tabs({ active: <?php echo $mesactivo ?> });

});		
</script>

</head>
<body>
<div class="container_24">

<div class="prefix_4 grid_10 alpha" id="mainmenu" align="center">
	<h1 align="center" class="titulo">Ventas - Hospital Centro Medico</h1>
	
	<input type="radio" id="radio1" name="radio"><label for="radio1" onclick="location.href='../index.php'">Productos</label>
	<input type="radio" id="radio2" name="radio" checked="checked"><label for="radio2">Ventas</label>
	<input type="radio" id="radio3" name="radio"><label for="radio3" onclick="location.href='../compras/index.php'">Compras</label>
<hr>
</div>
<div class="grid_8 omega" align="right">
	<img src="../images/logohcm.jpeg" align="right">
</div>
<div class="clear"></div>


<div class="prefix_3 grid_13 suffix_6" align="center">
<p>&nbsp;</p>
<form action="exe/buscar_expediente.php" method="post">
    <input class="txt_busqueda" type="text" name="listaExpedientes" id="listaExpedientes" size="40" value="Buscar expediente" onclick="this.value=''">
</form>
</div>
<div class="clear"></div>

<div id="secondmenu">
	<input type="radio" id="radio4" name="radio"><label for="radio4" onclick="location.href='show_venta.php'">Nueva Venta</label>
</div>
<p>&nbsp;</p>
<div id="meses">
    <ul>
<?php
    $mes=array("Enero", "Febrero","Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre","Diciembre");
    for ($i=0;$i<12;$i++) { 
    ?>
        <li><a href="#tabs-<?php echo $i ?>"><?php echo $mes[$i] ?></a></li>
<?php
    } // end for (meses)
?>
    </ul>
<?php    
	for ($i=0;$i<12;$i++) {
		$sql="SELECT id_venta, fecha, expediente, DAY(fecha) as dia FROM venta WHERE MONTH(fecha) = $i+1 ORDER BY DAY(fecha)";
		$rs=mysql_query($sql);
		$n=mysql_num_rows($rs);
		$mitad=ceil($n/2);
?>
    <div id="tabs-<?php echo $i ?>">
 <?php
	$inf=0;
	$sup=$mitad;
	for ($j=0;$j<2;$j++) {
?>	
    	<div class="grid_7 alpha">
<?php
$sql="SELECT id_venta, fecha, expediente, DAY(fecha) as dia FROM venta WHERE MONTH(fecha) = $i+1 ORDER BY DAY(fecha) LIMIT $inf, $sup";
$rs=  mysql_query($sql);
if (mysql_num_rows($rs) > 0) {
?>    	
    	<table cellpadding="3" cellspacing="0">
    	<tr>
    	    <td><strong>DIA</strong></td>
    	    <td><strong>EXPEDIENTE</strong></td>
    	</tr>
<?php
while ($row=  mysql_fetch_object($rs)) {	
?>
    <tr onmouseover='this.style.background="#72BAE9"; this.style.color="#ffffff"' onmouseout='this.style.background=""; this.style.color="#000000"'>
        <td align="center"><?php echo $row->dia ?></td>
        <td onclick='document.location.href="show_venta.php?id=<?php echo $row->id_venta ?>"'><?php echo $row->expediente ?></td>        
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
}
?>
    	</div>
 <?php
	$inf+=$mitad;
	$sup+=$mitad;
} // end for ($i<2)
?>	
    	<div class="grid_7 omega" align="right">
    		<h1><?php echo $mes[$i+1] ?></h1>
    		<h2><?php echo "$n expediente(s)" ?>
    	</div>
    	<div class="clear"></div>
    </div>    

<?php
    } // end for
?>
</div>
</body>
</html>
