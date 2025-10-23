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
$FmRec     = $_GET['fmrec'];
$txt1      = $_GET['txt1'];
$txt2      = $_GET['txt2'];
$txt3      = $_GET['txt3'];
$VrPag    = $_GET['TaxaConc'];
$VrPagF   = number_format($VrPag, 2, ",", ".");
$VrPagA = number_format($VrPag, 2, "", "");

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

?>

<!DOCTYPE html>

<html>

<head>

    <meta http-equiv="content-type" content="text/html; charset=utf-8" />
    <title>Recibo - <?php echo $Cliente . " - " . $tipo; ?></title>
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
            top: 118px;
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
            top: 422px;
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
<body>
<!--<body onload="window.print()">-->
    <div class="container">
        <img src="./images/logo.png" alt="Imagem" class="imagem_via1">
        <img src="./images/logo.png" alt="Imagem" class="imagem_via2">
        <img src="./images/logo.png" alt="Imagem" class="imagem_via3">
        <!--<img src="./images/logo.png" alt="Imagem" class="imagem_via4">-->
        <table align="left" cellspacing="0" border="0">
            <colgroup width="100"></colgroup>
            <colgroup span="2" width="100"></colgroup>
            <colgroup width="100"></colgroup>
            <colgroup width="8"></colgroup>
            <colgroup span="2" width="100"></colgroup>
            <colgroup width="8"></colgroup>
            <colgroup span="2" width="100"></colgroup>
            <colgroup width="8"></colgroup>
            <colgroup span="2" width="100"></colgroup>

            <!-- Primeira via -->
            <tr>
                <td height="17" align="left" valign=bottom><br></td>
                <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000"
                    colspan=3 rowspan=2 align="center" valign=middle>
                    <b>
                        <font size=4><?php echo $tipo; ?></font>
                    </b>
                </td>
                <td align="left" valign=bottom><br></td>
                <td style="border-top: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000"
                    colspan=2 align="center" valign=middle>
                    <b>
                        <font size=1>RECIBO</font>
                    </b>
                </td>
                <td align="left" valign=bottom>
                    <font size=1><br></font>
                </td>
                <td style="border-top: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000"
                    colspan=2 align="center" valign=middle>
                    <b>
                        <font size=1>PC</font>
                    </b>
                </td>
                <td align="center" valign=middle>
                    <font size=1><br></font>
                </td>
                <td style="border-top: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000"
                    colspan=2 align="center" valign=middle>
                    <b>
                        <font size=1>VALOR PAGO</font>
                    </b>
                </td>
            </tr>
            <tr>
                <td height="5" align="left" valign=bottom>
                    <font size=1><br></font>
                </td>
                <td align="left" valign=bottom><br></td>
                <td style="border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000"
                    colspan=2 align="center" valign=middle>
                    <font size=1><?php echo $NDoc; ?></font>
                </td>
                <td align="left" valign=bottom>
                    <font size=1><br></font>
                </td>
                <td style="border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000"
                    colspan=2 align="center" valign=middle>
                    <font size=1><?php echo $PC; ?></font>
                </td>
                <td align="left" valign=bottom>
                    <font size=1><br></font>
                </td>
                <td style="border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000"
                    colspan=2 align="center" valign=middle>
                    <font size=1><?php echo "R$ " . $VrPagF; ?></font>
                </td>
            </tr>
            <tr>
                <td height="4" align="left" valign=bottom></td>
            <tr>
                <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000"
                    colspan=4 rowspan=5 height="60" align="center" valign=middle>
                    <font size=1><img src="./images/endereco_pc<?php echo $PC; ?>.png" class="imagem_end_1">
                    </font>
                </td>
                <td align="left" valign=bottom>
                    <font size=1><br></font>
                </td>
                <td style="border-top: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000"
                    colspan=2 align="center" valign=middle><b>
                        <font size=1>DATA</font>
                    </b></td>
                <td align="left" valign=bottom>
                    <font size=1><br></font>
                </td>
                <td style="border-top: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000"
                    colspan=2 align="center" valign=middle><b>
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
                <td style="border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" colspan=2 align="center" valign=middle sdval="45793" sdnum="1046;0;DD/MM/AA">
                    <font size=1><?php echo $data; ?></font>
                </td>
                <td align="left" valign=bottom>
                    <font size=1><br></font>
                </td>
                <td style="border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" colspan=2 align="center" valign=middle>
                    <font size=1><?php echo $Vendedora; ?></font>
                </td>
            </tr>
            <tr>
                <td height="4" align="left" valign=bottom></td>
            </tr>
            <tr>
                <td align="left" valign=bottom>
                    <font size=1><br></font>
                </td>
                <?php

                // Conexão
                include "./conexao.php";
                include "./dbselect.php";

                // Forma de pagamento 1 - verifica se não está vazio e pega o primeiro valor e diferente de 00
                if (!empty($FPags[0]) && $FPags[0] !== "00") {
                    $FPag = $FPags[0];

                    // Nome  na forma de pagamento por extenso
                    if ($FPag == 10) {
                        $ModPag = "DINHEIRO";
                    } elseif ($FPag == 20) {
                        $ModPag = "CARTÃO DÉBITO";
                    } elseif ($FPag == 30) {
                        $ModPag = "CARTÃO CRÉDITO";
                    } elseif ($FPag == 70) {
                        $ModPag = "PIX QR CODE";
                    } elseif ($FPag == 71) {
                        $ModPag = "PIX CNPJ";
                    } elseif ($FPag == 99) {
                        $ModPag = "GRATUIDADE";
                    }

                ?>
                    <td style="border-top: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" colspan=2 align="center" valign=middle><b>
                            <font size=1><?php echo $ModPag; ?></font>
                        </b></td>
                    <td align="left" valign=bottom>
                        <font size=1><br></font>
                    </td>
                <?php
                }

                // Forma de pagamento 2
                if (!empty($FPags[1]) && $FPags[1] !== "00") {
                    $FPag = $FPags[1];

                    // Nome  na forma de pagamento por extenso
                    if ($FPag == 10) {
                        $ModPag = "DINHEIRO";
                    } elseif ($FPag == 20) {
                        $ModPag = "CARTÃO DÉBITO";
                    } elseif ($FPag == 30) {
                        $ModPag = "CARTÃO CRÉDITO";
                    } elseif ($FPag == 70) {
                        $ModPag = "PIX QR CODE";
                    } elseif ($FPag == 71) {
                        $ModPag = "PIX CNPJ";
                    }

                ?>
                    <td style="border-top: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" colspan=2 align="center" valign=middle><b>
                            <font size=1><?php echo $ModPag; ?></font>
                        </b></td>
                    <td align="left" valign=bottom>
                        <font size=1><br></font>
                    </td>
                <?php
                }

                // Forma de pagamento 3
                if (!empty($FPags[2]) && $FPags[2] !== "00") {
                    $FPag = $FPags[2];

                    // Nome  na forma de pagamento por extenso
                    if ($FPag == 10) {
                        $ModPag = "DINHEIRO";
                    } elseif ($FPag == 20) {
                        $ModPag = "CARTÃO DÉBITO";
                    } elseif ($FPag == 30) {
                        $ModPag = "CARTÃO CRÉDITO";
                    } elseif ($FPag == 70) {
                        $ModPag = "PIX QR CODE";
                    } elseif ($FPag == 71) {
                        $ModPag = "PIX CNPJ";
                    }

                ?>
                    <td style="border-top: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" colspan=2 align="center" valign=middle><b>
                            <font size=1><?php echo $ModPag; ?></font>
                        </b></td>
                    <td align="left" valign=bottom>
                        <font size=1><br></font>
                    </td>
                <?php
                }
                ?>
            </tr>
            <tr>
                <td align="left" valign=bottom>
                    <font size=1><br></font>
                </td>

                <?php
                // Valor 1
                if (!empty($FPags[0]) && $FPags[0] !== "00") {
                    $Vlr = $Vlrs[0];
                    $VlrF = number_format($Vlr, 2, ',', '.');
                ?>
                    <td style="border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" colspan=2 align="center" valign=middle sdval="500" sdnum="1046;0;[$R$-416] #.##0,00;[RED]-[$R$-416] #.##0,00">
                        <font size=1><?php echo "R$ " .  $VlrF; ?></font>
                    </td>
                    <td align="left" valign=bottom>
                        <font size=1><br></font>
                    </td>
                <?php
                }

                // Valor 2
                if (!empty($FPags[1]) && $FPags[1] !== "00") {
                    $Vlr = $Vlrs[1];
                    $VlrF = number_format($Vlr, 2, ',', '.');
                ?>
                    <td style="border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" colspan=2 align="center" valign=middle sdval="1000" sdnum="1046;0;[$R$-416] #.##0,00;[RED]-[$R$-416] #.##0,00">
                        <font size=1><?php echo "R$ " .  $VlrF; ?></font>
                    </td>
                    <td align="left" valign=bottom>
                        <font size=1><br></font>
                    </td>
                <?php
                }

                // Valor 3
                if (!empty($FPags[2]) && $FPags[2] !== "00") {
                    $Vlr = $Vlrs[2];
                    $VlrF = number_format($Vlr, 2, ',', '.');
                ?>
                    <td style="border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" colspan=2 align="center" valign=middle sdval="0" sdnum="1046;0;[$R$-416] #.##0,00;[RED]-[$R$-416] #.##0,00">
                        <font size=1 color="#000000"><?php echo "R$ " .  $VlrF; ?></font>
                    </td>
                <?php
                }
                ?>
            </tr>
            <tr>
                <td height="4" align="left" valign=bottom></td>
            </tr>
            <tr>
                <td style="border-top: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000"
                    colspan=13 height="15" align="left" valign=middle><b>
                        <font size=1>RECEBEMOS</font>
                    </b></td>
            </tr>
            <tr>
                <td style="border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000"
                    colspan=13 height="17" align="center" valign=middle>
                    <font size=1><?php echo $Cliente; ?></font>
                </td>
            </tr>
            <tr>
                <td height="4" align="left" valign=bottom>
                    <font size=1></font>
                </td>
            </tr>
            <tr>
                <td style="border-top: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000"
                    colspan=13 height="15" align="left" valign=middle><b>
                        <font size=1>A IMPORTÂNCIA TOTAL DE</font>
                    </b></td>
            </tr>
            <tr>
                <td style="border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000"
                    colspan=13 height="17" align="center" valign=middle>
                    <font size=1><?php echo $vlr_ext; ?></font>
                </td>
            </tr>
            <tr>
                <td height="4" align="left" valign=bottom>
                    <font size=1></font>
                </td>
            </tr>
            <tr>
                <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" colspan=13 height="15" align="center" valign=middle><b>
                        <font size=1>AUTENTICAÇÃO</font>
                    </b></td>
            </tr>
            <tr>
                <td height="4" align="left" valign=bottom></td>
            </tr>
            <tr>
                <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" colspan=13 height="16" align="center" valign=middle>
                    <font size=1><?php echo $Reg . $PC . $horaaut . $NDoc . $dtAut . $SgRec . $FmRec . $VrPagA . $Mat; ?></font>
                </td>
            </tr>
            <tr>
                <td height="4" align="left" valign=bottom></td>
            </tr>
            <tr>
                <td colspan=13 height="15" align="center" valign=middle>
                    <font size=1>------------------------------------------------------------------------------------------------------------------------------------------------------------------</font>
                </td>
            </tr>
            <!-- Segunda via -->
            <tr>
                <td height="17" align="left" valign=bottom><br></td>
                <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000"
                    colspan=3 rowspan=2 align="center" valign=middle>
                    <b>
                        <font size=4><?php echo $tipo; ?></font>
                    </b>
                </td>
                <td align="left" valign=bottom><br></td>
                <td style="border-top: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000"
                    colspan=2 align="center" valign=middle>
                    <b>
                        <font size=1>RECIBO</font>
                    </b>
                </td>
                <td align="left" valign=bottom>
                    <font size=1><br></font>
                </td>
                <td style="border-top: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000"
                    colspan=2 align="center" valign=middle>
                    <b>
                        <font size=1>PC</font>
                    </b>
                </td>
                <td align="center" valign=middle>
                    <font size=1><br></font>
                </td>
                <td style="border-top: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000"
                    colspan=2 align="center" valign=middle>
                    <b>
                        <font size=1>VALOR PAGO</font>
                    </b>
                </td>
            </tr>
            <tr>
                <td height="5" align="left" valign=bottom>
                    <font size=1><br></font>
                </td>
                <td align="left" valign=bottom><br></td>
                <td style="border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000"
                    colspan=2 align="center" valign=middle>
                    <font size=1><?php echo $NDoc; ?></font>
                </td>
                <td align="left" valign=bottom>
                    <font size=1><br></font>
                </td>
                <td style="border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000"
                    colspan=2 align="center" valign=middle>
                    <font size=1><?php echo $PC; ?></font>
                </td>
                <td align="left" valign=bottom>
                    <font size=1><br></font>
                </td>
                <td style="border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000"
                    colspan=2 align="center" valign=middle>
                    <font size=1><?php echo "R$ " . $VrPagF; ?></font>
                </td>
            </tr>
            <tr>
                <td height="4" align="left" valign=bottom></td>
            <tr>
                <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000"
                    colspan=4 rowspan=5 height="60" align="center" valign=middle>
                    <font size=1><img src="./images/endereco_pc<?php echo $PC; ?>.png" class="imagem_end_2">
                    </font>
                </td>
                <td align="left" valign=bottom>
                    <font size=1><br></font>
                </td>
                <td style="border-top: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000"
                    colspan=2 align="center" valign=middle><b>
                        <font size=1>DATA</font>
                    </b></td>
                <td align="left" valign=bottom>
                    <font size=1><br></font>
                </td>
                <td style="border-top: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000"
                    colspan=2 align="center" valign=middle><b>
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
                <td style="border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" colspan=2 align="center" valign=middle sdval="45793" sdnum="1046;0;DD/MM/AA">
                    <font size=1><?php echo $data; ?></font>
                </td>
                <td align="left" valign=bottom>
                    <font size=1><br></font>
                </td>
                <td style="border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" colspan=2 align="center" valign=middle>
                    <font size=1><?php echo $Vendedora; ?></font>
                </td>
            </tr>
            <tr>
                <td height="4" align="left" valign=bottom></td>
            </tr>
            <tr>
                <td align="left" valign=bottom>
                    <font size=1><br></font>
                </td>
                <?php

                // Conexão
                include "./conexao.php";
                include "./dbselect.php";

                // Forma de pagamento 1 - verifica se não está vazio e pega o primeiro valor e diferente de 00
                if (!empty($FPags[0]) && $FPags[0] !== "00") {
                    $FPag = $FPags[0];

                    // Nome  na forma de pagamento por extenso
                    if ($FPag == 10) {
                        $ModPag = "DINHEIRO";
                    } elseif ($FPag == 20) {
                        $ModPag = "CARTÃO DÉBITO";
                    } elseif ($FPag == 30) {
                        $ModPag = "CARTÃO CRÉDITO";
                    } elseif ($FPag == 70) {
                        $ModPag = "PIX QR CODE";
                    } elseif ($FPag == 71) {
                        $ModPag = "PIX CNPJ";
                    }

                ?>
                    <td style="border-top: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" colspan=2 align="center" valign=middle><b>
                            <font size=1><?php echo $ModPag; ?></font>
                        </b></td>
                    <td align="left" valign=bottom>
                        <font size=1><br></font>
                    </td>
                <?php
                }

                // Forma de pagamento 2
                if (!empty($FPags[1]) && $FPags[1] !== "00") {
                    $FPag = $FPags[1];

                    // Nome  na forma de pagamento por extenso
                    if ($FPag == 10) {
                        $ModPag = "DINHEIRO";
                    } elseif ($FPag == 20) {
                        $ModPag = "CARTÃO DÉBITO";
                    } elseif ($FPag == 30) {
                        $ModPag = "CARTÃO CRÉDITO";
                    } elseif ($FPag == 70) {
                        $ModPag = "PIX QR CODE";
                    } elseif ($FPag == 71) {
                        $ModPag = "PIX CNPJ";
                    }

                ?>
                    <td style="border-top: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" colspan=2 align="center" valign=middle><b>
                            <font size=1><?php echo $ModPag; ?></font>
                        </b></td>
                    <td align="left" valign=bottom>
                        <font size=1><br></font>
                    </td>
                <?php
                }

                // Forma de pagamento 3
                if (!empty($FPags[2]) && $FPags[2] !== "00") {
                    $FPag = $FPags[2];

                    // Nome  na forma de pagamento por extenso
                    if ($FPag == 10) {
                        $ModPag = "DINHEIRO";
                    } elseif ($FPag == 20) {
                        $ModPag = "CARTÃO DÉBITO";
                    } elseif ($FPag == 30) {
                        $ModPag = "CARTÃO CRÉDITO";
                    } elseif ($FPag == 70) {
                        $ModPag = "PIX QR CODE";
                    } elseif ($FPag == 71) {
                        $ModPag = "PIX CNPJ";
                    }

                ?>
                    <td style="border-top: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" colspan=2 align="center" valign=middle><b>
                            <font size=1><?php echo $ModPag; ?></font>
                        </b></td>
                    <td align="left" valign=bottom>
                        <font size=1><br></font>
                    </td>
                <?php
                }
                ?>
            </tr>
            <tr>
                <td align="left" valign=bottom>
                    <font size=1><br></font>
                </td>

                <?php
                // Valor 1
                if (!empty($FPags[0]) && $FPags[0] !== "00") {
                    $Vlr = $Vlrs[0];
                    $VlrF = number_format($Vlr, 2, ',', '.');
                ?>
                    <td style="border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" colspan=2 align="center" valign=middle sdval="500" sdnum="1046;0;[$R$-416] #.##0,00;[RED]-[$R$-416] #.##0,00">
                        <font size=1><?php echo "R$ " .  $VlrF; ?></font>
                    </td>
                    <td align="left" valign=bottom>
                        <font size=1><br></font>
                    </td>
                <?php
                }

                // Valor 2
                if (!empty($FPags[1]) && $FPags[1] !== "00") {
                    $Vlr = $Vlrs[1];
                    $VlrF = number_format($Vlr, 2, ',', '.');
                ?>
                    <td style="border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" colspan=2 align="center" valign=middle sdval="1000" sdnum="1046;0;[$R$-416] #.##0,00;[RED]-[$R$-416] #.##0,00">
                        <font size=1><?php echo "R$ " .  $VlrF; ?></font>
                    </td>
                    <td align="left" valign=bottom>
                        <font size=1><br></font>
                    </td>
                <?php
                }

                // Valor 3
                if (!empty($FPags[2]) && $FPags[2] !== "00") {
                    $Vlr = $Vlrs[2];
                    $VlrF = number_format($Vlr, 2, ',', '.');
                ?>
                    <td style="border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" colspan=2 align="center" valign=middle sdval="0" sdnum="1046;0;[$R$-416] #.##0,00;[RED]-[$R$-416] #.##0,00">
                        <font size=1 color="#000000"><?php echo "R$ " .  $VlrF; ?></font>
                    </td>
                <?php
                }
                ?>
            </tr>
            <tr>
                <td height="4" align="left" valign=bottom></td>
            </tr>
            <tr>
                <td style="border-top: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000"
                    colspan=13 height="15" align="left" valign=middle><b>
                        <font size=1>RECEBEMOS</font>
                    </b></td>
            </tr>
            <tr>
                <td style="border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000"
                    colspan=13 height="17" align="center" valign=middle>
                    <font size=1><?php echo $Cliente; ?></font>
                </td>
            </tr>
            <tr>
                <td height="4" align="left" valign=bottom>
                    <font size=1></font>
                </td>
            </tr>
            <tr>
                <td style="border-top: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000"
                    colspan=13 height="15" align="left" valign=middle><b>
                        <font size=1>A IMPORTÂNCIA TOTAL DE</font>
                    </b></td>
            </tr>
            <tr>
                <td style="border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000"
                    colspan=13 height="17" align="center" valign=middle>
                    <font size=1><?php echo $vlr_ext; ?></font>
                </td>
            </tr>
            <tr>
                <td height="4" align="left" valign=bottom>
                    <font size=1></font>
                </td>
            </tr>
            <tr>
                <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" colspan=13 height="15" align="center" valign=middle><b>
                        <font size=1>AUTENTICAÇÃO</font>
                    </b></td>
            </tr>
            <tr>
                <td height="4" align="left" valign=bottom></td>
            </tr>
            <tr>
                <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" colspan=13 height="16" align="center" valign=middle>
                    <font size=1><?php echo $Reg . $PC . $horaaut . $NDoc . $dtAut . $SgRec . $FmRec . $VrPagA . $Mat; ?></font>
                </td>
            </tr>
            <tr>
                <td height="4" align="left" valign=bottom></td>
            </tr>
            <tr>
                <td colspan=13 height="15" align="center" valign=middle>
                    <font size=1>------------------------------------------------------------------------------------------------------------------------------------------------------------------</font>
                </td>
            </tr>
            <!-- Terceira via -->
            <tr>
                <td height="17" align="left" valign=bottom><br></td>
                <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000"
                    colspan=3 rowspan=2 align="center" valign=middle>
                    <b>
                        <font size=4><?php echo $tipo; ?></font>
                    </b>
                </td>
                <td align="left" valign=bottom><br></td>
                <td style="border-top: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000"
                    colspan=2 align="center" valign=middle>
                    <b>
                        <font size=1>RECIBO</font>
                    </b>
                </td>
                <td align="left" valign=bottom>
                    <font size=1><br></font>
                </td>
                <td style="border-top: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000"
                    colspan=2 align="center" valign=middle>
                    <b>
                        <font size=1>PC</font>
                    </b>
                </td>
                <td align="center" valign=middle>
                    <font size=1><br></font>
                </td>
                <td style="border-top: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000"
                    colspan=2 align="center" valign=middle>
                    <b>
                        <font size=1>VALOR PAGO</font>
                    </b>
                </td>
            </tr>
            <tr>
                <td height="5" align="left" valign=bottom>
                    <font size=1><br></font>
                </td>
                <td align="left" valign=bottom><br></td>
                <td style="border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000"
                    colspan=2 align="center" valign=middle>
                    <font size=1><?php echo $NDoc; ?></font>
                </td>
                <td align="left" valign=bottom>
                    <font size=1><br></font>
                </td>
                <td style="border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000"
                    colspan=2 align="center" valign=middle>
                    <font size=1><?php echo $PC; ?></font>
                </td>
                <td align="left" valign=bottom>
                    <font size=1><br></font>
                </td>
                <td style="border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000"
                    colspan=2 align="center" valign=middle>
                    <font size=1><?php echo "R$ " . $VrPagF; ?></font>
                </td>
            </tr>
            <tr>
                <td height="4" align="left" valign=bottom></td>
            <tr>
                <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000"
                    colspan=4 rowspan=5 height="60" align="center" valign=middle>
                    <font size=1><img src="./images/endereco_pc<?php echo $PC; ?>.png" class="imagem_end_3">
                    </font>
                </td>
                <td align="left" valign=bottom>
                    <font size=1><br></font>
                </td>
                <td style="border-top: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000"
                    colspan=2 align="center" valign=middle><b>
                        <font size=1>DATA</font>
                    </b></td>
                <td align="left" valign=bottom>
                    <font size=1><br></font>
                </td>
                <td style="border-top: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000"
                    colspan=2 align="center" valign=middle><b>
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
                <td style="border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" colspan=2 align="center" valign=middle sdval="45793" sdnum="1046;0;DD/MM/AA">
                    <font size=1><?php echo $data; ?></font>
                </td>
                <td align="left" valign=bottom>
                    <font size=1><br></font>
                </td>
                <td style="border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" colspan=2 align="center" valign=middle>
                    <font size=1><?php echo $Vendedora; ?></font>
                </td>
            </tr>
            <tr>
                <td height="4" align="left" valign=bottom></td>
            </tr>
            <tr>
                <td align="left" valign=bottom>
                    <font size=1><br></font>
                </td>
                <?php

                // Conexão
                include "./conexao.php";
                include "./dbselect.php";

                // Forma de pagamento 1 - verifica se não está vazio e pega o primeiro valor e diferente de 00
                if (!empty($FPags[0]) && $FPags[0] !== "00") {
                    $FPag = $FPags[0];

                    // Nome  na forma de pagamento por extenso
                    if ($FPag == 10) {
                        $ModPag = "DINHEIRO";
                    } elseif ($FPag == 20) {
                        $ModPag = "CARTÃO DÉBITO";
                    } elseif ($FPag == 30) {
                        $ModPag = "CARTÃO CRÉDITO";
                    } elseif ($FPag == 70) {
                        $ModPag = "PIX QR CODE";
                    } elseif ($FPag == 71) {
                        $ModPag = "PIX CNPJ";
                    }

                ?>
                    <td style="border-top: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" colspan=2 align="center" valign=middle><b>
                            <font size=1><?php echo $ModPag; ?></font>
                        </b></td>
                    <td align="left" valign=bottom>
                        <font size=1><br></font>
                    </td>
                <?php
                }

                // Forma de pagamento 2
                if (!empty($FPags[1]) && $FPags[1] !== "00") {
                    $FPag = $FPags[1];

                    // Nome  na forma de pagamento por extenso
                    if ($FPag == 10) {
                        $ModPag = "DINHEIRO";
                    } elseif ($FPag == 20) {
                        $ModPag = "CARTÃO DÉBITO";
                    } elseif ($FPag == 30) {
                        $ModPag = "CARTÃO CRÉDITO";
                    } elseif ($FPag == 70) {
                        $ModPag = "PIX QR CODE";
                    } elseif ($FPag == 71) {
                        $ModPag = "PIX CNPJ";
                    }

                ?>
                    <td style="border-top: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" colspan=2 align="center" valign=middle><b>
                            <font size=1><?php echo $ModPag; ?></font>
                        </b></td>
                    <td align="left" valign=bottom>
                        <font size=1><br></font>
                    </td>
                <?php
                }

                // Forma de pagamento 3
                if (!empty($FPags[2]) && $FPags[2] !== "00") {
                    $FPag = $FPags[2];

                    // Nome  na forma de pagamento por extenso
                    if ($FPag == 10) {
                        $ModPag = "DINHEIRO";
                    } elseif ($FPag == 20) {
                        $ModPag = "CARTÃO DÉBITO";
                    } elseif ($FPag == 30) {
                        $ModPag = "CARTÃO CRÉDITO";
                    } elseif ($FPag == 70) {
                        $ModPag = "PIX QR CODE";
                    } elseif ($FPag == 71) {
                        $ModPag = "PIX CNPJ";
                    }

                ?>
                    <td style="border-top: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" colspan=2 align="center" valign=middle><b>
                            <font size=1><?php echo $ModPag; ?></font>
                        </b></td>
                    <td align="left" valign=bottom>
                        <font size=1><br></font>
                    </td>
                <?php
                }
                ?>
            </tr>
            <tr>
                <td align="left" valign=bottom>
                    <font size=1><br></font>
                </td>

                <?php
                // Valor 1
                if (!empty($FPags[0]) && $FPags[0] !== "00") {
                    $Vlr = $Vlrs[0];
                    $VlrF = number_format($Vlr, 2, ',', '.');
                ?>
                    <td style="border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" colspan=2 align="center" valign=middle sdval="500" sdnum="1046;0;[$R$-416] #.##0,00;[RED]-[$R$-416] #.##0,00">
                        <font size=1><?php echo "R$ " .  $VlrF; ?></font>
                    </td>
                    <td align="left" valign=bottom>
                        <font size=1><br></font>
                    </td>
                <?php
                }

                // Valor 2
                if (!empty($FPags[1]) && $FPags[1] !== "00") {
                    $Vlr = $Vlrs[1];
                    $VlrF = number_format($Vlr, 2, ',', '.');
                ?>
                    <td style="border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" colspan=2 align="center" valign=middle sdval="1000" sdnum="1046;0;[$R$-416] #.##0,00;[RED]-[$R$-416] #.##0,00">
                        <font size=1><?php echo "R$ " .  $VlrF; ?></font>
                    </td>
                    <td align="left" valign=bottom>
                        <font size=1><br></font>
                    </td>
                <?php
                }

                // Valor 3
                if (!empty($FPags[2]) && $FPags[2] !== "00") {
                    $Vlr = $Vlrs[2];
                    $VlrF = number_format($Vlr, 2, ',', '.');
                ?>
                    <td style="border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" colspan=2 align="center" valign=middle sdval="0" sdnum="1046;0;[$R$-416] #.##0,00;[RED]-[$R$-416] #.##0,00">
                        <font size=1 color="#000000"><?php echo "R$ " .  $VlrF; ?></font>
                    </td>
                <?php
                }
                ?>
            </tr>
            <tr>
                <td height="4" align="left" valign=bottom></td>
            </tr>
            <tr>
                <td style="border-top: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000"
                    colspan=13 height="15" align="left" valign=middle><b>
                        <font size=1>RECEBEMOS</font>
                    </b></td>
            </tr>
            <tr>
                <td style="border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000"
                    colspan=13 height="17" align="center" valign=middle>
                    <font size=1><?php echo $Cliente; ?></font>
                </td>
            </tr>
            <tr>
                <td height="4" align="left" valign=bottom>
                    <font size=1></font>
                </td>
            </tr>
            <tr>
                <td style="border-top: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000"
                    colspan=13 height="15" align="left" valign=middle><b>
                        <font size=1>A IMPORTÂNCIA TOTAL DE</font>
                    </b></td>
            </tr>
            <tr>
                <td style="border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000"
                    colspan=13 height="17" align="center" valign=middle>
                    <font size=1><?php echo $vlr_ext; ?></font>
                </td>
            </tr>
            <tr>
                <td height="4" align="left" valign=bottom>
                    <font size=1></font>
                </td>
            </tr>
            <tr>
                <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" colspan=13 height="15" align="center" valign=middle><b>
                        <font size=1>AUTENTICAÇÃO</font>
                    </b></td>
            </tr>
            <tr>
                <td height="4" align="left" valign=bottom></td>
            </tr>
            <tr>
                <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" colspan=13 height="16" align="center" valign=middle>
                    <font size=1><?php echo $Reg . $PC . $horaaut . $NDoc . $dtAut . $SgRec . $FmRec . $VrPagA . $Mat; ?></font>
                </td>
            </tr>
            <tr>
                <td height="4" align="left" valign=bottom></td>
            </tr>
            <tr>
                <td colspan=13 height="15" align="center" valign=middle>
                    <font size=1>------------------------------------------------------------------------------------------------------------------------------------------------------------------</font>
                </td>
            </tr>
            <!-- Quarta via -->
            <!--<tr>
                <td height="17" align="left" valign=bottom><br></td>
                <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000"
                    colspan=3 rowspan=2 align="center" valign=middle>
                    <b>
                        <font size=4><?php echo $tipo; ?></font>
                    </b>
                </td>
                <td align="left" valign=bottom><br></td>
                <td style="border-top: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000"
                    colspan=2 align="center" valign=middle>
                    <b>
                        <font size=1>RECIBO</font>
                    </b>
                </td>
                <td align="left" valign=bottom>
                    <font size=1><br></font>
                </td>
                <td style="border-top: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000"
                    colspan=2 align="center" valign=middle>
                    <b>
                        <font size=1>PC</font>
                    </b>
                </td>
                <td align="center" valign=middle>
                    <font size=1><br></font>
                </td>
                <td style="border-top: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000"
                    colspan=2 align="center" valign=middle>
                    <b>
                        <font size=1>VALOR PAGO</font>
                    </b>
                </td>
            </tr>
            <tr>
                <td height="5" align="left" valign=bottom>
                    <font size=1><br></font>
                </td>
                <td align="left" valign=bottom><br></td>
                <td style="border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000"
                    colspan=2 align="center" valign=middle>
                    <font size=1><?php echo $NDoc; ?></font>
                </td>
                <td align="left" valign=bottom>
                    <font size=1><br></font>
                </td>
                <td style="border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000"
                    colspan=2 align="center" valign=middle>
                    <font size=1><?php echo $PC; ?></font>
                </td>
                <td align="left" valign=bottom>
                    <font size=1><br></font>
                </td>
                <td style="border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000"
                    colspan=2 align="center" valign=middle>
                    <font size=1><?php echo "R$ " . $VrPagF; ?></font>
                </td>
            </tr>
            <tr>
                <td height="4" align="left" valign=bottom></td>
            <tr>
                <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000"
                    colspan=4 rowspan=5 height="60" align="center" valign=middle>
                    <font size=1><img src="./images/endereco_pc<?php echo $PC; ?>.png" class="imagem_end_4">
                    </font>
                </td>
                <td align="left" valign=bottom>
                    <font size=1><br></font>
                </td>
                <td style="border-top: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000"
                    colspan=2 align="center" valign=middle><b>
                        <font size=1>DATA</font>
                    </b></td>
                <td align="left" valign=bottom>
                    <font size=1><br></font>
                </td>
                <td style="border-top: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000"
                    colspan=2 align="center" valign=middle><b>
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
                <td style="border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" colspan=2 align="center" valign=middle sdval="45793" sdnum="1046;0;DD/MM/AA">
                    <font size=1><?php echo $data; ?></font>
                </td>
                <td align="left" valign=bottom>
                    <font size=1><br></font>
                </td>
                <td style="border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" colspan=2 align="center" valign=middle>
                    <font size=1><?php echo $Vendedora; ?></font>
                </td>
            </tr>
            <tr>
                <td height="4" align="left" valign=bottom></td>
            </tr>
            <tr>
                <td align="left" valign=bottom>
                    <font size=1><br></font>
                </td>
                <?php

                // Conexão
                include "./conexao.php";
                include "./dbselect.php";

                // Forma de pagamento 1 - verifica se não está vazio e pega o primeiro valor e diferente de 00
                if (!empty($FPags[0]) && $FPags[0] !== "00") {
                    $FPag = $FPags[0];

                    // Nome  na forma de pagamento por extenso
                    if ($FPag == 10) {
                        $ModPag = "DINHEIRO";
                    } elseif ($FPag == 20) {
                        $ModPag = "CARTÃO DÉBITO";
                    } elseif ($FPag == 30) {
                        $ModPag = "CARTÃO CRÉDITO";
                    } elseif ($FPag == 70) {
                        $ModPag = "PIX QR CODE";
                    } elseif ($FPag == 71) {
                        $ModPag = "PIX CNPJ";
                    }

                ?>
                    <td style="border-top: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" colspan=2 align="center" valign=middle><b>
                            <font size=1><?php echo $ModPag; ?></font>
                        </b></td>
                    <td align="left" valign=bottom>
                        <font size=1><br></font>
                    </td>
                <?php
                }

                // Forma de pagamento 2
                if (!empty($FPags[1]) && $FPags[1] !== "00") {
                    $FPag = $FPags[1];

                    // Nome  na forma de pagamento por extenso
                    if ($FPag == 10) {
                        $ModPag = "DINHEIRO";
                    } elseif ($FPag == 20) {
                        $ModPag = "CARTÃO DÉBITO";
                    } elseif ($FPag == 30) {
                        $ModPag = "CARTÃO CRÉDITO";
                    } elseif ($FPag == 70) {
                        $ModPag = "PIX QR CODE";
                    } elseif ($FPag == 71) {
                        $ModPag = "PIX CNPJ";
                    }

                ?>
                    <td style="border-top: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" colspan=2 align="center" valign=middle><b>
                            <font size=1><?php echo $ModPag; ?></font>
                        </b></td>
                    <td align="left" valign=bottom>
                        <font size=1><br></font>
                    </td>
                <?php
                }

                // Forma de pagamento 3
                if (!empty($FPags[2]) && $FPags[2] !== "00") {
                    $FPag = $FPags[2];

                    // Nome  na forma de pagamento por extenso
                    if ($FPag == 10) {
                        $ModPag = "DINHEIRO";
                    } elseif ($FPag == 20) {
                        $ModPag = "CARTÃO DÉBITO";
                    } elseif ($FPag == 30) {
                        $ModPag = "CARTÃO CRÉDITO";
                    } elseif ($FPag == 70) {
                        $ModPag = "PIX QR CODE";
                    } elseif ($FPag == 71) {
                        $ModPag = "PIX CNPJ";
                    }

                ?>
                    <td style="border-top: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" colspan=2 align="center" valign=middle><b>
                            <font size=1><?php echo $ModPag; ?></font>
                        </b></td>
                    <td align="left" valign=bottom>
                        <font size=1><br></font>
                    </td>
                <?php
                }
                ?>
            </tr>
            <tr>
                <td align="left" valign=bottom>
                    <font size=1><br></font>
                </td>

                <?php
                // Valor 1
                if (!empty($FPags[0]) && $FPags[0] !== "00") {
                    $Vlr = $Vlrs[0];
                    $VlrF = number_format($Vlr, 2, ',', '.');
                ?>
                    <td style="border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" colspan=2 align="center" valign=middle sdval="500" sdnum="1046;0;[$R$-416] #.##0,00;[RED]-[$R$-416] #.##0,00">
                        <font size=1><?php echo "R$ " .  $VlrF; ?></font>
                    </td>
                    <td align="left" valign=bottom>
                        <font size=1><br></font>
                    </td>
                <?php
                }

                // Valor 2
                if (!empty($FPags[1]) && $FPags[1] !== "00") {
                    $Vlr = $Vlrs[1];
                    $VlrF = number_format($Vlr, 2, ',', '.');
                ?>
                    <td style="border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" colspan=2 align="center" valign=middle sdval="1000" sdnum="1046;0;[$R$-416] #.##0,00;[RED]-[$R$-416] #.##0,00">
                        <font size=1><?php echo "R$ " .  $VlrF; ?></font>
                    </td>
                    <td align="left" valign=bottom>
                        <font size=1><br></font>
                    </td>
                <?php
                }

                // Valor 3
                if (!empty($FPags[2]) && $FPags[2] !== "00") {
                    $Vlr = $Vlrs[2];
                    $VlrF = number_format($Vlr, 2, ',', '.');
                ?>
                    <td style="border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" colspan=2 align="center" valign=middle sdval="0" sdnum="1046;0;[$R$-416] #.##0,00;[RED]-[$R$-416] #.##0,00">
                        <font size=1 color="#000000"><?php echo "R$ " .  $VlrF; ?></font>
                    </td>
                <?php
                }
                ?>
            </tr>
            <tr>
                <td height="4" align="left" valign=bottom></td>
            </tr>
            <tr>
                <td style="border-top: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000"
                    colspan=13 height="15" align="left" valign=middle><b>
                        <font size=1>RECEBEMOS</font>
                    </b></td>
            </tr>
            <tr>
                <td style="border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000"
                    colspan=13 height="17" align="center" valign=middle>
                    <font size=1><?php echo $Cliente; ?></font>
                </td>
            </tr>
            <tr>
                <td height="4" align="left" valign=bottom>
                    <font size=1></font>
                </td>
            </tr>
            <tr>
                <td style="border-top: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000"
                    colspan=13 height="15" align="left" valign=middle><b>
                        <font size=1>A IMPORTÂNCIA TOTAL DE</font>
                    </b></td>
            </tr>
            <tr>
                <td style="border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000"
                    colspan=13 height="17" align="center" valign=middle>
                    <font size=1><?php echo $vlr_ext; ?></font>
                </td>
            </tr>
            <tr>
                <td height="4" align="left" valign=bottom>
                    <font size=1></font>
                </td>
            </tr>
            <tr>
                <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" colspan=13 height="15" align="center" valign=middle><b>
                        <font size=1>AUTENTICAÇÃO</font>
                    </b></td>
            </tr>
            <tr>
                <td height="4" align="left" valign=bottom></td>
            </tr>
            <tr>
                <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" colspan=13 height="16" align="center" valign=middle>
                    <font size=1><?php echo $Reg . $PC . $horaaut . $NDoc . $dtAut . $SgRec . $FmRec . $VrPagA . $Mat; ?></font>
                </td>
            </tr>
            <tr>
                <td height="4" align="left" valign=bottom></td>
            </tr>
            <tr>
                <td colspan=13 height="15" align="center" valign=middle>
                    <font size=1>------------------------------------------------------------------------------------------------------------------------------------------------------------------</font>
                </td>
            </tr>-->
        </table>
    </div>
</body>

</html>
