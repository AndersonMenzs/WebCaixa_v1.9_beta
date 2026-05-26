<html>

<head>
	<title>WebCaixa v1.20.16_beta</title>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
	<style type="text/css">
		body {
			margin-top: 4%;
			margin-left: 1%;
			margin-right: 1%;
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

    <link rel="stylesheet" href="./css/themes.css">
    <script src="./js/jquery.js"></script>
    <script src="./js/ui.js"></script>


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

	<script src="val_retif.js" charset="utf-8"> </script>

</head>

<body background="../images/bg1.jpg" text="#FFFFFF">

	<?php
	include "../cabecprs.php";

	// Obtendo o Login
	$Sis        = "S7";
	$Rot       = "S7R0.6";
	$lg_user   = $_REQUEST['c_s'];
	$user    = substr($lg_user, 0, 8);
	$mat1 = substr($user, 0, 1);
	$mat2 = substr($user, 1, 3);
	$mat3 = substr($user, 4, 3);
	$dv   = substr($user, 7, 1);
	$userF     = "$mat1.$mat2.$mat3-$dv";
	$pss     = substr($lg_user, 8, 40);
	$Data      = date('Y-m-d');
	$Ano       = date('Y');

   // inicializa variáveis usadas no form para evitar undefined
   $mat_vend = isset($mat_vend) ? $mat_vend : '';
   $std = isset($_REQUEST['ref_std']) ? trim($_REQUEST['ref_std']) : '';

   // se vierem via REQUEST/POST, use-os
   if (isset($_REQUEST['mat_vend'])) $mat_vend = trim($_REQUEST['mat_vend']);

   $matVendEsc  = htmlspecialchars($mat_vend, ENT_QUOTES);

	include "us_sist.php";
	if ($ch == 'no') {
		include "us_cad.php";
	}

	if ($ch == 'ok') { ?>
		<form name="retif" method="post" action="confretif.php" onsubmit="return validaCampos()" autocomplete="off">
			<br>
			<font size='6' color='gold'><b><u><i>
							<center>Retificação de Lançamento</center>
						</i></u></b></font><br><br>
			<?php

			// Obtendo Dados Anteriores
			include "dbselect.php";
			$sql = "select dtopen, numerario, incsobra from caixa order by dtopen desc";
			$rs  = mysqli_query($conec, $sql) or die("Não foi possível acessar o Cadastro.");
			$ln = mysqli_fetch_array($rs);
			$DtOpen    = $ln['dtopen'];
			mysqli_free_result($rs);

			if ($DtOpen <> $Data) { ?>
				<br><br>
				<font size='6'><b>
						<center>Primeiro é Preciso <font color='gold'>
								<blink><u>Abrir o Caixa</u>
								</blink>
								<font color='#FFFFFF'>!!!</center>
					</b></font><br>
				<center><a href='aud.php?c_s=<?php echo $lg_user; ?>'><img src='images/voltar.gif'></a></center><br>
			<?php
			} else { ?>
				<table width="75%" border="05" cellpadding="05" cellspacing="0" align="center">
					<tr>
						<td>
							<font size="5"><b></i>Nº Autenticação: </i></b></font>
							<input type="text" name="txtaut" size="4" maxlength="4" class="campos" OnKeyUp="validate(this)">
						</td>
						<td align='right'>
							<font size="5"><b></i>Fita: </i></b></font>
							<input type="text" name="txtfita" size="4" maxlength="4" class="campos" OnKeyUp="validate(this)">
							<font color='gold' size="5"><b></i>/<blink><?php echo $Ano; ?></blink></i></b></font>
						</td>
					</tr>

					<tr>
						<td>
							<font size="5"><b></i>Resp. p/ Autenticação: </i></b></font>
                        <input type="text" id="mat_vend_input" name="mat_vend_input" size="40" maxlength="8" class="campos"
                            onkeypress="fPassaAlfaNumerico('an')"
                            onkeyup='this.value=this.value.toUpperCase(); validnome(this)' required autofocus>
                        <input type="hidden" name="mat_vend" id="mat_vend" value="<?php echo $matVendEsc; ?>">
                        <input type="hidden" name="vendedora" id="vendedora_hidden" value="">
						</td>
						<td align='right'>
							<font size="5"><b></i>Valor Autenticado: R$ </i></b></font>
							<input type="text" name="txtvalor" size="7" maxlength="7" class="campos" OnKeyUp="FormataValor('retif', 'txtvalor', event); validate(this)">
						</td>
					</tr>

					<tr>
						<td>
							<font size="5"><b></i>Retificar de</i></b></font>
							<select name="lsde" class="campos">
								<?php
								// Conectando ao Banco de Dados
								include "dbselect.php";

								// Criando a Instrução SQL de Consulta
								$sqlpr = "select * from formapag where codpag <= 31 or codpag >= 70 order by codpag";

								// Consultando os Registros
								$rspr = mysqli_query($conec, $sqlpr) or die("Não foi possível acessar os Dados");

								// Criando o Array para o campo PC
								while ($lnpr = mysqli_fetch_array($rspr)) {
									$CodPag  = $lnpr['codpag'];
									$ModPag  = $lnpr['modpag']; ?>

									<option value="<?php echo $CodPag; ?>" class="campos"><?php echo "$ModPag"; ?></option>
								<?php
								} ?>
							</select>
						</td>
						<td align='right'>
							<font size="5"><b></i>Para</i></b></font>
							<select name="lspara" class="campos">
								<?php

								// Criando a Instrução SQL de Consulta
								$sqlpr = "select * from formapag where codpag <= 31 or codpag >= 70 order by codpag";

								// Consultando os Registros
								$rspr = mysqli_query($conec, $sqlpr) or die("Não foi possível acessar os Dados");

								// Criando o Array para o campo PC
								while ($lnpr = mysqli_fetch_array($rspr)) {
									$CodPag  = $lnpr['codpag'];
									$ModPag  = $lnpr['modpag']; ?>

									<option value="<?php echo $CodPag; ?>" class="campos"><?php echo "$ModPag"; ?></option>
								<?php
								}
								mysqli_free_result($rspr); ?>
							</select>
						</td>
					</tr>
				</table><br><br>

				<table width="100%" border="0" cellpadding="0" cellspacing="0" align="center">
					<tr>
						<td width='33%'>
							<a href="aud.php?c_s=<?php echo $lg_user ?>"><img src="./images/voltar.gif"></a>
						</td>
						<td width='34%' align='center'>
							<input type="hidden" name="txtuser" value="<?php echo $lg_user; ?>">
							<input type="hidden" name="txtopen" value="<?php echo $DtOpen; ?>">
							<input type="hidden" name="txtnumer" value="<?php echo $Numer; ?>">
							<input type="hidden" name="txtincsobra" value="<?php echo $IncSobra; ?>">
							<input type="submit" name="btOK" value="Confirmar">&nbsp;&nbsp;
							<input type="reset" name="btReset" value="Limpar">
						</td>
						<td width='33%' align='right'>
							<a href="aud.php?c_s=<?php echo $lg_user ?>"><img src="./images/voltar.gif"></a>
						</td>
					</tr>
				</table>
				</p>
		</form>

		<meta http-equiv="refresh" content="120;URL=./acaud.php?c_s=<?php echo $lg_user; ?>">
	<?php
			}
		} else { ?>
	<br><br><br>
	<font size='5'><b>
			<center>Acesso <font color='gold'>
					<blink><u>não Autorizado</u>
					</blink>
					<font color='#FFFFFF'>!!!</center>
		</b></font><br><br><br>
	<center><a href='index.php?c_s=<?php echo $lg_user; ?>'><img src='images/voltar.gif'></a></center><br><br>
<?php
		}

		// Formatando Valores para Impressão
		$SisRot = "S-7.0.6";
		include "rodape.php"; ?>

</body>

</html>