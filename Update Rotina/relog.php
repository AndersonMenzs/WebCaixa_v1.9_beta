<?php
// Debugando
  error_reporting(E_ALL & ~E_NOTICE);
  ini_set("display_errors", 1);
?>

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
	?>
  </head>

  <body background="./images/bg1.jpg" text="#FFFFFF"><?php

     // Importando os Dados do Formulário
	$Cod    = trim($_POST['txtcod']);
	$CntSen = trim($_POST['contrasenha']);

     // Preparando Áreas
	$SenhaOK = substr($Cod + 95300000, 0, 6);

     // Salvando Dados
	if ($CntSen == $SenhaOK)
	  {
	   include "conexao.php";
	   include "dbselect.php";

	   $sqlO = "UPDATE datafix SET horaf = 0, minf = 0;";
	   $rsO  = mysqli_query($conec, $sqlO) or die ("File index.php Error #1. Contate seu Administrador.");
	   
	   ?>

	   <font color="gold" size="6">
	   <br><b><center><u><i>CLIQUE NO BOTÃO SAIR &amp; ENTRE NOVAMENTE</i></u></center></b></font><br>
	   <center><a href='index.php'><img src='images/Sair.gif'></a></center><br><?php
	  } else { ?>
		  <font color="gold" size="6">
		  <br><b><center><u><i>CÓDIGO INCORRETO</i></u></center></b></font><br>
		  <center><a href='index.php'><img src='images/Sair.gif'></a></center><br><br><?php
		 }
    // Encerrando
       include "./rod_index.php"; ?>

  </body>

</html>
