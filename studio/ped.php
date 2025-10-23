<html>

<head>
	<title>WebCaixa v1.19_beta</title>
	<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
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
	// Inserindo o Cabeçalho
	include "../cabecprs.php";
	?>

	<SCRIPT LANGUAGE="JavaScript">
		<!-- Begin
		function putFocus(formInst, elementInst) {
			if (document.forms.length > 0) {
				document.forms[formInst].elements[elementInst].focus();
			}
		}
		//  End 
		-->
	</script>

	<Script>
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
		//  End -->
	</script>

	<script type="text/javascript" src="val_ped.js" charset="utf-8">
	</script>

</head>

<body background="../images/bg1.jpg" text="#FFFFFF" onLoad="putFocus(0,0)">

	<?php
	// Obtendo o Login
	$Sis     = "S7";
	$Rot     = "S7R1";
	$lg_user = $_REQUEST['c_s'];
	$user = substr($lg_user, 0, 8);
	$pss  = substr($lg_user, 8, 40);

	include "us_sist.php";
	if ($ch == 'no') {
		include "us_cad.php";
	} ?>

	<table width='100%' border='0' cellpadding='0' cellspacing='0'>
		<tr>
			<td width='9%'>
				<a href="servrec.php?c_s=<?php echo $lg_user ?>"><img src="./images/voltar.gif"></a>
			</td>
			<td width='82%' align='center'>
				<font color="gold" size="6"><b>
						<center><u><i>SOLICITAÇÕES</i></u></center>
					</b></font><br><br><br>
			</td>
			<td width='9%'>
				<a href="servrec.php?c_s=<?php echo $lg_user; ?>"><img src="./images/voltar.gif"></a>
			</td>
		</tr>
	</table>

	<?php

	if ($ch == 'ok-enc' or $ch == 'ok-cai' or $ch == 'ok') { ?>
		<form name="frmest" method="post" action="estped.php" onsubmit="return checkdata()">
			<table width="50%" border="5" cellpadding="10" cellspacing="0" align="center">
				<tr>
					<td colspan="2" align="center">
						<font color='gold' size='5'><b><i>Autenticação Nº: &nbsp;</i></b></font>
						<input type="text" name="txtaut" size="4" maxlength="4" class="campos" onKeyUp="validate(this)">
						<input type="hidden" name="txtuser" value="<?php echo $lg_user; ?>">
					</td>
				</tr>

				<tr>
					<td witdh="50%" align="center">
						<font color='gold' size='5'><b><i>Book: &nbsp;</i></b></font>
						<input type="radio" name="rdopt" class="campos" value="BOOK">
					</td>
					<td witdh="50%" align="center">
						<font color='gold' size='5'><b><i>Poster: &nbsp;</i></b></font>
						<input type="radio" name="rdopt" class="campos" value="POSTER">
					</td>
				</tr>
			</table><br>

			<table width="100%" border="0" cellspacing="0">
				<tr>
					<td width="9%"></td>
					<td width="82%" align="center">
						<input type="submit" name="btenviar" value="Continuar">&nbsp;&nbsp;
						<input type="reset" name="btreset" value="Limpar">
					<td width="9%" align="right"></a>
					</td>
				</tr>
			</table>
		</form><?php
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
			$SisRot = "S-7.1";
			include "./rodape.php";
			mysqli_close($conec); ?>

</body>

</html>