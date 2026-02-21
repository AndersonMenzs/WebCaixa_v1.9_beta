<?php

//debug
error_reporting(E_ALL);
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);

// Pesquisando PC
include "conexao.php";
include "dbselect.php";

// Inserindo Cabeçalho
include "../cabecprs.php";
include "./valor_ext.php";

?>
<html>

<body background="../images/bg1.jpg" text="#FFFFFF">

	<?php
	$dados = filter_input_array(INPUT_POST, FILTER_DEFAULT);
	echo "<pre>";
	var_dump($dados);
	echo "</pre>";
	//exit();

	// Importando os Dados do Formulário
	$Sis       = "S7";
	$Rot       = "S7R2.2.1.2";
	$lg_user   = trim($_POST['txtuser']);
	$user    = substr($lg_user, 0, 8);
	$pss     = substr($lg_user, 8, 40);
	$Aut       = trim($_POST['txtreg']);
	$AutFull = 10000 + $Aut;
	$Reg       = substr($AutFull, 1, 4);
	$PC		= trim($_POST['pc']);
	$Ref_Std   = trim($_POST['ref_std']);
	$NDoc      = trim($_POST['txtdoc']);
	$TipoRec   = trim($_POST['tiporec']);
	//$tipo = trim($_POST['tipo']);
	$dtRec     = trim($_POST['dtrec']);
	$aRec    = substr($dtRec, 2, 2);
	$mRec    = substr($dtRec, 5, 2);
	$dRec    = substr($dtRec, 8, 2);
	$dtAut     = $dRec . $mRec . $aRec;
	$FPag_1      = isset($_POST['lsPr1']) ? (trim($_POST['lsPr1']) == '00' ? '' : trim($_POST['lsPr1'])) : '';
	$FPag_2      = isset($_POST['lsPr2']) ? (trim($_POST['lsPr2']) == '00' ? '' : trim($_POST['lsPr2'])) : '';
	$FPag_3      = isset($_POST['lsPr3']) ? (trim($_POST['lsPr3']) == '00' ? '' : trim($_POST['lsPr3'])) : '';
	$txt1 = isset($_POST['txt1']) ? (float) trim($_POST['txt1']) : 0;
	$txt2 = isset($_POST['txt2']) ? (float) trim($_POST['txt2']) : 0;
	$txt3 = isset($_POST['txt3']) ? (float) trim($_POST['txt3']) : 0;
	$ModPag    = trim($_POST['modpag']);
	$hora      = trim($_POST['txthora']);
	$h1 = substr($hora, 0, 2);
	$h2 = substr($hora, 3, 2);
	$horaaut   = $h1 . $h2;
	$Mat       = trim($_POST['txtmat']);
	$Mat_Vend  = trim($_POST['mat_vend']);
	$Vendedora = trim($_POST['vendedora']);
	$Cliente   = trim($_POST['cliente']);
	$VrRec     = trim($_POST['vrrec']);
	$VrRecF    = number_format($VrRec, 2, ',', '.');
	$vlr_ext   = valorPorExtenso($VrRecF);
	$VrPrest   = trim($_POST['vrprest']);
	$PIni = trim($_POST['txtparc_ini']);
	$PUlt = trim($_POST['txtparc_ult']);
	$QtdParcPag = trim($_POST['qtdeparc']);
	$VrParcial = $_POST['vrparcial'];
	
	//echo "<pre>";
	//echo $Reg . " - " . $PC . " - " . $NDoc . " - " . $TipoRec . " - " . $FPag_1 . " - " . $FPag_2 . " - " . $FPag_3 . " - " . $ModPag . " - " . $txt1 . " - " . $txt2 . " - " . $txt3 . " - " . $VrRec . " - " . $VrParcial . " - " . $Mat . " - " . $Mat_Vend . " - " . $Vendedora . " - " . $Cliente . " - " . $VrRec . " - " . $VrPrest . " - " . $PIni . " - " . $PUlt . " - " . $QtdParcPag; 

	// Pesquisando PC
	include "conexao.php";
	include "dbselect.php";

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
	$tipo = "CONTR. PARCELADO";

	// Imprimindo o Registro da Spool
	$SqlSp = "select * from spool order by rec";
	$rsSp  = mysqli_query($conec, $SqlSp) or die("Não foi possível obter dados da spool");
	$lnSp  = mysqli_fetch_array($rsSp);
	$Num = $lnSp['rec'];
	$Spo = $lnSp['spo'];
	
	// Consulta SQL corrigida com parênteses
	$sqlFm = "SELECT siglapag FROM formapag WHERE codpag IN('$FPag_1', '$FPag_2', '$FPag_3') AND codpag <> '---'";
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
		$ModPag = " ";
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
	} elseif (in_array("CPL", $FmRec)) {
		$ModPag = "CART. CRED. PARC. LOJA";
		$FmRec_a = "CPL";
	}

	// Encerrando a Conexão
	mysqli_close($conec);

	$SisRot = "S-7.2.2.1.2";
	include "./rodape.php"; ?>

	<script>
		function imprimirERedirecionar() {
			// Monta a URL com os dados
			var url = './recibo_cntparc.php?tipo=<?php echo urlencode($tipo); ?>' +
				'&txtmat=<?php echo urlencode($Mat); ?>' +
				'&NDoc=<?php echo urlencode($NDoc); ?>' +
				'&Reg=<?php echo urlencode($Reg); ?>' +
				'&PC=<?php echo urlencode($PC); ?>' +
				'&Ref_Std=<?php echo urlencode($Ref_Std); ?>' +
				'&SgRec=<?php echo urlencode($SgRec); ?>' +
				'&PIni=<?php echo urlencode($PIni); ?>' +
				'&PUlt=<?php echo urlencode($PUlt); ?>' +
				'&FPag_1=<?php echo urlencode($FPag_1); ?>' +
				'&FPag_2=<?php echo urlencode($FPag_2); ?>' +
				'&FPag_3=<?php echo urlencode($FPag_3); ?>' +
				'&txt1=<?php echo urlencode($txt1); ?>' +
				'&txt2=<?php echo urlencode($txt2); ?>' +
				'&txt3=<?php echo urlencode($txt3); ?>' +
				'&ModPag=<?php echo urlencode($ModPag); ?>' +
				'&QtdParcPag=<?php echo urlencode($QtdParcPag); ?>' +
				'&VrPrest=<?php echo urlencode($VrPrest); ?>' +
				'&VrRec=<?php echo urlencode($VrRec); ?>' +
				'&FmRec=<?php echo urlencode($FmRec_a); ?>' +
				'&data=<?php echo urlencode($dtRec); ?>' +
				'&Vendedora=<?php echo urlencode($Vendedora); ?>' +
				'&mat_vend=<?php echo urlencode($Mat_Vend); ?>' +
				'&Cliente=<?php echo urlencode($Cliente); ?>' +
				'&vlr_ext=<?php echo urlencode($vlr_ext); ?>' +
				'&VrParcial=<?php echo urlencode($VrParcial); ?>' +
				'&horaaut=<?php echo urlencode($horaaut); ?>' +
				'&dtAut=<?php echo urlencode($dtAut); ?>';

				console.log(url);
			window.open(url, '_blank');
			setTimeout(function() {
				window.location.href = './servrec.php?c_s=<?php echo $lg_user; ?>';
			}, 1000);
		}
	</script>

	<script>
		// Chama a função de forma segura após o carregamento da página
		if (document.readyState === 'complete') {
			try { imprimirERedirecionar(); } catch (e) {}
		} else {
			window.addEventListener('load', function() { try { imprimirERedirecionar(); } catch (e) {} });
		}
	</script>

</body>

</html>