<html>

<head>
	<title>WebCaixa v1.19_beta</title>
	<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
	<style type="text/css">
		body {
			margin-top: 5%;
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
		// Previne o botão voltar
		history.pushState(null, null, location.href);
		window.onpopstate = function() {
			history.go(1);
		};

		// Previne F5 e Ctrl+R
		document.onkeydown = function(e) {
			if (e.keyCode == 116 || (e.ctrlKey && e.keyCode == 82)) {
				e.preventDefault();
			}
		};

		// Desabilita clique direito (opcional)
		document.addEventListener('contextmenu', function(e) {
			e.preventDefault();
		});
	</script>

	<?php
	// Inserindo Cabeçalho
	include "../cabecprs.php";
	?>
</head>

<body background="../images/bg1.jpg" text="#FFFFFF">
	<?php
	// Importando os Dados do Formulário
	$Sis       = "S7";
	$Rot       = "S7R2.1.1.1";
	$dtRec     = date('Y-m-d');
	$dtComp    = date('Y-m-d');
	$hora	  = date('H:i');
	$lg_user   = trim($_POST['txtuser']);
	$user    = substr($lg_user, 0, 8);
	$pss     = substr($lg_user, 8, 40);
	$RdTaxa      = trim($_POST['rdtaxa']);
	$VrProd    = trim($_POST['txtvrprod']);
	$VrProdF = number_format($VrProd, 2, ",", ".");
	$NDoc      = trim($_POST['txtdoc']);
	$FPag_1     = trim($_POST['lsPr1']);
	$FPag_2     = trim($_POST['lsPr2']);
	$FPag_3     = trim($_POST['lsPr3']);
	$txt1 = isset($_POST['txt1']) ? (float) trim($_POST['txt1']) : 0;
	$txt2 = isset($_POST['txt2']) ? (float) trim($_POST['txt2']) : 0;
	$txt3 = isset($_POST['txt3']) ? (float) trim($_POST['txt3']) : 0;
	$VrTx	 = $txt1 + $txt2 + $txt3;
	$VrTxa	= number_format($VrTx, 2, ',', '.');
	$Mat_Vend = trim($_POST['mat_vend']);
	$Vendedora = trim($_POST['vendedora']);
	$Vendedora_full = trim($_POST['vendedora']);
	$Cliente	= trim($_POST['cliente']);
	$DataNasc	= trim($_POST['data_nasc']);
	$Idade 		= trim($_POST['idade']);
	$Pass      = strtolower(trim($_POST['txtsen']));
	$Senha     = sha1($Pass);

	// Truncar o nome da vendedora com o primeiro nome completo e após o primeiro espaco, deixar somente uma letra e ponto.
	$Vendedora = strtoupper($Vendedora);
	$Vendedora = substr($Vendedora, 0, strpos($Vendedora, ' ') + 1) . substr($Vendedora, strpos($Vendedora, ' ') + 1, 1) . '.';

	// Criando Variáveis
	$fps = 0;
	$TaxaProd  = $txt1 + $txt2 + $txt3;
	$TaxaProdF = number_format($TaxaProd, 2, ",", ".");

	// Verifica o Tipo de Recibo pela idade do cliente
	if ($Idade >= 60) {
		$TipoRec   = '10';
		$SubTipo   = 'TXPG';
	} else {
		$TipoRec   = '1';
		$SubTipo   = 'TXP';
	}

	// Conexão
	include "conexao.php";
	include "dbselect.php";

	// Obtendo Dados
	$sqlo = "select * from operador where pass = '$Senha' ";
	$rso  = mysqli_query($conec, $sqlo);
	$regso = mysqli_num_rows($rso); ?>

	<font color="gold" size="6">
		<br><b>
			<center><u><i>Sistema de Autenticação</i></u></center>
		</b>
	</font><br>
	<?php

	include "us_cad.php";

	if ($ch == 'ok' or $ch == 'ok-enc' or $ch == 'ok-cai' or $ch == 'ok-adm') {
		if ($regso > 0) {
			$lno  = mysqli_fetch_array($rso);
			$Mat = $lno['mat'];

			// Gravando os Registros
			$sqlr = "select * from registro order by datarec desc, reg desc";
			$rsr  = mysqli_query($conec, $sqlr) or die("Erro de Banco de Dados #1. Contate seu Administrador.");
			$regsr = mysqli_num_rows($rsr);
			$lnr = mysqli_fetch_array($rsr);
			$Reg     = $lnr['reg'];
			$dtReceb = $lnr['datarec'];

			if ($regsr == 0 or $dtComp <> $dtReceb) {
				$Reg = 0;
			}
			$Reg  = $Reg + 1;

			if ($FPag_1 <> "00" or $FPag_1 == "99") {
				//$fps = $fps + 1;
				$sqlGr = "insert into registro values($Reg, '$NDoc', '$TipoRec', '$SubTipo', '$FPag_1', '0', '$dtRec', '$hora', '$txt1', '$Mat', '', '$Mat_Vend', '$Vendedora_full', '$Cliente')";
				$rsGr  = mysqli_query($conec, $sqlGr) or die("Erro de Banco de Dados #2. Contate seu Administrador.");
			}

			if ($FPag_2 <> "00" and $FPag_1 <> "99") {
				//$fps = $fps + 1;
				$sqlGr = "insert into registro values($Reg, '$NDoc', '$TipoRec', '$SubTipo', '$FPag_2', '0', '$dtRec', '$hora', '$txt2', '$Mat', '', '$Mat_Vend', '$Vendedora_full', '$Cliente')";
				$rsGr  = mysqli_query($conec, $sqlGr) or die("Erro de Banco de Dados #5. Contate seu Administrador.");
			}

			if ($FPag_3 <> "00" and $FPag_1 <> "99") {
				//$fps = $fps + 1;
				$sqlGr = "insert into registro values($Reg, '$NDoc', '$TipoRec', '$SubTipo', '$FPag_3', '0', '$dtRec', '$hora', '$txt3', '$Mat', '', '$Mat_Vend', '$Vendedora_full', '$Cliente')";
				$rsGr  = mysqli_query($conec, $sqlGr) or die("Erro de Banco de Dados #8. Contate seu Administrador.");
			}

			// Preparando a Via Cliente 
	?>
			<form name="geraprod" method="post" action="via1newprod.php">
				<input type="hidden" name="txtuser" value="<?php echo $lg_user; ?>">
				<input type="hidden" name="txtreg" value="<?php echo $Reg; ?>">
				<input type="hidden" name="tiporec" value="<?php echo $TipoRec; ?>">
				<input type="hidden" name="txt1" value="<?php echo $txt1; ?>">
				<input type="hidden" name="txt2" value="<?php echo $txt2; ?>">
				<input type="hidden" name="txt3" value="<?php echo $txt3; ?>">
				<input type="hidden" name="txtvalor" value="<?php echo $VrTxa; ?>">
				<input type="hidden" name="txtdoc" value="<?php echo $NDoc; ?>">
				<input type="hidden" name="rdtaxa" value="<?php echo $RdTaxa; ?>">
				<input type="hidden" name="lsPr1" value="<?php echo $FPag_1; ?>">
				<input type="hidden" name="lsPr2" value="<?php echo $FPag_2; ?>">
				<input type="hidden" name="lsPr3" value="<?php echo $FPag_3; ?>">
				<input type="hidden" name="dtrec" value="<?php echo $dtRec; ?>">
				<input type="hidden" name="txthora" value="<?php echo $hora; ?>">
				<input type="hidden" name="txtvrprod" value="<?php echo $VrProd; ?>">
				<input type="hidden" name="txtvrprodF" value="<?php echo $VrProdF; ?>">
				<input type="hidden" name="txtmat" value="<?php echo $Mat; ?>"><br>
				<input type="hidden" name="mat_vend" value="<?php echo $Mat_Vend; ?>">
				<input type="hidden" name="vendedora" value="<?php echo $Vendedora; ?>">
				<input type="hidden" name="cliente" value="<?php echo $Cliente; ?>">
				<input type="hidden" name="idade" value="<?php echo $Idade; ?>">
				<input type="hidden" name="data_nasc" value="<?php echo $DataNasc; ?>">
				<p>
					<font size='6'><b>
							<center>Verifique se a impressora do <font color='gold'>
									<blink>Caixa</blink>
									<font color='#FFFFFF'> está ligada e com papel.
										<p>Logo após clique no <font color='gold'>
												<blink>botão abaixo</blink>
												<font color='#FFFFFF'>.</center>
						</b></font>
				</p><br>
				<center>
					<input id="ghost_click" type="submit" name="btimprime" value="Autenticar" autofocus>
				</center><br>
				<center>
					<font color='#FFFFFF' size='3'><span id="msg"></span></font>
				</center>
			</form><?php

				} else { ?>
			<font size='6'><b>
					<center>Senha <font color='gold'>
							<blink>Incorreta</blink><br>
							<font color='#FFFFFF'>ou<br>
								Usuário <font color='gold'>
									<blink>Não Autorizado</blink>
									<font color="#FFFFFF">!!!</center>
				</b></font><br>
			<center><a href='JavaScript:window.history.back()'><img src='images/voltar.gif'></a></center><br>
	<?php
				}
			}

			// Encerrando a Conexão
			$SisRot = "S-7.2.1.1.1";
			include "./rodape.php"; ?>

	<script src="./js/ghost_click.js"></script>

</body>

</html>