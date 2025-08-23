<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">

<html>

<head>

    <meta http-equiv="content-type" content="text/html; charset=utf-8" />
    <title>Carnê</title>
    <meta name="generator" content="LibreOffice 7.0.4.2 (Linux)" />
    <meta name="created" content="2022-11-08T08:49:58.126407801" />
    <meta name="changed" content="2024-01-17T17:23:16.843719506" />

    <style type="text/css">
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
            font-family: "Liberation Sans";
            font-size: x-small;
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

        .bto {
            padding: 1%;
            background: #dedede;
            margin-bottom: 1%;
            border-bottom: 1px solid #ccc;
        }

        .bto a,
        .bto button {
            padding: 9px;
            border: 0;
            cursor: pointer;
            text-decoration: none;
            font-size: 1em;
        }

        .bto .btn-impress {
            color: #fff;
            background: green;
        }

        .bto .btn {
            color: #555;
            background: transparent;
        }

        .nome {
            /* Nome no carnê */
            padding-top: 2%;
            font-size: .7em;
        }


        @media print {

            .bto {
                display: none;
            }

            .quebra-pagina {
                page-break-after: auto;
            }

            @page {
                /*margin: 1.18cm;*/
                margin-top: 1mm;
                margin-left: 1cm;
                margin-right: 0;
                margin-bottom: 2cm;
            }
        }
    </style>
</head>

<body>

    <?php
    // Obtendo o Login
    $Sis     = "S7";
    $Rot     = "S7R2.4.1.1";
    $lg_user = $_REQUEST['c_s'];
    $user = substr($lg_user, 0, 8);
    $pss  = substr($lg_user, 8, 40);
    $cpf  = substr($lg_user, 52, 11);

    $razao_social        = "ESTRELLA PHOTO STUDIO";
    $cnpj                = "02.708.080/0001-60";

    $hoje       = date("d/m/Y");

    // Conexão
    include './conexao.php';
    include './dbselect.php';

    // Consulta cpf do cliente para o carne
    $sql = "SELECT * FROM contratos_carnes WHERE cpf_cliente = '$cpf' AND DATE(dt_criada) = CURDATE() ORDER BY dt_criada DESC LIMIT 1";
    $rs = mysqli_query($conec, $sql);
    $regs = mysqli_num_rows($rs);
    $ln = mysqli_fetch_array($rs);

    $num_carne          = $ln['cod_carne'];
    $cpf_cliente        = $ln['cpf_cliente'];
    $nome_cli           = $ln['cliente'];
    $nome_mod           = $ln['modelo'];
    $nome_produto       = $ln['nome_produto'];
    $vlr_total          = $ln['vlr_total'];
    $vlr_entrada        = $ln['vlr_entrada'];
    $vlr_parcela        = $ln['vlr_parcela'];
    $vlr_prest_ini_1    = $ln['vlr_prest_ini_1'];
    $vlr_prest_ini_2    = $ln['vlr_prest_ini_2'];
    $qtd_parcela        = $ln['qtd_parcela'];
    $dt_venc_prest_ini_1  = $ln['dt_primeira_parcela'];
    $dt_venc_prest_ini_2  = $ln['dt_segunda_parcela'];
    $cod_vendor         = $ln['vendor'];
    $nome_vendor        = $ln['nome_vendor'];
    $cod_caixa          = $ln['caixa'];
    $cod_pc             = $ln['cod_pc'];

    // Calcular útimo dia de vencimento
    $qtd_parc = $qtd_parcela - 2;
    $dt_ult_venc = date('d/m/Y', strtotime($dt_venc_prest_ini_2 . " +$qtd_parc  months"));

    // Formatar cpf
    $cpf_cliente = substr_replace(substr_replace(substr_replace($cpf_cliente, '.', 3, 0), '.', 7, 0), '-', 11, 0);

    // Formatar valor
    $vlr_total = number_format($vlr_total, 2, ',', '.');
    $vlr_entrada = number_format($vlr_entrada, 2, ',', '.');
    $vlr_parcela = number_format($vlr_parcela, 2, ',', '.');
    $vlr_prest_ini_1 = number_format($vlr_prest_ini_1, 2, ',', '.');
    $vlr_prest_ini_2 = number_format($vlr_prest_ini_2, 2, ',', '.');

    ?>

    <div class="bto">
        Ao Imprimir o carnê certifique-se se a impressão está ajustada à página
        <br>
        <br>
        <button class="btn-impress" onclick="window.print()">Imprimir</button>
        &nbsp;
        <button><a class="btn-impress" href="servrec.php?c_s=<?php echo substr($lg_user, 0, 48); ?>">Recebimento</a></button>
        &nbsp;
        <button class="btn-impress" href="carneform.php?c_s=<?php echo $lg_user; ?>">Voltar ao formulário</button>
    </div>
    <br>

    <!-- Entrada -->
    <table cellspacing="0" border="0">
        <colgroup width="25"></colgroup>
        <colgroup width="66"></colgroup>
        <colgroup span="2" width="23"></colgroup>
        <colgroup width="50"></colgroup>
        <colgroup width="10"></colgroup>
        <colgroup width="85"></colgroup>
        <colgroup width="94"></colgroup>
        <colgroup width="83"></colgroup>
        <colgroup width="98"></colgroup>
        <colgroup width="85"></colgroup>
        <colgroup width="45"></colgroup>
        <tr>
            <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 0px solid #000000" colspan=2 rowspan=2 height="30" align="center" valign=middle><b>
                    <font size=1>Nº Carnê</font>
                </b></td>
            <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" colspan=3 rowspan=2 align="center" valign=middle><b><?php echo $num_carne; ?></b></td>
            <td align="left" valign=middle>
                <font size=1><br></font>
            </td>
            <td style="border-top: 1px solid #000000; border-left: 1px solid #000000; border-right: 0px solid #000000" align="left" valign=middle><b>
                    <font size=1> PC</font>
                </b></td>
            <td style="border-top: 1px solid #000000; border-left: 1px solid #000000; border-right: 0px solid #000000" align="left" valign=middle><b>
                    <font size=1> Cód. Vendora</font>
                </b></td>
            <td style="border-top: 1px solid #000000; border-left: 1px solid #000000; border-right: 0px solid #000000" align="left" valign=middle><b>
                    <font size=1> Cód. Caixa</font>
                </b></td>
            <td style="border-top: 1px solid #000000; border-left: 1px solid #000000; border-right: 0px solid #000000" align="left" valign=middle><b>
                    <font size=1> CPF</font>
                </b></td>
            <td style="border-top: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" colspan=2 align="left" valign=middle><b>
                    <font size=1> Nº do Carnê</font>
                </b></td>
        </tr>
        <tr>
            <td align="left" valign=middle>
                <font size=1><br></font>
            </td>
            <td style="border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 0px solid #000000" align="center" valign=middle sdval="206" sdnum="1046;">
                <font size=1><?php echo $cod_pc; ?></font>
            </td>
            <td style="border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 0px solid #000000" align="center" valign=middle>
                <font size=1><?php echo $cod_vendor . " – " . $nome_vendor; ?></font>
            </td>
            <td style="border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 0px solid #000000" align="center" valign=middle sdval="5449" sdnum="1046;">
                <font size=1><?php echo $cod_caixa; ?></font>
            </td>
            <td style="border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 0px solid #000000" align="center" valign=middle>
                <font size=1><?php echo $cpf_cliente; ?></font>
            </td>
            <td style="border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" colspan=2 align="center" valign=middle><b><?php echo $num_carne; ?></b></td>
        </tr>
        <tr>
            <td style="border-top: 0px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 0px solid #000000" colspan=2 rowspan=2 height="30" align="center" valign=middle><b>
                    <font size=1>Dt. Venc.</font>
                </b></td>
            <td style="border-top: 0px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" colspan=3 rowspan=2 align="center" valign=middle><?php echo $hoje; ?></td>
            <td align="left" valign=middle>
                <font size=1><br></font>
            </td>
            <td style="border-top: px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" colspan=6 align="left" valign=middle><b>
                    <font size=1> Nome Cliente</font>
                </b></td>
        </tr>
        <tr>
            <td align="left" valign=middle>
                <font size=1><br></font>
            </td>
            <td style="border-bottom: 0px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" colspan=6 align="left" valign=middle>
                <font size=1><?php echo $nome_cli; ?></font>
            </td>
        </tr>
        <tr>
            <td style="border-top: 0px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 0px solid #000000" colspan=2 rowspan=2 height="30" align="center" valign=middle><b>
                    <font size=1>Dt. Últ. Venc.</font>
                </b></td>
            <td style="border-top: 0px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" colspan=3 rowspan=2 align="center" valign=middle><?php echo $dt_ult_venc; ?></td>
            <td align="left" valign=middle>
                <font size=1><br></font>
            </td>
            <td style="border-top: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" colspan=6 align="left" valign=middle><b>
                    <font size=1> Nome Modelo</font>
                </b></td>
        </tr>
        <tr>
            <td align="left" valign=middle>
                <font size=1><br></font>
            </td>
            <td style="border-bottom: 0px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" colspan=6 align="left" valign=middle>
                <font size=1><?php echo $nome_mod; ?></font>
            </td>
        </tr>
        <tr>
            <td style="border-top: 0px solid #000000; border-bottom: 0px solid #000000; border-left: 1px solid #000000; border-right: 0px solid #000000" colspan=2 height="15" align="center" valign=middle><b>
                    <font size=1>PC</font>
                </b></td>
            <td style="border-top: 0px solid #000000; border-bottom: 0px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" colspan=3 align="center" valign=middle sdval="206" sdnum="1046;">
                <font size=1><?php echo $cod_pc; ?></font>
            </td>
            <td align="left" valign=middle>
                <font size=1><br></font>
            </td>
            <td style="border-top: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" colspan=6 align="left" valign=middle><b>
                    <font size=1> Pacote Fotográfico</font>
                </b></td>
        </tr>
        <tr>
            <td style="border-top: 1px solid #000000; border-bottom: 0px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" colspan=5 rowspan=2 height="30" align="center" valign=middle><b>
                    <font size=1>Estrella Photo Estúdio</font>
                </b></td>
            <td align="left" valign=middle>
                <font size=1><br></font>
            </td>
            <td style="border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" colspan=6 align="left" valign=middle>
                <font size=1><?php echo $nome_produto; ?></font>
            </td>
        </tr>
        <tr>
            <td align="left" valign=middle>
                <font size=1><br></font>
            </td>
            <td style="border-top: 0px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="left" valign=middle><b>
                    <font size=1> Vl. Compra</font>
                </b></td>
            <td align="center" valign=middle><b>
                    <font size=1>Vl. Entrada</font>
                </b></td>
            <td style="border-top: 0px solid #000000; border-left: 1px solid #000000; border-right: 0px solid #000000" rowspan=2 align="center" valign=middle><b>
                    <font size=1>ENTRADA</font>
                </b></td>
            <td style="border-top: 0px solid #000000; border-left: 1px solid #000000; border-right: 0px solid #000000" align="left" valign=middle><b>
                    <font size=1> Vl. Prest.</font>
                </b></td>
            <td style="border-top: 0px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" colspan=2 align="left" valign=middle><b>
                    <font size=1> Dt. Venc.</font>
                </b></td>
        </tr>
        <tr>
            <td style="border-top: 1px solid #000000; border-bottom: 0px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" colspan=5 rowspan=2 height="32" align="center" valign=middle>
                <font size=1>CNPJ <?php echo $cnpj; ?></font>
            </td>
            <td align="left" valign=middle>
                <font size=1><br></font>
            </td>
            <td style="border-bottom: 0px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="center" valign=middle>R$ <?php echo $vlr_total; ?></td>
            <td align="center" valign=middle>R$ <?php echo $vlr_entrada; ?></td>
            <td style="border-bottom: 0px solid #000000; border-left: 1px solid #000000; border-right: 0px solid #000000" align="center" valign=middle>R$ --- </td>
            <td style="border-bottom: 0px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" colspan=2 align="center" valign=middle><?php echo $hoje; ?></td>
        </tr>
        <tr>
            <td align="left" valign=middle>
                <font size=1><br></font>
            </td>
            <td style="border-top: 1px solid #000000; border-left: 1px solid #000000; border-right: 0px solid #000000" colspan=2 align="left" valign=middle><b>
                    <font size=1> Dt. Emissão</font>
                </b></td>
            <td style="border-top: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" colspan=4 rowspan=2 align="center" valign=middle>
                <font size=1><br></font>
            </td>
        </tr>
        <tr>
            <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" colspan=5 rowspan=4 height="62" align="center" valign=middle><b>
                    <font size=6>ENTRADA</font>
                </b></td>
            <td align="left" valign=middle>
                <font size=1><br></font>
            </td>
            <td style="border-bottom: 0px solid #000000; border-left: 1px solid #000000; border-right: 0px solid #000000" colspan=2 align="center" valign=middle>
                <font size=1><?php echo $hoje; ?></font>
            </td>
        </tr>
        <tr>
            <td align="left" valign=middle>
                <font size=1><br></font>
            </td>
            <td style="border-top: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" colspan=6 rowspan=2 align="center" valign=middle><b>
                    <font size=1> MANTENHA OS SEUS PAGAMENTOS EM DIA, PARA EVITAR MULTAS E JUROS</font>
                </b></td>
        </tr>
        <tr>
            <td align="left" valign=middle>
                <font size=1><br></font>
            </td>
        </tr>
        <tr>
            <td align="left" valign=middle>
                <font size=1><br></font>
            </td>
            <td style="border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" colspan=6 align="center" valign=middle>
                <font size=1>*** AUTENTICAÇÃO NO VERSO ***</font>
            </td>
        </tr>
        <tr>
            <td colspan=12 height="26" align="center" valign=top>
                <font size=1>…………………………………………………………………………………………………………………………………………………………………</font>
            </td>
        </tr>
    </table>

    <!-- Parcela 1 -->
    <table cellspacing="0" border="0">
        <colgroup width="25"></colgroup>
        <colgroup width="66"></colgroup>
        <colgroup span="2" width="23"></colgroup>
        <colgroup width="50"></colgroup>
        <colgroup width="10"></colgroup>
        <colgroup width="85"></colgroup>
        <colgroup width="94"></colgroup>
        <colgroup width="83"></colgroup>
        <colgroup width="98"></colgroup>
        <colgroup width="85"></colgroup>
        <colgroup width="45"></colgroup>
        <tr>
            <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 0px solid #000000" colspan=2 rowspan=2 height="30" align="center" valign=middle><b>
                    <font size=1>Nº Carnê</font>
                </b></td>
            <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" colspan=3 rowspan=2 align="center" valign=middle><b><?php echo $num_carne; ?></b></td>
            <td align="left" valign=middle>
                <font size=1><br></font>
            </td>
            <td style="border-top: 1px solid #000000; border-left: 1px solid #000000; border-right: 0px solid #000000" align="left" valign=middle><b>
                    <font size=1> PC</font>
                </b></td>
            <td style="border-top: 1px solid #000000; border-left: 1px solid #000000; border-right: 0px solid #000000" align="left" valign=middle><b>
                    <font size=1> Cód. Vendora</font>
                </b></td>
            <td style="border-top: 1px solid #000000; border-left: 1px solid #000000; border-right: 0px solid #000000" align="left" valign=middle><b>
                    <font size=1> Cód. Caixa</font>
                </b></td>
            <td style="border-top: 1px solid #000000; border-left: 1px solid #000000; border-right: 0px solid #000000" align="left" valign=middle><b>
                    <font size=1> CPF</font>
                </b></td>
            <td style="border-top: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" colspan=2 align="left" valign=middle><b>
                    <font size=1> Nº do Carnê</font>
                </b></td>
        </tr>
        <tr>
            <td align="left" valign=middle>
                <font size=1><br></font>
            </td>
            <td style="border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 0px solid #000000" align="center" valign=middle sdval="206" sdnum="1046;">
                <font size=1><?php echo $cod_pc; ?></font>
            </td>
            <td style="border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 0px solid #000000" align="center" valign=middle>
                <font size=1><?php echo $cod_vendor . " – " . $nome_vendor; ?></font>
            </td>
            <td style="border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 0px solid #000000" align="center" valign=middle>
                <font size=1><?php echo $cod_caixa; ?></font>
            </td>
            <td style="border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 0px solid #000000" align="center" valign=middle>
                <font size=1><?php echo $cpf_cliente; ?></font>
            </td>
            <td style="border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" colspan=2 align="center" valign=middle><b><?php echo $num_carne; ?></b></td>
        </tr>
        <tr>
            <td style="border-top: 0px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 0px solid #000000" colspan=2 rowspan=2 height="30" align="center" valign=middle><b>
                    <font size=1>Dt. Venc.</font>
                </b></td>
            <td style="border-top: 0px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" colspan=3 rowspan=2 align="center" valign=middle>
                <?php echo date('d/m/Y', strtotime($dt_venc_prest_ini_1)); ?></td>
            <td align="left" valign=middle>
                <font size=1><br></font>
            </td>
            <td style="border-top: 0px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" colspan=6 align="left" valign=middle><b>
                    <font size=1> Nome Cliente</font>
                </b></td>
        </tr>
        <tr>
            <td align="left" valign=middle>
                <font size=1><br></font>
            </td>
            <td style="border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" colspan=6 align="left" valign=middle>
                <font size=1><?php echo $nome_cli; ?></font>
            </td>
        </tr>
        <tr>
            <td style="border-top: 0px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 0px solid #000000" colspan=2 rowspan=2 height="30" align="center" valign=middle><b>
                    <font size=1>Dt. Últ. Venc.</font>
                </b></td>
            <td style="border-top: 0px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" colspan=3 rowspan=2 align="center" valign=middle><?php echo $dt_ult_venc; ?></td>
            <td align="left" valign=middle>
                <font size=1><br></font>
            </td>
            <td style="border-top: 0px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" colspan=6 align="left" valign=middle><b>
                    <font size=1> Nome Modelo</font>
                </b></td>
        </tr>
        <tr>
            <td align="left" valign=middle>
                <font size=1><br></font>
            </td>
            <td style="border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" colspan=6 align="left" valign=middle>
                <font size=1><?php echo $nome_mod; ?></font>
            </td>
        </tr>
        <tr>
            <td style="border-top: 0px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 0px solid #000000" colspan=2 height="15" align="center" valign=middle><b>
                    <font size=1>PC</font>
                </b></td>
            <td style="border-top: 0px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" colspan=3 align="center" valign=middle>
                <font size=1><?php echo $cod_pc; ?></font>
            </td>
            <td align="left" valign=middle>
                <font size=1><br></font>
            </td>
            <td style="border-top: 0px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" colspan=6 align="left" valign=middle><b>
                    <font size=1> Pacote Fotográfico</font>
                </b></td>
        </tr>
        <tr>
            <td style="border-top: 0px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" colspan=5 rowspan=2 height="30" align="center" valign=middle><b>
                    <font size=1>Estrella Photo Estúdio</font>
                </b></td>
            <td align="left" valign=middle>
                <font size=1><br></font>
            </td>
            <td style="border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" colspan=6 align="left" valign=middle>
                <font size=1><?php echo $nome_produto; ?></font>
            </td>
        </tr>
        <tr>
            <td align="left" valign=middle>
                <font size=1><br></font>
            </td>
            <td style="border-top: 0px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="left" valign=middle><b>
                    <font size=1> Vl. Compra</font>
                </b></td>
            <td align="left" valign=middle><b>
                    <font size=1> Vl. Entrada</font>
                </b></td>
            <td style="border-top: 0px solid #000000; border-left: 1px solid #000000; border-right: 0px solid #000000" align="left" valign=middle><b>
                    <font size=1> Nº Prest.</font>
                </b></td>
            <td style="border-top: 0px solid #000000; border-left: 1px solid #000000; border-right: 0px solid #000000" align="left" valign=middle><b>
                    <font size=1> Vl. Prest.</font>
                </b></td>
            <td style="border-top: 0px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" colspan=2 align="left" valign=middle><b>
                    <font size=1> Dt. Venc.</font>
                </b></td>
        </tr>
        <tr>
            <td style="border-top: 0px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" colspan=5 rowspan=2 height="30" align="center" valign=middle>
                <font size=1>CNPJ <?php echo $cnpj; ?></font>
            </td>
            <td align="left" valign=middle>
                <font size=1><br></font>
            </td>
            <td style="border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="center" valign=middle>R$ <?php echo $vlr_total; ?></td>
            <td style="border-bottom: 1px solid #000000; border-left: 0px solid #000000; border-right: 0px solid #000000" align="center" valign=middle>R$ <?php echo $vlr_entrada; ?></td>
            <td style="border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 0px solid #000000" align="center" valign=middle>1 / <?php echo $qtd_parcela; ?></td>
            <td style="border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 0px solid #000000" align="center" valign=middle>R$ <?php echo $vlr_prest_ini_1; ?></td>
            <td style="border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" colspan=2 align="center" valign=middle><?php echo date('d/m/Y', strtotime($dt_venc_prest_ini_1)); ?>
            </td>
        </tr>
        <tr>
            <td align="left" valign=middle>
                <font size=1><br></font>
            </td>
            <td style="border-top: 0px solid #000000; border-left: 1px solid #000000; border-right: 0px solid #000000" colspan=2 align="left" valign=middle><b>
                    <font size=1> Dt. Emissão</font>
                </b></td>
            <td style="border-top: 0px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" colspan=4 rowspan=2 align="center" valign=middle><b>
                    <font size=1> </font>
                </b></td>
        </tr>
        <tr>
            <td style="border-top: 0px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" colspan=5 height="15" align="left" valign=middle><b>
                    <font size=1> Nº Prestação</font>
                </b></td>
            <td align="left" valign=middle>
                <font size=1><br></font>
            </td>
            <td style="border-bottom: 0px solid #000000; border-left: 1px solid #000000; border-right: 0px solid #000000" colspan=2 align="center" valign=middle>
                <font size=1><?php echo $hoje; ?></font>
            </td>
        </tr>
        <tr>
            <td style="border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" colspan=5 rowspan=3 height="45" align="center" valign=middle sdnum="1046;0;DD/MM/AA"><b>
                    <font size=6>1 / <?php echo $qtd_parcela; ?></font>
                </b></td>
            <td align="left" valign=middle>
                <font size=1><br></font>
            </td>
            <td style="border-top: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" colspan=6 rowspan=2 align="center" valign=middle><b>
                    <font size=1> MANTENHA OS SEUS PAGAMENTOS EM DIA, PARA EVITAR MULTAS E JUROS</font>
                </b></td>
        </tr>
        <tr>
            <td align="left" valign=middle>
                <font size=1><br></font>
            </td>
        </tr>
        <tr>
            <td align="left" valign=middle>
                <font size=1><br></font>
            </td>
            <td style="border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" colspan=6 align="center" valign=middle>
                <font size=1>*** AUTENTICAÇÃO NO VERSO ***</font>
            </td>
        </tr>
        <tr>
            <td colspan=12 height="26" align="center" valign=top>
                <font size=1>……………………………………………………………………………………………………………………………………………………………………</font>
            </td>
        </tr>
    </table>

    <!-- Parcela 2 -->
    <table cellspacing="0" border="0">
        <colgroup width="25"></colgroup>
        <colgroup width="66"></colgroup>
        <colgroup span="2" width="23"></colgroup>
        <colgroup width="50"></colgroup>
        <colgroup width="10"></colgroup>
        <colgroup width="85"></colgroup>
        <colgroup width="94"></colgroup>
        <colgroup width="83"></colgroup>
        <colgroup width="98"></colgroup>
        <colgroup width="85"></colgroup>
        <colgroup width="45"></colgroup>
        <tr>
            <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 0px solid #000000" colspan=2 rowspan=2 height="30" align="center" valign=middle><b>
                    <font size=1>Nº Carnê</font>
                </b></td>
            <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" colspan=3 rowspan=2 align="center" valign=middle><b><?php echo $num_carne; ?></b></td>
            <td align="left" valign=middle>
                <font size=1><br></font>
            </td>
            <td style="border-top: 1px solid #000000; border-left: 1px solid #000000; border-right: 0px solid #000000" align="left" valign=middle><b>
                    <font size=1> PC</font>
                </b></td>
            <td style="border-top: 1px solid #000000; border-left: 1px solid #000000; border-right: 0px solid #000000" align="left" valign=middle><b>
                    <font size=1> Cód. Vendora</font>
                </b></td>
            <td style="border-top: 1px solid #000000; border-left: 1px solid #000000; border-right: 0px solid #000000" align="left" valign=middle><b>
                    <font size=1> Cód. Caixa</font>
                </b></td>
            <td style="border-top: 1px solid #000000; border-left: 1px solid #000000; border-right: 0px solid #000000" align="left" valign=middle><b>
                    <font size=1> CPF</font>
                </b></td>
            <td style="border-top: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" colspan=2 align="left" valign=middle><b>
                    <font size=1> Nº do Carnê</font>
                </b></td>
        </tr>
        <tr>
            <td align="left" valign=middle>
                <font size=1><br></font>
            </td>
            <td style="border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 0px solid #000000" align="center" valign=middle sdval="206" sdnum="1046;">
                <font size=1><?php echo $cod_pc; ?></font>
            </td>
            <td style="border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 0px solid #000000" align="center" valign=middle>
                <font size=1><?php echo $cod_vendor . " – " . $nome_vendor; ?></font>
            </td>
            <td style="border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 0px solid #000000" align="center" valign=middle sdval="5449" sdnum="1046;">
                <font size=1><?php echo $cod_caixa; ?></font>
            </td>
            <td style="border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 0px solid #000000" align="center" valign=middle>
                <font size=1><?php echo $cpf_cliente; ?></font>
            </td>
            <td style="border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" colspan=2 align="center" valign=middle><b><?php echo $num_carne; ?></b></td>
        </tr>
        <tr>
            <td style="border-top: 0px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 0px solid #000000" colspan=2 rowspan=2 height="30" align="center" valign=middle><b>
                    <font size=1>Dt. Venc.</font>
                </b></td>
            <td style="border-top: 0px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" colspan=3 rowspan=2 align="center" valign=middle>
                <?php echo date('d/m/Y', strtotime($dt_venc_prest_ini_2)); ?></td>
            <td align="left" valign=middle>
                <font size=1><br></font>
            </td>
            <td style="border-top: 0px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" colspan=6 align="left" valign=middle><b>
                    <font size=1> Nome Cliente</font>
                </b></td>
        </tr>
        <tr>
            <td align="left" valign=middle>
                <font size=1><br></font>
            </td>
            <td style="border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" colspan=6 align="left" valign=middle>
                <font size=1><?php echo $nome_cli; ?></font>
            </td>
        </tr>
        <tr>
            <td style="border-top: 0px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 0px solid #000000" colspan=2 rowspan=2 height="30" align="center" valign=middle><b>
                    <font size=1>Dt. Últ. Venc.</font>
                </b></td>
            <td style="border-top: 0px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" colspan=3 rowspan=2 align="center" valign=middle><?php echo $dt_ult_venc; ?></td>
            <td align="left" valign=middle>
                <font size=1><br></font>
            </td>
            <td style="border-top: 0px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" colspan=6 align="left" valign=middle><b>
                    <font size=1> Nome Modelo</font>
                </b></td>
        </tr>
        <tr>
            <td align="left" valign=middle>
                <font size=1><br></font>
            </td>
            <td style="border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" colspan=6 align="left" valign=middle>
                <font size=1><?php echo $nome_mod; ?></font>
            </td>
        </tr>
        <tr>
            <td style="border-top: 0px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 0px solid #000000" colspan=2 height="15" align="center" valign=middle><b>
                    <font size=1>PC</font>
                </b></td>
            <td style="border-top: 0px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" colspan=3 align="center" valign=middle>
                <font size=1><?php echo $cod_pc; ?></font>
            </td>
            <td align="left" valign=middle>
                <font size=1><br></font>
            </td>
            <td style="border-top: 0px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" colspan=6 align="left" valign=middle><b>
                    <font size=1> Pacote Fotográfico</font>
                </b></td>
        </tr>
        <tr>
            <td style="border-top: 0px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" colspan=5 rowspan=2 height="30" align="center" valign=middle><b>
                    <font size=1>Estrella Photo Estúdio</font>
                </b></td>
            <td align="left" valign=middle>
                <font size=1><br></font>
            </td>
            <td style="border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" colspan=6 align="left" valign=middle>
                <font size=1><?php echo $nome_produto; ?></font>
            </td>
        </tr>
        <tr>
            <td align="left" valign=middle>
                <font size=1><br></font>
            </td>
            <td style="border-top: 0px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="left" valign=middle><b>
                    <font size=1> Vl. Compra</font>
                </b></td>
            <td align="left" valign=middle><b>
                    <font size=1> Vl. Entrada</font>
                </b></td>
            <td style="border-top: 0px solid #000000; border-left: 1px solid #000000; border-right: 0px solid #000000" align="left" valign=middle><b>
                    <font size=1> Nº Prest.</font>
                </b></td>
            <td style="border-top: 0px solid #000000; border-left: 1px solid #000000; border-right: 0px solid #000000" align="left" valign=middle><b>
                    <font size=1> Vl. Prest.</font>
                </b></td>
            <td style="border-top: 0px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" colspan=2 align="left" valign=middle><b>
                    <font size=1> Dt. Venc.</font>
                </b></td>
        </tr>
        <tr>
            <td style="border-top: 0px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" colspan=5 rowspan=2 height="30" align="center" valign=middle>
                <font size=1>CNPJ <?php echo $cnpj; ?></font>
            </td>
            <td align="left" valign=middle>
                <font size=1><br></font>
            </td>
            <td style="border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="center" valign=middle>R$ <?php echo $vlr_total; ?></td>
            <td style="border-bottom: 1px solid #000000; border-left: 0px solid #000000; border-right: 0px solid #000000" align="center" valign=middle>R$ <?php echo $vlr_entrada; ?></td>
            <td style="border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 0px solid #000000" align="center" valign=middle>2 / <?php echo $qtd_parcela; ?></td>
            <td style="border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 0px solid #000000" align="center" valign=middle>R$ <?php echo $vlr_prest_ini_2; ?></td>
            <td style="border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" colspan=2 align="center" valign=middle><?php echo date('d/m/Y', strtotime($dt_venc_prest_ini_2)); ?>
            </td>
        </tr>
        <tr>
            <td align="left" valign=middle>
                <font size=1><br></font>
            </td>
            <td style="border-top: 0px solid #000000; border-left: 1px solid #000000; border-right: 0px solid #000000" colspan=2 align="left" valign=middle><b>
                    <font size=1> Dt. Emissão</font>
                </b></td>
            <td style="border-top: 0px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" colspan=4 rowspan=2 align="center" valign=middle><b>
                    <font size=1> </font>
                </b></td>
        </tr>
        <tr>
            <td style="border-top: 0px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" colspan=5 height="15" align="left" valign=middle><b>
                    <font size=1> Nº Prestação</font>
                </b></td>
            <td align="left" valign=middle>
                <font size=1><br></font>
            </td>
            <td style="border-bottom: 0px solid #000000; border-left: 1px solid #000000; border-right: 0px solid #000000" colspan=2 align="center" valign=middle>
                <font size=1><?php echo $hoje; ?></font>
            </td>
        </tr>
        <tr>
            <td style="border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" colspan=5 rowspan=3 height="45" align="center" valign=middle><b>
                    <font size=6>2 / <?php echo $qtd_parcela; ?></font>
                </b></td>
            <td align="left" valign=middle>
                <font size=1><br></font>
            </td>
            <td style="border-top: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" colspan=6 rowspan=2 align="center" valign=middle><b>
                    <font size=1> MANTENHA OS SEUS PAGAMENTOS EM DIA, PARA EVITAR MULTAS E JUROS</font>
                </b></td>
        </tr>
        <tr>
            <td align="left" valign=middle>
                <font size=1><br></font>
            </td>
        </tr>
        <tr>
            <td align="left" valign=middle>
                <font size=1><br></font>
            </td>
            <td style="border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" colspan=6 align="center" valign=middle>
                <font size=1>*** AUTENTICAÇÃO NO VERSO ***</font>
            </td>
        </tr>
        <tr>
            <td colspan=12 height="26" align="center" valign=top>
                <font size=1>……………………………………………………………………………………………………………………………………………………………………</font>
            </td>
        </tr>
    </table>

    <!-- Parcela restantes -->
    <?php
    $count = 3;
    $ano_vence = date('Y', strtotime($dt_venc_prest_ini_2));
    $mes_vence = date('m', strtotime($dt_venc_prest_ini_2));
    $dia_vence = date('d', strtotime($dt_venc_prest_ini_2));

    while ($count <= $qtd_parcela) {

        if ($mes_vence >= 12) {
            $ano_vence = $ano_vence + 1;
            $mes_vence = 1;
        } else {
            $mes_vence++;
        }
    ?>
        <table cellspacing="0" border="0">
            <colgroup width="25"></colgroup>
            <colgroup width="66"></colgroup>
            <colgroup span="2" width="23"></colgroup>
            <colgroup width="50"></colgroup>
            <colgroup width="10"></colgroup>
            <colgroup width="85"></colgroup>
            <colgroup width="94"></colgroup>
            <colgroup width="83"></colgroup>
            <colgroup width="98"></colgroup>
            <colgroup width="85"></colgroup>
            <colgroup width="45"></colgroup>
            <tr>
                <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 0px solid #000000" colspan=2 rowspan=2 height="30" align="center" valign=middle><b>
                        <font size=1>Nº Carnê</font>
                    </b></td>
                <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" colspan=3 rowspan=2 align="center" valign=middle><b><?php echo $num_carne; ?></b></td>
                <td align="left" valign=middle>
                    <font size=1><br></font>
                </td>
                <td style="border-top: 1px solid #000000; border-left: 1px solid #000000; border-right: 0px solid #000000" align="left" valign=middle><b>
                        <font size=1> PC</font>
                    </b></td>
                <td style="border-top: 1px solid #000000; border-left: 1px solid #000000; border-right: 0px solid #000000" align="left" valign=middle><b>
                        <font size=1> Cód. Vendora</font>
                    </b></td>
                <td style="border-top: 1px solid #000000; border-left: 1px solid #000000; border-right: 0px solid #000000" align="left" valign=middle><b>
                        <font size=1> Cód. Caixa</font>
                    </b></td>
                <td style="border-top: 1px solid #000000; border-left: 1px solid #000000; border-right: 0px solid #000000" align="left" valign=middle><b>
                        <font size=1> CPF</font>
                    </b></td>
                <td style="border-top: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" colspan=2 align="left" valign=middle><b>
                        <font size=1> Nº do Carnê</font>
                    </b></td>
            </tr>
            <tr>
                <td align="left" valign=middle>
                    <font size=1><br></font>
                </td>
                <td style="border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 0px solid #000000" align="center" valign=middle sdval="206" sdnum="1046;">
                    <font size=1><?php echo $cod_pc; ?></font>
                </td>
                <td style="border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 0px solid #000000" align="center" valign=middle>
                    <font size=1><?php echo $cod_vendor . " – " . $nome_vendor; ?></font>
                </td>
                <td style="border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 0px solid #000000" align="center" valign=middle sdval="5449" sdnum="1046;">
                    <font size=1><?php echo $cod_caixa; ?></font>
                </td>
                <td style="border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 0px solid #000000" align="center" valign=middle>
                    <font size=1><?php echo $cpf_cliente; ?></font>
                </td>
                <td style="border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" colspan=2 align="center" valign=middle><b><?php echo $num_carne; ?></b></td>
            </tr>
            <tr>
                <td style="border-top: 0px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 0px solid #000000" colspan=2 rowspan=2 height="30" align="center" valign=middle><b>
                        <font size=1>Dt. Venc.</font>
                    </b></td>
                <td style="border-top: 0px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" colspan=3 rowspan=2 align="center" valign=middle>
                    <?php echo $dia_vence . "/" . sprintf('%02d', $mes_vence) . "/" . $ano_vence; ?></td>
                <td align="left" valign=middle>
                    <font size=1><br></font>
                </td>
                <td style="border-top: 0px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" colspan=6 align="left" valign=middle><b>
                        <font size=1> Nome Cliente</font>
                    </b></td>
            </tr>
            <tr>
                <td align="left" valign=middle>
                    <font size=1><br></font>
                </td>
                <td style="border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" colspan=6 align="left" valign=middle>
                    <font size=1><?php echo $nome_cli; ?></font>
                </td>
            </tr>
            <tr>
                <td style="border-top: 0px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 0px solid #000000" colspan=2 rowspan=2 height="30" align="center" valign=middle><b>
                        <font size=1>Dt. Últ. Venc.</font>
                    </b></td>
                <td style="border-top: 0px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" colspan=3 rowspan=2 align="center" valign=middle><?php echo $dt_ult_venc; ?></td>
                <td align="left" valign=middle>
                    <font size=1><br></font>
                </td>
                <td style="border-top: 0px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" colspan=6 align="left" valign=middle><b>
                        <font size=1> Nome Modelo</font>
                    </b></td>
            </tr>
            <tr>
                <td align="left" valign=middle>
                    <font size=1><br></font>
                </td>
                <td style="border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" colspan=6 align="left" valign=middle>
                    <font size=1><?php echo $nome_mod; ?></font>
                </td>
            </tr>
            <tr>
                <td style="border-top: 0px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 0px solid #000000" colspan=2 height="15" align="center" valign=middle><b>
                        <font size=1>PC</font>
                    </b></td>
                <td style="border-top: 0px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" colspan=3 align="center" valign=middle>
                    <font size=1><?php echo $cod_pc; ?></font>
                </td>
                <td align="left" valign=middle>
                    <font size=1><br></font>
                </td>
                <td style="border-top: 0px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" colspan=6 align="left" valign=middle><b>
                        <font size=1> Pacote Fotográfico</font>
                    </b></td>
            </tr>
            <tr>
                <td style="border-top: 0px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" colspan=5 rowspan=2 height="30" align="center" valign=middle><b>
                        <font size=1>Estrella Photo Estúdio</font>
                    </b></td>
                <td align="left" valign=middle>
                    <font size=1><br></font>
                </td>
                <td style="border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" colspan=6 align="left" valign=middle>
                    <font size=1><?php echo $nome_produto; ?></font>
                </td>
            </tr>
            <tr>
                <td align="left" valign=middle>
                    <font size=1><br></font>
                </td>
                <td style="border-top: 0px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="left" valign=middle><b>
                        <font size=1> Vl. Compra</font>
                    </b></td>
                <td align="left" valign=middle><b>
                        <font size=1> Vl. Entrada</font>
                    </b></td>
                <td style="border-top: 0px solid #000000; border-left: 1px solid #000000; border-right: 0px solid #000000" align="left" valign=middle><b>
                        <font size=1> Nº Prest.</font>
                    </b></td>
                <td style="border-top: 0px solid #000000; border-left: 1px solid #000000; border-right: 0px solid #000000" align="left" valign=middle><b>
                        <font size=1> Vl. Prest.</font>
                    </b></td>
                <td style="border-top: 0px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" colspan=2 align="left" valign=middle><b>
                        <font size=1> Dt. Venc.</font>
                    </b></td>
            </tr>
            <tr>
                <td style="border-top: 0px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" colspan=5 rowspan=2 height="30" align="center" valign=middle>
                    <font size=1>CNPJ <?php echo $cnpj; ?></font>
                </td>
                <td align="left" valign=middle>
                    <font size=1><br></font>
                </td>
                <td style="border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="center" valign=middle>R$ <?php echo $vlr_total; ?></td>
                <td style="border-bottom: 1px solid #000000; border-left: 0px solid #000000; border-right: 0px solid #000000" align="center" valign=middle>R$ <?php echo $vlr_entrada; ?></td>
                <td style="border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 0px solid #000000" align="center" valign=middle><?php echo $count . " / " . $qtd_parcela; ?></td>
                <td style="border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 0px solid #000000" align="center" valign=middle>R$ <?php echo $vlr_parcela; ?></td>
                <td style="border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" colspan=2 align="center" valign=middle>
                    <?php echo $dia_vence . "/" . sprintf('%02d', $mes_vence) . "/" . $ano_vence; ?></td>
            </tr>
            <tr>
                <td align="left" valign=middle>
                    <font size=1><br></font>
                </td>
                <td style="border-top: 0px solid #000000; border-left: 1px solid #000000; border-right: 0px solid #000000" colspan=2 align="left" valign=middle><b>
                        <font size=1> Dt. Emissão</font>
                    </b></td>
                <td style="border-top: 0px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" colspan=4 rowspan=2 align="center" valign=middle><b>
                        <font size=1> </font>
                    </b></td>
            </tr>
            <tr>
                <td style="border-top: 0px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" colspan=5 height="15" align="left" valign=middle><b>
                        <font size=1> Nº Prestação</font>
                    </b></td>
                <td align="left" valign=middle>
                    <font size=1><br></font>
                </td>
                <td style="border-bottom: 0px solid #000000; border-left: 1px solid #000000; border-right: 0px solid #000000" colspan=2 align="center" valign=middle>
                    <font size=1><?php echo $hoje; ?></font>
                </td>
            </tr>
            <tr>
                <td style="border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" colspan=5 rowspan=3 height="45" align="center" valign=middle><b>
                        <font size=6><?php echo $count . " / " . $qtd_parcela; ?></font>
                    </b></td>
                <td align="left" valign=middle>
                    <font size=1><br></font>
                </td>
                <td style="border-top: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" colspan=6 rowspan=2 align="center" valign=middle><b>
                        <font size=1> MANTENHA OS SEUS PAGAMENTOS EM DIA, PARA EVITAR MULTAS E JUROS</font>
                    </b></td>
            </tr>
            <tr>
                <td align="left" valign=middle>
                    <font size=1><br></font>
                </td>
            </tr>
            <tr>
                <td align="left" valign=middle>
                    <font size=1><br></font>
                </td>
                <td style="border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" colspan=6 align="center" valign=middle>
                    <font size=1>*** AUTENTICAÇÃO NO VERSO ***</font>
                </td>
            </tr>
            <tr>
                <td colspan=12 height="26" align="center" valign=top>
                    <font size=1>……………………………………………………………………………………………………………………………………………………………………</font>
                </td>
            </tr>
        </table>

    <?php

        // Quebra de páginas
        if (!$count_quebra_pg) {
            $count_quebra_pg = 0;
        } // Preenche Variavel

        $count_quebra_pg++; // contagem de loop

        if ($count_quebra_pg == 3) { // Adiciona quebra a cada 3 loops e zera a variavel
            echo "<div class=\"quebra-pagina\"></div>";
            $count_quebra_pg = 0;
        }

        $count++;
    }
    ?>
    <!-- Endereços -->
    <table cellspacing="0" border="0">
        <colgroup width="25"></colgroup>
        <colgroup width="66"></colgroup>
        <colgroup span="2" width="23"></colgroup>
        <colgroup width="50"></colgroup>
        <colgroup width="10"></colgroup>
        <colgroup width="85"></colgroup>
        <colgroup width="94"></colgroup>
        <colgroup width="83"></colgroup>
        <colgroup width="98"></colgroup>
        <colgroup width="85"></colgroup>
        <colgroup width="45"></colgroup>
        <tr>
            <td style="border-top: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" colspan=12 height="15" align="center" valign=middle bgcolor="#CCCCCC"><b>Você poderá fazer a escolha de
                    um de nossos endereços para efetuar o pagamento:</b></td>
        </tr>
        <tr>
            <td style="border-top: 1px solid #000000; border-left: 1px solid #000000" height="15" align="center" valign=middle>
                <font size=1><br></font>
            </td>
            <td style="border-top: 1px solid #000000; border-right: 1px solid #000000" colspan=11 align="left" valign=middle>
                <font size=1>Alcântara – Rua Yolanda Saad Abuzaid, 100 A – Sala 504 – Tel: (21) 2603-2392 – Cel: (21)
                    99477-3885</font>
            </td>
        </tr>
        <tr>
            <td style="border-left: 1px solid #000000" height="15" align="center" valign=middle>
                <font size=1><br></font>
            </td>
            <td style="border-right: 1px solid #000000" colspan=11 align="left" valign=middle>
                <font size=1>Alcântara – Rua João Caetano, 45 – Salas 103 e 104 – Tel: (21) 2601-2878 – Cel: (21)
                    99106-0372</font>
            </td>
        </tr>
        <tr>
            <td style="border-left: 1px solid #000000" height="15" align="center" valign=middle>
                <font size=1><br></font>
            </td>
            <td style="border-right: 1px solid #000000" colspan=11 align="left" valign=middle>
                <font size=1>Bangu – Avenida Cônego de Vasconcelos, 423 – Sala 401 – Conjunto 306 – Tel: (21) 3331-1868
                    – Cel: (21) 99212-0588</font>
            </td>
        </tr>
        <tr>
            <td style="border-left: 1px solid #000000" height="15" align="center" valign=middle>
                <font size=1><br></font>
            </td>
            <td style="border-right: 1px solid #000000" colspan=11 align="left" valign=middle>
                <font size=1>Centro RJ – Rua da Alfândega,323 – Sobreloja – Tels: (21) 2221-6802 / (21) 2221-6920 – Cel:
                    (21) 99208-0507</font>
            </td>
        </tr>
        <tr>
            <td style="border-left: 1px solid #000000" height="15" align="center" valign=middle>
                <font size=1><br></font>
            </td>
            <td style="border-right: 1px solid #000000" colspan=11 align="left" valign=middle>
                <font size=1>Centro RJ – Rua Senador Dantas, 118 – Sala 712 – Tel: (21) 2242-7849 – Cel: (21) 99477-3882
                </font>
            </td>
        </tr>
        <tr>
            <td style="border-left: 1px solid #000000" height="15" align="center" valign=middle>
                <font size=1><br></font>
            </td>
            <td style="border-right: 1px solid #000000" colspan=11 align="left" valign=middle>
                <font size=1>Campo Grande – Rua Augusto Vasconcelos, 104 – Sobreloja – Tels: (21) 2415-1990 / (21)
                    2415-9477 – Cel: (21) 99212-0132</font>
            </td>
        </tr>
        <tr>
            <td style="border-left: 1px solid #000000" height="15" align="center" valign=middle>
                <font size=1><br></font>
            </td>
            <td style="border-right: 1px solid #000000" colspan=11 align="left" valign=middle>
                <font size=1>Campo Grande – Rua Coronel Agostinho, 79 – Sala 704 – Tel: (21) 2413-9134 – Cel: (21)
                    99477-3888</font>
            </td>
        </tr>
        <tr>
            <td style="border-left: 1px solid #000000" height="15" align="center" valign=middle>
                <font size=1><br></font>
            </td>
            <td style="border-right: 1px solid #000000" colspan=11 align="left" valign=middle>
                <font size=1>Duque de Caxias – Rua José Alvarenga (Calçadão de Caxias), 446 – Sala 302 – Tel: (21)
                    2783-9147 – Cel: (21) 99424-7272</font>
            </td>
        </tr>
        <tr>
            <td style="border-left: 1px solid #000000" height="15" align="center" valign=middle>
                <font size=1><br></font>
            </td>
            <td style="border-right: 1px solid #000000" colspan=11 align="left" valign=middle>
                <font size=1>Duque de Caxias – Rua José Alvarenga (Calçadão de Caxias), 439 – 2º Andar – Tel: (21)
                    2672-3967 – Cel: (21) 994773883</font>
            </td>
        </tr>
        <tr>
            <td style="border-left: 1px solid #000000" height="15" align="center" valign=middle>
                <font size=1><br></font>
            </td>
            <td style="border-right: 1px solid #000000" colspan=11 align="left" valign=middle>
                <font size=1>Madureira – Estrada do Portela, 29 – Salas 305 a 307 – Centro Comercial – Tel: (21)
                    3017-7267 – Cel: (21) 99208-0508</font>
            </td>
        </tr>
        <tr>
            <td style="border-left: 1px solid #000000" height="15" align="center" valign=middle>
                <font size=1><br></font>
            </td>
            <td style="border-right: 1px solid #000000" colspan=11 align="left" valign=middle>
                <font size=1>Niterói – Rua Coronel Gomes Machado, 38 – Sala 408 – Tel: (21)2620-1128 – Cel: (21)
                    99477-3887</font>
            </td>
        </tr>
        <tr>
            <td style="border-left: 1px solid #000000" height="15" align="center" valign=middle sdnum="1046;0;?/?">
                <font size=1><br></font>
            </td>
            <td style="border-right: 1px solid #000000" colspan=11 align="left" valign=middle>
                <font size=1>Nova Iguaçu – Avenida Amaral Peixoto, 130 – Sala 401 – Tel: (21) 2667-5090 – Cel: (21)
                    99217-0354</font>
            </td>
        </tr>
        <tr>
            <td style="border-bottom: 1px solid #000000; border-left: 1px solid #000000" height="15" align="center" valign=middle>
                <font size=1><br></font>
            </td>
            <td style="border-bottom: 1px solid #000000; border-right: 1px solid #000000" colspan=11 align="left" valign=middle>
                <font size=1>Tijuca – Rua Conde de Bonfim, 346 – Loja 217 – 2º Piso – Tel: (21) 2569-7096 – Cel: (21)
                    99256-2447</font>
            </td>
        </tr>
        <tr>
            <td style="border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" colspan=12 height="15" align="center" valign=middle bgcolor="#CCCCCC"><b>
                    <font size=1>Central de Informações – Tel: (21) 2121-5200 – (21) 2121-5207 / Cel: (21) 99208-0513 –
                        Site: <a href="http://www.estrella.com.br/">www.estrella.com.br</a></font>
                </b></td>
        </tr>
        <tr>
            <td colspan=12 height="15" align="center" valign=top>
                <font size=1>……………………………………………………………………………………………………………………………………………………………………</font>
            </td>
        </tr>
    </table>

    <?php
    // Encerrando as Conexões
    mysqli_close($conec);

    ?>

</body>

</html>