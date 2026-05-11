<html>

<head>
    <title>WebCaixa v1.20.6_beta</title>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
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

        #tb1,
        #tb2 {
            display: none;
        }
    </style>

   <!-- Adicionando jQuery UI para o autocomplete -->
   <link rel="stylesheet" href="./css/themes.css">
   <script src="./js/jquery.js"></script>
   <script src="./js/ui.js"></script>

    <?php
    include "../cabecprs.php";
    ?>

    <script>
        $(function() {
            function setupAutocomplete(element, tipo) {
                var $el = $(element);
                $el.autocomplete({
                    source: function(request, response) {
                        $.ajax({
                            url: "buscar_funcionarias.php",
                            dataType: "json",
                            data: {
                                term: request.term,
                                tipo: tipo
                            },
                            success: function(data) {
                                var items = [];

                                if (Array.isArray(data)) {
                                    items = data;
                                } else if (data && Array.isArray(data.nomes)) {
                                    for (var i = 0; i < data.nomes.length; i++) {
                                        items.push({
                                            label: data.nomes[i],
                                            value: data.nomes[i],
                                            mat: data.mat_vend && data.mat_vend[i] ? data.mat_vend[i] : ''
                                        });
                                    }
                                }

                                response(items);
                            },
                            error: function(xhr, status, err) {
                                console.error("Erro na requisição:", status, err);
                                response([]);
                            }
                        });
                    },
                    minLength: 2,
                    delay: 300,
                    select: function(event, ui) {
                        if (ui.item && ui.item.mat) {
                            $('#mat_vend').val(ui.item.mat);
                        }
                        $(this).val(ui.item ? ui.item.value : '');
                        return false;
                    },
                    focus: function(event, ui) {
                        $(this).val(ui.item ? ui.item.value : '');
                        return false;
                    }
                });

                var inst = $el.autocomplete("instance") || $el.data("ui-autocomplete") || $el.data("autocomplete");
                if (inst) {
                    inst._renderItem = function(ul, item) {
                        return $("<li>")
                            .append("<div>" + (item.label || item.value || "") + "</div>")
                            .appendTo(ul);
                    };
                }
            }

            function setupAutocompleteVendedora(element) {
                var $el = $(element);

                $el.autocomplete({
                    source: function(request, response) {
                        $.ajax({
                            url: "buscar_funcionarias.php",
                            dataType: "json",
                            data: {
                                term: request.term
                            },
                            success: function(data) {
                                var items = [];

                                if (data && Array.isArray(data.nomes)) {
                                    for (var i = 0; i < data.nomes.length; i++) {
                                        items.push({
                                            label: data.mat_vend[i] + ' - ' + data.nomes[i],
                                            value: data.nomes[i],
                                            mat: data.mat_vend[i],
                                            nome: data.nomes[i]
                                        });
                                    }
                                }

                                response(items);
                            }
                        });
                    },
                    minLength: 2,
                    delay: 300,

                    select: function(event, ui) {
                        $('#mat_vend').val(ui.item.mat);
                        $('#mat_vend_input').val(ui.item.nome);
                        $('#vendedora_hidden').val(ui.item.nome);
                        return false;
                    },

                    focus: function(event, ui) {
                        $(this).val(ui.item.nome);
                        return false;
                    }
                });

                var inst = $el.autocomplete("instance");
                if (inst) {
                    inst._renderItem = function(ul, item) {
                        return $("<li>")
                            .append("<div>" + item.label + "</div>")
                            .appendTo(ul);
                    };
                }
            }

            setupAutocompleteVendedora("#mat_vend_input");
        });

        function putFocus(formInst, elementInst) {
            if (document.forms.length > 0) {
                document.forms[formInst].elements[elementInst].focus();
            }
        }

        function validata(field) {
            var valid = "/0123456789"
            var ok = "yes";
            var temp;
            for (var i = 0; i < field.value.length; i++) {
                temp = "" + field.value.substring(i, i + 1);
                if (valid.indexOf(temp) == "-1") ok = "no";
            }
            if (ok == "no") {
                alert("Entrada Incorreta!\nDigite apenas algarismos!");
                field.value = "";
                field.focus();
                field.select();
            }
        }

        function FormataData(Formulario, Campo, TeclaPres) {
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
                if (tam <= 4) {
                    strCampo.value = vr;
                }
                if ((tam > 4) && (tam <= 7)) {
                    strCampo.value = vr.substr(0, tam - 2) + '/' + vr.substr(tam - 2, tam);
                }
                if ((tam > 7) && (tam <= 10)) {
                    strCampo.value = vr.substr(0, tam - 7) + '/' + vr.substr(tam - 7, 2) + '/' + vr.substr(tam - 5, tam);
                }
            }
        }

        function validvalor(field) {
            var valid = ".0123456789"
            var ok = "yes";
            var temp;
            for (var i = 0; i < field.value.length; i++) {
                temp = "" + field.value.substring(i, i + 1);
                if (valid.indexOf(temp) == "-1") ok = "no";
            }
            if (ok == "no") {
                alert("Entrada Incorreta! \n  Digite apenas algarismos!");
                field.value = "";
                field.focus();
                field.select();
            }
        }

        function FormataValor(Formulario, Campo, TeclaPres) {
            var tecla = TeclaPres.keyCode;
            var strCampo;
            var vr;
            var tam;
            var TamanhoMaximo = 6;

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
                if ((tam > 3) && (tam <= 6)) {
                    strCampo.value = vr.substr(0, tam - 3) + '.' + vr.substr(tam - 3, tam);
                }
            }
        }

        function fPassaAlfaNumerico(tipo) {
            return function(e) {
                let char = String.fromCharCode(e.which);
                if (tipo === 'an') {
                    if (!/^[a-zA-Z0-9\s]$/.test(char)) {
                        e.preventDefault();
                    }
                }
            };
        }

        function validnome(input) {
            input.value = input.value.replace(/[^A-Z0-9\s]/g, '');

            if (input.value.length < 3) {
                input.style.borderColor = "red";
            } else {
                input.style.borderColor = "";
            }
        }

        function validaCampos() {
            var mat_vend = document.getElementById('mat_vend').value.trim();
            var cliente = document.getElementById('cliente').value.trim();
            var dataNasc = document.getElementById('data_nasc').value.trim();

            if (mat_vend.length === 0) {
                alert('O campo Matrícula da Vendedora é obrigatório.');
                document.getElementById('mat_vend_input').focus();
                return false;
            }
            if (cliente.length <= 2) {
                alert('O campo Cliente deve ter mais que 2 letras.');
                document.getElementById('cliente').focus();
                return false;
            }

            return true;
        }
    </script>

</head>

<body background="../images/bg1.jpg" text="#FFFFFF" onLoad="putFocus(0,0)">

    <?php
    $Sis     = "S7";
    $Rot     = "S7R2.1";
    $lg_user = $_REQUEST['c_s'];
    $user = substr($lg_user, 0, 8);
    $pss  = substr($lg_user, 8, 40);

    $mat_vend = isset($mat_vend) ? $mat_vend : '';
    $std = isset($_REQUEST['ref_std']) ? trim($_REQUEST['ref_std']) : '';

    if (isset($_REQUEST['mat_vend'])) $mat_vend = trim($_REQUEST['mat_vend']);

    $matVendEsc  = htmlspecialchars($mat_vend, ENT_QUOTES);

    include "conexao.php";
    include "dbselect.php";

    include "us_sist.php";
    if ($ch == 'no') {
        include "us_cad.php";
    }
    ?>

    <table width='100%' border='0' cellpadding='0' cellspacing='0'>
        <tr>
            <td width='9%'>
                <a href="servrec.php?c_s=<?php echo $lg_user ?>"><img src="./images/voltar.gif"></a>
            </td>
            <td width='82%' align='center'>
                <font color="gold" size="6"><b>
                        <center><u><i>TAXA DE PRODUÇÃO</i></u></center>
                    </b></font><br><br><br>
            </td>
            <td width='9%'>
                <a href="servrec.php?c_s=<?php echo $lg_user; ?>"><img src="./images/voltar.gif"></a>
            </td>
        </tr>
    </table>

    <?php if ($ch == 'ok-enc' or $ch == 'ok-cai' or $ch == 'ok-adm' or $ch == 'ok') { ?>
        <form name="taxaProd" method="post" action="taxaprod_tipo.php?c_s=<?php echo $lg_user; ?>" onsubmit="return validaCampos()" autocomplete="off">
            <table width="70%" border="5" cellpadding="10" cellspacing="0" align="center">
                <tr>
                    <td width="45%" align="center">
                        <font color='#FFFFFF' size='5'><b><i>Colaboradora</i></b></font>
                    </td>
                    <td width="45%" align="center">
                        <font color='#FFFFFF' size='5'><b><i>Cliente</i></b></font>
                    </td>
                </tr>
                <tr>
                    <td align="center">
                        <input type="text" id="mat_vend_input" name="mat_vend_input" size="40" maxlength="8" class="campos"
                            onkeypress="fPassaAlfaNumerico('an')"
                            onkeyup='this.value=this.value.toUpperCase(); validnome(this)' required autofocus>
                        <input type="hidden" name="mat_vend" id="mat_vend" value="<?php echo $matVendEsc; ?>">
                        <input type="hidden" name="vendedora" id="vendedora_hidden" value="">
                    </td>
                    <td align="center">
                        <input type="text" id="cliente" name="cliente" size="40" maxlength="50" class="campos"
                            onkeypress="fPassaAlfaNumerico('an')"
                            onkeyup='this.value=this.value.toUpperCase(); validnome(this)' required>
                    </td>
                </tr>
                <tr>
                    <td align="center">
                        <font color='#FFFFFF' size='5'><b><i>Data Nascimento</i></b></font>
                    </td>
                    <td align="center">
                        <font color='#FFFFFF' size='5'><b><i>Produção</i></b></font>
                    </td>
                </tr>
                <tr>
                    <td align="center">
                        <input type="text" id="data_nasc" name="data_nasc" class="campos" placeholder="01/01/1940"
                            style="font-size: 16px; width: 300px;"
                            onkeyup="FormataData('taxaProd', 'data_nasc', event)" required>
                    </td>
                    <td align="center">
                        <select name="ref_taxprod" id="ref_taxprod" class="campos" style="font-size: 16px; width: 300px;" required>
                            <option value="normal" selected>Normal</option>
                            <option value="aghata">Cliente Aghata</option>
                            <option value="gratuidade">Cliente Sênior</option>
                            <option value="rev_estrella">Revelação Estrella</option>
                        </select>
                    </td>
                </tr>
            </table><br>

            <table width="100%" border="0" cellspacing="0">
                <tr>
                    <td width="9%"></td>
                    <td width="82%" align="center">
                        <input type="hidden" name="txtuser" value="<?php echo $lg_user; ?>">
                        <input type='submit' name='btenviar' value='Continuar'>&nbsp;&nbsp;
                        <input type='reset' name='btreset' value='Limpar'><br><br>
                    </td>
                    <td width="9%" align="right"></td>
                </tr>
            </table><br>
        </form>
    <?php } else { ?>
        <br><br>
        <font size='6'><b>
                <center>Acesso <font color='gold'><blink><u>não Autorizado</u></blink>
                        <font color='#FFFFFF'>!!!</center>
            </b></font><br><br>
        <center><a href='servrec.php?c_s=<?php echo $lg_user; ?>'><img src='images/voltar.gif'></a></center><br>
    <?php } ?>

    <?php
    $SisRot = "S-7.2.1";
    include "rodape.php";
    mysqli_close($conec);
    ?>

</body>

</html>