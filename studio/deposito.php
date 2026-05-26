<html>

<head>
	<title>WebCaixa v1.20.17_beta</title>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
	<style type="text/css">
		body {
			margin-top: 5%;
			margin-left: 3%;
			margin-right: 3%;
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

		function FormataValor(Formulario, Campo, TeclaPres) {
			var tecla = TeclaPres.keyCode;
			var strCampo;
			var vr;
			var tam;
			var TamanhoMaximo = 10;

			eval("strCampo = document." + Formulario + "." + Campo);

			vr = strCampo.value;
			vr = vr.replace("/", "");
			vr = vr.replace("/", "");
			vr = vr.replace("/", "");
			vr = vr.replace(",", "");
			vr = vr.replace(".", "");
			vr = vr.replace(".", "");
			vr = vr.replace(".", "");
			vr = vr.replace(".", "");
			vr = vr.replace(".", "");
			vr = vr.replace(".", "");
			vr = vr.replace(".", "");
			vr = vr.replace("-", "");
			vr = vr.replace("-", "");
			vr = vr.replace("-", "");
			vr = vr.replace("-", "");
			vr = vr.replace("-", "");
			tam = vr.length;

			if (tam < TamanhoMaximo && tecla != 8) {
				tam = vr.length + 1;
			}

			if (tecla == 8) {
				tam = tam - 1;
			}

			if (tecla == 8 || tecla >= 48 && tecla <= 57 || tecla >= 96 && tecla <= 105) {
				if (tam <= 3) {
					strCampo.value = vr;
				}
				if ((tam > 3) && (tam <= 10)) {
					strCampo.value = vr.substr(0, tam - 3) + '.' + vr.substr(tam - 3, tam);
				}
			}
		}

		function validate(field) {
			var valid = ".0123456789"
			var ok = "yes";
			var temp;
			for (var i = 0; i < field.value.length; i++) {
				temp = "" + field.value.substring(i, i + 1);
				if (valid.indexOf(temp) == "-1") ok = "no";
			}
			if (ok == "no") {
				alert("Entrada Incorreta!\nSomente algarismos podem ser aceitos!");
				field.focus();
				field.select();
			}
		}
	</script>

	<script src="val_dep.js" charset="utf-8"></script>

</head>

<body background="../images/bg1.jpg" text="#FFFFFF" onLoad="putFocus(0,0)">

	<?php
	// Obtendo o Login
	$Sis     = "S7";
	$Rot     = "S7R3.2";
	$lg_user = $_REQUEST['c_s'];
	$user = substr($lg_user, 0, 8);
	$pss  = substr($lg_user, 8, 40);
	$dtatual = date('ymd');

	include "us_sist.php";
	if ($ch == 'no') {
		include "us_cad.php";
	} ?>

	<font color="gold" size="6"><br>
		<b>
			<center><u><i>RECOLHIMENTOS</i></u></center>
		</b>
	</font><br><br><br>
	<?php

	if ($ch == 'ok-enc' or $ch == 'ok-cai' or $ch == 'ok') {
		// Obtendo o Saldo de Caixa
		include "dbselect.php";
		$sqlC = "select numerario, cashin, cashout from caixa where dtopen = $dtatual";
		$rsC  = mysqli_query($conec, $sqlC) or die("Erro de Banco de Dados #1. Contate seu Administrador!");
		$lnC  = mysqli_fetch_array($rsC);
		$numerario = $lnC['numerario'];
		$cashin    = $lnC['cashin'];
		$cashout   = $lnC['cashout'];

		$sqlR = "select * from registro where tiporec <> 'E' and (tiporec = '8' or modpgto = '10') and estorno = '' and datarec = '$dtatual' ";
		$rsR  = mysqli_query($conec, $sqlR) or die("Erro de Banco de Dados #2. Contate seu Administrador!");
		while ($lnR  = mysqli_fetch_array($rsR)) {
			$subtipo = $lnR['subtipo'];
			$valrec = $lnR['vlrec'];

			switch ($subtipo) {
				case 'DDP':
					$DPessoal = $DPessoal + $valrec;
					break;
				case 'MCS':
					$DMatCons = $DMatCons + $valrec;
					break;
				case 'MDV':
					$DMatDiv = $DMatDiv + $valrec;
					break;
				case 'MPD':
					$DMatProd = $DMatProd + $valrec;
					break;
				case 'RCL':
					$ReemCli = $ReemCli + $valrec;
					break;
				case 'SRV':
					$DServPres = $DServPres + $valrec;
					break;
				case 'VTR':
					$DVTransp = $DVTransp + $valrec;
					break;
				case 'OUT':
					$DOutros = $DOutros + $valrec;
					break;

				default:
					$Creditos = $Creditos + $valrec;
					break;
			}
		}
		// Totalizando Despesas
		$DespTot = $DPessoal + $DMatCons + $DMatDiv + $DMatProd + $ReemCli + $DServPres + $DVTransp + $DOutros;

		$sql = "select valor from depositos where dtdep = $dtatual";
		$rs  = mysqli_query($conec, $sql) or die("Erro de Banco de Dados #3. Contate seu Administrador!");
		while ($ln  = mysqli_fetch_array($rs)) {
			$Deposito = $ln['valor'];
			$Depsto   = $Depsto + $Deposito;
		}

		$Cx  = $numerario + $cashin - $cashout + $Creditos - $Depsto - $DespTot;
		$SdCaixa = number_format($Cx, 2, ".", ""); ?>

		<table width="60%" border="5" cellpadding="10" cellspacing="0" align="center">
			<form name="deps" method="post" action="confdep.php" OnSubmit="JavaScript:return checkdata()">
				<tr>
					<td width="33%" align="center">
						<font color='gold' size='5'><b><i>Nº do Envelope</i></b></font>
					</td>
					<td width="34%" align="center">
						<font color='gold' size='5'><b><i>Recolhimento</i></b></font>
					</td>
					<td width="33%" align="center">
						<font color='gold' size='5'><b><i>Recebedor</i></b></font>
					</td>
				</tr>

				<tr>
					<td width="33%" align="center">
						<input type="text" name="txtcod" size="6" maxlength="6" class="campos" OnKeyUp="validate(this)">
					</td>
					<td width="34%" align="center">
						<font size='4'><b><i>R$ </i></b></font>
						<input type="text" name="txtvalor" size="7" maxlength="7" class="campos" OnKeyUp="FormataValor('deps', 'txtvalor', event); validate(this)">
					</td>
					<td width="33%" align="center">
						<input type="text" name="txtreceb" size="8" maxlength="8" class="campos" OnKeyUp="validate(this)">
						<input type="hidden" name="txtuser" value="<?php echo $lg_user; ?>">
						<input type="hidden" name="txtcaixa" value="<?php echo $Cx; ?>">
						<input type="hidden" name="txtcaixaF" value="<?php echo $SdCaixa; ?>">
					</td>
				</tr>
		</table><br>

		<table width="100%" border="0" cellspacing="0">
			<tr>
				<td width="9%"><a href="pgtos.php?c_s=<?php echo $lg_user ?>"><img src="./images/voltar.gif"></a></td>
				<td width="82%" align="center">
					<input type="submit" name="btenviar" value="Continuar">&nbsp;&nbsp;
					<input type="reset" name="btreset" value="Limpar">
				<td width="9%" align="right"><a href="pgtos.php?c_s=<?php echo $lg_user; ?>"><img src="./images/voltar.gif"></a>
				</td>
			</tr>
		</table>
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
		<center><a href='pgtos.php?c_s=<?php echo $lg_user; ?>'><img src='images/voltar.gif'></a></center><br><br>
	<?php
	}

	// Encerrando as Conexões
	$SisRot = "S-7.3.2";
	include "rodape.php";
	mysqli_close($conec); ?>

</body>

</html>