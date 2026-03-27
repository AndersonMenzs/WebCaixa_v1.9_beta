<html>
  <head>
    <title>WebCaixa v1.20.0_beta</title>
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
	 include "../cabecprs.php";
	 $HoraAtual = date('His');
    ?>
  </head>

  <body background="../images/bg1.jpg" text="#FFFFFF"><?php
    // Obtendo o Login
       $Sis      = "S7";
       $Rot      = "S7R8.1.1";
       $lg_user  = $_POST['txtuser'];
	  $user  = substr($lg_user,0,8);
	  $pss   = substr($lg_user,8,40);

       $DataProd = $_POST['txtdtprod'];
	 $Prodd  = substr($DataProd,0,2);
	 $Prodm  = substr($DataProd,3,2);
	 $Prody  = substr($DataProd,6,4);
       $DtProdGr = "$Prody-$Prodm-$Prodd";

       $Prod     = $_POST['txtprod'];
       $ValProd  = $_POST['txtvrprod'];
       $ValProdN = trim($_POST['txtvrprodn']);

       $DataConc = $_POST['txtdtconc'];
	 $Concd  = substr($DataConc,0,2);
	 $Concm  = substr($DataConc,3,2);
	 $Concy  = substr($DataConc,6,4);
       $DtConcGr = "$Concy-$Concm-$Concd";

       $Conc     = $_POST['txtconc'];
       $ValConc  = $_POST['txtvrconc'];
       $ValConcN = trim($_POST['txtvrconcn']);

       $DataChav = $_POST['txtdtchav'];
	 $Chavd  = substr($DataChav,0,2);
	 $Chavm  = substr($DataChav,3,2);
	 $Chavy  = substr($DataChav,6,4);
       $DtChavGr = "$Chavy-$Chavm-$Chavd";

       $Chav     = $_POST['txtchav'];
       $ValChav  = $_POST['txtvrchav'];
       $ValChavN = trim($_POST['txtvrchavn']);

       $DataBebe = $_POST['txtdtbebe'];
	 $Bebed  = substr($DataBebe,0,2);
	 $Bebem  = substr($DataBebe,3,2);
	 $Bebey  = substr($DataBebe,6,4);
       $DtBebeGr = "$Bebey-$Bebem-$Bebed";

       $Bebe     = $_POST['txtbebe'];
       $ValBebe  = $_POST['txtvrbebe'];
       $ValBebeN = trim($_POST['txtvrbeben']);

       include "conexao.php";
       include "dbselect.php";

       if ($ValProd == $ValProdN or $ValConc == $ValConcN or $ValChav == $ValChavN)
         { ?>
	  <br><br><br><br><br><font size='6'><b><center>Valores  <font color='gold'><blink><u>Incorretos</u>
	  </blink><font color='#FFFFFF'>!!!</center></b></font><br><br><br>
	  <center><a href='JavaScript:window.history.back()'><img src='images/voltar.gif'></a></center><br><br><?php
	 } else {
		 if ($ValProdN > 0 and $ValProd <> $ValProdN)
		   {
		    $sql = "insert into taxas values('$DtProdGr',  'TXP', $ValProdN, '$user')";
		    $rs  = mysqli_query($conec, $sql) or die ("Erro de Sistema #2. Contate seu Administrador"); ?>
		    <br><br><font size='6'><b><center>Taxa de Produção <font color='gold'><blink><u>Atualizada com Sucesso</u></blink><font color='#FFFFFF'>!!!</center></b></font><br><?php
		   }

		 if ($ValConcN > 0 and $ValConc <> $ValConcN)
		   {
		    $sql = "insert into taxas values('$DtConcGr',  'TXC', $ValConcN, '$user')";
		    $rs  = mysqli_query($conec, $sql) or die ("Erro de Sistema #3. Contate seu Administrador");  ?>
		    <br><font color='#FFFFFF' size='6'><b><center> Taxa de Incrição no Concurso<font color='gold'><blink><u>Atualizada com Sucesso</u></blink><font color='#FFFFFF'>!!!</center></b></font><br><?php
		   }

		 if ($ValChavN > 0 and $ValChav <> $ValChavN)
		   {
		    $sql = "insert into taxas values('$DtChavGr',  'CHV', $ValChavN, '$user')";
		    $rs  = mysqli_query($conec, $sql) or die ("Erro de Sistema #2A. Contate seu Administrador"); ?>
		    <br><font size='6' color='#FFFFFF'><b><center>Chaveiro <font color='gold'><blink><u>Atualizado com Sucesso</u></blink><font color='#FFFFFF'>!!!</center></b></font><br><?php
		   } ?>
		 <meta http-equiv="refresh" content="2;vendback.php?c_s=<?php echo $lg_user; ?>"><?php

		 if ($ValBebeN > 0 and $ValBebe <> $ValBebeN)
		   {
		    $sql = "insert into taxas values('$DtBebeGr',  'BEB', $ValBebeN, '$user')";
		    $rs  = mysqli_query($conec, $sql) or die ("Erro de Sistema #2B. Contate seu Administrador"); ?>
		    <br><font size='6' color='#FFFFFF'><b><center>Bebê Estrella <font color='gold'><blink><u>Atualizado com Sucesso</u></blink><font color='#FFFFFF'>!!!</center></b></font><br><?php
		   } ?>
		 <meta http-equiv="refresh" content="2;vendback.php?c_s=<?php echo $lg_user; ?>"><?php
		}

      // Encerrando as Conexões
	 $SisRot = "S-7.8.1.1";
	 include "rodape.php";
	 mysqli_close($conec); ?>

  </body>

</html>
