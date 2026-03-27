<html>
  <head>
    <title>WebCaixa v1.20.0_beta</title>
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

  <body background="../images/bg1.jpg" text="#FFFFFF"><?php
     include "../cabecprs.php";

     // Obtendo o Login e Dados
       $Sis        = "S7";
	$Rot       = "S7R0.1.1";
	$lg_user   = $_POST['txtuser'];
	  $user    = substr($lg_user,0,8);
	     $mat1 = substr($user,0,1);
	     $mat2 = substr($user,1,3);
	     $mat3 = substr($user,4,3);
	     $dv   = substr($user,7,1);
	$userF     = "$mat1.$mat2.$mat3-$dv";
	  $pss     = substr($lg_user,8,40);
	$dtAltera  = date('Ymd');
	$NomeA     = trim($_POST['txtnome']);
	$PCA       = trim($_POST['txtpc']);
	$ApeA      = trim($_POST['txtape']);
	$CofreA    = trim($_POST['txtcofre']);
	$TrocoA    = trim($_POST['txttroco']);
	$GavA      = trim($_POST['txtgav']);
	$TotA      = $CofreA + $TrocoA + $GavA;

     include "us_sist.php";
     if ($ch == 'no')
       {
	include "us_cad.php";
       }

     include "dbselect.php";

     if ($ch == 'ok')
       {
	// Verificando o Arquivo Inicial
	   $sql = "select mat from inicial";
	   $rs  = mysqli_query($conec, $sql) or die ("Erro de Inclusão de Dados");
	   $reg = mysqli_num_rows($rs);

	if ($reg > 0)
	  {
	   // Removendo Dados Incorretos
	      $sqlG = "delete from inicial";
	      $rsG  = mysqli_query ($conec, $sqlG) or die ("Não Foi Possível Remover os Dados da Auditoria.");
	  }
	// Inserindo Novos Dados
	   $sqlG = "insert into inicial values('$user', $dtAltera, $CofreA, $TrocoA, $GavA, $TotA, '$PCA', '$ApeA')";
	   $rsG  = mysqli_query ($conec, $sqlG) or die ("Não foi possível salvar os dados da Auditoria.");

	// Atualizando o Caixa
	   $sqlA = "select numerario from caixa where dtopen = '$dtAltera' ";
	   $rsA  = mysqli_query ($conec, $sqlA) or die ("Não foi possível Consultar os Dados do Caixa.");
	   $regsA= mysqli_num_rows($rsA);

	if ($regsA <> 0)
	  {
	   $sqlA = "update caixa set numerario = $GavA where dtopen = $dtAltera";
	   $rsA  = mysqli_query ($conec, $sqlA) or die ("Não foi possível Atualizar os Dados do Caixa.");
	  } ?>

	<br><br><br><br><font size='6'><b><center>Dados <font color='gold'><blink><u>Gravados com Sucesso</u>
	</blink><font color='#FFFFFF'>!</center></b></font><br>
	<font size='6' color='#FFFFFF'><b><center>Seu Comprovante <font color='gold'><blink><u>Está Sendo Impresso</u>
	</blink><font color='#FFFFFF'>.</center></b></font><br><br><br>
	<center><a href='aud.php?c_s=<?php echo $lg_user; ?>'><img src='images/voltar.gif'></a></center><br><?php
       }
     mysqli_free_result($rsG);

     // Gerando Comprovante
	$dtAltI  = date('d/m/Y');
	$horaI   = date('H:i');
	$PCA       = trim($_POST['txtpc']);
	$ApeA      = trim($_POST['txtape']);
	$CofreI = number_format($CofreA,2,",",".");
	$TrocoI = number_format($TrocoA,2,",",".");
	$GavI = number_format($GavA,2,",",".");
	$TotI = number_format($TotA,2,",",".");

    // Imprimindo os Dados
       $traco = "------------------------------------------------";
       shell_exec("echo $traco > /dev/lp0");
       shell_exec("echo '* * * * * Estrella Photo Studio * * * * *' > /dev/lp0");
       shell_exec("echo $traco > /dev/lp0");
       shell_exec("echo '\n' > /dev/lp0");
       shell_exec("echo INCLUSAO / ALTERACAO DE VALORES PELA AUDITORIA > /dev/lp0");
       shell_exec("echo $traco > /dev/lp0");
       shell_exec("echo '\n' > /dev/lp0");
       shell_exec("echo '$dtAltI - $horaI - PC: $PCA ($ApeA)' > /dev/lp0");
       shell_exec("echo '\n' > /dev/lp0");
       shell_exec("echo $traco > /dev/lp0");
       shell_exec("echo '\n' > /dev/lp0");
       shell_exec("echo - - - - - - - - VALORES ATUAIS - - - - - - - > /dev/lp0");
       shell_exec("echo $traco > /dev/lp0");
       shell_exec("echo 'Cofre:. . . . . . . . . . . . R$ $CofreI'> /dev/lp0");
       shell_exec("echo 'Troco:. . . . . . . . . . . . R$ $TrocoI'> /dev/lp0");
       shell_exec("echo 'Gaveta: . . . . . . . . . . . R$ $GavI'> /dev/lp0");
       shell_exec("echo $traco > /dev/lp0");
       shell_exec("echo 'TOTAL:. . . . . . . . . . . . R$ $TotI'> /dev/lp0");
       shell_exec("echo $traco > /dev/lp0");
       shell_exec("echo '\n' > /dev/lp0");
       shell_exec("echo - - - - - - - - RESPONSAVEL - - - - - - - - > /dev/lp0");
       shell_exec("echo $traco > /dev/lp0");
       shell_exec("echo '$userF $NomeA' > /dev/lp0");
       shell_exec("echo '\n' > /dev/lp0");
       shell_exec("echo '\n' > /dev/lp0");
       shell_exec("echo Auditoria: ---------------------------------- > /dev/lp0");
       shell_exec("echo '\n' > /dev/lp0");
       shell_exec("echo '\n' > /dev/lp0");
       shell_exec("echo Caixa: -------------------------------------- > /dev/lp0");
       shell_exec("echo $traco > /dev/lp0");
       shell_exec("echo '\n' > /dev/lp0");
       shell_exec("echo '\n' > /dev/lp0");
       shell_exec("echo '\n' > /dev/lp0");
       shell_exec("echo '\n' > /dev/lp0");
       shell_exec("echo '\n' > /dev/lp0");
       shell_exec("echo '\n' > /dev/lp0");

   // Encerrando a Conexão
      $SisRot = "S-7.0.1.1";
      include "rodape.php"; ?>

    </body>

</html>
