<html>

<head>
    <title>WebCaixa v1.20.21_beta</title>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <style type="text/css">
        body {
            margin-top: 5%;
            margin-left: 5%;
            margin-right: 5%;
            border: 3px solid gray;
            padding: 10px 10px 10px 10px;
            font-family: sans-serif;
        }

        .campos {
            background-color: #C0C0C0;
            font: 16px sans-serif;
            color: #000000;
        }
    </style>

    <script>
        function F5(event) {
            var tecla = document.all ? window.event.keyCode : event.which;
            if (document.all) {
                window.event.keyCode = 0;
                window.event.returnValue = false;
            }
            if (tecla == 116) return false;
        }

        document.onkeydown = F5;
    </script>

    <?php
    // Inserindo o Cabeçalho
    include "../cabecprs.php";
    ?>

    <SCRIPT LANGUAGE="JavaScript">
        <!-- Begin
        function putFocus(formInst, elementInst) {
            if (document.forms.length > 0) {
                document.forms[formInst].elements[elementInst].focus();
            }
        }
        //  End 
        -->
    </script>

    <Script>
        function validate(field) {
            var valid = "0123456789"
            var ok = "yes";
            var temp;
            for (var i = 0; i < field.value.length; i++) {
                temp = "" + field.value.substring(i, i + 1);
                if (valid.indexOf(temp) == "-1") ok = "no";
            }
            if (ok == "no") {
                alert("Entrada Incorreta! \n  Digite apenas algarismos!");
                field.focus();
                field.select();
            }
        }
        //  End -->
    </script>

    <script type="text/javascript" src="val_ped.js" charset="utf-8">
    </script>

</head>

<body background="../images/bg1.jpg" text="#FFFFFF" onLoad="putFocus(0,0)">

    <?php
    // Importando os Dados do Formulário
    $Sis       = "S7";
    $Rot       = "S7R2.2.1";
    $lg_user   = trim($_POST['txtuser']);
    $user    = substr($lg_user, 0, 8);
    $pss     = substr($lg_user, 8, 40);

    function moedaParaFloat($valor) {
        $valor = trim((string) $valor);
        $valor = str_replace(['R$', ' '], '', $valor);
        if (strpos($valor, ',') !== false) {
            $valor = str_replace('.', '', $valor);
            $valor = str_replace(',', '.', $valor);
        }
        return (float) $valor;
    }

    function moedaParaCentavos($valor) {
        return (int) round(moedaParaFloat($valor) * 100);
    }

    $NumDoc    = trim($_POST['txtdoc']);
    $NumDocF = 10000000 + $NumDoc;
    $NDoc      = substr($NumDocF, 1, 7);

    $Mat_Vend = trim($_POST['mat_vend']);
    $Vendedora = trim($_POST['vendedora']);
    $Cliente    = trim($_POST['cliente']);

    $VrPrest    = moedaParaFloat($_POST['txtvalor'] ?? 0);
    $VrPrestF   = number_format($VrPrest, 2, ',', '.');
    $CreditoCobranca = moedaParaFloat($_POST['credito_cobranca'] ?? 0);
    $Chk_Pedido = isset($_POST['chk_pedido']) ? trim($_POST['chk_pedido']) : '';
    $PIni      = trim($_POST['txtparc_ini']);
    $PUlt      = trim($_POST['txtparc_ult']);
    $QtdeParc  = $PUlt - $PIni + 1;
    $Parcial   = moedaParaFloat($_POST['parcial'] ?? 0);
    $ParcialF  = number_format($Parcial, 2, ',', '.');
    $VrPrestForm  = $VrPrest * $QtdeParc;
    $VrPrestFormF  = number_format($VrPrestForm, 2, ',', '.');
    $FPag_1      = trim($_POST['lsPr1']);
    $FPag_2      = trim($_POST['lsPr2']);
    $FPag_3      = trim($_POST['lsPr3']);
    $txt1 = moedaParaFloat($_POST['txt1'] ?? 0);
    $txt2 = moedaParaFloat($_POST['txt2'] ?? 0);
    $txt3 = moedaParaFloat($_POST['txt3'] ?? 0);
    $Parc_card_cred = trim($_POST['parc_card_cred_1']) + trim($_POST['parc_card_cred_2']) + trim($_POST['parc_card_cred_3']);
    $ref_std = trim($_POST['ref_std']);
    $Quitacao = isset($_POST['chk_quitacao']) && $_POST['chk_quitacao'] == '1';
    $TotalParcelasContrato = isset($_POST['total_parcelas_contrato']) && trim($_POST['total_parcelas_contrato']) !== '' ? trim($_POST['total_parcelas_contrato']) : $QtdeParc;
    $ValorQuitacaoCents = moedaParaCentavos($_POST['txtvalor'] ?? 0) * (int) $QtdeParc;
    $ValorRecebidoCents = moedaParaCentavos($_POST['vlr_recebido'] ?? 0);
    $ValorPagamentosCents = moedaParaCentavos($_POST['txt1'] ?? 0) + moedaParaCentavos($_POST['txt2'] ?? 0) + moedaParaCentavos($_POST['txt3'] ?? 0);

    if ($Quitacao && $Parcial > 0) {
        $SisRot = "S-7.1";
        include "./rodape.php";
        echo "<script>alert('Quitação não pode conter parcial. Ajuste o valor recebido.'); window.history.back();</script>";
        exit;
    }

    if ($Quitacao && $ValorQuitacaoCents > 0 && ($ValorRecebidoCents != $ValorQuitacaoCents || $ValorPagamentosCents != $ValorRecebidoCents)) {
        $SisRot = "S-7.1";
        include "./rodape.php";
        echo "<script>alert('Valor recebido incorreto para quitação. O valor correto é R$ " . number_format($ValorQuitacaoCents / 100, 2, ',', '.') . ".'); window.history.back();</script>";
        exit;
    }

    include "us_sist.php";
    if ($ch == 'no') {
        include "us_cad.php";
    } ?>

    <table width='100%' border='0' cellpadding='0' cellspacing='0'>
        <tr>
            <td width='9%'>
                <a href="contrparc_tipo.php?c_s=<?php echo $lg_user ?>"><img src="./images/voltar.gif"></a>
            </td>
            <td width='82%' align='center'>
                <font color="gold" size="6"><b>
                        <center><u><i>PRODUTOS</i></u></center>
                    </b></font><br><br><br>
            </td>
            <td width='9%'>
                <a href="contrparc_tipo.php?c_s=<?php echo $lg_user; ?>"><img src="./images/voltar.gif"></a>
            </td>
        </tr>
    </table>

    <?php

    if ($ch == 'ok-enc' or $ch == 'ok-cai' or $ch == 'ok') {
        if ($Chk_Pedido != '1') { ?>
        <form name="frmest" id="frmest" method="post" action="confcntparc.php" autocomplete="off">
            <input type="hidden" name="txtuser" value="<?php echo $lg_user; ?>">
            <input type="hidden" name="ref_std" value="<?php echo $ref_std; ?>">
            <input type="hidden" name="txtdoc" value="<?php echo $NumDoc; ?>">
            <input type="hidden" name="mat_vend" value="<?php echo $Mat_Vend; ?>">
            <input type="hidden" name="vendedora" value="<?php echo $Vendedora; ?>">
            <input type="hidden" name="cliente" value="<?php echo $Cliente; ?>">
            <input type="hidden" name="txtvalor" value="<?php echo $VrPrest; ?>">
            <input type="hidden" name="credito_cobranca" value="<?php echo $CreditoCobranca; ?>">
            <input type="hidden" name="chk_pedido" value="<?php echo $Chk_Pedido; ?>">
            <input type="hidden" name="txtparc_ini" value="<?php echo $PIni; ?>">
            <input type="hidden" name="txtparc_ult" value="<?php echo $PUlt; ?>">
            <input type="hidden" name="lsPr1" value="<?php echo $FPag_1; ?>">
            <input type="hidden" name="lsPr2" value="<?php echo $FPag_2; ?>">
            <input type="hidden" name="lsPr3" value="<?php echo $FPag_3; ?>">
            <input type="hidden" name="txt1" value="<?php echo $txt1; ?>">
            <input type="hidden" name="txt2" value="<?php echo $txt2; ?>">
            <input type="hidden" name="txt3" value="<?php echo $txt3; ?>">
            <input type="hidden" name="qtdeparc" value="<?php echo $QtdeParc; ?>">
            <input type="hidden" name="parcial" value="<?php echo $Parcial; ?>">
            <input type="hidden" name="parc_card_cred" value="<?php echo $Parc_card_cred; ?>">
            <input type="hidden" name="rdopt" value="NORMAL">
            <input type="hidden" name="pct_book" value="">
            <input type="hidden" name="ped_poster" value="">
            <?php if ($Quitacao) { ?>
                <input type="hidden" name="chk_quitacao" value="1">
            <?php } ?>
            <?php if ($TotalParcelasContrato !== '') { ?>
                <input type="hidden" name="total_parcelas_contrato" value="<?php echo $TotalParcelasContrato; ?>">
            <?php } ?>
        </form>
        <script>
            document.forms['frmest'].submit();
        </script>
        <noscript>
            <center><input type="submit" form="frmest" value="Continuar"></center>
        </noscript>
        <?php } else { ?>
        <form name="frmest" method="post" action="confcntparc.php" onsubmit="return checkdata()" autocomplete="off">
            <table width="70%" border="5" cellpadding="10" cellspacing="0" align="center">
                <?php

                // Conexão
                include "conexao.php";
                include "dbselect.php";

                ?>

                <tr width="30%" align="center">
                    <td>
                        <font color='gold' size='5'><b><i>Book:</i></b></font>
                        <input id="rdopt_book" type="checkbox" name="rdopt_book" class="campos" value="BOOK" style="margin-left: 30px;">
                    </td>
                    <td align="center">
                        <font size="4" color='gold'><b><i>Qtde: </i></b></font>
                        <select name="qtde_book" id="qtde_book" class="campos" style="width: 60px; height: 30px; margin-right: 22px;">
                            <option value="" selected>0</option>
                            <?php for ($i = 1; $i <= 1; $i++) { ?>
                                <option value="<?php echo $i; ?>"><?php echo $i; ?></option>
                            <?php } ?>
                        </select>
                        <font size="4" color='gold'>
                            <b>
                                <i>Pacote: </i>
                            </b>
                        </font>
                        <select name="pct_book" id="pct_book" class="campos" style="width: 300px; height: 30px;">
                            <option value="" selected>Selecione</option>
                            <font size="4">
                                <?php

                                // Pacotes
                                $sql_Pct = "SELECT * FROM produtos WHERE cod_prod IN ('1','2','3','4','5','6','7','8','9','10') ORDER BY nome_prod ASC";
                                $res_Pct = mysqli_query($conec, $sql_Pct) or die("File Error #1. Contate seu Administrador.");

                                while ($row_Pct = mysqli_fetch_assoc($res_Pct)) {
                                ?>
                                    <option value="<?php echo $row_Pct['nome_prod']; ?>"><?php echo $row_Pct['nome_prod']; ?></option>
                                <?php
                                }

                                ?>
                            </font>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td width="30%" align="center">
                        <font color='gold' size='5'><b><i>Poster:</i></b></font>
                        <input id="rdopt_poster" type="checkbox" name="rdopt_poster" class="campos" value="POSTER" style="margin-left: 12px;">
                    </td>
                    <td align="center">
                        <font size="4" color='gold'><b><i>Qtde: </i></b></font>
                        <select name="qtde_poster" id="qtde_poster" class="campos" style="width: 60px; height: 30px; margin-right: 22px;">
                            <option value="" selected>0</option>
                            <?php for ($i = 1; $i <= 2; $i++) { ?>
                                <option value="<?php echo $i; ?>"><?php echo $i; ?></option>
                            <?php } ?>
                        </select>
                        <font size="4" color='gold'>
                            <b>
                                <i>Pacote: </i>
                            </b>
                        </font>
                        <select name="ped_poster" id="ped_poster" class="campos" style="width: 300px; height: 30px;">
                            <option value="" selected>Selecione</option>
                            <font size="4">
                                <?php
                                // Tamanhos
                                $sql_Tam = "SELECT * FROM produtos WHERE desc_prod <> 'x' AND cod_prod IN ('11','12') ORDER BY nome_prod ASC";
                                $res_Tam = mysqli_query($conec, $sql_Tam) or die("File Error #2. Contate seu Administrador.");

                                while ($row_Tam = mysqli_fetch_assoc($res_Tam)) {
                                ?>
                                    <option value="<?php echo $row_Tam['nome_prod']; ?>"><?php echo $row_Tam['nome_prod']; ?></option>
                                <?php
                                }

                                ?>
                            </font>
                        </select>
                    </td>
                </tr>
            </table><br>

            <table id="tab_ped" name="tab_ped" width="70%" border="5" cellpadding="10" cellspacing="0" align="center" style="display:none;">
                <thead>
                    <tr>
                        <td width="50%" align="center">
                            <font color='#FFFFFF' size='5'><b><i>Vendedora</i></b></font>
                        </td>
                        <td width="50%" align="center">
                            <font color='#FFFFFF' size='5'><b><i>Cliente</i></b></font>
                        </td>
                    </tr>
                </thead>
                <tbody id="tab_ped_body">
                    <tr>
                        <td align="center">
                            <font color='gold' size='5'><b><i><?php echo $Vendedora; ?></i></b></font>
                        </td>
                        <td align="center">
                            <font color='lime' size='5'><b><i><?php echo $Cliente; ?></i></b></font>
                        </td>
                    </tr>
                </tbody>
            </table><br>

            <input type="hidden" name="txtuser" value="<?php echo $lg_user; ?>">
            <input type="hidden" name="ref_std" value="<?php echo $ref_std; ?>">
            <input type="hidden" name="txtdoc" value="<?php echo $NumDoc; ?>">
            <input type="hidden" name="mat_vend" value="<?php echo $Mat_Vend; ?>">
            <input type="hidden" name="vendedora" value="<?php echo $Vendedora; ?>">
            <input type="hidden" name="cliente" value="<?php echo $Cliente; ?>">
            <input type="hidden" name="txtvalor" value="<?php echo $VrPrest; ?>">
            <input type="hidden" name="credito_cobranca" value="<?php echo $CreditoCobranca; ?>">
            <input type="hidden" name="chk_pedido" value="<?php echo $Chk_Pedido; ?>">
            <input type="hidden" name="txtparc_ini" value="<?php echo $PIni; ?>">
            <input type="hidden" name="txtparc_ult" value="<?php echo $PUlt; ?>">
            <input type="hidden" name="lsPr1" value="<?php echo $FPag_1; ?>">
            <input type="hidden" name="lsPr2" value="<?php echo $FPag_2; ?>">
            <input type="hidden" name="lsPr3" value="<?php echo $FPag_3; ?>">
            <input type="hidden" name="txt1" value="<?php echo $txt1; ?>">
            <input type="hidden" name="txt2" value="<?php echo $txt2; ?>">
            <input type="hidden" name="txt3" value="<?php echo $txt3; ?>">
            <input type="hidden" name="qtdeparc" value="<?php echo $QtdeParc; ?>">
            <input type="hidden" name="parcial" value="<?php echo $Parcial; ?>">
            <input type="hidden" name="parc_card_cred" value="<?php echo $Parc_card_cred; ?>">
            <?php if ($Quitacao) { ?>
                <input type="hidden" name="chk_quitacao" value="1">
            <?php } ?>
            <input type="hidden" name="total_parcelas_contrato" value="<?php echo $TotalParcelasContrato; ?>">


            <table width="100%" border="0" cellspacing="0">
                <tr>
                    <td width="9%"></td>
                    <td width="82%" align="center">
                        <input type="submit" name="btenviar" value="Continuar">&nbsp;&nbsp;
                        <input type="reset" name="btreset" value="Limpar">
                    <td width="9%" align="right"></a>
                    </td>
                </tr>
            </table>
        </form><?php
        }
            } else { ?>
        <br><br><br><br><br>
        <font size='6'><b>
                <center>Acesso <font color='gold'>
                        <blink><u>não Autorizado</u>
                        </blink>
                        <font color='#FFFFFF'>!!!</center>
            </b></font><br><br><br>
        <center><a href='index.php?c_s=<?php echo $lg_user; ?>'><img src='images/voltar.gif'></a></center><br><br>
    <?php
            }

            // Encerrando as Conexões
            $SisRot = "S-7.1";
            include "./rodape.php";
            if (isset($conec)) {
                mysqli_close($conec);
            } ?>

    <!-- script para controlar habilitação/desabilitação dos selects e validação -->
    <script>
        (function() {
            const chkBook = document.getElementById('rdopt_book');
            const chkPoster = document.getElementById('rdopt_poster');
            const marcadores = [chkBook, chkPoster].filter(Boolean);
            const qtdeBook = document.getElementById('qtde_book');
            const qtdePoster = document.getElementById('qtde_poster');
            const selectPct = document.getElementById('pct_book');
            const selectTam = document.getElementById('ped_poster');

            if (!marcadores.length || !qtdeBook || !qtdePoster || !selectPct || !selectTam) return;

            window.checkdata = function() {
                if (!chkBook.checked && !chkPoster.checked) {
                    alert('Selecione um tipo: Books ou Poster');
                    return false;
                }

                if (chkBook.checked) {
                    if (qtdeBook.value === '' || qtdeBook.selectedIndex === 0) {
                        alert('Informe a quantidade de Books');
                        qtdeBook.focus();
                        return false;
                    }
                    if (selectPct.value === '' || selectPct.selectedIndex === 0) {
                        alert('Selecione um Pacote de Books');
                        selectPct.focus();
                        return false;
                    }
                }

                if (chkPoster.checked) {
                    if (qtdePoster.value === '' || qtdePoster.selectedIndex === 0) {
                        alert('Informe a quantidade de Posters');
                        qtdePoster.focus();
                        return false;
                    }
                    if (selectTam.value === '' || selectTam.selectedIndex === 0) {
                        alert('Selecione um Tamanho do Poster');
                        selectTam.focus();
                        return false;
                    }
                }

                return true;
            };

            function atualizarSelects() {
                qtdeBook.disabled = !chkBook.checked;
                selectPct.disabled = !chkBook.checked;
                qtdePoster.disabled = !chkPoster.checked;
                selectTam.disabled = !chkPoster.checked;

                if (!chkBook.checked) {
                    qtdeBook.selectedIndex = 0;
                    selectPct.selectedIndex = 0;
                }

                if (!chkPoster.checked) {
                    qtdePoster.selectedIndex = 0;
                    selectTam.selectedIndex = 0;
                }
            }

            marcadores.forEach(function(marcador) {
                marcador.addEventListener('change', atualizarSelects);
            });

            // Aplicar estado inicial
            atualizarSelects();

            // Foco no primeiro campo
            if (document.forms.length > 0) {
                try {
                    document.forms[0].elements[0].focus();
                } catch (e) {}
            }
        })();
    </script>

</body>

</html>
