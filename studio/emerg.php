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
   </style>

   <?php
   // Inserindo o Cabeçalho
   include "../cabecprs.php";
   ?>

   <script>
      function formataValor(campo) {
         var digitos = campo.value.replace(/\D/g, '');

         if (digitos.length <= 2) {
            campo.value = digitos;
            return;
         }

         var reais = digitos.slice(0, -2).replace(/^0+(?=\d)/, '');
         var centavos = digitos.slice(-2);
         campo.value = reais + '.' + centavos;
      }

      function validaCampos() {
         var lacre = document.getElementById('lacre').value.trim();
         var valor = document.getElementById('txtvalor').value.trim();

         if (!/^\d+$/.test(lacre)) {
            alert('O campo Lacre deve conter somente números.');
            document.getElementById('lacre').focus();
            return false;
         }

         if (!/^\d+(\.\d{2})?$/.test(valor) || parseFloat(valor) <= 0) {
            alert('Informe um valor maior que zero.');
            document.getElementById('txtvalor').focus();
            return false;
         }

         return true;
      }
   </script>

</head>

<body background="../images/bg1.jpg" text="#FFFFFF">

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
   }

   include "dbselect.php";
   include "valida_caixa.php";

   if ($ch == 'ok-enc' or $ch == 'ok-cai' or $ch == 'ok') {
      // A colaboradora deve ser sempre a pessoa autenticada no sistema.
      include "dblog.php";
      $sqlColaboradora = "select nome from pessoal where mat = '" . mysqli_real_escape_string($conec, $user) . "' limit 1";
      $rsColaboradora = mysqli_query($conec, $sqlColaboradora)
         or die("Erro ao identificar a colaboradora. Contate seu Administrador.");
      $lnColaboradora = mysqli_fetch_array($rsColaboradora);
      $nomeColaboradora = $lnColaboradora ? trim($lnColaboradora['nome']) : '';
      mysqli_free_result($rsColaboradora);
      include "dbselect.php";

      if ($nomeColaboradora === '') {
         die("Não foi possível identificar o nome da colaboradora autenticada. Contate seu Administrador.");
      }

      $matVendEsc = htmlspecialchars($user, ENT_QUOTES, 'UTF-8');
      $nomeColaboradoraEsc = htmlspecialchars($nomeColaboradora, ENT_QUOTES, 'UTF-8');

      bloquear_se_caixa_anterior_aberto($conec, $lg_user);
   } ?><br>

   <table width='100%' border='0' cellpadding='0' cellspacing='0'>
      <tr>
         <td width='9%'>
            <a href="servrec.php?c_s=<?php echo $lg_user ?>"><img src="./images/voltar.gif"></a>
         </td>
         <td width='82%' align='center'>
            <font color="gold" size="6">
               <b>
                  <center>
                     <u>
                        <i>AJUSTE EMERGENCIAL</i>
                     </u>
                  </center>
               </b>
            </font>
            <br><br><br>
         </td>
         <td width='9%'>
            <a href="servrec.php?c_s=<?php echo $lg_user; ?>"><img src="./images/voltar.gif"></a>
         </td>
      </tr>
   </table><br>
   <?php

   if ($ch == 'ok-enc' or $ch == 'ok-cai' or $ch == 'ok') { ?>
      <form method="post" action="confemerg.php?c_s=<?php echo $lg_user; ?>" onsubmit="return validaCampos()" autocomplete="off">
         <table width="95%" border="5" cellpadding="10" cellspacing="0" align="center">
            <tr>
               <td width="33%" align="center">
                  <font color='#FFFFFF' size='5'><b><i>Colaboradora</i></b></font>
               </td>
               <td width="33%" align="center">
                  <font color='#FFFFFF' size='5'><b><i>Lacre</i></b></font>
               </td>
               <td width="33%" align="center">
                  <font color='#FFFFFF' size='5'><b><i>Valor</i></b></font>
               </td>
            </tr>
            <tr>
               <td width="33%" align="center">
                  <span>
                     <font color='gold' size='5'>
                        <b>
                           <i>
                              <?php echo $nomeColaboradoraEsc; ?>
                           </i>
                        </b>
                     </font>
                  </span>
                  <input type="hidden" name="mat_vend" value="<?php echo $matVendEsc; ?>">
               </td>
               <td width="33%" align="center">
                  <input type="text" id="lacre" name="lacre" size="10" maxlength="10" class="campos"
                     inputmode="numeric" pattern="[0-9]+" oninput="this.value = this.value.replace(/\D/g, '')"
                     required autofocus>
               </td>
               <td width="33%" align="center">
                  <font size='5'><b><i>R$ </i></b></font>
                  <input type="text" id="txtvalor" name="txtvalor" size="10" maxlength="10" class="campos"
                     inputmode="numeric" pattern="[0-9]+(\.[0-9]{2})?" oninput="formataValor(this)"
                     required>
               </td>
            </tr>
         </table>
         <br>

         <input type="hidden" name="vendedora" value="<?php echo $nomeColaboradoraEsc; ?>">
         <input type="hidden" name="txtuser" value="<?php echo $lg_user; ?>">

         <table width="100%" border="0" cellspacing="0">
            <tr>
               <td width="82%" align="center">
                  <input type="submit" value="Continuar">&nbsp;&nbsp;
                  <input type="reset" value="Limpar"><br><br>
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
      <center><a href='./index.php?c_s=<?php echo $lg_user; ?>'><img src='images/voltar.gif'></a></center><br><br>
   <?php            }

   // Encerrando as Conexões
   $SisRot = "S-7.2.2";
   include "rodape.php";
   mysqli_close($conec);
   ?>
</body>

</html>
