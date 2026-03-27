<html>

<head>
	<title>WebCaixa v1.20.0_beta</title>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">

</head>

<body background="../images/bg1.jpg" text="#FFFFFF">
	<?php
	// Importando os Dados do Formul�rio
	$Sis       = "S7";
	$Rot       = "S7R4.1.3";
	$lg_user   = trim($_POST['txtuser']);
	$user    = substr($lg_user, 0, 8);
	$pss     = substr($lg_user, 8, 40);
	$Aut       = trim($_POST['txtaut']);
	$PC        = trim($_POST['txtpc']);
	$horaaut   = trim($_POST['horaaut']);
	$NDoc      = trim($_POST['txtdoc']);
	$dtAut     = trim($_POST['dtaut']);
	$SgRec     = trim($_POST['siglarec']);
	$FmRec     = trim($_POST['formapag']);
	$MatRec    = trim($_POST['txtmat']);
	$VrEnt     = trim($_POST['txtvalor']);
	$VrEntr    = number_format($VrEnt, 2, ',', '');

	if (strlen($VrEnt) < 7) {
		$VrEntrF   = "R$ " . $VrEntr;
	} else {
		$VrEntrF   = "R$" . $VrEntr;
	}

	// Imprimindo a Via do Caixa
	shell_exec("echo '$Aut$PC$horaaut$NDoc $dtAut$VrEntrF$SgRec$FmRec$MatRec' > /dev/lp0");

	// Retornando ao Sistema 
	?>
	<meta http-equiv="refresh" content="0;URL=index.php?c_s=<?php echo $lg_user; ?>">
	<?php

	// Encerrando
	$SisRot = "S-7.4.1.3"; ?>

</body>

</html>