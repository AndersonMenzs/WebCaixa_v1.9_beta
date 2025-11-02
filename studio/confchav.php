<html>

<head>
	<title>WebCaixa v1.19_beta</title>
	<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
	<style type="text/css">
		body {
			margin-top: 3%;
			margin-left: 1%;
			margin-right: 1%;
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

	<script src="val_pgtotx.js" charset="utf-8"></script>

	<?php
	// Inserindo Cabeçalho
	include "../cabecprs.php";
	?>
</head>

<body background="../images/bg1.jpg" text="#FFFFFF" onLoad="putFocus(0,0)">
	<?php
	// Importando os Dados do Formulário
	$Sis       = "S7";
	$Rot       = "S7R2.5.1";
	$lg_user   = trim($_POST['txtuser']);
	$user    = substr($lg_user, 0, 8);
	$pss     = substr($lg_user, 8, 40);
	$NumDoc    = trim($_POST['txtdoc']);
	$NumDocF = 100000000 + $NumDoc;
	$NDoc      = substr($NumDocF, 1, 8);
	$Qtde	   = trim($_POST['qtde']);
	$TaxaChav  = trim($_POST['txtvrchav']);
	$TaxaChavF = number_format($TaxaChav, 2, ",", ".");
	$FPag1     = trim($_POST['lsPr1']);
	$FPag2     = trim($_POST['lsPr2']);
	$FPag3     = trim($_POST['lsPr3']);
	$txt1      = isset($_POST['txt1']) ? (float) trim($_POST['txt1']) : 0;
	$txt2      = isset($_POST['txt2']) ? (float) trim($_POST['txt2']) : 0;
	$txt3      = isset($_POST['txt3']) ? (float) trim($_POST['txt3']) : 0;
	$Mat_Vend = trim($_POST['mat_vend']);
	$Vendedora = trim($_POST['vendedora']);
	$Cliente	= trim($_POST['cliente']);
	$Pgto	   = $txt1 + $txt2 + $txt3;
	$PgtoF	   = number_format($Pgto, 2, ",", ".");

	include "conexao.php";
	include "dbselect.php";

	// Contando Formas de Pagamento
	$FsPags = 0;

	if ($txt1 <> "") {
		$FsPags = $FsPags + 1;
	}

	if ($txt2 <> "") {
		$FsPags = $FsPags + 1;
	}

	if ($txt3 <> "") {
		$FsPags = $FsPags + 1;
	}

	if ($FsPags == 1) {
		if ($txt1 <> "") {
			$FPag = $FPag1;
			$sql = "select * from formapag where codpag = '$FPag' ";
			$rs  = mysqli_query($conec, $sql);
			$ln  = mysqli_fetch_array($rs);
			$ModPag = $ln['modpag'];
			$FmRec  = $ln['siglapag'];
			mysqli_free_result($rs);
		} else if ($txt2 <> "") {
			$FPag = $FPag2;
			$sql = "select * from formapag where codpag = '$FPag' ";
			$rs  = mysqli_query($conec, $sql);
			$ln  = mysqli_fetch_array($rs);
			$ModPag = $ln['modpag'];
			$FmRec  = $ln['siglapag'];
			mysqli_free_result($rs);
		} else if ($txt3 <> "") {
			$FPag = $FPag3;
			$sql = "select * from formapag where codpag = '$FPag' ";
			$rs  = mysqli_query($conec, $sql);
			$ln  = mysqli_fetch_array($rs);
			$ModPag = $ln['modpag'];
			$FmRec  = $ln['siglapag'];
			mysqli_free_result($rs);
		}
	} else {
		$ModPag = "Diversas";
		$FmRec  = "DIV";
	}

	// Condição para nome em extensão para forma de pagamento
	if ($FmRec == "DIN") {
		$ModPag = "Dinheiro";
	} elseif ($FmRec == "CTD") {
		$ModPag = "Cartão Débito";
	} elseif ($FmRec == "CTV") {
		$ModPag = "Cartão Crédito";
	} elseif ($FmRec == "PXQ") {
		$ModPag = "Pix QR Code";
	} elseif ($FmRec == "PXC") {
		$ModPag = "Pix Cnpj";
	}

	?>

	<font color="gold" size="6">
		<br><b>
			<center><u><i>Recebimento da CHAVEIROS</i></u></center>
		</b>
	</font><br>
	<?php

	include "us_sist.php";
	if ($ch == 'no') {
		include "us_cad.php";
	}

	if ($ch == 'ok-enc' or $ch == 'ok-cai' or $ch == 'ok') { ?>
		<table width="70%" border="5" cellpadding="10" cellspacing="0" align="center">
			<form name="confentr" method="post" action="gerachav.php" onsubmit="return checkdata()">
				<tr>
					<td width="30%" align="center">
						<font color='gold' size='5'><b><i>Documento</font>
					</td>
					<td width="70%" align="center">
						<font color='#FFFFFF' size='5'><b><i><?php echo $NDoc; ?></i></b></font>
					</td>
				</tr>
				<tr>
					<td width="30%" align="center">
						<font color='gold' size='5'><b><i>Quantidade</font>
					</td>
					<td width="70%" align="center">
						<font color='#FFFFFF' size='5'><b><i><?php echo $Qtde; ?></i></b></font>
					</td>
				</tr>
				<tr>
					<td width="30%" align="center">
						<font color='gold' size='5'><b><i>Total</font>
					</td>
					<td width="70%" align="center">
						<font color='#FFFFFF' size='5'><b><i>R$ <?php echo $PgtoF; ?></i></b></font>
					</td>
				</tr>
				<tr>
					<td width="30%" align="center">
						<font color='gold' size='5'><b><i>Forma de Pagamento</font>
					</td>
					<td width="70%" align="center">
						<font color='#FFFFFF' size='5'><b><i><?php echo $ModPag; ?></i></b></font>
					</td>
				</tr>
				<tr>
					<td width="30%" align="center">
						<font color='gold' size='5'><b><i>Senha</font>
					</td>
					<td width="70%" align="center">
						<input type='password' name='txtsen' size='6' maxlength='6' class="campos">
					</td>
				</tr>
		</table>

		<input type="hidden" name="txtuser" value="<?php echo $lg_user; ?>">
		<input type="hidden" name="txtdoc" value="<?php echo $NDoc; ?>">
		<input type="hidden" name="lsPr1" value="<?php echo $FPag1; ?>">
		<input type="hidden" name="lsPr2" value="<?php echo $FPag2; ?>">
		<input type="hidden" name="lsPr3" value="<?php echo $FPag3; ?>">
		<input type="hidden" name="qtde" value="<?php echo $Qtde; ?>">
		<input type="hidden" name="txt1" value="<?php echo $txt1; ?>">
		<input type="hidden" name="txt2" value="<?php echo $txt2; ?>">
		<input type="hidden" name="txt3" value="<?php echo $txt3; ?>">
		<input type="hidden" name="txtvrchav" value="<?php echo $TaxaChav; ?>">
		<input type="hidden" name="mat_vend" value="<?php echo $Mat_Vend; ?>">
		<input type="hidden" name="vendedora" value="<?php echo $Vendedora; ?>">
		<input type="hidden" name="cliente" value="<?php echo $Cliente; ?>">
		<p>
			<center><input id="ghost_click" type="submit" name="btenvia" value="Registrar">
				<input type="button" name="btret" value="Retornar" onclick="window.history.back()">
			</center>
		</p>
		<center>
			<font color='#FFFFFF' size='3'><span id="msg"></span></font>
		</center>
		</form>
	<?php
	} else {
	?>
		<br><br><br><br><br>
		<font size='6'><b>
				<center>Acesso <font color='gold'>
						<blink><u>não Autorizado</u>
						</blink>
						<font color='#FFFFFF'>!!!</center>
			</b></font><br><br><br>
		<center><a href='servrec.php?c_s=<?php echo $lg_user; ?>'><img src='images/voltar.gif'></a></center><br><br>
	<?php
	}

	// Encerrando
	$SisRot = "S-7.2.5.1";
	include "./rodape.php";
	?>

	<script src="./js/ghost_click.js"></script>

</body>

</html>