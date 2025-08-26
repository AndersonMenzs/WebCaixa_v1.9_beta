<html>

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

   <script>
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
   </script>

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
   </script>

   <?php
   // Inserindo o Cabeçalho
   include "../cabecprs.php";
   ?>

   <script type="text/javascript" src="val_contrato.js" charset="utf-8"></script>

   <!-- Adicionando jQuery UI para o autocomplete -->
   <link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
   <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
   <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js"></script>

   <script>
      $(function() {
         function setupAutocomplete(element, tipo) {
            $(element).autocomplete({
               source: function(request, response) {
                  $.ajax({
                     url: "buscar_funcionarias.php",
                     dataType: "json",
                     contentType: "application/json",
                     data: {
                        term: request.term,
                        tipo: tipo
                     },
                     success: function(data) {
                        if (data && Array.isArray(data)) {
                           response(data);
                        } else if (data && data.error) {
                           console.error("Erro no servidor:", data.error);
                           response([]);
                        } else {
                           console.error("Resposta inválida do servidor");
                           response([]);
                        }
                     },
                     error: function(xhr, status, error) {
                        console.error("Erro na requisição:", status, error);
                        try {
                           // Tentar extrair mensagem de erro do HTML retornado
                           var errorHtml = xhr.responseText;
                           var errorMatch = errorHtml.match(/<title>(.*?)<\/title>/i) ||
                              errorHtml.match(/<body[^>]*>(.*?)<\/body>/is);
                           var errorMsg = errorMatch ? errorMatch[1] : "Erro desconhecido";
                           console.error("Detalhes:", errorMsg);
                        } catch (e) {
                           console.error("Não foi possível analisar o erro");
                        }
                        response([]);
                     }
                  });
               },
               minLength: 2,
               delay: 300
            });
         }

         // Aplicar aos campos
         setupAutocomplete("#encarregada", "encarregada");
         setupAutocomplete("#vendedora", "vendedora");
      });

      function validaCampos() {
         var vendedora = document.getElementById('vendedora').value.trim();
         var cliente = document.getElementById('cliente').value.trim();
         if (vendedora.length <= 8) {
            alert('O campo Vendedora deve ter mais que 8 letras.');
            document.getElementById('vendedora').focus();
            return false;
         }
         if (cliente.length <= 8) {
            alert('O campo Cliente deve ter mais que 8 letras.');
            document.getElementById('cliente').focus();
            return false;
         }

         // Validação da soma dos valores
         function parseValor(valor) {
            return parseFloat(valor.replace(',', '.')) || 0;
         }

         var vlrUnico = parseValor(document.cntentr.vlr_unico.value);
         var v1 = parseValor(document.cntentr.txtvalor1.value);
         var v2 = parseValor(document.cntentr.txtvalor2.value);
         var v3 = parseValor(document.cntentr.txtvalor3.value);
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
         var fp1 = document.cntentr.lsPr1.value;
         var fp2 = document.cntentr.lsPr2.value;
         var fp3 = document.cntentr.lsPr3.value;

         if (fp1 === fp2 || fp1 === fp3 || (fp2 !== "" && fp2 === fp3)) {
            var repetidos = [];
            if (fp1 === fp2) repetidos.push(fp1);
            if (fp1 === fp3) repetidos.push(fp1);
            if (fp2 === fp3) repetidos.push(fp2);

            // Buscar o texto da opção repetida
            var texto = "";
            if (repetidos.length > 0) {
               var selects = [document.cntentr.lsPr1, document.cntentr.lsPr2, document.cntentr.lsPr3];
               for (var i = 0; i < selects.length; i++) {
                  for (var j = 0; j < selects[i].options.length; j++) {
                     if (selects[i].options[j].value === repetidos[0]) {
                        texto = selects[i].options[j].text;
                        break;
                     }
                  }
                  if (texto) break;
               }
            }
            alert("A forma de pagamento '" + texto + "' foi repetida. Selecione formas diferentes.");
            return false;
         }

         return true;
      }

      function validarSomaValores() {
         var vlrUnico = parseFloat(document.cntentr.vlr_unico.value.replace('.', '').replace(',', '.')) || 0;
         var v1 = parseFloat(document.cntentr.txtvalor1.value.replace('.', '').replace(',', '.')) || 0;
         var v2 = parseFloat(document.cntentr.txtvalor2.value.replace('.', '').replace(',', '.')) || 0;
         var v3 = parseFloat(document.cntentr.txtvalor3.value.replace('.', '').replace(',', '.')) || 0;
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
         document.cntentr.vlr_unico.onblur = validarSomaValores;
         document.cntentr.txtvalor1.onblur = validarSomaValores;
         document.cntentr.txtvalor2.onblur = validarSomaValores;
         document.cntentr.txtvalor3.onblur = validarSomaValores;
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

</head>

<body background="../images/bg1.jpg" text="#FFFFFF" onLoad="putFocus(0,0)">

   <?php
   // Obtendo o Login
   $Sis     = "S7";
   $Rot     = "S7R2.2";
   $lg_user = $_REQUEST['c_s'];
   $user = substr($lg_user, 0, 8);
   $pss  = substr($lg_user, 8, 40);

   include "us_sist.php";
   if ($ch == 'no') {
      include "us_cad.php";
   } ?>

   <font color="gold" size="6"><br>
      <b>
         <center><u><i>Contrato - Entrada</i></u></center>
      </b>
   </font><br><br><br>
   <?php

   if ($ch == 'ok-enc' or $ch == 'ok-cai' or $ch == 'ok') { ?>
      <table width="70%" border="5" cellpadding="10" cellspacing="0" align="center">
         <form name="cntentr" method="post" action="confcntentr.php?c_s=<?php echo $lg_user; ?>" onsubmit="return validaCampos()" autocomplete="off">
            <tr>
               <td align="center">
                  <font color='#FFFFFF' size='5'><b><i>Nº do Contrato</i></b></font>
               </td>
               <td align="center">
                  <font color='#FFFFFF' size='5'><b><i>Vlr Único</i></b></font>
               </td>
               <td align="center">
                  <font color='#FFFFFF' size='5'><b><i>Forma de Pagamento</i></b></font>
               </td>
               <td align="center">
                  <font color='#FFFFFF' size='5'><b><i>Valor</i></b></font>
               </td>
            </tr>

            <tr>
               <td rowspan="3" align="center">
                  <input type="text" name="txtdoc" size="7" maxlength="7" class="campos" onKeyUp="validate(this)">
               </td>
               <td rowspan="3" align="center">
                  <input type="text" name="vlr_unico" size="7" maxlength="7" class="campos" OnKeyUp="FormataValor('cntentr', 'vlr_unico', event); validate(this)">
               </td>
               <td align="center">
                  <select name="lsPr1" class="campos">
                     <?php
                     // Obtendo a Relação
                     // Conectando ao Banco de Dados
                     include "dbselect.php";

                     // Criando a Instrução SQL de Consulta
                     $sqlpr = "select * from formapag where codpag <= 30 or codpag >= 70 order by codpag";

                     // Consultando os Registros
                     $rspr = mysqli_query($conec, $sqlpr) or die("Não foi possível acessar os Dados");

                     // Criando o Array para o campo PC
                     while ($lnpr = mysqli_fetch_array($rspr)) {
                        $CodPag  = $lnpr['codpag'];
                        $ModPag  = $lnpr['modpag'];
                     ?>
                        <option value="<?php echo $CodPag; ?>" class="campos"><?php echo "$ModPag"; ?></option>
                     <?php
                     }
                     mysqli_free_result($rspr);
                     ?>
                  </select>
               </td>
               <td align="center">
                  <font size='5'><b><i>R$ </i></b></font>
                  <input type="text" name="txtvalor1" size="7" maxlength="7" class="campos" OnKeyUp="FormataValor('cntentr', 'txtvalor1', event); validate(this)" required>
                  <input type="hidden" name="txtuser" value="<?php echo $lg_user; ?>">
               </td>
            </tr>

            <tr>
               <td align="center">
                  <select name="lsPr2" class="campos">
                     <?php
                     // Obtendo a Relação
                     // Conectando ao Banco de Dados
                     include "dbselect.php";

                     // Criando a Instrução SQL de Consulta
                     $sqlpr = "select * from formapag where codpag <= 30 or codpag >= 70 order by codpag";

                     // Consultando os Registros
                     $rspr = mysqli_query($conec, $sqlpr) or die("Não foi possível acessar os Dados");

                     // Criando o Array para o campo PC
                     while ($lnpr = mysqli_fetch_array($rspr)) {
                        $CodPag  = $lnpr['codpag'];
                        $ModPag  = $lnpr['modpag'];
                     ?>
                        <option value="<?php echo $CodPag; ?>" class="campos"><?php echo "$ModPag"; ?></option>
                     <?php
                     }
                     mysqli_free_result($rspr);
                     ?>
                  </select>
               </td>
               <td align="center">
                  <font size='5'><b><i>R$ </i></b></font>
                  <input type="text" name="txtvalor2" size="7" maxlength="7" class="campos" OnKeyUp="FormataValor('cntentr', 'txtvalor2', event); validate(this)">
                  <input type="hidden" name="txtuser" value="<?php echo $lg_user; ?>">
               </td>
            </tr>

            <tr>
               <td align="center">
                  <select name="lsPr3" class="campos">
                     <?php
                     // Obtendo a Relação
                     // Conectando ao Banco de Dados
                     include "dbselect.php";

                     // Criando a Instrução SQL de Consulta
                     $sqlpr = "select * from formapag where codpag <= 30 or codpag >= 70 order by codpag";

                     // Consultando os Registros
                     $rspr = mysqli_query($conec, $sqlpr) or die("Não foi possível acessar os Dados");

                     // Criando o Array para o campo PC
                     while ($lnpr = mysqli_fetch_array($rspr)) {
                        $CodPag  = $lnpr['codpag'];
                        $ModPag  = $lnpr['modpag'];
                     ?>
                        <option value="<?php echo $CodPag; ?>" class="campos"><?php echo "$ModPag"; ?></option>
                     <?php
                     }
                     mysqli_free_result($rspr);
                     ?>
                  </select>
               </td>
               <td align="center">
                  <font size='5'><b><i>R$ </i></b></font>
                  <input type="text" name="txtvalor3" size="7" maxlength="7" class="campos" OnKeyUp="FormataValor('cntentr', 'txtvalor3', event); validate(this)">
                  <input type="hidden" name="txtuser" value="<?php echo $lg_user; ?>">
               </td>
            </tr>
      </table>
      <br>
      <table width="70%" border="5" cellpadding="10" cellspacing="0" align="center">
         <tr>
            <td width="50%" align="center">
               <font color='#FFFFFF' size='5'><b><i>Vendedora</i></b></font>
            </td>
            <td width="50%" align="center">
               <font color='#FFFFFF' size='5'><b><i>Cliente</i></b></font>
            </td>
         </tr>
         <tr>
            <td width="50%" align="center">
               <input type="text" id="vendedora" name="vendedora" size="40" maxlength="50" class="campos"
                  onkeypress="fPassaAlfaNumerico('an')"
                  onkeyup='this.value=this.value.toUpperCase(); validnome(this)' required>
            </td>
            <td width="50%" align="center">
               <input type="text" id="cliente" name="cliente" size="40" maxlength="50" class="campos"
                  onkeypress="fPassaAlfaNumerico('an')"
                  onkeyup='this.value=this.value.toUpperCase(); validnome(this)' required>
            </td>
         </tr>
      </table>
      <br>

      <table width="100%" border="0" cellspacing="0">
         <tr>
            <td width="9%">
               <a href="servrec.php?c_s=<?php echo $lg_user ?>"><img src="./images/voltar.gif"></a>
            </td>
            <td width="82%" align="center">
               <input type='submit' name='btenviar' value='Continuar'>&nbsp;&nbsp;
               <input type='reset' name='btreset' value='Limpar'><br><br>
               <span id="msg"></span>
            </td>
            <td width="9%" align="right">
               <a href="servrec.php?c_s=<?php echo $lg_user; ?>"><img src="./images/voltar.gif"></a>
            </td>
         </tr>
      </table>
      </form>
   <?php
   } else { ?>
      <br><br><br><br><br>
      <font size='6'><b>
            <center>Acesso <font color='gold'>
                  <blink><u>não Autorizado</u>
                  </blink>
                  <font color='#FFFFFF'>!!!</center>
         </b></font><br><br><br>
      <center><a href='servrec.php?c_s=<?php echo $lg_user; ?>'><img src='images/voltar.gif'></a></center><br><br>
   <?php            }

   // Encerrando as Conexões
   $SisRot = "S-7.2.2";
   include "rodape.php";
   mysqli_close($conec);
   ?>
</body>

</html>