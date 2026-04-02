<html>

  <head>
    <title>WebCaixa v1.20.0_beta</title>
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
	 $Rot       = "S7R1.1.2";
	 $lg_user   = trim($_POST['txtuser']);
	   $user    = substr($lg_user,0,8);
	   $pss     = substr($lg_user,8,40);
	 $Reg       = trim($_POST['txtreg']);
	 $PC        = trim($_POST['txtpc']);
	 $Opt       = $_POST['rdopt'];
	 $NDoc      = trim($_POST['txtdoc']);
	 $dtAut     = trim($_POST['dtaut']);
	 $SlgPag    = trim($_POST['siglapag']);
	 $MatRec    = trim($_POST['txtmat']);
	 $VrEnt     = trim($_POST['txtvalor']);
	 $VrEntr    = number_format($VrEnt,2,',','');
	 $VrEntrF   = "R$ ".$VrEntr;

    // Imprimindo a Via do Caixa
       shell_exec("echo '$Reg$PC$NDoc$dtAut$VrEntrF$SlgPag$MatRec$Opt' > /dev/lp0");

    // Retornando ao Sistema ?>
       <meta http-equiv="refresh" content="0;URL=servrec.php?c_s=<?php echo $lg_user; ?>"><?php

    // Encerrando
       $SisRot = "S-7.1.1.2"; ?>

  </body>

</html>
