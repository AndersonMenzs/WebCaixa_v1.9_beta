<html>

  <head>
     <title>Alteração de Senha</title>
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
	</style>

	<?php
	  // Inserindo Cabeçalho
	     include "../cabecprs.php";
	?>
<script>
function F5(event) {
var tecla = document.all ? window.event.keyCode : event.which;
if (document.all) { window.event.keyCode = 0; window.event.returnValue = false; }
if (tecla == 116) return false;
}

document.onkeydown = F5;
</script>
  </head>

  <body background="../images/bg1.jpg" text="#FFFFFF">

    <?php
      // Recuperando Senhas
	 $Rot     = "S7R7.1";
	 $lg_user = $_POST['txtuser'];
	    $user = substr($lg_user,0,8);
	    $pss  = substr($lg_user,8,40);
	 $PssAnt  = strtolower($_POST['txtoldsen']);
	 $Pss1    = strtolower($_POST['txtnvsen']);
	 $Pss2    = strtolower($_POST['txtcfsen']);
	 $mfunc   = trim($_REQUEST['rp_mt']);
	 $ctPssAnt= sha1($PssAnt);
	 $ctPss   = sha1($Pss1);
	 $senhaValida = strlen($Pss1) == 6
		&& preg_match('/[a-z]/i', $Pss1)
		&& preg_match('/[0-9]/', $Pss1);

      // Verificando Integridade
	 if ($ctPssAnt <> $pss)
	   { ?>
	    <font color="#FFFFFF" size='5'><br><br>
	    <center><b><i>A Senha Anterior Informada <font color='gold'><blink>Não Confere</blink><font color='#FFFFFF'>.</i>
	    <br><br><br>Tente Novamente!</b></center></font><br>
	    <center><br><A HREF='JavaScript:window.history.back()'><img src='./images/voltar.gif'></A></center><br><br><?php
	   } else if ($senhaValida and $Pss1 == $Pss2)
		    {
		    // Abrindo a Conexão
		       include "conexao.php";

		   // Selecionando o Banco de Dados
		       include "dbselect.php";

		   // Consultando a Duplicidade de Senhas
		      $sqlCon = "SELECT pass FROM operador WHERE pass = '$ctPss' ";
		      $rsCon  = mysqli_query ($conec, $sqlCon) or die ("Erro de Alteração de Senha #1. Contate seu Administrador.");
		      $regsCon= mysqli_num_rows($rsCon);

		      if ($regsCon == 0)
			{
			 // Criando a Instrução SQL de atualização
			    $sqlALT = "UPDATE operador SET pass = '$ctPss', free = 'S' WHERE mat = '$mfunc' ";
			    $rsAltera = mysqli_query($conec, $sqlALT) or die("Erro de Alteração de Senha #2. Contate seu Administrador.");
			    //mysqli_free_result($rsAltera);

			    include "dblog.php";

			    $sqlUS = "UPDATE funcionarios SET pass = '$ctPss' WHERE mat = '$mfunc' ";
			    $rsUS  = mysqli_query($conec, $sqlUS) or die("Erro de Alteração de Senha #3. Contate seu Administrador.");
			    //mysqli_free_result($rsUS); ?>

			 <font color="#FFFFFF" size='6'><br><br>
			 <center><b><i>Senha Alterada <font color='gold'><blink>com Sucesso</blink><font color='#FFFFFF'>!<br><br>
			 Memorize sua nova senha ou anote em local seguro!!!</font></i></b></center><br>
			 <center><br><a href="../index.php"><img src="./images/Sair.gif"></A></center><br><?php
			} else { ?>
				<font color="gold" size='6'><br><br>
				<center><b><i><blink>Senha Não Aceita.</blink><font color='#FFFFFF'></i>
				   <br><br>Digite Uma Senha Diferente!</b></center></font><br>
				   <center><br><A HREF='JavaScript:window.history.back()'><img src='./images/voltar.gif'></A></center><br><?php
			       }
		   } else if ($Pss1 <> $Pss2) { ?>
			   <font color="gold" size='6'><br><br>
			   <center><b><i><blink>As Senhas Não Conferem.</blink><font color='#FFFFFF'></i>
			   <br><br>Tente Novamente!</b></center></font><br>
			   <center><br><A HREF='JavaScript:window.history.back()'><img src='./images/voltar.gif'></A></center><br><?php
			  } else { ?>
			   <font color="gold" size='6'><br><br>
			   <center><b><i><blink>Senha Não Aceita.</blink><font color='#FFFFFF'></i>
			   <br><br>A senha deve conter exatamente 6 caracteres, com letras e números.</b></center></font><br>
			   <center><br><A HREF='JavaScript:window.history.back()'><img src='./images/voltar.gif'></A></center><br><?php
			  }

   // Encerrando
      $SisRot = "S-7.7.1";
      include "rodape.php"; ?>

    </body>

</html>
