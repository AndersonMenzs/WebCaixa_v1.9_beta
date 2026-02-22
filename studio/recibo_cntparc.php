<?php

// Debug
/*error_reporting(E_ALL);
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);*/

/*$dados = filter_input_array(INPUT_GET, FILTER_DEFAULT);
echo "<pre>";
var_dump($dados);
echo "</pre>";*/
//exit();

// Variáveis do $_GET
$Reg       = trim($_GET['Reg']);
$NDoc       = trim($_GET['NDoc']);
$Mat       = trim($_GET['txtmat']);
$Mat = substr_replace($Mat, "-", -1, 0);
$PIni       = trim($_GET['PIni']);
$PC         = trim($_GET['PC']);
$Ref_Std   = trim($_GET['Ref_Std']);
$SgRec      = trim($_GET['SgRec']);
$Vendedora  = trim($_GET['Vendedora']);
$Mat_Vend   = ltrim($_GET['mat_vend'], '0');
$Cliente    = trim($_GET['Cliente']);
$QtdeParc   = trim($_GET['QtdParcPag']);
$VrParcial    = trim($_GET['VrParcial']);
$data       = date('d/m/Y', strtotime($_GET['data']));
$horaaut  = trim($_GET['horaaut']);
$dtAut     = trim($_GET['dtAut']);
$tipo       = trim($_GET['tipo']);
$FmRec      = trim($_GET['FmRec']);
$FPag_1      = trim($_GET['FPag_1']);
$FPag_2      = trim($_GET['FPag_2']);
$FPag_3      = trim($_GET['FPag_3']);
$txt1      = trim($_GET['txt1']);
$txt2      = trim($_GET['txt2']);
$txt3      = trim($_GET['txt3']);

$VrTot = $txt1 + $txt2 + $txt3;
$VrTotF = number_format($VrTot, 2, '', '');

$FPags = [$FPag_1, $FPag_2, $FPag_3];
$Vlrs = [$txt1, $txt2, $txt3];

$VrRec     = trim($_GET['VrRec']);
$VrRecF     = number_format($VrRec, 2, ",", ".");
$VrRecA = number_format($VrRec, 2, "", "");
$VrPrest     = trim($_GET['VrPrest']);
$VrPrestF     = number_format($VrPrest, 2, ",", ".");
$VrParcial     = floatval(str_replace(',', '.', str_replace('.', '', trim($_GET['VrParcial']))));
$VrParcial     = number_format($VrParcial, 2, ".", ",");
$VrParcialF     = number_format($VrParcial, 2, ",", ".");
$vlr_ext   = trim($_GET['vlr_ext']);
$PIni = trim($_GET['PIni']);
$PUlt = trim($_GET['PUlt']);
$Parc_Card_Cred = "X" . trim($_GET['parc_card_cred']);

$Rdopt = trim($_GET['rdopt'] ?? '');
$Pedido = trim($_GET['pedido'] ?? '');
$tipo_2 = trim($_GET['tipo_2'] ?? '');

// Conexão
include "./conexao.php";
include "./dbselect.php";
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
            top: 340px;
            left: 5px;
            width: 50px;
            height: auto;
            z-index: 2;
            pointer-events: none;
        }

        .imagem_via3 {
            position: absolute;
            top: 653px;
            left: 5px;
            width: 50px;
            height: auto;
            z-index: 2;
            pointer-events: none;
        }

        .imagem_end_1 {
            position: absolute;
            top: 60px;
            left: 22px;
            width: 260px;
            /* Largura original */
            height: 55px;
            /* Altura original */
            object-fit: contain;
            /* Mantém a proporção da imagem */
        }

        .imagem_end_2 {
            position: absolute;
            top: 170px;
            left: 22px;
            width: 260px;
            height: 520px;
            object-fit: contain;
        }

        .imagem_end_3 {
            position: absolute;
            top: 490px;
            left: 22px;
            width: 260px;
            height: 520px;
            object-fit: contain;
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
        <table cellspacing="0" border="0">
            <colgroup width="100"></colgroup>
            <colgroup span="2" width="100"></colgroup>
            <colgroup width="100"></colgroup>
            <colgroup width="8"></colgroup>
            <colgroup span="2" width="100"></colgroup>
            <colgroup width="8"></colgroup>
            <colgroup width="96"></colgroup>
            <colgroup width="8"></colgroup>
            <colgroup width="96"></colgroup>
            <colgroup width="8"></colgroup>
            <colgroup span="2" width="100"></colgroup>

            <!-- Primeira via -->
            <tr>
                <td height="17" align="left" valign="bottom"></td>
                <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000"
                    colspan=3 rowspan=2 align="center" valign=middle>
                    <b>
                        <font size=4><?php echo $tipo; ?></font>
                    </b>
                </td>
                <td align="left" valign=bottom></td>
                <td style="border-top: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000"
                    colspan=2 align="center" valign=middle>
                    <b>
                        <font size=1>CONTRATO</font>
                    </b>
                </td>
                <td align="left" valign=bottom></td>
                <td style="border-top: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="center" valign=middle>
                    <b>
                        <font size=1>PC</font>
                    </b>
                </td>
                <td align="center" valign=middle></td>
                <td style="border-top: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="center" valign=middle>
                    <b>
                        <font size=1>REF.</font>
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
                <td height="5" align="left" valign="bottom"></td>
                <td align="left" valign=bottom></td>
                <td style="border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" colspan=2 align="center" valign=middle>
                    <font size=1><?php echo $NDoc; ?></font>
                </td>
                <td align="left" valign=bottom></td>
                <td style="border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="center" valign=middle>
                    <font size=1><?php echo $PC; ?></font>
                </td>
                <td align="center" valign=middle></td>
                <td style="border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="center" valign=middle>
                    <font size=1>
                        <?php
                        if ($PC == $Ref_Std) {
                            echo " --- ";
                        } else {
                            echo $Ref_Std;
                        }
                        ?></font>
                </td>
                <td align="left" valign=bottom></td>
                <td style="border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" colspan=2 align="center" valign=middle>
                    <font size=1><?php echo "R$ " . $VrRecF; ?></font>
                </td>
            </tr>
            <tr>
                <td height="4" align="left" valign=bottom></td>
            </tr>
            <tr>
                <td style="border-top: 1px solid #000000; border-left: 1px solid #000000" align="center" valign=middle></td>
                <td style="border-top: 1px solid #000000" align="center" valign=middle></td>
                <td style="border-top: 1px solid #000000" align="center" valign=middle>
                    <font size=1><img src="./images/endereco_pc<?php echo $PC; ?>.png" class="imagem_end_1">
                    </font>
                </td>
                <td style="border-top: 1px solid #000000;border-right: 1px solid #000000" align="center" valign=middle></td>
                <td align="left" valign=bottom></td>
                <td style="border-top: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" colspan=2 align="center" valign=middle>
                    <b>
                        <font size=1>DATA</font>
                    </b>
                </td>
                <td align="left" valign=bottom></td>
                <td style="border-top: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" colspan=3 align="center" valign=middle>
                    <b>
                        <font size=1>VENDEDORA</font>
                    </b>
                </td>
                <td align="left" valign=bottom></td>
                <td style="border-top: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" colspan=2 align="center" valign=middle>
                    <b>
                        <font size=1>VLR. PRESTAÇÃO</font>
                    </b>
                </td>
            </tr>
            <tr>
                <td style="border-left: 1px solid #000000" align="center" valign=middle></td>
                <td align="center" valign=middle></td>
                <td align="center" valign=middle></td>
                <td style="border-right: 1px solid #000000" align="center" valign=middle></td>
                <td align="left" valign=bottom></td>
                <td style="border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" colspan=2 align="center" valign=middle>
                    <font size=1><?php echo $data; ?></font>
                </td>
                <td align="left" valign=bottom></td>
                <td style="border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" colspan=3 align="center" valign=middle>
                    <font size=1><?php echo $Vendedora . " - " . $Mat_Vend; ?></font>
                </td>
                <td align="left" valign=bottom></td>
                <td style="border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" colspan=2 align="center" valign=middle>
                    <font size=1><?php echo "R$ " . $VrPrestF; ?></font>
                </td>
            <tr>
                <td style="border-left: 1px solid #000000" height="4" align="left" valign=bottom></td>
                <td align="center" valign=middle></td>
                <td align="center" valign=middle></td>
                <td style="border-right: 1px solid #000000" height="4" align="left" valign=bottom></td>
            </tr>
            <tr>
                <td style="border-left: 1px solid #000000" align="center" valign=middle></td>
                <td align="center" valign=middle></td>
                <td align="center" valign=middle></td>
                <td style="border-right: 1px solid #000000" align="center" valign=middle></td>
                <td align="left" valign=bottom></td>
                <td style="border-top: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" colspan=2 align="center" valign=middle>
                    <b>
                        <font size=1>
                            <?php echo ($QtdeParc > 1) ? 'PARCELAS' : 'PARCELA'; ?></font>
                    </b>
                </td>
                <?php
                if ($VrParcial > 0) {
                ?>
                    <td align="left" valign=bottom></td>
                    <td style="border-top: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" colspan=3 align="center" valign=middle>
                        <b>
                            <font size=1>PARCELA PARCIAL</font>
                        </b>
                    </td>
                <?php
                }

                if ($VrParcial > 0.00) {
                ?>
                    <td align="left" valign=bottom></td>
                    <td style="border-top: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" colspan=2 align="center" valign=middle>
                        <b>
                            <font size=1>PARCIAL</font>
                        </b>
                    </td>
                <?php
                }
                ?>
            </tr>
            <tr>
                <?php
                if ($QtdeParc > 0) {
                ?>
                    <td style="border-left: 1px solid #000000" align="center" valign=middle></td>
                    <td align="center" valign=middle></td>
                    <td align="center" valign=middle></td>
                    <td style="border-right: 1px solid #000000" align="center" valign=middle></td>
                    <td align="left" valign=bottom></td>
                    <td style="border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" colspan=2 align="center" valign=middle>
                        <font size=1>
                            <?php
                            $pini = (int)$PIni;
                            $pult = (int)$PUlt;
                            if ($pult >= $pini && $pini > 0) {
                                $arr = [];
                                for ($i = $pini; $i <= $pult; $i++) {
                                    $arr[] = $i . "ª";
                                }
                                echo implode(', ', $arr);
                            } else {
                                echo $PIni;
                            }
                            ?></font>
                    </td>
                <?php
                }
                if ($VrParcial > 0.00) {
                ?>
                    <td align="left" valign=bottom></td>
                    <td style="border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" colspan=3 align="center" valign=middle>
                        <font size=1><?php echo $PUlt + 1; ?>ª</font>
                    </td>
                <?php
                }
                if ($VrParcial > 0.00) {
                ?>
                    <td align="left" valign=bottom></td>
                    <td style="border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" colspan=2 align="center" valign=middle>
                        <font size=1><?php echo "R$ " .  $VrParcialF; ?></font>
                    </td>
                <?php
                }
                ?>
                <td align="left" valign=bottom></td>
            </tr>
            <tr>
                <td style="border-left: 1px solid #000000" height="4" align="left" valign=bottom></td>
                <td align="center" valign=middle></td>
                <td align="center" valign=middle></td>
                <td style="border-right: 1px solid #000000" height="4" align="left" valign=bottom></td>
            </tr>
            <tr>
                <td style="border-left: 1px solid #000000" align="center" valign=middle></td>
                <td align="center" valign=middle></td>
                <td align="center" valign=middle></td>
                <td style="border-right: 1px solid #000000" align="center" valign=middle></td>
                <td align="left" valign=bottom></td>
                <?php

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
                    } elseif ($FPag == 31) {
                        $ModPag = "CARTÃO CRÉDITO PARCELADO LOJA";
                    }

                ?>
                    <td style="border-top: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" colspan=2 align="center" valign=middle>
                        <b>
                            <font size=1><?php echo $ModPag; ?></font>
                        </b>
                    </td>
                    <td align="left" valign=bottom></td>
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
                    } elseif ($FPag == 31) {
                        $ModPag = "CARTÃO CRÉDITO PARCELADO LOJA";
                    }

                ?>
                    <td style="border-top: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" colspan=3 align="center" valign=middle>
                        <b>
                            <font size=1><?php echo $ModPag; ?></font>
                        </b>
                    </td>
                    <td align="left" valign=bottom></td>
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
                    } elseif ($FPag == 31) {
                        $ModPag = "CARTÃO CRÉDITO PARCELADO LOJA";
                    }

                ?>
                    <td style="border-top: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" colspan=2 align="center" valign=middle>
                        <b>
                            <font size=1><?php echo $ModPag; ?></font>
                        </b>
                    </td>
                <?php
                }
                ?>
            <tr>
                <td style="border-left: 1px solid #000000" align="center" valign=middle></td>
                <td align="center" valign=middle></td>
                <td align="center" valign=middle></td>
                <td style="border-right: 1px solid #000000" align="center" valign=middle></td>
                <td align="left" valign=bottom></td>

                <?php
                // Valor 1
                if (!empty($FPags[0]) && $FPags[0] !== "00") {
                    $Vlr = $Vlrs[0];
                    $VlrF = number_format($Vlr, 2, ',', '.');
                ?>
                    <td style="border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" colspan=2 align="center" valign=middle>
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
                    <td style="border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" colspan=3 align="center" valign=middle>
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
                    <td style="border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" colspan=2 align="center" valign=middle>
                        <font size=1 color="#000000"><?php echo "R$ " .  $VlrF; ?></font>
                    </td>
                <?php
                }
                ?>
            </tr>
            <tr>
                <td style="border-top: 1px solid #000000" align="center" valign=middle></td>
                <td style="border-top: 1px solid #000000" align="center" valign=middle></td>
                <td style="border-top: 1px solid #000000" align="center" valign=middle></td>
                <td style="border-top: 1px solid #000000" align="center" valign=middle></td>
                <td height="4" align="left" valign=bottom></td>
            </tr>
            <tr>
                <td style="border-top: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" colspan=14 height="11" align="left" valign=middle>
                    <b>
                        <font size=1>RECEBEMOS</font>
                    </b>
                </td>
            </tr>
            <tr>
                <td style="border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" colspan=14 height="17" align="center" valign=middle>
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
                <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" colspan=14 height="26" align="center" valign=middle>
                    <font size=1><?php echo $Reg . $PC . $horaaut . $NDoc . $dtAut . $Parc_Card_Cred . $SgRec . $FmRec . $VrTotF . $Mat; ?></font>
                </td>
            </tr>
            <tr>
                <td height="4" align="left" valign=bottom></td>
            </tr>
            <tr>
                <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" colspan=14 height="23" align="center" valign=middle>
                    <b>
                        <font size=4>(VIA TESOURARIA)</font>
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
                <td height="17" align="left" valign="bottom"></td>
                <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000"
                    colspan=3 rowspan=2 align="center" valign=middle>
                    <b>
                        <font size=4><?php echo $tipo; ?></font>
                    </b>
                </td>
                <td align="left" valign=bottom></td>
                <td style="border-top: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000"
                    colspan=2 align="center" valign=middle>
                    <b>
                        <font size=1>CONTRATO</font>
                    </b>
                </td>
                <td align="left" valign=bottom></td>
                <td style="border-top: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="center" valign=middle>
                    <b>
                        <font size=1>PC</font>
                    </b>
                </td>
                <td align="center" valign=middle></td>
                <td style="border-top: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="center" valign=middle>
                    <b>
                        <font size=1>REF.</font>
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
                <td height="5" align="left" valign="bottom"></td>
                <td align="left" valign=bottom></td>
                <td style="border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" colspan=2 align="center" valign=middle>
                    <font size=1><?php echo $NDoc; ?></font>
                </td>
                <td align="left" valign=bottom></td>
                <td style="border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="center" valign=middle>
                    <font size=1><?php echo $PC; ?></font>
                </td>
                <td align="center" valign=middle></td>
                <td style="border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="center" valign=middle>
                    <font size=1>
                        <?php
                        if ($PC == $Ref_Std) {
                            echo " --- ";
                        } else {
                            echo $Ref_Std;
                        }
                        ?>
                    </font>
                </td>
                <td align="left" valign=bottom></td>
                <td style="border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" colspan=2 align="center" valign=middle>
                    <font size=1><?php echo "R$ " . $VrRecF; ?></font>
                </td>
            </tr>
            <tr>
                <td height="4" align="left" valign=bottom></td>
            </tr>
            <tr>
                <td style="border-top: 1px solid #000000; border-left: 1px solid #000000" align="center" valign=middle></td>
                <td style="border-top: 1px solid #000000" align="center" valign=middle></td>
                <td style="border-top: 1px solid #000000" align="center" valign=middle>
                    <font size=1><img src="./images/endereco_pc<?php echo $PC; ?>.png" class="imagem_end_2">
                    </font>
                </td>
                <td style="border-top: 1px solid #000000;border-right: 1px solid #000000" align="center" valign=middle></td>
                <td align="left" valign=bottom></td>
                <td style="border-top: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" colspan=2 align="center" valign=middle>
                    <b>
                        <font size=1>DATA</font>
                    </b>
                </td>
                <td align="left" valign=bottom></td>
                <td style="border-top: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" colspan=3 align="center" valign=middle>
                    <b>
                        <font size=1>VENDEDORA</font>
                    </b>
                </td>
                <td align="left" valign=bottom></td>
                <td style="border-top: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" colspan=2 align="center" valign=middle>
                    <b>
                        <font size=1>VLR. PRESTAÇÃO</font>
                    </b>
                </td>
            </tr>
            <tr>
                <td style="border-left: 1px solid #000000" align="center" valign=middle></td>
                <td align="center" valign=middle></td>
                <td align="center" valign=middle></td>
                <td style="border-right: 1px solid #000000" align="center" valign=middle></td>
                <td align="left" valign=bottom></td>
                <td style="border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" colspan=2 align="center" valign=middle>
                    <font size=1><?php echo $data; ?></font>
                </td>
                <td align="left" valign=bottom></td>
                <td style="border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" colspan=3 align="center" valign=middle>
                    <font size=1><?php echo $Vendedora . " - " . $Mat_Vend; ?></font>
                </td>
                <td align="left" valign=bottom></td>
                <td style="border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" colspan=2 align="center" valign=middle>
                    <font size=1><?php echo "R$ " . $VrPrestF; ?></font>
                </td>
            <tr>
                <td style="border-left: 1px solid #000000" height="4" align="left" valign=bottom></td>
                <td align="center" valign=middle></td>
                <td align="center" valign=middle></td>
                <td style="border-right: 1px solid #000000" height="4" align="left" valign=bottom></td>
            </tr>
            <tr>
                <td style="border-left: 1px solid #000000" align="center" valign=middle></td>
                <td align="center" valign=middle></td>
                <td align="center" valign=middle></td>
                <td style="border-right: 1px solid #000000" align="center" valign=middle></td>
                <td align="left" valign=bottom></td>
                <td style="border-top: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" colspan=2 align="center" valign=middle>
                    <b>
                        <font size=1>
                            <?php echo ($QtdeParc > 1) ? 'PARCELAS' : 'PARCELA'; ?></font>
                    </b>
                </td>
                <?php
                if ($VrParcial > 0) {
                ?>
                    <td align="left" valign=bottom></td>
                    <td style="border-top: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" colspan=3 align="center" valign=middle>
                        <b>
                            <font size=1>PARCELA PARCIAL</font>
                        </b>
                    </td>
                <?php
                }

                if ($VrParcial > 0.00) {
                ?>
                    <td align="left" valign=bottom></td>
                    <td style="border-top: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" colspan=2 align="center" valign=middle>
                        <b>
                            <font size=1>PARCIAL</font>
                        </b>
                    </td>
                <?php
                }
                ?>
            </tr>
            <tr>
                <?php
                if ($QtdeParc > 0) {
                ?>
                    <td style="border-left: 1px solid #000000" align="center" valign=middle></td>
                    <td align="center" valign=middle></td>
                    <td align="center" valign=middle></td>
                    <td style="border-right: 1px solid #000000" align="center" valign=middle></td>
                    <td align="left" valign=bottom></td>
                    <td style="border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" colspan=2 align="center" valign=middle>
                        <font size=1>
                            <?php
                            $pini = (int)$PIni;
                            $pult = (int)$PUlt;
                            if ($pult >= $pini && $pini > 0) {
                                $arr = [];
                                for ($i = $pini; $i <= $pult; $i++) {
                                    $arr[] = $i . "ª";
                                }
                                echo implode(', ', $arr);
                            } else {
                                echo $PIni;
                            }
                            ?></font>
                    </td>
                <?php
                }
                if ($VrParcial > 0.00) {
                ?>
                    <td align="left" valign=bottom></td>
                    <td style="border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" colspan=3 align="center" valign=middle>
                        <font size=1><?php echo $PUlt + 1; ?>ª</font>
                    </td>
                <?php
                }
                if ($VrParcial > 0.00) {
                ?>
                    <td align="left" valign=bottom></td>
                    <td style="border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" colspan=2 align="center" valign=middle>
                        <font size=1><?php echo "R$ " .  $VrParcialF; ?></font>
                    </td>
                <?php
                }
                ?>
                <td align="left" valign=bottom></td>
            </tr>
            <tr>
                <td style="border-left: 1px solid #000000" height="4" align="left" valign=bottom></td>
                <td align="center" valign=middle></td>
                <td align="center" valign=middle></td>
                <td style="border-right: 1px solid #000000" height="4" align="left" valign=bottom></td>
            </tr>
            <tr>
                <td style="border-left: 1px solid #000000" align="center" valign=middle></td>
                <td align="center" valign=middle></td>
                <td align="center" valign=middle></td>
                <td style="border-right: 1px solid #000000" align="center" valign=middle></td>
                <td align="left" valign=bottom></td>
                <?php

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
                    } elseif ($FPag == 31) {
                        $ModPag = "CARTÃO CRÉDITO PARCELADO LOJA";
                    }

                ?>
                    <td style="border-top: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" colspan=2 align="center" valign=middle>
                        <b>
                            <font size=1><?php echo $ModPag; ?></font>
                        </b>
                    </td>
                    <td align="left" valign=bottom></td>
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
                    } elseif ($FPag == 31) {
                        $ModPag = "CARTÃO CRÉDITO PARCELADO LOJA";
                    }

                ?>
                    <td style="border-top: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" colspan=3 align="center" valign=middle>
                        <b>
                            <font size=1><?php echo $ModPag; ?></font>
                        </b>
                    </td>
                    <td align="left" valign=bottom></td>
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
                    } elseif ($FPag == 31) {
                        $ModPag = "CARTÃO CRÉDITO PARCELADO LOJA";
                    }

                ?>
                    <td style="border-top: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" colspan=2 align="center" valign=middle>
                        <b>
                            <font size=1><?php echo $ModPag; ?></font>
                        </b>
                    </td>
                <?php
                }
                ?>
            <tr>
                <td style="border-left: 1px solid #000000" align="center" valign=middle></td>
                <td align="center" valign=middle></td>
                <td align="center" valign=middle></td>
                <td style="border-right: 1px solid #000000" align="center" valign=middle></td>
                <td align="left" valign=bottom></td>

                <?php
                // Valor 1
                if (!empty($FPags[0]) && $FPags[0] !== "00") {
                    $Vlr = $Vlrs[0];
                    $VlrF = number_format($Vlr, 2, ',', '.');
                ?>
                    <td style="border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" colspan=2 align="center" valign=middle>
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
                    <td style="border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" colspan=3 align="center" valign=middle>
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
                    <td style="border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" colspan=2 align="center" valign=middle>
                        <font size=1 color="#000000"><?php echo "R$ " .  $VlrF; ?></font>
                    </td>
                <?php
                }
                ?>
            </tr>
            <tr>
                <td style="border-top: 1px solid #000000" align="center" valign=middle></td>
                <td style="border-top: 1px solid #000000" align="center" valign=middle></td>
                <td style="border-top: 1px solid #000000" align="center" valign=middle></td>
                <td style="border-top: 1px solid #000000" align="center" valign=middle></td>
                <td height="4" align="left" valign=bottom></td>
            </tr>
            <tr>
                <td style="border-top: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" colspan=14 height="11" align="left" valign=middle>
                    <b>
                        <font size=1>RECEBEMOS</font>
                    </b>
                </td>
            </tr>
            <tr>
                <td style="border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" colspan=14 height="17" align="center" valign=middle>
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
                <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" colspan=14 height="26" align="center" valign=middle>
                    <font size=1><?php echo $Reg . $PC . $horaaut . $NDoc . $dtAut . $Parc_Card_Cred . $SgRec . $FmRec . $VrTotF . $Mat; ?></font>
                </td>
            </tr>
            <tr>
                <td height="4" align="left" valign=bottom></td>
            </tr>
            <tr>
                <td height="4" align="left" valign=bottom></td>
            </tr>
            <tr>
                <td colspan=14 height="26" align="center" valign=middle>
                    <font size=1>------------------------------------------------------------------------------------------------------------------------------------------------------------------</font>
                </td>
            </tr>

            <?php

            // Verifica se é uma quitação e pedido de venda para exibir a terceira via  
            if ($Rdopt != '' && $Pedido != '' && $tipo_2 != '') {
            ?>
                <!-- Primeira via -->
                <tr>
                    <td height="17" align="left" valign=bottom><br></td>
                    <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000"
                        colspan=3 rowspan=2 align="center" valign=middle>
                        <b>
                            <font size=4><?php echo $tipo_2 . " " . $Rdopt; ?></font>
                        </b>
                    </td>
                    <td align="left" valign=bottom><br></td>
                    <td style="border-top: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000"
                        colspan=2 align="center" valign=middle>
                        <b>
                            <font size=1>SOLICITAÇÃO</font>
                        </b>
                    </td>
                    <td align="left" valign=bottom></td>
                    <td style="border-top: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="center" valign=middle>
                        <b>
                            <font size=1>PC</font>
                        </b>
                    </td>
                    <td align="center" valign=middle></td>
                    <td style="border-top: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="center" valign=middle>
                        <b>
                            <font size=1>REF.</font>
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
                    <td height="5" align="left" valign=bottom></td>
                    <td align="left" valign=bottom><br></td>
                    <td style="border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000"
                        colspan=2 align="center" valign=middle>
                        <font size=1><?php echo $NDoc; ?></font>
                    </td>
                    <td align="left" valign=bottom></td>
                    <td style="border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="center" valign=middle>
                        <font size=1><?php echo $PC; ?></font>
                    </td>
                    <td align="center" valign=middle></td>
                    <td style="border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="center" valign=middle>
                        <font size=1>
                            <?php
                            if ($PC == $Ref_Std) {
                                echo " --- ";
                            } else {
                                echo $Ref_Std;
                            }
                            ?>
                        </font>
                    </td>
                    <td align="left" valign=bottom></td>
                    <td style="border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000"
                        colspan=2 align="center" valign=middle>
                        <font size=1><?php echo "R$ " . $VrRecF; ?></font>
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
                    <td align="left" valign=bottom></td>
                    <td style="border-top: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000"
                        colspan=2 align="center" valign=middle>
                        <b>
                            <font size=1>DATA</font>
                        </b>
                    </td>
                    <td align="left" valign=bottom></td>
                    <td style="border-top: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" 
                    colspan=3 align="center" valign=middle>
                        <b>
                            <font size=1>VENDEDORA</font>
                        </b>
                    </td>
                    <td align="left" valign=bottom></td>
                    <td style="border-top: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" 
                    colspan=2 align="center" valign=middle>
                        <b>
                            <font size=1>PEDIDO</font>
                        </b>
                    </td>
                    <td align="left" valign=bottom></td>
                </tr>
                <tr>
                    <td align="left" valign=bottom></td>
                    <td style="border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" 
                    colspan=2 align="center" valign=middle>
                        <font size=1>
                            <?php echo $data; ?>
                        </font>
                    </td>
                    <td align="left" valign=bottom></td>
                    <td style="border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" 
                    colspan=3 align="center" valign=middle>
                        <font size=1>
                            <?php echo $Vendedora . " - " . $Mat_Vend; ?>
                        </font>
                    </td>
                    <td align="left" valign=bottom></td>
                    <td style="border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" 
                    colspan=2 align="center" valign=middle>
                        <font size=1>
                            <?php echo $Pedido; ?>
                        </font>
                    </td>
                </tr>
                <tr>
                    <td height="4" align="left" valign=bottom></td>
                </tr>
                <tr>
                    <td align="left" valign=bottom><font size=1><br></font></td>
                    <td align="left" valign=bottom><font size=1><br></font></td>
                    <td align="left" valign=bottom><font size=1><br></font></td>
                    <td align="left" valign=middle><font size=1><br></font></td>
                    <td align="left" valign=bottom><font size=1><br></font></td>
                    <td align="left" valign=middle><font size=1><br></font></td>
                    <td align="left" valign=bottom><font size=1><br></font></td>
                </tr>
                <tr>
                    <td align="left" valign=bottom><font size=1><br></font></td>
                    <td align="left" valign=bottom><font size=1><br></font></td>
                    <td align="left" valign=bottom><font size=1><br></font></td>
                    <td align="left" valign=middle><font size=1><br></font></td>
                    <td align="left" valign=bottom><font size=1><br></font></td>
                    <td align="left" valign=middle><font size=1><br></font></td>
                    <td align="left" valign=bottom><font size=1><br></font></td>
                </tr>
                <tr>
                    <td height="4" align="left" valign=bottom></td>
                </tr>
            <tr>
                <td style="border-top: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" colspan=14 height="11" align="left" valign=middle>
                    <b>
                        <font size=1>RECEBEMOS</font>
                    </b>
                </td>
            </tr>
            <tr>
                <td style="border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" colspan=14 height="17" align="center" valign=middle>
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
                <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" colspan=14 height="26" align="center" valign=middle>
                    <font size=1><?php echo $Reg . $PC . $horaaut . $NDoc . $dtAut . $Parc_Card_Cred . $SgRec . $FmRec . $VrTotF . $Mat; ?></font>
                </td>
            </tr>
            <tr>
                <td height="4" align="left" valign=bottom></td>
            </tr>
            <tr>
                <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" colspan=14 height="23" align="center" valign=middle>
                    <b>
                        <font size=4>(VIA TESOURARIA)</font>
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
            <?php

            }

            ?>
        </table>
    </div>
</body>

</html>