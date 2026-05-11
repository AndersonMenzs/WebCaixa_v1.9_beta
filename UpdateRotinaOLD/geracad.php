<html>

  <head>
    <title>WebCaixa v1.20.3_beta</title>
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
	$SenhaP = substr($CPF, 0, 6);
	$pss    = sha1($SenhaP);
	$Cod    = trim($_POST['txtcod']);
	$Nome   = trim($_POST['txtnome']);
	$Ape    = substr($Nome, 0, 6);
	$MatAud = trim($_POST['lsAud']);
	$NCargo = trim($_POST['lsCargo']);

	if ($NCargo == '04')
	  {
	   $Cargo = 'Cai';
	  } else if ($NCargo == '05')
		   {
		    $Cargo = 'Enc';
		   } else {
			   $Cargo = 'Aud';
			  }
     // Salvando Dados
	include "conexao.php";
	include "dblog.php";

	$sql = "select cpf from pessoal where mat = '$user' and cpf = '$CPF' ";
	$rs  = mysqli_query($conec, $sql) or die ("File geracad.php Error #0. Contate seu Administrador.");
	$regs= mysqli_num_rows($rs);
	mysqli_free_result($rs);

	if ($regs == 0)
	  {
	   $sqlI = "insert into funcionarios values ('$user', '11111', '111', '$dtRest', '$dtRest', '2100-12-31', 'w', '1111', '111111', '$pss', '$NCargo', '1111', '10:00', '10:00', '10:00', '10:00', '1111','x', 'w', '$MatAud', 'U', 'https')";
	   $rsI  = mysqli_query($conec, $sqlI) or die ("File geracad.php Error #1. Contate seu Administrador.");
	   mysqli_free_result($rsI);

	   $sqlP = "INSERT INTO pessoal VALUES ('$user', '$Nome', '$Ape', 'pai', 'mae', '$dtRest', '111111', '$CPF', 'x@y.com', '2121212121', '2121212121', '200', 'w')";
	   $rsP  = mysqli_query($conec, $sqlP) or die ("File geracad.php Error #1A. Contate seu Administrador.");
	   mysqli_free_result($rsP);

	   include "dbselect.php";

	   $sqlD = "delete from operador where mat = '$user' ";
	   $rsD  = mysqli_query($conec, $sqlD) or die ("File geracad.php Error #2. Contate seu Administrador.");

	   $sqlO = "insert into operador values ('$user', '$pss', '$Cargo', '$dtRest', '$hrRest', '', '$MatAud')";
	   $rsO  = mysqli_query($conec, $sqlO) or die ("File geracad.php Error #3. Contate seu Administrador.");
	   mysqli_free_result($rsO);

	   $sqlR = "insert into restsenha values('$user', '$CPF', '$MatAud', '$dtRest', '$hrRest')";
	   $rsR  = mysqli_query($conec, $sqlR) or die ("File geracad.php Error #4. Contate seu Administrador.");
	   mysqli_free_result($rsR);
	  } else {
		  $sqlF = "update funcionarios set pass = '$pss' where mat = '$user' ";
		  $rsF  = mysqli_query($conec, $sqlF) or die ("File geracad.php Error #5. Contate seu Administrador.");
		  mysqli_free_result($rsF);

		  include "dbselect.php";

		  $sqlD = "delete from operador where mat = '$user' ";
		  $rsD  = mysqli_query($conec, $sqlD) or die ("File geracad.php Error #6. Contate seu Administrador.");
		  mysqli_free_result($rsD);

		  $sqlO = "insert into operador values ('$user', '$pss', '$Cargo', '$dtRest', '$hrRest', '', '$MatAud')";
		  $rsO  = mysqli_query($conec, $sqlO) or die ("File geracad.php Error #7. Contate seu Administrador.");
		  mysqli_free_result($rsO);

		  $sqlR = "insert into restsenha values('$user', '$CPF', '$MatAud', '$dtRest', '$hrRest')";
		  $rsR  = mysqli_query($conec, $sqlR) or die ("File geracad.php Error #8. Contate seu Administrador.");
		  mysqli_free_result($rsR);
		 } ?>

    <font color="gold" size="6">
    <br><b><center><u><i>RECUPERAÇÃO DE SENHA</i></u></center></b></font><br>

    <br><br><br><font size='7'><b><center>Sua Senha Provisória é <font color='gold'><?php echo substr($CPF,0,6); ?><font color='#FFFFFF'>!</center></b></font><br><br>
    <center><a href='index.php'><img src='images/Sair.gif'></a></center><br><?php
    // Encerrando
       $SisRot = "S-0.0.1";
       include "./rodape.php"; ?>
  </body>
</html>
