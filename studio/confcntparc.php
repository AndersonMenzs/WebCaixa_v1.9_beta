<html>

<head>
	<title>WebCaixa v1.19_beta</title>
	<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">

	<style type="text/css">
		body {
			margin-top: 3%;
			margin-left: 3%;
			margin-right: 3%;
			border: 3px solid gray;
			padding: 10px;
			font-family: sans-serif;
		}

		.campos {
			background-color: #C0C0C0;
			font: 12px sans-serif;
			color: #000000;
		}
	</style>

	<script>
		function putFocus(f, e) {
			if (document.forms.length > 0) {
				document.forms[f].elements[e].focus();
			}
		}
	</script>

	<script type="text/javascript" src="val_pgto.js"></script>

	<?php include "../cabecprs.php"; ?>
</head>

<body background="../images/bg1.jpg" text="#FFFFFF" onLoad="putFocus(0,0)">

	<?php

	$Sis = "S7";
	$Rot = "S7R2.2.1";

	$lg_user = trim($_POST['txtuser']);
	$user = substr($lg_user, 0, 8);
	$pss     = substr($lg_user, 8, 40);

	$NumDoc = trim($_POST['txtdoc'] ?? 0);
	$NumDocF = 10000000 + (int)$NumDoc;
	$NDoc = substr($NumDocF, 1, 7);

	$VrPrest = (float)($_POST['txtvalor'] ?? 0);
	$VrPrestF = number_format($VrPrest, 2, ',', '.');

	$VrRec = (float)($_POST['vlr_recebido'] ?? 0);

	$PIni = (int)($_POST['txtparc_ini'] ?? 0);
	$PUlt = (int)($_POST['txtparc_ult'] ?? 0);

	$QtdeParc = $PUlt - $PIni + 1;
	if ($QtdeParc <= 0) $QtdeParc = 1;

	$ParcialF = (float)($_POST['parcial'] ?? 0);
	$Parcial = number_format($ParcialF, 2, ',', '.');

	$VrPrestForm = $VrPrest * $QtdeParc;
	$VrPrestFormF = number_format($VrPrestForm, 2, ',', '.');

	$FPag_1 = trim($_POST['lsPr1'] ?? '');
	$FPag_2 = trim($_POST['lsPr2'] ?? '');
	$FPag_3 = trim($_POST['lsPr3'] ?? '');

	$txt1 = (float)($_POST['txt1'] ?? 0);
	$txt2 = (float)($_POST['txt2'] ?? 0);
	$txt3 = (float)($_POST['txt3'] ?? 0);

	$Mat_Vend = trim($_POST['mat_vend'] ?? '');
	$Vendedora = trim($_POST['vendedora'] ?? '');
	$Cliente = trim($_POST['cliente'] ?? '');

	$VrTot = $txt1 + $txt2 + $txt3;
	$VrTotF = number_format($VrTot, 2, ',', '.');

	include "conexao.php";
	include "dbselect.php";

	$Fspags = 0;
	if ($txt1 > 0) $Fspags++;
	if ($txt2 > 0) $Fspags++;
	if ($txt3 > 0) $Fspags++;

	$ModPag = "Diversas";
	$FmRec = "";
	$FPag = "";

	if ($Fspags == 1) {

		if ($txt1 > 0) $FPag = $FPag_1;
		elseif ($txt2 > 0) $FPag = $FPag_2;
		else $FPag = $FPag_3;

		$sql = "select * from formapag where codpag='$FPag'";
		$rs = mysqli_query($conec, $sql);

		if ($rs && mysqli_num_rows($rs) > 0) {
			$ln = mysqli_fetch_array($rs);
			$ModPag = $ln['modpag'];
			$FmRec = $ln['siglapag'];
		}

		mysqli_free_result($rs);
	}

	switch ($FmRec) {
		case "DIN":
			$ModPag = "Dinheiro";
			break;
		case "CTD":
			$ModPag = "Cartão Débito";
			break;
		case "CTV":
			$ModPag = "Cartão Crédito";
			break;
		case "PXQ":
			$ModPag = "Pix QR Code";
			break;
		case "PXC":
			$ModPag = "Pix Cnpj";
			break;
	}
	?>

	<font color="gold" size="6"><b>
			<center><u><i>Contrato - Parcelas</i></u></center>
		</b></font><br>

	<?php

	include "us_sist.php";
	if ($ch == 'no') {
		include "us_cad.php";
	}

	if ($ch == 'ok-enc' or $ch == 'ok-cai' or $ch == 'ok') { ?>

		<form name="confentr" method="post" action="geracntparc.php" onsubmit="return checkdata()">

			<table width="70%" border="5" cellpadding="5" cellspacing="0" align="center">

				<tr>
					<td align="right">
						<font color='gold' size='5'><b>Nº do Contrato</b></font>
					</td>
					<td align="center">
						<font size='5'><b><?php echo $NDoc; ?></b></font>
					</td>
				</tr>

				<tr>
					<td align="right">
						<font color='gold' size='5'><b>Prestação</b></font>
					</td>
					<td align="center">
						<font size='5'><b>
								<?php if ($PIni == $PUlt) echo $PIni;
								else echo "$PIni a $PUlt"; ?>
							</b></font>
					</td>
				</tr>

				<tr>
					<td align="right">
						<font color='gold' size='5'><b>Quantidade</b></font>
					</td>
					<td align="center">
						<font size='5'><b><?php echo $QtdeParc; ?></b></font>
					</td>
				</tr>

				<tr>
					<td align="right">
						<font color='gold' size='5'><b>Total Cobrado</b></font>
					</td>
					<td align="center">
						<font size='5'><b><?php echo "R$ " . $VrPrestFormF; ?></b></font>
					</td>
				</tr>

				<tr>
					<td align="right">
						<font color='gold' size='5'><b>Parcial</b></font>
					</td>
					<td align="center">
						<font size='5'><b><?php echo "R$ " . $Parcial; ?></b></font>
					</td>
				</tr>

				<tr>
					<td align="right">
						<font color='gold' size='5'><b>Forma</b></font>
					</td>
					<td align="center">
						<font size='6'><b><?php echo $ModPag; ?></b></font>
					</td>
				</tr>

				<tr>
					<td align="right">
						<font color='gold' size='5'><b>Senha</b></font>
					</td>
					<td align="center"><input type='password' name='txtsen' size='6' maxlength='6' class="campos"></td>
				</tr>

			</table>

			<input type="hidden" name="txtuser" value="<?php echo $lg_user; ?>">
			<input type="hidden" name="txtdoc" value="<?php echo $NumDoc; ?>">
			<input type="hidden" name="vrprest" value="<?php echo $VrPrest; ?>">
			<input type="hidden" name="txtparc_ini" value="<?php echo $PIni; ?>">
			<input type="hidden" name="txtparc_ult" value="<?php echo $PUlt; ?>">
			<input type="hidden" name="txtvalor1" value="<?php echo $txt1; ?>">
			<input type="hidden" name="txtvalor2" value="<?php echo $txt2; ?>">
			<input type="hidden" name="txtvalor3" value="<?php echo $txt3; ?>">
			<input type="hidden" name="txtmodpag" value="<?php echo $FPag; ?>">
			<input type="hidden" name="lsPr1" value="<?php echo $FPag_1; ?>">
			<input type="hidden" name="lsPr2" value="<?php echo $FPag_2; ?>">
			<input type="hidden" name="lsPr3" value="<?php echo $FPag_3; ?>">
			<input type="hidden" name="txtmodpag_ext" value="<?php echo $ModPag; ?>">
			<input type="hidden" name="qtdeparc" value="<?php echo $QtdeParc; ?>">
			<input type="hidden" name="vrparcial" value="<?php echo $ParcialF; ?>">
			<input type="hidden" name="vrtotf" value="<?php echo $VrTotF; ?>">
			<input type="hidden" name="vrrec" value="<?php echo $VrRec; ?>">
			<input type="hidden" name="mat_vend" value="<?php echo $Mat_Vend; ?>">
			<input type="hidden" name="vendedora" value="<?php echo $Vendedora; ?>">
			<input type="hidden" name="cliente" value="<?php echo $Cliente; ?>">

			<p align="center">
				<input type="submit" name="btenvia" value="Continuar">
				<input type="button" value="Retornar" onclick="history.back()">
			</p>

		</form>

	<?php } else { ?>

		<center>
			<font size='6'>Acesso não Autorizado</font>
		</center>

	<?php } ?>

	<?php include "./rodape.php"; ?>

</body>

</html>