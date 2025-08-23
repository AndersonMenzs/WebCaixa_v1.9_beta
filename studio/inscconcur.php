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
	<script src="val_conc.js" charset="utf-8"></script>

</head>

<body background="../images/bg1.jpg" text="#FFFFFF" onLoad="putFocus(0,0)">

	<?php
	// Obtendo o Login
	$Sis     = "S7";
	$Rot     = "S7R2.5";
	$lg_user = $_REQUEST['c_s'];
	$user = substr($lg_user, 0, 8);
	$pss  = substr($lg_user, 8, 40);

	// Obtendo Valor Atualizado
	include "conexao.php";
	include "dbselect.php";

	$sql = "select * from taxas where codigo = 'TXC' order by datalt desc";
	$rs  = mysqli_query($conec, $sql) or die("Erro de Banco de Dados #1");
	$ln  = mysqli_fetch_array($rs);
	$DataAlt = $ln['datalt'];
	$Codigo  = $ln['codigo'];
	$VrConc  = $ln['vltx'];
	$VrConcF = number_format($VrConc, 2, ',', '.');

	include "us_sist.php";
	if ($ch == 'no') {
		include "us_cad.php";
	} 

	// Consultando número de recibo
	$sql = "SELECT numrec FROM num_recibos WHERE status = '0'ORDER BY numrec DESC LIMIT 1";
	$res = mysqli_query($conec, $sql);
	$ln  = mysqli_fetch_array($res);
	$NumRec = $ln['numrec'];
	
	?>

	<font color="gold" size="6"><b>
			<center><u><i>INSCRIÇÃO NO CONCURSO</i></u></center>
		</b></font><br>
	<font size="5" color="#FFFFFF"><b>
			<center><u><i>Valor Atual - <font color="aqua">R$ <?php echo "$VrConcF"; ?></i></u></center>
		</b></font><br><?php

						if ($ch == 'ok-enc' or $ch == 'ok-cai' or $ch == 'ok') { ?>
		<table border="5" cellpadding="5" cellspacing="0" align="center">
			<form name="taxaConc" method="post" action="confconc.php" OnSubmit="JavaScript:return checkdata()">
				<tr>
					<td align="center">
						<font color='gold' size='5'><b><i>Nº Recibo</i></b></font>
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
						<?php
						if ($NumRec != '') {
							$readonly_disabled = 'readonly';

							echo "<input type='text' name='txtdoc' size='5' maxlength='7' class='campos' value='<?php if ($NumRec != '') echo $NumRec; ?>' <?php echo $readonly_disabled; ?>>";
						} else {
							echo "Não há recibo disponivel";
						}
						?>
					</td>
					</td>
					<td align="center">
						<select name="lsPr1" class="campos">
							<?php
							// Obtendo a Relação
							// Conectando ao Banco de Dados
							include "dbselect.php";

							// Criando a Instrução SQL de Consulta
							$sqlpr1 = "select * from formapag where codpag < 31 order by codpag";

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
						<input type="text" name="txt1" size="6" maxlength="6" class="campos" OnKeyUp="FormataValor('taxaConc', 'txt1', event); validvalor(this)">
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
						<input type="text" name="txt2" size="6" maxlength="6" class="campos" OnKeyUp="FormataValor('taxaConc', 'txt2', event); validvalor(this)">
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
						<input type="text" name="txt3" size="6" maxlength="6" class="campos" OnKeyUp="FormataValor('taxaConc', 'txt3', event); validvalor(this)">
					</td>
				</tr>

				<tr>
					<td align="center">
						<select name="lsPr4" class="campos">
							<?php
							// Obtendo a Relação
							// Conectando ao Banco de Dados
							include "dbselect.php";

							// Criando a Instrução SQL de Consulta
							$sqlpr4 = "select * from formapag where codpag < 31 order by codpag";

							// Consultando os Registros
							$rspr4 = mysqli_query($conec, $sqlpr4) or die("Errod de Banco de Dados #4. Contate seu Administrador");

							// Criando o Array para o campo PC
							while ($lnpr4 = mysqli_fetch_array($rspr4)) {
								$CodPag4  = $lnpr4['codpag'];
								$ModPag4  = $lnpr4['modpag'];
							?>
								<option value="<?php echo $CodPag4; ?>" class="campos"><?php echo "$ModPag4"; ?></option>
							<?php
							}
							mysqli_free_result($rspr4);
							?>
						</select>
					</td>
					<td align="center">
						<font size="5"><b><i>R$ </i></b></font>
						<input type="text" name="txt4" size="6" maxlength="6" class="campos" OnKeyUp="FormataValor('taxaConc', 'txt4', event); validvalor(this)">
					</td>
				</tr>
		</table><br>

		<table width="100%" border="0" cellspacing="0">
			<tr>
				<td width="9%">
					<a href="servrec.php?c_s=<?php echo $lg_user ?>"><img src="./images/voltar.gif"></a>
				</td>
				<td width="82%" align="center">
               <?php
               if (isset($NumRec)) {
                  echo "<input type='submit' name='btenviar' value='Continuar'>&nbsp;&nbsp;";
                  echo "<input type='reset' name='btreset' value='Limpar'><br><br>";
               } ?>
				</td>
				<td width="9%" align="right">
					<a href="servrec.php?c_s=<?php echo $lg_user; ?>"><img src="./images/voltar.gif"></a>
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