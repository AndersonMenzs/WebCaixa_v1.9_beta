<html>

<head>
  <title>WebCaixa v1.20.0_beta</title>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
</head>

<body background="../images/bg1.jpg" text="#FFFFFF">
  <?php
  // Importando os Dados do Formulario
  $Sis       = "S7";
  $Rot       = "S7R5.1.1.4";
  $lg_user   = trim($_POST['txtuser']);
  $user    = substr($lg_user, 0, 8);
  $pss     = substr($lg_user, 8, 40);
  $Reg       = trim($_POST['txtreg']);
  $PC        = trim($_POST['txtpc']);
  $horaaut   = trim($_POST['horaaut']);
  $NDoc      = trim($_POST['txtdoc']);
  $dtAut     = trim($_POST['dtaut']);
  $TaxaConcF = trim($_POST['taxaconc']);
  $SgRec     = trim($_POST['siglarec']);
  $FmRec     = trim($_POST['formapag']);
  $MatRec    = trim($_POST['txtmat']);

  // Imprimindo a Via do Caixa
  $Aut = "$Reg$PC$horaaut$NDoc $dtAut" . "R$ " . "$TaxaConcF$SgRec$FmRec$MatRec";
  shell_exec("echo $Aut > /dev/lp0");

  // Retornando ao Sistema 
  ?>
  <meta http-equiv="refresh" content="0;URL=servrec.php?c_s=<?php echo $lg_user; ?>">
  <?php

  // Encerrando
  $SisRot = "S-7.5.1.1.4"; ?>

</body>

</html>