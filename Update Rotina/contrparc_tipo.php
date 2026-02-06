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

		/* Estilo para o autocomplete */
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
	</script>

	<script>
		function FormataValor(Formulario, Campo, TeclaPres) {
			try {
				// normaliza evento/tecla
				var evt = TeclaPres || window.event || {};
				var tecla = evt.keyCode || evt.which || 0;

				// obtém form de forma segura
				var form = null;
				if (typeof Formulario === 'string') {
					form = document.forms[Formulario] || document.querySelector('form[name="' + Formulario + '"]');
				} else {
					form = document.forms[0];
				}

				// obtém campo de forma segura (por name ou id)
				var strCampo = null;
				if (form) {
					strCampo = form.elements[Campo] || form[Campo];
				}
				if (!strCampo) {
					strCampo = document.getElementById(Campo) || document.querySelector('[name="' + Campo + '"]');
				}

				if (!strCampo) {
					// elemento não encontrado — evita erro
					// console.warn('FormataValor: campo não encontrado', Formulario, Campo);
					return false;
				}

				// limpa formato atual e monta novo valor
				var vr = String(strCampo.value || '');
				vr = vr.replace(/[\/\.,\-\s]/g, '');

				var tam = vr.length;
				var TamanhoMaximo = 12; // permite entradas maiores, ex: 9999.99 => mais caracteres

				if (tam < TamanhoMaximo && tecla !== 8) tam = vr.length + 1;
				if (tecla === 8) tam = tam - 1;

				// aceita backspace e números (teclado normal e numpad)
				if (tecla === 8 || (tecla >= 48 && tecla <= 57) || (tecla >= 96 && tecla <= 105)) {
					if (tam <= 3) {
						strCampo.value = vr;
					} else if (tam > 3 && tam <= TamanhoMaximo) {
						strCampo.value = vr.substr(0, tam - 3) + '.' + vr.substr(tam - 3, tam);
					}
				}
				return true;
			} catch (e) {
				// evita quebrar a página
				// console.error('FormataValor error', e);
				return false;
			}
		}
	</script>

	<?php
	// Inserindo o Cabeçalho
	include "../cabecprs.php";
	?>

	<!-- Adicionando jQuery UI para o autocomplete -->
	<link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
	<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
	<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js"></script>

	<script type="text/javascript" src="val_parcela.js" charset="utf-8">
	</script>

</head>

<body background="../images/bg1.jpg" text="#FFFFFF" onLoad="putFocus(0,0)">

	<?php

	// Obtendo o Login
	$Sis     = "S7";
	$Rot     = "S7R2.3";
	$lg_user = $_REQUEST['c_s'];
	$user = substr($lg_user, 0, 8);
	$pss  = substr($lg_user, 8, 40);

	$Contrato = trim($_POST['txtdoc']);
	$mat_vend = trim($_POST['mat_vend']);
	$Vendedora = trim($_POST['vendedora']);
	$Cliente	= trim($_POST['cliente']);
	
	// Converter para centavos diretamente, evitando imprecisão de ponto flutuante
	// Remove separadores de milhar (.) e converte vírgula em ponto decimal
	$valor_str = str_replace(',', '.', str_replace('.', '', $_POST['txtvalor'] ?? '0'));
	$vlr_recebido_str = str_replace(',', '.', str_replace('.', '', $_POST['vlr_recebido'] ?? '0'));
	
	// Converte para centavos usando intval + arredondamento seguro
	$valC = intval(round(floatval($valor_str) * 100));
	$recC = intval(round(floatval($vlr_recebido_str) * 100));
	$txtparc = intval($_POST['txtparc'] ?? 0);

	$parcelasPlenas = $valC > 0 ? intdiv($recC, $valC) : 0;
	$parcialC = $recC - ($parcelasPlenas * $valC);

	$PIni = $txtparc;
	$PUlt = $parcelasPlenas > 0 ? ($txtparc + $parcelasPlenas - 1) : ($txtparc - 1);

	// próxima parcela caso haja parcial (ex: se PIni..PUlt = 1..5, próxima = 6)
	$nextParc = $PUlt + 1;
	$Parcial = number_format($parcialC / 100, 2, '.', ',');

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
		<form name="parcela" method="post" action="confcntparc.php" onsubmit="return checkdata()" autocomplete="off">
			<table width="95%" border="5" cellpadding="10" cellspacing="0" align="center">
				<tr>
					<td width="12%" align="center">
						<font color='gold' size='5'><b><i>Contrato</i></b></font>
					</td>
					<td width="40%" align="center">
						<font color='gold' size='5'><b><i>Vendedora</i></b></font>
					</td>
					<td width="40%" align="center">
						<font color='gold' size='5'><b><i>Cliente</i></b></font>
					</td>
				</tr>
				<tr>
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
					<td width="15%" align="center">
						<font color='gold' size='4'><b><i>Vlr. Prestação</i></b></font>
					</td>
					<td width="15%" align="center">
						<font color='gold' size='4'><b><i>Vlr. Recebido</i></b></font>
					</td>
					<td width="10%" align="center">
						<font color='gold' size='4'><b><i>Nº Prestação</i></b></font>
					</td>
					<td width="12%" align="center">
						<font color='gold' size='4'>
							<b>
								<i>
									<span id="labelQtdPrestacoes">Parcela(s)</span>
								</i>
							</b>
							</font>
					</td>
					<td width="12%" align="center">
						<font color='gold' size='4'><b><i><span id="labelParcial"><?php echo ($parcialC > 0) ? 'Parcial . ' . $parcialC . 'ª Parcela' : 'Parcial'; ?></span></i></b></font>
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
						<input type="text" name="txtparc" id="txtparc" size="4" maxlength="4" class="campos" onkeyup="validate(this)">
					</td>
					<td rowspan="3" align="center">
						<input type="hidden" name="txtparc_ini" id="txtparc_ini" value="<?php echo $PIni; ?>">
						<input type="hidden" name="txtparc_ult" id="txtparc_ult" value="<?php echo $PUlt; ?>">
						<font color='#FFFFFF' size='4'><b><i>
									<span id="PIni"><?php echo $PIni; ?></span>
									<span id="Psep" style="<?php echo ($parcelasPlenas > 1) ? '' : 'display:none;'; ?>"> a </span>
									<span id="PUlt" style="<?php echo ($parcelasPlenas > 1) ? '' : 'display:none;'; ?>"><?php echo $PUlt; ?></span>
								</i></b></font>
					</td>
					<td rowspan="3" align="center">
						<input type="hidden" name="parcial" id="parcial" value="<?php echo $Parcial; ?>">
						<font color='#FFFFFF' size='4'><b><i><span id="Parcial"><?php echo $Parcial; ?></span></i></b></font>
					</td>
					<input type="hidden" name="txtuser" value="<?php echo htmlspecialchars($lg_user, ENT_QUOTES); ?>">
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
					<td align="center">
						<font color='#FFFFFF' size='4'><b><i>R$ </i></b></font>
						<input type="text" name="txt1" id="txt1" size="6" maxlength="7" class="campos" onKeyUp="FormataValor('parcela', 'txt1', event); validate(this)">
					</td>
				</tr>
			</table><br>

			<table width="100%" border="0" cellspacing="0">
				<tr>
					<td width="9%"></td>
					</td>
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

		function atualizaParcelas() {
			var valParcelaCents = parseCurrencyToCents(document.getElementById('txtvalor').value);
			var recebidoCents = parseCurrencyToCents(document.getElementById('vlr_recebido').value);
			var inicioParc = parseInt((document.getElementById('txtparc').value || '0'), 10) || 0;

			if (valParcelaCents <= 0 || recebidoCents <= 0 || inicioParc <= 0) {
				// limpa exibição se dados inválidos
				document.getElementById('PIni').textContent = '';
				document.getElementById('PUlt').textContent = '';
				document.getElementById('Parcial').textContent = '';

				// limpar hidden também
				var hidIni = document.getElementById('txtparc_ini');
				var hidUlt = document.getElementById('txtparc_ult');
				var hidPar = document.getElementById('parcial');
				if (hidIni) hidIni.value = '';
				if (hidUlt) hidUlt.value = '';
				if (hidPar) hidPar.value = '';
				return;
			}

			var parcelasPlenas = Math.floor(recebidoCents / valParcelaCents);
			var parcialCents = recebidoCents - (parcelasPlenas * valParcelaCents);

			var pIni = inicioParc;
			var pUlt = parcelasPlenas > 0 ? (inicioParc + parcelasPlenas - 1) : (inicioParc - 1); // se 0, nenhuma plena

			var PIniEl = document.getElementById('PIni');
			var PUltEl = document.getElementById('PUlt');
			var PsepEl = document.getElementById('Psep');

			if (PIniEl) PIniEl.textContent = pIni;

			if (PUltEl && PsepEl) {
				PUltEl.textContent = pUlt; // atualiza sempre o valor
				// mostrar 'a' e o PUlt somente quando houver mais de uma prestação plena
				if (parcelasPlenas > 1) {
					PsepEl.style.display = 'inline';
					PUltEl.style.display = 'inline';
				} else {
					PsepEl.style.display = 'none';
					PUltEl.style.display = 'none';
				}
			}

			document.getElementById('Parcial').textContent = 'R$ ' + formatCentsToBR(parcialCents);

			// atualizar hidden inputs do formulário para serem enviados
			var hidIni = document.getElementById('txtparc_ini');
			var hidUlt = document.getElementById('txtparc_ult');
			var hidPar = document.getElementById('parcial'); // já existe no HTML
			if (hidIni) hidIni.value = pIni;
			if (hidUlt) hidUlt.value = (parcelasPlenas > 0 ? pUlt : '');
			if (hidPar) hidPar.value = formatCentsToBR(parcialCents); // formato BR (ex: "50,00")

			// Atualizar o label da quantidade de prestações
			var labelQtdPrestacoes = document.getElementById('labelQtdPrestacoes');
			if (labelQtdPrestacoes) {
				if (parcelasPlenas === 1) {
					labelQtdPrestacoes.textContent = 'Prestação Recebida';
				} else {
					labelQtdPrestacoes.textContent = 'Prestações Recebidas';
				}
			}

			// Atualizar o label do cabeçalho Parcial quando houver valor parcial
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

		// ligar eventos
		['txtvalor', 'vlr_recebido', 'txtparc'].forEach(function(id) {
			var el = document.getElementById(id);
			if (!el) return;
			el.addEventListener('input', atualizaParcelas);
			el.addEventListener('blur', atualizaParcelas);
		});
		// chama uma vez ao carregar
		document.addEventListener('DOMContentLoaded', atualizaParcelas);
	</script>

	<?php

	// Encerrando as Conexões
	$SisRot = "S-7.2.3";
	include "rodape.php";
	mysqli_close($conec); ?>

</body>

</html>