<?php
  // Importando os Dados do Formulário
     $Sis       = "S7";
     $Rot       = "S7R5.2.1.1.1";
 
  // Excluindo a Spool de Impressão
     include "dbselect.php";

     $Sqldel = "delete from spool2";
     $rsdel  = mysqli_query ($conec, $Sqldel) or die ("N&atile;o foi possível excluir dados da spool");

  // Encerrando a Conexão
     //mysqli_free_result($rsSp);
?>
