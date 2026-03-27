<html>

<head>
	<title>WebCaixa v1.19_beta</title>
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

		function validvalor(field) {
			var valid = ".0123456789"
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

		function FormataValor(Formulario, Campo, TeclaPres) {
			var tecla = TeclaPres.keyCode;
			var strCampo;
			var vr;
			var tam;
			var TamanhoMaximo = 6;

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
				if ((tam > 3) && (tam <= 6)) {
					strCampo.value = vr.substr(0, tam - 3) + '.' + vr.substr(tam - 3, tam);
				}
			}
		}
	</script>
	<script src="val_chav.js" charset="utf-8"></script>

</head>

<body background="../images/bg1.jpg" text="#FFFFFF" onLoad="putFocus(0,0)">

	<?php
	// Obtendo o Login
	$Sis     = "S7";
	$Rot     = "S7R2.5";
	$lg_user = $_REQUEST['c_s'];
	$user = substr($lg_user, 0, 8);
	$pss  = substr($lg_user, 8, 40);
	$Mat_Vend = trim($_POST['mat_vend']);
	$Vendedora = $_POST['vendedora'];
	$Cliente   = $_POST['cliente'];
	$DataHj = date('Y-m-d');

	// Obtendo Valor Atualizado
	include "conexao.php";
	include "dbselect.php";

	// Obtendo o código do estúdio e inserindo o número inicial do recibo
	$NumDocInicial = intval($std . "00000");

	$sql = "select * from taxas where codigo = 'CHV' order by datalt desc";
	$rs  = mysqli_query($conec, $sql) or die("Erro de Banco de Dados #1");
	$ln  = mysqli_fetch_array($rs);
	$DataAlt = $ln['datalt'];
	$Codigo  = $ln['codigo'];
	$VrChav  = $ln['vltx'];
	$VrChavF = number_format($VrChav, 2, ',', '.');

	// Consultando o último recibo dentro das rotinas TXP, TXC, PROD e BOOK
	$sql = "SELECT numdoc, datarec FROM registro 
        WHERE numdoc >= $NumDocInicial
        AND subtipo IN ('TXP', 'TXPG', 'TXC', 'PROD', 'BOOK', 'CHV', 'PRODK') 
        ORDER BY numdoc DESC";
	$rs  = mysqli_query($conec, $sql) or die('Erro #3!');
	$ln  = mysqli_fetch_array($rs);
	$NumDoc = $ln['numdoc'];
	$DataRec = $ln['datarec'];

	// Condição para usar o próximo número do recibo
	if ($DataHj >= $DataRec) {
		$NumDoc = $NumDoc + 1;
	} else {
		echo "Entre em contato com o administrador do sistema.";
	}

	include "us_sist.php";
	if ($ch == 'no') {
		include "us_cad.php";
	}

	?>
	<table width='100%' border='0' cellpadding='0' cellspacing='0'>
		<tr>
			<td width='9%'>
				<a href="inscconcur.php?c_s=<?php echo $lg_user ?>"><img src="./images/voltar.gif"></a>
			</td>
			<td width='82%' align='center'>
				<font color="gold" size="6"><b>
						<center><u><i>AQUISIÇÃO DE CHAVEIROS</i></u></center>
					</b></font>
				<font size="5" color="#FFFFFF"><b>
						<center><u><i>Valor Atual - <font color="aqua">R$ <?php echo $VrChavF; ?></i></u></center>
					</b></font><br>
			</td>
			<td width='9%'>
				<a href="inscconcur.php?c_s=<?php echo $lg_user; ?>"><img src="./images/voltar.gif"></a>
			</td>
		</tr>
	</table>
	<br>
	<?php

	if ($ch == 'ok-enc' or $ch == 'ok-cai' or $ch == 'ok') { ?>
		<form name="chaveiro" method="post" action="confchav.php" onsubmit="return checkdata();" autocomplete="off">
			<table width="70%" border="5" cellpadding="10" cellspacing="0" align="center">
				<tr>
					<td width="50%" align="center">
						<font color='#FFFFFF' size='5'><b><i>Vendedora</i></b></font>
					</td>
					<td width="50%" align="center">
						<font color='#FFFFFF' size='5'><b><i>Cliente</i></b></font>
					</td>
				</tr>
				<tr>
					<td align="center">
						<font color='gold' size='4'><b><i><?php echo $Vendedora; ?></i></b></font>
						<input type="hidden" name="vendedora" value="<?php echo $Vendedora; ?>">
						<input type="hidden" name="mat_vend" value="<?php echo $Mat_Vend; ?>">
					</td>
					<td align="center">
						<font color='lime' size='4'><b><i><?php echo $Cliente; ?></i></b></font>
						<input type="hidden" name="cliente" value="<?php echo $Cliente; ?>">
					</td>
				</tr>
			</table>
			<br>

			<table width="70%" border="5" cellpadding="10" cellspacing="0" align="center">
				<tr>
					<td align="center">
						<font color='gold' size='5'><b><i>Nº Recibo</i></b></font>
					</td>
					<td align="center">
						<font color='gold' size='5'><b><i>Quantidade</i></b></font>
					</td>
					<td align="center">
						<font color='gold' size='5'><b><i>Forma de Pagamento</i></b></font>
					</td>
					<td align="center">
						<font color='gold' size='5'><b><i>Valor</i></b></font>
					</td>
				</tr>

				<tr>
					<td rowspan="4" align="center">
						<font size='5'><b><i><?php echo $NumDoc; ?></i></b></font>
						<input type='hidden' id='txtdoc' name='txtdoc' class='campos' value="<?php echo $NumDoc; ?>">
					</td>
					<td rowspan="4" align="center">
						<input type='text' id='qtde' name='qtde' size='3' maxlength='3' class='campos' autofocus>
					</td>
					<td align="center">
						<select name="lsPr1" class="campos" autofocus>
							<?php
							// Obtendo a Relação
							// Conectando ao Banco de Dados
							include "dbselect.php";

							// Criando a Instrução SQL de Consulta
							$sqlpr1 = "select * from formapag where codpag <= 30 or codpag >= 70 and codpag <> 99 order by codpag";

							// Consultando os Registros
							$rspr1 = mysqli_query($conec, $sqlpr1) or die("Errod de Banco de Dados #1. Contate seu Administrador");

							// Criando o Array para o campo PC
							while ($lnpr1 = mysqli_fetch_array($rspr1)) {
								$CodPag1  = $lnpr1['codpag'];
								$ModPag1  = $lnpr1['modpag'];
							?>
								<option value="<?php echo $CodPag1; ?>" class="campos"><?php echo "$ModPag1"; ?></option>
							<?php
							}
							mysqli_free_result($rspr1);
							?>
						</select>
					</td>
					<td align="center">
						<font size="5"><b><i>R$ </i></b></font>
						<input type="text" name="txt1" size="6" maxlength="6" class="campos" OnKeyUp="FormataValor('chaveiro', 'txt1', event); validvalor(this)">
						<input type="hidden" name="txtvrchav" value="<?php echo $VrChav; ?>">
						<input type="hidden" name="txtuser" value="<?php echo $lg_user; ?>">
					</td>
				</tr>

				<tr>
					<td align="center">
						<select name="lsPr2" class="campos">
							<?php
							// Obtendo a Relação
							// Conectando ao Banco de Dados
							include "dbselect.php";

							// Criando a Instrução SQL de Consulta
							$sqlpr2 = "select * from formapag where codpag <= 30 or codpag >= 70 and codpag <> 99 order by codpag";

							// Consultando os Registros
							$rspr2 = mysqli_query($conec, $sqlpr2) or die("Errod de Banco de Dados #2. Contate seu Administrador");

							// Criando o Array para o campo PC
							while ($lnpr2 = mysqli_fetch_array($rspr2)) {
								$CodPag2  = $lnpr2['codpag'];
								$ModPag2  = $lnpr2['modpag'];
							?>
								<option value="<?php echo $CodPag2; ?>" class="campos"><?php echo "$ModPag2"; ?></option>
							<?php
							}
							mysqli_free_result($rspr2);
							?>
						</select>
					</td>
					<td align="center">
						<font size="5"><b><i>R$ </i></b></font>
						<input type="text" name="txt2" size="6" maxlength="6" class="campos" OnKeyUp="FormataValor('chaveiro', 'txt2', event); validvalor(this)">
					</td>
				</tr>

				<tr>
					<td align="center">
						<select name="lsPr3" class="campos">
							<?php
							// Obtendo a Relação
							// Conectando ao Banco de Dados
							include "dbselect.php";

							// Criando a Instrução SQL de Consulta
							$sqlpr3 = "select * from formapag where codpag <= 30 or codpag >= 70 and codpag <> 99 order by codpag";

							// Consultando os Registros
							$rspr3 = mysqli_query($conec, $sqlpr3) or die("Errod de Banco de Dados #2. Contate seu Administrador");

							// Criando o Array para o campo PC
							while ($lnpr3 = mysqli_fetch_array($rspr3)) {
								$CodPag3  = $lnpr3['codpag'];
								$ModPag3  = $lnpr3['modpag'];
							?>
								<option value="<?php echo $CodPag3; ?>" class="campos"><?php echo "$ModPag3"; ?></option>
							<?php
							}
							mysqli_free_result($rspr3);
							?>
						</select>
					</td>
					<td align="center">
						<font size="5"><b><i>R$ </i></b></font>
						<input type="text" name="txt3" size="6" maxlength="6" class="campos" OnKeyUp="FormataValor('chaveiro', 'txt3', event); validvalor(this)">
					</td>
				</tr>
			</table><br>

			<table width="100%" border="0" cellspacing="0">
				<tr>
					<td width="9%"></td>
					<td width="82%" align="center">
						<input type='submit' name='btenviar' value='Continuar'>&nbsp;&nbsp;
						<input type='reset' name='btreset' value='Limpar'><br><br>
					</td>
					<td width="9%" align="right"></td>
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
		<center><a href='servrec.php?c_s=<?php echo $lg_user; ?>'><img src='images/voltar.gif'></a></center><br><br>
	<?php
	}

	// Encerrando as Conexões
	$SisRot = "S-7.2.5";
	include "rodape.php";
	mysqli_close($conec);
	?>

</body>

</html>