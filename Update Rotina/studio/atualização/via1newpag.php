<html>

<head>
	<title>WebCaixa v1.20.9_beta</title>
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

	<script>
		function F5(event) {
			var tecla = document.all ? window.event.keyCode : event.which;
			if (document.all) {
				window.event.keyCode = 0;
				window.event.returnValue = false;
			}
			if (tecla == 116) return false;
		}

		document.onkeydown = F5;
	</script>

	<?php
	// Inserindo Cabeçalho
	include "../cabecprs.php";
	?>
</head>

<body background="../images/bg1.jpg" text="#FFFFFF" onload="imprimirERedirecionar()">
	<?php

	// Importando os Dados do Formulário
	$Sis       = "S7";
	$Rot       = "S7R3.1.2";
	$lg_user   = trim($_POST['txtuser']);
	$user    = substr($lg_user, 0, 8);
	$pss     = substr($lg_user, 8, 40);
	$Aut       = trim($_POST['txtreg']);
	$AutFull = 10000 + $Aut;
	$Reg       = substr($AutFull, 1, 4);
	$Cod       = trim($_POST['txtcod']);
	$Cod2      = trim($_POST['txtcod2']);
	$TipoDoc   = trim($_POST['tipodoc']);
	$TipoRec   = trim($_POST['tiporec']);
	$TipoDesp  = trim($_POST['txttipodesp']);
	$TipoRef = trim($_POST['tiporef']);
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
	$Valor     = trim($_POST['txtvalor']);
	$Valor_ext    = trim($_POST['txtvalor_ext']);
	$Vr	   = str_replace(".", "", $Valor);
	$VrF       = number_format($Valor, 2, ',', '.');
	$ValorF   = "R$ " . $VrF;
	$Mat       = trim($_POST['txtmat']);
	$FmRec  = "DIN";
	$UltDoc_ci = trim($_POST['ultdoc_ci']) ? trim($_POST['ultdoc_ci']) : "0";
	$UltDoc_rc = trim($_POST['ultdoc_rc']) ? trim($_POST['ultdoc_rc']) : "0";
	$UltDoc_md = trim($_POST['ultdoc_md']) ? trim($_POST['ultdoc_md']) : "0";
	$UltDoc_mp = trim($_POST['ultdoc_mp']) ? trim($_POST['ultdoc_mp']) : "0";
	$UltDoc_mc = trim($_POST['ultdoc_mc']) ? trim($_POST['ultdoc_mc']) : "0";
	$UltDoc_vt = trim($_POST['ultdoc_vt']) ? trim($_POST['ultdoc_vt']) : "0";
	$UltDoc_sp = trim($_POST['ultdoc_sp']) ? trim($_POST['ultdoc_sp']) : "0";
	$UltDoc_out = trim($_POST['ultdoc_out']) ? trim($_POST['ultdoc_out']) : "0";
	$colab		= trim($_POST['txtcolab']);
	$mat_vend	= trim($_POST['mat_vend']);
	$cliente	= trim($_POST['cliente']);
	$PC = trim($_POST['pc']);
	$Tes = "Tesouraria";
	$NomeDesc = trim($_POST['nomedesc']);

	// Formatando o número do documento cd CI2222600000 para CI-22226-00000
	$UltDoc_ci = substr($UltDoc_ci, 0, 2) . "-" . substr($UltDoc_ci, 2, 5) . "-" . substr($UltDoc_ci, 7);
	$UltDoc_rc = substr($UltDoc_rc, 0, 2) . "-" . substr($UltDoc_rc, 2, 5) . "-" . substr($UltDoc_rc, 7);
	$UltDoc_md = substr($UltDoc_md, 0, 2) . "-" . substr($UltDoc_md, 2, 5) . "-" . substr($UltDoc_md, 7);
	$UltDoc_mp = substr($UltDoc_mp, 0, 2) . "-" . substr($UltDoc_mp, 2, 5) . "-" . substr($UltDoc_mp, 7);
	$UltDoc_mc = substr($UltDoc_mc, 0, 2) . "-" . substr($UltDoc_mc, 2, 5) . "-" . substr($UltDoc_mc, 7);
	$UltDoc_vt = substr($UltDoc_vt, 0, 2) . "-" . substr($UltDoc_vt, 2, 5) . "-" . substr($UltDoc_vt, 7);
	$UltDoc_sp = substr($UltDoc_sp, 0, 2) . "-" . substr($UltDoc_sp, 2, 5) . "-" . substr($UltDoc_sp, 7);
	$UltDoc_out = substr($UltDoc_out, 0, 2) . "-" . substr($UltDoc_out, 2, 5) . "-" . substr($UltDoc_out, 7);

	// Pesquisando PC
	include "conexao.php";
	include "dbselect.php";

	$sqlPC = "select pc from inicial";
	$rsPC  = mysqli_query($conec, $sqlPC) or die("Erro de Banco de Dados #1. Contate seu Administrador.");
	$lnPC  = mysqli_fetch_array($rsPC);
	$PC  = $lnPC['pc'];

	// Obtendo o Tipo de Recebimento
	$sqlRec = "select siglapag from pgtos where codpag = '$TipoDesp' ";
	$rsRec = mysqli_query($conec, $sqlRec) or die("Erro de Banco de Dados #2. Contate seu Administrador.");
	$lnRec = mysqli_fetch_array($rsRec);
	$SgRec  = $lnRec['siglapag'];

	// Reduzindo a Matrícula
	$MatRec = substr($Mat, 1, 6) . "-" . substr($Mat, 7, 1); ?>

	<?php

	// Imprimindo Via Cliente
	$Aut1 = $Reg;
	if ($Cod2 == "") {
		$Aut2 = "$Reg$Cod $horaaut$dtAut $ValorF$SgRec$FmRec$MatRec";
	} else {
		$Aut2 = "$Reg$Cod$Cod2$horaaut$dtAut$ValorF$SgRec$MatRec";
	}

	// Remover hifen do $UltDoc_ci
	$UltDoc_ci_h = str_replace("-", "", $UltDoc_ci);
	$UltDoc_rc_h = str_replace("-", "", $UltDoc_rc);
	$UltDoc_mp_h = str_replace("-", "", $UltDoc_mp);
	$UltDoc_mc_h = str_replace("-", "", $UltDoc_mc);
	$UltDoc_vt_h = str_replace("-", "", $UltDoc_vt);
	$UltDoc_sp_h = str_replace("-", "", $UltDoc_sp);
	$UltDoc_out_h = str_replace("-", "", $UltDoc_out);

	// Gerando o código de autenticação
	if ($TipoDoc == 'CI') {
		$Aut = $Reg . $PC . $horaaut . $UltDoc_ci_h . " " . $dtAut . " R$ " . $Vr . $SgRec . $FmRec . $MatRec;
	} elseif ($TipoDoc == 'RC') {
		$Aut = $Reg . $PC . $horaaut . $UltDoc_rc_h . " " . $dtAut . " R$ " . $Vr . $SgRec . $FmRec . $MatRec;
	} elseif ($TipoDoc == 'MP') {
		$Aut = $Reg . $PC . $horaaut . $UltDoc_mp_h . " " . $dtAut . " R$ " . $Vr . $SgRec . $FmRec . $MatRec;
	} elseif ($TipoDoc == 'MC') {
		$Aut = $Reg . $PC . $horaaut . $UltDoc_mc_h . " " . $dtAut . " R$ " . $Vr . $SgRec . $FmRec . $MatRec;
	} elseif ($TipoDoc == 'MD') {
		$Aut = $Reg . $PC . $horaaut . $UltDoc_md_h . " " . $dtAut . " R$ " . $Vr  . $SgRec  . $FmRec  . $MatRec;
	} elseif ($TipoDoc == 'VT') {
		$Aut = $Reg . $PC . $horaaut . $UltDoc_vt_h . " " . $dtAut . " R$ " . $Vr  . $SgRec  . $FmRec  . $MatRec;
	} elseif ($TipoDoc == 'SP') {
		$Aut = $Reg . $PC . $horaaut . $UltDoc_sp_h . " " . $dtAut . " R$ " . $Vr  . $SgRec  . $FmRec  . $MatRec;
	} elseif ($TipoDoc == 'OUT') {
		$Aut = $Reg . $PC . $horaaut . $UltDoc_out_h . " " . $dtAut . " R$ " . $Vr  . $SgRec  . $FmRec  . $MatRec;
	}

	// Gravando a Spool
	$sql = "insert into spool values ('$Aut1', '$Aut2')";
	$rs  = mysqli_query($conec, $sql) or die("Erro de Banco de Dados #4. Contate seu Administrador.");

	// Gravando a Spool2
	$sql = "insert into spool2 values ('$Aut1', '$Aut2')";
	$rs  = mysqli_query($conec, $sql) or die("Erro de Banco de Dados #4. Contate seu Administrador.");

	// Encerrando a Conexão
	mysqli_free_result($rs);
	mysqli_free_result($rsPC);
	mysqli_free_result($rsRec);
	mysqli_free_result($rsApe);
	$SisRot = "S-7.3.1.2";
	include "rodape.php";


	// Redirecionando para a impressão ou para o servrec
	if ($TipoDesp == '1') {
	?>
		<script>
			function imprimirERedirecionar() {
				// Monta a URL com os dados
				var url = './ci_desp.php?tipo=<?php echo urlencode($tipo); ?>' +
					'&UlDoc_ci=<?php echo urlencode($UltDoc_ci); ?>' +
					'&Aut=<?php echo urlencode($Aut); ?>' +
					'&Data=<?php echo urlencode($Data); ?>' +
					'&PC=<?php echo urlencode($PC); ?>' +
					'&Tes=<?php echo urlencode($Tes); ?>' +
					'&Assunto=<?php echo urlencode($Assunto); ?>' +
					'&colab=<?php echo urlencode($colab); ?>' +
					'&mat_vend=<?php echo urlencode($mat_vend); ?>' +
					'&Valor=<?php echo urlencode($Valor); ?>' +
					'&Valor_ext=<?php echo urlencode($Valor_ext); ?>' +
					'&TipoRef=<?php echo urlencode($TipoRef); ?>';
				window.open(url, '_blank');
				setTimeout(function() {
					window.location.href = './index.php?c_s=<?php echo $lg_user; ?>';
				}, 1000);
			}
		</script>
	<?php
	}
	if ($TipoDesp == '5') {
	?>
		<script>
			function imprimirERedirecionar() {
				// Monta a URL com os dados
				var url = './rc_reemb.php?tipo=<?php echo urlencode($tipo); ?>' +
					'&UlDoc_rc=<?php echo urlencode($UltDoc_rc); ?>' +
					'&Aut=<?php echo urlencode($Aut); ?>' +
					'&Data=<?php echo urlencode($Data); ?>' +
					'&PC=<?php echo urlencode($PC); ?>' +
					'&Tes=<?php echo urlencode($Tes); ?>' +
					'&Assunto=<?php echo urlencode($Assunto); ?>' +
					'&mat_vend=<?php echo urlencode($mat_vend); ?>' +
					'&cliente=<?php echo urlencode($cliente); ?>' +
					'&Valor=<?php echo urlencode($Valor); ?>' +
					'&Valor_ext=<?php echo urlencode($Valor_ext); ?>' +
					'&TipoRef=<?php echo urlencode($TipoRef); ?>';
				window.open(url, '_blank');
				setTimeout(function() {
					window.location.href = './index.php?c_s=<?php echo $lg_user; ?>';
				}, 1000);
			}
		</script>
	<?php
	}
	if ($TipoDesp == '7') {
	?>
		<script>
			function imprimirERedirecionar() {
				// Monta a URL com os dados
				var url = './vt_trans.php?tipo=<?php echo urlencode($tipo); ?>' +
					'&UlDoc_vt=<?php echo urlencode($UltDoc_vt); ?>' +
					'&Aut=<?php echo urlencode($Aut); ?>' +
					'&Data=<?php echo urlencode($Data); ?>' +
					'&PC=<?php echo urlencode($PC); ?>' +
					'&Tes=<?php echo urlencode($Tes); ?>' +
					'&Assunto=<?php echo urlencode($Assunto); ?>' +
					'&colab=<?php echo urlencode($colab); ?>' +
					'&mat_vend=<?php echo urlencode($mat_vend); ?>' +
					'&Valor=<?php echo urlencode($Valor); ?>' +
					'&Valor_ext=<?php echo urlencode($Valor_ext); ?>' +
					'&TipoRef=<?php echo urlencode($TipoRef); ?>' +
					'&NomeDesc=<?php echo urlencode($NomeDesc); ?>';
				window.open(url, '_blank');
				setTimeout(function() {
					window.location.href = './index.php?c_s=<?php echo $lg_user; ?>';
				}, 1000);
			}
		</script>
	<?php
	}
	if ($TipoDesp == '6') {
	?>
		<script>
			function imprimirERedirecionar() {
				// Monta a URL com os dados
				var url = './serv_desp.php?tipo=<?php echo urlencode($tipo); ?>' +
					'&UlDoc_sp=<?php echo urlencode($UltDoc_sp); ?>' +
					'&Aut=<?php echo urlencode($Aut); ?>' +
					'&Data=<?php echo urlencode($Data); ?>' +
					'&PC=<?php echo urlencode($PC); ?>' +
					'&Tes=<?php echo urlencode($Tes); ?>' +
					'&Assunto=<?php echo urlencode($Assunto); ?>' +
					'&colab=<?php echo urlencode($colab); ?>' +
					'&mat_vend=<?php echo urlencode($mat_vend); ?>' +
					'&Valor=<?php echo urlencode($Valor); ?>' +
					'&Valor_ext=<?php echo urlencode($Valor_ext); ?>' +
					'&TipoRef=<?php echo urlencode($TipoRef); ?>' +
					'&NomeDesc=<?php echo urlencode($NomeDesc); ?>';
				window.open(url, '_blank');
				setTimeout(function() {
					window.location.href = './index.php?c_s=<?php echo $lg_user; ?>';
				}, 1000);
			}
		</script>
	<?php
	}
	if ($TipoDesp == '2' or $TipoDesp == '3' or $TipoDesp == '4' or $TipoDesp == '8') {
	?>
		<script>
			function imprimirERedirecionar() {
				// Monta a URL com os dados
				var url = './mcdpo_desp.php?tipo=<?php echo urlencode($tipo); ?>' +
					'&UlDoc_mcdpo=<?php echo urlencode(
						// Verifica que tipo de documento é para definir qual número de documento passar na URL
						$TipoDesp == '2' ? $UltDoc_mc : ($TipoDesp == '3' ? $UltDoc_md : ($TipoDesp == '4' ? $UltDoc_mp : ($TipoDesp == '8' ? $UltDoc_out : '')))	
					); ?>' +
					'&Aut=<?php echo urlencode($Aut); ?>' +
					'&Data=<?php echo urlencode($Data); ?>' +
					'&PC=<?php echo urlencode($PC); ?>' +
					'&Tes=<?php echo urlencode($Tes); ?>' +
					'&Assunto=<?php echo urlencode($Assunto); ?>' +
					'&colab=<?php echo urlencode($colab); ?>' +
					'&mat_vend=<?php echo urlencode($mat_vend); ?>' +
					'&Valor=<?php echo urlencode($Valor); ?>' +
					'&Valor_ext=<?php echo urlencode($Valor_ext); ?>' +
					'&TipoRef=<?php echo urlencode($TipoRef); ?>' +
					'&NomeDesc=<?php echo urlencode($NomeDesc); ?>';
				window.open(url, '_blank');
				setTimeout(function() {
					window.location.href = './index.php?c_s=<?php echo $lg_user; ?>';
				}, 1000);
			}
		</script>
	<?php
	}
	?>
</body>

</html>