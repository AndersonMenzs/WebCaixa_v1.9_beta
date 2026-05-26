<html>
   <head>
	<title>WebCaixa v1.20.16_beta</title>
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
	  .campos {
	   background-color:#C0C0C0;
	   font: 16px sans-serif;
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
	</script><?php

	// Inserindo o Cabeçalho
	   include "../cabecprs.php"; ?>
   </head>

   <body background="../images/bg1.jpg" text="#FFFFFF" link="#FFFFFF" alink="#FFFFFF" vlink="#FFFFFF"><?php
	// Obtendo o Login
	   $Sis     = "S7";
	   $Rot     = "S7R3.3";
	   $lg_user = $_REQUEST['c_s'];
	      $user = substr($lg_user,0,8);
	      $pss  = substr($lg_user,8,40);
	   $dtatual = date('ymd');

	include "us_sist.php";
	if ($ch == 'no')
	  {
	   include "us_cad.php";
	  } ?>

     <table width="100%" border="0" cellspacing="0">
        <tr>
	  <td width="9%">
	     <a href="pgtos.php?c_s=<?php echo $lg_user ?>"><img src="./images/voltar.gif"></a>
	  </td>
	  <td width="82%" align="center">
	     <font color="gold" size="5"><b><center><u><i>RECOLHIMENTOS ANTERIOIRES</i></u></center></b></font>
	  </td>
	  <td width="9%" align="right">
	     <a href="pgtos.php?c_s=<?php echo $lg_user; ?>"><img src="./images/voltar.gif"></a>
	  </td>
	</tr>
     </table>

     <p><center><b><i>(Selecione o Recolhimento e Clique no Envelope Correspondente para Reimprimir)</i></b></center></p><?php

	if ($ch == 'ok-enc' or $ch == 'ok-cai' or $ch == 'ok')
	  { ?>
	   <table border="5" cellpadding="5" cellspacing="0" align="center">
	       <tr>
		  <td align="center">
		     <font color='aqua' size='4'><b><i>Nº do Envelope</i></b></font>
		  </td>
		  <td align="center">
		     <font color='aqua' size='4'><b><i>Depósito</i></b></font>
		  </td>
		  <td align="center">
		     <font color='aqua' size='4'><b><i>Recolhimento</i></b></font>
		  </td>
		  <td align="center">
		     <font color='aqua' size='4'><b><i>Recebedor</i></b></font>
		  </td>
		  <td align="center">
		     <font color='aqua' size='4'><b><i>Operador</i></b></font>
		  </td>
		</tr><?php

	      // Obtendo o Saldo de Caixa
		 include "dbselect.php";
		 $sql = "select * from depositos order by regdep desc";
		 $rs  = mysqli_query($conec, $sql) or die ("Não foi possível Consultar Dados do Caixa");
		 while ($ln  = mysqli_fetch_array($rs))
		      {
		       $RegDep   = $ln['regdep'];
		       $DtDep    = $ln['dtdep'];
			 $DtDepF = substr($DtDep,8,2)."/".substr($DtDep,5,2)."/".substr($DtDep,0,4);
		       $HrDep    = $ln['hrdep'];
		       $Envelope = $ln['envelope'];
		       $ValorDep = $ln['valor'];
		       $MatReceb = $ln['matreceb'];
			  $MatRecebF = substr($MatReceb,0,1).".".substr($MatReceb,1,3).".".substr($MatReceb,4,3)."-".substr($MatReceb,7,1);
		       $Operador = $ln['operador'];
			  $OperadorF = substr($Operador,0,1).".".substr($Operador,1,3).".".substr($Operador,4,3)."-".substr($Operador,7,1); ?>

		       <tr>
			  <td align="center">
			     <a href="reimpdep.php?c_s=<?php echo $lg_user.$RegDep; ?>">
			     <font color='yellow'><b><i><?php echo "$Envelope"; ?></i></b></font></a>
			  </td>
			  <td>
			     <b><i><?php echo "$DtDepF - $HrDep hs"; ?></i></b></font>
			  </td>
			  <td align="right">
			     <b><i><?php echo "R$ $ValorDep"; ?></i></b></font>
			  </td>
			  <td align="center">
			     <b><i><?php echo "$MatRecebF"; ?></i></b></font>
			  </td>
			  <td align="center">
			     <b><i><?php echo "$OperadorF"; ?></i></b></font>
			  </td>
			</tr><?php
		      } ?>
	   </table><br><?php
    } else { ?>
	    <br><br><br><br><br><font size='6'><b><center>Acesso <font color='gold'><blink><u>não Autorizado</u>
	    </blink><font color='#FFFFFF'>!!!</center></b></font><br><br><br>
	    <center><a href='pgtos.php?c_s=<?php echo $lg_user; ?>'><img src='images/voltar.gif'></a></center><br><br><?php
	   }

      // Encerrando as Conexões
	 $SisRot = "S-7.3.3";
	 include "rodape.php";
	 mysqli_close($conec); ?>

  </body>

</html>
