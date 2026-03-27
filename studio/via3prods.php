<html>

<head>
	<title>WebCaixa v1.20.0_beta</title>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
</head>

<body background="../images/bg1.jpg" text="#FFFFFF">
	<?php
	// Importando os Dados do Formul�rio
	$Sis       = "S7";
	$Rot       = "S7R2.8.1.4";
	$lg_user   = trim($_POST['txtuser']);
	$user    = substr($lg_user, 0, 8);
	$pss     = substr($lg_user, 8, 40);
	$Reg       = trim($_POST['txtreg']);
	$PC        = trim($_POST['txtpc']);
	$horaaut   = trim($_POST['horaaut']);
	$NDoc      = trim($_POST['txtdoc']);
	$dtAut     = trim($_POST['dtaut']);
	$SgRec     = trim($_POST['siglarec']);
	$FmRec     = trim($_POST['formapag']);
	$MatRec    = trim($_POST['txtmat']);
	$VrPag     = trim($_POST['txtpag']);
	$VrPagr    = number_format($VrPag, 2, ',', '');
	$VrPagrF   = "R$ " . $VrPagr;

	// Imprimindo a Via do Caixa
	shell_exec("echo '$Reg$PC$horaaut$NDoc $dtAut$VrPagrF$SgRec$FmRec$MatRec' > /dev/lp0");

	// Retornando ao Sistema 
	?>
	<meta http-equiv="refresh" content="0;URL=servrec.php?c_s=<?php echo $lg_user; ?>">
	<?php

	// Encerrando
	$SisRot = "S-7.2.1.8.4"; ?>

</body>

</html>