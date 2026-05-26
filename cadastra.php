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

	<SCRIPT LANGUAGE="JavaScript">
	<!-- Begin
	 function putFocus(formInst, elementInst) {
	  if (document.forms.length > 0) {
	   document.forms[formInst].elements[elementInst].focus();
	  }
	 }
//  End -->
</script>

	<Script>
	<!-- This script and many more are available free online at -->
	<!-- The JavaScript Source!! http://javascript.internet.com -->

	<!-- Begin
	function validate(field) {
	var valid = "0123456789"
	var ok = "yes";
	var temp;
	for (var i=0; i<field.value.length; i++) {
	temp = "" + field.value.substring(i, i+1);
	if (valid.indexOf(temp) == "-1") ok = "no";
	}
	if (ok == "no") {
	alert("Entrada Incorreta! \n  Digite apenas algarismos!");
	field.value='';
	field.focus();
	field.select();
	   }
	}
	//  End -->
	</script>

	<script type="text/javascript" src="val_cemerg.js" charset="utf-8">
	</script><?php

      // Inserindo o Cabeçalho
	 include "./cabecprs.php" ; ?>
  </head>

  <body background="./images/bg1.jpg" text="#FFFFFF" onLoad="putFocus(0,0)"><?php

     // Preparando Áreas
        $Sis   = "S7";
	$Rot   = "S0R0";
	$DataC = date('dmY');
	$HoraC = date('hiih');
	$CodeC = $DataC + $HoraC; ?>

    <font color="gold" size="6"><br><b><center><u><i>CADASTRAMENTO DE FUNCIONÁRIOS</i></u></center></b></font><br><br><br>

    <table border="5" cellpadding="10" cellspacing="0" align="center">
     <form name="cademerg" method="post" action="geracad.php" onSubmit="JavaScript:return cadem()">
	<tr>
	  <td align="center">
	     <font color='gold' size='5'><b><i>Matrícula</i></b></font>
	  </td>
	  <td align="center">
	     <font color='gold' size='5'><b><i>CPF</i></b></font>
	  </td>
	  <td colspan="2" align="center">
	     <font color='gold' size='5'><b><i>Nome Completo</i></b></font>
	  </td>
	</tr>

	<tr>
	  <td align="center">
	     <input type="text" name="txtuser" size="8" maxlength="8" class="campos" onkeyup="validate(this)">
	  </td>
	  <td align="center">
	     <input type="text" name="txtcpf" size="11" maxlength="11" class="campos" onkeypress="fPassaAlfaNumerico('an')" onkeyup="validate(this)">
	  </td>
	  <td colspan="2" align="center">
	     <input type="text" name="txtnome" size="40" maxlength="45" class="campos" onkeyup="this.value=this.value.toUpperCase()">
	  </td>
	</tr>

	<tr>
	  <td align="center">
	     <font color='gold' size='5'><b><i>Cargo</i></b></font>
	  </td>
	  <td align="center">
	     <font color='gold' size='5'><b><i>Código</i></b></font>
	  </td>
	  <td align="center">
	     <font color='gold' size='5'><b><i>Autorizado Por</i></b></font>
	  </td>
	  <td align="center">
	     <font color='gold' size='5'><b><i>Contra-Senha</i></b></font>
	  </td>
	</tr>

	<tr>
          <td align="center">
	     <select name="lsCargo" class="campos">
	      <?php
		// Obtendo a Relação
		   // Conectando ao Banco de Dados
		      include "conexao.php";
		      include "dblog.php";

		   // Criando a Instrução SQL de Consulta
		      $sql = "select * from cargos where ccargo = '00' or ccargo = '04' or ccargo = '05' or ccargo = '08' ";

		   // Consultando os Registros
		      $rs = mysqli_query($conec, $sql) or die("Erro de Banco de Dados #0. Contate seu Administrador.");

		   // Criando o Array para o campo Autorização
		      while ($ln = mysqli_fetch_array($rs))
		 	   {
			    $NCrg  = $ln['ccargo'];
			    $Carg  = $ln['ncargo'];

			    if ($NCrg == '04')
			      {
			       $Carg = "Caixa";
			      } else if ($NCrg == '05')
				       {
					$Carg = "Encarregada";
				       } else if ($NCrg == '08')
						{
						 $Carg = "Auditora";
						} ?>
			    <option value="<?php echo $NCrg; ?>" class="campos"><?php echo "$Carg"; ?></option><?php
			   }
		mysqli_free_result($rs);
	      ?>
	     </select>
	  </td>
	  </td>
	  <td align="center">
	     <font color='gold' size='5'><b><i><?php echo $CodeC; ?></i></b></font>
	     <input type="hidden" name="txtcod" value="<?php echo $CodeC; ?>">
	  </td>
          <td align="center">
	     <select name="lsAud" class="campos">
	      <?php
		// Obtendo a Relação
		   // Criando a Instrução SQL de Consulta
		      $sql = "select pessoal.mat, pessoal.ape from pessoal inner join funcionarios on pessoal.mat = funcionarios.mat where (funcionarios.funcao = '08' or funcionarios.mat='00000359') and funcionarios.dtdemiss = '0000-00-00' ";

		   // Consultando os Registros
		      $rs = mysqli_query($conec, $sql) or die("Erro de Banco de Dados #1. Contate seu Administrador.");

		   // Criando o Array para o campo Autorização
		      while ($ln = mysqli_fetch_array($rs))
		 	   {
			    $NCrg  = $ln['mat'];
			    $Carg  = $ln['ape']; ?>
			    <option value="<?php echo $NCrg; ?>" class="campos"><?php echo "$Carg"; ?></option><?php
			   }
		mysqli_free_result($rs);
	      ?>
	     </select>
	  </td>
	  <td align="center">
	     <input type="text" name="contrasenha" size="6" maxlength="6" class="campos" OnKeyUp="validate(this)">
	  </td>
	</tr>
     </table><br>

     <table width="100%" border="0" cellspacing="0">
       <tr>
	  <td width="9%"><a href="index.php"><img src="./images/Sair.gif"></a></td>
	  <td width="82%" align="center">
	    <input type="submit" name="btenviar" value="Continuar">&nbsp;&nbsp;
	    <input type="reset" name="btreset" value="Limpar">
	  <td width="9%" align="right"><a href="index.php"><img src="./images/Sair.gif"></a>
	  </td>
	</tr>
     </table>
     </form><?php

     // Encerrando as Conexões
	$SisRot = "S-0.0";
	include "./rodape.php";
	mysqli_close($conec); ?>

  </body>

</html>
