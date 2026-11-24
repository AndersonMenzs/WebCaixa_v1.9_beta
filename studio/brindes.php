<html>

<head>
    <title>WebCaixa v1.20.21_beta</title>
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
                            },
                            error: function() {
                                response([]);
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
            var vendedora = document.getElementById('vendedora_hidden').value.trim();
            var colaboradora = document.getElementById('mat_vend_input').value.trim();
            var cliente = document.getElementById('cliente').value.trim();
            var brinde = document.getElementById('ref_taxbrinde');

            if (mat_vend.length === 0) {
                alert('O campo Matrícula da Vendedora é obrigatório.');
                document.getElementById('mat_vend_input').focus();
                return false;
            }
            if (vendedora.length === 0 && colaboradora.length === 0) {
                alert('Selecione uma colaboradora na lista.');
                document.getElementById('mat_vend_input').focus();
                return false;
            }
            if (cliente.length <= 2) {
                alert('O campo Cliente deve ter mais que 2 letras.');
                document.getElementById('cliente').focus();
                return false;
            }
            if (brinde && brinde.value.length === 0) {
                alert('Selecione o brinde.');
                brinde.focus();
                return false;
            }

            return true;
        }

        function limpaSelecaoVendedora(formulario) {
            setTimeout(function() {
                document.getElementById('mat_vend').value = '';
                document.getElementById('vendedora_hidden').value = '';
                document.getElementById('mat_vend_input').style.borderColor = '';
                if (formulario) {
                    formulario.querySelector('#mat_vend_input').focus();
                }
            }, 0);
        }
    </script>

</head>

<body background="../images/bg1.jpg" text="#FFFFFF" onLoad="putFocus(0,0)">

    <?php
    $Sis     = "S7";
    $Rot     = "S7R2.1";
    $lg_user = isset($_REQUEST['c_s']) ? trim($_REQUEST['c_s']) : '';
    $lg_userEsc = htmlspecialchars($lg_user, ENT_QUOTES, 'UTF-8');
    $lg_userUrl = urlencode($lg_user);
    $user = substr($lg_user, 0, 8);
    $pss  = substr($lg_user, 8, 40);

    $mat_vend = isset($mat_vend) ? $mat_vend : '';

    if (isset($_REQUEST['mat_vend'])) $mat_vend = trim($_REQUEST['mat_vend']);

    $matVendEsc = htmlspecialchars($mat_vend, ENT_QUOTES, 'UTF-8');

    include "conexao.php";
    include "dbselect.php";

    include "us_sist.php";
    if ($ch == 'no') {
        include "us_cad.php";
    }
    include "valida_caixa.php";

    if ($ch == 'ok-enc' or $ch == 'ok-cai' or $ch == 'ok') {
        bloquear_se_caixa_anterior_aberto($conec, $lg_user);
    }
     
    ?>

    <table width='100%' border='0' cellpadding='0' cellspacing='0'>
        <tr>
            <td width='9%'>
                <a href="servrec.php?c_s=<?php echo $lg_userUrl ?>"><img src="./images/voltar.gif"></a>
            </td>
            <td width='82%' align='center'>
                <font color="gold" size="6"><b>
                        <center><u><i>BRINDES</i></u></center>
                    </b></font><br><br><br>
            </td>
            <td width='9%'>
                <a href="servrec.php?c_s=<?php echo $lg_userUrl; ?>"><img src="./images/voltar.gif"></a>
            </td>
        </tr>
    </table>

    <?php if ($ch == 'ok-enc' or $ch == 'ok-cai' or $ch == 'ok-adm' or $ch == 'ok') { ?>
        <form name="taxaProd" method="post" action="brindes_tipo.php?c_s=<?php echo $lg_userUrl; ?>" onsubmit="return validaCampos()" onreset="limpaSelecaoVendedora(this)" autocomplete="off">
            <table width="90%" border="5" cellpadding="10" cellspacing="0" align="center">
                <tr>
                    <td width="30%" align="center">
                        <font color='#FFFFFF' size='5'><b><i>Colaboradora</i></b></font>
                    </td>
                    <td width="30%" align="center">
                        <font color='#FFFFFF' size='5'><b><i>Cliente</i></b></font>
                    </td>
                    <td width="40%" align="center">
                        <font color='#FFFFFF' size='5'><b><i>Brinde</i></b></font>
                    </td>
                </tr>
                <tr>
                    <td align="center">
                        <input type="text" id="mat_vend_input" name="mat_vend_input" size="40" maxlength="100" class="campos"
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
                    <td align="center">

                        <?php
                            // Consulta na tabela produtos

                            $sqlB = "SELECT * FROM produtos WHERE desc_prod = 'B' ORDER BY nome_prod";
                            $resB = mysqli_query($conec, $sqlB) or die("Error in query: $sqlB");

                            // Verifica se há resultados
                            $numBrindes = mysqli_num_rows($resB);
                            if ($numBrindes > 0) {
                                echo '<select name="ref_taxbrinde" id="ref_taxbrinde" class="campos" style="font-size: 16px; width: 480px; height: 22px;" required>';
                                echo '<option value="" disabled selected>Selecione</option>';
                                while ($rowB = mysqli_fetch_assoc($resB)) {
                                    $cod_prod = htmlspecialchars($rowB['cod_prod'], ENT_QUOTES, 'UTF-8');
                                    $nome_prod = htmlspecialchars($rowB['nome_prod'], ENT_QUOTES, 'UTF-8');
                                    echo '<option value="' . $cod_prod . '">' . $nome_prod . '</option>';
                                }
                                echo '</select>';
                            } else {
                                echo "<font color='gold'>Nenhum brinde cadastrado.</font>";
                            }
                            mysqli_free_result($resB);
                        ?>
                    </td>
                </tr>
            </table><br>

            <table width="100%" border="0" cellspacing="0">
                <tr>
                    <td width="9%"></td>
                    <td width="82%" align="center">
                        <input type="hidden" name="txtuser" value="<?php echo $lg_userEsc; ?>">
                        <input type='submit' name='btenviar' value='Continuar' <?php echo (isset($numBrindes) && $numBrindes === 0) ? 'disabled' : ''; ?>>&nbsp;&nbsp;
                        <input type='reset' name='btreset' value='Limpar'><br><br>
                    </td>
                    <td width="9%" align="right"></td>
                </tr>
            </table><br>
        </form>
    <?php } else { ?>
        <br><br>
        <center>
            <font size='6'><b>Acesso <font color='gold'><u>não autorizado</u></font>!</b></font>
        </center><br><br>
        <center><a href='servrec.php?c_s=<?php echo $lg_userUrl; ?>'><img src='images/voltar.gif'></a></center><br>
    <?php } ?>

    <?php
    $SisRot = "S-7.2.1";
    include "rodape.php";
    mysqli_close($conec);
    ?>

</body>

</html>
