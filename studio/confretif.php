<html>

  <head>
    <title>WebCaixa v1.19_beta</title>
    <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
	<style type="text/css">
	  body {
		margin-left: 5%;
		margin-right: 5%;
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

<SCRIPT LANGUAGE="JavaScript">
<!-- Begin
 function putFocus(formInst, elementInst) {
  if (document.forms.length > 0) {
   document.forms[formInst].elements[elementInst].focus();
  }
 }
//  End -->
</script>

	<?php
	  // Inserindo Cabeçalho
	     include "../cabecprs.php";
	?>
  </head>

  <body background="../images/bg1.jpg" text="#FFFFFF" onLoad="putFocus(0,0)">
    <?php
      // Importando os Dados do Formulário
	 $Sis    = "S7";
	 $Rot    = "S7R0.6.1";
	 $lg_user= trim($_POST['txtuser']);
	   $user = substr($lg_user,0,8);
	   $pss  = substr($lg_user,8,40);
	 $Autent = trim($_POST['txtaut']);
	 $Fita   = trim($_POST['txtfita']);
	 $Resp   = trim($_POST['txtresp']);
	   $RespF  = 100000000 + $Resp;
	   $Matric = substr($RespF,1,8);
	      $m1  = substr($Matric,0,1);
	      $m2  = substr($Matric,1,3);
	      $m3  = substr($Matric,4,3);
	      $dv  = substr($Matric,7,1);
	   $MatF   = "$m1.$m2.$m3-$dv";

	 $Valor  = trim($_POST['txtvalor']);
	 $ValorF = number_format($Valor,2,',','.');
	 $De     = trim($_POST['lsde']);
	 $Para   = trim($_POST['lspara']);
	 $Ano    = date('Y');

	 include "conexao.php";
	 include "dblog.php";
	 $sql = "select ape from pessoal where mat = '$Matric' ";
	 $rs  = mysqli_query($conec, $sql);
	 $ln  = mysqli_fetch_array($rs);
	   $Ape = $ln['ape'];

	 include "dbselect.php";

      // Obtendo Dados
	 $sql = "select * from formapag where codpag = '$FPag' ";
	 $rs  = mysqli_query($conec, $sql);
	 $ln  = mysqli_fetch_array($rs);
	   $ModPag = $ln['modpag'];
	 mysqli_free_result($rs); ?>

      <font color="gold" size="6">
      <b><center><u><i>Retificação de Lançamento</i></u></center></b></font><br><?php

      include "us_sist.php";
      if ($ch == 'no')
        {
	 include "us_cad.php";
        }

 if ($ch == 'ok-enc' or $ch == 'ok-cai' or $ch == 'ok')
   { ?>
    <table width="80%" border="5" cellpadding="9" cellspacing="0" align="center">
      <form name="confprod" method="post" action="geraretif.php">
	<tr>
	  <td width="45%" align="right">
	     <font color='gold' size='5'><b><i>Nº Autenticação</i></b></font>
	  </td>
	  <td width="55%">
	     <font color='#FFFFFF' size='5'><b><i><?php echo $Autent; ?></i></b></font>
	  </td>
	</tr>

	<tr>
	  <td width="45%" align="right">
	     <font color='gold' size='5'><b><i>Nº da Fita</i></b></font>
	  </td>
	  <td width="55%">
	     <font color='#FFFFFF' size='5'><b><i><?php echo "$Fita/$Ano"; ?></i></b></font>
	  </td>
	</tr>

	<tr>
	  <td width="45%" align="right">
	     <font color='gold' size='5'><b><i>Valor Registrado</i></b></font>
	  </td>
	  <td width="55%">
	     <font color='#FFFFFF' size='5'><b><i><?php echo "R$ $ValorF"; ?></i></b></font>
	  </td>
	</tr>

	<tr>
	  <td width="45%" align="right">
	     <font color='gold' size='5'><b><i>Responsável</i></b></font>
	  </td>
	  <td width="55%">
	     <font color='#FFFFFF' size='5'><b><i><?php echo "$MatF - $Ape"; ?></i></b></font>
	  </td>
	</tr>

	<tr>
	  <td width="45%" align="right">
	     <font color='gold' size='5'><b><i>Trocar a Forma de Pagamento</i></b></font>
	  </td>
	  <td width="55%"><?php
	     include "fpag.php"; ?>
	     <font color='#FFFFFF' size='5'><b><i><?php echo $Forma; ?></i></b></font>
	  </td>
	</tr>

	<tr>
	  <td width="45%" align="right">
	     <font color='gold' size='5'><b><i>Para a Forma de Pagamento</i></b></font>
	  </td>
	  <td width="55%"><?php
	     include "fpag.php"; ?>
	     <font color='#FFFFFF' size='5'><b><i><?php echo $Forma2; ?></i></b></font>
	  </td>
	</tr>
    </table>

	<input type="hidden" name="txtuser" value="<?php echo $lg_user; ?>">
	<input type="hidden" name="txtaut" value="<?php echo $Autent; ?>">
	<input type="hidden" name="txtFita" value="<?php echo $Fita; ?>">
	<input type="hidden" name="txtvalor" value="<?php echo $Valor; ?>">
	<input type="hidden" name="txtde" value="<?php echo $De; ?>">
	<input type="hidden" name="txtpara" value="<?php echo $Para; ?>">
	<input type="hidden" name="txtresp" value="<?php echo $MatF; ?>">
	<input type="hidden" name="txtape" value="<?php echo $Ape; ?>">
	<p><center><input type="submit" name="btenvia" value="Confirmar">
	<input type="button" name="btret" value="Retornar" OnClick="JavaScript:window.history.back()"></center></p>
    </form><?php
   } else { ?>
	   <br><br><br><br><br><font size='6'><b><center>Acesso <font color='gold'><blink><u>não Autorizado</u>
	   </blink><font color='#FFFFFF'>!!!</center></b></font><br><br><br>
	   <center><a href='servrec.php?c_s=<?php echo $lg_user; ?>'><img src='images/voltar.gif'></a></center><br><br><?php
	  }

    // Encerrando a Conexão
       $SisRot = "S-7.0.6.1";
       include "rodape.php"; ?>

  </body>

</html>
