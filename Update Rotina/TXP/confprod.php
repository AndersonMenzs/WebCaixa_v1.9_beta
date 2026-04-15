<html>

<head>
	<title>WebCaixa v1.20.0_beta</title>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
	<style type="text/css">
		body {
			margin-top: 3%;
			margin-left: 3%;
			margin-right: 3%;
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
		function putFocus(formInst, elementInst) {
			if (document.forms.length > 0) {
				document.forms[formInst].elements[elementInst].focus();
			}
		}
	</script>

	<?php
	// Inserindo Cabeçalho
	include "../cabecprs.php";
	?>
</head>

<body background="../images/bg1.jpg" text="#FFFFFF" onLoad="putFocus(0,0)">

	<?php

	// Importando os Dados do Formulário
	$Sis       = "S7";
	$Rot       = "S7R2.1.1";
	$lg_user   = trim($_POST['txtuser']);
	$user    = substr($lg_user, 0, 8);
	$pss     = substr($lg_user, 8, 40);
	$NumDoc    = trim($_POST['txtdoc']);
	$NumDocF = 100000000 + $NumDoc;
	$NDoc      = substr($NumDocF, 1, 8);
	$RdTaxa    = trim($_POST['rdtaxa']);
	$VrProd    = trim($_POST['txtvrprod']);
	$VrProdF = number_format($VrProd, 2, ",", ".");
	$FPag_1     = trim($_POST['lsPr1']);
	$FPag_2     = trim($_POST['lsPr2']);
	$FPag_3     = trim($_POST['lsPr3']);
	$txt1 = isset($_POST['txt1']) ? (float) trim($_POST['txt1']) : 0;
	$txt2 = isset($_POST['txt2']) ? (float) trim($_POST['txt2']) : '';
	$txt3 = isset($_POST['txt3']) ? (float) trim($_POST['txt3']) : '';
	$Mat_Vend = trim($_POST['mat_vend']);
	$Vendedora = trim($_POST['vendedora']);
	$Cliente	= trim($_POST['cliente']);
	$DataNasc	= trim($_POST['data_nasc']);
	$TaxaProd  = $txt1 + $txt2 + $txt3;
	$TaxaProdF = number_format($TaxaProd, 2, ",", ".");
	$Regula    = trim($_POST['regula']);
	$Senior    = trim($_POST['senior']);
	$Aghata    = trim($_POST['aghata']);
	$Gratuidade = true;

	// Calculando quantos anos tem
	$partes = explode('/', $DataNasc);
	$dia = $partes[0];
	$mes = $partes[1];
	$ano = $partes[2];

	$Idade = date('Y') - $ano;
	if (date('md') < $mes . $dia) {
		$Idade--;
	}

	include "conexao.php";
	include "dbselect.php";
	include "config.php";

	// Contando Formas de Pagamento
	$FsPags = 0;

	if ($txt1 <> "" or $txt1 == 0) {
		$FsPags = $FsPags + 1;
	}

	if ($txt2 <> "") {
		$FsPags = $FsPags + 1;
	}

	if ($txt3 <> "") {
		$FsPags = $FsPags + 1;
	}

	if ($FsPags == 1) {
		if ($txt1 <> "" or $txt1 == 0) {
			$FPag = $FPag_1;
			$sql = "select * from formapag where codpag = '$FPag' ";
			$rs  = mysqli_query($conec, $sql);
			$ln  = mysqli_fetch_array($rs);
			$ModPag = $ln['modpag'];
			mysqli_free_result($rs);
		} else if ($txt2 <> "") {
			$FPag = $FPag_2;
			$sql = "select * from formapag where codpag = '$FPag' ";
			$rs  = mysqli_query($conec, $sql);
			$ln  = mysqli_fetch_array($rs);
			$ModPag = $ln['modpag'];
			mysqli_free_result($rs);
		} else if ($txt3 <> "") {
			$FPag = $FPag_3;
			$sql = "select * from formapag where codpag = '$FPag' ";
			$rs  = mysqli_query($conec, $sql);
			$ln  = mysqli_fetch_array($rs);
			$ModPag = $ln['modpag'];
			mysqli_free_result($rs);
		}
	} else {
		$ModPag = "Diversas";
	} ?>

	<font color="gold" size="6">
		<br><b>
			<center><u><i>Recebimento da Taxa de Produção</i></u></center>
		</b>
	</font>
	<br>
	<?php
	// Verificando se a cliente é maior que 60 anos
	if ($Gratuidade && $Regula == 'gratuidade') {
		$Regula = 'Cliente Sênior';
	?>
		<center>
			<font color='lime' size='7'>
				<b>
					<i>Cliente Sênior</i>
				</b>
			</font>
		</center>
	<?php
	} elseif ($Gratuidade && $Regula == 'aghata') {
		$Regula = 'Cliente Aghata';
	?>
		<center>
			<font color='lime' size='7'>
				<b>
					<i>Cliente Mulher Aghata</i>
				</b>
			</font>
		</center>
	<?php
	} elseif ($Gratuidade && $Regula == 'rev_estrella') {
		$Regula = 'Cliente Revelação Estrella';
	?>
		<center>
			<font color='lime' size='7'>
				<b>
					<i>Cliente Revelação Estrella</i>
				</b>
			</font>
		</center>
	<?php
	}
	?>
	<br>
	<?php

	include "us_sist.php";
	if ($ch == 'no') {
		include "us_cad.php";
	}

	if ($ch == 'ok-enc' or $ch == 'ok-cai' or $ch == 'ok') { ?>
		<table width="70%" border="5" cellpadding="10" cellspacing="0" align="center">
			<form name="confentr" method="post" action="geraprod.php" OnSubmit="JavaScript:return checkdata()">
				<tr>
					<td width="30%" align="center">
						<font color='gold' size='5'><b><i>Nº Documento</i></b></font>
					</td>
					<td width="70%" align="center">
						<font color='#FFFFFF' size='5'><b><i><?php echo $NDoc; ?></i></b></font>
					</td>
				</tr>

				<tr>
					<td width="30%" align="center">
						<font color='gold' size='5'><b><i>Taxa de Produção</i></b></font>
					</td>
					<td width="70%" align="center">
						<font color='#FFFFFF' size='5'><b><i>R$ <?php echo $TaxaProdF; ?></i></b></font>
					</td>
				</tr>

				<tr>
					<td width="30%" align="center">
						<font color='gold' size='5'><b><i>Forma de Pagamento</i></b></font>
					</td>
					<td width="70%" align="center">
						<font size='6'><b><i><?php echo $ModPag; ?></i></b></font>
					</td>
				</tr>

				<tr>
					<td width="30%" align="center">
						<font color='gold' size='5'><b><i>Senha</i></b></font>
					</td>
					<td width="70%" align="center">
						<input type='password' name='txtsen' size='6' maxlength='6' class="campos">
					</td>
				</tr>
		</table>

		<input type="hidden" name="txtuser" value="<?php echo $lg_user; ?>">
		<input type="hidden" name="txtdoc" value="<?php echo $NDoc; ?>">
		<input type="hidden" name="rdtaxa" value="<?php echo $RdTaxa; ?>">
		<input type="hidden" name="txtvrprod" value="<?php echo $VrProd; ?>">
		<input type="hidden" name="txtvrprodF" value="<?php echo $VrProdF; ?>">
		<input type="hidden" name="txttaxa" value="<?php echo $TaxaProdF; ?>">
		<input type="hidden" name="lsPr1" value="<?php echo $FPag_1; ?>">
		<input type="hidden" name="lsPr2" value="<?php echo $FPag_2; ?>">
		<input type="hidden" name="lsPr3" value="<?php echo $FPag_3; ?>">
		<input type="hidden" name="txt1" value="<?php echo $txt1; ?>">
		<input type="hidden" name="txt2" value="<?php echo $txt2; ?>">
		<input type="hidden" name="txt3" value="<?php echo $txt3; ?>">
		<input type="hidden" name="data_nasc" value="<?php echo $DataNasc; ?>">
		<input type="hidden" name="idade" value="<?php echo $Idade; ?>">
		<input type="hidden" name="mat_vend" value="<?php echo $Mat_Vend; ?>">
		<input type="hidden" name="vendedora" value="<?php echo $Vendedora; ?>">
		<input type="hidden" name="cliente" value="<?php echo $Cliente; ?>">
		<input type="hidden" name="regula" value="<?php echo $Regula; ?>">
		<input type="hidden" name="senior" value="<?php echo $Senior; ?>">
		<input type="hidden" name="aghata" value="<?php echo $Aghata; ?>">
		<p>
			<center>
				<input id="ghost_click" type="submit" name="btenvia" value="Continuar">
				<input type="button" name="btret" value="Retornar" OnClick="JavaScript:window.history.back()">
			</center>
		</p>
		<center>
			<font color='#FFFFFF' size='3'><span id="msg"></span></font>
		</center>
		</form><?php
			} else { ?>
		<br><br><br><br><br>
		<font size='6'><b>
				<center>Acesso <font color='gold'>
						<blink>
							<u>não Autorizado</u>
						</blink>
						<font color='#FFFFFF'>!!!</center>
			</b></font><br><br><br>
		<center><a href='servrec.php?c_s=<?php echo $lg_user; ?>'><img src='images/voltar.gif'></a></center><br><br>
	<?php
			}

			// Encerrando
			$SisRot = "S-7.2.1.1";
			include "./rodape.php";
	?>

	<script src="./js/ghost_click.js"></script>

</body>

</html>