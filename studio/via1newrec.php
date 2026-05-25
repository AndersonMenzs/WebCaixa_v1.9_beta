<html>

<head>
	<title>WebCaixa v1.20.14_beta</title>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
	<style type="text/css">
		body {
			margin-top: 3%;
			margin-left: 5%;
			margin-right: 5%;
			border: 3px solid gray;
			padding: 10px 10px 10px 10px;
			font-family: sans-serif;
		}

		.campos {
			background-color: #C0C0C0;
			font: 12px sans-serif;
			color: #000000;
		}
	</style>

	<script>
		function F5(event) {
			var tecla = document.all ? window.event.keyCode : event.which;
			if (document.all) {
				window.event.keyCode = 0;
				window.event.returnValue = false;
			}
			if (tecla == 116) return false;
		}

		document.onkeydown = F5;
	</script>

	<?php
	// Inserindo Cabeçalho
	include "../cabecprs.php";
	?>
</head>

<body background="../images/bg1.jpg" text="#FFFFFF" onload="imprimirERedirecionar()">
	<?php

	// Recebendo os dados do formulário
	$lg_user = trim($_POST['txtuser']);
	$user    = substr($lg_user, 0, 8);
	$pss     = substr($lg_user, 8, 40);
	$MatReceb  = trim($_POST['txtreceb']);
	$MtRecF  = 100000000 + $MatReceb;
	$NomeColab = trim($_POST['txtoper']);
	$RecebFull = substr($MtRecF, 1, 8);
	$Envelope  = trim($_POST['txtcod']);
	$Valor     = trim($_POST['txtvalor']);
	$ValorF    = number_format($Valor, 2, ',', '.');
	$Valor_ext = trim($_POST['txtvalor_ext']);
	$SdCaixa   = trim($_POST['txtcaixa']) - $Valor;
	$SdFinal    = trim($_POST['txtcaixaF']);
	$DataF	 = trim($_POST['txtdata']);
	$HoraF	 = trim($_POST['txthora']);
	$tipo      = trim($_POST['txttipo']);
	$PC = "PC-" . $_POST['txtpc'];
	
	include "rodape.php"; 
	?>


	<script>
		function imprimirERedirecionar() {
			// Monta a URL com os dados
			var url = './comp_recolh.php?tipo=<?php echo urlencode($tipo); ?>' +
				'&MatReceb=<?php echo urlencode($MatReceb); ?>' +
				'&MatRecebF=<?php echo urlencode($MatRecebF); ?>' +
				'&NomeColab=<?php echo urlencode($NomeColab); ?>' +
				'&Envelope=<?php echo urlencode($Envelope); ?>' +
				'&Valor=<?php echo urlencode($Valor); ?>' +
				'&ValorF=<?php echo urlencode($ValorF); ?>' +
				'&Valor_ext=<?php echo urlencode($Valor_ext); ?>' +
				'&SdCaixa=<?php echo urlencode($SdCaixa); ?>' +
				'&SdFinal=<?php echo urlencode($SdFinal); ?>' +
				'&DataF=<?php echo urlencode($DataF); ?>' +
				'&HoraF=<?php echo urlencode($HoraF); ?>' +
				'&PC=<?php echo urlencode($PC); ?>'				;
			window.open(url, '_blank');
			setTimeout(function() {
				window.location.href = './servrec.php?c_s=<?php echo $lg_user; ?>';
			}, 1000);
		}
	</script>

</body>

</html>