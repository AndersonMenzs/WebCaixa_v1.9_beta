<?php
// Retorna JSON com registros que correspondem ao número de autenticação (últimos 4 dígitos ou igual)
header('Content-Type: application/json; charset=utf-8');
error_reporting(E_ALL);
ini_set('display_errors', 0);

// Variáveis
$Dt_Hoje = date("Y-m-d");

$txt = $_POST['txtaut'] ?? $_GET['txtaut'] ?? '';
$txt = preg_replace('/\D/', '', (string)$txt);
if ($txt === '') {
    echo json_encode([]);
    exit;
}

// inclui conexão
include "./conexao.php";
include "./dbselect.php";

if (!isset($conec) || !$conec) {
    echo json_encode([]);
    exit;
}

// Evita injeção: usar escape
$txt_esc = mysqli_real_escape_string($conec, $txt);

// Procura por reg terminando com os dígitos informados ou reg igual
$sql = "SELECT reg, COALESCE(vendedora,'') AS vendedora, COALESCE(cliente,'') AS cliente, COALESCE(mat_vend,'') AS mat_vend
        FROM registro
        WHERE (reg LIKE '%$txt_esc' OR reg = '$txt_esc')
           AND datarec = '$Dt_Hoje'
        LIMIT 1";

$rs = mysqli_query($conec, $sql);
if (!$rs) {
    echo json_encode([]);
    exit;
}

$rows = [];
while ($ln = mysqli_fetch_assoc($rs)) {
    $rows[] = $ln;
}
mysqli_free_result($rs);

echo json_encode($rows);
exit;
