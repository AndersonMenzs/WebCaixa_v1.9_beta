<html>

<head>
	<title>WebCaixa v1.19_beta</title>
	<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
	<style type="text/css">
		body {
			margin-left: 2%;
			margin-right: 2%;
			border: 3px solid gray;
			padding: 10px 10px 10px 10px;
			font-family: sans-serif;
		}

		.campos {
			background-color: #C0C0C0;
			font: 16px sans-serif;
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

	<script src="val_pgto.js"></script>

	<?php
	// Inserindo Cabeçalho
	include "../cabecprs.php";
	?>
</head>

<body background="../images/bg1.jpg" text="#FFFFFF" onLoad="putFocus(0,0)">
	<?php

	// Importando os Dados do Formulário
	$Sis       = "S7";
	$Rot       = "S7R2.8.1";
	$lg_user   = trim($_POST['txtuser']);
	$user    = substr($lg_user, 0, 8);
	$pss     = substr($lg_user, 8, 40);
	$NumDoc    = trim($_POST['txtdoc']);
	$NumDocF = 100000000 + $NumDoc;
	$NDoc      = substr($NumDocF, 1, 8);
	$FPag_1      = trim($_POST['lsPr1']);
	$FPag_2      = trim($_POST['lsPr2']);
	$FPag_3      = trim($_POST['lsPr3']);
	$Vendedora = trim($_POST['vendedora']);
	$Cliente	= trim($_POST['cliente']);
	$txt1 = isset($_POST['txt1']) ? (float) trim($_POST['txt1']) : 0;
	$txt2 = isset($_POST['txt2']) ? (float) trim($_POST['txt2']) : 0;
	$txt3 = isset($_POST['txt3']) ? (float) trim($_POST['txt3']) : 0;
	$Valor     = $txt1 + $txt2 + $txt3;
	$ValorF    = number_format($Valor, 2, ",", ".");
	$Book      = trim($_POST['rdbook']);

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
			<center><u><i>VENDAS À VISTA</i></u></center>
		</b>
	</font><br>
	<?php

	include "us_sist.php";
	if ($ch == 'no') {
		include "us_cad.php";
	}

	if ($ch == 'ok-enc' or $ch == 'ok-cai' or $ch == 'ok') { ?>
		<table width="85%" border="5" cellpadding="10" cellspacing="0" align="center">
			<form name="confentr" method="post" action="geraprods.php" onSubmit='JavaScript:return checkdata()'>
				<tr>
					<td width="30%" align="center">
						<font color='gold' size='5'><b><i>Documento Nº </i></b></font>
					</td>
					<td width="70%" align="center">
						<font color='#FFFFFF' size='5'><b><i><?php echo $NDoc; ?></i></b></font>
					</td>
				</tr>

				<tr>
					<td width="30%" align="center">
						<font color='gold' size='5'><b><i>Valor Pago</i></b></font>
					</td>
					<td width="70%" align="center">
						<font color='#FFFFFF' size='5'><b><i><?php echo "R$ " . $ValorF; ?></i></b></font>
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
						<font color='gold' size='5'><b><i>Produto: </i></b></font>
						<font color='#FFFFFF' size='5'><b><i>
									<blink>
										<?php
										if ($Book == 'n') {
											echo "Diversos";
										} else {
											echo "Book";
										} ?></blink>
								</i></b></font>
					</td>
					<td width="70%" align="center">
						<font color='gold' size='5'><b><i>Senha: </i></b></font>
						<input type='password' name='txtsen' size='6' maxlength='6' class="campos">
					</td>
				</tr>

		</table>

		<input type="hidden" name="txtuser" value="<?php echo $lg_user; ?>">
		<input type="hidden" name="txt1" value="<?php echo $txt1; ?>">
		<input type="hidden" name="txt2" value="<?php echo $txt2; ?>">
		<input type="hidden" name="txt3" value="<?php echo $txt3; ?>">
		<input type="hidden" name="txtvalor" value="<?php echo $Valor; ?>">
		<input type="hidden" name="txtdoc" value="<?php echo $NDoc; ?>">
		<input type="hidden" name="lsPr1" value="<?php echo $FPag_1; ?>">
		<input type="hidden" name="lsPr2" value="<?php echo $FPag_2; ?>">
		<input type="hidden" name="lsPr3" value="<?php echo $FPag_3; ?>">
		<input type="hidden" name="txtmodpag_ext" value="<?php echo $ModPag; ?>">
		<input type="hidden" name="vendedora" value="<?php echo $Vendedora; ?>">
		<input type="hidden" name="cliente" value="<?php echo $Cliente; ?>">
		<input type="hidden" name="rdbook" value="<?php echo $Book; ?>">
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

			// Encerrando a Conexão
			$SisRot = "S-7.2.8.1";
			include "rodape.php"; ?>

	<script src="./js/ghost_click.js"></script>

</body>

</html>