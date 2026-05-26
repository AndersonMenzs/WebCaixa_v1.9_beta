<html>

<head>
	<title>WebCaixa v1.20.16_beta</title>
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

		.ui-autocomplete {
			max-height: 200px;
			overflow-y: auto;
			overflow-x: hidden;
			background-color: #fff;
			color: #000;
			border: 1px solid #ccc;
		}

		.ui-menu-item {
			padding: 5px;
		}

		.ui-menu-item:hover {
			background-color: #f0f0f0;
			cursor: pointer;
		}

		.quitacao-label {
			color: #ffcc00;
			font-weight: bold;
		}

		/* Padroniza o tamanho do checkbox para ficar do tamanho do campo de texto */
		input[type="checkbox"] {
			width: 1.5em;
			height: 1.5em;
			vertical-align: middle;
		}
	</style>

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

		function validateParcelas(field) {
			var valor = parseInt(field.value || 0, 10);
			if (valor > 12) {
				alert("Erro! \n  Máximo de 12 parcelas permitido!");
				field.value = "";
				field.focus();
				field.select();
			}
		}

		function checkdata() {
			// Validação básica antes de enviar
			var txtvalor = document.getElementById('txtvalor');
			var vlr_recebido = document.getElementById('vlr_recebido');
			var txtparc = document.getElementById('txtparc');
			var chkQuitacao = document.getElementById('chk_quitacao');
			var parcial = document.getElementById('parcial');
			var qtdeQuitacao = document.getElementById('total_parcelas_contrato');
			var txt1 = document.getElementById('txt1');
			var txt2 = document.getElementById('txt2');
			var txt3 = document.getElementById('txt3');

			if (!txtvalor.value || parseFloat(txtvalor.value.replace('.', '').replace(',', '.')) <= 0) {
				alert('Informe o valor da prestação!');
				txtvalor.focus();
				return false;
			}

			if (!vlr_recebido.value || parseFloat(vlr_recebido.value.replace('.', '').replace(',', '.')) <= 0) {
				alert('Informe o valor recebido!');
				vlr_recebido.focus();
				return false;
			}

			if (!txtparc.value || parseInt(txtparc.value) <= 0) {
				alert('Informe o número da prestação!');
				txtparc.focus();
				return false;
			}

			if (chkQuitacao && chkQuitacao.checked && parcial) {
				var valorPrestacaoCents = parseCurrencyToCents(txtvalor.value);
				var valorRecebidoCents = parseCurrencyToCents(vlr_recebido.value);
				var qtdeParcelas = parseInt(qtdeQuitacao ? qtdeQuitacao.value : '0', 10) || 0;
				var valorQuitacaoCents = valorPrestacaoCents * qtdeParcelas;
				var valorPagamentosCents = parseCurrencyToCents(txt1 ? txt1.value : '') +
					parseCurrencyToCents(txt2 ? txt2.value : '') +
					parseCurrencyToCents(txt3 ? txt3.value : '');

				if (qtdeParcelas <= 0) {
					alert('Informe a quantidade de prestações a serem quitadas!');
					return false;
				}

				if (valorRecebidoCents !== valorQuitacaoCents) {
					alert('Valor recebido incorreto para quitação. O valor correto é R$ ' + formatCentsToBR(valorQuitacaoCents) + '.');
					vlr_recebido.focus();
					return false;
				}

				if (valorPagamentosCents !== valorQuitacaoCents) {
					alert('Valor informado na forma de pagamento incorreto para quitação. O valor correto é R$ ' + formatCentsToBR(valorQuitacaoCents) + '.');
					if (txt1) txt1.focus();
					return false;
				}

				var parcialCents = parseCurrencyToCents(parcial.value);
				if (parcialCents > 0) {
					alert('Quitação não pode ter valor parcial. Ajuste o recebimento antes de continuar.');
					vlr_recebido.focus();
					return false;
				}
				parcial.value = '0,00';
			}

			return true;
		}
	</script>

	<script>
		function FormataValor(Formulario, Campo, TeclaPres) {
			try {
				var evt = TeclaPres || window.event || {};
				var tecla = evt.keyCode || evt.which || 0;

				var form = null;
				if (typeof Formulario === 'string') {
					form = document.forms[Formulario] || document.querySelector('form[name="' + Formulario + '"]');
				} else {
					form = document.forms[0];
				}

				var strCampo = null;
				if (form) {
					strCampo = form.elements[Campo] || form[Campo];
				}
				if (!strCampo) {
					strCampo = document.getElementById(Campo) || document.querySelector('[name="' + Campo + '"]');
				}

				if (!strCampo) {
					return false;
				}

				var vr = String(strCampo.value || '');
				vr = vr.replace(/[\/\.,\-\s]/g, '');

				var tam = vr.length;
				var TamanhoMaximo = 12;

				if (tam < TamanhoMaximo && tecla !== 8) tam = vr.length + 1;
				if (tecla === 8) tam = tam - 1;

				if (tecla === 8 || (tecla >= 48 && tecla <= 57) || (tecla >= 96 && tecla <= 105)) {
					if (tam <= 3) {
						strCampo.value = vr;
					} else if (tam > 3 && tam <= TamanhoMaximo) {
						strCampo.value = vr.substr(0, tam - 3) + '.' + vr.substr(tam - 3, tam);
					}
				}
				return true;
			} catch (e) {
				return false;
			}
		}
	</script>

	<?php
	// Inserindo o Cabeçalho
	include "../cabecprs.php";
	?>

	<link rel="stylesheet" href="./css/themes.css">
	<script src="./js/jquery.js"></script>
	<script src="./js/ui.js"></script>
	<script type="text/javascript" src="val_parcela.js?v=20260512_quitacao" charset="utf-8"></script>

</head>

<body background="../images/bg1.jpg" text="#FFFFFF" onLoad="putFocus(0,0)">

	<?php
	// Conectando ao Banco de Dados
	include "conexao.php";
	include "dbselect.php";

	// Obtendo o Login
	$Sis     = "S7";
	$Rot     = "S7R2.3";
	$lg_user = $_REQUEST['c_s'];
	$user = substr($lg_user, 0, 8);
	$pss  = substr($lg_user, 8, 40);
	$ref_std = trim($_POST['ref_std']);

	$Contrato = trim($_POST['txtdoc']);
	$mat_vend = trim($_POST['mat_vend']);
	$Vendedora = trim($_POST['vendedora']);
	$Cliente	= trim($_POST['cliente']);

	// Verifica se é quitação
	$chk_quitacao = isset($_POST['chk_quitacao']) ? $_POST['chk_quitacao'] : 0;
	$qtde_parcelas_quitacao = isset($_POST['total_parcelas_contrato']) ? intval($_POST['total_parcelas_contrato']) : 0;

	// Converter para centavos
	$valor_str = str_replace(',', '.', str_replace('.', '', $_POST['txtvalor'] ?? '0'));
	$vlr_recebido_str = str_replace(',', '.', str_replace('.', '', $_POST['vlr_recebido'] ?? '0'));

	$valC = intval(round(floatval($valor_str) * 100));
	$recC = intval(round(floatval($vlr_recebido_str) * 100));
	$txtparc = intval($_POST['txtparc'] ?? 0);

	if ($txtparc > 12) {
		$txtparc = 12;
	}

	// Lógica de cálculo com suporte a quitação
	if ($chk_quitacao == 1 && $qtde_parcelas_quitacao > 0) {
		// Modo quitação: calcula a parcela final pela quantidade informada.
		$PIni = $txtparc;
		$parcelasPlenas = $qtde_parcelas_quitacao;
		$PUlt = $txtparc + $parcelasPlenas - 1;
		$parcialC = 0;
		$Parcial = "0,00";
	} else {
		// Modo normal
		$parcelasPlenas = $valC > 0 ? intdiv($recC, $valC) : 0;
		$parcialC = $recC - ($parcelasPlenas * $valC);
		$PIni = $txtparc;
		$PUlt = $parcelasPlenas > 0 ? ($txtparc + $parcelasPlenas - 1) : ($txtparc - 1);
		$Parcial = number_format($parcialC / 100, 2, '.', ',');
	}

	$nextParc = $PUlt + 1;
	$mostraParcial = ($chk_quitacao != 1 && $parcialC > 0);
	$mostraParcelas = ($txtparc > 0);

	include "us_sist.php";
	if ($ch == 'no') {
		include "us_cad.php";
	} ?>

	<table width='100%' border='0' cellpadding='0' cellspacing='0'>
		<tr>
			<td width='9%'>
				<a href="contrparc.php?c_s=<?php echo $lg_user ?>"><img src="./images/voltar.gif"></a>
			</td>
			<td width='82%' align='center'>
				<font color="gold" size="6"><b>
						<center><u><i>CONTRATO - PARCELAS</i></u></center>
					</b></font><br><br><br>
			</td>
			<td width='9%'>
				<a href="contrparc.php?c_s=<?php echo $lg_user; ?>"><img src="./images/voltar.gif"></a>
			</td>
		</tr>
	</table>

	<?php
	if ($ch == 'ok-enc' or $ch == 'ok-cai' or $ch == 'ok') { ?>
		<form name="parcela" method="post" action="contrparc_select.php" onsubmit="return checkdata()" autocomplete="off">
			<table width="95%" border="5" cellpadding="10" cellspacing="0" align="center">
				<tr>
					<td align="center">
						<font color='gold' size='5'><b><i>Ref. Estúdio</i></b></font>
					</td>
					<td align="center">
						<font color='gold' size='5'><b><i>Contrato</i></b></font>
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
						<font color='#FFFFFF' size='4'><b><i><?php echo $ref_std; ?></i></b></font>
						<input type="hidden" name="ref_std" value="<?php echo $ref_std; ?>">
					</td>
					<td align="center">
						<font color='#FFFFFF' size='4'><b><i><?php echo $Contrato; ?></i></b></font>
						<input type="hidden" name="txtdoc" value="<?php echo $Contrato; ?>">
					</td>
					<td align="center">
						<font color='#FFFFFF' size='4'><b><i><?php echo $Vendedora; ?></i></b></font>
						<input type="hidden" name="mat_vend" value="<?php echo $mat_vend; ?>">
						<input type="hidden" name="vendedora" value="<?php echo $Vendedora; ?>">
					</td>
					<td align="center">
						<font color='#FFFFFF' size='4'><b><i><?php echo $Cliente; ?></i></b></font>
						<input type="hidden" name="cliente" value="<?php echo $Cliente; ?>">
					</td>
				</tr>
			</table>
			<br>

			<table width="95%" border="5" cellpadding="10" cellspacing="0" align="center">
				<tr>
					<td width="15%" align="center">
						<font color='gold' size='4'><b><i>Vlr. Prestação</i></b></font>
					</td>
					<td width="15%" align="center">
						<font color='gold' size='4'><b><i>Vlr. Recebido</i></b></font>
					</td>
					<td width="10%" align="center">
						<font color='gold' size='4'><b><i>Nº Prestação</i></b></font>
					</td>
					<td width="8%" align="center">
						<font color='gold' size='4'><b><i>Quitação?</i></b></font>
					</td>
					<td width="8%" align="center" id="colParcelasHeader" style="<?php echo $mostraParcelas ? '' : 'display:none;'; ?>">
						<font color='gold' size='4'><b><i><span id="labelQtdPrestacoes">Parcela(s)</span></i></b></font>
					</td>
					<td width="12%" align="center" id="colParcialHeader" style="<?php echo $mostraParcial ? '' : 'display:none;'; ?>">
						<font color='gold' size='4'><b><i><span id="labelParcial"><?php echo ($parcialC > 0) ? 'Parcial da Próxima' : 'Parcial'; ?></span></i></b></font>
					</td>
					<td width="20%" align="center">
						<font color='gold' size='4'><b><i>Forma Pagamento</i></b></font>
					</td>
					<td width="15%" align="center">
						<font color='gold' size='4'><b><i>Valor</i></b></font>
					</td>
				</tr>
				<tr>
					<td rowspan="3" align="center">
						<font color='#FFFFFF' size='4'><b><i>R$ </i></b></font>
						<input type="text" name="txtvalor" id="txtvalor" size="6" maxlength="7" class="campos" autofocus onKeyUp="FormataValor('parcela', 'txtvalor', event); validate(this)">
					</td>
					<td rowspan="3" align="center">
						<font color='#FFFFFF' size='4'><b><i>R$ </i></b></font>
						<input type="text" name="vlr_recebido" id="vlr_recebido" size="6" maxlength="7" class="campos" onKeyUp="FormataValor('parcela', 'vlr_recebido', event); validate(this)">
					</td>
					<td rowspan="3" align="center">
						<input type="text" name="txtparc" id="txtparc" size="4" maxlength="2" class="campos" onkeyup="validate(this)" onchange="validateParcelas(this)">
						<input type="hidden" name="total_parcelas_contrato" id="total_parcelas_contrato" value="">
					</td>
					<td rowspan="3" align="center">
						<input type="checkbox" name="chk_quitacao" id="chk_quitacao" value="1" onchange="toggleQuitacao(this)">
					</td>
					<td rowspan="3" align="center" id="colParcelasValor" style="<?php echo $mostraParcelas ? '' : 'display:none;'; ?>">
						<input type="hidden" name="txtparc_ini" id="txtparc_ini" value="<?php echo $PIni; ?>">
						<input type="hidden" name="txtparc_ult" id="txtparc_ult" value="<?php echo $PUlt; ?>">
						<font color='#FFFFFF' size='4'><b><i>
									<span id="PIni"><?php echo $PIni; ?></span>
									<span id="Psep" style="<?php echo ($parcelasPlenas > 1) ? '' : 'display:none;'; ?>"> a </span>
									<span id="PUlt" style="<?php echo ($parcelasPlenas > 1) ? '' : 'display:none;'; ?>"><?php echo $PUlt; ?></span>
								</i></b></font>
					</td>
					<td rowspan="3" align="center" id="colParcialValor" style="<?php echo $mostraParcial ? '' : 'display:none;'; ?>">
						<input type="hidden" name="parcial" id="parcial" value="<?php echo $Parcial; ?>">
						<font color='#FFFFFF' size='4'><b><i><span id="Parcial"><?php echo $Parcial; ?></span></i></b></font>
					</td>
					<input type="hidden" name="txtuser" value="<?php echo $lg_user; ?>">
					<td align="center">
						<select name="lsPr1" id="lsPr1" class="campos" onchange="mostrarTabelaParcelas(this)">
							<?php
							// Conectando ao Banco de dados
							include "conexao.php";
							include "dbselect.php";

							$sqlpr = "select * from formapag where codpag <= 31 or codpag >= 70 and codpag <> 99 order by codpag";
							$rspr = mysqli_query($conec, $sqlpr) or die("Não foi possível acessar os Dados");
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
								<td align="center">
									<br>
									<font color='gold' size='4'><b><i>Parcela(s): </i></b></font>
									<select name="parc_card_cred_1" id="parc_card_cred_1" class="campos">
										<option value="0" selected>Selecione</option>
										<?php for ($i = 1; $i <= 12; $i++) { ?>
											<option value='<?php echo $i; ?>' class="campos">Parcelas <?php echo $i; ?>x</option>
										<?php } ?>
									</select>
								</td>
					</td>
				</tr>
			</table>
			</td>
			<td align="center">
				<font color='#FFFFFF' size='4'><b><i>R$ </i></b></font>
				<input type="text" name="txt1" id="txt1" size="6" maxlength="7" class="campos" onKeyUp="FormataValor('parcela', 'txt1', event); validate(this)">
			</td>
			</tr>
			<tr>
				<td align="center">
					<select name="lsPr2" id="lsPr2" class="campos" onchange="mostrarTabelaParcelas(this)">
						<?php
						// Conectando ao Banco de dados
						include "conexao.php";
						include "dbselect.php";

						$sqlpr = "select * from formapag where codpag <= 31 or codpag >= 70 and codpag <> 99 order by codpag";
						$rspr = mysqli_query($conec, $sqlpr) or die("Não foi possível acessar os Dados");
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
							<td align="center">
								<br>
								<font color='gold' size='4'><b><i>Parcela(s): </i></b></font>
								<select name="parc_card_cred_2" id="parc_card_cred_2" class="campos">
									<option value="0" selected>Selecione</option>
									<?php for ($i = 1; $i <= 12; $i++) { ?>
										<option value='<?php echo $i; ?>' class="campos">Parcelas <?php echo $i; ?>x</option>
									<?php } ?>
								</select>
							</td>
				</td>
			</tr>
			</table>
			</td>
			<td align="center">
				<font color='#FFFFFF' size='4'><b><i>R$ </i></b></font>
				<input type="text" name="txt2" id="txt2" size="6" maxlength="7" class="campos" onKeyUp="FormataValor('parcela', 'txt2', event); validate(this)">
			</td>
			</tr>
			<tr>
				<td align="center">
					<select name="lsPr3" id="lsPr3" class="campos" onchange="mostrarTabelaParcelas(this)">
						<?php
						// Conectando ao Banco de dados
						include "conexao.php";
						include "dbselect.php";

						$sqlpr = "select * from formapag where codpag <= 31 or codpag >= 70 and codpag <> 99 order by codpag";
						$rspr = mysqli_query($conec, $sqlpr) or die("Não foi possível acessar os Dados");
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
							<td align="center">
								<br>
								<font color='gold' size='4'><b><i>Parcela(s): </i></b></font>
								<select name="parc_card_cred_3" id="parc_card_cred_3" class="campos">
									<option value="0" selected>Selecione</option>
									<?php for ($i = 1; $i <= 12; $i++) { ?>
										<option value='<?php echo $i; ?>' class="campos">Parcelas <?php echo $i; ?>x</option>
									<?php } ?>
								</select>
							</td>
				</td>
			</tr>
			</table>
			</td>
			<td align="center">
				<font color='#FFFFFF' size='4'><b><i>R$ </i></b></font>
				<input type="text" name="txt3" id="txt3" size="6" maxlength="7" class="campos" onKeyUp="FormataValor('parcela', 'txt3', event); validate(this)">
			</td>
			</tr>
			</table><br>

			<table width="100%" border="0" cellspacing="0">
				<tr>
					<td width="9%"></td>
					<td width="82%" align="center">
						<input type="submit" name="btenviar" value="Continuar">&nbsp;&nbsp;
						<input type="reset" name="btreset" value="Limpar">
					</td>
					<td width="9%"></td>
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
	?>
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

		function setParcialColumnVisible(visible) {
			var header = document.getElementById('colParcialHeader');
			var valor = document.getElementById('colParcialValor');
			var display = visible ? '' : 'none';
			if (header) header.style.display = display;
			if (valor) valor.style.display = display;
		}

		function setParcelasColumnVisible(visible) {
			var header = document.getElementById('colParcelasHeader');
			var valor = document.getElementById('colParcelasValor');
			var display = visible ? '' : 'none';
			if (header) header.style.display = display;
			if (valor) valor.style.display = display;
		}

		function toggleQuitacao(checkbox) {
			var txtparc = document.getElementById('txtparc');
			var txtvalor = document.getElementById('txtvalor');
			var vlr_recebido = document.getElementById('vlr_recebido');
			var labelParcial = document.getElementById('labelParcial');
			var labelQtdPrestacoes = document.getElementById('labelQtdPrestacoes');
			var qtdeParcelasHidden = document.getElementById('total_parcelas_contrato');

			if (checkbox.checked) {
				// Desabilita campos
				txtparc.readOnly = false; // Mantém editável para informar a parcela inicial
				txtvalor.readOnly = true;
				vlr_recebido.readOnly = false; // Permite informar o valor total da quitação
				txtvalor.style.backgroundColor = '#f0f0f0';

				setParcelasColumnVisible(parseInt(txtparc.value || '0', 10) > 0);
				setParcialColumnVisible(false);
				if (labelQtdPrestacoes) {
					labelQtdPrestacoes.textContent = 'Quitação do contrato';
					labelQtdPrestacoes.style.color = '#ffcc00';
				}

				// Solicita a quantidade de prestações que serão quitadas.
				var qtdeParcelas = prompt('Informe a quantidade de prestações a serem quitadas:', '1');
				if (qtdeParcelas && parseInt(qtdeParcelas, 10) > 0) {
					qtdeParcelasHidden.value = parseInt(qtdeParcelas, 10);
					calcularQuitacao();
				} else {
					checkbox.checked = false;
					toggleQuitacao(checkbox);
				}
			} else {
				// Reativa os campos
				txtvalor.readOnly = false;
				txtvalor.style.backgroundColor = '';

				if (labelParcial) {
					labelParcial.textContent = 'Parcial';
					labelParcial.style.color = '';
				}
				if (labelQtdPrestacoes) {
					labelQtdPrestacoes.textContent = 'Parcela(s)';
					labelQtdPrestacoes.style.color = '';
				}

				qtdeParcelasHidden.value = '';

				// Recalcula normalmente
				atualizaParcelas();
			}
		}

		function calcularQuitacao() {
			var txtparc = document.getElementById('txtparc');
			var qtdeParcelasHidden = document.getElementById('total_parcelas_contrato');
			var inicioParc = parseInt(txtparc.value, 10);
			var qtdeParcelas = parseInt(qtdeParcelasHidden.value, 10);

			if (!inicioParc || inicioParc <= 0) {
				alert('Informe o número da parcela inicial para quitar o restante!');
				document.getElementById('chk_quitacao').checked = false;
				toggleQuitacao(document.getElementById('chk_quitacao'));
				return;
			}

			if (!qtdeParcelas || qtdeParcelas <= 0) {
				alert('Informe a quantidade de prestações a serem quitadas!');
				document.getElementById('chk_quitacao').checked = false;
				toggleQuitacao(document.getElementById('chk_quitacao'));
				return;
			}

			var ultimaParcela = inicioParc + qtdeParcelas - 1;
			var parcelasRestantes = qtdeParcelas;

			// Atualiza a exibição
			setParcelasColumnVisible(true);
			document.getElementById('PIni').textContent = inicioParc;
			document.getElementById('PUlt').textContent = ultimaParcela;
			if (parcelasRestantes > 1) {
				document.getElementById('Psep').style.display = 'inline';
				document.getElementById('PUlt').style.display = 'inline';
			} else {
				document.getElementById('Psep').style.display = 'none';
				document.getElementById('PUlt').style.display = 'none';
			}
			setParcialColumnVisible(false);
			document.getElementById('Parcial').textContent = '';

			// Atualiza os campos hidden
			var hidIni = document.getElementById('txtparc_ini');
			var hidUlt = document.getElementById('txtparc_ult');
			var hidPar = document.getElementById('parcial');
			if (hidIni) hidIni.value = inicioParc;
			if (hidUlt) hidUlt.value = ultimaParcela;
			if (hidPar) hidPar.value = '0,00';

			// Atualiza label
			var labelQtdPrestacoes = document.getElementById('labelQtdPrestacoes');
			if (labelQtdPrestacoes) {
				labelQtdPrestacoes.textContent = parcelasRestantes === 1 ? 'Prestação Recebida' : 'Prestações Recebidas';
			}
		}

		function atualizaParcelas() {
			// Verifica se o checkbox de quitação está marcado
			var quitacaoCheckbox = document.getElementById('chk_quitacao');
			if (quitacaoCheckbox && quitacaoCheckbox.checked) {
				calcularQuitacao();
				return;
			}

			var valParcelaCents = parseCurrencyToCents(document.getElementById('txtvalor').value);
			var recebidoCents = parseCurrencyToCents(document.getElementById('vlr_recebido').value);
			var inicioParc = parseInt((document.getElementById('txtparc').value || '0'), 10) || 0;
			setParcelasColumnVisible(inicioParc > 0);

			if (valParcelaCents <= 0 || recebidoCents <= 0 || inicioParc <= 0) {
				document.getElementById('PIni').textContent = inicioParc > 0 ? inicioParc : '';
				document.getElementById('PUlt').textContent = '';
				document.getElementById('Psep').style.display = 'none';
				document.getElementById('PUlt').style.display = 'none';
				document.getElementById('Parcial').textContent = '';
				setParcialColumnVisible(false);

				var hidIni = document.getElementById('txtparc_ini');
				var hidUlt = document.getElementById('txtparc_ult');
				var hidPar = document.getElementById('parcial');
				if (hidIni) hidIni.value = inicioParc > 0 ? inicioParc : '';
				if (hidUlt) hidUlt.value = '';
				if (hidPar) hidPar.value = '';
				return;
			}

			var parcelasPlenas = Math.floor(recebidoCents / valParcelaCents);
			var parcialCents = recebidoCents - (parcelasPlenas * valParcelaCents);

			var pIni = inicioParc;
			var pUlt = parcelasPlenas > 0 ? (inicioParc + parcelasPlenas - 1) : (inicioParc - 1);

			var PIniEl = document.getElementById('PIni');
			var PUltEl = document.getElementById('PUlt');
			var PsepEl = document.getElementById('Psep');

			if (PIniEl) PIniEl.textContent = pIni;

			if (PUltEl && PsepEl) {
				PUltEl.textContent = pUlt;
				if (parcelasPlenas > 1) {
					PsepEl.style.display = 'inline';
					PUltEl.style.display = 'inline';
				} else {
					PsepEl.style.display = 'none';
					PUltEl.style.display = 'none';
				}
			}

			setParcialColumnVisible(parcialCents > 0);
			document.getElementById('Parcial').textContent = parcialCents > 0 ? 'R$ ' + formatCentsToBR(parcialCents) : '';

			var hidIni = document.getElementById('txtparc_ini');
			var hidUlt = document.getElementById('txtparc_ult');
			var hidPar = document.getElementById('parcial');
			if (hidIni) hidIni.value = pIni;
			if (hidUlt) hidUlt.value = (parcelasPlenas > 0 ? pUlt : '');
			if (hidPar) hidPar.value = formatCentsToBR(parcialCents);

			var labelQtdPrestacoes = document.getElementById('labelQtdPrestacoes');
			if (labelQtdPrestacoes) {
				if (parcelasPlenas === 1) {
					labelQtdPrestacoes.textContent = 'Prestação Recebida';
				} else {
					labelQtdPrestacoes.textContent = 'Prestações Recebidas';
				}
			}

			var labelParcial = document.getElementById('labelParcial');
			if (labelParcial) {
				if (parcialCents > 0) {
					var prox = (pUlt || 0) + 1;
					labelParcial.textContent = 'Parcial da ' + prox + 'ª Prestação';
				} else {
					labelParcial.textContent = 'Parcial';
				}
			}
		}

		// Event listeners
		document.addEventListener('DOMContentLoaded', function() {
			['txtvalor', 'vlr_recebido', 'txtparc'].forEach(function(id) {
				var el = document.getElementById(id);
				if (el) {
					el.addEventListener('input', atualizaParcelas);
					el.addEventListener('blur', atualizaParcelas);
				}
			});

			atualizaParcelas();

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
				targetTable.style.display = (selectElement.value === '31') ? 'table' : 'none';
			}
		}
	</script>

	<?php
	$SisRot = "S-7.2.3";
	include "rodape.php";
	mysqli_close($conec); ?>

</body>

</html>
