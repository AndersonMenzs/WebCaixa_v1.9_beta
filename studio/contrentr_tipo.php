<html>

<head>
   <title>WebCaixa v1.20.0_beta</title>
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

      function verificarDocumento(input) {
         if (input.value.length === 7) {
            fetch('verif_numdoc.php?txtdoc=' + input.value)
               .then(response => response.json())
               .then(data => {
                  if (data.existe) {
                     alert('Este documento já existe no banco de dados!');
                     
                     // Limpa o campo de entrada
                     input.value = '';
                     
                     return false;
                  }
               })
               .catch(error => {
                  console.error('Erro:', error);
                  alert('Erro ao verificar o documento!');
               });
         }
      }
   </script>

   <?php
   // Inserindo o Cabeçalho
   include "../cabecprs.php";
   ?>

   <!-- Adicionando jQuery UI para o autocomplete -->
   <link rel="stylesheet" href="./css/themes.css">
   <script src="./js/jquery.js"></script>
   <script src="./js/ui.js"></script>

   <script src="val_contrato.js" charset="utf-8"></script>


</head>

<body background="../images/bg1.jpg" text="#FFFFFF" onLoad="putFocus(0,0)">

   <?php
   
   // Obtendo o Login
   $Sis     = "S7";
   $Rot     = "S7R2.2";
   $lg_user = $_REQUEST['c_s'];
   $user = substr($lg_user, 0, 8);
   $pss  = substr($lg_user, 8, 40);
   $Mat_Vend = trim($_POST['mat_vend']);
   $Vendedora = $_REQUEST['vendedora'];
   $Cliente   = $_REQUEST['cliente'];

   include "us_sist.php";
   if ($ch == 'no') {
      include "us_cad.php";
   } ?>

   <table width='100%' border='0' cellpadding='0' cellspacing='0'>
      <tr>
         <td width='9%'>
            <a href="contrentr.php?c_s=<?php echo $lg_user; ?>"><img src="./images/voltar.gif"></a>
         </td>
         <td width='82%' align='center'>
            <font color="gold" size="6"><b>
                  <center><u><i>CONTRATO - ENTRADA</i></u></center>
               </b></font><br><br><br>
         </td>
         <td width='9%'>
            <a href="contrentr.php?c_s=<?php echo $lg_user; ?>"><img src="./images/voltar.gif"></a>
         </td>
      </tr>
   </table>
   <?php

   if ($ch == 'ok-enc' or $ch == 'ok-cai' or $ch == 'ok') { ?>
      <form name="cntentr" method="post" action="confcntentr.php" onsubmit="return checkdata();" autocomplete="off">
         <table width="70%" border="5" cellpadding="10" cellspacing="0" align="center">
            <tr>
               <td width="50%" align="center">
                  <font color='#FFFFFF' size='5'><b><i>Colaboradora</i></b></font>
               </td>
               <td width="50%" align="center">
                  <font color='#FFFFFF' size='5'><b><i>Cliente</i></b></font>
               </td>
            </tr>
            <tr>
               <td align="center">
                  <font color='gold' size='4'><b><i><?php echo $Vendedora; ?></i></b></font>
                  <input type="hidden" name="vendedora" value="<?php echo $Vendedora; ?>">
                  <input type="hidden" name="mat_vend" value="<?php echo $Mat_Vend; ?>">
               </td>
               <td align="center">
                  <font color='lime' size='4'><b><i><?php echo $Cliente; ?></i></b></font>
                  <input type="hidden" name="cliente" value="<?php echo $Cliente; ?>">
               </td>
            </tr>
         </table>
         <br>

         <table width="70%" border="5" cellpadding="10" cellspacing="0" align="center">
            <tr>
               <td align="center">
                  <font color='#FFFFFF' size='5'><b><i>Nº do Contrato</i></b></font>
               </td>
               <td align="center">
                  <font color='#FFFFFF' size='5'><b><i>Valor Total</i></b></font>
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
                  <input type="text" name="txtdoc" size="7" maxlength="7" class="campos" onKeyUp="validate(this); verificarDocumento(this)" autofocus>
               </td>
               <td rowspan="3" align="center">
                  <font size='5'><b><i>R$ </i></b></font>
                  <input type="text" name="vlr_unico" size="7" maxlength="7" class="campos" OnKeyUp="FormataValor('cntentr', 'vlr_unico', event); validate(this)">
               </td>
               <td align="center">
                  <select name="lsPr1" class="campos">
                     <?php
                     // Obtendo a Relação
                     // Conectando ao Banco de Dados
                     include "dbselect.php";

                     // Criando a Instrução SQL de Consulta
                     $sqlpr = "select * from formapag where codpag <= 30 or codpag >= 70 and codpag <> 99 order by codpag";

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
                  <input type="text" name="txtvalor1" size="7" maxlength="7" class="campos" OnKeyUp="FormataValor('cntentr', 'txtvalor1', event); validate(this)">
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
                     $sqlpr = "select * from formapag where codpag <= 30 or codpag >= 70 and codpag <> 99 order by codpag";

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
                     $sqlpr = "select * from formapag where codpag <= 30 or codpag >= 70 and codpag <> 99 order by codpag";

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
         <br>

         <table width="100%" border="0" cellspacing="0">
            <tr>
               <td width="9%"></td>
               <td width="82%" align="center">
                  <input type='submit' name='btenviar' value='Continuar'>&nbsp;&nbsp;
                  <input type='reset' name='btreset' value='Limpar'><br><br>
                  <span id="msg"></span>
               </td>
               <td width="9%" align="right"></td>
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