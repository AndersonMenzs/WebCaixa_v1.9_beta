<?php
// Abrindo a Conexão
include "conexao.php";

// Selecionando o Banco de Dados
include "dblog.php";

// Autorizando o Login
$sqls = "select * from sistemas where mat = '$user' and sis = '$Sis' ";
$sqlu = "select mat, pass, hierarq from funcionarios where mat = '$user' and pass = '$pss' ";

// Consultando o registro
$rss = mysqli_query($conec, $sqls) or die("Não foi possível acessar Sistemas");
$rsu = mysqli_query($conec, $sqlu) or die("Não foi possível acessar o Cadastro");

// Obtendo os Dados do Banco
$lns   = mysqli_fetch_array($rss);
$lg  = $lns['mat'];
$sis = $lns['sis'];

$lnu   = mysqli_fetch_array($rsu);
$lgu = $lnu['mat'];
$psu = $lnu['pass'];
$hier = $lnu['hierarq'];


if (($lg == $user and $psu == $pss and $hier == "S") or ($lgu == $user and $psu == $pss and $hier == "A")) {
   $ch = 'ok';
} else {
   $ch = 'no';
}
// Encerrando a Conexão
mysqli_free_result($rss);
mysqli_free_result($rsu);
