<html>

<head>
    <title>WebCaixa v1.19_beta</title>
    <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
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
    /*$dados = filter_input_array(INPUT_POST, FILTER_DEFAULT);
	echo "<pre>";
	var_dump($dados);
	echo "</pre>";*/
    //exit();

    // Importando os Dados do Formulário
    $Sis       = "S7";
    $Rot       = "S7R2.2.1";
    $lg_user   = trim($_POST['txtuser']);
    $user    = substr($lg_user, 0, 8);
    $pss     = substr($lg_user, 8, 40);

    $NumDoc    = trim($_POST['txtdoc']);
    $NumDocF = 10000000 + $NumDoc;
    $NDoc      = substr($NumDocF, 1, 7);

    $Mat_Vend = trim($_POST['mat_vend']);
    $Vendedora = trim($_POST['vendedora']);
    $Cliente    = trim($_POST['cliente']);

    $VrPrest    = trim($_POST['txtvalor']);
    $VrPrestF   = number_format($VrPrest, 2, ',', '.');
    $PIni      = trim($_POST['txtparc_ini']);
    $PUlt      = trim($_POST['txtparc_ult']);
    $QtdeParc  = $PUlt - $PIni + 1;
    $Parcial   = trim($_POST['parcial']);
    $ParcialF  = number_format($Parcial, 2, ',', '.');
    $VrPrestForm  = $VrPrest * $QtdeParc;
    $VrPrestFormF  = number_format($VrPrestForm, 2, ',', '.');
    $FPag_1      = trim($_POST['lsPr1']);
    $FPag_2      = trim($_POST['lsPr2']);
    $FPag_3      = trim($_POST['lsPr3']);
    $txt1 = isset($_POST['txt1']) ? (float) trim($_POST['txt1']) : 0;
    $txt2 = isset($_POST['txt2']) ? (float) trim($_POST['txt2']) : 0;
    $txt3 = isset($_POST['txt3']) ? (float) trim($_POST['txt3']) : 0;
    $Parc_card_cred = trim($_POST['parc_card_cred_1']) + trim($_POST['parc_card_cred_2']) + trim($_POST['parc_card_cred_3']);
    $ref_std = trim($_POST['ref_std']);

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
                        <center><u><i>SOLICITAÇÕES</i></u></center>
                    </b></font><br><br><br>
            </td>
            <td width='9%'>
                <a href="contrparc_tipo.php?c_s=<?php echo $lg_user; ?>"><img src="./images/voltar.gif"></a>
            </td>
        </tr>
    </table>

    <?php

    if ($ch == 'ok-enc' or $ch == 'ok-cai' or $ch == 'ok') { ?>
        <form name="frmest" method="post" action="confcntparc.php" onsubmit="return checkdata()" autocomplete="off">
            <table width="70%" border="5" cellpadding="10" cellspacing="0" align="center">
                <?php

                // Conexão
                include "conexao.php";
                include "dbselect.php";

                ?>

                <tr width="50%" align="center">
                    <td>
                        <font color='gold' size='5'><b><i>Book:</i></b></font>
                        <input id="rdopt_book" type="radio" name="rdopt" class="campos" value="BOOK" onchange="atualizarSelects()">
                    </td>
                    <td align="center">
                        <font size="4" color='gold'>
                            <b>
                                <i>Pacote: </i>
                            </b>
                        </font>
                        <select name="pct_ped" id="pct_ped" class="campos" style="width: 300px; height: 30px;" disabled>
                            <option value="" selected>Selecione</option>
                            <font size="4">
                                <?php

                                // Pacotes
                                $sql_Pct = "SELECT * FROM produtos WHERE cod_prod IN ('1','2','3','4','5','6','7','8') ORDER BY nome_prod ASC";
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
                    <td width="50%" align="center">
                        <font color='gold' size='5'><b><i>Poster:</i></b></font>
                        <input id="rdopt_poster" type="radio" name="rdopt" class="campos" value="POSTER" onchange="atualizarSelects()">
                    </td>
                    <td align="center">
                        <font size="4" color='gold'>
                            <b>
                                <i>Pacote: </i>
                            </b>
                        </font>
                        <select name="tam_ped" id="tam_ped" class="campos" style="width: 300px; height: 30px;" disabled>
                            <option value="" selected>Selecione</option>
                            <font size="4">
                                <?php
                                // Tamanhos
                                $sql_Tam = "SELECT * FROM produtos WHERE cod_prod IN ('9','10') ORDER BY nome_prod ASC";
                                $res_Tam = mysqli_query($conec, $sql_Tam) or die("File Error #2. Contate seu Administrador.");

                                while ($row_Tam = mysqli_fetch_assoc($res_Tam)) {
                                ?>
                                    <option value="<?php echo $row_Tam['nome_prod']; ?>"><?php echo $row_Tam['nome_prod']; ?></option>
                                <?php
                                }

                                ?>
                            </font>
                        </select>

                        <input type="hidden" name="txtuser" value="<?php echo $lg_user; ?>">
                        <input type="hidden" name="ref_std" value="<?php echo $ref_std; ?>">
                        <input type="hidden" name="txtdoc" value="<?php echo $NumDoc; ?>">
                        <input type="hidden" name="mat_vend" value="<?php echo $Mat_Vend; ?>">
                        <input type="hidden" name="vendedora" value="<?php echo $Vendedora; ?>">
                        <input type="hidden" name="cliente" value="<?php echo $Cliente; ?>">
                        <input type="hidden" name="txtvalor" value="<?php echo $VrPrest; ?>">
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

                    </td>
                </tr>
            </table><br>

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
            mysqli_close($conec); ?>

    <!-- Script para habilitar/desabilitar selects conforme o tipo selecionado -->
    <script>
        function atualizarSelects() {
            const rdoptBook = document.getElementById('rdopt_book');
            const rdoptPoster = document.getElementById('rdopt_poster');
            const selectPct = document.getElementById('pct_ped');
            const selectTam = document.getElementById('tam_ped');

            if (rdoptBook.checked) {
                selectPct.disabled = false;
                selectTam.disabled = true;
                selectTam.value = '';
            } else if (rdoptPoster.checked) {
                selectPct.disabled = true;
                selectTam.disabled = false;
                selectPct.value = '';
            } else {
                selectPct.disabled = true;
                selectTam.disabled = true;
                selectPct.value = '';
                selectTam.value = '';
            }
        }

        // Função de validação antes de enviar
        function checkdata() {
            const rdoptBook = document.getElementById('rdopt_book');
            const rdoptPoster = document.getElementById('rdopt_poster');
            const selectPct = document.getElementById('pct_ped');
            const selectTam = document.getElementById('tam_ped');

            // Validar se selecionou Book ou Poster
            if (!rdoptBook.checked && !rdoptPoster.checked) {
                alert('Selecione BOOK ou POSTER!');
                return false;
            }

            // Validar se selecionou Book
            if (rdoptBook.checked) {
                if (selectPct.value === '' || selectPct.value === null) {
                    alert('Selecione um Pacote de BOOK!');
                    selectPct.focus();
                    return false;
                }
            }

            // Validar se selecionou Poster
            if (rdoptPoster.checked) {
                if (selectTam.value === '' || selectTam.value === null) {
                    alert('Selecione um Tamanho de POSTER!');
                    selectTam.focus();
                    return false;
                }
            }

            return true;
        }

        // Inicializar ao carregar a página
        document.addEventListener('DOMContentLoaded', function() {
            atualizarSelects();
        });
    </script>

</body>

</html>