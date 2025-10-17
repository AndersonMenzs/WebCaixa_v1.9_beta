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

	<?php
	// Inserindo Cabeçalho
	include "../cabecprs.php";
	?>
</head>

<body background="../images/bg1.jpg" text="#FFFFFF">
	<?php
	$dados = filter_input_array(INPUT_POST, FILTER_DEFAULT);
	 echo "<pre>";
	 var_dump($dados);
	 echo "</pre>";
	 exit;
	// Importando os Dados do Formulário
	$Sis       = "S7";
	$Rot       = "S7R2.5.1.1";
	$dtRec     = date('Y-m-d');
	$dtComp    = date('Y-m-d');
	$lg_user   = trim($_POST['txtuser']);
	$user    = substr($lg_user, 0, 8);
	$pss     = substr($lg_user, 8, 40);
	$NDoc      = trim($_POST['txtdoc']);
	$NDoc_a	= trim($_POST['txtdoc']);
	$FPag1     = trim($_POST['lsPr1']);
	$FPag2     = trim($_POST['lsPr2']);
	$FPag3     = trim($_POST['lsPr3']);
	$FPag4     = trim($_POST['lsPr4']);
	$txt1 = isset($_POST['txt1']) ? (float) trim($_POST['txt1']) : 0;
	$txt2 = isset($_POST['txt2']) ? (float) trim($_POST['txt2']) : 0;
	$txt3 = isset($_POST['txt3']) ? (float) trim($_POST['txt3']) : 0;
	$txt4 = isset($_POST['txt4']) ? (float) trim($_POST['txt4']) : 0;
	$Pass      = strtolower(trim($_POST['txtsen']));
	$Senha     = sha1($Pass);

	// Criando Variáveis
	$fps = 0;
	$TaxaConc  = $txt1 + $txt2 + $txt3 + $txt4;
	$TaxaConcF = number_format($TaxaConc, 2, ",", ".");
	$TipoRec   = '2';
	$SubTipo   = 'TXC';

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
	</font><br><br>
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

			if ($FPag1 <> "00") {
				$fps = $fps + 1;
				$sqlGr = "insert into registro values($Reg, '$NDoc', '$TipoRec', '$SubTipo', '$FPag1', '0', '$dtRec', '$hora', '$txt1', '$Mat', '')";
				$rsGr  = mysqli_query($conec, $sqlGr) or die("Erro de Banco de Dados #2. Contate seu Administrador.");
			}

			if ($FPag2 <> "00") {
				$fps = $fps + 1;
				$sqlGr = "insert into registro values($Reg, '$NDoc', '$TipoRec', '$SubTipo', '$FPag2', '0', '$dtRec', '$hora', '$txt2', '$Mat', '')";
				$rsGr  = mysqli_query($conec, $sqlGr) or die("Erro de Banco de Dados #5. Contate seu Administrador.");
			}

			if ($FPag3 <> "00") {
				$fps = $fps + 1;
				$sqlGr = "insert into registro values($Reg, '$NDoc', '$TipoRec', '$SubTipo', '$FPag3', '0', '$dtRec', '$hora', '$txt3', '$Mat', '')";
				$rsGr  = mysqli_query($conec, $sqlGr) or die("Erro de Banco de Dados #8. Contate seu Administrador.");
			}

			if ($FPag4 <> "00") {
				$fps = $fps + 1;
				$sqlGr = "insert into registro values($Reg, '$NDoc', '$TipoRec', '$SubTipo', '$FPag4', '0', '$dtRec', '$hora', '$txt4', '$Mat', '')";
				$rsGr  = mysqli_query($conec, $sqlGr) or die("Erro de Banco de Dados #10. Contate seu Administrador.");
			}

			// Preparando a Via Cliente
			if ($fps ==  1) {
				if ($FPag1 <> "00") {
					$FPag = $FPag1;
				} else if ($FPag2 <> "00") {
					$FPag = $FPag2;
				} else if ($FPag3 <> "00") {
					$FPag = $FPag3;
				} else {
					$FPag = $FPag4;
				}
			} else {
				$FPag = "05";
			}

			// Preparando a Via Cliente 
	?>
			<form name="geraconc" method="post" action="via1newconc.php">
				<input type="hidden" name="txtuser" value="<?php echo $lg_user; ?>">
				<input type="hidden" name="txtreg" value="<?php echo $Reg; ?>">
				<input type="hidden" name="tiporec" value="<?php echo $TipoRec; ?>">
				<input type="hidden" name="txtdoc" value="<?php echo $NDoc; ?>">
				<input type="hidden" name="formapag" value="<?php echo $FPag; ?>">
				<input type="hidden" name="dtrec" value="<?php echo $dtRec; ?>">
				<input type="hidden" name="txthora" value="<?php echo $hora; ?>">
				<input type="hidden" name="taxaconc" value="<?php echo $TaxaConcF; ?>">
				<input type="hidden" name="txtmat" value="<?php echo $Mat; ?>"><br>
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
					<input id="ghost_click" type="submit" name="btimprime" value="Autenticar">
				</center><br>
				<center>
					<font color='#FFFFFF' size='3'><span id="msg"></span></font>
				</center>
			</form>
		<?php

		} else { ?>
			<font size='6'><b>
					<center>Senha <font color='gold'>
							<blink>Incorreta</blink><br>
							<font color='#FFFFFF'>ou<br>
								Usuário <font color='gold'>
									<blink>Não Autorizado</blink>
									<font color='#FFFFFF'>!!!</center>
				</b></font><br>
			<center><a href='JavaScript:window.history.back()'><img src='images/voltar.gif'></a></center><br>
	<?php
		}
	}

	// Encerrando a Conexão
	/* mysqli_free_result($rso);
			mysqli_free_result($rsGr);
			mysqli_free_result($rsx); */
	$SisRot = "S-7.5.1.1.1";
	include "rodape.php"; ?>

	<script src="./js/ghost_click.js"></script>

</body>

</html>