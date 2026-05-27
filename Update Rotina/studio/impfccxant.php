<?php

// Debug
ini_set('error_log', 'php_errors.log');

// Funções
function post($chave, $padrao = '')
{
	return $_POST[$chave] ?? $padrao;
}

function num($chave, $padrao = 0.0)
{
	$valor = post($chave, $padrao);
	return valor_num($valor, $padrao);
}

function valor_num($valor, $padrao = 0.0)
{
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

// Conectando ao banco de dados
include "conexao.php";
include "dbselect.php";

// Recebendo variáveis
/*$lg_user = post('c_s');*/
$TipoFech = post('tipoFech');
$Fita    = post('fita');
$ano     = post('ano');
$PC      = post('pc');
$dataFch  = post('datafch');
$hora    = post('hora');
$app     = post('app');
$inicial = post('inicial');

$NTxProd = post('numtxprod');
$ValorProd = post('vrprod');
$NConcurso = post('numconcurso');
$ValorConc = post('vrconc');
$NContEnt = post('numcontent');
$ValorContEnt = post('vrcontent');
$NContParc = post('numcontparc');
$ValorContParc = post('vrcontparc');
$NPropEnt = post('numpropent');
$ValorPropEnt = post('vrpropent');
$NPRecs = post('numprodsrec');
$VrPRecsF = post('vrprecs');
$NBookRec = post('nbookrec');
$VrBookRecF = post('vrbookrec');
$NumPgtos  = post('numpgtos');
$PgtoServicos = post('pgtotot');
$NEstorno = post('numestorno');
$ValorEstorno = post('vrestorno');

$Dinheiro = post('dinheiro');
$CardDeb = post('carddeb');
$CardVista = post('cardvista');
$CardParcLj = post('cardparclj');
$CardParcAdm = post('cardparcadm');
$PixQRCode = post('pixqrcode');
$PixCNPJ = post('pixcnpj');
$TotIn = post('totin');

$DDPtot = post('ddpf');
$MCStot = post('mcsf');
$MDVtot = post('mdvf');
$MPDtot = post('mpdf');
$RCLtot = post('rclf');
$SRVtot = post('srvf');
$VTRtot = post('vtrf');
$OUTtot = post('outf');
$PgtoTot = post('pgtotot');

$Recolh = post('recolh', '0,00');
$TotPgto = post('totpgto', '0,00');
$IncSobraF = post('incsobra', '0,00');

$FechamentoF = post('fechamentoF', post('fechamento', '0,00'));
$GavAut = post('gavaut', '0,00');
$DifCx = post('difcx', '0,00');
$cd = post('cd');
$Diferenca = abs(num('difcx')) > 0.009;
$horaNorm = date("Hi");
$horaInv = date("iH");
$Reimp = '';
$Entradas = $TotIn;

$fech_data = trim(post('datafch', $_GET['datafch'] ?? ''));
$fech_data_obj = date_create_from_format('d/m/Y', $fech_data);

if (!$fech_data_obj) {
	die("Data de fechamento inválida para reimpressão.");
}

$fech_data_registro = date_format($fech_data_obj, 'Y-m-d');
$fech_data_oper = date_format($fech_data_obj, 'Y-m-d');
$fech_data_safe = date_format($fech_data_obj, 'Y-m-d');
$fech_data_recolh = date_format($fech_data_obj, 'Y-m-d');
$fech_data_spo = date_format($fech_data_obj, 'dmy');

?>

<!DOCTYPE html>
<html>

<head>
    <meta http-equiv="content-type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>WebCaixa v1.20.19_beta</title>
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
            table-layout: fixed;
            width: 100%;
        }

        p {
            margin: 0 0 0.6mm 0;
            line-height: 1.05;
            background: transparent;
        }

        td {
            box-sizing: border-box;
            vertical-align: top;
        }

        .tabela-info>tbody>tr>td {
            width: 15.833%;
        }

        .tabela-info>tbody>tr>td.espaco {
            width: 1%;
        }

        .tabela-dupla>tbody>tr>td {
            width: 49.5%;
        }

        .tabela-dupla>tbody>tr>td.espaco {
            width: 1%;
        }

        .tabela-quatro>tbody>tr>td {
            width: 24.25%;
        }

        .tabela-quatro>tbody>tr>td.espaco {
            width: 1%;
        }

        .tabela-quatro>tbody>tr>td,
        .tabela-dupla>tbody>tr>td,
        .tabela-info>tbody>tr>td {
            padding-left: 0;
            padding-right: 0;
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
                transform: scale(1.3);
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

<body lang="pt-BR" link="#000080" vlink="#800000" dir="ltr" onload="prepararImpressao();">
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
                                        <b>IMPRESSÃO DO WEBCAIXA (<?= $TipoFech ?>)</b>
                                    </font>
                                </font>
                            </p>
                        </td>
                    </tr>
                </table>
            </div>

            <table width="100%" cellpadding="4" cellspacing="0" class="tabela-info" style="margin-bottom: 0.05in">
                <tr>
                    <td width="15.833%" bgcolor="#999999" style="background: #999999; border: 1px solid #000000; padding: 0in">
                        <p class="txt-centro">
                            <font class="fonte-rel">
                                <font size="1" class="fs-7">
                                    <b>FITA</b>
                                </font>
                            </font>
                        </p>
                    </td>
                    <td width="1%" class="espaco" bgcolor="#ffffff" style="background: #ffffff; border: none; padding: 0in"></td>
                    <td width="15.833%" bgcolor="#999999" style="background: #999999; border: 1px solid #000000; padding: 0in">
                        <p class="txt-centro">
                            <font class="fonte-rel">
                                <font size="1" class="fs-7">
                                    <b>PC</b>
                                </font>
                            </font>
                        </p>
                    </td>
                    <td width="1%" class="espaco" bgcolor="#ffffff" style="background: #ffffff; border: none; padding: 0in"></td>
                    <td width="15.833%" bgcolor="#999999" style="background: #999999; border: 1px solid #000000; padding: 0in">
                        <p class="txt-centro">
                            <font class="fonte-rel">
                                <font size="1" class="fs-7">
                                    <b>DATA</b>
                                </font>
                            </font>
                        </p>
                    </td>
                    <td width="1%" class="espaco" bgcolor="#ffffff" style="background: #ffffff; border: none; padding: 0in"></td>
                    <td width="15.833%" bgcolor="#999999" style="background: #999999; border: 1px solid #000000; padding: 0in">
                        <p class="txt-centro">
                            <font class="fonte-rel">
                                <font size="1" class="fs-7">
                                    <b>HORA</b>
                                </font>
                            </font>
                        </p>
                    </td>
                    <td width="1%" class="espaco" bgcolor="#ffffff" style="background: #ffffff; border: none; padding: 0in"></td>
                    <td width="15.833%" bgcolor="#999999" style="background: #999999; border: 1px solid #000000; padding: 0in">
                        <p class="txt-centro">
                            <font class="fonte-rel">
                                <font size="1" class="fs-7">
                                    <b>OPERADOR</b>
                                </font>
                            </font>
                        </p>
                    </td>
                    <td width="1%" class="espaco" bgcolor="#ffffff" style="background: #ffffff; border: none; padding: 0in"></td>
                    <td width="15.833%" bgcolor="#999999" style="background: #999999; border: 1px solid #000000; padding: 0in">
                        <p class="txt-centro">
                            <font class="fonte-rel">
                                <font size="1" class="fs-7"><b>ABERTURA</b></font>
                            </font>
                        </p>
                    </td>
                </tr>
                <tr>
                    <td width="15.833%" height="13" bgcolor="#ffffff" style="background: #ffffff; border-top: none; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000; padding-top: 0in; padding-bottom: 0in; padding-left: 0in; padding-right: 0in">
                        <p class="txt-centro">
                            <font class="fonte-rel">
                                <font size="1" class="fs-7"><?= $Fita ?>/<?= $ano ?></font>
                            </font>
                        </p>
                    </td>
                    <td width="1%" class="espaco" bgcolor="#ffffff" style="background: #ffffff; border: none; padding: 0in"></td>
                    <td width="15.833%" bgcolor="#ffffff" style="background: #ffffff; border-top: none; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000; padding-top: 0in; padding-bottom: 0in; padding-left: 0in; padding-right: 0in">
                        <p class="txt-centro">
                            <font class="fonte-rel">
                                <font size="1" class="fs-7"><?= $PC ?></font>
                            </font>
                        </p>
                    </td>
                    <td width="1%" class="espaco" bgcolor="#ffffff" style="background: #ffffff; border: none; padding: 0in"></td>
                    <td width="15.833%" bgcolor="#ffffff" style="background: #ffffff; border-top: none; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000; padding-top: 0in; padding-bottom: 0in; padding-left: 0in; padding-right: 0in">
                        <p class="txt-centro">
                            <font class="fonte-rel">
                                <font size="1" class="fs-7"><?= $dataFch ?></font>
                            </font>
                        </p>
                    </td>
                    <td width="1%" class="espaco" bgcolor="#ffffff" style="background: #ffffff; border: none; padding: 0in"></td>
                    <td width="15.833%" bgcolor="#ffffff" style="background: #ffffff; border-top: none; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000; padding-top: 0in; padding-bottom: 0in; padding-left: 0in; padding-right: 0in">
                        <p class="txt-centro">
                            <font class="fonte-rel">
                                <font size="1" class="fs-7"><?= $hora ?></font>
                            </font>
                        </p>
                    </td>
                    <td width="1%" class="espaco" bgcolor="#ffffff" style="background: #ffffff; border: none; padding: 0in"></td>
                    <td width="15.833%" bgcolor="#ffffff" style="background: #ffffff; border-top: none; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000; padding-top: 0in; padding-bottom: 0in; padding-left: 0in; padding-right: 0in">
                        <p class="txt-centro">
                            <font class="fonte-rel">
                                <font size="1" class="fs-7"><?= $app ?></font>
                            </font>
                        </p>
                    </td>
                    <td width="1%" class="espaco" bgcolor="#ffffff" style="background: #ffffff; border: none; padding: 0in"></td>
                    <td width="15.833%" bgcolor="#ffffff" style="background: #ffffff; border-top: none; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000; padding-top: 0in; padding-bottom: 0in; padding-left: 0in; padding-right: 0in">
                        <p class="txt-centro">
                            <font class="fonte-rel">
                                <font size="1" class="fs-7">
                                    <b>R$ <?= $inicial ?></b>
                                </font>
                            </font>
                        </p>
                    </td>
                </tr>
            </table>

            <table width="100%" cellpadding="4" cellspacing="0" class="tabela-dupla" style="margin-bottom: 0.05in">
                <tr>
                    <td width="49.5%" height="14" bgcolor="#b2b2b2" style="background: #b2b2b2; border: 1px solid #000000; padding: 0in">
                        <p class="txt-centro">
                            <font class="fonte-rel">
                                <font size="1" class="fs-6">
                                    <b>RECEBIMENTOS</b>
                                </font>
                            </font>
                        </p>
                    </td>
                    <td width="1%" class="espaco" style="border: none; padding: 0in"></td>
                    <td width="49.5%" bgcolor="#b2b2b2" style="background: #b2b2b2; border: 1px solid #000000; padding: 0in">
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

            <table width="100%" cellpadding="4" cellspacing="0" class="tabela-quatro" style="margin-bottom: 0.05in">
                <tr>
                    <td width="24.25%" height="11" bgcolor="#dddddd" style="background: #dddddd; border: 1px solid #000000; padding: 0in">
                        <p class="txt-centro">
                            <font class="fonte-rel">
                                <font size="1" class="fs-6">
                                    <b>TIPO SERVIÇO</b>
                                </font>
                            </font>
                        </p>
                    </td>
                    <td width="1%" class="espaco" bgcolor="#ffffff" style="background: #ffffff; border: none; padding: 0in"></td>
                    <td width="24.25%" bgcolor="#dddddd" style="background: #dddddd; border: 1px solid #000000; padding: 0in">
                        <p class="txt-centro">
                            <font class="fonte-rel">
                                <font size="1" class="fs-6">
                                    <b>FORMA RECEBIMENTO</b>
                                </font>
                            </font>
                        </p>
                    </td>
                    <td width="1%" class="espaco" bgcolor="#ffffff" style="background: #ffffff; border: none; padding: 0in"></td>
                    <td width="24.25%" bgcolor="#dddddd" style="background: #dddddd; border: 1px solid #000000; padding: 0in">
                        <p class="txt-centro">
                            <font class="fonte-rel">
                                <font size="1" class="fs-6">
                                    <b>DESPESAS</b>
                                </font>
                            </font>
                        </p>
                    </td>
                    <td width="1%" class="espaco" bgcolor="#ffffff" style="background: #ffffff; border: none; padding: 0in"></td>
                    <td width="24.25%" bgcolor="#dddddd" style="background: #dddddd; border: 1px solid #000000; padding: 0in">
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

            <table width="100%" cellpadding="4" cellspacing="0" class="tabela-quatro" style="margin-bottom: 0.05in">
                <tr valign="top">
                    <td width="24.25%" class="coluna-topo" style="border: 1px solid #000000; padding: 0.04in;">
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
                                if (valor_num($NTxProd) > 0 && valor_num($ValorProd) > 0) {
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
                                                        <i>R$ <?= $ValorProd ?></i>
                                                    </font>
                                                </font>
                                            </p>
                                        </td>
                                    </tr>
                                <?php
                                }

                                if (valor_num($NConcurso) > 0 && valor_num($ValorConc) > 0) {
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
                                                        <i>R$ <?= $ValorConc ?></i>
                                                    </font>
                                                </font>
                                            </p>
                                        </td>
                                    </tr>
                                <?php
                                }

                                if (valor_num($NContEnt) > 0 && valor_num($ValorContEnt) > 0) {
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
                                                        <i>R$ <?= $ValorContEnt ?></i>
                                                    </font>
                                                </font>
                                            </p>
                                        </td>
                                    </tr>
                                <?php
                                }

                                if (valor_num($NContParc) > 0 && valor_num($ValorContParc) > 0) {
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
                                                        <i>R$ <?= $ValorContParc ?></i>
                                                    </font>
                                                </font>
                                            </p>
                                        </td>
                                    </tr>
                                <?php
                                }

                                if (valor_num($NPropEnt) > 0 && valor_num($ValorPropEnt) > 0) {
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
                                                        <i>R$ <?= $ValorPropEnt ?></i>
                                                    </font>
                                                </font>
                                            </p>
                                        </td>
                                    </tr>
                                <?php
                                }

                                if (valor_num($NPRecs) > 0 && valor_num($VrPRecsF) > 0) {
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
                                                        <i>R$ <?= $VrPRecsF ?></i>
                                                    </font>
                                                </font>
                                            </p>
                                        </td>
                                    </tr>
                                <?php
                                }

                                if (valor_num($NBookRec) > 0 && valor_num($VrBookRecF) > 0) {
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
                                                        <i>R$ <?= $VrBookRecF ?></i>
                                                    </font>
                                                </font>
                                            </p>
                                        </td>
                                    </tr>
                                <?php
                                }

                                if (valor_num($NumPgtos) > 0 && valor_num($PgtoServicos) > 0) {
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
                                                        <i>R$ <?= $PgtoServicos ?></i>
                                                    </font>
                                                </font>
                                            </p>
                                        </td>
                                    </tr>
                                <?php
                                } else {
                                    echo $NumPgtos . "<br>";
                                    echo $PgtoServicos . "<br>";
                                }

                                if (valor_num($NEstorno) > 0 && valor_num($ValorEstorno) > 0) {
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
                                                        <i>R$ <?= $ValorEstorno ?></i>
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

                    <td width="1%" class="espaco" style="border: none; padding: 0in"></td>

                    <td width="24.25%" class="coluna-topo" style="border: 1px solid #000000; padding: 0.04in;">
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

                                    <?php if (valor_num($Dinheiro) > 0) { ?>
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
                                                        <font size="1" class="fs-6"><i>R$ <?= $Dinheiro ?></i></font>
                                                    </font>
                                                </p>
                                            </td>
                                        </tr>
                                    <?php } ?>

                                    <?php if (valor_num($CardDeb) > 0) { ?>
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
                                                        <font size="1" class="fs-6"><i>R$ <?= $CardDeb ?></i></font>
                                                    </font>
                                                </p>
                                            </td>
                                        </tr>
                                    <?php } ?>

                                    <?php if (valor_num($CardVista) > 0) { ?>
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
                                                        <font size="1" class="fs-6"><i>R$ <?= $CardVista ?></i></font>
                                                    </font>
                                                </p>
                                            </td>
                                        </tr>
                                    <?php } ?>

                                    <?php if (valor_num($CardParcLj) > 0) { ?>
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
                                                        <font size="1" class="fs-6"><i>R$ <?= $CardParcLj ?></i></font>
                                                    </font>
                                                </p>
                                            </td>
                                        </tr>
                                    <?php } ?>

                                    <?php if (valor_num($CardParcAdm) > 0) { ?>
                                        <tr>
                                            <td width="68%" style="border: none; padding: 0in">
                                                <p>
                                                    <font class="fonte-rel">
                                                        <font size="1" class="fs-6"><i>Cartão Crédito Parc. Adm</i></font>
                                                    </font>
                                                </p>
                                            </td>
                                            <td width="32%" style="border: none; padding: 0in">
                                                <p>
                                                    <font class="fonte-rel">
                                                        <font size="1" class="fs-6"><i>R$ <?= $CardParcLj ?></i></font>
                                                    </font>
                                                </p>
                                            </td>
                                        </tr>
                                    <?php } ?>

                                    <?php if (valor_num($PixQRCode) > 0) { ?>
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
                                                        <font size="1" class="fs-6"><i>R$ <?= $PixQRCode ?></i></font>
                                                    </font>
                                                </p>
                                            </td>
                                        </tr>
                                    <?php } ?>

                                    <?php if (valor_num($PixCNPJ) > 0) { ?>
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
                                                        <font size="1" class="fs-6"><i>R$ <?= $PixCNPJ ?></i></font>
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
                                                    <font size="1" class="fs-6"><i><b>R$ <?= $TotIn ?></b></i></font>
                                                </font>
                                            </p>
                                        </td>
                                    </tr>
                                </table>
                            </div>

                        </div>
                    </td>

                    <td width="1%" class="espaco" style="border: none; padding: 0in"></td>

                    <td width="24.25%" class="coluna-topo" style="border: 1px solid #000000; padding: 0.04in;">
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

                                    <?php if (valor_num($DDPtot) > 0) { ?>
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
                                                        <font size="1" class="fs-6"><i>R$ <?= $DDPtot ?></i></font>
                                                    </font>
                                                </p>
                                            </td>
                                        </tr>
                                    <?php } ?>
                                    <?php if (valor_num($MCStot) > 0) { ?>
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
                                                        <font size="1" class="fs-6"><i>R$ <?= $MCStot ?></i></font>
                                                    </font>
                                                </p>
                                            </td>
                                        </tr>
                                    <?php } ?>
                                    <?php if (valor_num($MDVtot) > 0) { ?>
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
                                                        <font size="1" class="fs-6"><i>R$ <?= $MDVtot ?></i></font>
                                                    </font>
                                                </p>
                                            </td>
                                        </tr>
                                    <?php } ?>
                                    <?php if (valor_num($MPDtot) > 0) { ?>
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
                                                        <font size="1" class="fs-6"><i>R$ <?= $MPDtot ?></i></font>
                                                    </font>
                                                </p>
                                            </td>
                                        </tr>
                                    <?php } ?>
                                    <?php if (valor_num($RCLtot) > 0) { ?>
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
                                                        <font size="1" class="fs-6"><i>R$ <?= $RCLtot ?></i></font>
                                                    </font>
                                                </p>
                                            </td>
                                        </tr>
                                    <?php } ?>
                                    <?php if (valor_num($SRVtot) > 0) { ?>
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
                                                        <font size="1" class="fs-6"><i>R$ <?= $SRVtot ?></i></font>
                                                    </font>
                                                </p>
                                            </td>
                                        </tr>
                                    <?php } ?>
                                    <?php if (valor_num($VTRtot) > 0) { ?>
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
                                                        <font size="1" class="fs-6"><i>R$ <?= $VTRtot ?></i></font>
                                                    </font>
                                                </p>
                                            </td>
                                        </tr>
                                    <?php } ?>
                                    <?php if (valor_num($OUTtot) > 0) { ?>
                                        <tr>
                                            <td width="68%" style="border: none; padding: 0in">
                                                <p>
                                                    <font class="fonte-rel">
                                                        <font size="1" class="fs-6"><i>Outros</i></font>
                                                    </font>
                                                </p>
                                            </td>
                                            <td width="32%" style="border: none; padding: 0in">
                                                <p>
                                                    <font class="fonte-rel">
                                                        <font size="1" class="fs-6"><i>R$ <?= $OUTtot ?></i></font>
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
                                                    <font size="1" class="fs-6"><i><b>R$ <?= $PgtoTot ?></b></i></font>
                                                </font>
                                            </p>
                                        </td>
                                    </tr>
                                </table>
                            </div>

                        </div>
                    </td>

                    <td width="1%" class="espaco" style="border: none; padding: 0in"></td>

                    <td width="24.25%" class="coluna-topo" style="border: 1px solid #000000; padding: 0.04in;">
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
                                                    <?php if (valor_num($Recolh) > 0) { ?>
                                                        <i>R$ <?= $Recolh ?></i>
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
                                                <font size="1" class="fs-6"><i>R$ <?= $TotPgto ?></i></font>
                                            </font>
                                        </p>
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </td>
                </tr>
            </table>

            <?php if (valor_num($IncSobraF) > 0) { ?>
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
                                            <i>R$ <?= $IncSobraF ?></i>
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
                                        <font size="1" class="fs-6"><i>R$ <?= $FechamentoF ?></i></font>
                                    </font>
                                </p>
                            </td>
                            <td style="border:none; padding:0in">
                                <p class="txt-centro">
                                    <font class="fonte-rel">
                                        <font size="1" class="fs-6"><i>R$ <?= $GavAut ?></i></font>
                                    </font>
                                </p>
                            </td>
                            <td style="border:none; padding:0in">
                                <p class="txt-centro">
                                    <font class="fonte-rel">
                                        <font size="1" class="fs-6"><i>R$ <?= $DifCx ?></i></font>
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
                                        <font size="1" class="fs-6"><i>R$ <?= $FechamentoF ?></i></font>
                                    </font>
                                </p>
                            </td>
                            <td style="border:none; padding:0in">
                                <p class="txt-centro">
                                    <font class="fonte-rel">
                                        <font size="1" class="fs-6"><i>R$ <?= $GavAut ?></i></font>
                                    </font>
                                </p>
                            </td>
                            <td style="border:none; padding:0in">
                                <p class="txt-centro">
                                    <font class="fonte-rel">
                                        <font size="1" class="fs-6"><i>R$ <?= $DifCx ?></i></font>
                                    </font>
                                </p>
                            </td>
                        </tr>
                    </table>
                </div>
            <?php }
            $spools = [];

            $fech_data_spo_safe = mysqli_real_escape_string($conec, $fech_data_spo);

            $SqlSp = "SELECT spo FROM spool WHERE spo LIKE '%$fech_data_spo_safe%' ORDER BY rec";
            $rsSp  = mysqli_query($conec, $SqlSp) or die("Não foi possível obter dados da spool");

            while ($lnSp = mysqli_fetch_assoc($rsSp)) {
                $spools[] = $lnSp['spo'];
            }

            ?>
                <div class="bloco-autenticacoes">
            <?php
            if (!empty($spools)) {
            ?>

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
                    $totalSpo = count($spools);

                    for ($i = 0; $i < $totalSpo; $i += 3) {
                        $coluna1 = htmlspecialchars($spools[$i] ?? '', ENT_QUOTES, 'UTF-8');
                        $coluna2 = htmlspecialchars($spools[$i + 1] ?? '', ENT_QUOTES, 'UTF-8');
                        $coluna3 = htmlspecialchars($spools[$i + 2] ?? '', ENT_QUOTES, 'UTF-8');
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
                </div>
            <?php }

            // Obtendo a Relação de Operadores Cadastrados
            $Oper = [
                'matopf' => [],
                'cargo'  => [],
                'tempo'  => [],
                'respf'  => []
            ];

            $sqlH2 = "SELECT * FROM operador WHERE dataop = '$fech_data_oper'";
            $rsH2  = mysqli_query($conec, $sqlH2) or die("Não foi possível acessar o Histórico-2");

            while ($lnH2 = mysqli_fetch_assoc($rsH2)) {

                $MatOp  = $lnH2['mat'];
                $MatOpF = substr($MatOp, 0, 1) . "." . substr($MatOp, 1, 3) . "." . substr($MatOp, 4, 3) . "-" . substr($MatOp, 7, 1);

                $Cargo  = ($lnH2['cargo'] == 'Cai') ? 'Ag. Adm' : $lnH2['cargo'];

                $Tempo  = $lnH2['horaop'];

                $Free   = $lnH2['free'];
                $Compl  = ($Free == 'f') ? ' - Free-Lancer' : '';

                $Resp   = $lnH2['resp'];
                $RespF  = substr($Resp, 0, 1) . "." . substr($Resp, 1, 3) . "." . substr($Resp, 4, 3) . "-" . substr($Resp, 7, 1);

                // ✅ Monta array corretamente
                $Oper['matopf'][] = $MatOpF . $Compl;
                $Oper['cargo'][]  = $Cargo;
                $Oper['tempo'][]  = $Tempo;
                $Oper['respf'][]  = $RespF;
            }

            if (!empty($Oper['matopf']) && is_array($Oper['matopf'])) { ?>
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
            <?php }

            // Obtendo a Relação de Recuperação de Senhas
            $RecSenhas = [];

            $sqlR = "SELECT * FROM restsenha WHERE datar = '$fech_data_safe'";
            $rsR  = mysqli_query($conec, $sqlR) or die("Não foi possível acessar Recuperação de Senhas");

            while ($lnR = mysqli_fetch_assoc($rsR)) {

                $UserR  = $lnR['user'];
                $UserRF = substr($UserR, 0, 1) . "." . substr($UserR, 1, 3) . "." . substr($UserR, 4, 3) . "-" . substr($UserR, 7, 1);

                $CpfR   = $lnR['cpf'];
                $CpfRF  = substr($CpfR, 0, 3) . "." . substr($CpfR, 3, 3) . "." . substr($CpfR, 6, 3) . "-" . substr($CpfR, 9, 2);

                $AudR   = $lnR['aud'];
                $AudRF  = substr($AudR, 0, 1) . "." . substr($AudR, 1, 3) . "." . substr($AudR, 4, 3) . "-" . substr($AudR, 7, 1);

                $DataR  = $lnR['datar'];
                $DataRF = substr($DataR, 8, 2) . "/" . substr($DataR, 5, 2) . "/" . substr($DataR, 0, 4);

                $HoraR  = $lnR['horar'];

                $RecSenhas[] = [
                    'user_rf' => $UserRF,
                    'cpf_rf'  => $CpfRF,
                    'aud_rf'  => $AudRF,
                    'data_rf' => $DataRF,
                    'hora_r'  => $HoraR
                ];
            }

            if (!empty($RecSenhas)) { ?>
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
                        $totalSenha = count($RecSenhas);
                        for ($i = 0; $i < $totalSenha; $i++) {
                            $solicitante = htmlspecialchars($RecSenhas[$i]['user_rf'] ?? '', ENT_QUOTES, 'UTF-8');
                            $data        = htmlspecialchars($RecSenhas[$i]['data_rf'] ?? '', ENT_QUOTES, 'UTF-8');
                            $autorizado  = htmlspecialchars($RecSenhas[$i]['aud_rf'] ?? '', ENT_QUOTES, 'UTF-8');
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
            <?php }

            // Obtendo o Total Depositado
            $sqlR = "select * from depositos where dtdep = '$fech_data_recolh' ";
            $rsR  = mysqli_query($conec, $sqlR) or die("Erro #4C!");

            while ($lnR  = mysqli_fetch_array($rsR)) {

                $hora  = $lnR['hrdep'];
                $envelope = $lnR['envelope'];
                $matricula = $lnR['matreceb'];
                $valor = $lnR['valor'];
                $valor = number_format($valor, 2, ',', '.');

                $Recolhimentos[] = [
                    'hora'    => $hora,
                    'envelope' => $envelope,
                    'matricula' => $matricula,
                    'valor'   => $valor
                ];
            }

            if (!empty($Recolhimentos) && is_array($Recolhimentos)) { ?>
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
                        $totalRec = count($Recolhimentos);
                        $totalRecValor = 0;

                        for ($i = 0; $i < $totalRec; $i++) {
                            $hora     = htmlspecialchars($Recolhimentos[$i]['hora'] ?? '', ENT_QUOTES, 'UTF-8');
                            $envelope = htmlspecialchars($Recolhimentos[$i]['envelope'] ?? '', ENT_QUOTES, 'UTF-8');
                            $matricula = htmlspecialchars($Recolhimentos[$i]['matricula'] ?? '', ENT_QUOTES, 'UTF-8');
                            $valorRaw = $Recolhimentos[$i]['valor'] ?? 0;
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
                    <font size="1" class="fs-6"><?= $Reimp ?><?= $horaNorm ?>-<?= $Dinheiro ?>-<?= $horaInv ?> <?= $horaInv ?><?= $horaNorm ?>-<?= $Entradas ?>-<?= $horaInv ?><?= $horaNorm ?></font>
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
