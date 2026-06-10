<html>

<head>
	<title>WebCaixa v1.20.0_beta</title>
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
			var valid = ".0123456789"
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
	</script>

	<script src="val_prods.js" charset="utf-8"></script>

</head>

<body background="../images/bg1.jpg" text="#FFFFFF" onLoad="putFocus(0,0)">

	<?php
	
	// Obtendo o Login
	$Sis     = "S7";
	$Rot     = "S7R2.8";
	$lg_user = $_REQUEST['c_s'];
	$user = substr($lg_user, 0, 8);
	$pss  = substr($lg_user, 8, 40);
	$ref_std = trim($_POST['ref_std']);
	$Contrato = trim($_POST['txtdoc']);
	$Mat_Vend = trim($_POST['mat_vend']);
	$Vendedora = $_REQUEST['vendedora'];
	$Cliente   = $_REQUEST['cliente'];
	$DataHj = date('Y-m-d');

	// Obtendo Valor Atualizado
	include "conexao.php";
	include "dbselect.php";

	// Obtendo o código do estúdio e inserindo o número inicial do recibo
	$NumDocInicial = intval($std . "00000");

	// Consultando o último recibo dentro das rotinas TXP, TXC, PROD e BOOK
	$sql = "SELECT numdoc, datarec FROM registro 
        WHERE numdoc >= $NumDocInicial
        AND subtipo IN ('TXP', 'TXPG', 'TXC', 'PROD', 'BOOK', 'CHV') 
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
	} ?><br>

	<table width='100%' border='0' cellpadding='0' cellspacing='0'>
		<tr>
			<td width='9%'>
				<a href="prods.php?c_s=<?php echo $lg_user ?>"><img src="./images/voltar.gif"></a>
			</td>
			<td width='82%' align='center'>
				<font color="gold" size="6"><b>
						<center><u><i>VENDAS À VISTA</i></u></center>
					</b></font><br>
			</td>
			<td width='9%'>
				<a href="prods.php?c_s=<?php echo $lg_user; ?>"><img src="./images/voltar.gif"></a>
			</td>
		</tr>
	</table><br>
	<?php

	if ($ch == 'ok-enc' or $ch == 'ok-cai' or $ch == 'ok') {
	?>
		<form name="prods" method="post" action="confprods.php" onsubmit="return checkdata();" autocomplete="off">
			<table width="95%" border="5" cellpadding="10" cellspacing="0" align="center">
				<tr>
					<td align="center">
						<font color='gold' size='5'><b><i>Ref. Estúdio</i></b></font>
					</td>
					<td align="center">
						<font color='gold' size='5'><b><i>Contrato</i></b></font>
					</td>
					<td align="center">
						<font color='gold' size='5'><b><i>Vendedora</i></b></font>
					</td>
					<td align="center">
						<font color='gold' size='5'><b><i>Cliente</i></b></font>
					</td>
				</tr>
				<tr>
					<td align="center">
						<font color='#FFFFFF' size='4'><b><i><?php echo $ref_std; ?></i></b></font>
						<input type="hidden" name="txtdoc" id="txtdoc" value="<?php echo $Contrato; ?>">
					</td>
					<td align="center">
						<font color='#FFFFFF' size='4'><b><i><?php echo $Contrato; ?></i></b></font>
						<input type="hidden" name="txtdoc" id="txtdoc" value="<?php echo $Contrato; ?>">
					</td>
					<td align="center">
						<font color='#FFFFFF' size='4'><b><i><?php echo $Vendedora; ?></i></b></font>
						<input type="hidden" name="mat_vend" id="mat_vend" value="<?php echo $mat_vend; ?>">
						<input type="hidden" name="vendedora" id="vendedora" value="<?php echo $Vendedora; ?>">
					</td>
					<td align="center">
						<font color='#FFFFFF' size='4'><b><i><?php echo $Cliente; ?></i></b></font>
						<input type="hidden" name="cliente" id="cliente" value="<?php echo $Cliente; ?>">
					</td>
				</tr>
			</table>
			<br>

			<table width="95%" border="5" cellpadding="10" cellspacing="0" align="center">
				<tr>
					<td align="center">
						<font color='#FFFFFF' size='5'><b><i>Nº Recibo</i></b></font>
					</td>
					<td align="center">
						<font color='#FFFFFF' size='5'><b><i>Valor Total</i></b></font>
					</td>
					<td align="center">
						<font color='#FFFFFF' size='5'><b><i>Forma de Pagamento</i></b></font>
					</td>
					<td align="center">
						<font color='#FFFFFF' size='5'><b><i>Valor</i></b></font>
					</td>
				</tr>

				<tr>
					<td rowspan="3" align="center">
						<font size='5'><b><i><?php echo $NumDoc; ?></i></b></font>
						<input type='hidden' name='txtdoc' size='10' maxlength='8' class='campos' value="<?php echo $NumDoc; ?>">
					</td>
					<td rowspan="3" align="center">
						<font size='5'><b><i>R$ </i></b></font>
						<input type="text" name="vlr_unico" size="7" maxlength="7" class="campos" OnKeyUp="FormataValor('prods', 'vlr_unico', event); validate(this)" autofocus>
					</td>
					<td align="center">
						<select name="lsPr1" class="campos">
							<?php
							// Obtendo a Relação
							// Conectando ao Banco de Dados
							include "dbselect.php";

							// Criando a Instrução SQL de Consulta
							$sqlpr = "select * from formapag where codpag <= 31 or codpag >= 70 and codpag <> 99 order by codpag";

							// Consultando os Registros
							$rspr = mysqli_query($conec, $sqlpr) or die("Não foi possível acessar os Dados");

							// Criando o Array para o campo PC
							while ($lnpr = mysqli_fetch_array($rspr)) {
								$CodPag  = $lnpr['codpag'];
								$ModPag  = $lnpr['modpag'];
							?>
								<option value="<?php echo $CodPag; ?>" class="campos"><?php echo "$ModPag"; ?></option>
							<?php
							}
							mysqli_free_result($rspr);
							?>
						</select>
					</td>
					<td align="center">
						<font size='5'><b><i>R$ </i></b></font>
						<input type="text" name="txt1" size="7" maxlength="7" class="campos" OnKeyUp="FormataValor('prods', 'txt1', event); validate(this)">
						<input type="hidden" name="txtuser" value="<?php echo $lg_user; ?>">
					</td>
				</tr>

				<tr>
					<td align="center">
						<select name="lsPr2" class="campos">
							<?php
							// Obtendo a Relação
							include "dbselect.php";

							// Criando a Instrução SQL de Consulta
							$sqlpr = "select * from formapag where codpag <= 31 or codpag >= 70 and codpag <> 99 order by codpag";
							$rspr = mysqli_query($conec, $sqlpr) or die("Não foi possível acessar os Dados");

							// Criando o Array para o campo PC
							while ($lnpr = mysqli_fetch_array($rspr)) {
								$CodPag  = $lnpr['codpag'];
								$ModPag  = $lnpr['modpag'];
							?>
								<option value="<?php echo $CodPag; ?>" class="campos"><?php echo "$ModPag"; ?></option>
							<?php
							}
							mysqli_free_result($rspr);
							?>
						</select>
					</td>
					<td align="center">
						<font size='5'><b><i>R$ </i></b></font>
						<input type="text" name="txt2" size="7" maxlength="7" class="campos" OnKeyUp="FormataValor('prods', 'txt2', event); validate(this)">
						<input type="hidden" name="txtuser" value="<?php echo $lg_user; ?>">
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
							$sqlpr = "select * from formapag where codpag <= 31 or codpag >= 70 and codpag <> 99 order by codpag";

							// Consultando os Registros
							$rspr = mysqli_query($conec, $sqlpr) or die("Não foi possível acessar os Dados");

							// Criando o Array para o campo PC
							while ($lnpr = mysqli_fetch_array($rspr)) {
								$CodPag  = $lnpr['codpag'];
								$ModPag  = $lnpr['modpag'];
							?>
								<option value="<?php echo $CodPag; ?>" class="campos"><?php echo "$ModPag"; ?></option>
							<?php
							}
							mysqli_free_result($rspr);
							?>
						</select>
					</td>
					<td align="center">
						<font size='5'><b><i>R$ </i></b></font>
						<input type="text" name="txt3" size="7" maxlength="7" class="campos" OnKeyUp="FormataValor('prods', 'txt3', event); validate(this)">
						<input type="hidden" name="txtuser" value="<?php echo $lg_user; ?>">
					</td>
				</tr>

				<!--<tr>
					<td colspan="2" align="center">
						<font color='gold' size='6'><b><i>Deseja Book? </i></b></font>
					</td>
					<td colspan="2" align="center">
						<input type="radio" name="rdbook" value="s" class="campos">
						<font color='#FFFFFF' size='6'><b><i>Sim</i></b></font>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
						<input type="radio" name="rdbook" value="n" class="campos" checked>
						<font color='#FFFFFF' size='6'><b><i>Não</i></b></font>
					</td>
				</tr>-->
			</table><br>

			<table width="100%" border="0" cellspacing="0">
				<tr>
					<td width="82%" align="center">
						<input type='submit' name='btenviar' value='Continuar'>&nbsp;&nbsp;
						<input type='reset' name='btreset' value='Limpar'><br><br>
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
		<center><a href='servrec.php?c_s=<?php echo $lg_user; ?>'><img src='images/voltar.gif'></a></center><br><br>
	<?php
	}

	// Encerrando as Conexões
	$SisRot = "S-7.2.8";
	include "rodape.php";
	mysqli_close($conec); ?>

</body>

</html>