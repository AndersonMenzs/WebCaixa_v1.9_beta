<html>

<head>
    <title>WebCaixa v1.20.6_beta</title>
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

        .produto-detalhe {
            display: none;
            margin: 14px auto 0 auto;
        }

        #tbl_prods {
            margin-bottom: 4px;
        }

        .botoes-produtos {
            margin-top: 18px;
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

<body background="../images/bg1.jpg" text="#FFFFFF">

    <?php

    // Obtendo o Login
    $Sis     = "S7";
    $Rot     = "S7R2.8";
    $lg_user   = trim($_POST['txtuser']);
    $user    = substr($lg_user, 0, 8);
    $pss     = substr($lg_user, 8, 40);
    $Ref_Std   = trim($_POST['ref_std']);
    $NumDoc    = trim($_POST['txtdoc']);
    $NumDocF = 100000000 + $NumDoc;
    $NDoc      = substr($NumDocF, 1, 8);
    $FPag_1      = trim($_POST['lsPr1']);
    $FPag_2      = trim($_POST['lsPr2']);
    $FPag_3      = trim($_POST['lsPr3']);
    $Mat_Vend = trim($_POST['mat_vend']);
    $Vendedora = trim($_POST['vendedora']);
    $Cliente   = trim($_POST['cliente']);
    $txt1 = isset($_POST['txt1']) ? (float) trim($_POST['txt1']) : 0;
    $txt2 = isset($_POST['txt2']) ? (float) trim($_POST['txt2']) : 0;
    $txt3 = isset($_POST['txt3']) ? (float) trim($_POST['txt3']) : 0;
    $Valor     = $txt1 + $txt2 + $txt3;
    $ValorF    = number_format($Valor, 2, ",", ".");
    $Parcelas  = trim($_POST['parc_card_cred_1']) + trim($_POST['parc_card_cred_2']) + trim($_POST['parc_card_cred_3']);

    // Verificando o Sistema
    include "us_sist.php";
    if ($ch == 'no') {
        include "us_cad.php";
    } ?>

    <table width='100%' border='0' cellpadding='0' cellspacing='0'>
        <tr>
            <td width='9%'>
                <a href="servrec.php?c_s=<?php echo $lg_user ?>"><img src="./images/voltar.gif"></a>
            </td>
            <td width='82%' align='center'>
                <font color="gold" size="6"><b>
                        <center><u><i>PRODUTOS</i></u></center>
                    </b></font><br><br><br>
            </td>
            <td width='9%'>
                <a href="servrec.php?c_s=<?php echo $lg_user; ?>"><img src="./images/voltar.gif"></a>
            </td>
        </tr>
    </table>

    <?php

    if ($ch == 'ok-enc' or $ch == 'ok-cai' or $ch == 'ok') { ?>
        <form name="frmest" method="post" action="confprods.php" onsubmit="return checkdata()" autocomplete="off">
            <table id="tbl_prods" name="tbl_prods" width="70%" border="5" cellpadding="10" cellspacing="0" align="center">
                <tr align="center">
                    <td>
                        <font color='gold' size='5'><b><i>Book:</i></b></font>
                        <input id="rdopt_book" type="checkbox" name="rdopt_book" class="campos" value="BOOK">
                    </td>
                    <td>
                        <font color='gold' size='5'><b><i>Poster:</i></b></font>
                        <input id="rdopt_poster" type="checkbox" name="rdopt_poster" class="campos" value="POSTER">
                    </td>
                    <td>
                        <font color='gold' size='5'><b><i>Top's:</i></b></font>
                        <input id="rdopt_tops" type="radio" name="rdopt_radio" class="campos" value="TOPS">
                    </td>
                    <td>
                        <font color='gold' size='5'><b><i>Produtos Kit:</i></b></font>
                        <input id="rdopt_kit" type="radio" name="rdopt_radio" class="campos" value="KIT">
                    </td>
                    <td>
                        <font color='gold' size='5'><b><i>Produto:</i></b></font>
                        <input id="rdopt_produto" type="radio" name="rdopt_radio" class="campos" value="PRODUTO">
                    </td>
                </tr>
            </table>

            <!-- Book -->
            <table id="tbl_book" name="tbl_book" class="produto-detalhe" width="70%" border="5" cellpadding="10" cellspacing="0" align="center">
                <tr>
                    <td width="30%" align="center">
                        <font color='gold' size='5'><b><i>Book:</i></b></font>
                    </td>
                    <td width="20%" align="center">
                        <font color='gold' size='4'><b><i>Qtde:</i></b></font>
                        <select name="qtde_book" id="qtde_book" class="campos" style="width: 60px; height: 30px;">
                            <option value="" selected>0</option>
                            <?php
                            for ($i = 1; $i <= 10; $i++) { ?>
                                <option value="<?php echo $i; ?>"><?php echo $i; ?></option>
                            <?php
                            } ?>
                        </select>
                    </td>
                    <td align="center">
                        <select name="ped_book" id="ped_book" class="campos" style="width: 500px; height: 30px;">
                            <option value="" selected>Selecione</option>
                            <font size="4">
                                <?php

                                // Conectando ao Banco de Dados
                                include "conexao.php";
                                include "dbselect.php";

                                // Pacotes
                                $sql_Pct = "SELECT * FROM produtos WHERE cod_prod IN ('1','2','3','5','90','91') ORDER BY nome_prod ASC";
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
            </table>

            <!-- Poster -->
            <table id="tbl_poster" name="tbl_poster" class="produto-detalhe" width="70%" border="5" cellpadding="10" cellspacing="0" align="center">
                <tr>
                    <td width="30%" align="center">
                        <font color='gold' size='5'><b><i>Poster:</i></b></font>
                    </td>
                    <td width="20%" align="center">
                        <font color='gold' size='4'><b><i>Qtde:</i></b></font>
                        <select name="qtde_poster" id="qtde_poster" class="campos" style="width: 60px; height: 30px;">
                            <option value="" selected>0</option>
                            <?php
                            for ($i = 1; $i <= 10; $i++) { ?>
                                <option value="<?php echo $i; ?>"><?php echo $i; ?></option>
                            <?php
                            } ?>
                        </select>
                    </td>
                    <td align="center">
                        <select name="ped_poster" id="ped_poster" class="campos" style="width: 500px; height: 30px;">
                            <option value="" selected>Selecione</option>
                            <font size="4">
                                <?php
                                // Tamanhos
                                $sql_Tam = "SELECT * FROM produtos WHERE desc_prod <> 'x' AND cod_prod IN ('29','30') ORDER BY nome_prod ASC";
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
            </table>

            <!-- Top's -->
            <table id="tbl_top" name="tbl_top" class="produto-detalhe" width="70%" border="5" cellpadding="10" cellspacing="0" align="center">
                <tr>
                    <td width="20%" align="center">
                        <font color='gold' size='5'><b><i>Top's:</i></b></font>
                    </td>
                    <td width="25%" align="center">
                        <font color='gold' size='4'><b><i>Tipo: </i></b></font>
                        <select name="tipo_top" id="tipo_top" class="campos" style="width: 60px; height: 30px;">
                            <option value="" selected>0</option>
                            <?php
                            for ($i = 1; $i <= 10; $i++) { ?>
                                <option value="<?php echo $i; ?>"><?php echo $i; ?></option>
                            <?php
                            } ?>
                        </select>
                    </td>
                    <td width="25%" align="center">
                        <font color='gold' size='4'><b><i>Qtde: </i></b></font>
                        <select name="qtde_top1" id="qtde_top1" class="campos" style="width: 60px; height: 30px;">
                            <option value="" selected>0</option>
                            <?php
                            for ($i = 1; $i <= 10; $i++) { ?>
                                <option value="<?php echo $i; ?>"><?php echo $i; ?></option>
                            <?php
                            } ?>
                        </select>
                    </td>
                    <td align="center">
                        <select name="ped_top_book1" id="ped_top_book1" class="campos" style="width: 500px; height: 30px;">
                            <option value="" selected>Selecione</option>
                            <font size="4">
                                <?php

                                // Conectando ao Banco de Dados
                                include "conexao.php";
                                include "dbselect.php";

                                // Pacotes
                                $sql_Pct = "SELECT * FROM produtos WHERE cod_prod IN ('1','2','3','5','90','91') ORDER BY nome_prod ASC";
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
            </table>

            <!-- Produdos Kit -->
            <table id="tbl_kit" name="tbl_kit" class="produto-detalhe" width="70%" border="5" cellpadding="10" cellspacing="0" align="center">
                <tr>
                    <td width="16%" align="center">
                        <font color='gold' size='5'><b><i>Prods Kit:</i></b></font>
                    </td>
                    <td align="center">
                        <font color='gold' size='4'><b><i>T.Kit: </i></b></font>
                        <select name="qtde_tkit_1" id="qtde_tkit_1" class="campos" style="width: 60px; height: 30px;">
                            <option value="" selected>0</option>
                            <?php
                            for ($i = 1; $i <= 3; $i++) { ?>
                                <option value="<?php echo $i; ?>"><?php echo $i; ?></option>
                            <?php
                            } ?>
                        </select>
                    </td>
                    <td align="center">
                        <table width="100%" cellpadding="5">
                            <tr>
                                <td align="center">
                                    <font color='gold' size='4'><b><i>Qtde:</i></b></font>
                                    <select name="qtde_kit_1" id="qtde_kit_1" class="campos" style="width: 60px; height: 30px;">
                                        <option value="" selected>0</option>
                                        <?php for ($i = 1; $i <= 10; $i++) { ?>
                                            <option value="<?php echo $i; ?>"><?php echo $i; ?></option>
                                        <?php } ?>
                                    </select>
                                </td>
                            </tr>
                        </table>
                    </td>
                    <td width="50%" align="center">
                        <table width="100%" cellpadding="5">
                            <tr>
                                <td align="center">
                                    <select name="ped_tkit_1" id="ped_tkit_1" class="campos" style="width: 500px; height: 30px;">
                                        <option value="" selected>Selecione</option>
                                        <font size="4">
                                            <?php
                                            // Tamanhos
                                            $sql_Tam = "SELECT * FROM produtos WHERE desc_prod <> 'x' AND cod_prod NOT IN ('1','2','3','4','5','6','34','35','36','37','38','29','30','90','91') ORDER BY nome_prod ASC";
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
                        </table>
                    </td>
                </tr>
            </table>

            <!-- Produdo -->
            <table id="tbl_prod" name="tbl_prod" class="produto-detalhe" width="70%" border="5" cellpadding="10" cellspacing="0" align="center">
                <tr>
                    <td width="30%" align="center">
                        <font color='gold' size='5'><b><i>Produto:</i></b></font>
                    </td>
                    <td width="20%" align="center">
                        <font color='gold' size='4'><b><i>Qtde:</i></b></font>
                        <select name="qtde_prod" id="qtde_prod" class="campos" style="width: 60px; height: 30px;">
                            <option value="" selected>0</option>
                            <?php
                            for ($i = 1; $i <= 10; $i++) { ?>
                                <option value="<?php echo $i; ?>"><?php echo $i; ?></option>
                            <?php
                            } ?>
                        </select>
                    </td>
                    <td width="50%" align="center">
                        <select name="ped_prod" id="ped_prod" class="campos" style="width: 500px; height: 30px;">
                            <option value="" selected>Selecione</option>
                            <font size="4">
                                <?php

                                // Pacotes
                                $sql_Pct = "SELECT * FROM produtos WHERE desc_prod <> 'x' AND cod_prod NOT IN ('1','2','3','4','5','6','34','35','36','37','38','29','30','90','91') ORDER BY nome_prod ASC";
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
            </table>

            <!-- Envio de dados ocultos -->
            <input type="hidden" name="txtuser" value="<?php echo $lg_user; ?>">
            <input type="hidden" name="txt1" value="<?php echo $txt1; ?>">
            <input type="hidden" name="txt2" value="<?php echo $txt2; ?>">
            <input type="hidden" name="txt3" value="<?php echo $txt3; ?>">
            <input type="hidden" name="txtdoc" value="<?php echo $NDoc; ?>">
            <input type="hidden" name="ref_std" value="<?php echo $Ref_Std; ?>">
            <input type="hidden" name="lsPr1" value="<?php echo $FPag_1; ?>">
            <input type="hidden" name="lsPr2" value="<?php echo $FPag_2; ?>">
            <input type="hidden" name="lsPr3" value="<?php echo $FPag_3; ?>">
            <input type="hidden" name="parcelas" value="<?php echo $Parcelas; ?>">
            <input type="hidden" name="mat_vend" value="<?php echo $Mat_Vend; ?>">
            <input type="hidden" name="vendedora" value="<?php echo $Vendedora; ?>">
            <input type="hidden" name="cliente" value="<?php echo $Cliente; ?>">
            <input type="hidden" name="txtvalor" value="<?php echo $Valor; ?>">
            <input type="hidden" name="txtvalorf" value="<?php echo $ValorF; ?>">

            <table class="botoes-produtos" width="100%" border="0" cellspacing="0">
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
            $SisRot = "S-7.2.8";
            include "./rodape.php";
            mysqli_close($conec); ?>

    <script>
        (function() {
            var opcoes = {
                rdopt_book: {
                    tabela: 'tbl_book',
                    campos: ['qtde_book', 'ped_book'],
                    mensagem: 'Informe a quantidade e selecione o Book.'
                },
                rdopt_poster: {
                    tabela: 'tbl_poster',
                    campos: ['qtde_poster', 'ped_poster'],
                    mensagem: 'Informe a quantidade e selecione o Poster.'
                },
                rdopt_tops: {
                    tabela: 'tbl_top',
                    campos: ['tipo_top', 'qtde_top1', 'ped_top_book1'],
                    mensagem: 'Informe o tipo, a quantidade e selecione o Top.'
                },
                rdopt_kit: {
                    tabela: 'tbl_kit',
                    campos: ['qtde_tkit_1', 'qtde_kit_1', 'ped_tkit_1'],
                    mensagem: 'Informe as quantidades e selecione o Produto Kit.'
                },
                rdopt_produto: {
                    tabela: 'tbl_prod',
                    campos: ['qtde_prod', 'ped_prod'],
                    mensagem: 'Informe a quantidade e selecione o Produto.'
                }
            };

            var marcadores = Array.prototype.slice.call(document.querySelectorAll('#tbl_prods input[type="checkbox"], #tbl_prods input[type="radio"]'));

            function limparCheckboxes() {
                for (var i = 0; i < marcadores.length; i++) {
                    if (marcadores[i].type === 'checkbox') {
                        marcadores[i].checked = false;
                    }
                }
            }

            function existeRadioSelecionado() {
                for (var i = 0; i < marcadores.length; i++) {
                    if (marcadores[i].type === 'radio' && marcadores[i].checked) {
                        return true;
                    }
                }

                return false;
            }

            function controlarCheckboxes(bloquear) {
                for (var i = 0; i < marcadores.length; i++) {
                    if (marcadores[i].type === 'checkbox') {
                        marcadores[i].disabled = bloquear;
                    }
                }
            }

            function criarSelectTop(modelo, nome, largura) {
                var select = modelo.cloneNode(true);
                select.name = nome;
                select.id = nome;
                select.selectedIndex = 0;
                select.disabled = modelo.disabled;
                select.style.width = largura;

                return select;
            }

            function criarSelectProduto(modelo, nome, largura) {
                var select = modelo.cloneNode(true);
                select.name = nome;
                select.id = nome;
                select.selectedIndex = 0;
                select.disabled = modelo.disabled;
                select.style.width = largura;

                return select;
            }

            function atualizarOpcoesUnicas(seletor) {
                var selects = Array.prototype.slice.call(document.querySelectorAll(seletor));
                var selecionados = [];

                for (var i = 0; i < selects.length; i++) {
                    if (selects[i].value !== '') {
                        selecionados.push(selects[i].value);
                    }
                }

                for (var j = 0; j < selects.length; j++) {
                    var valorAtual = selects[j].value;
                    var opcoes = selects[j].options;

                    for (var k = 0; k < opcoes.length; k++) {
                        opcoes[k].disabled = opcoes[k].value !== '' && opcoes[k].value !== valorAtual && selecionados.indexOf(opcoes[k].value) !== -1;
                    }
                }
            }

            function atualizarOpcoesTop() {
                atualizarOpcoesUnicas('select[id^="ped_top_book"]');
            }

            function atualizarOpcoesKit() {
                atualizarOpcoesUnicas('select[id^="ped_tkit_"]');
            }

            function atualizarLinhasTop() {
                var tabelaTop = document.getElementById('tbl_top');
                var tipoTop = document.getElementById('tipo_top');
                var qtdeModelo = document.getElementById('qtde_top1');
                var pedModelo = document.getElementById('ped_top_book1');

                if (!tabelaTop || !tipoTop || !qtdeModelo || !pedModelo) {
                    return;
                }

                var linhasExtras = tabelaTop.querySelectorAll('tr[data-top-extra="s"]');
                for (var i = linhasExtras.length - 1; i >= 0; i--) {
                    linhasExtras[i].parentNode.removeChild(linhasExtras[i]);
                }

                var primeiraLinha = tabelaTop.rows[0];
                var colunaTitulo = primeiraLinha ? primeiraLinha.cells[0] : null;
                var colunaTipo = primeiraLinha ? primeiraLinha.cells[1] : null;

                var total = parseInt(tipoTop.value, 10);
                if (isNaN(total) || total < 2 || tipoTop.disabled) {
                    if (colunaTitulo) {
                        colunaTitulo.rowSpan = 1;
                    }
                    if (colunaTipo) {
                        colunaTipo.rowSpan = 1;
                    }
                    return;
                }

                if (total > 10) {
                    total = 10;
                }

                if (colunaTitulo) {
                    colunaTitulo.rowSpan = total;
                }
                if (colunaTipo) {
                    colunaTipo.rowSpan = total;
                }

                for (var linha = 2; linha <= total; linha++) {
                    var tr = document.createElement('tr');
                    tr.setAttribute('data-top-extra', 's');

                    var tdQtde = document.createElement('td');
                    tdQtde.width = '25%';
                    tdQtde.align = 'center';
                    tdQtde.innerHTML = "<font color='gold' size='4'><b><i>Qtde: </i></b></font>";
                    tdQtde.appendChild(criarSelectTop(qtdeModelo, 'qtde_top' + linha, '60px'));
                    tr.appendChild(tdQtde);

                    var tdPed = document.createElement('td');
                    tdPed.align = 'center';
                    tdPed.appendChild(criarSelectTop(pedModelo, 'ped_top_book' + linha, '500px'));
                    tr.appendChild(tdPed);

                    tabelaTop.tBodies[0].appendChild(tr);
                }

                atualizarOpcoesTop();
            }

            function atualizarLinhasKit() {
                var tabelaKit = document.getElementById('tbl_kit');
                var totalKit = document.getElementById('qtde_tkit_1');
                var qtdeModelo = document.getElementById('qtde_kit_1');
                var pedModelo = document.getElementById('ped_tkit_1');

                if (!tabelaKit || !totalKit || !qtdeModelo || !pedModelo) {
                    return;
                }

                var linhasExtras = tabelaKit.querySelectorAll('tr[data-kit-extra="s"]');
                for (var i = linhasExtras.length - 1; i >= 0; i--) {
                    linhasExtras[i].parentNode.removeChild(linhasExtras[i]);
                }

                var primeiraLinha = tabelaKit.rows[0];
                var colunaTitulo = primeiraLinha ? primeiraLinha.cells[0] : null;
                var colunaTipo = primeiraLinha ? primeiraLinha.cells[1] : null;

                var total = parseInt(totalKit.value, 10);
                if (isNaN(total) || total < 2 || totalKit.disabled) {
                    if (colunaTitulo) {
                        colunaTitulo.rowSpan = 1;
                    }
                    if (colunaTipo) {
                        colunaTipo.rowSpan = 1;
                    }
                    return;
                }

                if (total > 3) {
                    total = 3;
                }

                if (colunaTitulo) {
                    colunaTitulo.rowSpan = total;
                }
                if (colunaTipo) {
                    colunaTipo.rowSpan = total;
                }

                for (var linha = 2; linha <= total; linha++) {
                    var tr = document.createElement('tr');
                    tr.setAttribute('data-kit-extra', 's');

                    var tdQtde = document.createElement('td');
                    tdQtde.align = 'center';
                    tdQtde.innerHTML = "<font color='gold' size='4'><b><i>Qtde:</i></b></font>";
                    tdQtde.appendChild(criarSelectProduto(qtdeModelo, 'qtde_kit_' + linha, '60px'));
                    tr.appendChild(tdQtde);

                    var tdPed = document.createElement('td');
                    tdPed.width = '50%';
                    tdPed.align = 'center';
                    tdPed.appendChild(criarSelectProduto(pedModelo, 'ped_tkit_' + linha, '500px'));
                    tr.appendChild(tdPed);

                    tabelaKit.tBodies[0].appendChild(tr);
                }

                atualizarOpcoesKit();
            }

            function controlarCampos(tabela, habilitar, limpar) {
                var campos = tabela.querySelectorAll('input, select, textarea');

                for (var i = 0; i < campos.length; i++) {
                    campos[i].disabled = !habilitar;

                    if (limpar && campos[i].tagName === 'SELECT') {
                        campos[i].selectedIndex = 0;
                    } else if (limpar && (campos[i].type === 'checkbox' || campos[i].type === 'radio')) {
                        campos[i].checked = false;
                    } else if (limpar && campos[i].type !== 'button' && campos[i].type !== 'submit') {
                        campos[i].value = '';
                    }
                }
            }

            function obterMarcados() {
                var marcados = [];

                for (var i = 0; i < marcadores.length; i++) {
                    if (marcadores[i].checked) {
                        marcados.push(marcadores[i]);
                    }
                }

                return marcados;
            }

            function atualizarTabelas(marcadorAlterado) {
                if (marcadorAlterado && marcadorAlterado.type === 'radio' && marcadorAlterado.checked) {
                    limparCheckboxes();
                }

                controlarCheckboxes(existeRadioSelecionado());

                var marcadoresSelecionados = obterMarcados();

                for (var idMarcador in opcoes) {
                    if (!opcoes.hasOwnProperty(idMarcador)) {
                        continue;
                    }

                    var tabela = document.getElementById(opcoes[idMarcador].tabela);
                    if (!tabela) {
                        continue;
                    }

                    var visivel = false;
                    for (var i = 0; i < marcadoresSelecionados.length; i++) {
                        if (marcadoresSelecionados[i].id === idMarcador) {
                            visivel = true;
                            break;
                        }
                    }

                    tabela.style.display = visivel ? 'table' : 'none';
                    controlarCampos(tabela, visivel, !visivel);
                }

                atualizarLinhasTop();
                atualizarLinhasKit();
                atualizarOpcoesTop();
                atualizarOpcoesKit();
            }

            function obterCamposValidacao(idOpcao) {
                var campos = opcoes[idOpcao].campos.slice(0);

                if (idOpcao === 'rdopt_tops') {
                    var tipoTop = document.getElementById('tipo_top');
                    var total = tipoTop ? parseInt(tipoTop.value, 10) : 0;

                    if (!isNaN(total) && total > 1) {
                        if (total > 10) {
                            total = 10;
                        }

                        for (var i = 2; i <= total; i++) {
                            campos.push('qtde_top' + i);
                            campos.push('ped_top_book' + i);
                        }
                    }
                }

                if (idOpcao === 'rdopt_kit') {
                    var totalKit = document.getElementById('qtde_tkit_1');
                    var total = totalKit ? parseInt(totalKit.value, 10) : 0;

                    if (!isNaN(total) && total > 1) {
                        if (total > 3) {
                            total = 3;
                        }

                        for (var j = 2; j <= total; j++) {
                            campos.push('qtde_kit_' + j);
                            campos.push('ped_tkit_' + j);
                        }
                    }
                }

                return campos;
            }

            window.checkdata = function() {
                var marcadoresSelecionados = obterMarcados();

                if (marcadoresSelecionados.length === 0) {
                    alert('Voce precisa selecionar uma Opção!');
                    return false;
                }

                for (var i = 0; i < marcadoresSelecionados.length; i++) {
                    var opcao = opcoes[marcadoresSelecionados[i].id];
                    var camposValidacao = obterCamposValidacao(marcadoresSelecionados[i].id);

                    for (var j = 0; j < camposValidacao.length; j++) {
                        var campo = document.getElementById(camposValidacao[j]);

                        if (campo && campo.value === '') {
                            alert(opcao.mensagem);
                            campo.focus();
                            return false;
                        }
                    }
                }

                return true;
            };

            for (var i = 0; i < marcadores.length; i++) {
                marcadores[i].addEventListener('change', function() {
                    atualizarTabelas(this);
                });
            }

            var tipoTop = document.getElementById('tipo_top');
            if (tipoTop) {
                tipoTop.addEventListener('change', function() {
                    atualizarLinhasTop();
                    atualizarOpcoesTop();
                });
            }

            var totalKit = document.getElementById('qtde_tkit_1');
            if (totalKit) {
                totalKit.addEventListener('change', function() {
                    atualizarLinhasKit();
                    atualizarOpcoesKit();
                });
            }

            document.addEventListener('change', function(event) {
                if (event.target && event.target.id && event.target.id.indexOf('ped_top_book') === 0) {
                    atualizarOpcoesTop();
                }

                if (event.target && event.target.id && event.target.id.indexOf('ped_tkit_') === 0) {
                    atualizarOpcoesKit();
                }
            });

            var formulario = document.forms['frmest'];
            if (formulario) {
                formulario.addEventListener('reset', function() {
                    setTimeout(function() {
                        atualizarTabelas();
                    }, 0);
                });
            }

            atualizarTabelas();
        })();
    </script>

</body>

</html>
