<html>

<head>
	<title>WebCaixa v1.20.0_beta</title>
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

	<?php
	// Inserindo Cabeçalho
	include "../cabecprs.php";
	?>
</head>

<body background="../images/bg1.jpg" text="#FFFFFF">
	<?php
	// Importando os Dados do Formul�rio
	$Sis       = "S7";
	$Rot       = "S7R2.1.1.3";
	$lg_user   = trim($_POST['txtuser']);
	$user    = substr($lg_user, 0, 8);
	$pss     = substr($lg_user, 8, 40);
	$Reg       = trim($_POST['txtreg']);
	$PC        = trim($_POST['txtpc']);
	$horaaut   = trim($_POST['horaaut']);
	$NDoc      = trim($_POST['txtdoc']);
	$dtAut     = trim($_POST['dtaut']);
	$TaxaProdF = trim($_POST['taxaprodF']);
	$SgRec     = trim($_POST['siglarec']);
	$FmRec     = trim($_POST['formapag']);
	$MatRec    = trim($_POST['txtmat']); ?>

	<font color="gold" size="6">
		<br><b>
			<center><u><i>Sistema de Autenticação</i></u></center>
		</b>
	</font><?php

			// Imprimindo Ficha Cliente
			$Aut = "$Reg$PC$horaaut$NDoc $dtAut" . "R$ " . "$TaxaProdF$SgRec$FmRec$MatRec";
			shell_exec("echo $Aut > /dev/lp0");

			// Preparando Via Caixa 
			?>
	<form name="via3prod" method="post" action="via4prod.php">
		<input type="hidden" name="txtuser" value="<?php echo $lg_user; ?>">
		<input type="hidden" name="txtreg" value="<?php echo $Reg; ?>">
		<input type="hidden" name="txtpc" value="<?php echo $PC; ?>">
		<input type="hidden" name="horaaut" value="<?php echo $horaaut; ?>">
		<input type="hidden" name="txtdoc" value="<?php echo $NDoc; ?>">
		<input type="hidden" name="dtaut" value="<?php echo $dtAut; ?>">
		<input type="hidden" name="taxaprodF" value="<?php echo $TaxaProdF; ?>">
		<input type="hidden" name="siglarec" value="<?php echo $SgRec; ?>">
		<input type="hidden" name="formapag" value="<?php echo $FmRec; ?>">
		<input type="hidden" name="txtmat" value="<?php echo $MatRec; ?>">
		<br><br><br>
		<font size='6'><b>
				<center>Coloque a <font color='gold'>
						<blink>Ficha do Cliente</blink>
						<font color='#FFFFFF'> na Autenticadora
							e <br>
							<p>Clique no <font color='gold'>
									<blink>botão Abaixo</blink>
									<font color='#FFFFFF'>.</center>
			</b></font>
		</p><br>
		<center><input id="ghost_click" type="submit" name="btimprime" value="Autenticar"></center><br>
		<center>
			<font color='#FFFFFF' size='3'><span id="msg"></span></font>
		</center>
	</form><?php

			// Encerrando
			$SisRot = "S-7.2.1.1.3";
			include "./rodape.php"; ?>

	<script src="./js/ghost_click.js"></script>

</body>

</html>