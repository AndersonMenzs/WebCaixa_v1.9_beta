<?php

// Pesquisando PC
include "conexao.php";
include "dbselect.php";

// Inserindo Cabeçalho
include "../cabecprs.php";
include "./valor_ext.php";

?>
<html>

<body background="../images/bg1.jpg" text="#FFFFFF" onload="imprimirERedirecionar()">
	<?php
	// Importando os Dados do Formulário
	$Sis       = "S7";
	$Rot       = "S7R2.2.1.2";
	$lg_user   = trim($_POST['txtuser']);
	$user    = substr($lg_user, 0, 8);
	$pss     = substr($lg_user, 8, 40);
	$Aut       = trim($_POST['txtreg']);
	$AutFull = 10000 + $Aut;
	$Reg       = substr($AutFull, 1, 4);
	$NDoc      = trim($_POST['txtdoc']);
	$TipoRec   = trim($_POST['tiporec']);
	$FPag_1      = isset($_POST['lsPr1']) ? (trim($_POST['lsPr1']) == '00' ? '' : trim($_POST['lsPr1'])) : '';
	$FPag_2      = isset($_POST['lsPr2']) ? (trim($_POST['lsPr2']) == '00' ? '' : trim($_POST['lsPr2'])) : '';
	$FPag_3      = isset($_POST['lsPr3']) ? (trim($_POST['lsPr3']) == '00' ? '' : trim($_POST['lsPr3'])) : '';
	$dtRec     = trim($_POST['dtrec']);
	$aRec    = substr($dtRec, 2, 2);
	$mRec    = substr($dtRec, 5, 2);
	$dRec    = substr($dtRec, 8, 2);
	$dtAut     = $dRec . $mRec . $aRec;
	$hora      = trim($_POST['txthora']);
	$h1 = substr($hora, 0, 2);
	$h2 = substr($hora, 3, 2);
	$horaaut   = $h1 . $h2;
	$txt1 = isset($_POST['txtvalor1']) ? (float) trim($_POST['txtvalor1']) : 0;
	$txt2 = isset($_POST['txtvalor2']) ? (float) trim($_POST['txtvalor2']) : 0;
	$txt3 = isset($_POST['txtvalor3']) ? (float) trim($_POST['txtvalor3']) : 0;
	$VrEnt	 = $txt1 + $txt2 + $txt3;
	$VrEntr    = number_format($VrEnt, 2, ',', '.');
	$VrEntrF   = $VrEntr;
	$Mat       = trim($_POST['txtmat']);
	$Vendedora = trim($_POST['vendedora']);
	$Cliente   = trim($_POST['cliente']);
	$vlr_ext   = valorPorExtenso($VrEntr);

	// Obtendo o código do PC
	$sqlPC = "select pc from inicial";
	$rsPC  = mysqli_query($conec, $sqlPC) or die("Não foi possível acessar o PC");
	$lnPC  = mysqli_fetch_array($rsPC);
	$PC  = $lnPC['pc'];

	// Obtendo o Tipo de Recebimento
	$sqlRec = "select siglarec from tiporec where codrec = '$TipoRec' ";
	$rsRec = mysqli_query($conec, $sqlRec) or die("Não foi possível acessar o Tipo de Recebimento");
	$lnRec = mysqli_fetch_array($rsRec);
	$SgRec  = $lnRec['siglarec'];
	$tipo = "PROP. ENTRADA";

	// Consulta SQL corrigida com parênteses
	$sqlFm = "SELECT siglapag FROM formapag WHERE (codpag = '$FPag_1' OR codpag = '$FPag_2' OR codpag = '$FPag_3') AND codpag <> '---'";
	$rsFm = mysqli_query($conec, $sqlFm) or die("Não foi possível acessar o Forma de Pagamento");

	$FmRec = [];

	while ($lnFm = mysqli_fetch_assoc($rsFm)) {
		$FmRec[] = $lnFm['siglapag'];
	}

	// Remove duplicatas, caso existam
	$FmRec = array_unique($FmRec);

	// Define o modo de pagamento
	$ModPag = '';
	$FmRec_a = '';

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
	}

	// Reduzindo a Matrícula
	$MatRec = substr($Mat, 1, 6) . "-" . substr($Mat, 7, 1);
	$Mat = substr($Mat, 0, 7) . "-" . substr($Mat, 7, 1);

	// Imprimindo Via Cliente
	$Aut1 = $Reg;
	$Aut2 = "$Reg$PC$horaaut$NDoc $dtAut$VrEntrF$SgRec$FmRec_a$MatRec";

	// Remover ponto do valor
	$VrEnt = str_replace('.', '', $VrEnt);

	// Gravando a Spool
	include "dbselect.php";
	$sql = "insert into spool2 values ('$Aut1', '$Aut2')";
	$rs  = mysqli_query($conec, $sql) or die("Não foi possível gravar a Spool");

	$SisRot = "S-7.2.2.1.2";
	include "./rodape.php";

	?>

	<script>
		function imprimirERedirecionar() {
			// Monta a URL com os dados
			var url = './recibo_propentr.php?tipo=<?php echo urlencode($tipo); ?>' +
				'&NDoc=<?php echo urlencode($NDoc); ?>' +
				'&PC=<?php echo urlencode($PC); ?>' +
				'&VrEntrF=<?php echo urlencode($VrEntrF); ?>' +
				'&ModPag=<?php echo urlencode($ModPag); ?>' +
				'&fpag_1=<?php echo urlencode($FPag_1); ?>' +
				'&fpag_2=<?php echo urlencode($FPag_2); ?>' +
				'&fpag_3=<?php echo urlencode($FPag_3); ?>' +
				'&fmrec=<?php echo urlencode($FmRec_a); ?>' +
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