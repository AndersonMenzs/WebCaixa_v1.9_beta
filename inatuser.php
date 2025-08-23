<?php
// Obtendo a Data Inicial
$AnoCad = substr($dtOpI, 0, 4);
$MesCad = substr($dtOpI, 5, 2);
$DiaCad = substr($dtOpI, 8, 2);

// Obtendo a Data Final
$AnoHoje = date('Y');
$MesHoje = date('m');
$DiaHoje = date('d');

// Cálculo do timestamp das duas datas
$timestamp1 = mktime(0, 0, 0, $MesCad, $DiaCad, $AnoCad);
$timestamp2 = mktime(0, 0, 0, $MesHoje, $DiaHoje, $AnoHoje);

// Diferença em segundos
$segundos_diferenca = $timestamp1 - $timestamp2;

// Diferença em dias
$dias_diferenca = abs($segundos_diferenca / (60 * 60 * 24));

// Removendo o Usuário
if ($dias_diferenca > 45 && $dias_diferenca < 120) {
    $sqlRem = "DELETE FROM operador WHERE mat = '$MatI' AND cargo <> 'Adm' AND cargo <> 'Aud'";
    $rsRem = mysqli_query($conec, $sqlRem) or die("Erro de Acesso #3. Contate seu Administrador.");

    if ($MatI >= 90000000 || $MatI < 90000005) {
        include "dblog.php";

        $sqlDF = "DELETE FROM funcionarios WHERE mat = '$MatI'";
        $rsDF = mysqli_query($conec, $sqlDF) or die("Erro de Acesso #4. Contate seu Administrador.");

        $sqlDP = "DELETE FROM pessoal WHERE mat = '$MatI'";
        $rsDP = mysqli_query($conec, $sqlDP) or die("Erro de Acesso #5. Contate seu Administrador.");
    }
}
//mysqli_free_result($rsRem);

include "dbselect.php";
?>
