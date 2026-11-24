<?php
$tipo = isset($_GET['tipo']) ? trim($_GET['tipo']) : 'BRINDE';
$NDoc = isset($_GET['NDoc']) ? trim($_GET['NDoc']) : '';
$PC = isset($_GET['PC']) ? trim($_GET['PC']) : '';
$Reg = isset($_GET['Reg']) ? trim($_GET['Reg']) : '';
$data = isset($_GET['data']) ? trim($_GET['data']) : '';
$horaaut = isset($_GET['horaaut']) ? trim($_GET['horaaut']) : '';
$dtAut = isset($_GET['dtAut']) ? trim($_GET['dtAut']) : '';
$SgRec = isset($_GET['SgRec']) ? trim($_GET['SgRec']) : 'GRT';
$Mat = isset($_GET['Mat']) ? trim($_GET['Mat']) : '';
$Mat_Vend = isset($_GET['mat_vend']) ? trim($_GET['mat_vend']) : '';
$Vendedora = isset($_GET['Vendedora']) ? trim($_GET['Vendedora']) : '';
$Cliente = isset($_GET['Cliente']) ? trim($_GET['Cliente']) : '';
$Brinde = isset($_GET['Brinde']) ? trim($_GET['Brinde']) : '';
$vlr_ext = isset($_GET['vlr_ext']) ? trim($_GET['vlr_ext']) : 'ZERO REAIS';

if ($data !== '') {
	$timestamp = strtotime($data);
	$data = $timestamp !== false ? date('d/m/Y', $timestamp) : $data;
}

$MatRec = substr($Mat, 0, 7) . "-" . substr($Mat, 7, 1);
$Autenticacao = $Reg . $PC . $horaaut . $NDoc . $dtAut . $SgRec . "000" . $MatRec;
?>
<!DOCTYPE html>
<html>

<head>
	<meta http-equiv="content-type" content="text/html; charset=utf-8">
	<title>Recibo - <?php echo htmlspecialchars($Cliente, ENT_QUOTES, 'UTF-8') . " - " . htmlspecialchars($tipo, ENT_QUOTES, 'UTF-8'); ?> GRATUIDADE</title>
	<meta name="generator" content="LibreOffice 7.4.7.2 (Linux)">

	<style type="text/css">
		.container {
			position: relative;
			width: fit-content;
			height: fit-content;
		}

		.endereco_box {
			display: inline-block;
			height: 65px;
			position: relative;
			width: 350px;
		}

		.endereco_logo {
			height: auto;
			left: 0;
			pointer-events: none;
			position: absolute;
			top: 7px;
			width: 50px;
			z-index: 2;
		}

		.imagem_end_1,
		.imagem_end_2 {
			margin-left: 55px;
			width: 285px;
			height: 65px;
			object-fit: contain;
		}

		body,
		div,
		table,
		thead,
		tbody,
		tfoot,
		tr,
		th,
		td,
		p,
		font {
			font-family: "Arial";
			font-size: x-small;
		}

		.descricao-brinde {
			display: inline-block;
			line-height: 1.35;
			padding: 2px 0;
			white-space: normal;
			word-break: normal;
		}

		@media print {
			html,
			body {
				height: 297mm;
				width: 210mm;
				margin: 0;
				padding: 0;
				overflow: hidden;
			}

			@page {
				margin: 2mm;
			}

			body {
				margin: 2mm;
				padding: 2mm;
			}

			header,
			footer,
			nav,
			.sem-imprimir {
				display: none !important;
			}
		}
	</style>
</head>

<body onload="window.print()">
	<div class="container">
		<table align="left" cellspacing="0" border="0">
			<colgroup width="100"></colgroup>
			<colgroup width="100"></colgroup>
			<colgroup width="5"></colgroup>
			<colgroup width="100"></colgroup>
			<colgroup width="100"></colgroup>
			<colgroup width="4"></colgroup>
			<colgroup span="2" width="100"></colgroup>
			<colgroup width="5"></colgroup>
			<colgroup span="2" width="100"></colgroup>
			<colgroup width="5"></colgroup>
			<colgroup span="2" width="100"></colgroup>

			<?php
			$vias = array(
				array('title' => 'VIA TESOURARIA', 'imagem' => 'imagem_end_1'),
				array('title' => 'VIA CLIENTE', 'imagem' => 'imagem_end_2')
			);

			foreach ($vias as $viaIndex => $via) {
				if ($viaIndex > 0) {
			?>
			<tr>
				<td colspan="14" height="26" align="center" valign="middle">
					<font size="1">------------------------------------------------------------------------------------------------------------------------------------------------------------------</font>
				</td>
			</tr>
			<?php } ?>

			<tr>
				<td height="17" align="left" valign="bottom"></td>
				<td style="border-top:1px solid #000000;border-bottom:1px solid #000000;border-left:1px solid #000000;border-right:1px solid #000000" colspan="4" rowspan="2" align="center" valign="middle">
					<b><font size="4"><?php echo htmlspecialchars($tipo, ENT_QUOTES, 'UTF-8'); ?></font></b>
				</td>
				<td align="left" valign="bottom"></td>
				<td style="border-top:1px solid #000000;border-left:1px solid #000000;border-right:1px solid #000000" colspan="2" align="center" valign="middle">
					<b><font size="1">RECIBO</font></b>
				</td>
				<td align="left" valign="bottom"></td>
				<td style="border-top:1px solid #000000;border-left:1px solid #000000;border-right:1px solid #000000" colspan="2" align="center" valign="middle">
					<b><font size="1">PC</font></b>
				</td>
				<td align="left" valign="bottom"></td>
				<td style="border-top:1px solid #000000;border-left:1px solid #000000;border-right:1px solid #000000" colspan="2" align="center" valign="middle">
					<b><font size="1">VALOR PAGO</font></b>
				</td>
			</tr>
			<tr>
				<td height="5" align="left" valign="bottom"></td>
				<td align="left" valign="bottom"></td>
				<td style="border-bottom:1px solid #000000;border-left:1px solid #000000;border-right:1px solid #000000" colspan="2" align="center" valign="middle">
					<font size="1"><?php echo htmlspecialchars($NDoc, ENT_QUOTES, 'UTF-8'); ?></font>
				</td>
				<td align="left" valign="bottom"></td>
				<td style="border-bottom:1px solid #000000;border-left:1px solid #000000;border-right:1px solid #000000" colspan="2" align="center" valign="middle">
					<font size="1"><?php echo htmlspecialchars($PC, ENT_QUOTES, 'UTF-8'); ?></font>
				</td>
				<td align="left" valign="bottom"></td>
				<td style="border-bottom:1px solid #000000;border-left:1px solid #000000;border-right:1px solid #000000" colspan="2" align="center" valign="middle">
					<font size="1">R$ 0,00</font>
				</td>
			</tr>
			<tr><td height="4" colspan="14" align="left" valign="bottom"></td></tr>

			<tr>
				<td style="border-top:1px solid #000000;border-bottom:1px solid #000000;border-left:1px solid #000000;border-right:1px solid #000000" colspan="4" rowspan="5" height="60" align="center" valign="middle">
					<span class="endereco_box">
						<img src="./images/logo.png" alt="Logo" class="endereco_logo">
						<img src="./images/endereco_pc<?php echo htmlspecialchars($PC, ENT_QUOTES, 'UTF-8'); ?>.png" class="<?php echo $via['imagem']; ?>" alt="Endereço">
					</span>
				</td>
				<td align="left" valign="bottom"></td>
				<td style="border-top:1px solid #000000;border-left:1px solid #000000;border-right:1px solid #000000" colspan="2" align="center" valign="middle">
					<b><font size="1">DATA</font></b>
				</td>
				<td align="left" valign="bottom"></td>
				<td style="border-top:1px solid #000000;border-left:1px solid #000000;border-right:1px solid #000000" colspan="3" align="center" valign="middle">
					<b><font size="1">COLABORADORA</font></b>
				</td>
				<td align="left" valign="bottom"></td>
				<td align="left" valign="bottom"></td>
				<td align="left" valign="bottom"></td>
			</tr>
			<tr>
				<td align="left" valign="bottom"></td>
				<td style="border-bottom:1px solid #000000;border-left:1px solid #000000;border-right:1px solid #000000" colspan="2" align="center" valign="middle">
					<font size="1"><?php echo htmlspecialchars($data, ENT_QUOTES, 'UTF-8'); ?></font>
				</td>
				<td align="left" valign="bottom"></td>
				<td style="border-bottom:1px solid #000000;border-left:1px solid #000000;border-right:1px solid #000000" colspan="3" align="center" valign="middle">
					<font size="1"><?php echo htmlspecialchars($Vendedora . " - " . $Mat_Vend, ENT_QUOTES, 'UTF-8'); ?></font>
				</td>
				<td align="left" valign="bottom"></td>
				<td align="left" valign="bottom"></td>
				<td align="left" valign="bottom"></td>
			</tr>
			<tr><td height="4" colspan="14" align="left" valign="bottom"></td></tr>
			<tr>
				<td align="left" valign="bottom"></td>
				<td style="border-top:1px solid #000000;border-bottom:1px solid #000000;border-left:1px solid #000000;border-right:1px solid #000000" colspan="2" rowspan="2" align="center" valign="middle">
					<font size="3"><b>GRATUIDADE</b></font>
				</td>
				<td align="left" valign="bottom"></td>
				<td style="border-top:1px solid #000000;border-bottom:1px solid #000000;border-left:1px solid #000000;border-right:1px solid #000000" colspan="6" rowspan="2" align="center" valign="middle">
					<font size="3"><b><i>BRINDE</i></b></font>
				</td>
				<td align="left" valign="bottom"></td>
			</tr>
			<tr><td height="4" colspan="14" align="left" valign="bottom"></td></tr>
			<tr><td height="4" colspan="14" align="left" valign="bottom"></td></tr>

			<tr>
				<td style="border-top:1px solid #000000;border-left:1px solid #000000;border-right:1px solid #000000" colspan="14" height="15" align="left" valign="middle">
					<b><font size="1">DESCRIÇÃO DO BRINDE</font></b>
				</td>
			</tr>
			<tr>
				<td style="border-bottom:1px solid #000000;border-left:1px solid #000000;border-right:1px solid #000000" colspan="14" height="28" align="center" valign="middle">
					<font size="1"><span class="descricao-brinde"><?php echo htmlspecialchars($Brinde, ENT_QUOTES, 'UTF-8'); ?></span></font>
				</td>
			</tr>
			<tr><td height="4" colspan="14" align="left" valign="bottom"></td></tr>

			<tr>
				<td style="border-top:1px solid #000000;border-left:1px solid #000000;border-right:1px solid #000000" colspan="14" height="15" align="left" valign="middle">
					<b><font size="1">RECEBEMOS</font></b>
				</td>
			</tr>
			<tr>
				<td style="border-bottom:1px solid #000000;border-left:1px solid #000000;border-right:1px solid #000000" colspan="14" height="17" align="center" valign="middle">
					<font size="1"><?php echo htmlspecialchars($Cliente, ENT_QUOTES, 'UTF-8'); ?></font>
				</td>
			</tr>
			<tr><td height="4" colspan="14" align="left" valign="bottom"></td></tr>

			<tr>
				<td style="border-top:1px solid #000000;border-left:1px solid #000000;border-right:1px solid #000000" colspan="14" height="15" align="left" valign="middle">
					<b><font size="1">A IMPORTÂNCIA TOTAL DE</font></b>
				</td>
			</tr>
			<tr>
				<td style="border-bottom:1px solid #000000;border-left:1px solid #000000;border-right:1px solid #000000" colspan="14" height="17" align="center" valign="middle">
					<font size="1"><?php echo htmlspecialchars($vlr_ext, ENT_QUOTES, 'UTF-8'); ?></font>
				</td>
			</tr>
			<tr><td height="4" colspan="14" align="left" valign="bottom"></td></tr>

			<tr>
				<td style="border-top:1px solid #000000;border-bottom:1px solid #000000;border-left:1px solid #000000;border-right:1px solid #000000" colspan="14" height="15" align="center" valign="middle">
					<b><font size="1">AUTENTICAÇÃO</font></b>
				</td>
			</tr>
			<tr><td height="4" colspan="14" align="left" valign="bottom"></td></tr>
			<tr>
				<td style="border-top:1px solid #000000;border-bottom:1px solid #000000;border-left:1px solid #000000;border-right:1px solid #000000" colspan="14" height="20" align="center" valign="middle">
					<font size="1"><?php echo htmlspecialchars($Autenticacao, ENT_QUOTES, 'UTF-8'); ?></font>
				</td>
			</tr>
			<tr><td height="4" colspan="14" align="left" valign="bottom"></td></tr>
			<tr>
				<td style="border-top:1px solid #000000;border-bottom:1px solid #000000;border-left:1px solid #000000;border-right:1px solid #000000" colspan="14" rowspan="2" height="30" align="center" valign="middle">
					<b><font size="5">(<?php echo htmlspecialchars($via['title'], ENT_QUOTES, 'UTF-8'); ?>)</font></b>
				</td>
			</tr>
			<?php } ?>
		</table>
	</div>
</body>
</html>
