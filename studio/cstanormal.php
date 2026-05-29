<html>
  <head>
    <title>WebCaixa v1.20.20_beta</title>
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
	</script><?php

    // Inserindo o Cabeçalho
       include "../cabecprs.php" ; ?>
  </head>

  <body background="../images/bg1.jpg" text="#FFFFFF" onLoad="putFocus(0,0)"><?php

     // Obtendo o Login
        $Sis      = "S7";
	$Rot      = "S7R1.2";
	$lg_user  = $_REQUEST['c_s'];
	   $user  = substr($lg_user,0,8);
	   $pss   = substr($lg_user,8,40);

     include "us_sist.php";
     if ($ch == 'no')
       {
	include "us_cad.php";
       } ?>

     <table width="100%" border="0" cellpadding="05" cellspacing="0" align="center">
	<tr>
	   <td>
	      <a href="consulta.php?c_s=<?php echo $lg_user ?>"><img src="./images/voltar.gif"></a>
	   </td>
	   <td align="center">
	      <font color="gold" size="6">
	      <b><u><i>RETIFICAÇÕES POR TÉRMINO ANORMAL</i></u></center></b></font>
	   </td>
	   <td>
	      <a href="consulta.php?c_s=<?php echo $lg_user ?>"><img src="./images/voltar.gif"></a>
	   </td>
	</tr>
     </table><br><br><?php

     if ($ch == 'ok-enc' or $ch == 'ok')
       {
	// Consultando o Banco de Dados
	   include "conexao.php";
	   include "dbselect.php";

	   $sql  = "select * from anormalend order by dtoper, hroper desc";
	   $rs   = mysqli_query($conec, $sql) or die ("Erro de Banco de Dados #1. Contate seu Administrador");
	   $regs = mysqli_num_rows($rs);

     if ($regs > 0)
       { ?>
	<table border="01" cellpadding="05" cellspacing="0" align="center">
	   <tr>
	      <td align='center'>
		 <font size='4' color='aqua'><b><i>Data da<br>
		 Retificação</i></b></font>
	      </td>
	      <td align='center'>
		 <p><font size='4' color='aqua'><b><i>Horário</i></b></font></p>
	      </td>
	      <td align='center'>
		 <font size='4' color='aqua'><b><i>Valor<br>
		 Corrigido</i></b></font>
	      </td>
	      <td align='center'>
		 <font size='4' color='aqua'><b><i>Diferença<br>
		 Lançada</i></b></font>
	      </td>
	      <td align='center'>
		 <font size='4' color='aqua'><b><i>Natureza da<br>
		 Operação</i></b></font>
	      </td>
	      <td align='center'>
		 <font size='4' color='aqua'><b><i>Matrícula da<br>
		 Auditora</i></b></font>
	      </td>
	   </tr><?php
	   while ($ln = mysqli_fetch_array($rs))
		{
		 $dtOper    = $ln['dtoper'];
		   $A  = substr($dtOper,0,4);
		   $M  = substr($dtOper,5,2);
		   $D  = substr($dtOper,8,2);
		 $dtOperF = "$D-$M-$A";
		 $hrOper     = $ln['hroper'];
		 $vlOper     = $ln['vloper'];
		 $Difer    = $ln['difer'];
		 $Nat   = $ln['natoper'];
		   if ($Nat == "D")
		     {
		      $Nat = "Débito";
		     } else {
			     $Nat = "Crédito";
			    }
		 $Oper    = $ln['operador'];
		   $Op1   = substr($user,0,7);
		   $Dv1   = substr($user,7,1);
		 $OpFull  = "$Op1-$Dv1"; ?>
		 <tr>
		    <td>
		       <font><b><i><?php echo "$dtOperF"; ?></i></b></font>
		    </td>
		    <td align='right'>
		       <font><b><i><?php echo "$hrOper"; ?></i></b></font>
		    </td>
		    <td align='right'>
		       <font><b><i>R$ <?php echo "$vlOper"; ?></i></b></font>
		    </td>
		    <td align='right'>
		       <font><b><i>R$ <?php echo "$Difer"; ?></i></b></font>
		    </td>
		    <td align='right'>
		       <font><b><i><?php echo "$Nat"; ?></i></b></font>
		    </td>
		    <td align='right'>
		       <font><b><i><?php echo "$OpFull"; ?></i></b></font>
		    </td>
		  </tr><?php
	      } ?>
	</table><?php
       } else { ?>
	       <br><br><br><br><br><font size='6'><b><center>Nenhum Registro Encontrado!</center></b></font><br><br><br><?php
	      } ?>

    <br><br><center><a href="consulta.php?c_s=<?php echo $lg_user ?>"><img src="./images/voltar.gif"></a></center><br><?php
   } else { ?>
	   <br><br><br><br><br><font size='6'><b><center>Acesso <font color='gold'><blink><u>não Autorizado</u>
	   </blink><font color='#FFFFFF'>!!!</center></b></font><br><br><br>
	   <center><a href='consulta.php?c_s=<?php echo $lg_user; ?>'><img src='images/voltar.gif'></a></center><br><br><?php
	  }

   // Encerrando
      $SisRot = "S-7.1.2";
      include "rodape.php";

      // Encerrando as Conexões
	 mysqli_close($conec); ?>

  </body>

</html>
