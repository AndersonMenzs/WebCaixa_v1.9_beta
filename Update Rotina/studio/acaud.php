<html>
  <head>
    <title>WebCaixa v1.20.6_beta</title>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
	<style type="text/css">
	  body {
		margin-top: 5%;
		margin-left: 12%;
		margin-right: 12%;
		border: 3px solid gray;
		padding: 10px 10px 10px 10px;
		font-family:sans-serif;
	       }
	  .campos {
	   background-color:#C0C0C0;
	   font: 16px sans-serif;
	   color:#000000;
		  }
	</style>
	
    <?php
      // Inserindo o Cabeçalho
	 include "../cabecprs.php" ;
    ?>

    <script>
    function F5(event) {
    var tecla = document.all ? window.event.keyCode : event.which;
    if (document.all) { window.event.keyCode = 0; window.event.returnValue = false; }
    if (tecla == 116) return false;
    }

    document.onkeydown = F5;
    </script>

    <SCRIPT LANGUAGE="JavaScript">    <!-- Begin
     function putFocus(formInst, elementInst) {
      if (document.forms.length > 0) {
       document.forms[formInst].elements[elementInst].focus();
      }
     }
    </script>

    <Script>
    function validate(field) {
    var valid = "0123456789"
    var ok = "yes";
    var temp;
    for (var i=0; i<field.value.length; i++) {
    temp = "" + field.value.substring(i, i+1);
    if (valid.indexOf(temp) == "-1") ok = "no";
    }
    if (ok == "no") {
    alert("Entrada Incorreta! \n  Digite apenas algarismos!");
    field.value = "";
    field.focus();
    field.select();
       }
    }
    //  End -->
    </script>
  </head>

  <body background="../images/bg1.jpg" text="#FFFFFF" onLoad="putFocus(0,0)">

    <?php
     // Obtendo o Login
        $Sis     = "S7";
	$Rot     = "S7R0.0";
	$lg_user = $_REQUEST['c_s'];
	   $user = substr($lg_user,0,8);
	   $pss  = substr($lg_user,8,40);

     include "us_sist.php";
     if ($ch == 'no')
       {
	include "us_cad.php";
       } ?><br>

     <font color="gold" size="6"><b><center><u><i>LOGIN DE SEGURANÇA<br>
     <font color="aqua" size="5">(AUDITORA)</i></u></center></b></font><br><?php

    if ($ch == 'ok-enc' or $ch == 'ok')
      { ?>
       <table border="5" cellpadding="10" cellspacing="0" align="center">
       <form name="seglog" method="post" action="aud.php">
	  <tr>
	     <td align="center">
		<font color='gold' size='5'><b><i>Matrícula</i></b></font>
	     </td>
	     <td align="center">
		<font color='gold' size='5'><b><i>Senha</i></b></font>
	     </td>
	  </tr>

	  <tr>
	     <td align="center">
		<input type="text" name="txtmat" size="8" maxlength="10" class="campos" OnKeyUp="validate(this)">
	     <td align="center">
		<input type="password" name="txtsen" size="6" maxlength="8" class="campos">
	     </td>
	   </tr>
       </table><br>

       <table width="100%" border="0" cellspacing="0">
	  <tr>
	     <td width="9%"><a href="index.php?c_s=<?php echo $lg_user ?>"><img src="./images/voltar.gif"></a></td>
	     <td width="82%" align="center">
		<input type="submit" name="btenviar" value="Continuar">&nbsp;&nbsp;
		<input type="reset" name="btreset" value="Limpar">
	     <td width="9%" align="right">
		<a href="index.php?c_s=<?php echo $lg_user; ?>"><img src="./images/voltar.gif"></a>
	     </td>
	  </tr>
       </table>
       </form><?php
      } else { ?>
	      <br><br><br><br><br><font size='6'><b><center>Acesso <font color='gold'><blink><u>não Autorizado</u>
	      </blink><font color='#FFFFFF'>!!!</center></b></font><br><br><br>
	      <center><a href='index.php?c_s=<?php echo $lg_user; ?>'><img src='images/voltar.gif'></a></center><br><br><?php
	     }

     // Encerrando as Conexões
	$SisRot = "S-7.0.0";
	include "rodape.php"; ?>

  </body>

</html>
