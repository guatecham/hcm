<?php

function date2mysql($f) {

$aux = explode("/",$f);
$r=$aux[2]."-".$aux[1]."-".$aux[0];

return $r;

} // end function


function mysql2date($f) {

$aux = explode("-",$f);

$r=$aux[2]."/".$aux[1]."/".$aux[0];

return $r;

}

?>