<html>
  <head>
    <title>WebCaixa v1.19_beta</title>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
	<style type="text/css">
	  body {
		margin-top:3%;
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
  </head>

  <body background="../images/bg1.jpg" text="#FFFFFF">
    <?php
     include "../cabecprs.php";

     // Obtendo o Login e Dados
       $Sis        = "S7";
	$Rot       = "S7R0.7.1";
	$lg_user   = $_POST['txtuser'];
	  $user    = substr($lg_user,0,8);
	     $mat1 = substr($user,0,1);
	     $mat2 = substr($user,1,3);
	     $mat3 = substr($user,4,3);
	     $dv   = substr($user,7,1);
	$userF     = "$mat1.$mat2.$mat3-$dv";
	  $pss     = substr($lg_user,8,40);
	$dtOpen    = trim($_POST['txtopen']);
	$Numer     = trim($_POST['txtnumer']);
	$Difer     = trim($_POST['txtdifer']);
	$Oper      = trim($_POST['lsOp']);

     // Preparando Áreas
	$dtI    = date('d/m/Y');
	$hI     = date('H:i');

	if ($Oper == 'D')
	  {
	   $Numer  = $Numer - $Difer;
	  } else {
		  $Numer  = $Numer + $Difer;
		 }
	$NumerF = number_format($Numer,2,",",".");

	include "us_sist.php";
	if ($ch == 'no')
	  {
	   include "us_cad.php";
	  }

 if ($ch == 'ok')
   {
    // Obtendo o Nome da Auditora
       include "dblog.php";
       $sqlU = "select nome from pessoal where mat = '$user' ";
       $rsU  = mysqli_query ($conec, $sqlU) or die ("Não foi possível obter dados da Auditoria.");
       $lnU  = mysqli_fetch_array($rsU);
	 $NomeU = $lnU['nome'];

    // Formatando a Matrícula
       $m1 = substr($user,0,1);
       $m2 = substr($user,1,3);
       $m3 = substr($user,4,3);
       $dv = substr($user,7,1);
       $userF = "$m1.$m2.$m3-$dv";

    // Atualizando o Caixa
       include "dbselect.php";
       $sqlG = "update caixa set numerario = $Numer where dtopen = '$dtOpen' ";
       $rsG  = mysqli_query ($conec, $sqlG) or die ("Erro de Banco de Dados #1. Contate seu Administrador.");

       $sqlF = "insert into anormalend values ('$dtOpen', '$hI', $Numer, $Difer, '$Oper', '$user')";
       $rsF  = mysqli_query ($conec, $sqlF) or die ("Erro de Banco de Dados #2. Contate seu Administrador."); ?>

       <br><br><br><br><font size='6'><b><center>Saldo Inicial do Caixa Retificado Para <font color='gold'><i>R$ <?php echo $NumerF; ?></i><font color='#FFFFFF'> !</center></b></font><br>
       <center><a href='aud.php?c_s=<?php echo $lg_user; ?>'><img src='images/voltar.gif'></a></center><br><?php

       $traco = "------------------------------------------------";
       shell_exec("echo '\n' > /dev/lp0");
       shell_exec("echo '\n' > /dev/lp0");
       shell_exec("echo $traco > /dev/lp0");
       shell_exec("echo '      ATUALIZACAO DO SALDO INICIAL DO CAIXA'> /dev/lp0");
       shell_exec("echo '      -- POR TERMINO ANORMAL DO SISTEMA --'> /dev/lp0");
       shell_exec("echo '                    (1a. Via)'> /dev/lp0");
       shell_exec("echo '\n' > /dev/lp0");
       shell_exec("echo 'SALDO INICIAL DO CAIXA CORRIGIDO P/ R$ $NumerF'> /dev/lp0");
       shell_exec("echo '             EM: $dtI - $hI'> /dev/lp0");
       shell_exec("echo '\n' > /dev/lp0");
       shell_exec("echo '\n' > /dev/lp0");
       shell_exec("echo $traco > /dev/lp0");
       shell_exec("echo '$userF - $NomeU'> /dev/lp0");
       shell_exec("echo '                   (Auditora)'> /dev/lp0");
       shell_exec("echo '\n' > /dev/lp0");
       shell_exec("echo $traco > /dev/lp0");


       shell_exec("echo '      ATUALIZACAO DO SALDO INCIAL DO CAIXA'> /dev/lp0");
       shell_exec("echo '      -- POR TERMINO ANORMAL DO SISTEMA --'> /dev/lp0");
       shell_exec("echo '                    (2a. Via)'> /dev/lp0");
       shell_exec("echo '\n' > /dev/lp0");
       shell_exec("echo 'SALDO INICIAL DO CAIXA CORRIGIDO P/ R$ $NumerF'> /dev/lp0");
       shell_exec("echo '             EM: $dtI - $hI'> /dev/lp0");
       shell_exec("echo '\n' > /dev/lp0");
       shell_exec("echo '\n' > /dev/lp0");
       shell_exec("echo $traco > /dev/lp0");
       shell_exec("echo '$userF - $NomeU'> /dev/lp0");
       shell_exec("echo '                   (Auditora)'> /dev/lp0");
       shell_exec("echo '\n' > /dev/lp0");
       shell_exec("echo '\n' > /dev/lp0");
       shell_exec("echo '\n' > /dev/lp0");
       shell_exec("echo '\n' > /dev/lp0");
       shell_exec("echo '\n' > /dev/lp0");
       shell_exec("echo '\n' > /dev/lp0");
   }

   // Encerrando a Conexão
      mysqli_free_result($rsG);

      $SisRot = "S-7.0.7.1";
      include "rodape.php"; ?>

    </body>

</html>
