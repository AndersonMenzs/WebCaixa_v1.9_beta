<html>
  <head>
    <title>WebCaixa v1.20.7_beta</title>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
	<style type="text/css">
	  body {
		margin-top: 5%;
		margin-left: 3%;
		margin-right: 3%;
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

    <?php
      // Inserindo o Cabeçalho
	 include "../cabecprs.php" ;
    ?>
  </head>

  <body background="../images/bg1.jpg" text="#FFFFFF" onLoad="putFocus(0,0)">

    <?php
     // Obtendo o Login
        $Sis     = "S7";
	$Rot     = "S7R3";
	$lg_user = $_REQUEST['c_s'];
	   $user = substr($lg_user,0,8);
	   $pss  = substr($lg_user,8,40);

     include "us_sist.php";
     if ($ch == 'no')
       {
	include "us_cad.php";
       } ?>

    <font color="gold" size="6"><br>
      <b><center><u><i>PAGAMENTOS</i></u></center></b></font><br><br><br><?php

  if ($ch == 'ok-enc' or $ch == 'ok-cai' or $ch == 'ok')
    { ?>
     <table border="0" cellpadding="0" cellspacing="10" align="center">
	<tr>
	  <td>
	      <a href="despesa.php?c_s=<?php echo $lg_user; ?>"><img src="./images/star4.gif" width="25" border="0" align="top"></a><font size='4'><b><i>- Despesas </i></b></font>
	  </td>
	</tr>

	<tr>
	  <td>
	      <a href="deposito.php?c_s=<?php echo $lg_user; ?>"><img src="./images/star4.gif" width="25" border="0" align="top"></a><font size='4'><b><i>- Recolhimentos </i></b></font>
	  </td>
	</tr>

	<!--<tr>
	  <td>
	      <a href="depant.php?c_s=<?php echo $lg_user; ?>"><img src="./images/star4.gif" width="25" border="0" align="top"></a><font size='4'><b><i>- Recolhimentos Anteriores (Reimpressão) </i></b></font>
	  </td>
	</tr>-->
     </table>

    <br><br><center><a href="index.php?c_s=<?php echo $lg_user ?>"><img src="./images/voltar.gif"></center><br><?php
	} else { ?>
	        <br><br><br><br><br><font size='6'><b><center>Acesso <font color='gold'><blink><u>não Autorizado</u>
		    </blink><font color='#FFFFFF'>!!!</center></b></font><br><br><br>
	        <center><a href='index.php?c_s=<?php echo $lg_user; ?>'><img src='images/voltar.gif'></a></center><br><br><?php
		}

   // Encerrando
      $SisRot = "S-7.3";
      include "rodape.php";

      // Encerrando as Conexões
	 mysqli_close($conec); ?>

  </body>

</html>
