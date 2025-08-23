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
   </style>

   <?php
   // Inserindo o Cabeçalho
   include "../cabecprs.php";
   ?>

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

   <script type="text/javascript" src="val_contrato.js" charset="utf-8">
   </script>

</head>

<body background="../images/bg1.jpg" text="#FFFFFF" onLoad="putFocus(0,0)">

   <?php
   // Obtendo o Login
   $Sis     = "S7";
   $Rot     = "S7R2.6";
   $lg_user = $_REQUEST['c_s'];
   $user = substr($lg_user, 0, 8);
   $pss  = substr($lg_user, 8, 40);

   include "us_sist.php";
   if ($ch == 'no') {
      include "us_cad.php";
   } ?>

   <font color="gold" size="6"><br>
      <b>
         <center><u><i>Proposta - Entrada</i></u></center>
      </b>
   </font><br><br><br>
   <?php

   // Consultando número de recibo
   /*$sql = "SELECT numrec FROM num_recibos WHERE status = '0'ORDER BY numrec ASC LIMIT 1";
   $res = mysqli_query($conec, $sql);
   $ln  = mysqli_fetch_array($res);
   $NumRec = $ln['numrec'];*/

   if ($ch == 'ok-enc' or $ch == 'ok-cai' or $ch == 'ok') { ?>
      <table width="70%" border="5" cellpadding="10" cellspacing="0" align="center">
         <form name="cntentr" method="post" action="confpropentr.php" OnSubmit="JavaScript:return checkdata()">
            <tr>
               <td width="30%" align="center">
                  <font color='gold' size='5'><b><i>Nº da Proposta</i></b></font>
               </td>
               <td width="30%" align="center">
                  <font color='gold' size='5'><b><i>Valor</i></b></font>
               </td>
               <td width="40%" align="center">
                  <font color='gold' size='5'><b><i>Forma de Pagamento</i></b></font>
               </td>
            </tr>

            <tr>
               <td width="30%" align="center">
                  <?php
                  if ($NumRec != '') {
                     $readonly_disabled = 'readonly';

                     echo "<input type='text' name='txtdoc' size='5' maxlength='7' class='campos' value='$NumRec' $readonly_disabled>";
                  } else {
                     echo "Não há recibo disponivel";
                  }
                  ?>
               </td>
               <td width="30%" align="center">
                  <font size='5'>R$ </i></b></font>
                  <input type="text" name="txtvalor" size="7" maxlength="7" class="campos" OnKeyUp="FormataValor('cntentr', 'txtvalor', event);">
                  <input type="hidden" name="txtuser" value="<?php echo $lg_user; ?>">
               </td>
               <td width="40%" align="center">
                  <select name="lsPr" class="campos">
                     <?php
                     // Obtendo a Relação
                     // Conectando ao Banco de Dados
                     include "dbselect.php";

                     // Criando a Instrução SQL de Consulta
                     $sqlpr = "select * from formapag where codpag <= 30 order by codpag";

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
      </table><br>

      <table width="100%" border="0" cellspacing="0">
         <tr>
            <td width="9%">
               <a href="servrec.php?c_s=<?php echo $lg_user ?>"><img src="./images/voltar.gif"></a>
            </td>
            <td width="82%" align="center">
               <?php
               if (isset($NumRec)) {
                  echo "<input type='submit' name='btenviar' value='Continuar'>&nbsp;&nbsp;";
                  echo "<input type='reset' name='btreset' value='Limpar'><br><br>";
               } ?>
            <td width="9%" align="right">
               <a href="servrec.php?c_s=<?php echo $lg_user; ?>"><img src="./images/voltar.gif"></a>
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
      <center><a href='servrec.php?c_s=<?php echo $lg_user; ?>'><img src='images/voltar.gif'></a></center><br><br>
   <?php
            }
            $SisRot = "S-7.2.6";
            include "rodape.php";

            // Encerrando as Conexões
            mysqli_close($conec); ?>

</body>

</html>
