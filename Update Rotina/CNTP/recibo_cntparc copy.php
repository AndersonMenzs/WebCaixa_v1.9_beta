<?php

// Debug
error_reporting(E_ALL);
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);

/*$dados = filter_input_array(INPUT_GET, FILTER_DEFAULT);
echo "<pre>";
var_dump($dados);
echo "</pre>";
exit();*/

// Variáveis do $_GET
$Reg       = trim($_GET['Reg']);
$NDoc       = trim($_GET['NDoc']);
$Mat       = trim($_GET['mat']);
$Mat = substr_replace($Mat, "-", -1, 0);
$PIni       = trim($_GET['PIni']);
$PC         = trim($_GET['PC']);
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
$VrRec     = trim($_GET['VrRec']);
$VrRecF     = number_format($VrRec, 2, ",", ".");
$VrRecA = number_format($VrRec, 2, "", "");
$VrPrest     = trim($_GET['VrPrest']);
$VrPrestF     = number_format($VrPrest, 2, ",", ".");
$VrParcial     = trim($_GET['VrParcial']);
$VrParcialF     = number_format($VrParcial, 2, ",", ".");
$vlr_ext   = trim($_GET['vlr_ext']);
$FPag     = trim($_GET['FPag_1']);
$PIni = trim($_GET['PIni']);
$PUlt = trim($_GET['PUlt']);

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
            top: 310px;
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
            top: 42px;
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
            top: 120px;
            left: 22px;
            width: 260px;
            /* Largura original */
            height: 520px;
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

<body onload="window.print()">
    <div class="container">
        <img src="./images/logo.png" alt="Imagem" class="imagem_via1">
        <img src="./images/logo.png" alt="Imagem" class="imagem_via2">
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
                        <font size=1>CONTRATO</font>
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

                <?php

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
                    $ModPag = "CART. CRED. PARC. LOJA";
                }

                ?>

                <td style="border-top: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000"
                    colspan=2 align="center" valign=middle>
                    <b>
                        <font size=1>VLR. PAGO - <?php echo $ModPag; ?></font>
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
                    <font size=1><?php echo "R$ " . $VrRecF; ?></font>
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
                    colspan=2 align="center" valign=middle>
                    <b>
                        <font size=1>VENDEDORA</font>
                    </b>
                </td>
                <td align="left" valign=bottom>
                    <font size=1><br></font>
                </td>
                <td style="border-top: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000"
                    colspan=2 align="center" valign=middle>
                    <b>
                        <font size=1>VLR. PRESTAÇÃO</font>
                    </b>
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
                    <font size=1><?php echo $Vendedora . " - " . $Mat_Vend; ?></font>
                </td>
                <td align="left" valign=bottom>
                    <font size=1><br></font>
                </td>
                <td style="border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" colspan=2 align="center" valign=middle>
                    <font size=1><?php echo "R$ " . $VrPrestF; ?></font>
                </td>
            </tr>
            <tr>
                <td height="4" align="left" valign=bottom></td>
            </tr>
            <tr>
                <td align="left" valign=bottom>
                    <font size=1><br></font>
                </td>
                <td style="border-top: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" colspan=2 align="center" valign=middle>
                    <b>
                        <font size=1>
                            <?php echo ($QtdeParc > 1) ? 'PARCELAS' : 'PARCELA'; ?>
                        </font>
                    </b>
                </td>
                <?php
                if ($QtdeParc > 1) {
                ?>
                    <td align="left" valign=bottom>
                        <font size=1><br></font>
                    </td>
                    <td style="border-top: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" colspan=2 align="center" valign=middle><b>
                            <font size=1>PARCIAL PARCELA</font>
                        </b>
                    </td>
                <?php
                }

                if ($VrParcial > 0) {
                ?>

                    <td align="left" valign=bottom>
                        <font size=1><br></font>
                    </td>
                    <td style="border-top: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" colspan=2 align="center" valign=middle><b>
                            <font size=1>PARCIAL</font>
                        </b>
                    </td>
                <?php
                }
                ?>
                <td align="left" valign=bottom>
                    <font size=1><br></font>
                </td>
            </tr>
            <tr>
                <?php
                if ($QtdeParc > 0) {
                ?>
                    <td align="left" valign=bottom>
                        <font size=1><br></font>
                    </td>
                    <td style="border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" colspan=2 align="center" valign=middle sdval="500" sdnum="1046;0;[$R$-416] #.##0,00;[RED]-[$R$-416] #.##0,00">
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
                if ($QtdeParc > 1) {
                ?>
                <td align="left" valign=bottom>
                    <font size=1><br></font>
                </td>
                <td style="border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" colspan=2 align="center" valign=middle sdval="1000" sdnum="1046;0;[$R$-416] #.##0,00;[RED]-[$R$-416] #.##0,00">
                    <font size=1><?php echo $PUlt + 1; ?>ª</font>
                </td>
                <?php
                }
                if ($VrParcial > 1) {
                ?>
                    <td align="left" valign=bottom>
                        <font size=1><br></font>
                    </td>
                    <td style="border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" colspan=2 align="center" valign=middle sdval="0" sdnum="1046;0;[$R$-416] #.##0,00;[RED]-[$R$-416] #.##0,00">
                        <font size=1 color="#000000"><?php echo "R$ " .  $VrParcialF; ?></font>
                    </td>
                <?php
                }
                ?>
                <td align="left" valign=bottom>
                    <font size=1><br></font>
                </td>
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
                    <font size=1><?php echo $Reg . $PC . $horaaut . $NDoc . $dtAut . $SgRec . $FmRec . $VrRecA . $Mat; ?></font>
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

            <!-- Segunda Via -->
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
                        <font size=1>CONTRATO</font>
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

                <?php

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

                <td style="border-top: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000"
                    colspan=2 align="center" valign=middle>
                    <b>
                        <font size=1>VLR. PAGO - <?php echo $ModPag; ?></font>
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
                    <font size=1><?php echo "R$ " . $VrRecF; ?></font>
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
                    colspan=2 align="center" valign=middle>
                    <b>
                        <font size=1>VENDEDORA</font>
                    </b>
                </td>
                <td align="left" valign=bottom>
                    <font size=1><br></font>
                </td>
                <td style="border-top: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000"
                    colspan=2 align="center" valign=middle>
                    <b>
                        <font size=1>VLR. PRESTAÇÃO</font>
                    </b>
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
                    <font size=1><?php echo $Vendedora . " - " . $Mat_Vend; ?></font>
                </td>
                <td align="left" valign=bottom>
                    <font size=1><br></font>
                </td>
                <td style="border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" colspan=2 align="center" valign=middle>
                    <font size=1><?php echo "R$ " . $VrPrestF; ?></font>
                </td>
            </tr>
            <tr>
                <td height="4" align="left" valign=bottom></td>
            </tr>
            <tr>
                <td align="left" valign=bottom>
                    <font size=1><br></font>
                </td>
                <td style="border-top: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" colspan=2 align="center" valign=middle>
                    <b>
                        <font size=1>
                            <?php echo ($QtdeParc > 1) ? 'PARCELAS' : 'PARCELA'; ?>
                        </font>
                    </b>
                </td>
                <?php
                if ($QtdeParc > 1) {
                ?>
                    <td align="left" valign=bottom>
                        <font size=1><br></font>
                    </td>
                    <td style="border-top: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" colspan=2 align="center" valign=middle><b>
                            <font size=1>PARCIAL PARCELA</font>
                        </b>
                    </td>
                <?php
                }

                if ($VrParcial > 0) {
                ?>

                    <td align="left" valign=bottom>
                        <font size=1><br></font>
                    </td>
                    <td style="border-top: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" colspan=2 align="center" valign=middle><b>
                            <font size=1>PARCIAL</font>
                        </b>
                    </td>
                <?php
                }
                ?>
                <td align="left" valign=bottom>
                    <font size=1><br></font>
                </td>
            </tr>
            <tr>
                <?php
                if ($QtdeParc > 0) {
                ?>
                    <td align="left" valign=bottom>
                        <font size=1><br></font>
                    </td>
                    <td style="border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" colspan=2 align="center" valign=middle sdval="500" sdnum="1046;0;[$R$-416] #.##0,00;[RED]-[$R$-416] #.##0,00">
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
                if ($QtdeParc > 1) {
                ?>
                <td align="left" valign=bottom>
                    <font size=1><br></font>
                </td>
                <td style="border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" colspan=2 align="center" valign=middle sdval="1000" sdnum="1046;0;[$R$-416] #.##0,00;[RED]-[$R$-416] #.##0,00">
                    <font size=1><?php echo $PUlt + 1; ?>ª</font>
                </td>
                <?php
                }
                if ($VrParcial > 1) {
                ?>
                    <td align="left" valign=bottom>
                        <font size=1><br></font>
                    </td>
                    <td style="border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" colspan=2 align="center" valign=middle sdval="0" sdnum="1046;0;[$R$-416] #.##0,00;[RED]-[$R$-416] #.##0,00">
                        <font size=1 color="#000000"><?php echo "R$ " .  $VrParcialF; ?></font>
                    </td>
                <?php
                }
                ?>
                <td align="left" valign=bottom>
                    <font size=1><br></font>
                </td>
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
                    <font size=1><?php echo $Reg . $PC . $horaaut . $NDoc . $dtAut . $SgRec . $FmRec . $VrRecA . $Mat; ?></font>
                </td>
            </tr>
            <tr>
                <td colspan=13 height="15" align="center" valign=middle>
                    <font size=1>------------------------------------------------------------------------------------------------------------------------------------------------------------------</font>
                </td>
            </tr>
        </table>
    </div>
</body>

</html>