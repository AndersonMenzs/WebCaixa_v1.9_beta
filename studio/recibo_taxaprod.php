<?php

// Debug
error_reporting(E_ALL);
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);

$dados = filter_input_array(INPUT_GET, FILTER_DEFAULT);
echo "<pre>";
print_r($dados);
echo "</pre>";

$tipo      = $_GET['tipo'];
$NDoc      = $_GET['NDoc'];
$PC        = $_GET['PC'];
$VrEntrF   = $_GET['VrEntrF'];
$ModPag    = $_GET['ModPag'];
$FPag_1    = $_GET['fpag_1'];
$FPag_2    = $_GET['fpag_2'];
$FPag_3    = $_GET['fpag_3'];
$txt1      = $_GET['txt1'];
$txt2      = $_GET['txt2'];
$txt3      = $_GET['txt3'];

$FPags = [$FPag_1, $FPag_2, $FPag_3];
$Vlrs = [$txt1, $txt2, $txt3];

$data      = $_GET['data'];
$data = date('d/m/Y', strtotime($data));
$Vendedora = $_GET['Vendedora'];
$Cliente   = $_GET['Cliente'];
$vlr_ext   = $_GET['vlr_ext'];
$Reg       = $_GET['Reg'];
$horaaut   = $_GET['horaaut'];
$dtAut     = $_GET['dtAut'];
$SgRec     = $_GET['SgRec'];
$VrEnt     = $_GET['VrEnt'];
$Mat       = $_GET['Mat'];

?>