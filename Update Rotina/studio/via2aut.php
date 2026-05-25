<html>

  <head>
    <title>WebCaixa v1.20.12_beta</title>
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
	  .campos {
	   background-color:#C0C0C0;
	   font: 12px sans-serif;
	   color:#000000;
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
	 $Rot       = "S7R8.2.1.2";
	 $lg_user   = trim($_POST['txtuser']);
	   $user    = substr($lg_user,0,8);
	   $pss     = substr($lg_user,8,40);
	 $Reg       = trim($_POST['txtreg']);
	 $PC        = trim($_POST['txtpc']);
	 $horaaut   = trim($_POST['horaaut']);
	 $NDoc      = trim($_POST['txtdoc']);
	 $dtAut     = trim($_POST['dtaut']);
	 $VlVendaF  = $_POST['txtvendaf'];
	 $SgRec     = trim($_POST['siglarec']);
	 $MatRec    = trim($_POST['txtmat']);
	 $Ape       = trim($_POST['txtape']); ?>

    <font color="gold" size="6">
      <br><b><center><u><i>Sistema de Autenticação</i></u></center></b></font><?php

    // Imprimindo Ficha Cliente
       shell_exec("echo '$Reg$PC$horaaut$NDoc $dtAut$VlVendaF$SgRec$MatRec$Ape' > /dev/lp0"); ?>

    <br><center><meta http-equiv="refresh" content="0;URL=cadvend.php?c_s=<?php echo $lg_user ?>"></center><br><?php

    // Encerrando
       $SisRot = "S-7.8.2.1.2";
       include "rodape.php"; ?>

  </body>

</html>
