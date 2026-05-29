<html>

  <head>
    <title>WebCaixa v1.20.20_beta</title>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
	<style type="text/css">
	  body {
		margin-top: 3%;
		margin-left: 5%;
		margin-right: 5%;
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
	  // Inserindo Cabeçalho
	     include "./cabecprs.php";

	  // Preparando Áreas
	     $dtRest = date('Y-m-d');
	     $hrRest = date('H:i');
	?>
  </head>

  <body background="./images/bg1.jpg" text="#FFFFFF"><?php

     // Importando os Dados do Formulário
	$Sis    = "S7";
	$Rot    = "S0R0.1";
	$user   = substr(100000000 + $_POST['txtuser'], 1, 8);
	$CPF    = trim($_POST['txtcpf']);
	$SenhaP = substr($CPF, 0, 5);
	$pss    = sha1($SenhaP);
	$Cod    = trim($_POST['txtcod']);
	$MatAud = trim($_POST['lsAud']);

     // Salvando Dados
	include "conexao.php";
	include "dblog.php";

	$sql = "select cpf from pessoal where mat = '$user' and cpf = '$CPF' ";
	$rs  = mysqli_query($conec, $sql) or die ("Erro de Banco de Dados #0. Contate seu Administrador.");
	$regs= mysqli_num_rows($rs);
	mysqli_free_result($rs);

	if ($regs > 0)
	  {
		
	   $sqlF = "update funcionarios set pass = '$pss' where mat = '$user' ";
	   $rsF  = mysqli_query($conec, $sqlF) or die ("Erro de Banco de Dados #1. Contate seu Administrador.");
	   //mysqli_free_result($rsF);
	   
	   include "dbselect.php";

	   $sqlO = "update operador set pass = '$pss' where mat = '$user' ";
	   $rsO  = mysqli_query($conec, $sqlO) or die ("Erro de Banco de Dados #2. Contate seu Administrador.");
	   //mysqli_free_result($rsO);

	   $sqlR = "insert into restsenha values('$user', '$CPF', '$MatAud', '$dtRest', '$hrRest')";
	   $rsR  = mysqli_query($conec, $sqlR) or die ("Erro de Banco de Dados #3. Contate seu Administrador.");
	   //mysqli_free_result($rsR); ?>

	   <font color="gold" size="6">
	   <br><b><center><u><i>RECUPERAÇÃO DE SENHA</i></u></center></b></font><br>

	   <br><br><br><font size='7'><b><center>Sua Senha Provisória é <font color='gold'><?php echo substr($CPF,0,5); ?><font color='#FFFFFF'>!</center></b></font><br><br>
	   <center><a href='index.php'><img src='images/Sair.gif'></a></center><br><?php
	  } else { ?>
		  <font color="gold" size="6">
		  <br><b><center><u><i>RECUPERAÇÃO DE SENHA</i></u></center></b></font><br>

		  <br><br><font size='6'><b><center>Usuário Inexistente<br><br>
		  ou<br><br>
		  Não Cadastrado no Sistema!</center></b></font><br><br>
		  <center><a href='index.php'><img src='images/Sair.gif'></a></center><br><br><?php
		 }
    // Encerrando
       $SisRot = "S-0.0.1";
       include "./rodape.php"; ?>

  </body>

</html>
