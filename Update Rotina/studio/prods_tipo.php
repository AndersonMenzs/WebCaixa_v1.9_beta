<?php

// debug
ini_set('error_log', 'php_errors.log');
?>

<html>

<head>
	<title>WebCaixa v1.20.6_beta</title>
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

<body background="../images/bg1.jpg" text="#FFFFFF">

	<?php

	// Obtendo o Login
	$Sis     = "S7";
	$Rot     = "S7R2.8";
	$lg_user = $_REQUEST['c_s'];
	$user = substr($lg_user, 0, 8);
	$pss  = substr($lg_user, 8, 40);
	$Ref_Std = trim($_POST['ref_std']);
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
		<form name="prods" method="post" action="prods_select.php" onsubmit="return checkdata();" autocomplete="off">
			<table width="95%" border="5" cellpadding="10" cellspacing="0" align="center">
				<tr>
					<td align="center">
						<font color='gold' size='5'><b><i>Ref. Estúdio</i></b></font>
					</td>
					<td align="center">
						<font color='gold' size='5'><b><i>Colaboradora</i></b></font>
					</td>
					<td align="center">
						<font color='gold' size='5'><b><i>Cliente</i></b></font>
					</td>
				</tr>
				<tr>
					<td align="center">
						<font color='#FFFFFF' size='4'><b><i><?php echo $Ref_Std; ?></i></b></font>
						<input type="hidden" name="ref_std" id="ref_std" value="<?php echo $Ref_Std; ?>">
					</td>
					<td align="center">
						<font color='#FFFFFF' size='4'><b><i><?php echo $Vendedora; ?></i></b></font>
						<input type="hidden" name="mat_vend" id="mat_vend" value="<?php echo $Mat_Vend; ?>">
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
						<select name="lsPr1" id="lsPr1" class="campos" onchange="mostrarTabelaParcelas(this)">
							<?php
							// Obtendo a Relação
							include "conexao.php";
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

						<table width="100%" name="tb_parc_cred_1" id="tb_parc_cred_1" style="display: none;">
							<tr>
								<td align="right">
									<br>
									<font color='gold' size='4'><b><i>Parcela(s): </i></b></font>
									<select name="parc_card_cred_1" id="parc_card_cred_1" class="campos">
										<option value="0" selected>Selecione</option>
										<?php
										for ($i = 1; $i <= 12; $i++) {
										?>
											<option value='<?php echo $i; ?>' class="campos">Parcelas <?php echo $i; ?>x</option>
										<?php
										}
										?>
									</select>
								</td>
							</tr>
						</table>
					</td>
					<td align="center">
						<font color='#FFFFFF' size='4'><b><i>R$ </i></b></font>
						<input type="text" name="txt1" id="txt1" size="6" maxlength="7" class="campos" onKeyUp="FormataValor('prods', 'txt1', event); validate(this)">
					</td>
				</tr>
				<tr>
					<td align="center">
						<select name="lsPr2" id="lsPr2" class="campos" onchange="mostrarTabelaParcelas(this)">
							<?php
							// Obtendo a Relação


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
						<table width="100%" name="tb_parc_cred_2" id="tb_parc_cred_2" style="display: none;">
							<tr>
								<td align="right">
									<br>
									<font color='gold' size='4'><b><i>Parcela(s): </i></b></font>
									<select name="parc_card_cred_2" id="parc_card_cred_2" class="campos">
										<option value="0" selected>Selecione</option>
										<?php for ($i = 1; $i <= 12; $i++) { ?>
											<option value='<?php echo $i; ?>' class="campos">Parcelas <?php echo $i; ?>x</option>
										<?php } ?>
									</select>
								</td>
							</tr>
						</table>
					</td>
					<td align="center">
						<font color='#FFFFFF' size='4'><b><i>R$ </i></b></font>
						<input type="text" name="txt2" id="txt2" size="6" maxlength="7" class="campos" onKeyUp="FormataValor('prods', 'txt2', event); validate(this)">
					</td>
				</tr>
				<tr>
					<td align="center">
						<select name="lsPr3" id="lsPr3" class="campos" onchange="mostrarTabelaParcelas(this)">
							<?php
							// Obtendo a Relação

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
						<table width="100%" name="tb_parc_cred_3" id="tb_parc_cred_3" style="display: none;">
							<tr>
								<td align="right">
									<br>
									<font color='gold' size='4'><b><i>Parcela(s): </i></b></font>
									<select name="parc_card_cred_3" id="parc_card_cred_3" class="campos">
										<option value="0" selected>Selecione</option>
										<?php for ($i = 1; $i <= 12; $i++) { ?>
											<option value='<?php echo $i; ?>' class="campos">Parcelas <?php echo $i; ?>x</option>
										<?php } ?>
									</select>
								</td>
							</tr>
						</table>
					</td>
					<td align="center">
						<font color='#FFFFFF' size='4'><b><i>R$ </i></b></font>
						<input type="text" name="txt3" id="txt3" size="6" maxlength="7" class="campos" onKeyUp="FormataValor('prods', 'txt3', event); validate(this)">
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
			</table>
			<br>
			<input type="hidden" name="txtuser" value="<?php echo $lg_user; ?>">

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

	<script>
		function parseCurrencyToCents(str) {
			if (!str) return 0;
			str = String(str).trim();
			if (str === '') return 0;
			str = str.replace(/\s+/g, '');

			var lastDot = str.lastIndexOf('.');
			var lastComma = str.lastIndexOf(',');
			var decimalSep = null;
			if (lastDot > -1 && lastComma > -1) {
				decimalSep = (lastDot > lastComma) ? '.' : ',';
			} else if (lastDot > -1) {
				decimalSep = (str.length - lastDot - 1 === 2) ? '.' : null;
			} else if (lastComma > -1) {
				decimalSep = (str.length - lastComma - 1 === 2) ? ',' : null;
			}

			if (decimalSep) {
				if (decimalSep === ',') {
					str = str.replace(/\./g, '').replace(',', '.');
				} else {
					str = str.replace(/,/g, '');
				}
			} else {
				str = str.replace(/[^\d]/g, '');
				var n = parseInt(str || '0', 10);
				return isNaN(n) ? 0 : n;
			}

			var f = parseFloat(str);
			return isNaN(f) ? 0 : Math.round(f * 100);
		}

		function formatCentsToBR(cents) {
			return (cents / 100).toFixed(2).replace('.', ',');
		}

		// ligar eventos
		['txtvalor', 'vlr_recebido', 'txtparc'].forEach(function(id) {
			var el = document.getElementById(id);
			if (!el) return;
			el.addEventListener('input', atualizaParcelas);
			el.addEventListener('blur', atualizaParcelas);
		});

		// Event listeners
		document.addEventListener('DOMContentLoaded', function() {

			// Inicializa selects de cartão de crédito
			for (var i = 1; i <= 3; i++) {
				var select = document.getElementById('lsPr' + i);
				if (select) {
					mostrarTabelaParcelas(select);
				}
			}
		});

		function mostrarTabelaParcelas(selectElement) {
			if (!selectElement || !selectElement.id) return;

			var index = selectElement.id.replace('lsPr', '');
			var targetTable = document.getElementById('tb_parc_cred_' + index);

			if (targetTable) {
				// TABELA deve usar 'table' ou 'table-row-group', NÃO 'block'
				targetTable.style.display = (selectElement.value === '31') ? 'table' : 'none';
			}
		}
	</script>

	<script>
		// Chama putFocus de forma segura após o carregamento da página
		if (document.readyState === 'complete') {
			try {
				putFocus(0, 0);
			} catch (e) {}
		} else {
			window.addEventListener('load', function() {
				try {
					putFocus(0, 0);
				} catch (e) {}
			});
		}
	</script>

</body>

</html>