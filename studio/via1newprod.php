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
	include "./valor_ext.php";
	?>
</head>

<body background="../images/bg1.jpg" text="#FFFFFF" onload="imprimirERedirecionar()">
	<?php

	// Importando os Dados do Formulário
	$Sis       = "S7";
	$Rot       = "S7R2.1.1.2";
	$lg_user   = trim($_POST['txtuser']);
	$user    = substr($lg_user, 0, 8);
	$pss     = substr($lg_user, 8, 40);
	$Aut       = trim($_POST['txtreg']);
	$AutFull = 10000 + $Aut;
	$Reg       = substr($AutFull, 1, 4);
	$RdTaxa    = trim($_POST['rdtaxa']);
	$NDoc      = trim($_POST['txtdoc']);
	$TipoRec   = trim($_POST['tiporec']);
	$TaxaProd  = trim($_POST['taxaprod']);
	$TaxaProdF = trim($_POST['taxaprodF']);
	$FPag      = trim($_POST['formapag']);
	$Fpag_1    = trim($_POST['lsPr1']);
	$Fpag_2    = trim($_POST['lsPr2']);
	$Fpag_3    = trim($_POST['lsPr3']);
	$txt1 = isset($_POST['txtvalor1']) ? (float) trim($_POST['txtvalor1']) : 0;
	$txt2 = isset($_POST['txtvalor2']) ? (float) trim($_POST['txtvalor2']) : 0;
	$txt3 = isset($_POST['txtvalor3']) ? (float) trim($_POST['txtvalor3']) : 0;
	$dtRec     = trim($_POST['dtrec']);
	$aRec    = substr($dtRec, 2, 2);
	$mRec    = substr($dtRec, 5, 2);
	$dRec    = substr($dtRec, 8, 2);
	$dtAut     = $dRec . $mRec . $aRec;
	$hora      = trim($_POST['txthora']);
	$h1 = substr($hora, 0, 2);
	$h2 = substr($hora, 3, 2);
	$horaaut   = $h1 . $h2;
	$Mat       = trim($_POST['txtmat']);
	$Vendedora = trim($_POST['vendedora']);
	$Cliente   = trim($_POST['cliente']);
	$DataNasc  = trim($_POST['data_nasc']);
	$Idade     = trim($_POST['idade']);
	$vlr_ext   = valorPorExtenso($TaxaProdF);

	// Pesquisando PC
	include "conexao.php";
	include "dbselect.php";

	// Obtendo o código do PC
	$sqlPC = "select pc from inicial";
	$rsPC  = mysqli_query($conec, $sqlPC) or die("Erro de Banco de Dados #1. Contate seu Administrador.");
	$lnPC  = mysqli_fetch_array($rsPC);
	$PC  = $lnPC['pc'];

	// Salvando Amizade Premiada
	if ($RdTaxa == "S") {
		$sqlAP = "insert into amizpre values('$NDoc', '$dtRec', $TaxaProd, '$Mat')";
		$rsAP  = mysqli_query($conec, $sqlAP) or die("Erro de Banco de Dados #2. Contate seu Administrador.");
	}

	// Obtendo o Tipo de Recebimento
	$sqlRec = "select siglarec from tiporec where codrec = '$TipoRec' ";
	$rsRec = mysqli_query($conec, $sqlRec) or die("Erro de Banco de Dados #3. Contate seu Administrador.");
	$lnRec = mysqli_fetch_array($rsRec);
	$SgRec  = $lnRec['siglarec'];
	$tipo = "TAXA PRODUÇÃO";

	// Obtendo a Forma de Recebimento
	$sqlFm = "select siglapag from formapag where codpag = '$FPag' ";
	$rsFm  = mysqli_query($conec, $sqlFm) or die("Erro de Banco de Dados #4. Contate seu Administrador.");
	$lnFm  = mysqli_fetch_array($rsFm);
	$FmRec  = $lnFm['siglapag'];

	//if ($FmRec == "") {
	//	$FmRec = "DIV";
	//}

	// Reduzindo a Matrícula
	$MatRec = substr($Mat, 1, 6) . "-" . substr($Mat, 7, 1);
	$Mat = substr($Mat, 0, 7) . "-" . substr($Mat, 7, 1);
	?>

	<font color="gold" size="6">
		<br><b>
			<center><u><i>Sistema de Autenticação</i></u></center>
		</b>
	</font><?php

			// Imprimindo Via Cliente
			$Aut1 = $Reg;
			$Aut2 = "$Reg$PC$horaaut$NDoc $dtAut" . "R$ " . "$TaxaProdF$SgRec$FmRec$MatRec";
			//shell_exec("echo $Aut2 > /dev/lp0");

			// Remover ponto do valor
			$TaxaProd = str_replace('.', '', $TaxaProd);

			// Condição para forma de pagamento
			if ($FmRec == "DIN") {
				$ModPag = "DINHEIRO";
			} elseif ($FmRec == "CTD") {
				$ModPag = "CARTÃO DÉBITO";
			} elseif ($FmRec == "CTV") {
				$ModPag = "CARTÃO CRÉDITO";
			} elseif ($FmRec == "PXQ") {
				$ModPag = "PIX QR CODE";
			} elseif ($FmRec == "PXC") {
				$ModPag = "PIX CNPJ";
			}

			// Preparando Ficha Cliente 
			?>
	<br><br><br><br>
	<font size='6'><b>
			<center>Coloque a <font color='gold'>
					<blink>Segunda Via</blink>
					<font color='#FFFFFF'> na Autenticadora
						e <br>
						<p>Clique no <font color='gold'>
								<blink>botão Abaixo</blink>
								<font color='#FFFFFF'>.</center>
		</b></font>
	</p><br>
	<center>
		<input id="ghost_click" type="submit" name="btimprime" value="Autenticar">
	</center><br>
	<center>
		<font color='#FFFFFF' size='3'><span id="msg"></span></font>
	</center>
	<?php

	// Gravando a Spool
	include "dbselect.php";
	$sql = "insert into spool2 values ('$Aut1', '$Aut2')";
	$rs  = mysqli_query($conec, $sql) or die("Erro de Banco de Dados #5. Contate seu Administrador.");

	$SisRot = "S-7.2.1.1.2";
	include "./rodape.php"; ?>

	<script src="./js/ghost_click.js"></script>
	<script>
		function imprimirERedirecionar() {
			// Monta a URL com os dados
			var url = './recibo_taxaprod.php?tipo=<?php echo urlencode($tipo); ?>' +
				'&NDoc=<?php echo urlencode($NDoc); ?>' +
				'&PC=<?php echo urlencode($PC); ?>' +
				'&TaxaProdF=<?php echo urlencode($TaxaProdF); ?>' +
				'&ModPag=<?php echo urlencode($ModPag); ?>' +
				'&fpag_1=<?php echo urlencode($FPag_1); ?>' +
				'&fpag_2=<?php echo urlencode($FPag_2); ?>' +
				'&fpag_3=<?php echo urlencode($FPag_3); ?>' +
				'&txt1=<?php echo urlencode($txt1); ?>' +
				'&txt2=<?php echo urlencode($txt2); ?>' +
				'&txt3=<?php echo urlencode($txt3); ?>' +
				'&data=<?php echo urlencode($dtRec); ?>' +
				'&Vendedora=<?php echo urlencode($Vendedora); ?>' +
				'&Cliente=<?php echo urlencode($Cliente); ?>' +
				'&vlr_ext=<?php echo urlencode($vlr_ext); ?>' +
				'&Reg=<?php echo urlencode($Reg); ?>' +
				'&horaaut=<?php echo urlencode($horaaut); ?>' +
				'&dtAut=<?php echo urlencode($dtAut); ?>' +
				'&SgRec=<?php echo urlencode($SgRec); ?>' +
				'&VrEnt=<?php echo urlencode($VrEnt); ?>' +
				'&Mat=<?php echo urlencode($Mat); ?>';
			window.open(url, '_blank');
			setTimeout(function() {
				window.location.href = './servrec.php?c_s=<?php echo $lg_user; ?>';
			}, 1000);
		}
	</script>

</body>

</html>