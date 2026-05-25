<html>
  <head>
    <title>WebCaixa v1.20.14_beta</title>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
	<style type="text/css">
	  body {
		margin-top: 2%;
		margin-left: 2%;
		margin-right: 2%;
		border: 3px solid gray;
		padding: 10px 10px 10px 10px;
		font-family:sans-serif;
	       }
	</style>
	
<script type="text/javascript" src="rem_taxas.js" charset="utf-8">
</script>

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

  <body background="../images/bg1.jpg" text="#FFFFFF" onLoad="putFocus(0,0)"><?php
    // Obtendo o Login
       $Sis     = "S7";
       $Rot     = "S7R8.2";
       $lg_user = $_REQUEST['c_s'];
	  $user = substr($lg_user,0,8);
	  $pss  = substr($lg_user,8,40);
       $dtHoje  = date('y-m-d');

       include "us_sist.php";
       if ($ch == 'no')
         {
	  include "us_cad.php";
         } ?>

       <font color="gold" size="6"><br><b><center><u><i>Desfazendo Rejustes</i></u></center></b></font><br><br><br><?php

       if ($ch == 'ok-enc' or $ch == 'ok')
	 {
	  // Obtendo Valores dos Serviços
	     include "conexao.php";
	     include "dbselect.php";

	     $sql  = "select * from taxas where datalt = '$dtHoje' ";
	     $rs   = mysqli_query($conec, $sql) or die ("Erro de Banco de Dados #1. Contate seu Administrador");
	     $regs = mysqli_num_rows($rs);

	     if ($regs == 0)
	       { ?>
		<br><br><font size='6'><b><center>Cancelamento de Reajuste <font color='gold'><blink><u>Negado</u></blink><font color='#FFFFFF'>!!!</center></b></font><br><br>
		<center><a href='vendback.php?c_s=<?php echo $lg_user; ?>'><img src='images/voltar.gif'></a></center><br><?php
	       } else { ?>
		       <table width="70%" border="5" cellpadding="10" cellspacing="0" align="center">
		       <form name="frmundo" method="post" action="rematual.php" OnSubmit="JavaScript:return checkdata()"><?php

		       while ($ln  = mysqli_fetch_array($rs))
			    {
			     $Datalt = $ln['datalt'];
				$dty = substr($Datalt,0,4);
				$dtm = substr($Datalt,5,2);
				$dtd = substr($Datalt,8,2);
			     $Data_Alt = "$dtd/$dtm/$dty";
			     $Codigo = $ln['codigo'];
			     $VrTaxa = $ln['vltx'];
			     $VrTxF  = number_format($VrTaxa,2,',','.'); ?>
			    <tr>
				<td align="center">
				   <font color='gold' size='4'><b><i>Data: <?php echo $Data_Alt; ?></i></b></font>
				</td>
				<td align="center">
				   <font color='gold' size='4'><b><i>Serviço: <?php echo $Codigo; ?></i></b></font>
				</td>
				<td align="center">
				   <font color='gold' size='4'><b><i>Valor Atual: <?php echo $VrTxF; ?></i></b></font>
				</td>
			    </tr><?php
			    } ?>
		       </table><br>

		       <input type='hidden' name='dtalt' value='<?php echo $Datalt; ?>'>
		       <input type='hidden' name='dtaltf' value='<?php echo $Data_Alt; ?>'>
		       <input type='hidden' name='txtuser' value='<?php echo $lg_user; ?>'>
		       <table width="100%" border="0" cellspacing="0">
			  <tr>
			     <td width="9%"><a href="vendback.php?c_s=<?php echo $lg_user ?>"><img src="./images/voltar.gif"></a></td>
			     <td width="82%" align="center">
				<input type="submit" name="btenviar" value="Continuar">&nbsp;&nbsp;
				<input type="reset" name="btreset" value="Limpar">
			     <td width="9%" align="right"><a href="vendback.php?c_s=<?php echo $lg_user; ?>"><img src="./images/voltar.gif"></a>
			     </td>
			  </tr>
		       </table>
		       </form><br><br><?php
		      }
	 } else { ?>
		 <br><br><br><br><br><font size='6'><b><center>Acesso <font color='gold'><blink><u>não Autorizado</u>
		 </blink><font color='#FFFFFF'>!!!</center></b></font><br><br><br>
		 <center><a href='vendback.php?c_s=<?php echo $lg_user; ?>'><img src='images/voltar.gif'></a></center><br><br><?php
		}

      // Encerrando as Conexões
	 $SisRot = "S-7.8.2";
	 include "rodape.php";
	 mysqli_close($conec); ?>

  </body>
</html>
