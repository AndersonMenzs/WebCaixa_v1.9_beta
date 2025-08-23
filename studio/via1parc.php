<html>

  <head>
    <title>WebCaixa v1.19_beta</title>
    <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
	<style type="text/css">
	  body {
		margin-top: 5%;
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
	?>
  </head>

  <body background="../images/bg1.jpg" text="#FFFFFF">
    <?php
      // Importando os Dados do Formulário
	 $Sis       = "S7";
	 $Rot       = "S7R2.2.1.2";
	 $lg_user   = trim($_POST['txtuser']);
	   $user    = substr($lg_user,0,8);
	   $pss     = substr($lg_user,8,40); ?>
	 
    <font color="gold" size="6">
      <br><b><center><u><i>Sistema de Autenticação</i></u></center></b></font><?php

    // Criando a Spool de Impressão
       include "conexao.php";
       include "dbselect.php";

    // Imprimindo o Registro da Spool
       $SqlSp = "select * from spool order by rec";
       $rsSp  = mysqli_query ($conec, $SqlSp) or die ("Não foi possível obter dados da spool");
       $lnSp  = mysqli_fetch_array($rsSp);
	  $Num = $lnSp['rec'];
	  $Spo = $lnSp['spo'];

   // Autenticando a Via do Cliente
       shell_exec("echo '$Spo' > /dev/lp0");

    // Preparando do Caixa ?>
       <form name="via2parc" method="post" action="via2parc.php">
	   <input type="hidden" name="txtuser" value="<?php echo $lg_user; ?>">
	   <br>
	   <font size='6'><b><center>Coloque a <font color='gold'><blink>Via do Caixa</blink><font color='#FFFFFF'> na Autenticadora e<br>
	   <p>Clique no <font color='gold'><blink>no Botão Abaixo</blink><font color='#FFFFFF'>.</center></b></font></p><br>
	   <center><input id="ghost_click" type="submit" name="btimprime" value="Autenticar"></center><br>
	   <center><font color='#FFFFFF' size='3'><span id="msg"></span></font></center>
       </form><?php

    // Encerrando a Conexão
      //mysqli_free_result($rsSp);

       $SisRot = "S-7.2.2.1.2";
       include "./rodape.php"; ?>

	   <script src="./js/ghost_click.js"></script>

  </body>

</html>
