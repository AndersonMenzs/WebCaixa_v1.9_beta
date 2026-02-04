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

		function autotab(original, destination) {
			if (original.getAttribute && original.value.length == original.getAttribute("maxlength"))
				destination.focus()
		}

		function validpag(field) {
			var valid = "SN"
			var ok = "yes";
			var temp;
			for (var i = 0; i < field.value.length; i++) {
				temp = "" + field.value.substring(i, i + 1);
				if (valid.indexOf(temp) == "-1") ok = "no";
			}
			if (ok == "no") {
				alert("Entrada Incorreta! \n  Digite apenas \"S\" ou \"N\".");
				field.value = "";
				field.focus();
				field.select();
			}
		}
	</script>

	<script type="text/javascript" src="val_pgto.js" charset="utf-8"></script>

	<?php
	// Inserindo Cabeçalho
	include "../cabecprs.php";
	?>
</head>

<body background="../images/bg1.jpg" text="#FFFFFF" onLoad="putFocus(0,0)">

	<?php
	/*$dados = filter_input_array(INPUT_POST, FILTER_DEFAULT);
	echo "<pre>";
	var_dump($dados);
	echo "</pre>";
	exit();*/

	// Importando os Dados do Formulário
	$Sis       = "S7";
	$Rot       = "S7R2.2.1";
	$lg_user   = trim($_POST['txtuser']);
	$user    = substr($lg_user, 0, 8);
	$pss     = substr($lg_user, 8, 40);
	$NumDoc    = trim($_POST['txtdoc']);
	$NumDocF = 10000000 + $NumDoc;
	$NDoc      = substr($NumDocF, 1, 7);
	$VrPrest    = trim($_POST['txtvalor']);
	$VrPrestF   = number_format($VrPrest, 2, ',', '.');
	$VrRec     = trim($_POST['vlr_recebido']);
	$PIni      = trim($_POST['txtparc_ini']);
	$PUlt      = trim($_POST['txtparc_ult']);
	$QtdeParc  = $PUlt - $PIni + 1;
	$ParcialF   = trim($_POST['parcial']);
	$Parcial  = number_format($ParcialF, 2, '.', ',');
	$VrPrestForm  = $VrPrest * $QtdeParc;
	$VrPrestFormF  = number_format($VrPrestForm, 2, ',', '.');
	$FPag_1      = trim($_POST['lsPr1']);
	$txt1 = isset($_POST['txt1']) ? (float) trim($_POST['txt1']) : 0;
	$Mat_Vend = trim($_POST['mat_vend']);
	$Vendedora = trim($_POST['vendedora']);
	$Cliente	= trim($_POST['cliente']);

	include "conexao.php";
	include "dbselect.php";

	// Contando as formas de pagamentos
	$Fspags = 0;

	if ($txt1 <> "") {
		$Fspags = $Fspags + 1;
	}

	if ($Fspags == 1) {
		if ($txt1 <> "") {
			$FPag = $FPag_1;
			$sql = "select * from formapag where codpag = '$FPag' ";
			$rs  = mysqli_query($conec, $sql);
			$ln  = mysqli_fetch_array($rs);
			$ModPag = $ln['modpag'];
			$FmRec  = $ln['siglapag'];
			mysqli_free_result($rs);
		}
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
	} elseif ($FmRec == "CLP") {
		$ModPag = "Cartão Cred. Loja";
		}?>

	<font color="gold" size="6">
		<b>
			<center><u><i>Contrato - Parcelas</i></u></center>
		</b>
	</font><br>

	<?php

	include "us_sist.php";
	if ($ch == 'no') {
		include "us_cad.php";
	}

	if ($ch == 'ok-enc' or $ch == 'ok-cai' or $ch == 'ok') { ?>
		<form name="confentr" method="post" action="geracntparc.php" onsubmit="return checkdata()">
			<table width="70%" border="5" cellpadding="5" cellspacing="0" align="center">
				<tr>
					<td width="45%" align="right">
						<font color='gold' size='5'><b><i>Nº do Contrato </i></b></font>
					</td>
					<td width="55%" align="center">
						<font color='#FFFFFF' size='5'><b><i><?php echo $NDoc; ?></i></b></font>
					</td>
				</tr>

				<tr>
					<td width="45%" align="right">
						<font color='gold' size='5'><b><i>Prestação </i></b></font>
					</td>
					<td width="55%" align="center">
						<font color='#FFFFFF' size='5'>
							<b>
								<i>
									<?php
									if ($PIni == $PUlt) {
										echo $PIni;
									} else {
										echo "$PIni a $PUlt";
									}
									?>
								</i>
							</b>
						</font>
					</td>
				</tr>

				<tr>
					<td width="45%" align="right">
						<font color='gold' size='5'><b><i>Quantidade de Parcelas </i></b></font>
					</td>
					<td width="55%" align="center">
						<font color='#FFFFFF' size='5'><b><i><?php echo $QtdeParc; ?></i></b></font>
					</td>
				</tr><?php

						if ($QtdeParc > 1) { ?>
					<tr>
						<td width="45%" align="right">
							<font color='gold' size='5'><b><i>Valor de Cada Parcela </i></b></font>
						</td>
						<td width="55%" align="center">
							<font color='#FFFFFF' size='5'><b><i><?php echo "R$ " . $VrPrestF; ?></i></b></font>
						</td>
					</tr><?php
						} ?>

				<tr>
					<td width="45%" align="right">
						<font color='gold' size='5'><b><i>Total Cobrado </i></b></font>
					</td>
					<td width="55%" align="center">
						<font color='#FFFFFF' size='5'><b><i><?php echo "R$ " . $VrPrestFormF; ?></i></b></font>
					</td>
				</tr>

				<tr>
					<td width="45%" align="right">
						<font color='gold' size='5'><b><i>Parcial </i></b></font>
					</td>
					<td width="55%" align="center">
						<font color='#FFFFFF' size='5'><b><i><?php echo "R$ " . $ParcialF; ?></i></b></font>
					</td>
				</tr>

				<tr>
					<td width="45%" align="right">
						<font color='gold' size='5'><b><i>Forma de Pagamento </i></b></font>
					</td>
					<td width="55%" align="center">
						<font size='6' color='#FFFFFF'>
							<b>
								<i>
									<?php echo $ModPag; ?>
								</i>
							</b>
						</font>
					</td>
				</tr>

				<tr>
					<td width="45%" align="right">
						<font color='gold' size='5'><b><i>Senha </i></b></font>
					</td>
					<td width="55%" align="center">
						<input type='password' name='txtsen' size='6' maxlength='6' class="campos">
					</td>
				</tr>
			</table>

			<input type="hidden" name="txtuser" value="<?php echo $lg_user; ?>">
			<input type="hidden" name="txtdoc" value="<?php echo $NumDoc; ?>">
			<input type="hidden" name="vrprest" value="<?php echo $VrPrest; ?>">
			<input type="hidden" name="txtparc_ini" value="<?php echo $PIni; ?>">
			<input type="hidden" name="txtparc_ult" value="<?php echo $PUlt; ?>">
			<input type="hidden" name="lsPr1" value="<?php echo $FPag_1; ?>">
			<input type="hidden" name="txtmodpag_ext" value="<?php echo $ModPag; ?>">
			<input type="hidden" name="qtdeparc" value="<?php echo $QtdeParc; ?>">
			<input type="hidden" name="vrparcial" value="<?php echo $Parcial; ?>">
			<input type="hidden" name="vrrec" value="<?php echo $VrRec; ?>">
			<input type="hidden" name="mat_vend" value="<?php echo $Mat_Vend; ?>">
			<input type="hidden" name="vendedora" value="<?php echo $Vendedora; ?>">
			<input type="hidden" name="cliente" value="<?php echo $Cliente; ?>">
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
						<blink><u>não Autorizado</u>
						</blink>
						<font color='#FFFFFF'>!!!</center>
			</b></font><br><br><br>
		<center><a href='servrec.php?c_s=<?php echo $lg_user; ?>'><img src='images/voltar.gif'></a></center><br><br>
	<?php
			}

			// Encerrando
			$SisRot = "S-7.2.2.1";
			include "./rodape.php"; ?>

	<script src="./js/ghost_click.js"></script>

</body>

</html>