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
         return true;
      }

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
   } ?><br>

    <table width='100%' border='0' cellpadding='0' cellspacing='0'>
        <tr>
            <td width='9%'>
                <a href="servrec.php?c_s=<?php echo $lg_user ?>"><img src="./images/voltar.gif"></a>
            </td>
            <td width='82%' align='center'>
                <font color="gold" size="6"><b>
                        <center><u><i>VENDAS À VISTA</i></u></center>
                    </b></font><br><br><br>
            </td>
            <td width='9%'>
                <a href="servrec.php?c_s=<?php echo $lg_user; ?>"><img src="./images/voltar.gif"></a>
            </td>
        </tr>
    </table><br>
   <?php

   if ($ch == 'ok-enc' or $ch == 'ok-cai' or $ch == 'ok') { ?>
      <table width="70%" border="5" cellpadding="10" cellspacing="0" align="center">
         <form name="cntentr" method="post" action="prods_tipo.php?c_s=<?php echo $lg_user; ?>" onsubmit="return validaCampos()" autocomplete="off">
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
            <td width="82%" align="center">
               <input type='submit' name='btenviar' value='Continuar'>&nbsp;&nbsp;
               <input type='reset' name='btreset' value='Limpar'><br><br>
               <span id="msg"></span>
            </td>
         </tr>
      </table><br>
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