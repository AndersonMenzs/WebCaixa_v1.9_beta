<head>
    <title>WebCaixa v1.19_beta</title>
    <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
    <style type="text/css">
        body {
            margin-top: 5%;
            margin-left: 3%;
            margin-right: 3%;
            border: 3px solid gray;
            padding: 10px 10px 10px 10px;
            font-family: sans-serif;
        }

        .campos {
            background-color: #C0C0C0;
            font: 16px sans-serif;
            color: #000000;
        }

        /* Estilo para o autocomplete */
        .ui-autocomplete {
            max-height: 200px;
            overflow-y: auto;
            overflow-x: hidden;
            background-color: #fff;
            color: #000;
            border: 1px solid #ccc;
        }

        .ui-menu-item {
            padding: 5px;
        }

        .ui-menu-item:hover {
            background-color: #f0f0f0;
            cursor: pointer;
        }
    </style>

    <script type="text/javascript" src="val_taxaprod.js" charset="utf-8"></script>

    <!-- Adicionando jQuery UI para o autocomplete -->
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js"></script>


    <?php
    // Inserindo o Cabeçalho
    include "../cabecprs.php";
    ?>

    <script>
        function FormataValor(Formulario, Campo, TeclaPres) {
            var tecla = TeclaPres.keyCode;
            var strCampo;
            var vr;
            var tam;
            var TamanhoMaximo = 10;

            eval("strCampo = document." + Formulario + "." + Campo);

            vr = strCampo.value;
            vr = vr.replace("/", "");
            vr = vr.replace("/", "");
            vr = vr.replace("/", "");
            vr = vr.replace(",", "");
            vr = vr.replace(".", "");
            vr = vr.replace(".", "");
            vr = vr.replace(".", "");
            vr = vr.replace(".", "");
            vr = vr.replace(".", "");
            vr = vr.replace(".", "");
            vr = vr.replace(".", "");
            vr = vr.replace("-", "");
            vr = vr.replace("-", "");
            vr = vr.replace("-", "");
            vr = vr.replace("-", "");
            vr = vr.replace("-", "");
            tam = vr.length;

            if (tam < TamanhoMaximo && tecla != 8) {
                tam = vr.length + 1;
            }

            if (tecla == 8) {
                tam = tam - 1;
            }

            if (tecla == 8 || tecla >= 48 && tecla <= 57 || tecla >= 96 && tecla <= 105) {
                if (tam <= 3) {
                    strCampo.value = vr;
                }
                if ((tam > 3) && (tam <= 10)) {
                    strCampo.value = vr.substr(0, tam - 3) + '.' + vr.substr(tam - 3, tam);
                }
            }
        }

        function putFocus(formInst, elementInst) {
            if (document.forms.length > 0) {
                document.forms[formInst].elements[elementInst].focus();
            }
        }

        function validate(field) {
            var valid = ".0123456789"
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
        
        function validaCampos() {
            // Validação da soma dos valores
            function parseValor(valor) {
                return parseFloat(valor.replace(',', '.')) || 0;
            }

            var vlrUnico = parseValor(document.taxaProd.vlr_unico.value);
            var v1 = parseValor(document.taxaProd.txt1.value);
            var v2 = parseValor(document.taxaProd.txt2.value);
            var v3 = parseValor(document.taxaProd.txt3.value);
            var soma = v1 + v2 + v3;

            vlrUnico = Math.round(vlrUnico * 100) / 100;
            soma = Math.round(soma * 100) / 100;

            if (vlrUnico > 0 && soma !== vlrUnico) {
                var diferenca = soma - vlrUnico;
                var msg = diferenca > 0 ?
                    "A soma dos valores está MAIOR em R$" + Math.abs(diferenca).toFixed(2) :
                    "A soma dos valores está MENOR em R$" + Math.abs(diferenca).toFixed(2);
                alert(msg);
                return false;
            }

            // Validação das formas de pagamento únicas
            var fp1 = document.taxaProd.lsPr1.value;
            var fp2 = document.taxaProd.lsPr2.value;
            var fp3 = document.taxaProd.lsPr3.value;

            // Verifica se há valores repetidos, ignorando valores vazios ou "Selecione"
            var formasPreenchidas = [];

            // Adiciona apenas formas de pagamento válidas (não vazias)
            if (fp1 && fp1 !== "" && fp1 !== "Selecione") formasPreenchidas.push({
                value: fp1,
                select: document.taxaProd.lsPr1
            });
            if (fp2 && fp2 !== "" && fp2 !== "Selecione" && fp2 !== fp3) formasPreenchidas.push({
                value: fp2,
                select: document.taxaProd.lsPr2
            });
            if (fp3 && fp3 !== "" && fp3 !== "Selecione" && fp3 !== fp2) formasPreenchidas.push({
                value: fp3,
                select: document.taxaProd.lsPr3
            });
            
            // Verifica duplicatas entre as formas preenchidas
            var valores = formasPreenchidas.map(item => item.value);
            var duplicatas = valores.filter((item, index) => valores.indexOf(item) !== index);

            if (duplicatas.length > 0) {
                // Buscar o texto da opção repetida
                var texto = "";
                for (var i = 0; i < formasPreenchidas.length; i++) {
                    if (formasPreenchidas[i].value === duplicatas[0]) {
                        for (var j = 0; j < formasPreenchidas[i].select.options.length; j++) {
                            if (formasPreenchidas[i].select.options[j].value === duplicatas[0]) {
                                texto = formasPreenchidas[i].select.options[j].text;
                                break;
                            }
                        }
                        if (texto) break;
                    }
                }
                alert("A forma de pagamento '" + texto + "' foi repetida.\nSelecione formas diferentes.");
                return false;
            }

            return true;
        }

        function validarSomaValores() {
            var vlrUnico = parseFloat(document.taxaProd.vlr_unico.value.replace('.', '').replace(',', '.')) || 0;
            var v1 = parseFloat(document.taxaProd.txt1.value.replace('.', '').replace(',', '.')) || 0;
            var v2 = parseFloat(document.taxaProd.txt2.value.replace('.', '').replace(',', '.')) || 0;
            var v3 = parseFloat(document.taxaProd.txt3.value.replace('.', '').replace(',', '.')) || 0;
            var soma = v1 + v2 + v3;

            // Arredonda para duas casas decimais
            vlrUnico = Math.round(vlrUnico * 100) / 100;
            soma = Math.round(soma * 100) / 100;

            if (vlrUnico > 0 && soma !== vlrUnico) {
                var diferenca = soma - vlrUnico;
                var msg = diferenca > 0 ?
                    "A soma dos valores está MAIOR em R$ " + Math.abs(diferenca).toFixed(2) :
                    "A soma dos valores está MENOR em R$ " + Math.abs(diferenca).toFixed(2);
                alert(msg);
            }
        }

        // Adiciona o evento de validação nos campos
        window.onload = function() {
            document.taxaProd.vlr_unico.onblur = validarSomaValores;
            document.taxaProd.txt1.onblur = validarSomaValores;
            document.taxaProd.txt2.onblur = validarSomaValores;
            document.taxaProd.txt3.onblur = validarSomaValores;
        };

        function fPassaAlfaNumerico(tipo) {
            return function(e) {
                let char = String.fromCharCode(e.which);
                if (tipo === 'an') {
                    // permite apenas letras e números
                    if (!/^[a-zA-Z0-9\s]$/.test(char)) {
                        e.preventDefault();
                    }
                }
            };
        }

        function validnome(input) {
            // remove tudo que não for letra, número ou espaço
            input.value = input.value.replace(/[^A-Z0-9\s]/g, '');

            // exemplo: exige pelo menos 3 caracteres
            if (input.value.length < 3) {
                input.style.borderColor = "red";
            } else {
                input.style.borderColor = "";
            }
        }
    </script>

    <script src="val_prod.js" charset="utf-8"></script>

</head>

<body background="../images/bg1.jpg" text="#FFFFFF" onLoad="putFocus(0,0)">

    <?php
    // Obtendo o Login
    $Sis     = "S7";
    $Rot     = "S7R2.1";
    $lg_user = $_REQUEST['c_s'];
    $user = substr($lg_user, 0, 8);
    $pss  = substr($lg_user, 8, 40);
    $DataHj = date('Y-m-d');

    // Recebendo valores
    $Vendedora = trim($_POST['vendedora']);
    $Cliente    = trim($_POST['cliente']);
    $DataNasc    = trim($_POST['data_nasc']);

    // Calculando quantos anos tem
    $partes = explode('/', $DataNasc);
    $ano = $partes[2];
    $idade = date('Y') - $ano;
    if (date('md') < date('md', strtotime($DataNasc))) {
        $idade--;
    }

    // Obtendo Valor Atualizado
    include "conexao.php";
    include "dbselect.php";

    $sql = "select * from taxas where codigo = 'TXP' order by datalt desc";
    $rs  = mysqli_query($conec, $sql) or die("Erro de Banco de Dados #1");
    $ln  = mysqli_fetch_array($rs);
    $DataAlt = $ln['datalt'];
    $Codigo  = $ln['codigo'];
    $VrProd  = $ln['vltx'];
    $VrProdF = number_format($VrProd, 2, ',', '.');

    // Condição para gratuidade para maiores de 60 anos
    if ($idade >= 60) {
        $VrProd = 0;
        $VrProdF = number_format($VrProd, 2, ',', '.');
    }

    // Obtendo Valor Anterior
    $sqlA  = "select * from taxas where codigo = 'TXP' and vltx <> $VrProd order by datalt desc";
    $rsA   = mysqli_query($conec, $sqlA) or die("Erro de Banco de Dados #2");
    $lnA   = mysqli_fetch_array($rsA);
    $DtAltA = $lnA['datalt'];
    $CodA   = $lnA['codigo'];
    $VrAnt   = $lnA['vltx'];
    $VrAntF = number_format($VrAnt, 2, ',', '.');

    // Consultando o último recibo dentro das rotinas TXP, TXC, PROD e BOOK
    $sql = "SELECT numdoc, datarec FROM registro 
        WHERE numdoc >= 21700000 
        AND datarec >= '2025-08-29' 
        AND subtipo IN ('TXP', 'TXC', 'PROD', 'BOOK') 
        ORDER BY numdoc DESC";
    $rs  = mysqli_query($conec, $sql) or die('Erro #3!');
    $ln  = mysqli_fetch_array($rs);
    $NumDoc = $ln['numdoc'];
    $DataRec = $ln['datarec'];

    // Condição para usar o próximo número do recibo
    if ($DataHj >= $DataRec) {
        $NumDoc = $NumDoc + 1;
    } else {
        echo "Entre em contato com o administrador do sistema.";
    }

    include "us_sist.php";
    if ($ch == 'no') {
        include "us_cad.php";
    } ?>

    <table width='100%' border='0' cellpadding='0' cellspacing='0'>
        <tr>
            <td width='9%'>
                <a href="taxaprod.php?c_s=<?php echo $lg_user ?>"><img src="./images/voltar.gif"></a>
            </td>
            <td width='82%' align='center'>
                <font color="gold" size="6"><b>
                        <center><u><i>TAXA DE PRODUÇÃO</i></u></center>
                    </b></font>
                <font size="5" color="#FFFFFF"><b>
                        <center><u><i>Valor Atual - <font color="aqua">R$ <?php echo $VrProdF; ?></i></u></center>
                    </b></font><br>
            </td>
            <td width='9%'>
                <a href="taxaprod.php?c_s=<?php echo $lg_user; ?>"><img src="./images/voltar.gif"></a>
            </td>
        </tr>

        <tr>
            <td></td>
            <td>
                <?php
                // Verificando se a cliente é maior que 60 anos
                if ($idade >= 60) {
                ?>
                    <center>
                        <font color='lime' size='7'>
                            <b>
                                <i>Cliente Sênior</i>
                            </b>
                        </font>
                    </center>
                <?php
                }
                ?>
            </td>
            <td></td>
        </tr>
    </table><br>
    <?php

    if ($ch == 'ok-enc' or $ch == 'ok-cai' or $ch == 'ok-adm' or $ch == 'ok') {
    ?>
        <form name="taxaProd" method="post" action="confprod.php" onsubmit="return validaCampos() && validarSomaValores();" autocomplete="off">
            <table width="80%" border="5" cellpadding="10" cellspacing="0" align="center">
                <tr>
                    <td width="40%" align="center">
                        <font color='#FFFFFF' size='5'><b><i>Vendedora</i></b></font>
                    </td>
                    <td width="40%" align="center">
                        <font color='#FFFFFF' size='5'><b><i>Cliente</i></b></font>
                    </td>
                    <td width="20%" align="center">
                        <font color='#FFFFFF' size='5'><b><i>Data Nasc.</i></b></font>
                    </td>
                </tr>
                <tr>
                    <td align="center">
                        <font color='gold' size='4'><b><i><?php echo $Vendedora; ?></i></b></font>
                        <input type="hidden" name="vendedora" value="<?php echo $Vendedora; ?>">
                    </td>
                    <td align="center">
                        <font color='lime' size='4'><b><i><?php echo $Cliente; ?></i></b></font>
                        <input type="hidden" name="cliente" value="<?php echo $Cliente; ?>">
                    </td>
                    <td align="center">
                        <font color='gold' size='4'><b><i><?php echo $DataNasc; ?></i></b></font>
                        <input type="hidden" name="data_nasc" value="<?php echo $DataNasc; ?>">
                    </td>
                </tr>
            </table><br>

            <table width="80%" border="5" cellpadding="10" cellspacing="0" align="center">
                <input type="hidden" name="vlr_unico" value="<?php echo $VrProd; ?>">
                <tr>
                    <td align="center">
                        <font size='5'><b><i>Nº Recibo</i></b></font>
                    </td>
                    <td align="center">
                        <font color='gold' size='5'>
                            <b>
                                <i>
                                    <blink>Amizade Premiada?</blink>
                                </i>
                            </b>
                        </font>
                    </td>
                    <td align="center">
                        <font size='5'><b><i>Forma de Pagamento</i></b></font>
                    </td>
                    <td align="center">
                        <font size='5'><b><i>Valor</i></b></font>
                    </td>
                </tr>

                <tr>
                    <td rowspan="4" align="center">
                        <font size='5'><b><i><?php echo $NumDoc; ?></i></b></font>
                        <input type='hidden' name='txtdoc' size='10' maxlength='8' class='campos' value="<?php echo $NumDoc; ?>">
                    </td>
                    <td rowspan="4" align="center">
                        <font color='lime' size='5'><b><i>Não </i></b></font><input type='radio' name='rdtaxa' value='N' checked>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        <font size='5'><b><i>Sim </i></b></font><input type='radio' name='rdtaxa' value='S'>
                        <input type="hidden" name="txtvrprod" value="<?php echo $VrProd; ?>">
                        <input type="hidden" name="txtvrprodf" value="<?php echo $VrProdF; ?>">
                        <!--<input type="hidden" name="txtAP" value="<?php echo $VrAnt; ?>">
                        <input type="hidden" name="txtAPf" value="<?php echo $VrAntF; ?>">-->
                        <input type="hidden" name="txtuser" value="<?php echo $lg_user; ?>">
                    </td>
                    <td align="center">
                        <?php
                        // Verificando se é maior de 60 anos
                        if ($idade >= 60) {
                        ?>
                            <font color='lime' size='5'><b><i>GRATUIDADE</i></b></font>
                            <input type="hidden" name="lsPr1" value="99">
                            <input type="hidden" name="txt1" value="0.00">
                        <?php
                        } else {
                        ?>
                            <select name="lsPr1" class="campos">
                                <?php
                                // Obtendo a Relação
                                include "dbselect.php";
                                $sqlpr1 = "select * from formapag where codpag <= 30 or codpag >= 70 order by codpag";
                                $rspr1 = mysqli_query($conec, $sqlpr1) or die("Não foi possível acessar os Dados");
                                while ($lnpr1 = mysqli_fetch_array($rspr1)) {
                                    $CodPag1  = $lnpr1['codpag'];
                                    $ModPag1  = $lnpr1['modpag'];
                                    echo "<option value='$CodPag1' class='campos'>$ModPag1</option>";
                                }
                                mysqli_free_result($rspr1);
                                ?>
                            </select>
                        <?php
                        }
                        ?>

                    </td>
                    <td align="center">
                        <font size="5"><b><i>R$ </i></b></font>

                        <?php
                        // Verificando se é maior de 60 anos
                        if ($idade >= 60) {
                        ?>
                            <font size='5'><b><i>0,00</i></b></font>
                            <input type="hidden" name="txt1" value="0.00">
                        <?php
                        } else {
                        ?>
                            <input type="text" name="txt1" size="6" maxlength="6" class="campos" OnKeyUp="FormataValor('taxaProd', 'txt1', event); ">
                        <?php
                        }
                        ?>
                    </td>
                </tr>

                <?php
                // Verifica se é menor de 60 anos para liberar os outros campos
                if ($idade < 60) {
                ?>
                    <tr>
                        <td align="center">
                            <select name="lsPr2" class="campos">
                                <?php
                                include "dbselect.php";
                                $sqlpr2 = "select * from formapag where codpag <= 30 or codpag >= 70 order by codpag";
                                $rspr2 = mysqli_query($conec, $sqlpr2) or die("Não foi possível acessar os Dados");

                                // Criando o Array para o campo PC
                                while ($lnpr2 = mysqli_fetch_array($rspr2)) {
                                    $CodPag2  = $lnpr2['codpag'];
                                    $ModPag2  = $lnpr2['modpag'];
                                ?>
                                    <option value="<?php echo $CodPag2; ?>" class="campos"><?php echo "$ModPag2"; ?></option>
                                <?php
                                }
                                mysqli_free_result($rspr2);
                                ?>
                            </select>
                        </td>
                        <td align="center">
                            <font size="5"><b><i>R$ </i></b></font>
                            <input type="text" name="txt2" size="6" maxlength="6" class="campos" OnKeyUp="FormataValor('taxaProd', 'txt2', event); ">
                        </td>
                    </tr>

                    <tr>
                        <td align="center">
                            <select name="lsPr3" class="campos">
                                <?php
                                include "dbselect.php";
                                $sqlpr3 = "select * from formapag where codpag <= 30 or codpag >= 70 order by codpag";
                                $rspr3 = mysqli_query($conec, $sqlpr3) or die("Não foi possível acessar os Dados");

                                // Criando o Array para o campo PC
                                while ($lnpr3 = mysqli_fetch_array($rspr3)) {
                                    $CodPag3  = $lnpr3['codpag'];
                                    $ModPag3  = $lnpr3['modpag'];
                                ?>
                                    <option value="<?php echo $CodPag3; ?>" class="campos"><?php echo "$ModPag3"; ?></option>
                                <?php
                                }
                                mysqli_free_result($rspr3);
                                ?>
                            </select>
                        </td>
                        <td align="center">
                            <font size="5"><b><i>R$ </i></b></font>
                            <input type="text" name="txt3" size="6" maxlength="6" class="campos" OnKeyUp="FormataValor('taxaProd', 'txt3', event); ">
                        </td>
                    </tr>
                <?php
                }
                ?>
            </table><br>

            <table width="100%" border="0" cellspacing="0">
                <tr>
                    <td width="9%"></td>
                    <td width="82%" align="center">
                        <input type="hidden" name="txtuser" value="<?php echo $lg_user; ?>">
                        <input type='submit' name='btenviar' value='Continuar'>
                        <?php
                        // Verificando se é maior de 60 anos
                        if ($idade < 60) {
                        ?> &nbsp;&nbsp;
                            <input type='reset' name='btreset' value='Limpar'><br><br>
                        <?php
                        } ?>
                    </td>
                    <td width="9%" align="right"></td>
                </tr>
            </table><br>
        </form>
    <?php
    } else { ?>
        <br><br>
        <font size='6'><b>
                <center>Acesso <font color='gold'>
                        <blink><u>não Autorizado</u>
                        </blink>
                        <font color='#FFFFFF'>!!!</center>
            </b></font><br><br>
        <center><a href='servrec.php?c_s=<?php echo $lg_user; ?>'><img src='images/voltar.gif'></a></center><br>
    <?php
    }

    // Encerrando as Conexões
    $SisRot = "S-7.2.1";
    include "../rodape.php";
    mysqli_close($conec);
    ?>

</body>

</html>