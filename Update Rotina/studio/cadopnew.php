<html>

  <head>
    <title>WebCaixa v1.20.10_beta</title>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
	<style type="text/css">
	  body {
		margin-top: 7%;
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
	     include "../cabecprs.php";

	  // Obtendo o Login
	     $Rot     = "S7R6.1.1.2";
	     $lg_user = $_POST['txtuser'];
		$user = substr($lg_user,0,8);
		$pss  = substr($lg_user,8,40);

	  // Preparando Áreas
	     $DataOp  = date ('Y-m-d');
	     $HoraOp  = date ('H:i');
	?>
  </head>

  <body background="../images/bg1.jpg" text="#FFFFFF">

    <?php
      // Importando os Dados do Formulário
	 $lg_user = trim($_POST['txtuser']);
	    $user = substr($lg_user,0,8);
	    $Pss  = substr($lg_user,8,40);
	 $Mat     = trim($_POST['txtmat']);
	 $CPF     = trim($_POST['txtcpf']);
	   $CPFrdz= substr($CPF,0,3).substr($CPF,4,3).substr($CPF,8,3).substr($CPF,12,2);
	 $PassLine= substr($CPF,0,3).substr($CPF,4,3);
	 $PassOp  = sha1("$PassLine");
	 $Nome    = trim($_POST['txtnome']);
	 $Ape     = trim($_POST['txtape']);
	 $Func   =  trim($_POST['txtfuncao']);

      // Abrindo a Conexão
	 include "conexao.php";

      // Selecionando o Banco de Dados
	 include "dblog.php";

     // Verificando Cadastramento Anterior
	$sql = "select cpf from pessoal where cpf = '$CPFrdz' ";
	$rs  = mysqli_query($conec, $sql) or die("Erro de Banco de Dados #1. Contate seu Administrador.");
	$regs= mysqli_num_rows($rs);

	if ($regs == 0)
	  {
	   // Criando a Instrução SQL de Inclusão
	      $sqlF = "INSERT INTO funcionarios VALUES ('$Mat', '11111', '111', '$DataOp', '$DataOp', '2100-12-31', 'w', '1111', '111111', '$PassOp','04', '1111', '10:00', '10:00', '10:00', '10:00', '1111','x', 'w', '$user','U', 'https')";
	      $rsF  = mysqli_query($conec, $sqlF) or die("Erro de Banco de Dados #2. Contate seu Administrador.");

	      $sqlP = "INSERT INTO pessoal VALUES ('$Mat', '$Nome', '$Ape', 'pai', 'mae', '$DataOp', '111111', '$CPFrdz', 'x@y.com', '2121212121', '2121212121', '200', 'w')";
	      $rsP  = mysqli_query($conec, $sqlP) or die("Erro de Banco de Dados #3. Contate seu Administrador.");

	   // Selecionando o Banco de Dados
	      include "dbselect.php";

	   // Criando a Instrução SQL de Inclusão
	      $sqlA = "INSERT INTO operador VALUES ('$Mat', '$PassOp', '$Func', '$DataOp', '$HoraOp', '', '$user')";
	      $rsA = mysqli_query($conec, $sqlA) or die("Erro de Atualização #4. Contate seu Administrador."); ?><br><br><br><br>

	   <font size="6"><center><b>Funcionário(a) <font color="gold"><blink>Cadastrado(a)</blink><font color="#FFFFFF"> com Sucesso!</b></center></font><br><br>

	   <A HREF="index.php?c_s=<?php echo $lg_user; ?> "><center><img src="images/voltar.gif" border="0"></center></A><br><br><?php

	   mysqli_free_result($rsF);
	   mysqli_free_result($rsP);
	   mysqli_free_result($rsA);
	  } else { ?>
		  <br><br><br><font size='6'><b><center>CPF <font color='gold'><blink>Já Cadastrado</blink><font color='#FFFFFF'> no Sistema!!!</center></b></font><br><br><br>
		  <center><a href='index.php?c_s=<?php echo $lg_user; ?>'><img src='images/voltar.gif'></a></center><br><br><?php
		 }

     // Encerrando a Conexão
	mysqli_free_result($rs);

     $SisRot = "S-7.6.1.1.2";
     include "rodape.php";
   ?>

    </body>

</html>
