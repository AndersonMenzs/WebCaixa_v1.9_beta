<html>
  <head>
    <title>WebCaixa v1.20.20_beta</title>
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
       $Rot     = "S7R8.2.1";
       $lg_user = $_POST['txtuser'];
	  $user = substr($lg_user,0,8);
	  $pss  = substr($lg_user,8,40);
       $dtHoje  = date('y-m-d');
       $dtHojeF = date('d/m/Y'); ?>

       <font color="gold" size="6"><br><b><center><u><i>Desfazendo Rejustes</i></u></center></b></font><br><br><br><?php
       // Obtendo Valores dos Serviços
	  include "conexao.php";
	  include "dbselect.php";

	  $sql  = "delete from taxas where datalt = '$dtHoje' ";
	  $rs   = mysqli_query($conec, $sql) or die ("Erro de Banco de Dados #1. Contate seu Administrador"); ?>

	  <br><font size='6'><b><center>Reajustes Realizados em <?php echo $dtHojeF; ?><br><br>
	  <font color='gold'><blink><u>Cancelados com Sucesso</u></blink><font color='#FFFFFF'>!!!</center></b></font><br>
		<center><meta http-equiv="refresh" content="2;URL=vendback.php?c_s=<?php echo $lg_user; ?>"></center><br><?php

      // Encerrando as Conexões
	 $SisRot = "S-7.8.2.1";
	 include "rodape.php";
	 mysqli_close($conec); ?>

  </body>
</html>
