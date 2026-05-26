<html>
  <head>
    <title>WebCaixa v1.20.16_beta</title>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">

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
      // Importando os Dados do Formulário
	 $Sis       = "S7";
	 $Rot       = "S7R5.2.1.1.1";
 
    // Imprimindo Cabeçalho da Spool de Impressão
       shell_exec("echo '--- A U T E N T I C A C O E S - D O - D I A ---' >> /backups/fcx_$dtAbre.txt");
       shell_exec("echo '-----------------------------------------------' >> /backups/fcx_$dtAbre.txt");

    // Imprimindo a Spool de Impressão
       include "conexao.php";
       include "dbselect.php";

       $SqlSp = "select * from spool2 order by rec";
       $rsSp  = mysqli_query ($conec, $SqlSp) or die ("Não foi possível obter dados da spool");
       while ($lnSp  = mysqli_fetch_array($rsSp))
	    {
	     $Spo = $lnSp['spo2'];
	     shell_exec("echo '$Spo' >> /backups/fcx_$dtAbre.txt");
	    }

    // Encerrando a Conexão
       mysqli_free_result($rsSp);
       $SisRot = "S-7.5.2.1.1.1"; ?>

  </body>

</html>
