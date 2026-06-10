<?php  // Preparando Variáveis
$dataop = date("Y-m-d");
$chcx   = "no";

// Abrindo a Conexão
include "conexao.php";

// Selecionando o Banco de Dados Funcionários
include "dbselect.php";
include_once "valida_caixa.php";

// Verificando Situação do Caixa pela regra central de bloqueio.
$caixaAnterior = caixa_anterior_aberto($conec);

if ($caixaAnterior['aberto']) {
   $chcx = 'a';
} else if (caixa_aberto_hoje($conec)) {
   $chcx = 'f';
} else {
   $sqlV  = "select dtopen, dtclose from caixa where dtclose IS NOT NULL order by dtclose desc";
   $rsV   = mysqli_query($conec, $sqlV) or die("Não foi possível acessar o Caixa");
   $lnV   = mysqli_fetch_array($rsV);

   if ($lnV) {
      $Abr = $lnV['dtopen'];
      $Fch = caixa_normalizar_data($lnV['dtclose']);

      if ($Fch != '' and $Fch < $dataop) {
         $chcx = 'x';
      }
   }

   mysqli_free_result($rsV);
}
