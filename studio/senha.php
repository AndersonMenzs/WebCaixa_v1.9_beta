<html>
  <head>
    <title>alteração de Senha</title>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
	<style type="text/css">
	  body {
		margin-top: 5%;
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

<SCRIPT LANGUAGE="JavaScript">
<!-- Begin
 function putFocus(formInst, elementInst) {
  if (document.forms.length > 0) {
   document.forms[formInst].elements[elementInst].focus();
  }
 }
//  End -->
</script>

<script type="text/javascript" src="valsen.js" charset="utf-8">
</script>
	
	<?php
	  // Inserindo Cabeçalho
	     include "../cabecprs.php";
	?>

  </head>

  <body background="../images/bg1.jpg" text="#FFFFFF" onLoad="putFocus(0,1);">
    <?php
      // Recuperando Login
	 $Sis     = "S7";
	 $Rot     = "S7R7";
	 $lg_user = $_REQUEST['c_s'];
	    $user = substr($lg_user,0,8);
	    $pss  = substr($lg_user,8,40);

      // Conectando o Banco de Dados
	 include "conexao.php";

      // Selecionando o Banco de Dados Funcionarios
	 include "dblog.php";

      // Criando a Instrução SQL de Consulta
	 IF ($conec)
	    {
	     $sqlp = "SELECT nome  FROM pessoal where mat = '$user' ";
	    }

      // Consultando o Nome
	 $rsp = mysqli_query($conec, $sqlp) or die("Não foi possível consultar Pessoal");

     // Obtendo os Dados
	$lnp  = mysqli_fetch_array($rsp);
	      $Nome   = $lnp['nome'];

      // Selecionando o Banco de Dados
	 include "dbselect.php";

      // Criando a Instrução SQL de Consulta
	 IF ($conec)
	    {
	     $sqls = "SELECT *  FROM operador where mat = '$user' ";
	    }

      // Consultando os Registros
	 $rss = mysqli_query($conec, $sqls) or die("Não foi possível selecionar o arquivo");

     // Obtendo os Dados
	$lns  = mysqli_fetch_array($rss);
	      $Mat   = $lns['mat'];
		$matr= substr($Mat,0,7);
		$dv  = substr($Mat,7,1);

     // Verificando a Existência do Usuário
	if ($Mat == $user)
	  { ?>

	   <br><br><font color='gold' size='6'><b><u><i><center>ALTERAÇÃO DE SENHA</center></i></u></b></font><br>

	   <FORM NAME="senhalt" METHOD="POST" ACTION="altersenha.php?rp_mt=<?php echo $Mat; ?> "
	   OnSubmit="JavaScript:return checkdata()">

	   <table width="45%" border="1" cellpadding="5" cellspacing="0" align="center">
	      <tr>
		 <td colspan="2">
		    <font size='5' color='#FFFFFF'><center><b>Usuário: <?php echo $matr, '-', $dv; ?></b></center></font>
		 </td>
		    <input type="hidden" name="txtuser" value="<?php echo $lg_user; ?>">
	      </tr>

	      <tr>
		 <td colspan="2" align='center'>
		    <font size='4' color="gold"><b><i><?php echo $Nome; ?></i></b></font>
		 </td>
	      </tr>

	      <tr>
	         <td colspan="2" align='center'>
		    <font size='3' color="#FFFFFF"><i>Senha Atual:&nbsp;</i></font>
		    <input type="password" name="txtoldsen" size="6" maxlength="6" class="campos">
		 </td>
	      </tr>

	      <tr>
	         <td align='center'>
		    <font size='3'>Nova Senha: <input type="password" size="6" maxlength="6" name="txtnvsen" class="campos">&nbsp;</font>
		 </td>
	         <td align='center'>
		    <font size='3'>Repetir Senha: <input type="password" size = "6" maxlength="6" name="txtcfsen" class="campos">&nbsp;</font>
		 </td>
	      </tr>
	   </table><br>

	   <table width="100%" border="0" cellspacing="0">
	      <tr>
		 <td>&nbsp;</td>
	      </tr>

	      <tr>
		 <td width="16%" align="center">
		    <a href="../index.php?c_s=<?php echo $lg_user; ?>"><img src="./images/Sair.gif"></a>
		 </td>
		 <td width="68%" align="center">
		    <input type="submit" name="btenviar" value="Alterar Senha">&nbsp;&nbsp;&nbsp;
		    <input type="reset" name="btcancel" value="Limpar">
		 </td>
		 <td width="16%" align="center"><a href="../index.php?c_s=<?php echo $lg_user; ?>">
		    <img src="./images/Sair.gif"></a>
		 </td>
	      </tr>
	   </table> <br>

	   <center><font size='4'><b>É obrigatória a utilização de <font color ="gold">
	   <blink>Letras e Algarismos</blink><font color="#FFFFFF"> na nova senha.</b></center></font>

	   </FORM><?php

	   // Fechando as Conexões
	      mysqli_free_result($rsp);
	      mysqli_free_result($rss);
	  } else { ?>
		  <br><font size='6'><center><b>Usuário e/ou Senha <font color='gold'><blink>Incorretos</blink>
		  <font color='#FFFFFF'>.<br><br>
		  Alteração de Senha <font color='gold'><blink>Cancelada</blink><font color='#FFFFFF'>!!!</b>
		  <br><br><br>
		  <a href='JavaScript:window.history.back()'><img src='./images/voltar.gif'></a></center></font><br><?php
		 }

      $SisRot = "S-7.7";
      include "rodape.php"; ?>

  </body>

</html>
