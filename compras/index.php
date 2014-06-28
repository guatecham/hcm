<?php 
include('../utilidades/conex.php');

if (isset($_REQUEST["m"])) {
    $mesactivo = $_REQUEST["m"];
} else {
    $mesactivo = date('m') - 1;
}

?>

<!doctype html>
<html lang="us">
<head>
	<meta charset="utf-8">
	<title>Compras - Hospital Centro Medico</title>
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

		$( "#mainmenu" ).buttonset();
                $( "#secondmenu" ).buttonset(); 
		$( "#meses" ).tabs({ active: <?php echo $mesactivo ?> });

});		
</script>

</head>
<body>
<div class="container_24">

<div class="prefix_4 grid_10 alpha" id="mainmenu" align="center">
	<h1 align="center" class="titulo">Compras - Hospital Centro Medico</h1>
	
	<input type="radio" id="radio1" name="radio"><label for="radio1" onclick="location.href='../index.php'">Productos</label>
	<input type="radio" id="radio2" name="radio"><label for="radio2" onclick="location.href='../ventas/index.php'">Ventas</label>
	<input type="radio" id="radio3" name="radio" checked="checked"><label for="radio3">Compras</label>
<hr>
</div>
<div class="grid_8 omega" align="right">
	<img src="../images/logohcm.jpeg" align="right">
</div>
<div class="clear"></div>

<div id="secondmenu">
	<input type="radio" id="radio4" name="radio"><label for="radio4" onclick="location.href='show_compra.php'">Nueva Compra</label>
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
		$sql="SELECT id_compra, fecha, casa_id, DAY(fecha) as dia FROM compra WHERE MONTH(fecha) = $i+1 ORDER BY DAY(fecha)";
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
$sql="SELECT id_compra, fecha, casa, DAY(fecha) as dia FROM compra INNER JOIN casa ON casa_id = id_casa WHERE MONTH(fecha) = $i+1 ORDER BY DAY(fecha) LIMIT $inf, $sup";
$rs=  mysql_query($sql);
if (mysql_num_rows($rs) > 0) {
?>    	
    	<table cellpadding="3" cellspacing="0">
    	<tr>
    	    <td><strong>DIA</strong></td>
    	    <td><strong>PROVEEDOR</strong></td>
    	</tr>
<?php
$c=0;
while ($row=  mysql_fetch_object($rs)) {
	$c++;
	if ($c % 2 == 0) {
		$color ="#e7f3fb";
	} else {
		$color = "#b3cfea";	
	}
?>
    <tr onmouseover='this.style.background="#72BAE9"; this.style.color="#ffffff"' onmouseout='this.style.background=""; this.style.color="#000000"'>
        <td align="center"><?php echo $row->dia ?></td>
        <td onclick='document.location.href="show_compra.php?id=<?php echo $row->id_compra ?>"'><?php echo $row->casa ?></td>
        
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
    		<h1><?php echo $mes[$i] ?></h1>
    		<h2><?php echo "$n compra(s)" ?>
    	</div>
    	<div class="clear"></div>
    </div>    

<?php
    } // end for
?>
</div>

</div>
</body>
</html>