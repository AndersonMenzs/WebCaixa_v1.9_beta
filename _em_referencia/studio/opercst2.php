<html>
  <head>
    <title>WebCaixa v1.20.0_beta</title>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
	<style type="text/css">
	  body {
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

  </head>

  <body background="../images/bg1.jpg" text="#FFFFFF" onLoad="putFocus(0,0)">
    <?php
     include "../cabecprs.php";

     // Obtendo o Login
        $Sis     = "S7";
	$Rot     = "S7R6.4";
	$lg_user = $_REQUEST['c_s'];
	  $user  = substr($lg_user,0,8);
	  $pss   = substr($lg_user,8,40);

     include "us_sist.php";

     if ($ch == 'no')
       {
	include "us_cad.php";
       }

     if ($ch == 'ok' or $ch == 'ok-enc')
       {
	include "dblog.php";
	$sqlP = "select pessoal.mat, pessoal.nome, pessoal.cpf, funcionarios.funcao from pessoal inner join funcionarios on pessoal.mat = funcionarios.mat order by nome";
	$rsP  = mysqli_query($conec, $sqlP) or die ("Não foi Possível Consultar o Cadastro");	   ?><br><br>

	<table width="100%" border="0" cellpadding="0" cellspacing="0" align="center">
	    <tr>
	       <td width=15% align='center'>
		  <a href='index.php?c_s=<?php echo $lg_user; ?>'><img src='./images/voltar.gif' border='0'></a>
	       </td>
	       <td width=70% align='center'>
		  <font color='gold' size='5'><b><u><i>Consultar Matrícula &amp; CPF</i></u></b></font>
	       </td>
	       <td width=15% align='center'>
		  <a href='index.php?c_s=<?php echo $lg_user; ?>'><img src='./images/voltar.gif' border='0'></a>
	       </td>
	    </tr>
	</table>

        <center><b><i>(Para rolar a tela utilize as teclas <font color='lime'><blink>&quot;PageUp&quot; - &quot;PageDown&quot; - &quot;Setas&quot;<font color='#FFFFFF'></blink>)</font></i></b></center><br><br><br>

	<table border="1" cellpadding="0" cellspacing="0" align="center">
	    <tr>
	       <td width=12% align='center'>
		  <font color='gold' size='4'><b><i>Matrícula</i></b><font>
	       </td>
	       <td width=48% align='center'>
		   <font color='gold' size='4'><b><i>Funcionário</i></b><font>
	       </td>
	       <td width=28% align='center'>
		  <font color='gold' size='4'><b><i>Funcão</i></b><font>
	       </td>
	       <td width=12% align='center'>
		  <font color='gold' size='4'><b><i>CPF</i></b><font>
	       </td>
	    </tr><?php

	    while ($lnP  = mysqli_fetch_array($rsP))
		 {
		  $Mat  = $lnP['mat'];
		    $m1 = substr($Mat,0,1);
		    $m2 = substr($Mat,1,3);
		    $m3 = substr($Mat,4,3);
		    $dv = substr($Mat,7,1);
		       $MatF  = "$m1.$m2.$m3-$dv";
		    $Nome  = $lnP['nome'];
		    $CPF   = $lnP['cpf'];
		       $c1 = substr($CPF,0,3);
		       $c2 = substr($CPF,3,3);
		       $c3 = substr($CPF,6,3);
		       $c4 = substr($CPF,9,2);
		    $CPFF  = "$c1.$c2.$c3-$c4";
		    $Funcao= $lnP['funcao']; ?>
		  <tr>
		     <td width=12%>
			<font color='lime'><b><i>&nbsp;<?php echo $MatF; ?></i></b><font>
		     </td>
		     <td width=48%>
			<font color='#FFFFFF'><b><i>&nbsp;<?php echo $Nome; ?></i></b><font>
		     </td>
		     <td width=28%><?php
			$sqlF = "select ncargo from cargos where ccargo = '$Funcao' ";
			$rsF  = mysqli_query($conec, $sqlF) or die ("Não foi Possível Consultar o Cargos");
			$lnF  = mysqli_fetch_array($rsF);
			  $FName = $lnF['ncargo']; ?>

			<font color='#FFFFFF'><b><i>&nbsp;<?php echo $FName; ?></i></b><font>
		     </td>
		     <td width=12% align='right'>
			<font color='yellow'><b><i><?php echo $CPFF; ?>&nbsp;</i></b><font>
		     </td>
		  </tr><?php
		 }

	     mysqli_free_result($rsP); ?>
	  </table><br><br>

	  <center><a href='index.php?c_s=<?php echo $lg_user; ?>'><img src='./images/voltar.gif' border='0'></a></center><?php
	} else { ?>
		<br><br><br><font size='5'><b><center>Acesso <font color='gold'><blink><u>não Autorizado</u>
		</blink><font color='#FFFFFF'>!!!</center></b></font><br><br><br>
		<center><a href='operador.php?c_s=<?php echo $lg_user; ?>'><img src='images/voltar.gif'></a></center><br><br><?php
	       } ?>
    <meta http-equiv="refresh" content="60;URL=./index.php?c_s=<?php echo $lg_user; ?>"><?php

    // Encerrando
       $SisRot = "S-7.6.4";
       include "rodape.php"; ?>

    </body>
</html>
