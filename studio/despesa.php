<html>

<head>
	<title>WebCaixa v1.20.4_beta</title>
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

   <!-- Adicionando jQuery UI para o autocomplete -->
   <link rel="stylesheet" href="./css/themes.css">
   <script src="./js/jquery.js"></script>
   <script src="./js/ui.js"></script>

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
	</script>

	<script>
		$(function() {
			function setupAutocompleteVendedora(inputSelector, hiddenSelector) {
				var $el = $(inputSelector);
				$el.autocomplete({
					source: function(request, response) {
						$.ajax({
							url: "buscar_funcionarias.php",
							dataType: "json",
							data: {
								term: request.term
							},
							success: function(data) {
								var items = [];
								if (data && Array.isArray(data.nomes)) {
									for (var i = 0; i < data.nomes.length; i++) {
										items.push({
											label: data.mat_vend[i] + ' - ' + data.nomes[i],
											value: data.nomes[i],
											mat: data.mat_vend[i],
											nome: data.nomes[i]
										});
									}
								}
								response(items);
							}
						});
					},
					minLength: 2,
					delay: 300,
					select: function(event, ui) {
						$(hiddenSelector).val(ui.item.mat); // matrícula (hidden)
						$el.val(ui.item.nome); // nome no campo visível
						return false;
					},
					focus: function(event, ui) {
						$el.val(ui.item.nome);
						return false;
					}
				});
				var inst = $el.autocomplete("instance");
				if (inst) {
					inst._renderItem = function(ul, item) {
						return $("<li>")
							.append("<div>" + item.label + "</div>")
							.appendTo(ul);
					};
				}
			}

			// Aplicar autocomplete para cada campo de colaborador
			setupAutocompleteVendedora("#mat_vend_input_dp", "#mat_vend_dp");
			setupAutocompleteVendedora("#mat_vend_input_vt", "#mat_vend_vt");
			setupAutocompleteVendedora("#mat_vend_input_srv", "#mat_vend_srv");
		});

		function validaCampos() {
			var mat_vend = document.getElementById('mat_vend').value.trim();
			var cliente = document.getElementById('cliente').value.trim();

			if (mat_vend.length === 0) {
				alert('O campo Matrícula da Vendedora é obrigatório.');
				document.getElementById('mat_vend_input').focus();
				return false;
			}
			if (cliente.length <= 8) {
				alert('O campo Cliente deve ter mais que 8 letras.');
				document.getElementById('cliente').focus();
				return false;
			}

			return true;
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

		function mostrarTabelaDespesa() {

			var select = document.getElementById('lsPr');
			var selectedOption = select.options[select.selectedIndex];
			var selectedValue = select.value;

			// Pegue a classe da opção selecionada
			var optionClass = selectedOption.className;

			// Obtenha as tabelas
			var tabelaDP = document.getElementById('tb_despesas_dp');
			var tabelaRemb = document.getElementById('tb_reembolso_cli');
			var tablaValeTrans = document.getElementById('tb_vale_trans_dp');
			var tabelaServPrest = document.getElementById('tb_serv_prest_dp');

			// Inicialmente oculte ambas
			if (tabelaDP) tabelaDP.style.display = 'none';
			if (tabelaRemb) tabelaRemb.style.display = 'none';
			if (tablaValeTrans) tablaValeTrans.style.display = 'none';
			if (tabelaServPrest) tabelaServPrest.style.display = 'none';

			// Remove required de todos os campos de colaborador
			var camposColab = [
				document.getElementById('mat_vend_input_dp'),
				document.getElementById('mat_vend_input_vt'),
				document.getElementById('mat_vend_input_srv')
			];
			camposColab.forEach(function(c) {
				if (c) c.removeAttribute('required');
			});

			// Mostre a tabela correta
			if (selectedValue === '1' || optionClass.includes('despesa-dp')) {
				if (tabelaDP) tabelaDP.style.display = 'table';
				if (tabelaRemb) tabelaRemb.style.display = 'none';
				if (tablaValeTrans) tablaValeTrans.style.display = 'none';
				if (tabelaServPrest) tabelaServPrest.style.display = 'none';
				var colabDP = document.getElementById('mat_vend_input_dp');
				if (colabDP) colabDP.setAttribute('required', 'required');
			} else if (selectedValue === '5' || optionClass.includes('reembolso-cli')) {
				if (tabelaRemb) tabelaRemb.style.display = 'table';
				if (tabelaDP) tabelaDP.style.display = 'none';
				if (tablaValeTrans) tablaValeTrans.style.display = 'none';
				if (tabelaServPrest) tabelaServPrest.style.display = 'none';
			} else if (selectedValue === '7' || optionClass.includes('vale_trans-dp')) {
				if (tablaValeTrans) tablaValeTrans.style.display = 'table';
				if (tabelaDP) tabelaDP.style.display = 'none';
				if (tabelaRemb) tabelaRemb.style.display = 'none';
				if (tabelaServPrest) tabelaServPrest.style.display = 'none';
				var colabVT = document.getElementById('mat_vend_input_vt');
				if (colabVT) colabVT.setAttribute('required', 'required');
			} else if (selectedValue === '6' || optionClass.includes('serv_prest-dp')) {
				if (tabelaServPrest) tabelaServPrest.style.display = 'table';
				if (tabelaDP) tabelaDP.style.display = 'none';
				if (tabelaRemb) tabelaRemb.style.display = 'none';
				if (tablaValeTrans) tablaValeTrans.style.display = 'none';
				var colabSrv = document.getElementById('mat_vend_input_srv');
				if (colabSrv) colabSrv.setAttribute('required', 'required');
			}

			// Opcional: Limpar campos quando mudar de tabela
			if (selectedValue !== '1' && selectedValue !== '5' && selectedValue !== '7' && selectedValue !== '6') {
				// Limpa campos se não for nenhum dos três tipos especiais
				if (tabelaDP) {
					var colabDP = tabelaDP.querySelector('#mat_vend_input_dp');
					var matDP = tabelaDP.querySelector('#mat_vend_dp');
					var refDP = tabelaDP.querySelector('#lsref_desp');
					if (colabDP) colabDP.value = '';
					if (matDP) matDP.value = '';
					if (refDP) refDP.selectedIndex = 0;
				}
				if (tabelaRemb) {
					var cliente = tabelaRemb.querySelector('#cliente');
					var refRemb = tabelaRemb.querySelector('#lsref_remb');
					if (cliente) cliente.value = '';
					if (refRemb) refRemb.selectedIndex = 0;
				}
				if (tablaValeTrans) {
					var colabVT = tablaValeTrans.querySelector('#mat_vend_input_vt');
					var matVT = tablaValeTrans.querySelector('#mat_vend_vt');
					if (colabVT) colabVT.value = '';
					if (matVT) matVT.value = '';
				}
				if (tabelaServPrest) {
					var colabSrv = tabelaServPrest.querySelector('#mat_vend_input_srv');
					var matSrv = tabelaServPrest.querySelector('#mat_vend_srv');
					if (colabSrv) colabSrv.value = '';
					if (matSrv) matSrv.value = '';
				}
			}
		}

		// Função para inicializar na carga da página
		function inicializarTabelasDespesa() {
			// Inicialmente oculte ambas as tabelas
			var tabelaDP = document.getElementById('tb_despesas_dp');
			var tabelaRemb = document.getElementById('tb_reembolso_cli');
			var tablaValeTrans = document.getElementById('tb_vale_trans_dp');
			var tabelaServPrest = document.getElementById('tb_serv_prest_dp');

			if (tabelaDP) tabelaDP.style.display = 'none';
			if (tabelaRemb) tabelaRemb.style.display = 'none';
			if (tablaValeTrans) tablaValeTrans.style.display = 'none';
			if (tabelaServPrest) tabelaServPrest.style.display = 'none';

			// Chame a função para mostrar a tabela correta baseado na seleção atual
			mostrarTabelaDespesa();
		}

		// Execute quando a página carregar
		$(document).ready(function() {
			inicializarTabelasDespesa();
		});
	</script>

	<script src="val_pag.js" charset="utf-8"></script>

</head>

<body background="../images/bg1.jpg" text="#FFFFFF" onLoad="putFocus(0,0)">

	<?php
	// Obtendo o Login
	$Sis     = "S7";
	$Rot     = "S7R3.1";
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
			<center><u><i>DESPESAS</i></u></center>
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
		$SdCaixa = number_format($Cx, 2, ".", "");

	?>

		<table width="85%" border="5" cellpadding="10" cellspacing="0" align="center">
			<form name="pgtos" method="post" action="confdesp.php" OnSubmit="JavaScript:return checkdata()">
				<tr>
					<td width="32%" align="center">
						<font color='gold' size='5'><b><i>Código</i></b></font>
					</td>
					<td width="33%" align="center">
						<font color='gold' size='5'><b><i>Valor</i></b></font>
					</td>
					<td width="35%" align="center">
						<font color='gold' size='5'><b><i>Tipo de Despesa</i></b></font>
					</td>
				</tr>

				<tr>
					<td width="32%" align="center">
						<input type="text" name="txtcod" size="6" maxlength="6" class="campos" onkeypress="fPassaAlfaNumerico('an')" onkeyup="this.value=this.value.toUpperCase()">&nbsp;&nbsp;&nbsp;
						<input type="text" name="txtcod2" size="6" maxlength="6" class="campos" onkeypress="fPassaAlfaNumerico('an')" onkeyup="this.value=this.value.toUpperCase()">
					</td>
					<td width="33%" align="center">
						<font size='4'><b><i>R$ </i></b></font>
						<input type="text" name="txtvalor" size="7" maxlength="7" class="campos" OnKeyUp="FormataValor('pgtos', 'txtvalor', event);">
						<input type="hidden" name="txtuser" value="<?php echo $lg_user; ?>">
						<input type="hidden" name="txtcaixa" value="<?php echo $SdCaixa; ?>">
					</td>
					<td width="35%" align="center">
						<select name="lsPr" id="lsPr" class="campos" onchange="mostrarTabelaDespesa()">
							<?php
							// Obtendo a Relação
							// Conectando ao Banco de Dados
							include "dbselect.php";

							// Criando a Instrução SQL de Consulta
							//$sqlpr = "select * from pgtos where codpag <> 3 order by codpag";
							$sqlpr = "select * from pgtos order by codpag";

							// Consultando os Registros
							$rspr = mysqli_query($conec, $sqlpr) or die("Não foi possível acessar os Dados");

							// Criando o Array para o campo PC
							while ($lnpr = mysqli_fetch_array($rspr)) {
								$CodPag  = $lnpr['codpag'];
								$TipoPag = $lnpr['tipopag'];

								$classe = "";

								if ($CodPag == '1') {
									$classe = "despesa-dp";
								} elseif ($CodPag == '5') {
									$classe = "reembolso-cli";
								} elseif ($CodPag == '7') {
									$classe = "vale_trans-dp";
								}
							?>
								<option value="<?php echo $CodPag; ?>" class="<?php echo $classe; ?> campos">
									<?php echo "$TipoPag"; ?>
								</option>
							<?php
							}
							mysqli_free_result($rspr);
							?>
						</select>
					</td>
				</tr>
		</table>

		<br>

		<table id="tb_despesas_dp" width="85%" border="5" cellpadding="10" cellspacing="0" align="center">
			<tr>
				<td width="50%" align="center">
					<font color='gold' size='5'><b><i>Reterente</i></b></font>
				</td>
				<td width="50%" align="center">
					<font color='gold' size='5'><b><i>Colaborador(a)</i></b></font>
				</td>
			</tr>

			<tr>
				<td width="50%" align="center">
					<select name="lsref_desp" id="lsref_desp" class="campos">
						<?php
						// Criando a Instrução SQL de Consulta
						$sqlpr = "SELECT * FROM tiporef WHERE ref_tiporec <> 'RCL' ORDER BY codref";
						$rspr = mysqli_query($conec, $sqlpr) or die("Não foi possível acessar os Dados");

						while ($lnpr = mysqli_fetch_array($rspr)) {
							$CodRef_Desp  = $lnpr['codref'];
							$TipoRef_Desp = $lnpr['nomeref'];
						?>
							<option value="<?php echo $TipoRef_Desp; ?>" class="campos">
								<?php echo "$TipoRef_Desp"; ?>
							</option>
						<?php
						}
						mysqli_free_result($rspr);
						?>
					</select>
				</td>
				<td width="50%" align="center">
					<input type="text" id="mat_vend_input_dp" name="colab_dp" size="40" maxlength="8" class="campos"
						onkeypress="fPassaAlfaNumerico('an')"
						onkeyup='this.value=this.value.toUpperCase(); validnome(this)' required autofocus>
					<input type="hidden" name="mat_colab_dp" id="mat_vend_dp" value="<?php echo $matVendEsc; ?>">
				</td>
			</tr>
		</table>

		<table id="tb_reembolso_cli" width="85%" border="5" cellpadding="10" cellspacing="0" align="center">
			<tr>
				<td width="50%" align="center">
					<font color='gold' size='5'><b><i>Reterente</i></b></font>
				</td>
				<td width="50%" align="center">
					<font color='gold' size='5'><b><i>Cliente</i></b></font>
				</td>
			</tr>

			<tr>
				<td width="50%" align="center">
					<select name="lsref_remb" id="lsref_remb" class="campos">
						<?php
						// Criando a Instrução SQL de Consulta
						$sqlpr = "SELECT * FROM tiporef WHERE ref_tiporec <> 'DDP' ORDER BY codref";
						$rspr = mysqli_query($conec, $sqlpr) or die("Não foi possível acessar os Dados");

						while ($lnpr = mysqli_fetch_array($rspr)) {
							$CodRef_Remb  = $lnpr['codref'];
							$TipoRef_Remb = $lnpr['nomeref'];
						?>
							<option value="<?php echo $TipoRef_Remb; ?>" class="campos">
								<?php echo "$TipoRef_Remb"; ?>
							</option>
						<?php
						}
						mysqli_free_result($rspr);
						?>
					</select>
				</td>
				<td width="50%" align="center">
					<input type="text" id="cliente" name="cliente" size="40" maxlength="50" class="campos"
						onkeypress="fPassaAlfaNumerico('an')"
						onkeyup='this.value=this.value.toUpperCase(); validnome(this)'>
				</td>
			</tr>
		</table>

		<table id="tb_vale_trans_dp" width="85%" border="5" cellpadding="10" cellspacing="0" align="center">
			<tr>
				<td width="50%" align="center">
					<font color='gold' size='5'><b><i>Colaborador(a)</i></b></font>
				</td>
			</tr>

			<tr>
				<td width="50%" align="center">
					<input type="text" id="mat_vend_input_vt" name="colab_vt" size="40" maxlength="8" class="campos"
						onkeypress="fPassaAlfaNumerico('an')"
						onkeyup='this.value=this.value.toUpperCase(); validnome(this)' required autofocus>
					<input type="hidden" name="mat_colab_vt" id="mat_vend_vt" value="<?php echo $matVendEsc; ?>">
				</td>
			</tr>
		</table>

		<table id="tb_serv_prest_dp" width="85%" border="5" cellpadding="10" cellspacing="0" align="center">
			<tr>
				<td width="50%" align="center">
					<font color='gold' size='5'><b><i>Colaborador(a)</i></b></font>
				</td>
			</tr>

			<tr>
				<td width="50%" align="center">
					<input type="text" id="mat_vend_input_srv" name="colab_srv" size="40" maxlength="8" class="campos"
						onkeypress="fPassaAlfaNumerico('an')"
						onkeyup='this.value=this.value.toUpperCase(); validnome(this)' required autofocus>
					<input type="hidden" name="mat_colab_srv" id="mat_vend_srv" value="<?php echo $matVendEsc; ?>">
				</td>
			</tr>
		</table>

		<br>

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
	$SisRot = "S-7.3.1";
	include "rodape.php";
	mysqli_close($conec); ?>

</body>

</html>