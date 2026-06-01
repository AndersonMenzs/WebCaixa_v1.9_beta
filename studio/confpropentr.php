<html>

<head>
	<title>WebCaixa v1.20.21_beta</title>
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

	// Importando os Dados do Formulário
	$Sis       = "S7";
	$Rot       = "S7R2.2.1";
	$lg_user   = trim($_POST['txtuser']);
	$user    = substr($lg_user, 0, 8);
	$pss     = substr($lg_user, 8, 40);
	$NumDoc    = trim($_POST['txtdoc']);
	$NumDocF = 10000000 + $NumDoc;
	$NDoc      = substr($NumDocF, 1, 7);
	$VrEntr_1    = trim($_POST['txtvalor1']);
	$VrEntr_2   = trim($_POST['txtvalor2']);
	$VrEntr_3   = trim($_POST['txtvalor3']);
	$EntrForm = $VrEntr_1 + $VrEntr_2 + $VrEntr_3;
	$EntrForm = number_format($EntrForm, 2, ',', '.');
	$FPag_1      = trim($_POST['lsPr1']);
	$FPag_2      = trim($_POST['lsPr2']);
	$FPag_3      = trim($_POST['lsPr3']);
	$Mat_Vend = trim($_POST['mat_vend']);
	$Vendedora = trim($_POST['vendedora']);
	$Cliente	= trim($_POST['cliente']);
	$txt1 = isset($_POST['txtvalor1']) ? (float) trim($_POST['txtvalor1']) : 0;
	$txt2 = isset($_POST['txtvalor2']) ? (float) trim($_POST['txtvalor2']) : 0;
	$txt3 = isset($_POST['txtvalor3']) ? (float) trim($_POST['txtvalor3']) : 0;

	include "conexao.php";
	include "dbselect.php";

	// Contando as formas de pagamentos
	$Fspags = 0;

	if ($txt1 <> "") {
		$Fspags = $Fspags + 1;
	}
	if ($txt2 <> "") {
		$Fspags = $Fspags + 1;
	}

	if ($txt3 <> "") {
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
		} elseif ($txt2 <> "") {
			$FPag = $FPag_2;
			$sql = "select * from formapag where codpag = '$FPag' ";
			$rs  = mysqli_query($conec, $sql);
			$ln  = mysqli_fetch_array($rs);
			$ModPag = $ln['modpag'];
			$FmRec  = $ln['siglapag'];
			mysqli_free_result($rs);
		} elseif ($txt3 <> "") {
			$FPag = $FPag_3;
			$sql = "select * from formapag where codpag = '$FPag' ";
			$rs  = mysqli_query($conec, $sql);
			$ln  = mysqli_fetch_array($rs);
			$ModPag = $ln['modpag'];
			$FmRec  = $ln['siglapag'];
			mysqli_free_result($rs);
		}
	} else {
		$ModPag = "Diversas";
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
			<center><u><i>Proposta - Entrada</i></u></center>
		</b>
	</font><br>
	<?php

	include "us_sist.php";
	if ($ch == 'no') {
		include "us_cad.php";
	}

	if ($ch == 'ok-enc' or $ch == 'ok-cai' or $ch == 'ok') {
	?>
		<table width="70%" border="5" cellpadding="10" cellspacing="0" align="center">
			<form name="confentr" method="post" action="gerapropentr.php" onsubmit="return checkdata()" autocomplete="off">
				<tr>
					<td width="30%" align="center">
						<font color='gold' size='5'><b><i>Nº da Proposta</i></b></font>
					</td>
					<td width="70%" align="center">
						<font color='#FFFFFF' size='5'><b><i><?php echo $NDoc; ?></i></b></font>
					</td>
				</tr>

				<tr>
					<td width="30%" align="center">
						<font color='gold' size='5'><b><i>Valor Cobrado</i></b></font>
					</td>
					<td width="70%" align="center">
						<font color='#FFFFFF' size='5'><b><i><?php echo "R$ " . $EntrForm; ?></i></b></font>
					</td>
				</tr>

				<tr>
					<td width="30%" align="center">
						<font color='gold' size='5'><b><i>Forma de Pagamento</i></b></font>
					</td>
					<td width="70%" align="center">
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
					<td width="30%" align="center">
						<font color='gold' size='5'><b><i>Senha</i></b></font>
					</td>
					<td width="70%" align="center">
						<input type='password' name='txtsen' size='6' maxlength='6' class="campos">
					</td>
				</tr>
		</table>
		<input type="hidden" name="txtuser" value="<?php echo $lg_user; ?>">
		<input type="hidden" name="txtvalor1" value="<?php echo $txt1; ?>">
		<input type="hidden" name="txtvalor2" value="<?php echo $txt2; ?>">
		<input type="hidden" name="txtvalor3" value="<?php echo $txt3; ?>">
		<input type="hidden" name="txtvalor" value="<?php echo $EntrForm; ?>">
		<input type="hidden" name="txtdoc" value="<?php echo $NDoc; ?>">
		<input type="hidden" name="txtmodpag" value="<?php echo $FPag; ?>">
		<input type="hidden" name="lsPr1" value="<?php echo $FPag_1; ?>">
		<input type="hidden" name="lsPr2" value="<?php echo $FPag_2; ?>">
		<input type="hidden" name="lsPr3" value="<?php echo $FPag_3; ?>">
		<input type="hidden" name="txtmodpag_ext" value="<?php echo $ModPag; ?>">
		<input type="hidden" name="mat_vend" value="<?php echo $Mat_Vend; ?>">
		<input type="hidden" name="vendedora" value="<?php echo $Vendedora; ?>">
		<input type="hidden" name="cliente" value="<?php echo $Cliente; ?>">
		<br><br>
		<center>
			<input id="ghost_click" type="submit" name="btenvia" value="Continuar">
			<input type="button" name="btret" value="Retornar" OnClick="JavaScript:window.history.back()"><br><br>
			<span id="msg"></span>
		</center>
		</p>
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
	$SisRot = "S-7.2.2.1";
	include "rodape.php";
	?>
	<script src="./js/ghost_click.js"></script>
</body>

</html>