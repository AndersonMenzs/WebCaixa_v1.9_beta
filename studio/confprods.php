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
	$NumDocF = 1000000 + $NumDoc;
	$NDoc      = substr($NumDocF, 1, 6);
	$Valor     = trim($_POST['txtvalor']);
	$ValorF    = number_format($Valor, 2, ",", ".");
	$FPag      = trim($_POST['lsPr']);
	$Book      = trim($_POST['rdbook']);

	include "conexao.php";
	include "dbselect.php";

	// Obtendo Dados
	$sql = "select * from formapag where codpag = '$FPag' ";
	$rs  = mysqli_query($conec, $sql);
	$ln  = mysqli_fetch_array($rs);
	$ModPag = $ln['modpag'];
	mysqli_free_result($rs); ?>

	<font color="gold" size="6">
		<br><b>
			<center><u><i>VENDAS A VISTA</i></u></center>
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
						<font size='6'><b><i>Pagamento em <font color='gold'>
										<blink>Dinheiro</blink>&nbsp;
										<font size="5">
											<font color="#FFFFFF">(<font color="lime">S&nbsp;/&nbsp;<font color="red">N<font color="gold">
															<font color="#FFFFFF">)<font size="6">?</i></b></font>&nbsp;&nbsp;
						<input type="text" name="txtconfirm" size="2" maxlength="1" class="campos" onKeyPress="fPassaAlfaNumerico('an')" onKeyUp="this.value=this.value.toUpperCase(); validpag(this); autotab(this, txtsen)">
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
		<input type="hidden" name="txtvalor" value="<?php echo $Valor; ?>">
		<input type="hidden" name="txtdoc" value="<?php echo $NDoc; ?>">
		<input type="hidden" name="txtmodpag" value="<?php echo $FPag; ?>">
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