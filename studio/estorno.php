<html>

<head>
	<title>WebCaixa v1.20.4_beta</title>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
	<style type="text/css">
		body {
			margin-top: 5%;
			margin-left: 5%;
			margin-right: 5%;
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

	<?php
	// Inserindo o Cabeçalho
	include "../cabecprs.php";
	?>

	<script>
		function putFocus(formInst, elementInst) {
			if (document.forms.length > 0) {
				document.forms[formInst].elements[elementInst].focus();
			}
		}

		function validate(field) {
			var valid = "0123456789"
			var ok = "yes";
			var temp;
			for (var i = 0; i < field.value.length; i++) {
				temp = "" + field.value.substring(i, i + 1);
				if (valid.indexOf(temp) == "-1") ok = "no";
			}
			if (ok == "no") {
				alert("Entrada Incorreta! \n  Digite apenas algarismos!");
				field.focus();
				field.select();
			}
		}
	</script>

	<script src="val_estorno.js" charset="utf-8"></script>

</head>

<body background="../images/bg1.jpg" text="#FFFFFF" onLoad="putFocus(0,0)">

	<?php
	// Obtendo o Login
	$Sis     = "S7";
	$Rot     = "S7R4";
	$lg_user = $_REQUEST['c_s'];
	$user = substr($lg_user, 0, 8);
	$pss  = substr($lg_user, 8, 40);

	include "us_sist.php";
	if ($ch == 'no') {
		include "us_cad.php";
	} ?>

	<font color="gold" size="6"><br>
		<b>
			<center><u><i>Estorno de Autenticação</i></u></center>
		</b>
	</font><br><br><br>
	<?php

	if ($ch == 'ok-enc' or $ch == 'ok-cai' or $ch == 'ok') { ?>
		<table width="40%" border="5" cellpadding="10" cellspacing="0" align="center">
			<form name="frmest" method="post" action="estconf.php" OnSubmit="JavaScript:return checkdata()" autocomplete="off">
				<tr>
					<td align="center">
						<font color='gold' size='5'><b><i>Autenticação Nº: &nbsp;</i></b></font>
						<input type="text" name="txtaut" size="4" maxlength="4" class="campos" onKeyUp="validate(this)" autofocus>
						<input type="hidden" name="txtuser" value="<?php echo $lg_user; ?>">
					</td>
				</tr>
		</table><br>

		<table width="100%" border="0" cellspacing="0">
			<tr>
				<td width="9%"><a href="index.php?c_s=<?php echo $lg_user ?>"><img src="./images/voltar.gif"></a>
				</td>
				<td width="82%" align="center">
					<input type="submit" name="btenviar" value="Continuar">&nbsp;&nbsp;
					<input type="reset" name="btreset" value="Limpar">
				</td>
				<td width="9%" align="right">
					<a href="index.php?c_s=<?php echo $lg_user; ?>"><img src="./images/voltar.gif"></a>
				</td>
			</tr>
		</table>
		</form>
	<?php
	} else { ?>
		<br><br><br><br><br>
		<font size='6'><b>
				<center>Acesso <font color='gold'>
						<blink><u>não Autorizado</u>
						</blink>
						<font color='#FFFFFF'>!!!</center>
			</b></font><br><br><br>
		<center><a href='index.php?c_s=<?php echo $lg_user; ?>'><img src='images/voltar.gif'></a></center><br><br>
	<?php
	}

	// Encerrando as Conexões
	$SisRot = "S-7.4";
	include "rodape.php";
	mysqli_close($conec); ?>

</body>

</html>