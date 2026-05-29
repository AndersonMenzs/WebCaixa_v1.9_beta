<html>

<head>
	<title>WebCaixa v1.20.20_beta</title>
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

	<SCRIPT LANGUAGE="JavaScript">
		function putFocus(formInst, elementInst) {
			if (document.forms.length > 0) {
				document.forms[formInst].elements[elementInst].focus();
			}
		}
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
				field.value = "";
				field.focus();
				field.select();
			}
		}
		//  End -->
	</script>

	<script type="text/javascript" src="checkoper.js" charset="utf-8">
	</script>

</head>

<body background="../images/bg1.jpg" text="#FFFFFF" onLoad="putFocus(0,0)">
	<?php
	include "../cabecprs.php";

	// Obtendo o Login
	$Sis     = "S7";
	$Rot     = "S7R6.1";
	$lg_user = $_REQUEST['c_s'];
	$user  = substr($lg_user, 0, 8);
	$pss   = substr($lg_user, 8, 40);

	include "us_sist.php";
	if ($ch == 'no') {
		include "us_cad.php";
	}

	if ($ch == 'ok') { ?><br><br>
		<font color='gold' size='6'><b><u><i>
						<center>CADASTRAR FUNCIONÁRIOS</center>
					</i></u></b></font> <br><br><br>

		<form name="oper" method="post" action="verifop.php" OnSubmit="JavaScript:return checkop()">
			<table border="10" cellpadding="10" cellspacing="0" align="center">
				<tr>
					<td align="center">
						<font size="5"><b><i>Matrícula:</i></b></font>
						<input type="text" name="txtmat" size="8" maxlength="8" class="campos" OnKeyUp="validate(this)">
					</td>
					<td align="center">
						<font size="5"><b><i>Cadastrar Como:</i></b></font>
						<select name="lsCargo" class="campos">
							<option value="00" class="campos">SELECIONE</option>
							<?php

							// Obtendo a Relação
							// Conectando ao Banco de Dados
							include "conexao.php";
							include "dblog.php";

							// Criando a Instrução SQL de Consulta
							$sqlC = "SELECT * FROM cargos WHERE ccargo IN (03, 04, 05, 08, 15, 18, 19, 32) ORDER BY ncargo";

							// Consultando os Registros
							$rsC = mysqli_query($conec, $sqlC) or die("Não foi possível acessar os Dados");

							// Criando o Array para o campo Cargo
							while ($lnC = mysqli_fetch_array($rsC)) {
								$CodCargo = $lnC['ccargo'];
								$Funcao   = $lnC['ncargo'];

								if ($CodCargo == '04') {
									$Funcao = "Caixa";
								} ?>
								<option value="<?php echo "$CodCargo" . "$Funcao"; ?>" class="campos"><?php echo strtoupper("$Funcao"); ?></option>
							<?php
							}
							mysqli_free_result($rsC); ?>
						</select>
						<input type="hidden" name="txtuser" value="<?php echo $lg_user; ?>">
					</td>
				</tr>
			</table><br><br>

			<center><input type="submit" name="btsub" value="Continuar">&nbsp;&nbsp;&nbsp;
				<input type="reset" name="btrst" value="Limpar">
			</center>
		</form><br><br>
	<?php
	} else if ($ch == 'ok-enc') { ?><br><br>
		<font color='gold' size='6'><b><u><i>
						<center>CADASTRAR FUNCIONÁRIOS</center>
					</i></u></b></font> <br><br><br>

		<form name="oper" method="post" action="verifop.php" OnSubmit="JavaScript:return checkop()">
			<table border="10" cellpadding="10" cellspacing="0" align="center">
				<tr>
					<td align="center">
						<font size="5"><b><i>Matrícula:</i></b></font>
						<input type="text" name="txtmat" size="8" maxlength="8" class="campos" OnKeyUp="validate(this)">
					</td>
					<td align="center">
						<font size="5"><b><i>Cadastrar Como:</i></b></font>
						<select name="lsCargo" class="campos">
							<option value="00" class="campos">SELECIONE</option>
							<?php

							// Conectando ao Banco de Dados
							include "conexao.php";
							include "dblog.php";

							// Criando a Instrução SQL de Consulta
							$sqlC = "SELECT * FROM cargos WHERE ccargo IN (03, 04, 05, 15, 18, 19, 32) ORDER BY ncargo";

							// Consultando os Registros
							$rsC = mysqli_query($conec, $sqlC) or die("Não foi possível acessar os Dados");

							// Criando o Array para o campo PC
							while ($lnC = mysqli_fetch_array($rsC)) {
								$CodCargo = $lnC['ccargo'];
								$Funcao   = $lnC['ncargo'];

								if ($CodCargo == '04') {
									$Funcao = "Caixa";
								} ?>
								<option value="<?php echo "$CodCargo" . "$Funcao"; ?>" class="campos"><?php echo strtoupper("$Funcao"); ?></option>
							<?php
							}
							mysqli_free_result($rsC); ?>
						</select>
						<input type="hidden" name="txtuser" value="<?php echo $lg_user; ?>">
					</td>
				</tr>
			</table><br><br>

			<center><input type="submit" name="btsub" value="Continuar">&nbsp;&nbsp;&nbsp;
				<input type="reset" name="btrst" value="Limpar">
			</center>
		</form><br><br>
	<?php
	} ?>
	<table width="100%" border="0" cellpadding="0" cellspacing="0">
		<tr>
			<td width='15%'>
				<a href='index.php?c_s=<?php echo $lg_user; ?>'><img src='./images/voltar.gif' border='0'></a>
			</td>
			<td width='70%' align='center'>
				<font size='5'><b><i>Digite &quot;<font color='gold'>
								<blink><u>00</u></blink>
								<font color='#FFFFFF'>&quot; para Cadastrar <font color='lime'>
										<blink><u>Free-Lancer</u></blink></i></b></font>
			</td>
			<td width='15%' align='right'>
				<a href='index.php?c_s=<?php echo $lg_user; ?>'><img src='./images/voltar.gif' border='0'></a>
			</td>
		</tr>
	</table>

	<meta http-equiv="refresh" content="60;URL=./index.php?c_s=<?php echo $lg_user; ?>">
	<?php

	if ($ch <> 'ok' and $ch <> 'ok-enc') { ?>
		<br><br><br>
		<font size='5'><b>
				<center>Acesso <font color='gold'>
						<blink><u>não Autorizado</u>
						</blink>
						<font color='#FFFFFF'>!!!</center>
			</b></font><br><br><br>
		<center><a href='index.php?c_s=<?php echo $lg_user; ?>'><img src='images/voltar.gif'></a></center><br><br>
	<?php
	}

	// Encerrando
	$SisRot = "S-7.6.1";
	include "rodape.php"; ?>

</body>

</html>