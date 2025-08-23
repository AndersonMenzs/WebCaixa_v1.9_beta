<?php
  include "dbselect.php";
  $sqlP = "select modpag from formapag where codpag = '$De' ";
  $rsP  = mysqli_query($conec, $sqlP) or dir ("Não foi Possível Consultar Forma de Pagamento");
  $lnP  = mysqli_fetch_array($rsP);
    $Forma = $lnP['modpag'];

  $sqlN = "select modpag from formapag where codpag = '$Para' ";
  $rsN  = mysqli_query($conec, $sqlN) or dir ("Não foi Possível Consultar Forma de Pagamento");
  $lnN  = mysqli_fetch_array($rsN);
    $Forma2 = $lnN['modpag'];

  mysqli_free_result($rsP);
  mysqli_free_result($rsN);
?>
