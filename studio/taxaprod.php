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

	<script type="text/javascript" src="val_contrato.js" charset="utf-8"></script>

	<!-- Adicionando jQuery UI para o autocomplete -->
	<link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
	<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
	<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js"></script>


	<?php
	// Inserindo o Cabeçalho
	include "../cabecprs.php";
	?>

	<script>
		$(function() {
			function setupAutocomplete(element, tipo) {
				$(element).autocomplete({
					source: function(request, response) {
						$.ajax({
							url: "buscar_funcionarias.php",
							dataType: "json",
							contentType: "application/json",
							data: {
								term: request.term,
								tipo: tipo
							},
							success: function(data) {
								if (data && Array.isArray(data)) {
									response(data);
								} else if (data && data.error) {
									console.error("Erro no servidor:", data.error);
									response([]);
								} else {
									console.error("Resposta inválida do servidor");
									response([]);
								}
							},
							error: function(xhr, status, error) {
								console.error("Erro na requisição:", status, error);
								try {
									// Tentar extrair mensagem de erro do HTML retornado
									var errorHtml = xhr.responseText;
									var errorMatch = errorHtml.match(/<title>(.*?)<\/title>/i) ||
										errorHtml.match(/<body[^>]*>(.*?)<\/body>/is);
									var errorMsg = errorMatch ? errorMatch[1] : "Erro desconhecido";
									console.error("Detalhes:", errorMsg);
								} catch (e) {
									console.error("Não foi possível analisar o erro");
								}
								response([]);
							}
						});
					},
					minLength: 2,
					delay: 300
				});
			}

			// Aplicar aos campos
			setupAutocomplete("#encarregada", "encarregada");
			setupAutocomplete("#vendedora", "vendedora");
		});

		function validaCampos() {
			var vendedora = document.getElementById('vendedora').value.trim();
			var cliente = document.getElementById('cliente').value.trim();
			if (vendedora.length <= 8) {
				alert('O campo Vendedora deve ter mais que 8 letras.');
				document.getElementById('vendedora').focus();
				return false;
			}
			if (cliente.length <= 8) {
				alert('O campo Cliente deve ter mais que 8 letras.');
				document.getElementById('cliente').focus();
				return false;
			}

			// Validação da soma dos valores
			function parseValor(valor) {
				return parseFloat(valor.replace(',', '.')) || 0;
			}

			return true;
		}

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

		function fPassaAlfaNumerico(tipo) {
			return function(e) {
				let char = String.fromCharCode(e.which);
				if (tipo === 'an') {
					// permite apenas letras e números
					if (!/^[a-zA-Z0-9\s]$/.test(char)) {
						e.preventDefault();
					}
				}
			};
		}

		function validnome(input) {
			// remove tudo que não for letra, número ou espaço
			input.value = input.value.replace(/[^A-Z0-9\s]/g, '');

			// exemplo: exige pelo menos 3 caracteres
			if (input.value.length < 3) {
				input.style.borderColor = "red";
			} else {
				input.style.borderColor = "";
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
	$DataHj = date('Y-m-d');

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

	// Consultando o último recibo dentro das rotinas TXP, TXC, PROD e BOOK
	$sql = "SELECT numdoc, datarec FROM registro 
        WHERE numdoc >= 22000000 
        AND datarec >= '2025-08-29' 
        AND subtipo IN ('TXP', 'TXC', 'PROD', 'BOOK') 
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
		<table width="70%" border="5" cellpadding="5" cellspacing="0" align="center">
			<form name="taxaProd" method="post" action="confprod.php" OnSubmit="JavaScript:return checkdata()" autocomplete="off">
				<input type="hidden" name="vlr_unico" value="<?php echo $VrProd; ?>">
				<tr>
					<td align="center">
						<font size='5'><b><i>Nº Recibo</i></b></font>
					</td>
					<td align="center">
						<font color='gold' size='6'>
							<b>
								<i>
									<blink>Amizade Premiada?</blink>
								</i>
							</b>
						</font>
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
						<font size='5'><b><i><?php echo $NumDoc; ?></i></b></font>
						<input type='hidden' name='txtdoc' size='10' maxlength='8' class='campos' value="<?php echo $NumDoc; ?>">
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
							// Conectando ao Banco de Dados
							include "dbselect.php";

							// Obtendo a Relação
							// Criando a Instrução SQL de Consulta
							$sqlpr1 = "select * from formapag where codpag <= 30 or codpag >= 70 order by codpag";

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
							$sqlpr2 = "select * from formapag where codpag <= 30 or codpag >= 70 order by codpag";

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
							$sqlpr3 = "select * from formapag where codpag <= 30 or codpag >= 70 order by codpag";

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
		<table width="70%" border="5" cellpadding="10" cellspacing="0" align="center">
			<tr>
				<td width="35%" align="center">
					<font color='#FFFFFF' size='5'><b><i>Vendedora</i></b></font>
				</td>
				<td width="35%" align="center">
					<font color='#FFFFFF' size='5'><b><i>Cliente</i></b></font>
				</td>
				<td width="30%" align="center">
					<font color='#FFFFFF' size='5'><b><i>Data Nasc.</i></b></font>
				</td>
			</tr>
			<tr>
				<td align="center">
					<input type="text" id="vendedora" name="vendedora" size="40" maxlength="50" class="campos"
						onkeypress="fPassaAlfaNumerico('an')"
						onkeyup='this.value=this.value.toUpperCase(); validnome(this)' required>
				</td>
				<td align="center">
					<input type="text" id="cliente" name="cliente" size="40" maxlength="50" class="campos"
						onkeypress="fPassaAlfaNumerico('an')"
						onkeyup='this.value=this.value.toUpperCase(); validnome(this)' required>
				</td>
				<td align="center">
					<input type="date" id="data_nasc" name="data_nasc" class="campos" value="1940-01-01" required>
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