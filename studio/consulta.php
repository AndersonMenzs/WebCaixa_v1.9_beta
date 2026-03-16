<html>
  <head>
    <title>WebCaixa v1.19_beta</title>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
	<style type="text/css">
	  body {
		margin-top: 10%;
		margin-left: 3%;
		margin-right: 3%;
		border: 3px solid gray;
		padding: 10px 10px 10px 10px;
		font-family:sans-serif;
	       }
	</style>
    <?php

	// Inserindo o Cabeçalho
	   include "../cabecprs.php" ; 
    ?>
  </head>

  <body background="../images/bg1.jpg" text="#FFFFFF" onLoad="putFocus(0,0)"><?php

     // Obtendo o Login
        $Sis     = "S7";
	$Rot     = "S7R1";
	$lg_user = $_REQUEST['c_s'];
	   $user = substr($lg_user,0,8);
	   $pss  = substr($lg_user,8,40);

     include "us_sist.php";

     if ($ch == 'no')
       {
	include "us_cad.php";
       } ?>

     <font color="gold" size="6"><br>
     <b><center><u><i>CONSULTAR</i></u></center></b></font><br><br><?php

     if ($ch == 'ok-enc' or $ch == 'ok-cai' or $ch == 'ok')
       { ?>
	<table border="0" cellpadding="0" cellspacing="10" align="center">
	   <tr>
	      <td>
		 <a href="cnt.php?c_s=<?php echo $lg_user; ?>"><img src="./images/star4.gif" width="25" border="0" align="top"></a><font size='4'><b><i>- Autenticações </i></b></font>
	      </td>
	   </tr><?php

	if ($ch == 'ok-enc' or $ch == 'ok')
	  { ?>
	   <tr>
	      <td>
		 <a href="cstanormal.php?c_s=<?php echo $lg_user; ?>"><img src="./images/star4.gif" width="25" border="0" align="top"></a><font size='4'><b><i>- Términos Anormais </i></b></font>
	      </td>
	   </tr><?php
	  } ?>
	</table>

	<br><br><center><a href="index.php?c_s=<?php echo $lg_user ?>"><img src="./images/voltar.gif"></center><br><?php
       } else { ?>
	       <br><br><br><br><br><font size='6'><b><center>Acesso <font color='gold'><blink><u>não Autorizado</u>
	       </blink><font color='#FFFFFF'>!!!</center></b></font><br><br><br>
	       <center><a href='index.php?c_s=<?php echo $lg_user; ?>'><img src='images/voltar.gif'></a></center><br><br><?php
	      }

     // Encerrando
        $SisRot = "S-7.1";
        include "rodape.php";

     // Encerrando as Conexões
	mysqli_close($conec); ?>

  </body>
</html>