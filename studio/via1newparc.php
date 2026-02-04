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
	$PC		= trim($_POST['pc']);
	$NDoc      = trim($_POST['txtdoc']);
	$TipoRec   = trim($_POST['tiporec']);
	$tipo = trim($_POST['tipo']);
	$dtRec     = trim($_POST['dtrec']);
	$aRec    = substr($dtRec, 2, 2);
	$mRec    = substr($dtRec, 5, 2);
	$dRec    = substr($dtRec, 8, 2);
	$dtAut     = $dRec . $mRec . $aRec;
	$FPag_1      = isset($_POST['lsPr1']) ? (trim($_POST['lsPr1']) == '00' ? '' : trim($_POST['lsPr1'])) : '';
	$txt1 = isset($_POST['txt1']) ? (float) trim($_POST['txt1']) : 0;
	$hora      = trim($_POST['txthora']);
	$h1 = substr($hora, 0, 2);
	$h2 = substr($hora, 3, 2);
	$horaaut   = $h1 . $h2;
	$Mat       = trim($_POST['txtmat']);
	$Vendedora = trim($_POST['vendedora']);
	$Cliente   = trim($_POST['cliente']);
	$VrPag     = $txt1;
	$VrPagF    = number_format($VrPag, 2, ',', '.');
	$vlr_ext   = valorPorExtenso($VrPagF);
	$ParcUlt   = trim($_POST['txtparc']);
	$vlrParc   = valorPorExtenso(number_format($ParcUlt, 2, ',', '.'));
	$PIni = trim($_POST['txtparc_ini']);
	$PUlt = trim($_POST['txtparc_ult']);
	$QtdParcPag = trim($_POST['qtdeparc']);
	$Parcial = trim($_POST['parcial']);
	$ParcialF = number_format($Parcial, 2, ',', '.');

	// Pesquisando PC
	include "conexao.php";
	include "dbselect.php";

	// Obtendo o código do PC
	$sqlPC = "select pc from inicial";
	$rsPC  = mysqli_query($conec, $sqlPC) or die("Não foi possível acessar o PC");
	$lnPC  = mysqli_fetch_array($rsPC);
	$PC  = $lnPC['pc'];

	// Imprimindo o Registro da Spool
	$SqlSp = "select * from spool order by rec";
	$rsSp  = mysqli_query($conec, $SqlSp) or die("Não foi possível obter dados da spool");
	$lnSp  = mysqli_fetch_array($rsSp);
	$Num = $lnSp['rec'];
	$Spo = $lnSp['spo'];

	// Encerrando a Conexão
	mysqli_close($conec);

	$SisRot = "S-7.2.2.1.2";
	include "./rodape.php"; ?>

	<script>
		function imprimirERedirecionar() {
			// Monta a URL com os dados
			var url = './recibo_cntparc.php?tipo=<?php echo urlencode($tipo); ?>' +
				'&NDoc=<?php echo urlencode($NDoc); ?>' +
				'&PC=<?php echo urlencode($PC); ?>' +
				'&PIni=<?php echo urlencode($PIni); ?>' +
				'&PUlt=<?php echo urlencode($PUlt); ?>' +
				'&QtdParcPag=<?php echo urlencode($QtdParcPag); ?>' +
				'&TaxaConc=<?php echo urlencode($VrPag); ?>' +
				'&TaxaConcF=<?php echo urlencode($VrPagF); ?>' +
				'&fpag_1=<?php echo urlencode($FPag_1); ?>' +
				'&txt1=<?php echo urlencode($txt1); ?>' +
				'&data=<?php echo urlencode($dtRec); ?>' +
				'&Vendedora=<?php echo urlencode($Vendedora); ?>' +
				'&Mat=<?php echo urlencode($Mat); ?>' +
				'&Cliente=<?php echo urlencode($Cliente); ?>' +
				'&vlr_ext=<?php echo urlencode($vlr_ext); ?>' +
				'&ParcUlt=<?php echo urlencode($ParcUlt); ?>' +
				'&vlrParc_ext=<?php echo urlencode($vlrParc); ?>' +
				'&Parcial=<?php echo urlencode($ParcialF); ?>' +
				'&Reg=<?php echo urlencode($Reg); ?>' +
				'&horaaut=<?php echo urlencode($horaaut); ?>' +
				'&dtAut=<?php echo urlencode($dtAut); ?>';
			window.open(url, '_blank');
			/*setTimeout(function() {
				window.location.href = './servrec.php?c_s=<?php echo $lg_user; ?>';
			}, 1000);*/
		}
	</script>

</body>

</html>