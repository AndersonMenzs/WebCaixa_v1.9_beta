<?php

//Debug
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
?>

<html>

<head>
	<title>WebCaixa v1.19_beta</title>
	<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
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
	// Importando os Dados do Formulário
	$Sis       = "S7";
	$Rot       = "S7R4.1.2";
	$lg_user   = trim($_POST['txtuser']);
	$user    = substr($lg_user, 0, 8);
	$pss     = substr($lg_user, 8, 40);
	$Aut       = trim($_POST['txtaut']);
	$NDoc      = trim($_POST['txtdoc']);
	$TipoRec   = 'EST';
	$FPag      = trim($_POST['formapag']);
	$dtRec     = trim($_POST['dtrec']);
	$aRec    = substr($dtRec, 2, 2);
	$mRec    = substr($dtRec, 5, 2);
	$dRec    = substr($dtRec, 8, 2);
	$dtAut     = $dRec . $mRec . $aRec;
	$hora      = trim($_POST['txthora']);
	$h1 = substr($hora, 0, 2);
	$h2 = substr($hora, 3, 2);
	$horaaut   = $h1 . $h2;
	$VrEnt     = trim($_POST['txtvalor']);
	$VrEntr    = number_format($VrEnt, 2, ',', '');
	$DataAtual = date("Y-m-d");

	if (strlen($VrEnt) < 7) {
		$VrEntrF   = "R$ " . $VrEntr;
	} else {
		$VrEntrF   = "R$" . $VrEntr;
	}
	$Mat  = trim($_POST['txtmat']);

	// Pesquisando PC
	include "conexao.php";
	include "dbselect.php";

	$sqlPC = "select pc from inicial";
	$rsPC  = mysqli_query($conec, $sqlPC) or die("Não foi possível acessar o PC");
	$lnPC  = mysqli_fetch_array($rsPC);
	$PC  = $lnPC['pc'];

	$sql = "SELECT * FROM registro WHERE reg = '$Aut' AND datarec = '$DataAtual'";
	$rs = mysqli_query($conec, $sql) or die("Nao foi possivel acessar o Registro");
	$regs = mysqli_num_rows($rs);

	// Verfica se a forma de pagamento foi unica
	if ($regs == 1) {
		$ln = mysqli_fetch_assoc($rs);
		$FPag = $ln['modpgto'];

		$sqlFm = "SELECT siglapag FROM formapag WHERE codpag = '$FPag'";
		$rsFm  = mysqli_query($conec, $sqlFm) or die("Não foi possível acessar a Forma de Pagamento");
		$lnFm  = mysqli_fetch_assoc($rsFm);

		$FmRec = $lnFm['siglapag'];
	} elseif ($regs > 1) {
		// Quando há mais de uma forma de pagamento
		$FPag = array();

		while ($ln = mysqli_fetch_assoc($rs)) {
			$FPag[] = $ln['modpgto'];
		}

		// Remove duplicatas e valores inválidos
		$FPag = array_unique(array_filter($FPag, function ($v) {
			return $v != '' && $v != '---';
		}));

		// Monta a condição SQL dinamicamente
		if (!empty($FPag)) {
			$condicoes = array();
			foreach ($FPag as $cod) {
				$condicoes[] = "codpag = '$cod'";
			}
			$condicaoSQL = implode(' OR ', $condicoes);

			$sqlFm = "SELECT siglapag FROM formapag WHERE ($condicaoSQL)";
			$rsFm  = mysqli_query($conec, $sqlFm) or die("Não foi possível acessar a Forma de Pagamento");

			$FmRec = array();
			while ($lnFm = mysqli_fetch_assoc($rsFm)) {
				$FmRec[] = $lnFm['siglapag'];
			}

			// Remove duplicatas
			$FmRec = array_unique($FmRec);

			// Se tiver mais de uma forma, define como pagamento dividido

			// Se houver mais de uma forma diferente
			if (count($FmRec) > 1) {
				$FmRec_a = 'DIV';
			} elseif (in_array("DIN", $FmRec)) {
				$ModPag = "DINHEIRO";
				$FmRec_a = "DIN";
			} elseif (in_array("CTD", $FmRec)) {
				$ModPag = "CARTÃO DÉBITO";
				$FmRec_a = "CTD";
			} elseif (in_array("CTV", $FmRec)) {
				$ModPag = "CARTÃO CRÉDITO";
				$FmRec_a = "CTV";
			} elseif (in_array("PXQ", $FmRec)) {
				$ModPag = "PIX QR CODE";
				$FmRec_a = "PXQ";
			} elseif (in_array("PXC", $FmRec)) {
				$ModPag = "PIX CNPJ";
				$FmRec_a = "PXC";
			} elseif (in_array("GRT", $FmRec)) {
				$ModPag = "GRATUIDADE";
				$FmRec_a = "GRT";
			} elseif (in_array("CPL", $FmRec)) {
				$ModPag = "CARTÃO CRÉDITO PARCELADO (LOJA)";
				$FmRec_a = "CPL";
			}
		} else {
			$FmRec = '';
			$ModPag = '';
		}
	} else {
		// Nenhum registro encontrado
		$FmRec = '';
		$ModPag = '';
	}


	// Ajustando a Matrícula
	$MatRec = substr($Mat, 0, 7) . "-" . substr($Mat, 7, 1);
	$MatRdz = substr($Mat, 1, 6) . "-" . substr($Mat, 7, 1); ?>

	<font color="gold" size="6">
		<br><b>
			<center><u><i>Sistema de Autenticação</i></u></center>
		</b>
	</font>
	<?php

	// Imprimindo o Recibo
	$Aut1 = $Aut;
	$Aut2 = "$Aut$PC$horaaut$NDoc $dtAut$VrEntrF$TipoRec$FmRec_a$MatRec";
	$AutR = "$Aut$PC$horaaut$NDoc $dtAut$VrEntrF$TipoRec$FmRec_a$MatRdz";
	shell_exec("echo $Aut2 > /dev/lp0");

	// Gravando a Spool
	include "dbselect.php";
	$sql = "insert into spool2 values ('$Aut1', '$AutR')";
	$rs  = mysqli_query($conec, $sql) or die("File via1est Error #1. Contate seu Administrador.");

	// Preparando Ficha Cliente 
	?>
	<form name="via1entr" method="post" action="via3est.php">
		<input type="hidden" name="txtuser" value="<?php echo $lg_user; ?>">
		<input type="hidden" name="txtaut" value="<?php echo $Aut; ?>">
		<input type="hidden" name="txtpc" value="<?php echo $PC; ?>">
		<input type="hidden" name="horaaut" value="<?php echo $horaaut; ?>">
		<input type="hidden" name="txtdoc" value="<?php echo $NDoc; ?>">
		<input type="hidden" name="dtaut" value="<?php echo $dtAut; ?>">
		<input type="hidden" name="txtvalor" value="<?php echo $VrEnt; ?>">
		<input type="hidden" name="siglarec" value="<?php echo $TipoRec; ?>">
		<input type="hidden" name="formapag" value="<?php echo $FmRec_a; ?>">
		<input type="hidden" name="txtmat" value="<?php echo $MatRec; ?>">
		<br><br><br><br>
		<font size='6'><b>
				<center>Clique <font color='gold'>
						<blink>no Botão Abaixo</blink>
						<font color='#FFFFFF'> <br>
							<p>para <font color='gold'>
									<blink>Retornar</blink>
									<font color='#FFFFFF'> ao Menu Principal.</center>
			</b></font>
		</p><br>
		<center>
			<input id="ghost_click" type="submit" name="btimprime" value="Fim de Operação">
		</center><br>
		<center>
			<font color='#FFFFFF' size='3'><span id="msg"></span></font>
		</center>
	</form><?php

			// Encerrando a Conexão
			/* mysqli_free_result($rs);
			mysqli_free_result($rsPC);
			mysqli_free_result($rsRec);
			mysqli_free_result($rsFm);
			mysqli_free_result($rsApe); */
			$SisRot = "S-7.4.1.2";
			include "rodape.php"; ?>

	<script src="./js/ghost_click.js"></script>

</body>

</html>