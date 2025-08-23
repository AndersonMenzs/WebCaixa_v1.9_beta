<html>
  <head>
    <title>WebCaixa v1.19_beta</title>
    <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
	<style type="text/css">
	  body {
		margin-top: 3%;
		margin-left: 3%;
		margin-right: 3%;
		border: 3px solid gray;
		padding: 10px 10px 10px 10px;
		font-family:sans-serif;
	       }
	  .campos {
	   background-color:#C0C0C0;
	   font: 16px sans-serif;
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
      // Inserindo o Cabeçalho
	 include "../cabecprs.php" ;
    ?>

  </head>

  <body background="../images/bg1.jpg" text="#FFFFFF" onLoad="putFocus(0,0)">

    <?php
     // Obtendo o Login
        $Sis     = "S7";
	$Rot     = "S7R5.0.0.1";
	$lg_user = trim($_POST['txtuser']);
	   $user = substr($lg_user,0,8);
	   $pss  = substr($lg_user,8,40);
	$lg_user = trim($_POST['txtuser']);
	$Codigo  = trim($_POST['txtcod']);
	$Respon  = trim($_POST['lsPr']);
	$ctrSen  = trim($_POST['txtctrsen']);

    // Verificando a ContraSenha
       $Soma     = 1000000 + $Codigo + $Respon;
       $Result   = substr($Soma,1,6);
	 $R0     = substr($Result,0,1);
	 $R1     = substr($Result,1,1);
	 $R2     = substr($Result,2,1);
	 $R3     = substr($Result,3,1);
	 $R4     = substr($Result,4,1);
	 $R5     = substr($Result,5,1);
       $CtrCorr	 = "$R5$R4$R3$R2$R1$R0";

       if ($CtrCorr == $ctrSen)
	 { ?>
	  <meta http-equiv="refresh" content="0;URL=fchparcsem.php?c_s=<?php echo $lg_user; ?>"><?php
	 } else { ?>
		 <br><br><font size='6'><b><center>Senha <font color='gold'><blink><u>Incorreta</u>
		    </blink><font color='#FFFFFF'>!!!</center></b></font>
		 <br><br><font size='6'><b><center>Clique em Retornar e Digite Novamente!!!</center></b></font><br><br>
	        <center><a href='JavaScript:window.history.back()'><img src='images/voltar.gif'></a></center><br><?php
		}
      $SisRot = "S-7.5.0.0.1";
      include "../rodape.php"; ?>

  </body>

</html>
