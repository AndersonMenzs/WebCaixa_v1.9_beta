<?php
// Debug
//error_reporting(E_ALL);
//

//
ini_set('error_log', 'php_errors.log');

?>
<html>

<head>
	<title>WebCaixa v1.20.12_beta</title>
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
	</style>

	<script>
		function toggleDoc(doc) {
			var linhas = document.querySelectorAll(".doc_" + doc);

			linhas.forEach(function(l) {
				if (l.style.display === "none") {
					l.style.display = "table-row";
				} else {
					l.style.display = "none";
				}
			});
		}
	</script>

	<?php
	// Inserindo o Cabeçalho
	include "../cabecprs.php";
	?>
</head>

<body background="../images/bg1.jpg" text="#FFFFFF" onLoad="putFocus(0,0)">

	<?php
	// Obtendo o Login
	$Sis      = "S7";
	$Rot      = "S7R1.1.1";
	$lg_user  = $_POST['txtuser'];
	$user  = substr($lg_user, 0, 8);
	$pss   = substr($lg_user, 8, 40);
	$DataAut  = $_POST['txtdata'];
	$dtD    = substr($DataAut, 0, 2);
	$dtM    = substr($DataAut, 3, 2);
	$dtA    = substr($DataAut, 6, 4);
	$DataForm = "$dtA-$dtM-$dtD";

	include "us_sist.php";
	if ($ch == 'no') {
		include "us_cad.php";
	} ?>

	<table width="100%" border="0" cellpadding="05" cellspacing="0" align="center">
		<tr>
			<td>
				<a href="cnt.php?c_s=<?php echo $lg_user ?>"><img src="./images/voltar.gif"></a>
			</td>
			<td align="center">
				<font color="gold" size="6">
					<b><u><i>Autenticações do Dia - <font color='#FFFFFF'><?php echo $DataAut; ?></i></u></center></b>
				</font>
			</td>
			<td>
				<a href="cnt.php?c_s=<?php echo $lg_user ?>"><img src="./images/voltar.gif"></a>
			</td>
		</tr>
	</table><br><br>
	<?php

	if ($ch == 'ok-enc' or $ch == 'ok-cai' or $ch == 'ok') {
		// Consultando o Banco de Dados
		include "conexao.php";
		include "dbselect.php";

		$sql = "
				SELECT 
					caixa.fita,
					registro.reg,
					registro.numdoc,
					registro.tiporec,
					registro.subtipo,
					registro.parcela,
					registro.datarec,
					registro.horarec,
					registro.vlrec,
					registro.operador,
					registro.estorno,
					registro.modpgto,

					COALESCE(tiporec.siglarec, registro.subtipo) AS siglarec,
					formapag.siglapag

				FROM caixa

				INNER JOIN registro 
					ON caixa.dtopen = registro.datarec

				LEFT JOIN tiporec 
					ON tiporec.siglarec = registro.subtipo

				LEFT JOIN formapag 
					ON formapag.codpag = registro.modpgto

				WHERE registro.datarec = '$DataForm'

				ORDER BY 
					registro.reg,
					registro.numdoc,
					registro.parcela,
					registro.subtipo DESC
				";

		$rs   = mysqli_query($conec, $sql) or die("Erro de Banco de Dados #1. Contate seu Administrador");
		$regs = mysqli_num_rows($rs);

		if ($regs > 0) { ?>
			<table border="01" cellpadding="05" cellspacing="0" align="center">
				<tr>
					<td>
						<font size='4' color='aqua'><b><i>Fita</i></b></font>
					</td>
					<td>
						<font size='4' color='aqua'><b><i>Autentic.</i></b></font>
					</td>
					<td>
						<font size='4' color='aqua'><b><i>Documento</i></b></font>
					</td>
					<td>
						<font size='4' color='aqua'><b><i>Rec.</i></b></font>
					</td>
					<td>
						<font size='4' color='aqua'><b><i>Parcela</i></b></font>
					</td>
					<td>
						<font size='4' color='aqua'><b><i>Data Rec.</i></b></font>
					</td>
					<td>
						<font size='4' color='aqua'><b><i>Hora Rec.</i></b></font>
					</td>
					<td>
						<font size='4' color='aqua'><b><i>Valor Rec</i></b></font>
					</td>
					<td>
						<font size='4' color='aqua'><b><i>Forma</i></b></font>
					</td>
					<td>
						<font size='4' color='aqua'><b><i>Operador</i></b></font>
					</td>
					<td>
						<font size='4' color='aqua'><b><i>Estornado</i></b></font>
					</td>
				</tr>

				<?php

				$docsCount = [];
				$docsTotal = [];
				$docsEstorno = [];
				$doscX = [];

				mysqli_data_seek($rs, 0);

				while ($tmp = mysqli_fetch_assoc($rs)) {

					$d   = $tmp['numdoc'];
					$temEstorno = !empty($tmp['estorno']) ? 1 : 0;
					$groupKey = $d . "_" . $temEstorno;
					$vlr = floatval($tmp['vlrec']);

					if (!empty($tmp['estorno'])) {
						$docsEstorno[$groupKey] = true;
						$doscX[$groupKey] = true;
					}

					if (!isset($docsCount[$groupKey])) {
						$docsCount[$groupKey] = 0;
						$docsTotal[$groupKey] = 0;
					}

					$docsCount[$groupKey]++;
					// Não somar se estiver marcado com x (estorno) ou se subtipo for EST
					if (empty($tmp['estorno']) && $tmp['siglarec'] != 'EST') {
						$docsTotal[$groupKey] += $vlr;
					}
				}
				mysqli_data_seek($rs, 0);

			// Agrupar dados por documento e criar grupos separados por estorno
			$docsByKey = [];
			$docsFirstRow = [];
			$docsCNTP = []; // Rastrear CNTP com múltiplas formas

			while ($ln = mysqli_fetch_assoc($rs)) {
				$Doc = $ln['numdoc'];
				$temEstorno = !empty($ln['estorno']) ? 1 : 0;
				$groupKey = $Doc . "_" . $temEstorno;

				if (!isset($docsByKey[$groupKey])) {
					$docsByKey[$groupKey] = [];
					$docsFirstRow[$groupKey] = $ln; // Guardar primeira linha de cada grupo
				}

				$docsByKey[$groupKey][] = $ln;
				
				// Detectar CNTP
				if ($ln['siglarec'] == 'CNTP') {
					if (!isset($docsCNTP[$Doc])) {
						$docsCNTP[$Doc] = [];
					}
					$docsCNTP[$Doc][] = $ln;
				}
			}
			
			// Verificar quais CNTP têm múltiplas formas de pagamento
			$docsCNTPMultiplas = [];
			foreach ($docsCNTP as $Doc => $registros) {
				$formas = array_unique(array_column($registros, 'modpgto'));
				if (count($formas) > 1) {
					$docsCNTPMultiplas[$Doc] = true;
				}
			}

			mysqli_data_seek($rs, 0);

			// Exibir cada documento com seus registros
			$docsIndexPrinted = [];

			foreach ($docsByKey as $groupKey => $allRows) {

				$docsIndexPrinted[$groupKey] = 0;
				
				// Extrair o número do documento do groupKey
				$docArray = explode("_", $groupKey);
				$Doc = $docArray[0];
				$temEstorno = $docArray[1];

				foreach ($allRows as $ln) {

					$Fita    = $ln['fita'];
					$Reg     = $ln['reg'];
					$RegF    = substr(10000 + $Reg, 1, 4);
					$SubTipo = $ln['siglarec'];
					$ModPgto = $ln['siglapag'];
					$Parc    = $ln['parcela'] ?: "-";

					$DtRec   = $ln['datarec'];
					$RecFull = substr($DtRec, 8, 2) . "/" . substr($DtRec, 5, 2) . "/" . substr($DtRec, 0, 4);

					$HrRec   = $ln['horarec'];
					$VlRec   = $ln['vlrec'];
					$VlRecF  = number_format($VlRec, 2, ",", ".");

					$Oper    = $ln['operador'];
					$OpFull  = substr($Oper, 0, 7) . "-" . substr($Oper, 7, 1);

					$Estorno = $ln['estorno'];

					$docsIndexPrinted[$groupKey]++;

					// Linha Pai (primeira linha do grupo)
					if ($docsIndexPrinted[$groupKey] == 1) {

						echo "<tr onclick=\"toggleDoc('{$groupKey}')\" style='cursor:pointer'>";

						echo "
							<td><b><i>{$Fita}</b></i></td>
							<td align='right'><b><i>{$RegF}</b></i></td>
							<td align='right'><b><i>{$Doc}</b></i></td>
							<td align='right'><b><i><font color='" . ($SubTipo == 'EST' ? "red" : "white") . "'>{$SubTipo}</font></b></i></td>
							<td align='center'><b><i>-</b></i></td>
							<td align='right'><b><i>{$RecFull}</b></i></td>
							<td align='right'><b><i>{$HrRec}</b></i></td>
							<td align='right'><b><i>R$ " . number_format($docsTotal[$groupKey], 2, ",", ".") . "</b></i></td>
							<td align='center'><b><i>-</b></i></td>
							<td align='right'><b><i>{$OpFull}</b></i></td>
							<td align='center'><b>".(!empty($docsEstorno[$groupKey]) ? "x" : "-")."</b></td>
							</tr>";
					}

					// Linha Filha
					echo "<tr class='doc_{$groupKey}' style='display:none;color:gold;'>";

					echo "
						<td><b><i>{$Fita}</b></i></td>
						<td align='right'><b><i>{$RegF}</b></i></td>
						<td align='right'><b><i>{$Doc}</b></i></td>
						<td align='right'><b><i><font color='" . ($SubTipo == 'EST' ? "red" : "gold") . "'>{$SubTipo}</font></b></i></td>
						<td align='center'><b><i>{$Parc}</b></i></td>
						<td align='right'><b><i>{$RecFull}</b></i></td>
						<td align='right'><b><i>{$HrRec}</b></i></td>
						<td align='right'><b><i>R$ {$VlRecF}</b></i></td>
						<td align='right'><b><i>{$ModPgto}</b></i></td>
						<td align='right'><b><i>{$OpFull}</b></i></td>
						<td align='center'><b><i>" . ($Estorno != "" ? "x" : "-") . "</b></i></td>
						</tr>";
				}
			}
				?>
			</table>
		<?php
		} else {
		?>
			<br><br>
			<font size='6' color='gold'><b>
					<center>
						<blink><u>Nenhum</u></blink>
						<font color='#FFFFFF'> Registro Encontrado Nesta Data!!!
					</center>
				</b></font><?php
						} ?>
		<br><br>
		<center><a href="cnt.php?c_s=<?php echo $lg_user ?>"><img src="./images/voltar.gif"></a></center><br>
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
		<center><a href='cnt.php?c_s=<?php echo $lg_user; ?>'><img src='images/voltar.gif'></a></center><br><br>
	<?php
	}

	// Encerrando
	$SisRot = "S-7.1.1.1";
	include "rodape.php";

	// Encerrando as Conexões
	mysqli_close($conec);
	?>

</body>

</html>