<html>

<head>
	<title>WebCaixa v1.19_beta</title>
	<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
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
				field.value = "";
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

	<script src="val_prod.js" charset="utf-8"></script>

</head>

<body background="../images/bg1.jpg" text="#FFFFFF" onLoad="putFocus(0,0)">

	<?php
	// Obtendo o Login
	$Sis     = "S7";
	$Rot     = "S7R2.1";
	$lg_user = $_REQUEST['c_s'];
	$user = substr($lg_user, 0, 8);
	$pss  = substr($lg_user, 8, 40);

	// Obtendo Valor Atualizado
	include "conexao.php";
	include "dbselect.php";

	$sql = "select * from taxas where codigo = 'TXP' order by datalt desc";
	$rs  = mysqli_query($conec, $sql) or die("Erro de Banco de Dados #1");
	$ln  = mysqli_fetch_array($rs);
	$DataAlt = $ln['datalt'];
	$Codigo  = $ln['codigo'];
	$VrProd  = $ln['vltx'];
	$VrProdF = number_format($VrProd, 2, ',', '.');

	// Obtendo Valor Anterior
	$sqlA  = "select * from taxas where codigo = 'TXP' and vltx <> $VrProd order by datalt desc";
	$rsA   = mysqli_query($conec, $sqlA) or die("Erro de Banco de Dados #2");
	$lnA   = mysqli_fetch_array($rsA);
	$DtAltA = $lnA['datalt'];
	$CodA   = $lnA['codigo'];
	$VrAnt   = $lnA['vltx'];
	$VrAntF = number_format($VrAnt, 2, ',', '.');

	include "us_sist.php";
	if ($ch == 'no') {
		include "us_cad.php";
	} ?>

	<font color="gold" size="6"><b>
			<center><u><i>TAXA DE PRODUÇÃO</i></u></center>
		</b></font>
	<font size="5" color="#FFFFFF"><b>
			<center><u><i>Valor Atual - <font color="aqua">R$ <?php echo "$VrProdF"; ?></i></u></center>
		</b></font><br>
	<?php

	if ($ch == 'ok-enc' or $ch == 'ok-cai' or $ch == 'ok-adm' or $ch == 'ok') {
	?>
		<table border="5" cellpadding="5" cellspacing="0" align="center">
			<form name="taxaProd" method="post" action="confprod.php" OnSubmit="JavaScript:return checkdata()" autocomplete="off">
				<tr>
					<td align="center">
						<font size='5'><b><i>Nº Recibo</i></b></font>
					</td>
					<td align="center">
						<font color='gold' size='6'><b><i>
									<blink>Amizade Premiada?</blink>
								</i></b></font>
					</td>
					<td align="center">
						<font size='5'><b><i>Forma de Pagamento</i></b></font>
					</td>
					<td align="center">
						<font size='5'><b><i>Valor</i></b></font>
					</td>
				</tr>

				<tr>
					<td rowspan="4" align="center">
						<?php

						// COnexão
						include "dbselect.php";

						?>

						<input type='text' name='txtdoc' size='5' maxlength='7' class='campos'>

					</td>
					<td rowspan="4" align="center">
						<font color='lime' size='5'><b><i>Não </i></b></font><input type='radio' name='rdtaxa' value='N' checked>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
						<font size='5'><b><i>Sim </i></b></font><input type='radio' name='rdtaxa' value='S'>

						<input type="hidden" name="txtvrprod" value="<?php echo $VrProd; ?>">
						<input type="hidden" name="txtvrprodf" value="<?php echo $VrProdF; ?>">

						<input type="hidden" name="txtAP" value="<?php echo $VrAnt; ?>">
						<input type="hidden" name="txtAPf" value="<?php echo $VrAntF; ?>">

						<input type="hidden" name="txtuser" value="<?php echo $lg_user; ?>">
					</td>
					<td align="center">
						<select name="lsPr1" class="campos">
							<?php
							// Obtendo a Relação
							// Criando a Instrução SQL de Consulta
							$sqlpr1 = "select * from formapag where codpag < 31 order by codpag";

							// Consultando os Registros
							$rspr1 = mysqli_query($conec, $sqlpr1) or die("Não foi possível acessar os Dados");

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
						<input type="text" name="txt1" size="6" maxlength="6" class="campos" OnKeyUp="FormataValor('taxaProd', 'txt1', event); validvalor(this)">
						<input type="hidden" name="txtvrconc" value="<?php echo $VrConc; ?>">
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
							$sqlpr2 = "select * from formapag where codpag < 31 order by codpag";

							// Consultando os Registros
							$rspr2 = mysqli_query($conec, $sqlpr2) or die("Não foi possível acessar os Dados");

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
						<input type="text" name="txt2" size="6" maxlength="6" class="campos" OnKeyUp="FormataValor('taxaProd', 'txt2', event); validvalor(this)">
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
							$sqlpr3 = "select * from formapag where codpag < 31 order by codpag";

							// Consultando os Registros
							$rspr3 = mysqli_query($conec, $sqlpr3) or die("Não foi possível acessar os Dados");

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
						<input type="text" name="txt3" size="6" maxlength="6" class="campos" OnKeyUp="FormataValor('taxaProd', 'txt3', event); validvalor(this)">
					</td>
				</tr>

		</table><br>

		<table width="100%" border="0" cellspacing="0">
			<tr>
				<td width="9%">
					<a href="servrec.php?c_s=<?php echo $lg_user ?>"><img src="./images/voltar.gif"></a>
				</td>
				<td width="82%" align="center">
					<input type='submit' name='btenviar' value='Continuar'>&nbsp;&nbsp;
					<input type='reset' name='btreset' value='Limpar'><br><br>
				</td>
				<td width="9%" align="right">
					<a href="servrec.php?c_s=<?php echo $lg_user; ?>"><img src="./images/voltar.gif"></a>
				</td>
			</tr>
		</table>
		</form><?php
			} else { ?>
		<br><br>
		<font size='6'><b>
				<center>Acesso <font color='gold'>
						<blink><u>não Autorizado</u>
						</blink>
						<font color='#FFFFFF'>!!!</center>
			</b></font><br><br>
		<center><a href='servrec.php?c_s=<?php echo $lg_user; ?>'><img src='images/voltar.gif'></a></center><br>
	<?php
			}

			// Encerrando as Conexões
			$SisRot = "S-7.2.1";
			include "../rodape.php";
			mysqli_close($conec);
	?>

</body>

</html>