<?php
include "conexao.php";
include "dbselect.php";
include "./valor_ext.php";
include "../cabecprs.php";
?>
<html>

<head>
	<title>WebCaixa v1.20.21_beta</title>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
</head>

<body background="../images/bg1.jpg" text="#FFFFFF" onload="imprimirERedirecionar()">
	<?php
	$Sis = "S7";
	$Rot = "S7R2.1.1.2";
	$lg_user = isset($_POST['txtuser']) ? trim($_POST['txtuser']) : '';
	$user = substr($lg_user, 0, 8);
	$Aut = isset($_POST['txtreg']) ? (int) trim($_POST['txtreg']) : 0;
	$AutFull = 10000 + $Aut;
	$Reg = substr((string) $AutFull, 1, 4);
	$TipoRec = isset($_POST['tiporec']) ? trim($_POST['tiporec']) : '10';
	$NDoc = isset($_POST['txtdoc']) ? trim($_POST['txtdoc']) : '';
	$dtRec = isset($_POST['dtrec']) ? trim($_POST['dtrec']) : date('Y-m-d');
	$hora = isset($_POST['txthora']) ? trim($_POST['txthora']) : date('H:i');
	$Mat = isset($_POST['txtmat']) ? trim($_POST['txtmat']) : '';
	$Mat_Vend = isset($_POST['mat_vend']) ? trim($_POST['mat_vend']) : '';
	$Vendedora = isset($_POST['vendedora']) ? trim($_POST['vendedora']) : '';
	$Cliente = isset($_POST['cliente']) ? trim($_POST['cliente']) : '';
	$CodBrinde = isset($_POST['cod_brinde']) ? trim($_POST['cod_brinde']) : '';
	$NomeBrinde = isset($_POST['nome_brinde']) ? trim($_POST['nome_brinde']) : '';

	include "valida_caixa.php";
	bloquear_se_caixa_anterior_aberto($conec, $lg_user);

	$sqlPC = "SELECT pc FROM inicial LIMIT 1";
	$rsPC = mysqli_query($conec, $sqlPC) or die("Erro de Banco de Dados #1. Contate seu Administrador.");
	$lnPC = mysqli_fetch_assoc($rsPC);
	mysqli_free_result($rsPC);
	$PC = $lnPC ? $lnPC['pc'] : '';

	$tipoRecEsc = mysqli_real_escape_string($conec, $TipoRec);
	$sqlRec = "SELECT siglarec FROM tiporec WHERE codrec = '$tipoRecEsc' LIMIT 1";
	$rsRec = mysqli_query($conec, $sqlRec) or die("Erro de Banco de Dados #2. Contate seu Administrador.");
	$lnRec = mysqli_fetch_assoc($rsRec);
	mysqli_free_result($rsRec);
	$SgRec = $lnRec ? $lnRec['siglarec'] : 'GRT';

	$aRec = substr($dtRec, 2, 2);
	$mRec = substr($dtRec, 5, 2);
	$dRec = substr($dtRec, 8, 2);
	$dtAut = $dRec . $mRec . $aRec;
	$horaaut = str_replace(':', '', $hora);

	// Reduzindo a Matrícula
	$MatRec = substr($Mat, 0, 7) . "-" . substr($Mat, 7, 1);
	$Mat = substr($Mat, 0, 7) . "-" . substr($Mat, 7, 1);
	
	$TaxaProdF = '0,00';
	$VrProdA = '000';
	$vlr_ext = valorPorExtenso($TaxaProdF);

	$Aut1 = mysqli_real_escape_string($conec, $Reg);
	$Aut2 = mysqli_real_escape_string(
		$conec,
		"$Reg$PC$horaaut$NDoc $dtAut" . "R$ " . "$TaxaProdF$SgRec BRIN$MatRec"
	);

	mysqli_query($conec, "INSERT INTO spool VALUES ('$Aut1', '$Aut2')") or die("Erro de Banco de Dados #3. Contate seu Administrador.");
	mysqli_query($conec, "INSERT INTO spool2 VALUES ('$Aut1', '$Aut2')") or die("Erro de Banco de Dados #4. Contate seu Administrador.");

	$SisRot = "S-7.2.1.1.2";
	include "./rodape.php";
	mysqli_close($conec);
	?>

	<script>
		function imprimirERedirecionar() {
			var url = './recibo_brinde.php?tipo=BRINDE' +
				'&NDoc=<?php echo urlencode($NDoc); ?>' +
				'&PC=<?php echo urlencode($PC); ?>' +
				'&Reg=<?php echo urlencode($Reg); ?>' +
				'&data=<?php echo urlencode($dtRec); ?>' +
				'&horaaut=<?php echo urlencode($horaaut); ?>' +
				'&dtAut=<?php echo urlencode($dtAut); ?>' +
				'&SgRec=<?php echo urlencode($SgRec); ?>' +
				'&Mat=<?php echo urlencode($Mat); ?>' +
				'&mat_vend=<?php echo urlencode($Mat_Vend); ?>' +
				'&Vendedora=<?php echo urlencode($Vendedora); ?>' +
				'&Cliente=<?php echo urlencode($Cliente); ?>' +
				'&Brinde=<?php echo urlencode($NomeBrinde); ?>' +
				'&vlr_ext=<?php echo urlencode($vlr_ext); ?>';

			window.open(url, '_blank');
			setTimeout(function() {
				window.location.href = './brindes.php?c_s=<?php echo urlencode($lg_user); ?>';
			}, 1000);
		}
	</script>
</body>

</html>