<?php 
include('../utilidades/conex.php');
include('../utilidades/funciones.php');

if (isset($_REQUEST["id"])) {
    $id_venta = $_REQUEST["id"]; 
    $titulo = "Mostrar venta";
    $boton = "Cambiar";
    
    // encontrar los datos de la venta
    $sql="SELECT * FROM venta WHERE id_venta = $id_venta";
    $rs=mysql_query($sql);
    $row=mysql_fetch_object($rs);
    $expediente = $row->expediente;
    $fecha = mysql2date($row->fecha);
    $nota = $row->nota;
    
} else {
    $id_venta = 0;
    $titulo = "Nueva venta";
    $boton = "Ingresar";
    
    $expediente = "[Nueva venta]";
    $fecha = date("d/m/Y");
    $nota = "";
    
} // end if

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
<html lang="us">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1" />
	<title><?php echo $expediente ?> - - Hospital Centro Medico</title>
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

		$( "#listaProductos" ).autocomplete({
			source: productosDisponibles
		});

		$( "#mainmenu" ).buttonset();

		$( "#fecha" ).datepicker({
			showOn: "button",
			buttonImage: "../images/calendar.gif",
			buttonImageOnly: true,
			dateFormat: "dd/mm/yy"
		});


		$( "#btn_ingresar" ).button();

// Hover states on the static widgets
		$( "#dialog-link, #icons li" ).hover(
			function() {
				$( this ).addClass( "ui-state-hover" );
			},
			function() {
				$( this ).removeClass( "ui-state-hover" );
			}
		);

});
</script>

<script>
function confirma_elimina(id) {
    if (confirm('Desea eliminar el registro')) {
        document.location.href="exe/del_producto.php?id=" + id;
    }
   
} // end function

function validar() { 

if (document.getElementById('expediente').value == "" || document.getElementById('expediente').value == "[Nueva venta]" ) {
	alert('Debe ingresar un numero de expediente');
	document.getElementById('expediente').focus();
	return 0;
}

document.getElementById('frm_venta').submit();

} // end function


function validar2() {
	
	if (document.getElementById('listaProductos').value == "") {
		alert('Debe seleccionar un producto para agregar');
		document.getElementById('listaProductos').value="";
		document.getElementById('listaProductos').focus();
		return 0;
	} 
	
	if (isNaN(document.getElementById('cantidad').value) || document.getElementById('cantidad').value == "" ) {
		alert('La cantidad debe ser un numero');
		document.getElementById('cantidad').value="";
		document.getElementById('cantidad').focus();
		return 0;
	}
	
	document.getElementById('frm_detalle_venta').submit();
	
} // end function
</script>
    
</head>
<body>
<?php 

?>

<div class="container_24">


<div class="prefix_4 grid_10 alpha" id="mainmenu" align="center">
	<h1 align="center" class="titulo">Hospital Centro Medico</h1>
	<input type="radio" id="radio1" name="radio"><label for="radio1" onclick="location.href='index.php">Productos</label>
	<input type="radio" id="radio2" name="radio" checked="checked"><label for="radio2" onclick="location.href='../ventas/index.php'">Volver</label>
	<input type="radio" id="radio3" name="radio"><label for="radio3" onclick="location.href='../compras/index.php'">Compras</label>
<hr>
<h2 class="textoBig">Expediente <?php echo $expediente ?></h2>
</div>
<div class="grid_8 omega" align="right">
	<img src="../images/logohcm.jpeg" align="right">
</div>
<div class="clear"></div>

	

<form id="frm_venta" action="exe/add_edit_venta.php" method="POST">
<input type="hidden" name="id_venta" id="id_venta" value="<?php echo $id_venta ?>">

<div class="prefix_4 grid_10 suffix_10">
<table width="100%" cellspacing="0" cellpadding="3">
	<tr bgcolor="#e5f0fb">
		<td align="right" class="textoMed1">Fecha:</div></td>
		<td align="left" class="textoMed2"><input type="text" name="fecha" id="fecha" value="<?php echo $fecha ?>"></td>
	</tr>
	<tr bgcolor="#f1f4f6">
		<td align="right" class="textoMed1">Expediente:</div></td>
		<td align="left" class="textoMed2"><input type="text" name="expediente" id="expediente" value="<?php echo $expediente ?>" onclick="if (this.value == '[Nueva venta]') {this.value=''}" ></td>
	</tr>
	<tr bgcolor="#e5f0fb">
		<td align="right" class="textoMed1">Nota:</div></td>
		<td align="left" class="textoMed2"><textarea rows="4" cols="40" name="nota" id="nota" value="<?php echo $nota ?>"><?php echo $nota ?></textarea></td>
	</tr>
</table>
<hr>
</div>
<div class="clear"></div>


<div class=" prefix_8 grid_6 suffix_10 omega">
<input type="button" value="<?php echo $boton ?>" onclick="validar()">

</div>
<div class="clear"></div>
</form>
<?php 
if ($id_venta != 0) {
?>
<div class="prefix_2 grid_16 suffix_6">

<form id="frm_detalle_venta" action="exe/add_detalle.php" method="POST">
    <input type="hidden" name="id_venta" id="id_venta" value="<?php echo $id_venta ?>">    
<h2>Detalle</h2>
<table width="100%" cellpadding="3" cellspacing="1">
<?php
$total=$i=0;
$sql="SELECT * FROM detalle_venta WHERE venta_id = $id_venta";
$rs=  mysql_query($sql);
if (mysql_num_rows($rs) > 0) {
?>
    <tr>
        <td>&nbsp;</td>
        <td><strong>Producto</strong></td>
        <td><strong>Cantidad</strong></td>
        <td align="right"><strong>Precio</strong></td>
        <td align="right"><strong>Subtotal</strong></td>
    </tr>
<?php 
while ($row=mysql_fetch_object($rs)) {
    $subtotal = $row->cantidad * $row->precio;
    $total += $subtotal;
    $sql="SELECT nombre FROM producto WHERE id_producto = $row->producto_id";
    $rs_aux=mysql_query($sql);
    $row_aux=  mysql_fetch_object($rs_aux);

    if ($i % 2 == 0) {
	    $color = "#E5F0FB";
    } else {
	    $color = "#72BAE9";
    }
    $i++;
?> 
    <tr bgcolor="<?php echo $color ?>">
        <td>
        <ul id="icons" class="ui-widget ui-helper-clearfix">
	<li class="ui-state-default ui-corner-all" title=".ui-icon-circle-minus" onclick="confirma_elimina('<?php echo $row->id_registro ?>')" ><span class="ui-icon ui-icon-circle-minus"></span></li>
        </ul>
        </td>
        <td><?php echo $row_aux->nombre ?></td>
        <td align="center"><?php echo $row->cantidad ?></td>
        <td align="right"><?php echo "Q.".number_format($row->precio,2) ?></td>
        <td align="right"><?php echo "Q.".number_format($subtotal,2) ?></td>
    </tr>
<?php 
} // end while
?>
        <tr>
        <td colspan="3">&nbsp;</td>
        <td colspan="2"><strong><hr></td>
    </tr>
    <tr>
        <td colspan="3" align="right" class="textoBig">TOTAL</td>
        <td colspan="2" align="right" class="textoBig"><?php echo "Q.".number_format($total,2) ?></td>
    </tr>
 <?php
} // end if
?>  
     <tr>
     	<td>&nbsp;</td>
   	
        <td colspan="4" align="left"><strong>Agregar producto al expediente</strong></td>
    </tr>
       <tr>
        <td>&nbsp;</td>
        <td><input type="text" class="txt_busqueda" name="listaProductos" id="listaProductos" size="30"></td>
        <td><input type="text" class="txt_busqueda" name="cantidad" id="cantidad" size="5"></td>
        <td align="left"><input type="button" onclick="validar2()" value="+">
        
       <?php
       /*
        <ul id="icons" class="ui-widget ui-helper-clearfix">
	<li class="ui-state-default ui-corner-all" title=".ui-icon-circle-plus" onclick="validar2()" ><span class="ui-icon ui-icon-circle-plus"></span></li>
        </ul>
        */ ?>
        </td>
        <td>&nbsp;</td>
    </tr>
   
<?php
} // end if
?>
</table> 

<?php
if (isset($_REQUEST["notfound"])) {
?>
<div class="content">
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

</form> 
</div>

</div>
</body>
</html>
