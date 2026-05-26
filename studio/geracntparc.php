	<?php
//Debug

ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include 'conexao.php';
include 'dbselect.php';
?>

<html>

<head>
	<title>WebCaixa v1.20.17_beta</title>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
	<style type="text/css">
		body {
			margin-top: 5%;
			margin-left: 5%;
			margin-right: 5%;
			border: 3px solid gray;
			padding: 10px 10px 10px 10px;
			font-family: sans-serif;
		}

		.campos {
			background-color: #C0C0C0;
			font: 12px sans-serif;
			color: #000000;
		}
	</style>

	<?php
	// Inserindo Cabeçalho
	include "../cabecprs.php";
	?>
</head>

<body background="../images/bg1.jpg" text="#FFFFFF">

	<?php
	/*$dados = filter_input_array(INPUT_POST, FILTER_DEFAULT);
	echo "<pre>";
	var_dump($dados);
	echo "</pre>";
	exit();*/

	// Importando os Dados do Formulário
	$Sis       = "S7";
	$Rot       = "S7R2.2.1.1";
	$dtRec     = date('Y-m-d');
	$dtComp    = date('Y-m-d');
	$lg_user   = trim($_POST['txtuser'] ?? '');
	$user      = substr($lg_user, 0, 8);
	$pss       = substr($lg_user, 8, 40);
	$Pass      = strtolower(trim($_POST['txtsen'] ?? ''));
	$Senha     = sha1($Pass);
	$Mat_Vend  = trim($_POST['mat_vend'] ?? '');
	$Vendedora = trim($_POST['vendedora'] ?? '');
	$Vendedora_full = trim($_POST['vendedora'] ?? '');
	$Cliente   = trim($_POST['cliente'] ?? '');

	$NDoc      = trim($_POST['txtdoc'] ?? '');
	$NDoc_a    = trim($_POST['txtdoc'] ?? '');

	$FPag_1    = trim($_POST['lsPr1'] ?? '');
	$FPag_2    = trim($_POST['lsPr2'] ?? '');
	$FPag_3    = trim($_POST['lsPr3'] ?? '');
	$txt1      = isset($_POST['txt1']) ? (float) str_replace(',', '.', $_POST['txt1']) : 0;
	$txt2      = isset($_POST['txt2']) ? (float) str_replace(',', '.', $_POST['txt2']) : 0;
	$txt3      = isset($_POST['txt3']) ? (float) str_replace(',', '.', $_POST['txt3']) : 0;

	$VrRec     = $txt1 + $txt2 + $txt3;
	$VrPrest   = trim($_POST['vrprest'] ?? '');
	$VrRecF    = number_format($VrRec, 2, ',', '.');
	$QtdeParc  = (int) trim($_POST['qtdeparc'] ?? 0);
	$Parc      = trim($_POST['vrprest'] ?? '');
	$PIni      = (int) trim($_POST['txtparc_ini'] ?? 1);
	$PUlt      = (int) trim($_POST['txtparc_ult'] ?? 0);
	$Parcial   = $_POST['vrparcial'] ?? '';
	$Ref_Std   = trim($_POST['ref_std']);
	$Parc_Card_Cred = trim($_POST['parc_card_cred'] ?? '');
	$ModPag    = trim($_POST['modpgto'] ?? '');
	$Rdopt     = trim($_POST['rdopt'] ?? '');
	$Pedido    = trim($_POST['pedido'] ?? '');
	$Quitacao  = isset($_POST['chk_quitacao']) && $_POST['chk_quitacao'] == '1';

	function moedaParaFloat($valor) {
		$valor = trim((string) $valor);
		$valor = str_replace(['R$', ' '], '', $valor);
		if (strpos($valor, ',') !== false) {
			$valor = str_replace('.', '', $valor);
			$valor = str_replace(',', '.', $valor);
		}
		return (float) $valor;
	}

	function moedaParaCentavos($valor) {
		return (int) round(moedaParaFloat($valor) * 100);
	}

	if ($Quitacao && moedaParaFloat($Parcial) > 0) {
		$SisRot = "S-7.2.2.1.1";
		include "./rodape.php";
		echo "<script>alert('Quitação não pode conter parcial. Ajuste o valor recebido.'); window.history.back();</script>";
		mysqli_close($conec);
		exit;
	}

	$ValorQuitacaoCents = moedaParaCentavos($VrPrest) * (int) $QtdeParc;
	$ValorRecebidoCents = (int) round($VrRec * 100);

	if ($Quitacao && $ValorQuitacaoCents > 0 && $ValorRecebidoCents != $ValorQuitacaoCents) {
		$SisRot = "S-7.2.2.1.1";
		include "./rodape.php";
		echo "<script>alert('Valor recebido incorreto para quitação. O valor correto é R$ " . number_format($ValorQuitacaoCents / 100, 2, ',', '.') . ".'); window.history.back();</script>";
		mysqli_close($conec);
		exit;
	}

	$Estorno = '';
	$hora    = date('H:i');

	// Truncar o nome da vendedora
	if (!empty($Vendedora)) {
		$Vendedora = strtoupper($Vendedora);
		$posicao_espaco = strpos($Vendedora, ' ');
		if ($posicao_espaco !== false) {
			$Vendedora = substr($Vendedora, 0, $posicao_espaco + 1) . substr($Vendedora, $posicao_espaco + 1, 1) . '.';
		}
	}

	// Tipo do produto
	$TipoRec   = '3';
	$SubTipo   = 'CNTP';
	$DataHoje  = date('Y-m-d');

	// Verificar se o operador digitou a senha correta
	$sqlo = "SELECT * FROM operador WHERE pass = '$Senha'";
	$rso  = mysqli_query($conec, $sqlo);

	if (!$rso) {
		die("<p style='color:red'>Erro na consulta de operador: " . mysqli_error($conec) . "</p>");
	}

	$regso = mysqli_num_rows($rso); ?>

	<font color="gold" size="6">
		<br><b>
			<center><u><i>Sistema de Autenticação</i></u></center>
		</b>
	</font><br>
	<?php

	include "us_cad.php";

	if ($ch == 'ok' or $ch == 'ok-enc' or $ch == 'ok-cai' or $ch == 'ok-adm') {
		if ($regso > 0) {

			$lno  = mysqli_fetch_array($rso);
			$Mat  = $lno['mat'];

			// Formatar MatRec UMA VEZ antes do loop (não a cada iteração!)
			$MatRec = substr($Mat, 1, 6) . "-" . substr($Mat, 7, 1);

			// Verificar se a quantidade de parcelas é válida
			if ($QtdeParc <= 0) {
				die("<p style='color:red'>ERRO: Quantidade de parcelas inválida!</p>");
			}

			// Buscar o último registro
			$sqlr = "SELECT * FROM registro ORDER BY datarec DESC, reg DESC LIMIT 1";
			$rsr  = mysqli_query($conec, $sqlr);

			if (!$rsr) {
				die("<p style='color:red'>Erro na consulta de registro: " . mysqli_error($conec) . "</p>");
			}

			$regsr = mysqli_num_rows($rsr);
			$Reg = 0;

			if ($regsr > 0) {
				$lnr = mysqli_fetch_array($rsr);
				$Reg     = (int) $lnr['reg'];
				$dtReceb = $lnr['datarec'];

				if ($dtComp != $dtReceb) {
					$Reg = 0;
				}
			}

			// Gravando o Registro
			$valorTotal = $VrRec;
			$parcelaInicial = $PIni;
			$quantidadeParcelas = $QtdeParc;

			// Pagamentos - REMOVER VALORES ZERO
			$pagamentos = [];
			if ($txt1 > 0 && !empty($FPag_1)) {
				$pagamentos[] = ['modpgto' => $FPag_1, 'valor' => $txt1];
			}
			if ($txt2 > 0 && !empty($FPag_2)) {
				$pagamentos[] = ['modpgto' => $FPag_2, 'valor' => $txt2];
			}
			if ($txt3 > 0 && !empty($FPag_3)) {
				$pagamentos[] = ['modpgto' => $FPag_3, 'valor' => $txt3];
			}

			// PROCESSAMENTO

			// 1. Verificar se total dos pagamentos é igual ao valor total
			$totalPagamentos = 0;
			foreach ($pagamentos as $p) {
				$totalPagamentos += $p['valor'];
			}

			// 2. Calcular valor de cada parcela
			$valorParcela = $valorTotal / $quantidadeParcelas;

			// 3. Calcular percentual de cada forma de pagamento
			$percentuais = [];
			foreach ($pagamentos as $pagamento) {
				$percentuais[$pagamento['modpgto']] = $pagamento['valor'] / $valorTotal;
			}

			// 4. Inserir os registros (sem prepared statements para manter 100% estrutural)
			$totalInserido = 0;
			$parcelaFinal = $parcelaInicial + $quantidadeParcelas - 1;
			$contadorRegistro = 1;

			// Iniciar transação
			mysqli_begin_transaction($conec);

			try {
				for ($parcela = $parcelaInicial; $parcela <= $parcelaFinal; $parcela++) {

					foreach ($pagamentos as $index => $pagamento) {

						// Calcula o valor rateado
						$valorRateado = round($valorParcela * $percentuais[$pagamento['modpgto']], 2);

						// Se for o último registro, ajusta para fechar o total
						if ($parcela == $parcelaFinal && $index == count($pagamentos) - 1) {
							$valorRateado = round($valorTotal - $totalInserido, 2);
						}

						// Incrementa o registro
						$Reg++;

						// Escapar os dados para evitar SQL injection
						$Reg = (int) $Reg;
						$NDoc = mysqli_real_escape_string($conec, $NDoc);
						$TipoRec = mysqli_real_escape_string($conec, $TipoRec);
						$SubTipo = mysqli_real_escape_string($conec, $SubTipo);
						$ModPgto = mysqli_real_escape_string($conec, $pagamento['modpgto']);
						$Parcela = (int) $parcela;
						$dtRec = mysqli_real_escape_string($conec, $dtRec);
						$horarec = mysqli_real_escape_string($conec, $hora);
						$VrRateado = number_format($valorRateado, 2, '.', '');
						$Operador = mysqli_real_escape_string($conec, $user);
						$Estorno = mysqli_real_escape_string($conec, $Estorno);
						$Mat_Vend = mysqli_real_escape_string($conec, $Mat_Vend);
						$Vendedora_Full = mysqli_real_escape_string($conec, $Vendedora_full);
						$Cliente = mysqli_real_escape_string($conec, $Cliente);

						// Query de inserção
						$sqlP = "INSERT INTO registro 
                        (reg, numdoc, tiporec, subtipo, modpgto, parcela, datarec, horarec, vlrec, operador, estorno, mat_vend, vendedora, cliente) 
                        VALUES 
                        ($Reg, '$NDoc', '$TipoRec', '$SubTipo', '$ModPgto', $Parcela, 
                        '$dtRec', '$horarec', $VrRateado, '$Operador', '$Estorno', 
                        '$Mat_Vend', '$Vendedora_Full', '$Cliente')";

						// Executar
						if (mysqli_query($conec, $sqlP)) {
							$totalInserido += $valorRateado;
							$contadorRegistro++;
						}
					}
				}
				// Criando o spool após inserir os registros para garantir que o reg seja o correto
				$sqlReg = "SELECT MIN(reg) AS reg FROM registro WHERE datarec = '$dtRec' AND numdoc = '$NDoc'";
				$rsReg = mysqli_query($conec, $sqlReg) or die("File geracntparc Error #2. Contate seu Administrador.");
				$lnReg = mysqli_fetch_array($rsReg);
				$Reg = $lnReg['reg'];

				$RegFull = 10000 + $Reg;
				$RegSp = substr($RegFull, 1, 4);

				$sqlPC = "select pc from inicial";
				$rsPC = mysqli_query($conec, $sqlPC) or die("File geracntparc Error #3. Contate seu Administrador.");
				$lnPC = mysqli_fetch_array($rsPC);
				$PCSp = $lnPC['pc'];

				$hSp = substr($hora, 0, 2);
				$mSp = substr($hora, 3, 2);
				$HoraSp = $hSp . $mSp;
				$NDocSp = $NDoc;
				$dtAutSp = date('dmy');

				// Buscar sigla do tipo de recebimento (CNTP)
				$sqlSg = "select siglarec from tiporec where codrec = '$TipoRec'";
				$rsSg = mysqli_query($conec, $sqlSg) or die("File geracntparc Error #4. Contate seu Administrador.");
				$lnSg = mysqli_fetch_array($rsSg);
				$SgRecSp = $lnSg['siglarec']; // CNTP

				// Buscar TODAS as siglas das formas de pagamento de uma vez
				$codigosPag = [];
				if ($FPag_1 != "00") $codigosPag[] = "'$FPag_1'";
				if ($FPag_2 != "00") $codigosPag[] = "'$FPag_2'";
				if ($FPag_3 != "00") $codigosPag[] = "'$FPag_3'";

				$siglasPorCodigo = [];
				if (!empty($codigosPag)) {
					$sqlFm = "SELECT codpag, siglapag FROM formapag WHERE codpag IN (" . implode(',', $codigosPag) . ")";
					$rsFm = mysqli_query($conec, $sqlFm) or die("File geracntparc Error #5. Contate seu Administrador.");

					while ($lnFm = mysqli_fetch_assoc($rsFm)) {
						$siglasPorCodigo[$lnFm['codpag']] = $lnFm['siglapag'];
					}
				}

				// Commit da transação ANTES de gravar os spools
				mysqli_commit($conec);

				// Gravar registros no spool e spool2 para cada forma de pagamento com valor > 0
				// Cada forma gera seu próprio registro com CNTP + SIGLA (individual)

				if ($FPag_1 != "00" && $txt1 > 0 && isset($siglasPorCodigo[$FPag_1])) {
					$valorFormatado = 'R$ ' . number_format($txt1, 2, ',', '.');
					$Spo = $RegSp . $PCSp . $HoraSp . $NDocSp . $dtAutSp . $valorFormatado . $SgRecSp . $siglasPorCodigo[$FPag_1] . $MatRec;

					$sqlSp1 = "insert into spool values('$RegSp', '$Spo')";
					$rsSp1 = mysqli_query($conec, $sqlSp1) or die("File geracntparc Error #6. Contate seu Administrador.");

					$sqlSp2 = "insert into spool2 values('$RegSp', '$Spo')";
					$rsSp2 = mysqli_query($conec, $sqlSp2) or die("File geracntparc Error #7. Contate seu Administrador.");
				}

				if ($FPag_2 != "00" && $txt2 > 0 && isset($siglasPorCodigo[$FPag_2])) {
					$valorFormatado = 'R$ ' . number_format($txt2, 2, ',', '.');
					$Spo = $RegSp . $PCSp . $HoraSp . $NDocSp . $dtAutSp . $valorFormatado . $SgRecSp . $siglasPorCodigo[$FPag_2] . $MatRec;

					$sqlSp1 = "insert into spool values('$RegSp', '$Spo')";
					$rsSp1 = mysqli_query($conec, $sqlSp1) or die("File geracntparc Error #6. Contate seu Administrador.");

					$sqlSp2 = "insert into spool2 values('$RegSp', '$Spo')";
					$rsSp2 = mysqli_query($conec, $sqlSp2) or die("File geracntparc Error #7. Contate seu Administrador.");
				}

				if ($FPag_3 != "00" && $txt3 > 0 && isset($siglasPorCodigo[$FPag_3])) {
					$valorFormatado = 'R$ ' . number_format($txt3, 2, ',', '.');
					$Spo = $RegSp . $PCSp . $HoraSp . $NDocSp . $dtAutSp . $valorFormatado . $SgRecSp . $siglasPorCodigo[$FPag_3] . $MatRec;

					$sqlSp1 = "insert into spool values('$RegSp', '$Spo')";
					$rsSp1 = mysqli_query($conec, $sqlSp1) or die("File geracntparc Error #6. Contate seu Administrador.");

					$sqlSp2 = "insert into spool2 values('$RegSp', '$Spo')";
					$rsSp2 = mysqli_query($conec, $sqlSp2) or die("File geracntparc Error #7. Contate seu Administrador.");
				}
			} catch (Exception $e) {
				// Rollback em caso de erro
				mysqli_rollback($conec);
				//echo "<p style='color:red'>ERRO: " . $e->getMessage() . "</p>";
			} ?>
			<form name="geracntparc" method="post" action="via1newparc.php">

				<input type="hidden" name="txtuser" value="<?php echo $lg_user; ?>">
				<input type="hidden" name="txtreg" value="<?php echo $RegSp; ?>">
				<input type="hidden" name="txtmat" value="<?php echo $Operador; ?>">
				<input type="hidden" name="ref_std" value="<?php echo $Ref_Std; ?>">
				<input type="hidden" name="txtdoc" value="<?php echo $NDoc; ?>">
				<input type="hidden" name="sgrec" value="<?php echo $SgRecSp; ?>">
				<input type="hidden" name="pc" value="<?php echo $PCSp; ?>">
				<input type="hidden" name="tiporec" value="<?php echo $TipoRec; ?>">
				<input type="hidden" name="lsPr1" value="<?php echo $FPag_1; ?>">
				<input type="hidden" name="lsPr2" value="<?php echo $FPag_2; ?>">
				<input type="hidden" name="lsPr3" value="<?php echo $FPag_3; ?>">
				<input type="hidden" name="txt1" value="<?php echo $txt1; ?>">
				<input type="hidden" name="txt2" value="<?php echo $txt2; ?>">
				<input type="hidden" name="txt3" value="<?php echo $txt3; ?>">
				<input type="hidden" name="parc_card_cred" value="<?php echo $Parc_Card_Cred; ?>">
				<input type="hidden" name="modpag" value="<?php echo $ModPag; ?>">
				<input type="hidden" name="dtrec" value="<?php echo $dtRec; ?>">
				<input type="hidden" name="txthora" value="<?php echo $hora; ?>">
				<input type="hidden" name="mat_vend" value="<?php echo $Mat_Vend; ?>">
				<input type="hidden" name="vendedora" value="<?php echo $Vendedora; ?>">
				<input type="hidden" name="cliente" value="<?php echo $Cliente; ?>">
				<input type="hidden" name="vrprest" value="<?php echo $VrPrest; ?>">
				<input type="hidden" name="vrrec" value="<?php echo $VrRec; ?>">
				<input type="hidden" name="qtdeparc" value="<?php echo $QtdeParc; ?>">
				<input type="hidden" name="txtparc_ini" value="<?php echo $PIni; ?>">
				<input type="hidden" name="txtparc_ult" value="<?php echo $PUlt; ?>">
				<input type="hidden" name="txtparc" value="<?php echo $Parcial; ?>">
				<input type="hidden" name="vrparcial" value="<?php echo $Parcial; ?>">
				<input type="hidden" name="rdopt" value="<?php echo $Rdopt; ?>">
				<input type="hidden" name="pedido" value="<?php echo $Pedido; ?>">

				<font size='6'><b>
						<center>Verifique se a impressora do <font color='gold'>
								<blink>Caixa</blink>
								<font color='#FFFFFF'> está ligada e com papel.
									<p>Logo após clique no <font color='gold'>
											<blink>botão abaixo</blink>
											<font color='#FFFFFF'>.</center>
					</b></font>
				</p><br>
				<center><input id="ghost_click" type="submit" name="btimprime" value="Autenticar" autofocus></center><br>
				<center>
					<font color='#FFFFFF' size='3'><span id="msg"></span></font>
				</center>
			</form>
		<?php
		} else { ?>
			<font size='6'><b>
					<center>Senha <font color='gold'>
							<blink>Incorreta</blink><br>
							<font color='#FFFFFF'>ou<br>
								Usuário <font color='gold'>
									<blink>Não Autorizado</blink>
									<font color="#FFFFFF">!!!</center>
				</b></font><br>
			<center><a href='JavaScript:window.history.back()'><img src='images/voltar.gif'></a></center><br>
	<?php
		}
	}

	mysqli_close($conec);

	// Inserindo Rodapé
	$SisRot = "S-7.2.2.1.1";
	include "./rodape.php"; ?>

	<script src="./js/ghost_click.js"></script>

</body>

</html>
