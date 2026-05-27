<?php

function post($chave, $padrao = '')
{
    return $_POST[$chave] ?? $padrao;
}

function num($chave, $padrao = 0.0)
{
    $valor = post($chave, $padrao);

    if (is_array($valor)) {
        return (float) $padrao;
    }

    $valor = trim((string) $valor);

    if ($valor === '') {
        return (float) $padrao;
    }

    if (strpos($valor, ',') !== false) {
        $valor = str_replace('.', '', $valor);
        $valor = str_replace(',', '.', $valor);
    }

    return (float) $valor;
}

function moeda($valor)
{
    return number_format((float) $valor, 2, ',', '.');
}

$lg_user        = post('txtuser');
$TipoFech       = post('tipofech');
$Fita           = post('fita');
$ano            = post('ano');
$PC             = post('pc');
$dataFch        = post('datafch');
$hora           = post('hora');
$userF          = post('operador');
$app            = post('app');
$inicial        = num('abertura', 0);

$NTxProd        = num('ntxprod', 0);
$ValorProd      = num('ntxprodvlr', 0);
$NConcurso      = num('nconc', 0);
$ValorConc      = num('nconcvlr', 0);
$NContEnt       = num('ncontent', 0);
$ValorContEnt   = num('ncontentvlr', 0);
$NContParc      = num('ncontparc', 0);
$ValorContParc  = num('ncontparcvlr', 0);
$NPropEnt       = num('npropent', 0);
$ValorPropEnt   = num('npropentvlr', 0);
$NPRecs         = num('nprod', 0);
$VrPRecsF       = num('nprodvlr', 0);
$NBookRec       = num('nbookrec', 0);
$VrBookRecF     = num('nbookrecvlr', 0);
$NumPgtos       = num('npgtos', 0);
$PgtoServicos   = num('npgtototvlr', 0);
$NEstorno       = num('nestorno', 0);
$ValorEstorno   = num('nestornovlr', 0);

$Dinheiro       = num('dinheiro', 0);
$PixQRCode      = num('pixqrcode', 0);
$PixCNPJ        = num('pixcnpj', 0);
$CardDeb        = num('carddeb', 0);
$CardVista      = num('cardvista', 0);
$CardParcLj     = num('cardparclj', 0);
$TotIn          = num('totin', 0);

$DDPF           = num('pessoal', 0);
$MCSF           = num('mconsumo', 0);
$MDVF           = num('mdivulgacao', 0);
$MPDF           = num('mproducao', 0);
$RCLF           = num('reembcliente', 0);
$SRVF           = num('servprest', 0);
$VTRF           = num('valetrans', 0);
$OUTF           = num('outros', 0);
$PgtoTot        = num('totdesp', 0);

$Recolh         = num('recolh', 0);
$TotPgto        = num('totpgto', 0);

$IncSobraF      = num('incsobraf', 0);
$Errlanc        = post('errlanc', []);

$FechamentoF    = num('fechamentof', 0);
$GavAut         = num('gavaut', 0);
$DifCx          = num('difcx', 0);
$cd             = post('cd');

$Diferenca      = post('diferenca', false);

$Spo            = post('spo2', []);
$Oper           = post('oper', []);
$SolicSenha     = post('solicsenha', []);

$inicialFmt        = moeda($inicial);
$ValorProdFmt      = moeda($ValorProd);
$ValorConcFmt      = moeda($ValorConc);
$ValorContEntFmt   = moeda($ValorContEnt);
$ValorContParcFmt  = moeda($ValorContParc);
$ValorPropEntFmt   = moeda($ValorPropEnt);
$VrPRecsFFmt       = moeda($VrPRecsF);
$VrBookRecFFmt     = moeda($VrBookRecF);
$PgtoServicosFmt   = moeda($PgtoServicos);
$ValorEstornoFmt   = moeda($ValorEstorno);

$DinheiroFmt       = moeda($Dinheiro);
$PixQRCodeFmt      = moeda($PixQRCode);
$PixCNPJFmt        = moeda($PixCNPJ);
$CardDebFmt        = moeda($CardDeb);
$CardVistaFmt      = moeda($CardVista);
$CardParcLjFmt     = moeda($CardParcLj);
$TotInFmt          = moeda($TotIn);

$DDPFFmt           = moeda($DDPF);
$MCSFFmt           = moeda($MCSF);
$MDVFFmt           = moeda($MDVF);
$MPDFFmt           = moeda($MPDF);
$RCLFFmt           = moeda($RCLF);
$SRVFFmt           = moeda($SRVF);
$VTRFFmt           = moeda($VTRF);
$PgtoTotFmt        = moeda($PgtoTot);

$RecolhFmt         = moeda($Recolh);
$TotPgtoFmt        = moeda($TotPgto);

$IncSobraFFmt      = moeda($IncSobraF);
$FechamentoFFmt    = moeda($FechamentoF);
$GavAutFmt         = moeda($GavAut);
$DifCxFmt          = moeda($DifCx);

?>

<!DOCTYPE html>
<html>

<head>
	<meta http-equiv="content-type" content="text/html; charset=utf-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1" />
	<title>WebCaixa v1.20.18_beta</title>
	<meta name="generator" content="LibreOffice 25.2.3.2 (Linux)" />
	<meta name="created" content="2026-04-19T12:11:10.519774564" />
	<meta name="changed" content="2026-04-20T15:19:01.024157216" />
	<style type="text/css">
		:root {
			--a4-width: 210mm;
			--a4-height: 297mm;
			--cor-titulo: #b2b2b2;
			--cor-subtitulo: #cccccc;
			--cor-cabecalho: #eeeeee;
			--cor-branco: #ffffff;
			--cor-borda: #000000;
			--fonte-padrao: Arial, Helvetica, sans-serif;
			--fonte-relatorio: "DejaVu Sans", Arial, Helvetica, sans-serif;
			--fs-11: 11pt;
			--fs-8: 8pt;
			--fs-7: 7pt;
			--fs-6: 6pt;
			--fs-58: 5.8pt;
			--padrao-padding: 0in;
		}

		@page {
			size: A4 portrait;
			margin: 5mm;
		}

		html,
		body {
			margin: 0;
			padding: 0;
			background: #dcdcdc;
		}

		body {
			font-family: Arial, Helvetica, sans-serif;
			color: #000;
		}

		.page {
			width: var(--a4-width);
			min-height: var(--a4-height);
			margin: 5px auto;
			padding: 5mm;
			box-sizing: border-box;
			background: #fff;
			box-shadow: 0 0 12px rgba(0, 0, 0, .18);
			overflow: visible;
		}

		table {
			border-collapse: collapse;
		}

		p {
			margin: 0 0 0.6mm 0;
			line-height: 1.05;
			background: transparent;
		}

		td {
			vertical-align: top;
		}

		td p {
			widows: 0;
			orphans: 0;
			background: transparent;
		}

		font {
			line-height: 1;
			font-family: var(--fonte-relatorio);
		}

		.fonte-rel {
			font-family: var(--fonte-relatorio);
		}

		.fs-11 {
			font-size: var(--fs-11);
		}

		.fs-8 {
			font-size: var(--fs-8);
		}

		.fs-7 {
			font-size: var(--fs-7);
		}

		.fs-6 {
			font-size: var(--fs-6);
		}

		.fs-58 {
			font-size: var(--fs-58);
		}

		.txt-centro {
			text-align: center;
		}

		.txt-esq {
			text-align: left;
		}

		.txt-dir {
			text-align: right;
		}

		.celula-titulo {
			background: var(--cor-titulo);
			border: 1px solid var(--cor-borda);
			padding: var(--padrao-padding);
		}

		.celula-subtitulo {
			background: var(--cor-subtitulo);
			border: none;
			padding: var(--padrao-padding);
		}

		.celula-cabecalho {
			background: var(--cor-cabecalho);
			border: none;
			padding: var(--padrao-padding);
		}

		.celula-padrao {
			border: none;
			padding: var(--padrao-padding);
			vertical-align: top;
		}

		.bg-titulo {
			background: var(--cor-titulo);
		}

		.bg-subtitulo {
			background: var(--cor-subtitulo);
		}

		.bg-cab {
			background: var(--cor-cabecalho);
		}

		.bg-branco {
			background: var(--cor-branco);
		}

		.coluna-topo {
			vertical-align: top !important;
		}

		.coluna-box {
			height: 100%;
			min-height: 230px;
			display: flex;
			flex-direction: column;
			justify-content: space-between;
		}

		.coluna-conteudo {
			flex: 1;
		}

		.coluna-total {
			margin-top: 6px;
		}

		.tabela-interna td {
			vertical-align: top !important;
		}

		.bloco-linha {
			width: 100%;
			font-size: 0;
			margin-bottom: 0.05in;
		}

		.bloco-4 {
			width: 49%;
			display: inline-block;
			vertical-align: top;
			font-size: 12px;
			margin-bottom: 0.05in;
		}

		.bloco-esq {
			margin-right: 1%;
		}

		.bloco-full {
			width: 100%;
			display: block;
			font-size: 12px;
			margin-bottom: 0.05in;
		}

		.bloco-autenticacoes {
			width: 100%;
			display: block;
			font-size: 12px;
			margin-bottom: 0.05in;
		}

		.quebra-pagina-95 {
			break-before: page;
			page-break-before: always;
		}

		.bloco-vazio {
			width: 49%;
			display: inline-block;
			vertical-align: top;
			font-size: 12px;
			margin-bottom: 0.05in;
		}

		@media screen {
			.page {
				transform: scale(1.4);
				transform-origin: top center;
			}
		}

		@media print {

			html,
			body {
				background: #fff;
				width: auto;
				height: auto;
			}

			body {
				box-sizing: border-box;
				padding: 0;
			}

			.container {
				width: 100%;
				margin: 0;
				padding: 0;
				box-sizing: border-box;
			}

			.page {
				width: 100%;
				min-height: 0;
				margin: 0;
				padding: 0;
				box-shadow: none;
				overflow: visible;
			}

			body {
				-webkit-print-color-adjust: exact;
				print-color-adjust: exact;
			}

			table {
				page-break-inside: auto;
			}

			tr,
			td,
			.bloco-4,
			.bloco-full {
				break-inside: avoid;
				page-break-inside: avoid;
			}

			.bloco-autenticacoes,
			.bloco-autenticacoes table {
				break-inside: auto;
				page-break-inside: auto;
			}

			.bloco-autenticacoes tr,
			.bloco-autenticacoes td {
				break-inside: avoid;
				page-break-inside: avoid;
			}
		}
	</style>
</head>

<body lang="pt-BR" link="#000080" vlink="#800000" dir="ltr" onload="prepararImpressao()">
	<div class="container">
		<div class="page">
			<div class="row">
				<table width="100%" cellpadding="4" cellspacing="0" style="margin-bottom: 0.05in">
					<tr>
						<td width="100%" height="32" bgcolor="#cccccc" style="background: #cccccc; border: 1px solid #000000; padding: 0in">
							<p class="txt-centro">
								<font class="fonte-rel">
									<font size="2" class="fs-11">
										<b>ESTRELLA PHOTO STUDIO</b>
									</font>
								</font>
							</p>
							<p class="txt-centro">
								<font class="fonte-rel">
									<font size="1" class="fs-8">
										<b>FECHAMENTO DO WEBCAIXA (<?= $TipoFech ?>)</b>
									</font>
								</font>
							</p>
						</td>
					</tr>
				</table>
			</div>

			<table width="100%" cellpadding="4" cellspacing="0" style="margin-bottom: 0.05in">
				<tr>
					<td width="16%" bgcolor="#999999" style="background: #999999; border: 1px solid #000000; padding: 0in">
						<p class="txt-centro">
							<font class="fonte-rel">
								<font size="1" class="fs-7">
									<b>FITA</b>
								</font>
							</font>
						</p>
					</td>
					<td width="1%" bgcolor="#ffffff" style="background: #ffffff; border: none; padding: 0in"></td>
					<td width="16%" bgcolor="#999999" style="background: #999999; border: 1px solid #000000; padding: 0in">
						<p class="txt-centro">
							<font class="fonte-rel">
								<font size="1" class="fs-7">
									<b>PC</b>
								</font>
							</font>
						</p>
					</td>
					<td width="1%" bgcolor="#ffffff" style="background: #ffffff; border: none; padding: 0in"></td>
					<td width="16%" bgcolor="#999999" style="background: #999999; border: 1px solid #000000; padding: 0in">
						<p class="txt-centro">
							<font class="fonte-rel">
								<font size="1" class="fs-7">
									<b>DATA</b>
								</font>
							</font>
						</p>
					</td>
					<td width="1%" bgcolor="#ffffff" style="background: #ffffff; border: none; padding: 0in"></td>
					<td width="16%" bgcolor="#999999" style="background: #999999; border: 1px solid #000000; padding: 0in">
						<p class="txt-centro">
							<font class="fonte-rel">
								<font size="1" class="fs-7">
									<b>HORA</b>
								</font>
							</font>
						</p>
					</td>
					<td width="1%" bgcolor="#ffffff" style="background: #ffffff; border: none; padding: 0in"></td>
					<td width="16%" bgcolor="#999999" style="background: #999999; border: 1px solid #000000; padding: 0in">
						<p class="txt-centro">
							<font class="fonte-rel">
								<font size="1" class="fs-7">
									<b>OPERADOR</b>
								</font>
							</font>
						</p>
					</td>
					<td width="1%" bgcolor="#ffffff" style="background: #ffffff; border: none; padding: 0in"></td>
					<td width="16%" bgcolor="#999999" style="background: #999999; border: 1px solid #000000; padding: 0in">
						<p class="txt-centro">
							<font class="fonte-rel">
								<font size="1" class="fs-7"><b>ABERTURA</b></font>
							</font>
						</p>
					</td>
				</tr>
				<tr>
					<td width="16%" height="13" bgcolor="#ffffff" style="background: #ffffff; border-top: none; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000; padding-top: 0in; padding-bottom: 0in; padding-left: 0in; padding-right: 0in">
						<p class="txt-centro">
							<font class="fonte-rel">
								<font size="1" class="fs-7"><?= $Fita ?>/<?= $ano ?></font>
							</font>
						</p>
					</td>
					<td width="1%" bgcolor="#ffffff" style="background: #ffffff; border: none; padding: 0in"></td>
					<td width="16%" bgcolor="#ffffff" style="background: #ffffff; border-top: none; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000; padding-top: 0in; padding-bottom: 0in; padding-left: 0in; padding-right: 0in">
						<p class="txt-centro">
							<font class="fonte-rel">
								<font size="1" class="fs-7"><?= $PC ?></font>
							</font>
						</p>
					</td>
					<td width="1%" bgcolor="#ffffff" style="background: #ffffff; border: none; padding: 0in"></td>
					<td width="16%" bgcolor="#ffffff" style="background: #ffffff; border-top: none; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000; padding-top: 0in; padding-bottom: 0in; padding-left: 0in; padding-right: 0in">
						<p class="txt-centro">
							<font class="fonte-rel">
								<font size="1" class="fs-7"><?= $dataFch ?></font>
							</font>
						</p>
					</td>
					<td width="1%" bgcolor="#ffffff" style="background: #ffffff; border: none; padding: 0in"></td>
					<td width="16%" bgcolor="#ffffff" style="background: #ffffff; border-top: none; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000; padding-top: 0in; padding-bottom: 0in; padding-left: 0in; padding-right: 0in">
						<p class="txt-centro">
							<font class="fonte-rel">
								<font size="1" class="fs-7"><?= $hora ?></font>
							</font>
						</p>
					</td>
					<td width="1%" bgcolor="#ffffff" style="background: #ffffff; border: none; padding: 0in"></td>
					<td width="16%" bgcolor="#ffffff" style="background: #ffffff; border-top: none; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000; padding-top: 0in; padding-bottom: 0in; padding-left: 0in; padding-right: 0in">
						<p class="txt-centro">
							<font class="fonte-rel">
								<font size="1" class="fs-7"><?= $app ?></font>
							</font>
						</p>
					</td>
					<td width="1%" bgcolor="#ffffff" style="background: #ffffff; border: none; padding: 0in"></td>
					<td width="16%" bgcolor="#ffffff" style="background: #ffffff; border-top: none; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000; padding-top: 0in; padding-bottom: 0in; padding-left: 0in; padding-right: 0in">
						<p class="txt-centro">
							<font class="fonte-rel">
								<font size="1" class="fs-7">
									<b>R$ <?= $inicialFmt ?></b>
								</font>
							</font>
						</p>
					</td>
				</tr>
			</table>

			<table width="100%" cellpadding="4" cellspacing="0" style="margin-bottom: 0.05in">
				<tr>
					<td width="49%" height="14" bgcolor="#b2b2b2" style="background: #b2b2b2; border: 1px solid #000000; padding: 0in">
						<p class="txt-centro">
							<font class="fonte-rel">
								<font size="1" class="fs-6">
									<b>RECEBIMENTOS</b>
								</font>
							</font>
						</p>
					</td>
					<td width="1%" style="border: none; padding: 0in"></td>
					<td width="49%" bgcolor="#b2b2b2" style="background: #b2b2b2; border: 1px solid #000000; padding: 0in">
						<p class="txt-centro">
							<font class="fonte-rel">
								<font size="1" class="fs-6">
									<b>PAGAMENTOS</b>
								</font>
							</font>
						</p>
					</td>
				</tr>
			</table>

			<table width="100%" cellpadding="4" cellspacing="0" style="margin-bottom: 0.05in">
				<tr>
					<td width="24%" height="11" bgcolor="#dddddd" style="background: #dddddd; border: 1px solid #000000; padding: 0in">
						<p class="txt-centro">
							<font class="fonte-rel">
								<font size="1" class="fs-6">
									<b>TIPO SERVIÇO</b>
								</font>
							</font>
						</p>
					</td>
					<td width="1%" bgcolor="#ffffff" style="background: #ffffff; border: none; padding: 0in"></td>
					<td width="24%" bgcolor="#dddddd" style="background: #dddddd; border: 1px solid #000000; padding: 0in">
						<p class="txt-centro">
							<font class="fonte-rel">
								<font size="1" class="fs-6">
									<b>FORMA RECEBIMENTO</b>
								</font>
							</font>
						</p>
					</td>
					<td width="1%" bgcolor="#ffffff" style="background: #ffffff; border: none; padding: 0in"></td>
					<td width="24%" bgcolor="#dddddd" style="background: #dddddd; border: 1px solid #000000; padding: 0in">
						<p class="txt-centro">
							<font class="fonte-rel">
								<font size="1" class="fs-6">
									<b>DESPESAS</b>
								</font>
							</font>
						</p>
					</td>
					<td width="1%" bgcolor="#ffffff" style="background: #ffffff; border: none; padding: 0in"></td>
					<td width="24%" bgcolor="#dddddd" style="background: #dddddd; border: 1px solid #000000; padding: 0in">
						<p class="txt-centro">
							<font class="fonte-rel">
								<font size="1" class="fs-6">
									<b>RECOLHIMENTOS</b>
								</font>
							</font>
						</p>
					</td>
				</tr>
			</table>

			<table width="100%" cellpadding="4" cellspacing="0" style="margin-bottom: 0.05in">
				<tr valign="top">
					<td width="24%" class="coluna-topo" style="border: 1px solid #000000; padding: 0.04in;">
						<div class="coluna-box">
							<table width="100%" cellpadding="4" cellspacing="0" class="tabela-interna">
								<tr>
									<td width="43%" bgcolor="#eeeeee" style="background: #eeeeee; border: none; padding: 0in">
										<p class="txt-centro">
											<font class="fonte-rel">
												<font size="1" class="fs-6">
													<b>TIPO</b>
												</font>
											</font>
										</p>
									</td>
									<td width="25%" bgcolor="#eeeeee" style="background: #eeeeee; border: none; padding: 0in">
										<p class="txt-centro">
											<font class="fonte-rel">
												<font size="1" class="fs-6">
													<b>QUANT.</b>
												</font>
											</font>
										</p>
									</td>
									<td width="32%" bgcolor="#eeeeee" style="background: #eeeeee; border: none; padding: 0in">
										<p class="txt-centro">
											<font class="fonte-rel">
												<font size="1" class="fs-6">
													<b>TOTAL</b>
												</font>
											</font>
										</p>
									</td>
								</tr>
								<?php
								if ($NTxProd > 0 && $ValorProd > 0.00) {
								?>
									<tr>
										<td width="43%" style="border: none; padding: 0in">
											<p>
												<font class="fonte-rel">
													<font size="1" class="fs-6">
														<i>Tx. Produção</i>
													</font>
												</font>
											</p>
										</td>
										<td width="25%" style="border: none; padding: 0in">
											<p class="txt-centro">
												<font class="fonte-rel">
													<font size="1" class="fs-6">
														<i><?= $NTxProd ?></i>
													</font>
												</font>
											</p>
										</td>
										<td width="32%" style="border: none; padding: 0in">
											<p>
												<font class="fonte-rel">
													<font size="1" class="fs-6">
														<i>R$ <?= $ValorProdFmt ?></i>
													</font>
												</font>
											</p>
										</td>
									</tr>
								<?php
								}

								if ($NConcurso > 0 && $ValorConc > 0.00) {
								?>
									<tr>
										<td width="43%" style="border: none; padding: 0in">
											<p>
												<font class="fonte-rel">
													<font size="1" class="fs-6">
														<i>Insc. Concurso</i>
													</font>
												</font>
											</p>
										</td>
										<td width="25%" style="border: none; padding: 0in">
											<p class="txt-centro">
												<font class="fonte-rel">
													<font size="1" class="fs-6">
														<i><?= $NConcurso ?></i>
													</font>
												</font>
											</p>
										</td>
										<td width="32%" style="border: none; padding: 0in">
											<p>
												<font class="fonte-rel">
													<font size="1" class="fs-6">
														<i>R$ <?= $ValorConcFmt ?></i>
													</font>
												</font>
											</p>
										</td>
									</tr>
								<?php
								}

								if ($NContEnt > 0 && $ValorContEnt > 0.00) {
								?>
									<tr>
										<td width="43%" style="border: none; padding: 0in">
											<p>
												<font class="fonte-rel">
													<font size="1" class="fs-6">
														<i>Contr. Entrada</i>
													</font>
												</font>
											</p>
										</td>
										<td width="25%" style="border: none; padding: 0in">
											<p class="txt-centro">
												<font class="fonte-rel">
													<font size="1" class="fs-6">
														<i><?= $NContEnt ?></i>
													</font>
												</font>
											</p>
										</td>
										<td width="32%" style="border: none; padding: 0in">
											<p>
												<font class="fonte-rel">
													<font size="1" class="fs-6">
														<i>R$ <?= $ValorContEntFmt ?></i>
													</font>
												</font>
											</p>
										</td>
									</tr>
								<?php
								}

								if ($NContParc > 0 && $ValorContParc > 0.00) {
								?>
									<tr>
										<td width="43%" style="border: none; padding: 0in">
											<p>
												<font class="fonte-rel">
													<font size="1" class="fs-6">
														<i>Contr. Parcela</i>
													</font>
												</font>
											</p>
										</td>
										<td width="25%" style="border: none; padding: 0in">
											<p class="txt-centro">
												<font class="fonte-rel">
													<font size="1" class="fs-6">
														<i><?= $NContParc ?></i>
													</font>
												</font>
											</p>
										</td>
										<td width="32%" style="border: none; padding: 0in">
											<p>
												<font class="fonte-rel">
													<font size="1" class="fs-6">
														<i>R$ <?= $ValorContParcFmt ?></i>
													</font>
												</font>
											</p>
										</td>
									</tr>
								<?php
								}

								if ($NPropEnt > 0 && $ValorPropEnt > 0.00) {
								?>
									<tr>
										<td width="43%" style="border: none; padding: 0in">
											<p>
												<font class="fonte-rel">
													<font size="1" class="fs-6">
														<i>Contr. Proposta</i>
													</font>
												</font>
											</p>
										</td>
										<td width="25%" style="border: none; padding: 0in">
											<p class="txt-centro">
												<font class="fonte-rel">
													<font size="1" class="fs-6">
														<i><?= $NPropEnt ?></i>
													</font>
												</font>
											</p>
										</td>
										<td width="32%" style="border: none; padding: 0in">
											<p>
												<font class="fonte-rel">
													<font size="1" class="fs-6">
														<i>R$ <?= $ValorPropEntFmt ?></i>
													</font>
												</font>
											</p>
										</td>
									</tr>
								<?php
								}

								if ($NPRecs > 0 && $VrPRecsF > 0.00) {
								?>
									<tr>
										<td width="43%" style="border: none; padding: 0in">
											<p>
												<font class="fonte-rel">
													<font size="1" class="fs-6">
														<i>Produtos</i>
													</font>
												</font>
											</p>
										</td>
										<td width="25%" style="border: none; padding: 0in">
											<p class="txt-centro">
												<font class="fonte-rel">
													<font size="1" class="fs-6">
														<i><?= $NPRecs ?></i>
													</font>
												</font>
											</p>
										</td>
										<td width="32%" style="border: none; padding: 0in">
											<p>
												<font class="fonte-rel">
													<font size="1" class="fs-6">
														<i>R$ <?= $VrPRecsFFmt ?></i>
													</font>
												</font>
											</p>
										</td>
									</tr>
								<?php
								}

								if ($NBookRec > 0 && $VrBookRecF > 0.00) {
								?>
									<tr>
										<td width="43%" style="border: none; padding: 0in">
											<p>
												<font class="fonte-rel">
													<font size="1" class="fs-6">
														<i>Book à Vista</i>
													</font>
												</font>
											</p>
										</td>
										<td width="25%" style="border: none; padding: 0in">
											<p class="txt-centro">
												<font class="fonte-rel">
													<font size="1" class="fs-6">
														<i><?= $NBookRec ?></i>
													</font>
												</font>
											</p>
										</td>
										<td width="32%" style="border: none; padding: 0in">
											<p>
												<font class="fonte-rel">
													<font size="1" class="fs-6">
														<i>R$ <?= $VrBookRecFFmt ?></i>
													</font>
												</font>
											</p>
										</td>
									</tr>
								<?php
								}

								if ($NumPgtos > 0 && $PgtoServicos > 0.00) {
								?>
									<tr>
										<td width="43%" style="border: none; padding: 0in">
											<p>
												<font class="fonte-rel">
													<font size="1" class="fs-6">
														<i>Despesas</i>
													</font>
												</font>
											</p>
										</td>
										<td width="25%" style="border: none; padding: 0in">
											<p class="txt-centro">
												<font class="fonte-rel">
													<font size="1" class="fs-6">
														<i><?= $NumPgtos ?></i>
													</font>
												</font>
											</p>
										</td>
										<td width="32%" style="border: none; padding: 0in">
											<p>
												<font class="fonte-rel">
													<font size="1" class="fs-6">
														<i>R$ <?= $PgtoServicosFmt ?></i>
													</font>
												</font>
											</p>
										</td>
									</tr>
								<?php
								}

								if ($NEstorno > 0 && $ValorEstorno > 0.00) {
								?>
									<tr>
										<td width="43%" style="border: none; padding: 0in">
											<p>
												<font class="fonte-rel">
													<font size="1" class="fs-6">
														<i>Estorno</i>
													</font>
												</font>
											</p>
										</td>
										<td width="25%" style="border: none; padding: 0in">
											<p class="txt-centro">
												<font class="fonte-rel">
													<font size="1" class="fs-6">
														<i><?= $NEstorno ?></i>
													</font>
												</font>
											</p>
										</td>
										<td width="32%" style="border: none; padding: 0in">
											<p>
												<font class="fonte-rel">
													<font size="1" class="fs-6">
														<i>R$ <?= $ValorEstornoFmt ?></i>
													</font>
												</font>
											</p>
										</td>
									</tr>
								<?php
								}
								?>
							</table>
						</div>
					</td>

					<td width="1%" style="border: none; padding: 0in"></td>

					<td width="24%" class="coluna-topo" style="border: 1px solid #000000; padding: 0.04in;">
						<div class="coluna-box">

							<div class="coluna-conteudo">
								<table width="100%" cellpadding="4" cellspacing="0" class="tabela-interna">
									<tr>
										<td width="68%" bgcolor="#eeeeee" style="background: #eeeeee; border: none; padding: 0in">
											<p class="txt-centro">
												<font class="fonte-rel">
													<font size="1" class="fs-6">
														<b>TIPO</b>
													</font>
												</font>
											</p>
										</td>
										<td width="32%" bgcolor="#eeeeee" style="background: #eeeeee; border: none; padding: 0in">
											<p class="txt-centro">
												<font class="fonte-rel">
													<font size="1" class="fs-6">
														<b>VALOR</b>
													</font>
												</font>
											</p>
										</td>
									</tr>

									<?php if ($Dinheiro > 0.00) { ?>
										<tr>
											<td width="68%" style="border: none; padding: 0in">
												<p>
													<font class="fonte-rel">
														<font size="1" class="fs-6"><i>Dinheiro</i></font>
													</font>
												</p>
											</td>
											<td width="32%" style="border: none; padding: 0in">
												<p>
													<font class="fonte-rel">
														<font size="1" class="fs-6"><i>R$ <?= $DinheiroFmt ?></i></font>
													</font>
												</p>
											</td>
										</tr>
									<?php } ?>

									<?php if ($CardDeb > 0.00) { ?>
										<tr>
											<td width="68%" style="border: none; padding: 0in">
												<p>
													<font class="fonte-rel">
														<font size="1" class="fs-6"><i>Cartão Débito</i></font>
													</font>
												</p>
											</td>
											<td width="32%" style="border: none; padding: 0in">
												<p>
													<font class="fonte-rel">
														<font size="1" class="fs-6"><i>R$ <?= $CardDebFmt ?></i></font>
													</font>
												</p>
											</td>
										</tr>
									<?php } ?>

									<?php if ($CardVista > 0.00) { ?>
										<tr>
											<td width="68%" style="border: none; padding: 0in">
												<p>
													<font class="fonte-rel">
														<font size="1" class="fs-6"><i>Cartão Crédito</i></font>
													</font>
												</p>
											</td>
											<td width="32%" style="border: none; padding: 0in">
												<p>
													<font class="fonte-rel">
														<font size="1" class="fs-6"><i>R$ <?= $CardVistaFmt ?></i></font>
													</font>
												</p>
											</td>
										</tr>
									<?php } ?>

									<?php if ($CardParcLj > 0.00) { ?>
										<tr>
											<td width="68%" style="border: none; padding: 0in">
												<p>
													<font class="fonte-rel">
														<font size="1" class="fs-6"><i>Cartão Crédito Parc. Loja</i></font>
													</font>
												</p>
											</td>
											<td width="32%" style="border: none; padding: 0in">
												<p>
													<font class="fonte-rel">
														<font size="1" class="fs-6"><i>R$ <?= $CardParcLjFmt ?></i></font>
													</font>
												</p>
											</td>
										</tr>
									<?php } ?>

									<?php if ($PixQRCode > 0.00) { ?>
										<tr>
											<td width="68%" style="border: none; padding: 0in">
												<p>
													<font class="fonte-rel">
														<font size="1" class="fs-6"><i>Pix QR Code</i></font>
													</font>
												</p>
											</td>
											<td width="32%" style="border: none; padding: 0in">
												<p>
													<font class="fonte-rel">
														<font size="1" class="fs-6"><i>R$ <?= $PixQRCodeFmt ?></i></font>
													</font>
												</p>
											</td>
										</tr>
									<?php } ?>

									<?php if ($PixCNPJ > 0.00) { ?>
										<tr>
											<td width="68%" style="border: none; padding: 0in">
												<p>
													<font class="fonte-rel">
														<font size="1" class="fs-6"><i>Pix CNPJ</i></font>
													</font>
												</p>
											</td>
											<td width="32%" style="border: none; padding: 0in">
												<p>
													<font class="fonte-rel">
														<font size="1" class="fs-6"><i>R$ <?= $PixCNPJFmt ?></i></font>
													</font>
												</p>
											</td>
										</tr>
									<?php } ?>
								</table>
							</div>

							<div class="coluna-total">
								<table width="100%" cellpadding="4" cellspacing="0" class="tabela-interna">
									<tr>
										<td width="68%" bgcolor="#eeeeee" style="background: #eeeeee; border: none; padding: 0in">
											<p class="txt-esq">
												<font class="fonte-rel">
													<font size="1" class="fs-6"><i><b>TOTAL</b></i></font>
												</font>
											</p>
										</td>
										<td width="32%" bgcolor="#eeeeee" style="background: #eeeeee; border: none; padding: 0in">
											<p>
												<font class="fonte-rel">
													<font size="1" class="fs-6"><i><b>R$ <?= $TotInFmt ?></b></i></font>
												</font>
											</p>
										</td>
									</tr>
								</table>
							</div>

						</div>
					</td>

					<td width="1%" style="border: none; padding: 0in"></td>

					<td width="24%" class="coluna-topo" style="border: 1px solid #000000; padding: 0.04in;">
						<div class="coluna-box">

							<div class="coluna-conteudo">
								<table width="100%" cellpadding="4" cellspacing="0" class="tabela-interna">
									<tr>
										<td width="68%" bgcolor="#eeeeee" style="background: #eeeeee; border: none; padding: 0in">
											<p class="txt-centro">
												<font class="fonte-rel">
													<font size="1" class="fs-6"><b>TIPO</b></font>
												</font>
											</p>
										</td>
										<td width="32%" bgcolor="#eeeeee" style="background: #eeeeee; border: none; padding: 0in">
											<p class="txt-centro">
												<font class="fonte-rel">
													<font size="1" class="fs-6"><b>VALOR</b></font>
												</font>
											</p>
										</td>
									</tr>

									<?php if ($DDPF > 0.00) { ?>
										<tr>
											<td width="68%" style="border: none; padding: 0in">
												<p>
													<font class="fonte-rel">
														<font size="1" class="fs-6"><i>Pessoal</i></font>
													</font>
												</p>
											</td>
											<td width="32%" style="border: none; padding: 0in">
												<p>
													<font class="fonte-rel">
														<font size="1" class="fs-6"><i>R$ <?= $DDPFFmt ?></i></font>
													</font>
												</p>
											</td>
										</tr>
									<?php } ?>
									<?php if ($MCSF > 0.00) { ?>
										<tr>
											<td width="68%" style="border: none; padding: 0in">
												<p>
													<font class="fonte-rel">
														<font size="1" class="fs-6"><i>Material Consumo</i></font>
													</font>
												</p>
											</td>
											<td width="32%" style="border: none; padding: 0in">
												<p>
													<font class="fonte-rel">
														<font size="1" class="fs-6"><i>R$ <?= $MCSFFmt ?></i></font>
													</font>
												</p>
											</td>
										</tr>
									<?php } ?>
									<?php if ($MDVF > 0.00) { ?>
										<tr>
											<td width="68%" style="border: none; padding: 0in">
												<p>
													<font class="fonte-rel">
														<font size="1" class="fs-6"><i>Material Divulgação</i></font>
													</font>
												</p>
											</td>
											<td width="32%" style="border: none; padding: 0in">
												<p>
													<font class="fonte-rel">
														<font size="1" class="fs-6"><i>R$ <?= $MDVFFmt ?></i></font>
													</font>
												</p>
											</td>
										</tr>
									<?php } ?>
									<?php if ($MPDF > 0.00) { ?>
										<tr>
											<td width="68%" style="border: none; padding: 0in">
												<p>
													<font class="fonte-rel">
														<font size="1" class="fs-6"><i>Material Produção</i></font>
													</font>
												</p>
											</td>
											<td width="32%" style="border: none; padding: 0in">
												<p>
													<font class="fonte-rel">
														<font size="1" class="fs-6"><i>R$ <?= $MPDFFmt ?></i></font>
													</font>
												</p>
											</td>
										</tr>
									<?php } ?>
									<?php if ($RCLF > 0.00) { ?>
										<tr>
											<td width="68%" style="border: none; padding: 0in">
												<p>
													<font class="fonte-rel">
														<font size="1" class="fs-6"><i>Reembolso Cliente</i></font>
													</font>
												</p>
											</td>
											<td width="32%" style="border: none; padding: 0in">
												<p>
													<font class="fonte-rel">
														<font size="1" class="fs-6"><i>R$ <?= $RCLFFmt ?></i></font>
													</font>
												</p>
											</td>
										</tr>
									<?php } ?>
									<?php if ($SRVF > 0.00) { ?>
										<tr>
											<td width="68%" style="border: none; padding: 0in">
												<p>
													<font class="fonte-rel">
														<font size="1" class="fs-6"><i>Serviços Prestados</i></font>
													</font>
												</p>
											</td>
											<td width="32%" style="border: none; padding: 0in">
												<p>
													<font class="fonte-rel">
														<font size="1" class="fs-6"><i>R$ <?= $SRVFFmt ?></i></font>
													</font>
												</p>
											</td>
										</tr>
									<?php } ?>
									<?php if ($VTRF > 0.00) { ?>
										<tr>
											<td width="68%" style="border: none; padding: 0in">
												<p>
													<font class="fonte-rel">
														<font size="1" class="fs-6"><i>Vale Transporte</i></font>
													</font>
												</p>
											</td>
											<td width="32%" style="border: none; padding: 0in">
												<p>
													<font class="fonte-rel">
														<font size="1" class="fs-6"><i>R$ <?= $VTRFFmt ?></i></font>
													</font>
												</p>
											</td>
										</tr>
									<?php } ?>
								</table>
							</div>

							<div class="coluna-total">
								<table width="100%" cellpadding="4" cellspacing="0" class="tabela-interna">
									<tr>
										<td width="68%" bgcolor="#eeeeee" style="background: #eeeeee; border: none; padding: 0in">
											<p class="txt-esq">
												<font class="fonte-rel">
													<font size="1" class="fs-6"><i><b>TOTAL</b></i></font>
												</font>
											</p>
										</td>
										<td width="32%" bgcolor="#eeeeee" style="background: #eeeeee; border: none; padding: 0in">
											<p>
												<font class="fonte-rel">
													<font size="1" class="fs-6"><i><b>R$ <?= $PgtoTotFmt ?></b></i></font>
												</font>
											</p>
										</td>
									</tr>
								</table>
							</div>

						</div>
					</td>

					<td width="1%" style="border: none; padding: 0in"></td>

					<td width="24%" class="coluna-topo" style="border: 1px solid #000000; padding: 0.04in;">
						<div class="coluna-box">
							<table width="100%" cellpadding="4" cellspacing="0" class="tabela-interna">
								<tr>
									<td width="68%" bgcolor="#eeeeee" style="background: #eeeeee; border: none; padding: 0in">
										<p class="txt-centro">
											<font class="fonte-rel">
												<font size="1" class="fs-6"><b>TIPO</b></font>
											</font>
										</p>
									</td>
									<td width="32%" bgcolor="#eeeeee" style="background: #eeeeee; border: none; padding: 0in">
										<p class="txt-centro">
											<font class="fonte-rel">
												<font size="1" class="fs-6"><b>VALOR</b></font>
											</font>
										</p>
									</td>
								</tr>
								<tr>
									<td width="68%" style="border: none; padding: 0in">
										<p>
											<font class="fonte-rel">
												<font size="1" class="fs-6"><i>Recolhimentos</i></font>
											</font>
										</p>
									</td>
									<td width="32%" style="border: none; padding: 0in">
										<p>
											<font class="fonte-rel">
												<font size="1" class="fs-6">
													<?php if ($Recolh > 0.00) { ?>
														<i>R$ <?= $RecolhFmt ?></i>
													<?php } else { ?>
														<i>R$ 0,00</i>
													<?php } ?>
												</font>
											</font>
										</p>
									</td>
								</tr>
								<tr>
									<td width="68%" style="border: none; padding: 0in">
										<p>
											<font class="fonte-rel">
												<font size="1" class="fs-6"><i>Pagamentos + Recolhimentos</i></font>
											</font>
										</p>
									</td>
									<td width="32%" style="border: none; padding: 0in">
										<p>
											<font class="fonte-rel">
												<font size="1" class="fs-6"><i>R$ <?= $TotPgtoFmt ?></i></font>
											</font>
										</p>
									</td>
								</tr>
							</table>
						</div>
					</td>
				</tr>
			</table>

			<?php if (!empty($IncSobraF) && $IncSobraF > 0) { ?>
				<div class="bloco-4 bloco-esq">
					<table width="100%" cellpadding="4" cellspacing="0" style="margin-bottom: 0.05in">
						<tr>
							<td bgcolor="#b2b2b2" style="background:#b2b2b2; border:1px solid #000000; padding:0in">
								<p class="txt-centro">
									<font class="fonte-rel">
										<font size="1" class="fs-6">
											<b>INCORPORAÇÃO DE SALDO</b>
										</font>
									</font>
								</p>
							</td>
						</tr>
					</table>

					<table width="100%" cellpadding="4" cellspacing="0" style="margin-bottom: 0.05in">
						<tr>
							<td bgcolor="#eeeeee" style="background:#eeeeee; border:none; padding:0in">
								<p class="txt-centro">
									<font class="fonte-rel">
										<font size="1" class="fs-6">
											<b>SOBRA INCORPORADA AO CAIXA</b>
										</font>
									</font>
								</p>
							</td>
						</tr>
						<tr>
							<td style="border:none; padding:0in">
								<p class="txt-centro">
									<font class="fonte-rel">
										<font size="1" class="fs-6">
											<i>R$ <?= $IncSobraFFmt ?></i>
										</font>
									</font>
								</p>
							</td>
						</tr>
					</table>
				</div>
			<?php } ?>

			<?php if (!empty($Errlanc['de']) && is_array($Errlanc['de']) && count($Errlanc['de']) > 0) { ?>
				<div class="bloco-4">
					<table width="100%" cellpadding="4" cellspacing="0" style="margin-bottom: 0.05in">
						<tr>
							<td bgcolor="#b2b2b2" style="background:#b2b2b2; border:1px solid #000000; padding:0in">
								<p class="txt-centro">
									<font class="fonte-rel">
										<font size="1" class="fs-6">
											<b>RETIFICAÇÃO DE LANÇAMENTO</b>
										</font>
									</font>
								</p>
							</td>
						</tr>
					</table>

					<table width="100%" cellpadding="4" cellspacing="0" style="margin-bottom: 0.05in">
						<tr>
							<td width="33%" bgcolor="#eeeeee" style="background:#eeeeee; border:none; padding:0in">
								<p class="txt-centro">
									<font class="fonte-rel">
										<font size="1" class="fs-6"><b>DE</b></font>
									</font>
								</p>
							</td>
							<td width="33%" bgcolor="#eeeeee" style="background:#eeeeee; border:none; padding:0in">
								<p class="txt-centro">
									<font class="fonte-rel">
										<font size="1" class="fs-6"><b>PARA</b></font>
									</font>
								</p>
							</td>
							<td width="34%" bgcolor="#eeeeee" style="background:#eeeeee; border:none; padding:0in">
								<p class="txt-centro">
									<font class="fonte-rel">
										<font size="1" class="fs-6"><b>VALOR</b></font>
									</font>
								</p>
							</td>
						</tr>

						<?php for ($i = 0; $i < count($Errlanc['de']); $i++) { ?>
							<tr>
								<td style="border:none; padding:0in">
									<p class="txt-centro">
										<font class="fonte-rel">
											<font size="1" class="fs-6"><i><?= $Errlanc['de'][$i] ?></i></font>
										</font>
									</p>
								</td>
								<td style="border:none; padding:0in">
									<p class="txt-centro">
										<font class="fonte-rel">
											<font size="1" class="fs-6"><i><?= $Errlanc['para'][$i] ?></i></font>
										</font>
									</p>
								</td>
								<td style="border:none; padding:0in">
									<p class="txt-centro">
										<font class="fonte-rel">
											<font size="1" class="fs-6"><i>R$ <?= moeda($Errlanc['diff'][$i] ?? 0) ?></i></font>
										</font>
									</p>
								</td>
							</tr>
						<?php } ?>
					</table>
				</div>
			<?php } ?>

			<?php if (!empty($FechamentoF) || !empty($GavAut) || !empty($DifCx)) { ?>
				<div class="bloco-4 bloco-esq">
					<table width="100%" cellpadding="4" cellspacing="0" style="margin-bottom: 0.05in">
						<tr>
							<td bgcolor="#b2b2b2" style="background:#b2b2b2; border:1px solid #000000; padding:0in">
								<p class="txt-centro">
									<font class="fonte-rel">
										<font size="1" class="fs-6">
											<b>SALDO CAIXA</b>
										</font>
									</font>
								</p>
							</td>
						</tr>
					</table>

					<table width="100%" cellpadding="4" cellspacing="0" style="margin-bottom: 0.05in">
						<tr>
							<td width="33%" bgcolor="#eeeeee" style="background:#eeeeee; border:none; padding:0in">
								<p class="txt-centro">
									<font class="fonte-rel">
										<font size="1" class="fs-6"><b>VALOR REAL</b></font>
									</font>
								</p>
							</td>
							<td width="33%" bgcolor="#eeeeee" style="background:#eeeeee; border:none; padding:0in">
								<p class="txt-centro">
									<font class="fonte-rel">
										<font size="1" class="fs-6"><b>GAVETA</b></font>
									</font>
								</p>
							</td>
							<td width="34%" bgcolor="#eeeeee" style="background:#eeeeee; border:none; padding:0in">
								<p class="txt-centro">
									<font class="fonte-rel">
										<font size="1" class="fs-6"><b>DIFERENÇA</b></font>
									</font>
								</p>
							</td>
						</tr>
						<tr>
							<td style="border:none; padding:0in">
								<p class="txt-centro">
									<font class="fonte-rel">
										<font size="1" class="fs-6"><i>R$ <?= $FechamentoFFmt ?></i></font>
									</font>
								</p>
							</td>
							<td style="border:none; padding:0in">
								<p class="txt-centro">
									<font class="fonte-rel">
										<font size="1" class="fs-6"><i>R$ <?= $GavAutFmt ?></i></font>
									</font>
								</p>
							</td>
							<td style="border:none; padding:0in">
								<p class="txt-centro">
									<font class="fonte-rel">
										<font size="1" class="fs-6"><i>R$ <?= $DifCxFmt ?></i></font>
									</font>
								</p>
							</td>
						</tr>
					</table>
				</div>
			<?php } ?>

			<?php if (!empty($cd)) { ?>
				<div class="bloco-4">
					<table width="100%" cellpadding="4" cellspacing="0" style="margin-bottom: 0.05in">
						<tr>
							<td bgcolor="#b2b2b2" style="background:#b2b2b2; border:1px solid #000000; padding:0in">
								<p class="txt-centro">
									<font class="fonte-rel">
										<font size="1" class="fs-6">
											<b>
												<?php
												if ($cd == "(SOBRA)") {
													echo "SOBRA CAIXA";
												} elseif ($cd == "(FALTA)") {
													echo "FALTA CAIXA";
												} else {
													echo " ";
												}
												?>
											</b>
										</font>
									</font>
								</p>
							</td>
						</tr>
					</table>

					<table width="100%" cellpadding="4" cellspacing="0" style="margin-bottom: 0.05in">
						<tr>
							<td width="33%" bgcolor="#eeeeee" style="background:#eeeeee; border:none; padding:0in">
								<p class="txt-centro">
									<font class="fonte-rel">
										<font size="1" class="fs-6"><b>SALDO FECHAMENTO</b></font>
									</font>
								</p>
							</td>
							<td width="33%" bgcolor="#eeeeee" style="background:#eeeeee; border:none; padding:0in">
								<p class="txt-centro">
									<font class="fonte-rel">
										<font size="1" class="fs-6"><b>VALOR INFORMADO</b></font>
									</font>
								</p>
							</td>
							<td width="34%" bgcolor="#eeeeee" style="background:#eeeeee; border:none; padding:0in">
								<p class="txt-centro">
									<font class="fonte-rel">
										<font size="1" class="fs-6"><b>NUMERÁRIO</b></font>
									</font>
								</p>
							</td>
						</tr>
						<tr>
							<td style="border:none; padding:0in">
								<p class="txt-centro">
									<font class="fonte-rel">
										<font size="1" class="fs-6"><i>R$ <?= $FechamentoFFmt ?></i></font>
									</font>
								</p>
							</td>
							<td style="border:none; padding:0in">
								<p class="txt-centro">
									<font class="fonte-rel">
										<font size="1" class="fs-6"><i>R$ <?= $GavAutFmt ?></i></font>
									</font>
								</p>
							</td>
							<td style="border:none; padding:0in">
								<p class="txt-centro">
									<font class="fonte-rel">
										<font size="1" class="fs-6"><i>R$ <?= $DifCxFmt ?></i></font>
									</font>
								</p>
							</td>
						</tr>
					</table>
				</div>
			<?php } ?>

			<div class="bloco-autenticacoes">
			<?php if (!empty($Spo['spo']) && is_array($Spo['spo'])) { ?>

				<table width="100%" cellpadding="4" cellspacing="0" style="margin-bottom: 0.05in">
					<tr>
						<td width="100%" valign="top" bgcolor="#b2b2b2" style="background: #b2b2b2; border: 1px solid #000000; padding: 0in">
							<p class="txt-centro">
								<font class="fonte-rel">
									<font size="1" class="fs-6">
										<b>AUTENTICAÇÕES DO DIA</b>
									</font>
								</font>
							</p>
						</td>
					</tr>
				</table>

				<table width="100%" cellpadding="4" cellspacing="0" style="margin-bottom: 0.05in">
					<?php
					$totalSpo = count($Spo['spo']);

					for ($i = 0; $i < $totalSpo; $i += 3) {
						$coluna1 = htmlspecialchars($Spo['spo'][$i] ?? '', ENT_QUOTES, 'UTF-8');
						$coluna2 = htmlspecialchars($Spo['spo'][$i + 1] ?? '', ENT_QUOTES, 'UTF-8');
						$coluna3 = htmlspecialchars($Spo['spo'][$i + 2] ?? '', ENT_QUOTES, 'UTF-8');
					?>
						<tr>
							<td width="33.33%" bgcolor="#eeeeee" style="background: #eeeeee; border: none; padding: 0in">
								<p class="txt-esq">
									<font class="fonte-rel">
										<font size="1" class="fs-58"><?= $coluna1 ?></font>
									</font>
								</p>
							</td>

							<td width="33.33%" bgcolor="#eeeeee" style="background: #eeeeee; border: none; padding: 0in">
								<p class="txt-esq">
									<font class="fonte-rel">
										<font size="1" class="fs-58"><?= $coluna2 ?></font>
									</font>
								</p>
							</td>

							<td width="33.33%" bgcolor="#eeeeee" style="background: #eeeeee; border: none; padding: 0in">
								<p class="txt-esq">
									<font class="fonte-rel">
										<font size="1" class="fs-58"><?= $coluna3 ?></font>
									</font>
								</p>
							</td>
						</tr>
					<?php } ?>
				</table>

			<?php } else { ?>
				<table width="100%" cellpadding="4" cellspacing="0" style="margin-bottom: 0.05in">
					<tr>
						<td width="100%" valign="top" bgcolor="#b2b2b2" style="background: #b2b2b2; border: 1px solid #000000; padding: 0in">
							<p class="txt-centro">
								<font class="fonte-rel">
									<font size="1" class="fs-6">
										<b>AUTENTICAÇÕES DO DIA</b>
									</font>
								</font>
							</p>
						</td>
					</tr>
					<tr>
						<td width="100%" bgcolor="#eeeeee" style="background: #eeeeee; border: none; padding: 0in">
							<p class="txt-centro">
								<font class="fonte-rel">
									<font size="1" class="fs-6">
										<i>Nenhuma autenticação registrada.</i>
									</font>
								</font>
							</p>
						</td>
					</tr>
				</table>
			<?php } ?>
			</div>

			<?php if (!empty($Oper['matopf']) && is_array($Oper['matopf'])) { ?>
				<div class="bloco-full bloco-operadores">

					<table width="100%" cellpadding="4" cellspacing="0" style="margin-bottom: 0.05in">
						<tr>
							<td width="100%" bgcolor="#b2b2b2" style="background: #b2b2b2; border: 1px solid #000000; padding: 0in">
								<p class="txt-centro">
									<font class="fonte-rel">
										<font size="1" class="fs-6">
											<b>OPERADORES CADASTRADOS NO SISTEMA</b>
										</font>
									</font>
								</p>
							</td>
						</tr>
					</table>

					<table width="100%" cellpadding="4" cellspacing="0" style="margin-bottom: 0.05in">
						<tr valign="top">
							<td width="25%" bgcolor="#cccccc" style="background: #cccccc; border: none; padding: 0in">
								<p class="txt-centro">
									<font class="fonte-rel">
										<font size="1" class="fs-6"><b>FUNCIONÁRIO</b></font>
									</font>
								</p>
							</td>
							<td width="25%" bgcolor="#cccccc" style="background: #cccccc; border: none; padding: 0in">
								<p class="txt-centro">
									<font class="fonte-rel">
										<font size="1" class="fs-6"><b>FUNÇÃO</b></font>
									</font>
								</p>
							</td>
							<td width="25%" bgcolor="#cccccc" style="background: #cccccc; border: none; padding: 0in">
								<p class="txt-centro">
									<font class="fonte-rel">
										<font size="1" class="fs-6"><b>HORA</b></font>
									</font>
								</p>
							</td>
							<td width="25%" bgcolor="#cccccc" style="background: #cccccc; border: none; padding: 0in">
								<p class="txt-centro">
									<font class="fonte-rel">
										<font size="1" class="fs-6"><b>CADASTRADO</b></font>
									</font>
								</p>
							</td>
						</tr>

						<?php
						$totalOper = count($Oper['matopf']);
						for ($i = 0; $i < $totalOper; $i++) {
							$matOpf = htmlspecialchars($Oper['matopf'][$i] ?? '', ENT_QUOTES, 'UTF-8');
							$cargo  = htmlspecialchars($Oper['cargo'][$i] ?? '', ENT_QUOTES, 'UTF-8');
							$tempo  = htmlspecialchars($Oper['tempo'][$i] ?? '', ENT_QUOTES, 'UTF-8');
							$respf  = htmlspecialchars($Oper['respf'][$i] ?? '', ENT_QUOTES, 'UTF-8');
						?>
							<tr valign="top">
								<td width="25%" style="border: none; padding: 0in">
									<p class="txt-centro">
										<font class="fonte-rel">
											<font size="1" class="fs-6"><i><?= $matOpf ?></i></font>
										</font>
									</p>
								</td>
								<td width="25%" style="border: none; padding: 0in">
									<p class="txt-centro">
										<font class="fonte-rel">
											<font size="1" class="fs-6"><i><?= $cargo ?></i></font>
										</font>
									</p>
								</td>
								<td width="25%" style="border: none; padding: 0in">
									<p class="txt-centro">
										<font class="fonte-rel">
											<font size="1" class="fs-6"><i><?= $tempo ?></i></font>
										</font>
									</p>
								</td>
								<td width="25%" style="border: none; padding: 0in">
									<p class="txt-centro">
										<font class="fonte-rel">
											<font size="1" class="fs-6"><i><?= $respf ?></i></font>
										</font>
									</p>
								</td>
							</tr>
						<?php } ?>
					</table>

				</div>
			<?php } ?>

			<?php if (!empty($SolicSenha['solicitante']) && is_array($SolicSenha['solicitante'])) { ?>
				<div class="bloco-full">

					<table width="100%" cellpadding="4" cellspacing="0" style="margin-bottom: 0.05in">
						<tr>
							<td width="100%" bgcolor="#b2b2b2" style="background: #b2b2b2; border: 1px solid #000000; padding: 0in">
								<p class="txt-centro">
									<font class="fonte-rel">
										<font size="1" class="fs-6">
											<b>SOLICITAÇÕES DE SENHA PROVISÓRIA</b>
										</font>
									</font>
								</p>
							</td>
						</tr>
					</table>

					<table width="100%" cellpadding="4" cellspacing="0" style="margin-bottom: 0.05in">
						<tr valign="top">
							<td width="34%" bgcolor="#cccccc" style="background: #cccccc; border: none; padding: 0in">
								<p class="txt-centro">
									<font class="fonte-rel">
										<font size="1" class="fs-6"><b>SOLICITANTE</b></font>
									</font>
								</p>
							</td>
							<td width="33%" bgcolor="#cccccc" style="background: #cccccc; border: none; padding: 0in">
								<p class="txt-centro">
									<font class="fonte-rel">
										<font size="1" class="fs-6"><b>DATA</b></font>
									</font>
								</p>
							</td>
							<td width="33%" bgcolor="#cccccc" style="background: #cccccc; border: none; padding: 0in">
								<p class="txt-centro">
									<font class="fonte-rel">
										<font size="1" class="fs-6"><b>AUTORIZADO</b></font>
									</font>
								</p>
							</td>
						</tr>

						<?php
						$totalSenha = count($SolicSenha['solicitante']);
						for ($i = 0; $i < $totalSenha; $i++) {
							$solicitante = htmlspecialchars($SolicSenha['solicitante'][$i] ?? '', ENT_QUOTES, 'UTF-8');
							$data        = htmlspecialchars($SolicSenha['data'][$i] ?? '', ENT_QUOTES, 'UTF-8');
							$autorizado  = htmlspecialchars($SolicSenha['autorizado'][$i] ?? '', ENT_QUOTES, 'UTF-8');
						?>
							<tr valign="top">
								<td width="34%" style="border: none; padding: 0in">
									<p class="txt-centro">
										<font class="fonte-rel">
											<font size="1" class="fs-6"><i><?= $solicitante ?></i></font>
										</font>
									</p>
								</td>
								<td width="33%" style="border: none; padding: 0in">
									<p class="txt-centro">
										<font class="fonte-rel">
											<font size="1" class="fs-6"><i><?= $data ?></i></font>
										</font>
									</p>
								</td>
								<td width="33%" style="border: none; padding: 0in">
									<p class="txt-centro">
										<font class="fonte-rel">
											<font size="1" class="fs-6"><i><?= $autorizado ?></i></font>
										</font>
									</p>
								</td>
							</tr>
						<?php } ?>
					</table>

				</div>
			<?php } ?>

			<?php if (!empty($Recolhimentos['hora']) && is_array($Recolhimentos['hora'])) { ?>
				<div class="bloco-full bloco-recolhimentos">

					<table width="100%" cellpadding="4" cellspacing="0" style="margin-bottom: 0.05in">
						<tr valign="top">
							<td width="100%" bgcolor="#b2b2b2" style="background: #b2b2b2; border: 1px solid #000000; padding: 0in">
								<p class="txt-centro">
									<font class="fonte-rel">
										<font size="1" class="fs-6"><b>RECOLHIMENTOS</b></font>
									</font>
								</p>
							</td>
						</tr>
					</table>

					<table width="100%" cellpadding="4" cellspacing="0" style="margin-bottom: 0.05in">
						<tr valign="top">
							<td width="25%" bgcolor="#cccccc" style="background: #cccccc; border: none; padding: 0in">
								<p class="txt-centro">
									<font class="fonte-rel">
										<font size="1" class="fs-6"><b>HORA</b></font>
									</font>
								</p>
							</td>
							<td width="25%" bgcolor="#cccccc" style="background: #cccccc; border: none; padding: 0in">
								<p class="txt-centro">
									<font class="fonte-rel">
										<font size="1" class="fs-6"><b>ENVELOPE</b></font>
									</font>
								</p>
							</td>
							<td width="25%" bgcolor="#cccccc" style="background: #cccccc; border: none; padding: 0in">
								<p class="txt-centro">
									<font class="fonte-rel">
										<font size="1" class="fs-6"><b>MATRÍCULA</b></font>
									</font>
								</p>
							</td>
							<td width="25%" bgcolor="#cccccc" style="background: #cccccc; border: none; padding: 0in">
								<p class="txt-centro">
									<font class="fonte-rel">
										<font size="1" class="fs-6"><b>VALOR</b></font>
									</font>
								</p>
							</td>
						</tr>

						<?php
						$totalRec = count($Recolhimentos['hora']);
						$totalRecValor = 0;

						for ($i = 0; $i < $totalRec; $i++) {
							$hora     = htmlspecialchars($Recolhimentos['hora'][$i] ?? '', ENT_QUOTES, 'UTF-8');
							$envelope = htmlspecialchars($Recolhimentos['envelope'][$i] ?? '', ENT_QUOTES, 'UTF-8');
							$matricula = htmlspecialchars($Recolhimentos['matricula'][$i] ?? '', ENT_QUOTES, 'UTF-8');
							$valorRaw = $Recolhimentos['valor'][$i] ?? 0;
							$totalRecValor += (float) str_replace(',', '.', str_replace('.', '', $valorRaw));
							$valor    = htmlspecialchars($valorRaw, ENT_QUOTES, 'UTF-8');
						?>
							<tr valign="top">
								<td width="25%" style="border: none; padding: 0in">
									<p class="txt-centro">
										<font class="fonte-rel">
											<font size="1" class="fs-6"><i><?= $hora ?></i></font>
										</font>
									</p>
								</td>
								<td width="25%" style="border: none; padding: 0in">
									<p class="txt-centro">
										<font class="fonte-rel">
											<font size="1" class="fs-6"><i><?= $envelope ?></i></font>
										</font>
									</p>
								</td>
								<td width="25%" style="border: none; padding: 0in">
									<p class="txt-centro">
										<font class="fonte-rel">
											<font size="1" class="fs-6"><i><?= $matricula ?></i></font>
										</font>
									</p>
								</td>
								<td width="25%" style="border: none; padding: 0in">
									<p class="txt-centro">
										<font class="fonte-rel">
											<font size="1" class="fs-6"><i>R$ <?= $valor ?></i></font>
										</font>
									</p>
								</td>
							</tr>
						<?php } ?>

						<tr valign="top">
							<td colspan="3" width="75%" bgcolor="#eeeeee" style="background: #eeeeee; border: none; padding: 0in">
								<p class="txt-dir">
									<font class="fonte-rel">
										<font size="1" class="fs-6"><i><b>TOTAL</b></i></font>
									</font>
								</p>
							</td>
							<td width="25%" bgcolor="#eeeeee" style="background: #eeeeee; border: none; padding: 0in">
								<p class="txt-centro">
									<font class="fonte-rel">
										<font size="1" class="fs-6"><i><b>R$ <?= number_format($totalRecValor, 2, ',', '.') ?></b></i></font>
									</font>
								</p>
							</td>
						</tr>
					</table>

				</div>
			<?php } ?>

			<div class="bloco-full">

				<p style="line-height: 100%; margin-bottom: 0in"><br /></p>
				<p style="line-height: 100%; margin-bottom: 0in"><br /></p>
				<p style="line-height: 100%; margin-bottom: 0in"><br /></p>

				<table width="100%" cellpadding="4" cellspacing="0">
					<tr valign="bottom">
						<td width="33%" style="border: none; padding: 0in">
							<p class="txt-centro">
								<font class="fonte-rel">
									<font size="1" class="fs-6"><b>___________________________________________</b></font>
								</font>
							</p>
						</td>

						<?php if ($Diferenca == true) { ?>
							<td width="33%" style="border: none; padding: 0in">
								<p class="txt-centro">
									<font class="fonte-rel">
										<font size="1" class="fs-6"><b>___________________________________________</b></font>
									</font>
								</p>
							</td>
						<?php } ?>

						<td width="33%" style="border: none; padding: 0in">
							<p class="txt-centro">
								<font class="fonte-rel">
									<font size="1" class="fs-6"><b>___________________________________________</b></font>
								</font>
							</p>
						</td>
					</tr>

					<tr valign="top">
						<td width="33%" style="border: none; padding: 0in">
							<p class="txt-centro">
								<font class="fonte-rel">
									<font size="1" class="fs-6"><b>VISTO CAIXA</b></font>
								</font>
							</p>
						</td>

						<?php if ($Diferenca == true) { ?>
							<td width="33%" style="border: none; padding: 0in">
								<p class="txt-centro">
									<font class="fonte-rel">
										<font size="1" class="fs-6"><b>ASSINATURA AUDITORA</b></font>
									</font>
								</p>
							</td>
						<?php } ?>

						<td width="33%" style="border: none; padding: 0in">
							<p class="txt-centro">
								<font class="fonte-rel">
									<font size="1" class="fs-6"><b>ASSINATURA ENCARREGADA</b></font>
								</font>
							</p>
						</td>
					</tr>
				</table>

			</div>
			<p align="center" style="line-height: 100%; margin-bottom: 0in"><br /></p>
			<p align="center" style="margin-bottom: 0in; line-height: 100%">
				<font class="fonte-rel">
					<font size="1" class="fs-6">(R)1833-232,90-3318 33181833-1802.8-33181833</font>
				</font>
			</p>
		</div>
	</div>
	<script>
		function mmParaPx(mm) {
			var medidor = document.createElement('div');
			medidor.style.height = mm + 'mm';
			medidor.style.position = 'absolute';
			medidor.style.visibility = 'hidden';
			document.body.appendChild(medidor);
			var px = medidor.offsetHeight;
			document.body.removeChild(medidor);
			return px;
		}

		function ajustarQuebrasPagina() {
			var pagina = document.querySelector('.page');
			if (!pagina) {
				return;
			}

			var alturaUtilPagina = mmParaPx(287);
			var limitePagina = alturaUtilPagina * 0.95;
			var offsetPagina = pagina.offsetTop;
			var elementos = Array.prototype.slice.call(pagina.children).filter(function(elemento) {
				return elemento.tagName !== 'SCRIPT' &&
					!elemento.classList.contains('bloco-autenticacoes') &&
					!elemento.classList.contains('bloco-operadores') &&
					!elemento.classList.contains('bloco-recolhimentos') &&
					elemento.offsetHeight > 0;
			});

			elementos.forEach(function(elemento) {
				elemento.classList.remove('quebra-pagina-95');
			});

			var blocoAutenticacoes = pagina.querySelector('.bloco-autenticacoes');
			var fimAutenticacoes = blocoAutenticacoes ?
				(blocoAutenticacoes.offsetTop - offsetPagina + blocoAutenticacoes.offsetHeight) : 0;
			var autenticacoesOcupamFimDaPagina = fimAutenticacoes >= limitePagina;

			if (pagina.scrollHeight > alturaUtilPagina && autenticacoesOcupamFimDaPagina) {
				var secaoFinal = pagina.querySelector('.bloco-operadores') || pagina.querySelector('.bloco-recolhimentos');

				if (secaoFinal) {
					secaoFinal.classList.add('quebra-pagina-95');
				}
			}

			for (var ciclo = 0; ciclo < 4; ciclo++) {
				var alterou = false;

				for (var i = 1; i < elementos.length; i++) {
					var elemento = elementos[i];
					var topo = elemento.offsetTop - offsetPagina;
					var altura = elemento.offsetHeight;
					var base = topo + altura;
					var topoNaPagina = topo % alturaUtilPagina;
					var baseNaPagina = base % alturaUtilPagina;
					var atravessaPagina = Math.floor(topo / alturaUtilPagina) !== Math.floor(base / alturaUtilPagina);
					var podeCaberEmUmaPagina = altura < alturaUtilPagina;

					if (
						!elemento.classList.contains('quebra-pagina-95') &&
						(topoNaPagina >= limitePagina || baseNaPagina >= limitePagina || (atravessaPagina && podeCaberEmUmaPagina))
					) {
						elemento.classList.add('quebra-pagina-95');
						alterou = true;
						break;
					}
				}

				if (!alterou) {
					break;
				}
			}
		}

		function imprimirDepoisDoLayout() {
			ajustarQuebrasPagina();

			window.requestAnimationFrame(function() {
				ajustarQuebrasPagina();
				window.print();
			});
		}

		function prepararImpressao() {
			if (document.fonts && document.fonts.ready) {
				document.fonts.ready.then(imprimirDepoisDoLayout);
			} else {
				setTimeout(imprimirDepoisDoLayout, 100);
			}
		}

		window.addEventListener('beforeprint', ajustarQuebrasPagina);
	</script>
</body>

</html>
