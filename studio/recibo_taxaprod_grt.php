<?php

// Debug
error_reporting(E_ALL);
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);

$tipo      = $_GET['tipo'];
$NDoc      = $_GET['NDoc'];
$PC        = $_GET['PC'];
$ModPag    = $_GET['ModPag'];
$FPag_1    = $_GET['fpag_1'];
$FPag_2    = $_GET['fpag_2'];
$FPag_3    = $_GET['fpag_3'];
$txt1      = $_GET['txt1'];
$txt2      = $_GET['txt2'];
$txt3      = $_GET['txt3'];
$VrProd    = $_GET['VrProd'];
$VrProdF   = number_format($VrProd, 2, ",", ".");
$VrProdA = number_format($VrProd, 2, "", ".");
$TaxaProdF = $_GET['TaxaProd'];

$FPags = [$FPag_1, $FPag_2, $FPag_3];
$Vlrs = [$txt1, $txt2, $txt3];

$data      = $_GET['data'];
$data = date('d/m/Y', strtotime($data));
$Vendedora = $_GET['Vendedora'];
$Cliente   = $_GET['Cliente'];
$vlr_ext   = $_GET['vlr_ext'];
$Reg       = $_GET['Reg'];
$horaaut   = $_GET['horaaut'];
$dtAut     = $_GET['dtAut'];
$SgRec     = $_GET['SgRec'];
$Mat       = $_GET['Mat'];
$Nasc      = $_GET['DataNasc'];
$Nasc      = date('d/m/Y', strtotime($Nasc));
$idade     = $_GET['Idade'];

?>

<!DOCTYPE html>

<html>

<head>

    <meta http-equiv="content-type" content="text/html; charset=utf-8" />
    <title>Recibo - <?php echo $Cliente . " - " . $tipo . " GRATUIDADE"; ?></title>
    <meta name="generator" content="LibreOffice 7.4.7.2 (Linux)" />
    <meta name="created" content="2025-06-16T12:56:54" />
    <meta name="changed" content="2025-08-20T17:55:04.895764472" />
    <meta name="AppVersion" content="15.0000" />

    <style type="text/css">
        .container {
            position: relative;
            width: fit-content;
            /* Ajusta ao tamanho da tabela */
            height: fit-content;
        }

        .imagem_via1 {
            position: absolute;
            top: -1px;
            /* Ajuste a posição vertical */
            left: 5px;
            /* Ajuste a posição horizontal */
            width: 50px;
            /* Tamanho pequeno */
            height: auto;
            z-index: 2;
            /* Opcional: transparência */
            pointer-events: none;
            /* Para não bloquear clique na tabela */
        }

        .imagem_via2 {
            position: absolute;
            top: 300px;
            /* ajuste para a posição desejada */
            left: 5px;
            /* ajuste para a posição desejada */
            width: 50px;
            height: auto;
            z-index: 2;
            pointer-events: none;
        }

        .imagem_via3 {
            position: absolute;
            top: 562px;
            /* ajuste para a posição desejada */
            left: 5px;
            /* ajuste para a posição desejada */
            width: 50px;
            height: auto;
            z-index: 2;
            pointer-events: none;
        }

        .imagem_via4 {
            position: absolute;
            top: 826px;
            /* ajuste para a posição desejada */
            left: 5px;
            /* ajuste para a posição desejada */
            width: 50px;
            height: auto;
            z-index: 2;
            pointer-events: none;
        }

        .imagem_end_1 {
            position: absolute;
            top: 38px;
            left: 7px;
            width: 285px;
            /* Largura original */
            height: 65px;
            /* Altura original */
            object-fit: contain;
            /* Mantém a proporção da imagem */
        }

        .imagem_end_2 {
            position: absolute;
            top: 99px;
            left: 30px;
            width: 285px;
            /* Largura original */
            height: 540px;
            /* Altura original */
            object-fit: contain;
            /* Mantém a proporção da imagem */
        }

        .imagem_end_3 {
            position: absolute;
            top: 128px;
            left: 30px;
            width: 285px;
            /* Largura original */
            height: 1010px;
            /* Altura original */
            object-fit: contain;
            /* Mantém a proporção da imagem */
        }

        .imagem_end_4 {
            position: absolute;
            top: 415px;
            left: 30px;
            width: 285px;
            /* Largura original */
            height: 960px;
            /* Altura original */
            object-fit: contain;
            /* Mantém a proporção da imagem */
        }

        .texto {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            color: white;
            z-index: 1;
            /* Alterado para ficar abaixo da imagem */
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
        p {
            font-family: "Arial";
            font-size: x-small
        }

        a.comment-indicator:hover+comment {
            background: #ffd;
            position: absolute;
            display: block;
            border: 1px solid black;
            padding: 0.5em;
        }

        a.comment-indicator {
            background: red;
            display: inline-block;
            border: 1px solid black;
            width: 0.5em;
            height: 0.5em;
        }

        comment {
            display: none;
        }

        @media print {

            html,
            body {
                height: 297mm;
                width: 210mm;
                margin: 0;
                padding: 0;
                overflow: hidden;
                /* evita quebra */
            }

            /* Remove margens padrão */
            @page {
                margin: 2mm;
            }

            body {
                margin: 2mm;
                padding: 2mm;
            }

            /* Se quiser esconder elementos que não devem aparecer */
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
        <img src="./images/logo.png" alt="Imagem" class="imagem_via1">
        <img src="./images/logo.png" alt="Imagem" class="imagem_via2">
        <img src="./images/logo.png" alt="Imagem" class="imagem_via3">
        <img src="./images/logo.png" alt="Imagem" class="imagem_via4">

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

            <!-- Primeira via -->
            <tr>
                <td rowspan="3" align="left" valign=bottom></td>
                <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" colspan=4 rowspan=2 align="center" valign=middle>
                    <b>
                        <font size=4><?php echo $tipo; ?></font>
                    </b>
                </td>
                <td align="left" valign=bottom></td>
                <td style="border-top: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" colspan=2 align="center" valign=middle><b>
                        <font size=1>RECIBO</font>
                    </b></td>
                <td align="left" valign=bottom>
                    <font size=1></font>
                </td>
                <td style="border-top: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" colspan=2 align="center" valign=middle><b>
                        <font size=1>PC</font>
                    </b></td>
                <td align="center" valign=middle>
                    <font size=1></font>
                </td>
                <td style="border-top: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" colspan=2 align="center" valign=middle><b>
                        <font size=1>VALOR PAGO</font>
                    </b></td>
            </tr>
            <tr>
                <td height="5" align="left" valign=bottom></td>
                <td style="border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" colspan=2 align="center" valign=middle>
                    <font size=1><?php echo $NDoc; ?></font>
                </td>
                <td align="left" valign=bottom>
                    <font size=1></font>
                </td>
                <td style="border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" colspan=2 align="center" valign=middle>
                    <font size=1><?php echo $PC; ?></font>
                </td>
                <td align="left" valign=bottom>
                    <font size=1></font>
                </td>
                <td style="border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" colspan=2 align="center" valign=middle>
                    <font size=1><?php echo "R$ " . $VrProdF; ?></font>
                </td>
            </tr>
            <tr>
                <td height="4" align="left" valign=bottom></td>
            </tr>
            <tr>
                <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" colspan=5 rowspan=5 height="60" align="center" valign=middle>
                    <font size=1><img src="./images/endereco_pc<?php echo $PC; ?>.png" class="imagem_<font size=3><b>GRATUIDADE</b></font>"></font>
                </td>
                <td align="left" valign=bottom></td>
                <td style="border-top: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" colspan=2 align="center" valign=middle><b>
                        <font size=1>DATA</font>
                    </b></td>
                <td height="4" align="left" valign=bottom></td>
                <td style="border-top: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" colspan=2 align="center" valign=middle>
                    <b>
                        <font size=1>VENDEDORA</font>
                    </b>
                </td>
                <td height="4" align="left" valign=bottom></td>
            </tr>
            <tr>
                <td height="4" align="left" valign=bottom></td>
                <td style="border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" colspan=2 align="center" valign=middle>
                    <font size=1><?php echo $data; ?></font>
                </td>
                <td align="left" valign=bottom></td>
                <td style="border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" colspan=2 align="center" valign=middle>
                    <font size=1><?php echo $Vendedora; ?></font>
                </td>
            </tr>
            <tr>
                <td height="4" align="left" valign=bottom></td>
            </tr>
            <tr>
                <td align="left" valign=bottom></td>
                <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" colspan=2 rowspan=2 align="center" valign=middle>
                    <font size=3><b>GRATUIDADE</b></font>
                </td>
                <td height="4" align="left" valign=bottom></td>
                <td colspan=2 align="center" valign=middle></td>
                <td align="left" valign=bottom></td>
                <td colspan=2 align="center" valign=middle></td>
            </tr>
            <tr>
                <td height="4" align="left" valign=bottom></td>
                <td height="4" align="left" valign=bottom></td>
                <td colspan=2 align="center" valign=middle></td>
                <td align="left" valign=bottom></td>
                <td colspan=2 align="center" valign=middle></td>
            </tr>
            <tr>
                <td height="4" align="left" valign=bottom></td>
            </tr>
            <tr>
                <td style="border-top: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" colspan=2 height="11" align="left" valign=middle>
                    <b>
                        <font size=1>NASC.</font>
                    </b>
                </td>
                <td align="left" valign=middle></td>
                <td style="border-top: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" colspan=11 align="left" valign=middle>
                    <b>
                        <font size=1>ASSINATURA</font>
                    </b>
                </td>
            </tr>
            <tr>
                <td style="border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" colspan=2 height="17" align="center" valign=middle>
                    <font size=1><?php echo  $Nasc; ?></font>
                </td>
                <td align="center" valign=middle></td>
                <td style="border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" colspan=11 align="center" valign=middle></td>
            </tr>
            <tr>
                <td height="4" align="left" valign=bottom></td>
            </tr>
            <tr>
                <td style="border-top: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" colspan=14 height="11" align="left" valign=middle>
                    <b>
                        <font size=1>A IMPORTÂNCIA TOTAL DE</font>
                    </b>
                </td>
            </tr>
            <tr>
                <td style="border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" colspan=14 height="17" align="center" valign=middle>
                    <font size=1><?php echo $vlr_ext; ?></font>
                </td>
            </tr>
            <tr>
                <td height="4" align="left" valign=bottom></td>
            </tr>
            <tr>
                <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" colspan=14 height="11" align="center" valign=middle>
                    <b>
                        <font size=1>AUTENTICAÇÃO</font>
                    </b>
                </td>
            </tr>
            <tr>
                <td height="4" align="left" valign=bottom></td>
            </tr>
            <tr>
                <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" colspan=14 height="20" align="center" valign=middle>
                    <font size=1><?php echo $Reg . $PC . $horaaut . $NDoc . $dtAut . $SgRec . $VrProdA . $Mat; ?></font>
                </td>
            </tr>
            <tr>
                <td height="4" align="left" valign=bottom></td>
            </tr>
            <tr>
                <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" colspan=14 rowspan=2 height="30" align="center" valign=middle>
                    <b>
                        <font size=5>(VIA TESOURARIA)</font>
                    </b>
                </td>
            </tr>
            <tr>
                <td height="4" align="left" valign=bottom></td>
            </tr>
            <tr>
                <td colspan=14 height="26" align="center" valign=middle>
                    <font size=1>------------------------------------------------------------------------------------------------------------------------------------------------------------------</font>
                </td>
            </tr>

            <!-- Segunda via -->
            <tr>
                <td rowspan="3" align="left" valign=bottom></td>
                <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" colspan=4 rowspan=2 align="center" valign=middle>
                    <b>
                        <font size=4><?php echo $tipo; ?></font>
                    </b>
                </td>
                <td align="left" valign=bottom></td>
                <td style="border-top: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" colspan=2 align="center" valign=middle>
                    <b>
                        <font size=1>RECIBO</font>
                    </b>
                </td>
                <td align="left" valign=bottom></td>
                <td style="border-top: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" colspan=2 align="center" valign=middle>
                    <b>
                        <font size=1>PC</font>
                    </b>
                </td>
                <td align="center" valign=middle></td>
                <td style="border-top: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" colspan=2 align="center" valign=middle>
                    <b>
                        <font size=1>VALOR PAGO</font>
                    </b>
                </td>
            </tr>
            <tr>
                <td height="5" align="left" valign=bottom></td>
                <td style="border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" colspan=2 align="center" valign=middle>
                    <font size=1><?php echo $NDoc; ?></font>
                </td>
                <td align="left" valign=bottom></td>
                <td style="border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" colspan=2 align="center" valign=middle>
                    <font size=1><?php echo $PC; ?></font>
                </td>
                <td align="left" valign=bottom></td>
                <td style="border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" colspan=2 align="center" valign=middle>
                    <font size=1><?php echo "R$ " . $VrProdF; ?></font>
                </td>
            </tr>
            <tr>
                <td height="4" align="left" valign=bottom></td>
            </tr>
            <tr>
                <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" colspan=5 rowspan=5 height="60" align="center" valign=middle>
                    <font size=1><img src="./images/endereco_pc<?php echo $PC; ?>.png" class="imagem_end_2"></font>
                </td>
                <td align="left" valign=bottom></td>
                <td style="border-top: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" colspan=2 align="center" valign=middle>
                    <b>
                        <font size=1>DATA</font>
                    </b>
                </td>
                <td height="4" align="left" valign=bottom></td>
                <td style="border-top: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" colspan=2 align="center" valign=middle>
                    <b>
                        <font size=1>VENDEDORA</font>
                    </b>
                </td>
                <td height="4" align="left" valign=bottom></td>
            </tr>
            <tr>
                <td height="4" align="left" valign=bottom></td>
                <td style="border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" colspan=2 align="center" valign=middle>
                    <font size=1><?php echo $data; ?></font>
                </td>
                <td align="left" valign=bottom></td>
                <td style="border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" colspan=2 align="center" valign=middle>
                    <font size=1><?php echo $Vendedora; ?></font>
                </td>
            </tr>
            <tr>
                <td height="4" align="left" valign=bottom></td>
            </tr>
            <tr>
                <td align="left" valign=bottom></td>
                <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" colspan=2 rowspan=2 align="center" valign=middle>
                    <font size=3><b>GRATUIDADE</b></font>
                </td>
                <td height="4" align="left" valign=bottom></td>
                <td colspan=2 align="center" valign=middle></td>
                <td align="left" valign=bottom></td>
                <td colspan=2 align="center" valign=middle></td>
            </tr>
            <tr>
                <td height="4" align="left" valign=bottom></td>
                <td height="4" align="left" valign=bottom></td>
                <td colspan=2 align="center" valign=middle></td>
                <td align="left" valign=bottom></td>
                <td colspan=2 align="center" valign=middle>
                    <font size=1></font>
                </td>
            </tr>
            <tr>
                <td height="4" align="left" valign=bottom></td>
            </tr>
            <tr>
                <td style="border-top: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" colspan=2 height="11" align="left" valign=middle><b>
                        <font size=1>NASC.</font>
                    </b></td>
                <td align="left" valign=middle><b>
                        <font size=1></font>
                    </b></td>
                <td style="border-top: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" colspan=11 align="left" valign=middle><b>
                        <font size=1>ASSINATURA</font>
                    </b></td>
            </tr>
            <tr>
                <td style="border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" colspan=2 height="17" align="center" valign=middle>
                    <font size=1><?php echo  $Nasc; ?></font>
                </td>
                <td align="center" valign=middle>
                    <font size=1></font>
                </td>
                <td style="border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" colspan=11 align="center" valign=middle>
                    <font size=1><?php echo $Cliente; ?></font>
                </td>
            </tr>
            <tr>
                <td height="4" align="left" valign=bottom></td>
            </tr>
            <tr>
                <td style="border-top: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" colspan=14 height="11" align="left" valign=middle><b>
                        <font size=1>A IMPORTÂNCIA TOTAL DE</font>
                    </b></td>
            </tr>
            <tr>
                <td style="border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" colspan=14 height="17" align="center" valign=middle>
                    <font size=1><?php echo $vlr_ext; ?></font>
                </td>
            </tr>
            <tr>
                <td height="4" align="left" valign=bottom></td>
            </tr>
            <tr>
                <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" colspan=14 height="11" align="center" valign=middle><b>
                        <font size=1>AUTENTICAÇÃO</font>
                    </b></td>
            </tr>
            <tr>
                <td height="4" align="left" valign=bottom></td>
            </tr>
            <tr>
                <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" colspan=14 height="20" align="center" valign=middle>
                    <font size=1><?php echo $Reg . $PC . $horaaut . $NDoc . $dtAut . $SgRec . $VrProdA . $Mat; ?></font>
                </td>
            </tr>
            <tr>
                <td height="4" align="left" valign=bottom></td>
            </tr>
            <tr>
                <td colspan=14 height="26" align="center" valign=middle>
                    <font size=1>------------------------------------------------------------------------------------------------------------------------------------------------------------------</font>
                </td>
            </tr>
            <!-- Terceira via -->
            <tr>
                <td rowspan="3" align="left" valign=bottom></td>
                <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" colspan=4 rowspan=2 align="center" valign=middle>
                    <b>
                        <font size=4><?php echo $tipo; ?></font>
                    </b>
                </td>
                <td align="left" valign=bottom></td>
                <td style="border-top: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" colspan=2 align="center" valign=middle><b>
                        <font size=1>RECIBO</font>
                    </b></td>
                <td align="left" valign=bottom>
                    <font size=1></font>
                </td>
                <td style="border-top: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" colspan=2 align="center" valign=middle><b>
                        <font size=1>PC</font>
                    </b></td>
                <td align="center" valign=middle>
                    <font size=1></font>
                </td>
                <td style="border-top: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" colspan=2 align="center" valign=middle><b>
                        <font size=1>VALOR PAGO</font>
                    </b></td>
            </tr>
            <tr>
                <td height="5" align="left" valign=bottom></td>
                <td style="border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" colspan=2 align="center" valign=middle>
                    <font size=1><?php echo $NDoc; ?></font>
                </td>
                <td align="left" valign=bottom>
                    <font size=1></font>
                </td>
                <td style="border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" colspan=2 align="center" valign=middle>
                    <font size=1><?php echo $PC; ?></font>
                </td>
                <td align="left" valign=bottom>
                    <font size=1></font>
                </td>
                <td style="border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" colspan=2 align="center" valign=middle>
                    <font size=1><?php echo "R$ " . $VrProdF; ?></font>
                </td>
            </tr>
            <tr>
                <td height="4" align="left" valign=bottom></td>
            </tr>
            <tr>
                <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" colspan=5 rowspan=5 height="60" align="center" valign=middle>
                    <font size=1><img src="./images/endereco_pc<?php echo $PC; ?>.png" class="imagem_end_3"></font>
                </td>
                <td align="left" valign=bottom></td>
                <td style="border-top: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" colspan=2 align="center" valign=middle><b>
                        <font size=1>DATA</font>
                    </b></td>
                <td height="4" align="left" valign=bottom></td>
                <td style="border-top: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" colspan=2 align="center" valign=middle><b>
                        <font size=1>VENDEDORA</font>
                    </b></td>
                <td height="4" align="left" valign=bottom></td>
            </tr>
            <tr>
                <td height="4" align="left" valign=bottom></td>
                <td style="border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" colspan=2 align="center" valign=middle>
                    <font size=1><?php echo $data; ?></font>
                </td>
                <td align="left" valign=bottom></td>
                <td style="border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" colspan=2 align="center" valign=middle>
                    <font size=1><?php echo $Vendedora; ?></font>
                </td>
            </tr>
            <tr>
                <td height="4" align="left" valign=bottom></td>
            </tr>
            <tr>
                <td align="left" valign=bottom></td>
                <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" colspan=2 rowspan=2 align="center" valign=middle>
                    <font size=3><b>GRATUIDADE</b></font>
                </td>
                <td height="4" align="left" valign=bottom></td>
                <td colspan=2 align="center" valign=middle><b>
                        <font size=1></font>
                    </b></td>
                <td align="left" valign=bottom><b>
                        <font size=1></font>
                    </b></td>
                <td colspan=2 align="center" valign=middle><b>
                        <font size=1></font>
                    </b></td>
            </tr>
            <tr>
                <td height="4" align="left" valign=bottom></td>
                <td height="4" align="left" valign=bottom></td>
                <td colspan=2 align="center" valign=middle></td>
                <td align="left" valign=bottom></td>
                <td colspan=2 align="center" valign=middle></td>
            </tr>
            <tr>
                <td height="4" align="left" valign=bottom></td>
            </tr>
            <tr>
                <td style="border-top: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" colspan=2 height="11" align="left" valign=middle><b>
                        <font size=1>NASC.</font>
                    </b></td>
                <td align="left" valign=middle></td>
                <td style="border-top: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" colspan=11 align="left" valign=middle>
                    <b>
                        <font size=1>ASSINATURA</font>
                    </b>
                </td>
            </tr>
            <tr>
                <td style="border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" colspan=2 height="17" align="center" valign=middle>
                    <font size=1><?php echo  $Nasc; ?></font>
                </td>
                <td align="center" valign=middle></td>
                <td style="border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" colspan=11 align="center" valign=middle>
                    <font size=1><?php echo $Cliente; ?></font>
                </td>
            </tr>
            <tr>
                <td height="4" align="left" valign=bottom></td>
            </tr>
            <tr>
                <td style="border-top: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" colspan=14 height="11" align="left" valign=middle>
                    <b>
                        <font size=1>A IMPORTÂNCIA TOTAL DE</font>
                    </b>
                </td>
            </tr>
            <tr>
                <td style="border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" colspan=14 height="17" align="center" valign=middle>
                    <font size=1><?php echo $vlr_ext; ?></font>
                </td>
            </tr>
            <tr>
                <td height="4" align="left" valign=bottom></td>
            </tr>
            <tr>
                <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" colspan=14 height="11" align="center" valign=middle>
                    <b>
                        <font size=1>AUTENTICAÇÃO</font>
                    </b>
                </td>
            </tr>
            <tr>
                <td height="4" align="left" valign=bottom></td>
            </tr>
            <tr>
                <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" colspan=14 height="20" align="center" valign=middle>
                    <font size=1><?php echo $Reg . $PC . $horaaut . $NDoc . $dtAut . $SgRec . $VrProdA . $Mat; ?></font>
                </td>
            </tr>
            <tr>
                <td height="4" align="left" valign=bottom></td>
            </tr>
            <tr>
                <td colspan=14 height="26" align="center" valign=middle>
                    <font size=1>------------------------------------------------------------------------------------------------------------------------------------------------------------------</font>
                </td>
            </tr>
            <!-- Quarta via -->
            <tr>
                <td rowspan="3" align="left" valign=bottom></td>
                <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" colspan=4 rowspan=2 align="center" valign=middle>
                    <b>
                        <font size=4><?php echo $tipo; ?></font>
                    </b>
                </td>
                <td align="left" valign=bottom></td>
                <td style="border-top: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" colspan=2 align="center" valign=middle>
                    <b>
                        <font size=1>RECIBO</font>
                    </b>
                </td>
                <td align="left" valign=bottom></td>
                <td style="border-top: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" colspan=2 align="center" valign=middle>
                    <b>
                        <font size=1>PC</font>
                    </b>
                </td>
                <td align="center" valign=middle>
                    <font size=1></font>
                </td>
                <td style="border-top: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" colspan=2 align="center" valign=middle>
                    <b>
                        <font size=1>VALOR PAGO</font>
                    </b>
                </td>
            </tr>
            <tr>
                <td height="5" align="left" valign=bottom></td>
                <td style="border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" colspan=2 align="center" valign=middle>
                    <font size=1><?php echo $NDoc; ?></font>
                </td>
                <td align="left" valign=bottom></td>
                <td style="border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" colspan=2 align="center" valign=middle>
                    <font size=1><?php echo $PC; ?></font>
                </td>
                <td align="left" valign=bottom></td>
                <td style="border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" colspan=2 align="center" valign=middle>
                    <font size=1><?php echo "R$ " . $VrProdF; ?></font>
                </td>
            </tr>
            <tr>
                <td height="4" align="left" valign=bottom></td>
            </tr>
            <tr>
                <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000"
                    colspan=5 rowspan=5 height="60" align="center" valign=middle>
                    <font size=1><img src="./images/endereco_pc<?php echo $PC; ?>.png" class="imagem_end_4"></font>
                </td>
                <td align="left" valign=bottom></td>
                <td style="border-top: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" colspan=2 align="center" valign=middle><b>
                        <font size=1>DATA</font>
                    </b></td>
                <td align="left" valign=bottom></td>
                <td style="border-top: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" colspan=2 align="center" valign=middle><b>
                        <font size=1>VENDEDORA</font>
                    </b></td>
                <td align="left" valign=bottom></td>
                <td align="left" valign=bottom></td>
                <td align="left" valign=bottom></td>
            </tr>
            <tr>
                <td align="left" valign=bottom></td>
                <td style="border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" colspan=2 align="center" valign=middle>
                    <font size=1>29/08/25</font>
                </td>
                <td align="left" valign=bottom></td>
                <td style="border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" colspan=2 align="center" valign=middle>
                    <font size=1><?php echo $Vendedora; ?></font>
                </td>
                <td align="left" valign=bottom></td>
                <td align="left" valign=bottom></td>
                <td align="left" valign=bottom></td>
            </tr>
            <tr>
                <td height="4" align="left" valign=bottom></td>
            </tr>
            <tr>
                <td align="left" valign=bottom></td>
                <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" colspan=2 rowspan=2 align="center" valign=middle>
                    <font size=3><b>GRATUIDADE</b></font>
                </td>
                <td align="left" valign=bottom></td>
                <td colspan=2 align="center" valign=middle></td>
                <td align="left" valign=bottom></td>
                <td colspan=2 align="center" valign=middle></td>
            </tr>
            <tr>
                <td align="left" valign=bottom></td>
            </tr>
            <tr>
                <td height="4" align="left" valign=bottom></td>
            </tr>
            <tr>
                <td style="border-top: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" colspan=2 height="11" align="left" valign=middle>
                    <b>
                        <font size=1>NASC.</font>
                    </b>
                </td>
                <td align="left" valign=middle></td>
                <td style="border-top: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" colspan=11 align="left" valign=middle>
                    <b>
                        <font size=1>ASSINATURA</font>
                    </b>
                </td>
            </tr>
            <tr>
                <td style="border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" colspan=2 height="17" align="center" valign=middle>
                    <font size=1><?php echo  $Nasc; ?></font>
                </td>
                <td align="center" valign=middle></td>
                <td style="border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" colspan=11 align="center" valign=middle>
                    <font size=1><?php echo $Cliente; ?></font>
                </td>
            </tr>
            <tr>
                <td height="4" align="left" valign=bottom></td>
            </tr>
            <tr>
                <td style="border-top: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" colspan=14 height="11" align="left" valign=middle>
                    <b>
                        <font size=1>A IMPORTÂNCIA TOTAL DE</font>
                    </b>
                </td>
            </tr>
            <tr>
                <td style="border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" colspan=14 height="17" align="center" valign=middle>
                    <font size=1><?php echo $vlr_ext; ?></font>
                </td>
            </tr>
            <tr>
                <td height="4" align="left" valign=bottom></td>
            </tr>
            <tr>
                <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" colspan=14 height="11" align="center" valign=middle>
                    <b>
                        <font size=1>AUTENTICAÇÃO</font>
                    </b>
                </td>
            </tr>
            <tr>
                <td height="4" align="left" valign=bottom></td>
            </tr>
            <tr>
                <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" colspan=14 height="20" align="center" valign=middle>
                    <font size=1><?php echo $Reg . $PC . $horaaut . $NDoc . $dtAut . $SgRec . $VrProdA . $Mat; ?>-9</font>
                </td>
            </tr>
            <tr>
                <td colspan=14 height="26" align="center" valign=middle>
                    <font size=1>------------------------------------------------------------------------------------------------------------------------------------------------------------------</font>
                </td>
            </tr>
        </table>
    </div>
</body>

</html>