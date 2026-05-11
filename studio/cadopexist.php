<html>

  <head>
    <title>WebCaixa v1.20.4_beta</title>
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
	     $Rot     = "S7R6.1.1.1";
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
	 $Nome    = trim($_POST['txtnome']);
	 $Ape     = trim($_POST['txtape']);
	 $Func   =  trim($_POST['txtfuncao']);

      // Abrindo a Conexão
	 include "conexao.php";

      // Consultando a Senha do Funcionário
	 include "dblog.php";
	$sqlF  = "select pass from funcionarios where mat = '$Mat' ";
	$rsF   = mysqli_query($conec, $sqlF) or die("Erro de Atualização #0. Contate seu Administrador.");
	$lnF   = mysqli_fetch_array($rsF);
	  $Pass= $lnF['pass'];

      // Selecionando o Banco de Dados
	 include "dbselect.php";

     // Atualizando o Cadastro de Operadores
	$sqlA  = "select * from operador where mat = '$Mat' ";
	$rsA   = mysqli_query($conec, $sqlA) or die("Erro de Atualização #1. Contate seu Administrador.");
	$regsA = mysqli_num_rows($rsA);

	if ($regsA > 0)
	  {
	   $sqlA  = "delete from operador where mat = '$Mat' ";
	   $rsA   = mysqli_query($conec, $sqlA) or die("Erro de Atualização #2. Contate seu Administrador.");
	  }

     // Criando a Instrução SQL de Inclusão
	$sqlA = "INSERT INTO operador VALUES ('$Mat', '$Pass', '$Func', '$DataOp', '$HoraOp', '', '$user')";
	$rsA = mysqli_query($conec, $sqlA) or die("Erro de Atualização #3. Contate seu Adminsitrador."); ?><br><br><br><br>

     <font size="6"><center><b>Funcionário(a) <font color="gold"><blink>Cadastrado(a)</blink><font color="#FFFFFF"> com Sucesso!</b></center></font><br><br>

     <A HREF="index.php?c_s=<?php echo $lg_user; ?> "><center><img src="images/voltar.gif" border="0"></center></A><br><br><?php

     // Encerrando a Conexão
	mysqli_free_result($rsA);

     $SisRot = "S-7.6.1.1.1";
     include "rodape.php";
   ?>

    </body>

</html>
