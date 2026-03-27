<html>

  <head>
    <title>WebCaixa v1.20.0_beta</title>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
	<style type="text/css">
	  body {
		margin-top: 6%;
		margin-left: 2%;
		margin-right: 2%;
		border: 3px solid gray;
		padding: 10px 10px 10px 10px;
		font-family:sans-serif;
	       }
	  .campos {
	   background-color:#C0C0C0;
	   font: 12px sans-serif;
	   color:#000000;
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

<script language="JavaScript">
<!--
  javascript:window.history.forward(1);
//-->
</script>

      <?php
	include "../cabecprs.php";

    // Autorizando o Login
       $Sis         = "S7";
       $Rot     = "S7R8";
       $lg_user     = $_REQUEST['c_s'];
         $user      = substr($lg_user,0,8);
         $pss       = substr($lg_user,8,40); ?>
  </head>

  <body background="../images/bg1.jpg" text="#FFFFFF">
  <?php include "us_sist.php";

     if ($ch == 'no')
       {
	include "us_cad.php";
       }  ?><br>

  <font face="arial" color="gold" size="6"><b><i><center><u>REAJUSTE DE TAXAS</u><br><br><br>
     <table border='0' cellpadding='7' cellspacing='0' align='center'><?php
	if ($ch == 'ok-enc' or $ch == 'ok')
	  { ?>
	   <tr>
	      <td>
		 <a href="atutaxas.php?c_s=<?php echo $lg_user; ?>"><img src="./images/star4.gif" width="25" border="0" align="top"></a><font size='4'><b><i>- Reajustar Preços </i></b></font>
	      </td>
	   </tr>

	   <tr>
	      <td>
		 <a href="undotaxas.php?c_s=<?php echo $lg_user; ?>"><img src="./images/star4.gif" width="25" border="0" align="top"></a><font size='4'><b><i>- Desfazer Reajuste </i></b></font>
	      </td>
	   </tr><?php
	  } ?>

	<tr>
           <td align="center">
	      <a href="aud.php?c_s=<?php echo $lg_user; ?>"><img src="./images/voltar.gif"></a>
           </td>
        </tr>
      </table><br><br>

  <meta http-equiv="refresh" content="60;URL=./acaud.php?c_s=<?php echo $lg_user; ?>"><?php

  // Encerrando
     $SisRot = "S-7.8";
     include "../rodapext.php"; ?>

  </body>
</html>
