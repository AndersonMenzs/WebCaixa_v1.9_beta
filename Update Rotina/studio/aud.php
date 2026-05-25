<html>
  <head>
    <title>WebCaixa v1.20.14_beta</title>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
	<style type="text/css">
	  body {
		margin-left: 5%;
		margin-right: 5%;
		border: 3px solid gray;
		padding: 10px 10px 10px 10px;
		font-family:sans-serif;
	       }
	</style>
<script>
function F5(event) {
var tecla = document.all ? window.event.keyCode : event.which;
if (document.all) { window.event.keyCode = 0; window.event.returnValue = false; }
if (tecla == 116) return false;
}

document.onkeydown = F5;
</script>

  </head>

  <body background="../images/bg1.jpg" text="#FFFFFF">
    <?php
     include "../cabecprs.php";

     // Obtendo o Login
	$Sis  = "S7";
	$Rot  = "S7R0";
	$user = substr(100000000 + trim($_POST['txtmat']),1,8);
	$pass = strtolower(trim($_POST['txtsen']));
	$pss  = sha1($pass);
	$lg_user = $user.$pss;

	if ($user == '' or $user == 0)
	  {
	   $lg_user = $_REQUEST['c_s'];
	      $user = substr($lg_user,0,8);
	   $pss     = substr($lg_user,8,40);
	  }

	$userF = substr($user,0,1).".".substr($user,1,3).".".substr($user,4,3)."-".substr($user,7,1);
	$hif    =' - ';
	$hif2   =' em ';

	include "us_sist.php";
	if ($ch == 'no')
	  {
	   include "us_cad.php";
	  }


     if ($ch == 'ok')
       { ?>
	<font size='6' color='gold'><b><u><i><center>MENU AUDITORIA</center></i></u></b></font><br>
	<table border="0" cellpadding="3" cellspacing="0" align="center">
	   <tr>
	      <td>
		 <a href="audit.php?c_s=<?php echo $lg_user; ?>"><img src="./images/star4.gif" width="25" border="0" align="top"></a><font size='4'><b><i>- Composição Inicial do Caixa </i></b></font>
	      </td>
	   </tr>

	   <tr>
	      <td>
		 <a href="fchparcsem.php?c_s=<?php echo "$lg_user"."$dtAbre"; ?>"><img src="./images/star4.gif" width="25" border="0" align="top"></a><font size='4'><b><i>- Fechamento Parcial&nbsp;&nbsp; <font color='lime'>(sem&nbsp;&nbsp;&nbsp;Impressão)</i></b></font>
	      </td>
	   </tr>

	   <tr>
	      <td>
		 <a href="fchparcial.php?c_s=<?php echo $lg_user; ?>"><img src="./images/star4.gif" width="25" border="0" align="top"></a><font size='4'><b><i>- Fechamento Parcial&nbsp;&nbsp; <font color='gold'>(com&nbsp;&nbsp;&nbsp;Impressão)</i></b></font>
	      </td>
	   </tr>

	   <tr>
	      <td>
		 <a href="cntaud.php?c_s=<?php echo $lg_user; ?>"><img src="./images/star4.gif" width="25" border="0" align="top"></a><font size='4'><b><i>- Consultas Autenticadas</i></b></font>
	      </td>
	   </tr>

	   <tr>
	      <td>
		 <a href="difcx.php?c_s=<?php echo $lg_user; ?>"><img src="./images/star4.gif" width="25" border="0" align="top"></a><font size='4'><b><i>- Incorporar Sobra de Numerário ao Caixa</i></b></font>
	      </td>
	   </tr>

	   <tr>
	      <td>
		 <a href="retifica.php?c_s=<?php echo $lg_user; ?>"><img src="./images/star4.gif" width="25" border="0" align="top"></a><font size='4'><b><i>- Retificação por Erro de Lançamento</i></b></font>
	      </td>
	   </tr>

	   <tr>
	      <td>
		 <a href="correccx.php?c_s=<?php echo $lg_user; ?>"><img src="./images/star4.gif" width="25" border="0" align="top"></a><font size='4'><b><i>- Retificação por Término Anormal do Caixa</i></b></font>
	      </td>
	   </tr>

	   <tr>
	      <td>
		 <a href="vendback.php?c_s=<?php echo $lg_user; ?>"><img src="./images/star4.gif" width="25" border="0" align="top"></a><font size='4'><b><i>- Reajuste de Preço de Taxas e Produtos</i></b></font>
	      </td>
	   </tr>
        </table>
	<meta http-equiv="refresh" content="60;URL=./acaud.php?c_s=<?php echo $lg_user; ?>"><?php
       } else { ?>
	       <br><br><br><font size='7'><b><center>Acesso <font color='gold'><blink><u>não Autorizado</u>
	       </blink><font color='#FFFFFF'>!!!</center></b></font><br><br><?php
	      } ?>
   <center><a href='index.php?c_s=<?php echo $lg_user; ?>'><img src='images/voltar.gif'></a></center><br><?php

   // Encerrando
      $SisRot = "S-7.0";
      include "rodape.php"; ?>

    </body>

</html>
