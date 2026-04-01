<?php

//Debug
//ini_set('error_log', 'php_errors.log');
?>

<html>

<body background="../images/bg1.jpg" text="#FFFFFF" onload="imprimirERedirecionar()">
	<?php

	// Inserindo Cabeçalho
	include "../cabecprs.php";
	include "./valor_ext.php";
	
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
	$Data = date('d/m/Y', strtotime($dtRec));
	$hora      = trim($_POST['txthora']);
	$h1 = substr($hora, 0, 2);
	$h2 = substr($hora, 3, 2);
	$horaaut   = $h1 . $h2;
	$VrEnt     = trim($_POST['txtvalor']);
	$VrEntr    = number_format($VrEnt, 2, ',', '');
	$Valor_ext    = valorPorExtenso($VrEntr);
	$DataAtual = date("Y-m-d");

	if (strlen($VrEnt) < 7) {
		$VrEntrF   = "R$ " . $VrEntr;
	} else {
		$VrEntrF   = "R$" . $VrEntr;
	}
	$Mat  = trim($_POST['txtmat']);

	// Pesquisando PC
	include "conexao.php";

	// COnsultando a Matrícula
	include "dblog.php";

	// Consultando
	$sql = "SELECT nome FROM pessoal WHERE mat = '$Mat'";
	$rs  = mysqli_query($conec, $sql) or die("Não foi possível acessar os Dados");
	$ln  = mysqli_fetch_array($rs);
	$Colab = $ln['nome'];

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
			if (count($FmRec) > 1) {
				$ModPag = "DIVERSOS";
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

	// Gravando a Spool
	include "dbselect.php";
	$sql = "insert into spool2 values ('$Aut1', '$AutR')";
	$rs  = mysqli_query($conec, $sql) or die("File via1est Error #1. Contate seu Administrador.");

	// Remover ponto do valor
	$VrEntrF = str_replace(",", "", $VrEntr);
	// Gerando código de autenticação
	$Aut = $Aut . $PC . $horaaut . $NDoc . " " . $dtAut . " R$ " . $VrEntrF . $TipoRec . $FmRec_a . $MatRec;
	?>

	<?php

	// Encerrando a Conexão	
	$SisRot = "S-7.4.1.2";
	include "rodape.php"; ?>

	<script>
		function imprimirERedirecionar() {
			// Monta a URL com os dados
			var url = './est_comprovante.php?aut=<?php echo urlencode($Aut); ?>' +
				'&PC=<?php echo urlencode($PC); ?>' +
				'&Aut=<?php echo urlencode($Aut); ?>' +
				'&ModPag=<?php echo urlencode($ModPag); ?>' +
				'&FmRec_a=<?php echo urlencode($FmRec_a); ?>' +
				'&Data=<?php echo urlencode($Data); ?>' +
				'&VrEntr=<?php echo urlencode($VrEntr); ?>' +
				'&Valor_ext=<?php echo urlencode($Valor_ext); ?>' +
				'&txtdoc=<?php echo urlencode($NDoc); ?>' +
				'&Ref_Std=<?php echo urlencode($Ref_Std); ?>' +
				'&Mat=<?php echo urlencode($Mat); ?>' +
				'&Colab=<?php echo urlencode($Colab); ?>';
			window.open(url, '_blank');
			setTimeout(function() {
				window.location.href = './index.php?c_s=<?php echo $lg_user; ?>';
			}, 1000);
		}
	</script>

</body>

</html>