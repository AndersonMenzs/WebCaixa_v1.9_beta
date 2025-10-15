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
$VrProdF    = $_GET['VrProd'];
//$VrProdF   = number_format($VrProd, 2, ",", ".");
//$VrProdA = number_format($VrProd, 2, "", ".");
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
$idade     = $_GET['Idade'];

?>

<!DOCTYPE html>

<html>

<head>

    <meta http-equiv="content-type" content="text/html; charset=utf-8" />
    <title></title>
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
            top: 265px;
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
            top: 529px;
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
            top: 793px;
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
            left: 10px;
            width: 285px;
            /* Largura original */
            height: 65px;
            /* Altura original */
            object-fit: contain;
            /* Mantém a proporção da imagem */
        }

        .imagem_end_2 {
            position: absolute;
            top: 76px;
            left: 10px;
            width: 285px;
            /* Largura original */
            height: 520px;
            /* Altura original */
            object-fit: contain;
            /* Mantém a proporção da imagem */
        }

        .imagem_end_3 {
            position: absolute;
            top: 114px;
            left: 10px;
            width: 285px;
            /* Largura original */
            height: 972px;
            /* Altura original */
            object-fit: contain;
            /* Mantém a proporção da imagem */
        }

        .imagem_end_4 {
            position: absolute;
            top: 416px;
            left: 10px;
            width: 285px;
            /* Largura original */
            height: 900px;
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

            /* Remove margens padrão */
            @page {
                margin: 0;
            }

            body {
                margin: 6mm;
                padding: 0;
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

<!--<body onload="window.print()">-->

<body>
    <div class="container">
        <img src="./images/logo.png" alt="Imagem" class="imagem_via1">
        <img src="./images/logo.png" alt="Imagem" class="imagem_via2">
        <img src="./images/logo.png" alt="Imagem" class="imagem_via3">
        <img src="./images/logo.png" alt="Imagem" class="imagem_via4">
        <table align="left" cellspacing="0" border="0">
            <colgroup width="100"></colgroup>
            <colgroup width="100"></colgroup>
            <colgroup width="8"></colgroup>
            <colgroup width="85"></colgroup>
            <colgroup width="2"></colgroup>
            <colgroup width="8"></colgroup>
            <colgroup span="2" width="100"></colgroup>
            <colgroup width="8"></colgroup>
            <colgroup span="2" width="100"></colgroup>
            <colgroup width="8"></colgroup>
            <colgroup span="2" width="100"></colgroup>

            <!-- Primeira via -->
            <tr>
                <td rowspan="3" height="17" align="left" valign=bottom><br></td>
                <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" colspan=4 rowspan=2 align="center" valign=middle>
                    <b>
                        <font size=5><?php echo $tipo; ?></font>
                    </b></td>
                <td align="left" valign=bottom><br></td>
                <td style="border-top: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" colspan=2 align="center" valign=middle><b>
                        <font size=1>RECIBO</font>
                    </b></td>
                <td align="left" valign=bottom>
                    <font size=1><br></font>
                </td>
                <td style="border-top: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" colspan=2 align="center" valign=middle><b>
                        <font size=1>PC</font>
                    </b></td>
                <td align="center" valign=middle>
                    <font size=1><br></font>
                </td>
                <td style="border-top: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" colspan=2 align="center" valign=middle><b>
                        <font size=1>VALOR PAGO</font>
                    </b></td>
            </tr>
            <tr>
                <td align="left" valign=bottom><br></td>
                <td style="border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" colspan=2 align="center" valign=middle sdnum="1046;0;@">
                    <font size=1>22000001</font>
                </td>
                <td align="left" valign=bottom>
                    <font size=1><br></font>
                </td>
                <td style="border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" colspan=2 align="center" valign=middle sdval="222" sdnum="1046;">
                    <font size=1>222</font>
                </td>
                <td align="left" valign=bottom>
                    <font size=1><br></font>
                </td>
                <td style="border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" colspan=2 align="center" valign=middle sdval="0" sdnum="1046;0;[$R$-416] #.##0,00;[RED]-[$R$-416] #.##0,00">
                    <font size=1>R$ 0,00</font>
                </td>
            </tr>
            <tr>
                <td height="4" align="left" valign=bottom></td>
            </tr>
            <tr>
                <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" colspan=4 rowspan=5 height="60" align="center" valign=middle>
                    <font size=1>
                        <br><img src="./images/endereco_pc<?php echo $PC; ?>.png" class="imagem_end_1">
                    </font>
                </td>
                <td align="left" valign=bottom>
                    <font size=1><br></font>
                </td>
                <td style="border-top: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" colspan=2 align="center" valign=middle><b>
                        <font size=1>DATA</font>
                    </b></td>
                <td align="left" valign=bottom>
                    <font size=1><br></font>
                </td>
                <td style="border-top: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" colspan=2 align="center" valign=middle><b>
                        <font size=1>VENDEDORA</font>
                    </b></td>
                <td align="left" valign=bottom>
                    <font size=1><br></font>
                </td>
            </tr>
            <tr>
                <td align="left" valign=bottom>
                    <font size=1><br></font>
                </td>
                <td style="border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" colspan=2 align="center" valign=middle sdval="45898" sdnum="1046;0;DD/MM/AA">
                    <font size=1><?php echo $data; ?></font>
                </td>
                <td align="left" valign=bottom>
                    <font size=1><br></font>
                </td>
                <td style="border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" colspan=2 align="center" valign=middle>
                    <font size=1><?php echo $Vendedora; ?></font>
                </td>
                <td align="left" valign=bottom>
                    <font size=1><br></font>
                </td>
                <td align="left" valign=bottom><br></td>
                <td align="left" valign=bottom><br></td>
            </tr>
            <tr>
                <td height="4" align="left" valign=bottom></td><td height="4" align="left" valign=bottom></td>
            </tr>
            <tr>
                <td height="4" align="left" valign=bottom></td><td height="4" align="left" valign=bottom></td>
                <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" colspan=2 rowspan=2 align="center" valign=middle>
                    <b>GRATUIDADE</b>
                </td>
                <td align="left" valign=bottom>
                    <font size=1><br></font>
                </td>
                <td colspan=2 align="center" valign=middle><b>
                        <font size=1><br></font>
                    </b></td>
                <td align="left" valign=bottom><b>
                        <font size=1><br></font>
                    </b></td>
                <td colspan=2 align="center" valign=middle><b>
                        <font size=1><br></font>
                    </b></td>
            </tr>
            <tr>
                <td align="left" valign=bottom>
                    <font size=1><br></font>
                </td>
                <td align="left" valign=bottom>
                    <font size=1><br></font>
                </td>
                <td colspan=2 align="center" valign=middle>
                    <font size=1><br></font>
                </td>
                <td align="left" valign=bottom>
                    <font size=1><br></font>
                </td>
                <td colspan=2 align="center" valign=middle sdnum="1046;0;0,00%">
                    <font size=1><br></font>
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
                        <font size=1><br></font>
                    </b></td>
                <td style="border-top: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" colspan=11 align="left" valign=middle><b>
                        <font size=1>ASSINATURA</font>
                    </b></td>
            </tr>
            <tr>
                <td style="border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" colspan=2 height="17" align="center" valign=middle sdval="23640" sdnum="1046;0;DD/MM/AA">
                    <font size=1>20/09/64</font>
                </td>
                <td align="center" valign=middle>
                    <font size=1><br></font>
                </td>
                <td style="border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" colspan=11 align="center" valign=middle>
                    <font size=1>ISABELE GOMES PEREIRA</font>
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
                    <font size=1>ZERO REAIS</font>
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
                <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" colspan=14 height="26" align="center" valign=middle>
                    <font size=1>000122212322000001290825TXPG0000000035-9</font>
                </td>
            </tr>
            <tr>
                <td height="4" align="left" valign=bottom></td>
            </tr>
            <tr>
                <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" colspan=14 rowspan=2 height="40" align="center" valign=middle><b>
                        <font size=4>(VIA TESOURARIA)</font>
                    </b></td>
            </tr>
            <tr>
            </tr>
            <tr>
                <td colspan=14 height="26" align="center" valign=middle>
                    <font size=1>------------------------------------------------------------------------------------------------------------------------------------------------------------------</font>
                </td>
            </tr>
            <tr>
                <td rowspan=5 height="66" align="left" valign=bottom>
                    <font size=1><br><img src="Recibo1(TX.%20PRODU%C3%87%C3%83O%20-%20GRATUIDADE)_html_89d7323401fb32ff.png" width=54 height=53 hspace=2 vspace=8>
                    </font>
                </td>
                <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" colspan=4 rowspan=2 align="center" valign=middle><b>
                        <font size=5>TX. PRODUÇÃO</font>
                    </b></td>
                <td align="left" valign=bottom><br></td>
                <td style="border-top: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" colspan=2 align="center" valign=middle><b>
                        <font size=1>RECIBO</font>
                    </b></td>
                <td align="left" valign=bottom>
                    <font size=1><br></font>
                </td>
                <td style="border-top: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" colspan=2 align="center" valign=middle><b>
                        <font size=1>PC</font>
                    </b></td>
                <td align="center" valign=middle>
                    <font size=1><br></font>
                </td>
                <td style="border-top: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" colspan=2 align="center" valign=middle><b>
                        <font size=1>VALOR PAGO</font>
                    </b></td>
            </tr>
            <tr>
                <td align="left" valign=bottom><br></td>
                <td style="border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" colspan=2 align="center" valign=middle sdnum="1046;0;@">
                    <font size=1>22000001</font>
                </td>
                <td align="left" valign=bottom>
                    <font size=1><br></font>
                </td>
                <td style="border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" colspan=2 align="center" valign=middle sdval="222" sdnum="1046;">
                    <font size=1>222</font>
                </td>
                <td align="left" valign=bottom>
                    <font size=1><br></font>
                </td>
                <td style="border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" colspan=2 align="center" valign=middle sdval="0" sdnum="1046;0;[$R$-416] #.##0,00;[RED]-[$R$-416] #.##0,00">
                    <font size=1>R$ 0,00</font>
                </td>
            </tr>
            <tr>
                <td align="left" valign=bottom>
                    <font size=1><br></font>
                </td>
                <td align="left" valign=bottom>
                    <font size=1><br></font>
                </td>
                <td align="left" valign=bottom>
                    <font size=1><br></font>
                </td>
                <td align="left" valign=bottom>
                    <font size=1><br></font>
                </td>
                <td align="left" valign=bottom>
                    <font size=1><br></font>
                </td>
                <td align="left" valign=bottom>
                    <font size=1><br></font>
                </td>
                <td align="left" valign=bottom>
                    <font size=1><br></font>
                </td>
                <td align="left" valign=bottom>
                    <font size=1><br></font>
                </td>
                <td align="left" valign=bottom>
                    <font size=1><br></font>
                </td>
                <td align="left" valign=bottom>
                    <font size=1><br></font>
                </td>
                <td align="left" valign=bottom>
                    <font size=1><br></font>
                </td>
                <td align="left" valign=bottom>
                    <font size=1><br></font>
                </td>
                <td align="left" valign=bottom>
                    <font size=1><br></font>
                </td>
            </tr>
            <tr>
                <td align="left" valign=bottom>
                    <font size=1><br></font>
                </td>
                <td style="border-top: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" colspan=2 align="center" valign=middle><b>
                        <font size=1>DATA</font>
                    </b></td>
                <td align="left" valign=bottom>
                    <font size=1><br></font>
                </td>
                <td style="border-top: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" colspan=2 align="center" valign=middle><b>
                        <font size=1>VENDEDORA</font>
                    </b></td>
                <td align="left" valign=bottom>
                    <font size=1><br></font>
                </td>
                <td align="left" valign=bottom><br></td>
                <td align="left" valign=bottom><br></td>
            </tr>
            <tr>
                <td align="left" valign=bottom>
                    <font size=1><br></font>
                </td>
                <td style="border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" colspan=2 align="center" valign=middle sdval="45898" sdnum="1046;0;DD/MM/AA">
                    <font size=1>29/08/25</font>
                </td>
                <td align="left" valign=bottom>
                    <font size=1><br></font>
                </td>
                <td style="border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" colspan=2 align="center" valign=middle>
                    <font size=1>Rafaella B.</font>
                </td>
                <td align="left" valign=bottom>
                    <font size=1><br></font>
                </td>
                <td align="left" valign=bottom><br></td>
                <td align="left" valign=bottom><br></td>
            </tr>
            <tr>
                <td align="left" valign=bottom>
                    <font size=1><br></font>
                </td>
                <td align="left" valign=bottom>
                    <font size=1><br></font>
                </td>
                <td align="left" valign=bottom>
                    <font size=1><br></font>
                </td>
                <td align="left" valign=bottom>
                    <font size=1><br></font>
                </td>
                <td align="left" valign=bottom>
                    <font size=1><br></font>
                </td>
                <td align="left" valign=bottom>
                    <font size=1><br></font>
                </td>
                <td align="left" valign=bottom>
                    <font size=1><br></font>
                </td>
                <td align="left" valign=bottom>
                    <font size=1><br></font>
                </td>
                <td align="left" valign=bottom>
                    <font size=1><br></font>
                </td>
            </tr>
            <tr>
                <td align="left" valign=bottom>
                    <font size=1><br></font>
                </td>
                <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" colspan=2 rowspan=2 align="center" valign=middle><b>GRATUIDADE</b></td>
                <td align="left" valign=bottom>
                    <font size=1><br></font>
                </td>
                <td colspan=2 align="center" valign=middle><b>
                        <font size=1><br></font>
                    </b></td>
                <td align="left" valign=bottom><b>
                        <font size=1><br></font>
                    </b></td>
                <td colspan=2 align="center" valign=middle><b>
                        <font size=1><br></font>
                    </b></td>
            </tr>
            <tr>
                <td align="left" valign=bottom>
                    <font size=1><br></font>
                </td>
                <td align="left" valign=bottom>
                    <font size=1><br></font>
                </td>
                <td colspan=2 align="center" valign=middle>
                    <font size=1><br></font>
                </td>
                <td align="left" valign=bottom>
                    <font size=1><br></font>
                </td>
                <td colspan=2 align="center" valign=middle sdnum="1046;0;0,00%">
                    <font size=1><br></font>
                </td>
            </tr>
            <tr>
                <td height="4" align="left" valign=bottom>
                    <font size=1><br></font>
                </td>
                <td align="left" valign=bottom>
                    <font size=1><br></font>
                </td>
                <td align="left" valign=bottom>
                    <font size=1><br></font>
                </td>
                <td align="left" valign=bottom>
                    <font size=1><br></font>
                </td>
                <td align="left" valign=bottom>
                    <font size=1><br></font>
                </td>
                <td align="left" valign=bottom>
                    <font size=1><br></font>
                </td>
                <td align="left" valign=bottom>
                    <font size=1><br></font>
                </td>
                <td align="left" valign=bottom>
                    <font size=1><br></font>
                </td>
                <td align="left" valign=bottom>
                    <font size=1><br></font>
                </td>
                <td align="left" valign=bottom>
                    <font size=1><br></font>
                </td>
                <td align="left" valign=bottom>
                    <font size=1><br></font>
                </td>
                <td align="left" valign=bottom>
                    <font size=1><br></font>
                </td>
                <td align="left" valign=bottom>
                    <font size=1><br></font>
                </td>
                <td align="left" valign=bottom>
                    <font size=1><br></font>
                </td>
            </tr>
            <tr>
                <td style="border-top: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" colspan=2 height="11" align="left" valign=middle><b>
                        <font size=1>NASC.</font>
                    </b></td>
                <td align="left" valign=middle><b>
                        <font size=1><br></font>
                    </b></td>
                <td style="border-top: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" colspan=11 align="left" valign=middle><b>
                        <font size=1>ASSINATURA</font>
                    </b></td>
            </tr>
            <tr>
                <td style="border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" colspan=2 height="17" align="center" valign=middle sdval="23640" sdnum="1046;0;DD/MM/AA">
                    <font size=1>20/09/64</font>
                </td>
                <td align="center" valign=middle>
                    <font size=1><br></font>
                </td>
                <td style="border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" colspan=11 align="center" valign=middle>
                    <font size=1>ISABELE GOMES PEREIRA</font>
                </td>
            </tr>
            <tr>
                <td height="4" align="left" valign=bottom>
                    <font size=1><br></font>
                </td>
                <td align="left" valign=bottom>
                    <font size=1><br></font>
                </td>
                <td align="left" valign=bottom>
                    <font size=1><br></font>
                </td>
                <td align="left" valign=bottom>
                    <font size=1><br></font>
                </td>
                <td align="left" valign=bottom>
                    <font size=1><br></font>
                </td>
                <td align="left" valign=bottom>
                    <font size=1><br></font>
                </td>
                <td align="left" valign=bottom>
                    <font size=1><br></font>
                </td>
                <td align="left" valign=bottom>
                    <font size=1><br></font>
                </td>
                <td align="left" valign=bottom>
                    <font size=1><br></font>
                </td>
                <td align="left" valign=bottom>
                    <font size=1><br></font>
                </td>
                <td align="left" valign=bottom>
                    <font size=1><br></font>
                </td>
                <td align="left" valign=bottom>
                    <font size=1><br></font>
                </td>
                <td align="left" valign=bottom>
                    <font size=1><br></font>
                </td>
                <td align="left" valign=bottom>
                    <font size=1><br></font>
                </td>
            </tr>
            <tr>
                <td style="border-top: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" colspan=14 height="11" align="left" valign=middle><b>
                        <font size=1>A IMPORTÂNCIA TOTAL DE</font>
                    </b></td>
            </tr>
            <tr>
                <td style="border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" colspan=14 height="17" align="center" valign=middle>
                    <font size=1>ZERO REAIS</font>
                </td>
            </tr>
            <tr>
                <td height="4" align="left" valign=bottom>
                    <font size=1><br></font>
                </td>
                <td align="left" valign=bottom>
                    <font size=1><br></font>
                </td>
                <td align="left" valign=bottom>
                    <font size=1><br></font>
                </td>
                <td align="left" valign=bottom>
                    <font size=1><br></font>
                </td>
                <td align="left" valign=bottom>
                    <font size=1><br></font>
                </td>
                <td align="left" valign=bottom>
                    <font size=1><br></font>
                </td>
                <td align="left" valign=bottom>
                    <font size=1><br></font>
                </td>
                <td align="left" valign=bottom>
                    <font size=1><br></font>
                </td>
                <td align="left" valign=bottom>
                    <font size=1><br></font>
                </td>
                <td align="left" valign=bottom>
                    <font size=1><br></font>
                </td>
                <td align="left" valign=bottom>
                    <font size=1><br></font>
                </td>
                <td align="left" valign=bottom>
                    <font size=1><br></font>
                </td>
                <td align="left" valign=bottom>
                    <font size=1><br></font>
                </td>
                <td align="left" valign=bottom>
                    <font size=1><br></font>
                </td>
            </tr>
            <tr>
                <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" colspan=14 height="11" align="center" valign=middle><b>
                        <font size=1>AUTENTICAÇÃO</font>
                    </b></td>
            </tr>
            <tr>
                <td height="4" align="left" valign=bottom>
                    <font size=1><br></font>
                </td>
                <td align="left" valign=bottom>
                    <font size=1><br></font>
                </td>
                <td align="left" valign=bottom>
                    <font size=1><br></font>
                </td>
                <td align="left" valign=bottom>
                    <font size=1><br></font>
                </td>
                <td align="left" valign=bottom>
                    <font size=1><br></font>
                </td>
                <td align="left" valign=bottom>
                    <font size=1><br></font>
                </td>
                <td align="left" valign=bottom>
                    <font size=1><br></font>
                </td>
                <td align="left" valign=bottom>
                    <font size=1><br></font>
                </td>
                <td align="left" valign=bottom>
                    <font size=1><br></font>
                </td>
                <td align="left" valign=bottom>
                    <font size=1><br></font>
                </td>
                <td align="left" valign=bottom>
                    <font size=1><br></font>
                </td>
                <td align="left" valign=bottom>
                    <font size=1><br></font>
                </td>
                <td align="left" valign=bottom>
                    <font size=1><br></font>
                </td>
                <td align="left" valign=bottom>
                    <font size=1><br></font>
                </td>
            </tr>
            <tr>
                <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" colspan=14 height="26" align="center" valign=middle>
                    <font size=1>0001222163500000000180825TXPG0000000035-9</font>
                </td>
            </tr>
            <tr>
                <td height="4" align="left" valign=bottom>
                    <font size=1><br></font>
                </td>
                <td align="left" valign=bottom>
                    <font size=1><br></font>
                </td>
                <td align="left" valign=bottom>
                    <font size=1><br></font>
                </td>
                <td align="left" valign=bottom>
                    <font size=1><br></font>
                </td>
                <td align="left" valign=bottom>
                    <font size=1><br></font>
                </td>
                <td align="left" valign=bottom>
                    <font size=1><br></font>
                </td>
                <td align="left" valign=bottom>
                    <font size=1><br></font>
                </td>
                <td align="left" valign=bottom>
                    <font size=1><br></font>
                </td>
                <td align="left" valign=bottom>
                    <font size=1><br></font>
                </td>
                <td align="left" valign=bottom>
                    <font size=1><br></font>
                </td>
                <td align="left" valign=bottom>
                    <font size=1><br></font>
                </td>
                <td align="left" valign=bottom>
                    <font size=1><br></font>
                </td>
                <td align="left" valign=bottom>
                    <font size=1><br></font>
                </td>
                <td align="left" valign=bottom>
                    <font size=1><br></font>
                </td>
            </tr>
            <tr>
                <td colspan=14 height="26" align="center" valign=middle>
                    <font size=1>------------------------------------------------------------------------------------------------------------------------------------------------------------------</font>
                </td>
            </tr>
            <tr>
                <td rowspan=5 height="66" align="left" valign=bottom>
                    <font size=1><br><img src="Recibo1(TX.%20PRODU%C3%87%C3%83O%20-%20GRATUIDADE)_html_89d7323401fb32ff.png" width=54 height=53 hspace=2 vspace=8>
                    </font>
                </td>
                <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" colspan=4 rowspan=2 align="center" valign=middle><b>
                        <font size=5>TX. PRODUÇÃO</font>
                    </b></td>
                <td align="left" valign=bottom><br></td>
                <td style="border-top: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" colspan=2 align="center" valign=middle><b>
                        <font size=1>RECIBO</font>
                    </b></td>
                <td align="left" valign=bottom>
                    <font size=1><br></font>
                </td>
                <td style="border-top: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" colspan=2 align="center" valign=middle><b>
                        <font size=1>PC</font>
                    </b></td>
                <td align="center" valign=middle>
                    <font size=1><br></font>
                </td>
                <td style="border-top: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" colspan=2 align="center" valign=middle><b>
                        <font size=1>VALOR PAGO</font>
                    </b></td>
            </tr>
            <tr>
                <td align="left" valign=bottom><br></td>
                <td style="border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" colspan=2 align="center" valign=middle sdnum="1046;0;@">
                    <font size=1>22000001</font>
                </td>
                <td align="left" valign=bottom>
                    <font size=1><br></font>
                </td>
                <td style="border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" colspan=2 align="center" valign=middle sdval="222" sdnum="1046;">
                    <font size=1>222</font>
                </td>
                <td align="left" valign=bottom>
                    <font size=1><br></font>
                </td>
                <td style="border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" colspan=2 align="center" valign=middle sdval="0" sdnum="1046;0;[$R$-416] #.##0,00;[RED]-[$R$-416] #.##0,00">
                    <font size=1>R$ 0,00</font>
                </td>
            </tr>
            <tr>
                <td align="left" valign=bottom>
                    <font size=1><br></font>
                </td>
                <td align="left" valign=bottom>
                    <font size=1><br></font>
                </td>
                <td align="left" valign=bottom>
                    <font size=1><br></font>
                </td>
                <td align="left" valign=bottom>
                    <font size=1><br></font>
                </td>
                <td align="left" valign=bottom>
                    <font size=1><br></font>
                </td>
                <td align="left" valign=bottom>
                    <font size=1><br></font>
                </td>
                <td align="left" valign=bottom>
                    <font size=1><br></font>
                </td>
                <td align="left" valign=bottom>
                    <font size=1><br></font>
                </td>
                <td align="left" valign=bottom>
                    <font size=1><br></font>
                </td>
                <td align="left" valign=bottom>
                    <font size=1><br></font>
                </td>
                <td align="left" valign=bottom>
                    <font size=1><br></font>
                </td>
                <td align="left" valign=bottom>
                    <font size=1><br></font>
                </td>
                <td align="left" valign=bottom>
                    <font size=1><br></font>
                </td>
            </tr>
            <tr>
                <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" colspan=5 rowspan=5 height="60" align="center" valign=middle>
                    <font size=1><br><img src="Recibo1(TX.%20PRODU%C3%87%C3%83O%20-%20GRATUIDADE)_html_8aa753e3a89a9d2a.png" width=284 height=55 hspace=10 vspace=5>
                    </font>
                </td>
                <td align="left" valign=bottom>
                    <font size=1><br></font>
                </td>
                <td style="border-top: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" colspan=2 align="center" valign=middle><b>
                        <font size=1>DATA</font>
                    </b></td>
                <td align="left" valign=bottom>
                    <font size=1><br></font>
                </td>
                <td style="border-top: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" colspan=2 align="center" valign=middle><b>
                        <font size=1>VENDEDORA</font>
                    </b></td>
                <td align="left" valign=bottom>
                    <font size=1><br></font>
                </td>
                <td align="left" valign=bottom><br></td>
                <td align="left" valign=bottom><br></td>
            </tr>
            <tr>
                <td align="left" valign=bottom>
                    <font size=1><br></font>
                </td>
                <td style="border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" colspan=2 align="center" valign=middle sdval="45898" sdnum="1046;0;DD/MM/AA">
                    <font size=1>29/08/25</font>
                </td>
                <td align="left" valign=bottom>
                    <font size=1><br></font>
                </td>
                <td style="border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" colspan=2 align="center" valign=middle>
                    <font size=1>Rafaella B.</font>
                </td>
                <td align="left" valign=bottom>
                    <font size=1><br></font>
                </td>
                <td align="left" valign=bottom><br></td>
                <td align="left" valign=bottom><br></td>
            </tr>
            <tr>
                <td align="left" valign=bottom>
                    <font size=1><br></font>
                </td>
                <td align="left" valign=bottom>
                    <font size=1><br></font>
                </td>
                <td align="left" valign=bottom>
                    <font size=1><br></font>
                </td>
                <td align="left" valign=bottom>
                    <font size=1><br></font>
                </td>
                <td align="left" valign=bottom>
                    <font size=1><br></font>
                </td>
                <td align="left" valign=bottom>
                    <font size=1><br></font>
                </td>
                <td align="left" valign=bottom>
                    <font size=1><br></font>
                </td>
                <td align="left" valign=bottom>
                    <font size=1><br></font>
                </td>
                <td align="left" valign=bottom>
                    <font size=1><br></font>
                </td>
            </tr>
            <tr>
                <td align="left" valign=bottom>
                    <font size=1><br></font>
                </td>
                <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" colspan=2 rowspan=2 align="center" valign=middle><b>GRATUIDADE</b></td>
                <td align="left" valign=bottom>
                    <font size=1><br></font>
                </td>
                <td colspan=2 align="center" valign=middle><b>
                        <font size=1><br></font>
                    </b></td>
                <td align="left" valign=bottom><b>
                        <font size=1><br></font>
                    </b></td>
                <td colspan=2 align="center" valign=middle><b>
                        <font size=1><br></font>
                    </b></td>
            </tr>
            <tr>
                <td align="left" valign=bottom>
                    <font size=1><br></font>
                </td>
                <td align="left" valign=bottom>
                    <font size=1><br></font>
                </td>
                <td colspan=2 align="center" valign=middle>
                    <font size=1><br></font>
                </td>
                <td align="left" valign=bottom>
                    <font size=1><br></font>
                </td>
                <td colspan=2 align="center" valign=middle sdnum="1046;0;0,00%">
                    <font size=1><br></font>
                </td>
            </tr>
            <tr>
                <td height="4" align="left" valign=bottom>
                    <font size=1><br></font>
                </td>
                <td align="left" valign=bottom>
                    <font size=1><br></font>
                </td>
                <td align="left" valign=bottom>
                    <font size=1><br></font>
                </td>
                <td align="left" valign=bottom>
                    <font size=1><br></font>
                </td>
                <td align="left" valign=bottom>
                    <font size=1><br></font>
                </td>
                <td align="left" valign=bottom>
                    <font size=1><br></font>
                </td>
                <td align="left" valign=bottom>
                    <font size=1><br></font>
                </td>
                <td align="left" valign=bottom>
                    <font size=1><br></font>
                </td>
                <td align="left" valign=bottom>
                    <font size=1><br></font>
                </td>
                <td align="left" valign=bottom>
                    <font size=1><br></font>
                </td>
                <td align="left" valign=bottom>
                    <font size=1><br></font>
                </td>
                <td align="left" valign=bottom>
                    <font size=1><br></font>
                </td>
                <td align="left" valign=bottom>
                    <font size=1><br></font>
                </td>
                <td align="left" valign=bottom>
                    <font size=1><br></font>
                </td>
            </tr>
            <tr>
                <td style="border-top: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" colspan=2 height="11" align="left" valign=middle><b>
                        <font size=1>NASC.</font>
                    </b></td>
                <td align="left" valign=middle><b>
                        <font size=1><br></font>
                    </b></td>
                <td style="border-top: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" colspan=11 align="left" valign=middle><b>
                        <font size=1>ASSINATURA</font>
                    </b></td>
            </tr>
            <tr>
                <td style="border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" colspan=2 height="17" align="center" valign=middle sdval="23640" sdnum="1046;0;DD/MM/AA">
                    <font size=1>20/09/64</font>
                </td>
                <td align="center" valign=middle>
                    <font size=1><br></font>
                </td>
                <td style="border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" colspan=11 align="center" valign=middle>
                    <font size=1>ISABELE GOMES PEREIRA</font>
                </td>
            </tr>
            <tr>
                <td height="4" align="left" valign=bottom>
                    <font size=1><br></font>
                </td>
                <td align="left" valign=bottom>
                    <font size=1><br></font>
                </td>
                <td align="left" valign=bottom>
                    <font size=1><br></font>
                </td>
                <td align="left" valign=bottom>
                    <font size=1><br></font>
                </td>
                <td align="left" valign=bottom>
                    <font size=1><br></font>
                </td>
                <td align="left" valign=bottom>
                    <font size=1><br></font>
                </td>
                <td align="left" valign=bottom>
                    <font size=1><br></font>
                </td>
                <td align="left" valign=bottom>
                    <font size=1><br></font>
                </td>
                <td align="left" valign=bottom>
                    <font size=1><br></font>
                </td>
                <td align="left" valign=bottom>
                    <font size=1><br></font>
                </td>
                <td align="left" valign=bottom>
                    <font size=1><br></font>
                </td>
                <td align="left" valign=bottom>
                    <font size=1><br></font>
                </td>
                <td align="left" valign=bottom>
                    <font size=1><br></font>
                </td>
                <td align="left" valign=bottom>
                    <font size=1><br></font>
                </td>
            </tr>
            <tr>
                <td style="border-top: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" colspan=14 height="11" align="left" valign=middle><b>
                        <font size=1>A IMPORTÂNCIA TOTAL DE</font>
                    </b></td>
            </tr>
            <tr>
                <td style="border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" colspan=14 height="17" align="center" valign=middle>
                    <font size=1>ZERO REAIS</font>
                </td>
            </tr>
            <tr>
                <td height="4" align="left" valign=bottom>
                    <font size=1><br></font>
                </td>
                <td align="left" valign=bottom>
                    <font size=1><br></font>
                </td>
                <td align="left" valign=bottom>
                    <font size=1><br></font>
                </td>
                <td align="left" valign=bottom>
                    <font size=1><br></font>
                </td>
                <td align="left" valign=bottom>
                    <font size=1><br></font>
                </td>
                <td align="left" valign=bottom>
                    <font size=1><br></font>
                </td>
                <td align="left" valign=bottom>
                    <font size=1><br></font>
                </td>
                <td align="left" valign=bottom>
                    <font size=1><br></font>
                </td>
                <td align="left" valign=bottom>
                    <font size=1><br></font>
                </td>
                <td align="left" valign=bottom>
                    <font size=1><br></font>
                </td>
                <td align="left" valign=bottom>
                    <font size=1><br></font>
                </td>
                <td align="left" valign=bottom>
                    <font size=1><br></font>
                </td>
                <td align="left" valign=bottom>
                    <font size=1><br></font>
                </td>
                <td align="left" valign=bottom>
                    <font size=1><br></font>
                </td>
            </tr>
            <tr>
                <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" colspan=14 height="11" align="center" valign=middle><b>
                        <font size=1>AUTENTICAÇÃO</font>
                    </b></td>
            </tr>
            <tr>
                <td height="4" align="left" valign=bottom>
                    <font size=1><br></font>
                </td>
                <td align="left" valign=bottom>
                    <font size=1><br></font>
                </td>
                <td align="left" valign=bottom>
                    <font size=1><br></font>
                </td>
                <td align="left" valign=bottom>
                    <font size=1><br></font>
                </td>
                <td align="left" valign=bottom>
                    <font size=1><br></font>
                </td>
                <td align="left" valign=bottom>
                    <font size=1><br></font>
                </td>
                <td align="left" valign=bottom>
                    <font size=1><br></font>
                </td>
                <td align="left" valign=bottom>
                    <font size=1><br></font>
                </td>
                <td align="left" valign=bottom>
                    <font size=1><br></font>
                </td>
                <td align="left" valign=bottom>
                    <font size=1><br></font>
                </td>
                <td align="left" valign=bottom>
                    <font size=1><br></font>
                </td>
                <td align="left" valign=bottom>
                    <font size=1><br></font>
                </td>
                <td align="left" valign=bottom>
                    <font size=1><br></font>
                </td>
                <td align="left" valign=bottom>
                    <font size=1><br></font>
                </td>
            </tr>
            <tr>
                <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" colspan=14 height="26" align="center" valign=middle>
                    <font size=1>0001222163500000000180825TXPG0000000035-9</font>
                </td>
            </tr>
            <tr>
                <td height="4" align="left" valign=bottom>
                    <font size=1><br></font>
                </td>
                <td align="left" valign=bottom>
                    <font size=1><br></font>
                </td>
                <td align="left" valign=bottom>
                    <font size=1><br></font>
                </td>
                <td align="left" valign=bottom>
                    <font size=1><br></font>
                </td>
                <td align="left" valign=bottom>
                    <font size=1><br></font>
                </td>
                <td align="left" valign=bottom>
                    <font size=1><br></font>
                </td>
                <td align="left" valign=bottom>
                    <font size=1><br></font>
                </td>
                <td align="left" valign=bottom>
                    <font size=1><br></font>
                </td>
                <td align="left" valign=bottom>
                    <font size=1><br></font>
                </td>
                <td align="left" valign=bottom>
                    <font size=1><br></font>
                </td>
                <td align="left" valign=bottom>
                    <font size=1><br></font>
                </td>
                <td align="left" valign=bottom>
                    <font size=1><br></font>
                </td>
                <td align="left" valign=bottom>
                    <font size=1><br></font>
                </td>
                <td align="left" valign=bottom>
                    <font size=1><br></font>
                </td>
            </tr>
            <tr>
                <td colspan=14 height="26" align="center" valign=middle>
                    <font size=1>------------------------------------------------------------------------------------------------------------------------------------------------------------------</font>
                </td>
            </tr>
            <tr>
                <td rowspan=5 height="66" align="left" valign=bottom>
                    <font size=1><br><img src="Recibo1(TX.%20PRODU%C3%87%C3%83O%20-%20GRATUIDADE)_html_89d7323401fb32ff.png" width=54 height=53 hspace=2 vspace=8>
                    </font>
                </td>
                <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" colspan=4 rowspan=2 align="center" valign=middle><b>
                        <font size=5>TX. PRODUÇÃO</font>
                    </b></td>
                <td align="left" valign=bottom><br></td>
                <td style="border-top: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" colspan=2 align="center" valign=middle><b>
                        <font size=1>RECIBO</font>
                    </b></td>
                <td align="left" valign=bottom>
                    <font size=1><br></font>
                </td>
                <td style="border-top: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" colspan=2 align="center" valign=middle><b>
                        <font size=1>PC</font>
                    </b></td>
                <td align="center" valign=middle>
                    <font size=1><br></font>
                </td>
                <td style="border-top: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" colspan=2 align="center" valign=middle><b>
                        <font size=1>VALOR PAGO</font>
                    </b></td>
            </tr>
            <tr>
                <td align="left" valign=bottom><br></td>
                <td style="border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" colspan=2 align="center" valign=middle sdnum="1046;0;@">
                    <font size=1>22000001</font>
                </td>
                <td align="left" valign=bottom>
                    <font size=1><br></font>
                </td>
                <td style="border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" colspan=2 align="center" valign=middle sdval="222" sdnum="1046;">
                    <font size=1>222</font>
                </td>
                <td align="left" valign=bottom>
                    <font size=1><br></font>
                </td>
                <td style="border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" colspan=2 align="center" valign=middle sdval="0" sdnum="1046;0;[$R$-416] #.##0,00;[RED]-[$R$-416] #.##0,00">
                    <font size=1>R$ 0,00</font>
                </td>
            </tr>
            <tr>
                <td align="left" valign=bottom>
                    <font size=1><br></font>
                </td>
                <td align="left" valign=bottom>
                    <font size=1><br></font>
                </td>
                <td align="left" valign=bottom>
                    <font size=1><br></font>
                </td>
                <td align="left" valign=bottom>
                    <font size=1><br></font>
                </td>
                <td align="left" valign=bottom>
                    <font size=1><br></font>
                </td>
                <td align="left" valign=bottom>
                    <font size=1><br></font>
                </td>
                <td align="left" valign=bottom>
                    <font size=1><br></font>
                </td>
                <td align="left" valign=bottom>
                    <font size=1><br></font>
                </td>
                <td align="left" valign=bottom>
                    <font size=1><br></font>
                </td>
                <td align="left" valign=bottom>
                    <font size=1><br></font>
                </td>
                <td align="left" valign=bottom>
                    <font size=1><br></font>
                </td>
                <td align="left" valign=bottom>
                    <font size=1><br></font>
                </td>
                <td align="left" valign=bottom>
                    <font size=1><br></font>
                </td>
            </tr>
            <tr>
                <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" colspan=5 rowspan=5 height="60" align="center" valign=middle>
                    <font size=1><br><img src="Recibo1(TX.%20PRODU%C3%87%C3%83O%20-%20GRATUIDADE)_html_8aa753e3a89a9d2a.png" width=284 height=55 hspace=10 vspace=5>
                    </font>
                </td>
                <td align="left" valign=bottom>
                    <font size=1><br></font>
                </td>
                <td style="border-top: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" colspan=2 align="center" valign=middle><b>
                        <font size=1>DATA</font>
                    </b></td>
                <td align="left" valign=bottom>
                    <font size=1><br></font>
                </td>
                <td style="border-top: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" colspan=2 align="center" valign=middle><b>
                        <font size=1>VENDEDORA</font>
                    </b></td>
                <td align="left" valign=bottom>
                    <font size=1><br></font>
                </td>
                <td align="left" valign=bottom><br></td>
                <td align="left" valign=bottom><br></td>
            </tr>
            <tr>
                <td align="left" valign=bottom>
                    <font size=1><br></font>
                </td>
                <td style="border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" colspan=2 align="center" valign=middle sdval="45898" sdnum="1046;0;DD/MM/AA">
                    <font size=1>29/08/25</font>
                </td>
                <td align="left" valign=bottom>
                    <font size=1><br></font>
                </td>
                <td style="border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" colspan=2 align="center" valign=middle>
                    <font size=1>Rafaella B.</font>
                </td>
                <td align="left" valign=bottom>
                    <font size=1><br></font>
                </td>
                <td align="left" valign=bottom><br></td>
                <td align="left" valign=bottom><br></td>
            </tr>
            <tr>
                <td align="left" valign=bottom>
                    <font size=1><br></font>
                </td>
                <td align="left" valign=bottom>
                    <font size=1><br></font>
                </td>
                <td align="left" valign=bottom>
                    <font size=1><br></font>
                </td>
                <td align="left" valign=bottom>
                    <font size=1><br></font>
                </td>
                <td align="left" valign=bottom>
                    <font size=1><br></font>
                </td>
                <td align="left" valign=bottom>
                    <font size=1><br></font>
                </td>
                <td align="left" valign=bottom>
                    <font size=1><br></font>
                </td>
                <td align="left" valign=bottom>
                    <font size=1><br></font>
                </td>
                <td align="left" valign=bottom>
                    <font size=1><br></font>
                </td>
            </tr>
            <tr>
                <td align="left" valign=bottom>
                    <font size=1><br></font>
                </td>
                <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" colspan=2 rowspan=2 align="center" valign=middle><b>GRATUIDADE</b></td>
                <td align="left" valign=bottom>
                    <font size=1><br></font>
                </td>
                <td colspan=2 align="center" valign=middle><b>
                        <font size=1><br></font>
                    </b></td>
                <td align="left" valign=bottom><b>
                        <font size=1><br></font>
                    </b></td>
                <td colspan=2 align="center" valign=middle><b>
                        <font size=1><br></font>
                    </b></td>
            </tr>
            <tr>
                <td align="left" valign=bottom>
                    <font size=1><br></font>
                </td>
                <td align="left" valign=bottom>
                    <font size=1><br></font>
                </td>
                <td colspan=2 align="center" valign=middle>
                    <font size=1><br></font>
                </td>
                <td align="left" valign=bottom>
                    <font size=1><br></font>
                </td>
                <td colspan=2 align="center" valign=middle sdnum="1046;0;0,00%">
                    <font size=1><br></font>
                </td>
            </tr>
            <tr>
                <td height="4" align="left" valign=bottom>
                    <font size=1><br></font>
                </td>
                <td align="left" valign=bottom>
                    <font size=1><br></font>
                </td>
                <td align="left" valign=bottom>
                    <font size=1><br></font>
                </td>
                <td align="left" valign=bottom>
                    <font size=1><br></font>
                </td>
                <td align="left" valign=bottom>
                    <font size=1><br></font>
                </td>
                <td align="left" valign=bottom>
                    <font size=1><br></font>
                </td>
                <td align="left" valign=bottom>
                    <font size=1><br></font>
                </td>
                <td align="left" valign=bottom>
                    <font size=1><br></font>
                </td>
                <td align="left" valign=bottom>
                    <font size=1><br></font>
                </td>
                <td align="left" valign=bottom>
                    <font size=1><br></font>
                </td>
                <td align="left" valign=bottom>
                    <font size=1><br></font>
                </td>
                <td align="left" valign=bottom>
                    <font size=1><br></font>
                </td>
                <td align="left" valign=bottom>
                    <font size=1><br></font>
                </td>
                <td align="left" valign=bottom>
                    <font size=1><br></font>
                </td>
            </tr>
            <tr>
                <td style="border-top: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" colspan=2 height="11" align="left" valign=middle><b>
                        <font size=1>NASC.</font>
                    </b></td>
                <td align="left" valign=middle><b>
                        <font size=1><br></font>
                    </b></td>
                <td style="border-top: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" colspan=11 align="left" valign=middle><b>
                        <font size=1>ASSINATURA</font>
                    </b></td>
            </tr>
            <tr>
                <td style="border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" colspan=2 height="17" align="center" valign=middle sdval="23640" sdnum="1046;0;DD/MM/AA">
                    <font size=1>20/09/64</font>
                </td>
                <td align="center" valign=middle>
                    <font size=1><br></font>
                </td>
                <td style="border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" colspan=11 align="center" valign=middle>
                    <font size=1>ISABELE GOMES PEREIRA</font>
                </td>
            </tr>
            <tr>
                <td height="4" align="left" valign=bottom>
                    <font size=1><br></font>
                </td>
                <td align="left" valign=bottom>
                    <font size=1><br></font>
                </td>
                <td align="left" valign=bottom>
                    <font size=1><br></font>
                </td>
                <td align="left" valign=bottom>
                    <font size=1><br></font>
                </td>
                <td align="left" valign=bottom>
                    <font size=1><br></font>
                </td>
                <td align="left" valign=bottom>
                    <font size=1><br></font>
                </td>
                <td align="left" valign=bottom>
                    <font size=1><br></font>
                </td>
                <td align="left" valign=bottom>
                    <font size=1><br></font>
                </td>
                <td align="left" valign=bottom>
                    <font size=1><br></font>
                </td>
                <td align="left" valign=bottom>
                    <font size=1><br></font>
                </td>
                <td align="left" valign=bottom>
                    <font size=1><br></font>
                </td>
                <td align="left" valign=bottom>
                    <font size=1><br></font>
                </td>
                <td align="left" valign=bottom>
                    <font size=1><br></font>
                </td>
                <td align="left" valign=bottom>
                    <font size=1><br></font>
                </td>
            </tr>
            <tr>
                <td style="border-top: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" colspan=14 height="11" align="left" valign=middle><b>
                        <font size=1>A IMPORTÂNCIA TOTAL DE</font>
                    </b></td>
            </tr>
            <tr>
                <td style="border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" colspan=14 height="17" align="center" valign=middle>
                    <font size=1>ZERO REAIS</font>
                </td>
            </tr>
            <tr>
                <td height="4" align="left" valign=bottom>
                    <font size=1><br></font>
                </td>
                <td align="left" valign=bottom>
                    <font size=1><br></font>
                </td>
                <td align="left" valign=bottom>
                    <font size=1><br></font>
                </td>
                <td align="left" valign=bottom>
                    <font size=1><br></font>
                </td>
                <td align="left" valign=bottom>
                    <font size=1><br></font>
                </td>
                <td align="left" valign=bottom>
                    <font size=1><br></font>
                </td>
                <td align="left" valign=bottom>
                    <font size=1><br></font>
                </td>
                <td align="left" valign=bottom>
                    <font size=1><br></font>
                </td>
                <td align="left" valign=bottom>
                    <font size=1><br></font>
                </td>
                <td align="left" valign=bottom>
                    <font size=1><br></font>
                </td>
                <td align="left" valign=bottom>
                    <font size=1><br></font>
                </td>
                <td align="left" valign=bottom>
                    <font size=1><br></font>
                </td>
                <td align="left" valign=bottom>
                    <font size=1><br></font>
                </td>
                <td align="left" valign=bottom>
                    <font size=1><br></font>
                </td>
            </tr>
            <tr>
                <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" colspan=14 height="11" align="center" valign=middle><b>
                        <font size=1>AUTENTICAÇÃO</font>
                    </b></td>
            </tr>
            <tr>
                <td height="4" align="left" valign=bottom>
                    <font size=1><br></font>
                </td>
                <td align="left" valign=bottom>
                    <font size=1><br></font>
                </td>
                <td align="left" valign=bottom>
                    <font size=1><br></font>
                </td>
                <td align="left" valign=bottom>
                    <font size=1><br></font>
                </td>
                <td align="left" valign=bottom>
                    <font size=1><br></font>
                </td>
                <td align="left" valign=bottom>
                    <font size=1><br></font>
                </td>
                <td align="left" valign=bottom>
                    <font size=1><br></font>
                </td>
                <td align="left" valign=bottom>
                    <font size=1><br></font>
                </td>
                <td align="left" valign=bottom>
                    <font size=1><br></font>
                </td>
                <td align="left" valign=bottom>
                    <font size=1><br></font>
                </td>
                <td align="left" valign=bottom>
                    <font size=1><br></font>
                </td>
                <td align="left" valign=bottom>
                    <font size=1><br></font>
                </td>
                <td align="left" valign=bottom>
                    <font size=1><br></font>
                </td>
                <td align="left" valign=bottom>
                    <font size=1><br></font>
                </td>
            </tr>
            <tr>
                <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" colspan=14 height="26" align="center" valign=middle>
                    <font size=1>0001222163500000000180825TXPG0000000035-9</font>
                </td>
            </tr>
            <tr>
                <td height="4" align="left" valign=bottom>
                    <font size=1><br></font>
                </td>
                <td align="left" valign=bottom>
                    <font size=1><br></font>
                </td>
                <td align="left" valign=bottom>
                    <font size=1><br></font>
                </td>
                <td align="left" valign=bottom>
                    <font size=1><br></font>
                </td>
                <td align="left" valign=bottom>
                    <font size=1><br></font>
                </td>
                <td align="left" valign=bottom>
                    <font size=1><br></font>
                </td>
                <td align="left" valign=bottom>
                    <font size=1><br></font>
                </td>
                <td align="left" valign=bottom>
                    <font size=1><br></font>
                </td>
                <td align="left" valign=bottom>
                    <font size=1><br></font>
                </td>
                <td align="left" valign=bottom>
                    <font size=1><br></font>
                </td>
                <td align="left" valign=bottom>
                    <font size=1><br></font>
                </td>
                <td align="left" valign=bottom>
                    <font size=1><br></font>
                </td>
                <td align="left" valign=bottom>
                    <font size=1><br></font>
                </td>
                <td align="left" valign=bottom>
                    <font size=1><br></font>
                </td>
            </tr>
            <tr>
                <td colspan=14 height="26" align="center" valign=middle>
                    <font size=1>------------------------------------------------------------------------------------------------------------------------------------------------------------------</font>
                </td>
            </tr>
        </table>
        <br clear=left>
        <!-- ************************************************************************** -->
</body>

</html>